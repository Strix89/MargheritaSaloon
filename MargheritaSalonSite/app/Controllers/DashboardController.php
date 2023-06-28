<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;
use App\Models\VisitModel;
use App\Models\AnnounceModel;
use App\Models\TreatmentModel;
use App\Models\ProductModel;
use App\Models\WorksModel;
use CodeIgniter\Files\File;


class DashboardController extends BaseController
{
    public function index(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        }
        $visitor = new VisitModel();
        $user = new UserModel();
        return view("/layouts/dashboard", ['title' => "Dashboard", "visitors" => $visitor->count_visitors(), "logged_users" => $user->getAllLogged()]);
    }

    public function resetPsw(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        }
        return view("/layouts/resetPsw", ['title' => "Reset Password"]);
    }

    public function do_resetPsw(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);

        $user = new UserModel();

        $rules = [
            'oldpsw' => 'required|min_length[6]|max_length[20]',
            'newpsw' => 'required|min_length[6]|max_length[20]',
            'newrespsw' => 'required|min_length[6]|max_length[20]'
        ];

        if($this->validate($rules)){
            $oldpsw = $this->request->getPost('oldpsw');
            $newpsw = $this->request->getPost('newpsw');
            $newrespsw = $this->request->getPost('newrespsw');

            $result = $user->where('Telefono', $this->session->get("user")["Telefono"])->first();

            if(password_verify($oldpsw, $result['PSW'])){
                if($newpsw == $newrespsw && $newpsw != $oldpsw){
                    $user->update($this->session->get("user")["Telefono"], ['PSW' => password_hash($newpsw, PASSWORD_BCRYPT)]);
                    $this->session->set("user", $user->where('Telefono', $this->session->get("user")["Telefono"])->first());
                    return view("/layouts/resetPsw", ['title' => "Reset Password", 'success' => "Password modificata con successo!"]);
                } else {
                    return view("/layouts/resetPsw", ['title' => "Reset Password", 'error' => "Le nuove password non coincidono!<br>Oppure la nuova password inserita è uguale a quella vecchia!"]);
                }
            } else {
                return view("/layouts/resetPsw", ['title' => "Reset Password", 'error' => "Vecchia password errata!"]);
            }
        } else {
            return view("/layouts/resetPsw", ['title' => "Reset Password", 'error' => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function logout(){
        $user = new UserModel();
        $user->setLogout($this->session->get("user")["Telefono"]);
        $this->session->remove("user");
        return redirect()->to('/');
    }

    public function insertAnnounce(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $announce = new AnnounceModel();
        $result = $announce->get_Annunci(14);
        if ($result === null) {
            return view("/layouts/AddAnnou", ['title' => "Inserisci Annuncio", "error" => "Non ci sono annunci da mostrare!"]);
        }
        return view("/layouts/AddAnnou", ['title' => "Inserisci Annuncio", "result" => $result]);
    }

    public function do_insertAnnounce(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);
        $announce = new AnnounceModel();
        $rules = [
            'annuncio' => 'required|min_length[10]|max_length[1000]'
        ];
        if($this->validate($rules)){
            $announce->insert_annuncio(date("Y-m-d"), date("H:i:s"), $this->session->get("user")["Telefono"], $this->request->getPost('annuncio'));
            return view("/layouts/AddAnnou", ['title' => "Inserisci Annuncio", 'success' => "Annuncio inserito con successo!"]);
        } else {
            return view("/layouts/AddAnnou", ['title' => "Inserisci Annuncio", 'error' => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function getAnnouncements(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $announce = new AnnounceModel();
        $result = $announce->get_Annunci(14);
        if ($result === null || $result === 0) {
            return view("/layouts/getAnnou", ['title' => "Annunci", 'error' => "Non ci sono annunci da mostrare!"]);
        }
        return view("/layouts/getAnnou", ['title' => "Annunci", 'result' => $result]);
    }

    public function getTreatements(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $trattamenti = new TreatmentModel();
        $result = $trattamenti->getTreatments();
        if ($result === null) {
            return view("/layouts/treatments", ['title' => "Trattamenti", 'error' => "Non ci sono trattamenti da mostrare!"]);
        }
        return view("/layouts/treatments", ['title' => "Trattamenti", 'result' => $result]);
    }

    public function do_insertTreatment(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);
        $trattamenti = new TreatmentModel();
        $rules = [
            'titolo' => 'required|min_length[3]|max_length[25]',
            'descrizione' => 'required|min_length[5]|max_length[1000]',
            'prezzo' => 'required|numeric',
            'surplus' => 'required|numeric',
            'durata' => 'required|numeric'
        ];
        if($this->validate($rules)){
            $data = [
                'Titolo' => $this->request->getPost("titolo"), 
                'Durata' => $this->request->getPost("durata"),
                'Prezzo' => $this->request->getPost("prezzo"), 
                'Surplus' => $this->request->getPost("surplus"), 
                'Descrizione' => $this->request->getPost("descrizione"), 
                'Telefono' => $this->session->get("user")["Telefono"]
            ];
            $result = $trattamenti->insert($data);
            if($result == false){
                return view("/layouts/treatments", ['title' => "Inserisci Trattamento", 'error' => "Errore nell'inserimento del trattamento!"]);
            }
            return redirect()->to(site_url('/treatments'));
        } else {
            return view("/layouts/treatments", ['title' => "Inserisci Trattamento", 'error' => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function rmTreatment($id){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        } else if(!isset($id)) {
            return redirect()->to(site_url('/treatments'));
        }
        $trattamenti = new TreatmentModel();
        $result = $trattamenti->removeItem($id);
        if($result == false){
            return view("/layouts/treatments", ['title' => "Trattamenti", 'error' => "Errore nell'eliminazione del trattamento!"]);
        }
        return redirect()->to(site_url('/treatments'));
    }

    public function addProducts(){
        if ($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $prodotto = new ProductModel();
        $result = $prodotto->getProducts();
        if ($result === null) {
            return view ("/layouts/addProducts", ['title' => "Aggiungi Prodotto", "error" => "Non ci sono prodotti da mostrare!"]);
        }
        return view ("/layouts/addProducts", ['title' => "Aggiungi Prodotto", "result" => $result]);    
    }

    public function do_addProducts(){
        if ($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        } else if ($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);
        $map_name = ["front", "back", "side"];
        $rules = [
            'nome' => 'required|min_length[3]|max_length[25]',
            'descrizione' => 'required|min_length[5]|max_length[1000]',
            'prezzo' => 'required|numeric',
            'immagine' => 'uploaded[immagine.0]|ext_in[immagine,jpg,jpeg]|is_image[immagine]',
        ];
        if($this->validate($rules)){
            $prodotto = new ProductModel();
            $files = $this->request->getFiles();
            if (count($files["immagine"]) > 3){
                return view("/layouts/addProducts", ['title' => "Aggiungi Prodotto", 'error' => "Errore puoi caricare massimo 3 immagini .jpg!"]);
            }
            $result = $prodotto->addProdotto($this->request->getPost("nome"),
            $this->request->getPost("prezzo"), 
            $this->request->getPost("descrizione"), 
            $this->session->get("user")["Telefono"], count($files["immagine"]));
            if($result == false){
                return view("/layouts/addProducts", ['title' => "Aggiungi Prodotto", 'error' => "Errore nell'inserimento del prodotto nel DB!"]);
            }
            $lastID = $prodotto->getLastID();
            foreach($files["immagine"] as $file){
                $file->move("./assets/products", $lastID . "_" . $map_name[array_search($file, $files["immagine"])] . ".jpg");
            }
            return redirect()->to(site_url('/addproducts'));
        } else {
            return view("/layouts/addProducts", ['title' => "Aggiungi Prodotto", 'error' => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function rmProduct($id){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        } else if(!isset($id)) {
            return redirect()->to(site_url('/addproducts'));
        }
        $prodotto = new ProductModel();
        $images = $prodotto->getImagesByProductId($id);
        $result = $prodotto->rmProduct($id);
        foreach($images as $image){
            unlink("./assets/products/" . $id. "_" . $image["Nome"] . ".jpg");
        }
        if($result == false){
            return view("/layouts/addProducts", ['title' => "Aggiungi prodotto", 'error' => "Errore nell'eliminazione del prodotto!"]);
        }
        return redirect()->to(site_url('/addproducts'));
    }

    public function getProducts(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if($this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $prodotto = new ProductModel();
        $result = $prodotto->getProducts();
        if ($result === null) {
            return view ("/layouts/products", ['title' => "Prodotti", "error" => "Non ci sono prodotti da mostrare!"]);
        }
        return view ("/layouts/products", ['title' => "Prodotti", "result" => $result]);
    }

    public function addWorks(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $lavoro = new WorksModel();
        $result = $lavoro->getWorks();
        if ($result === null) {
            return view ("/layouts/addWorks", ['title' => "Aggiungi Lavoro", "error" => "Non ci sono lavori da mostrare!"]);
        }
        return view ("/layouts/addWorks", ['title' => "Aggiungi Lavoro", "result" => $result]);
    }

    public function do_addWorks(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if($this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);
        $map_name = ["1", "2", "3"];
        $rules = [
            'titolo' => 'required|min_length[3]|max_length[25]',
            'descrizione' => 'required|min_length[5]|max_length[1000]',
            'immagine' => 'uploaded[immagine.0]|ext_in[immagine,jpg,jpeg]|is_image[immagine]',
        ];
        if($this->validate($rules)){
            $lavoro = new WorksModel();
            $files = $this->request->getFiles();
            if (count($files["immagine"]) > 3){
                return view("/layouts/addWorks", ['title' => "Aggiungi Lavoro", 'error' => "Errore puoi caricare massimo 3 immagini .jpg!"]);
            }
            $result = $lavoro->addWork($this->request->getPost("titolo"),
            $this->request->getPost("data"), 
            $this->request->getPost("descrizione"), 
            $this->session->get("user")["Telefono"], count($files["immagine"]));
            if($result == false){
                return view("/layouts/addWorks", ['title' => "Aggiungi Lavoro", 'error' => "Errore nell'inserimento del lavoro nel DB!"]);
            }
            $lastID = $lavoro->getLastID();
            foreach($files["immagine"] as $file){
                $file->move("./assets/works", $lastID . "_" . $map_name[array_search($file, $files["immagine"])] . ".jpg");
            }
            return redirect()->to(site_url('/addworks'));
        } else {
            return view("/layouts/addWorks", ['title' => "Aggiungi Lavoro", 'error' => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function rmWork($id){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        } else if(!isset($id)) {
            return redirect()->to(site_url('/addworks'));
        }
        $lavoro = new WorksModel();
        $images = $lavoro->getImagesByWorkId($id);
        $result = $lavoro->rmWork($id);
        foreach($images as $image){
            unlink("./assets/works/" . $id. "_" . $image["Nome"] . ".jpg");
        }
        if($result == false){
            return view("/layouts/addWorks", ['title' => "Aggiungi lavoro", 'error' => "Errore nell'eliminazione del lavoro!"]);
        }
        return redirect()->to(site_url('/addworks'));
    }

    public function getWorks(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        } else if($this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $lavoro = new WorksModel();
        $result = $lavoro->getWorks();
        if ($result === null) {
            return view ("/layouts/works", ['title' => "Lavori", "error" => "Non ci sono lavori da mostrare!"]);
        }
        return view ("/layouts/works", ['title' => "Lavori", "result" => $result]);
    }
}

?>
