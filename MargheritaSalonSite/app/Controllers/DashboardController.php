<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;
use App\Models\VisitModel;
use App\Models\AnnounceModel;
use App\Models\TreatmentModel;
use App\Models\ProductModel;
use App\Models\WorksModel;
use App\Models\ReviewsModel;
use App\Models\ReservationModel;
use CodeIgniter\Files\File;
use \Datetime;
use \DateInterval;
use \DatePeriod;

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
            'durata' => 'required|numeric|'
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

    public function getReviews(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        }
        $recensione = new ReviewsModel();
        $result = $recensione->getReviews();
        if ($result === null || count($result) == 0) {
            return view ("/layouts/reviews", ['title' => "Recensioni", "error" => "Non ci sono recensioni da mostrare!"]);
        }
        return view ("/layouts/reviews", ['title' => "Recensioni", "result" => $result]);
    }

    public function getSalonCalendar(){
        if($this->session->get("user") === null) {
            return redirect()->to(site_url('/clienterror'));
        }
        $appuntamento = new ReservationModel();
        $result = $appuntamento->getReservations(null, 14);
        if ($result === null || count($result) == 0) {
            return view ("/layouts/calendar", ['title' => "Calendario", "error" => "Non ci sono appuntamenti, da oggi a 14 giorni, da mostrare!"]);
        }
        return view ("/layouts/calendar", ['title' => "Calendario", "result" => $result, "mode" => false]);
    }

    public function getPersonalCalendar(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $appuntamento = new ReservationModel();
        $result = $appuntamento->getReservations($this->session->get("user")["Telefono"], 14);
        if ($result === null || count($result) == 0) {
            return view ("/layouts/calendar", ['title' => "Calendario", "error" => "Non ci sono appuntamenti per te, da oggi a 14 giorni, da mostrare!"]);
        }
        return view ("/layouts/calendar", ['title' => "Calendario", "result" => $result, "mode" => true]);
    }

    public function makeReservationDate(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $data = date("Y-m-d");
        $ora = date("H:i");
        $orari = array_reduce([
            ['08:00', '13:01'],
            ['15:00', '20:01']
        ], function($acc, $range) {
            $ora_inizio = new DateTime($range[0]);
            $ora_fine = new DateTime($range[1]);
            $intervallo = new DateInterval('PT30M');
            $orari = array_map(function($ora) {
                return $ora->format('H:i');
            }, iterator_to_array(new DatePeriod($ora_inizio, $intervallo, $ora_fine)));
            return array_merge($acc, $orari);
        }, []);
        $sequenceDate = function ($numero_date) {
            $date = array();
            $oggi = new DateTime();
            for ($i = 0; $i < $numero_date; $i++) {
                if ($i === 0) {
                    if ($oggi->format('N') < 6) {
                        $date[] = $oggi->format('Y-m-d');
                    }
                } else {
                    do {
                        $oggi->add(new DateInterval('P1D'));
                    } while ($oggi->format('N') >= 6);
                    $data = $oggi->format('Y-m-d');
                    $date[] = $data;
                }
            }
            return $date;
        };
        $sequenceDate = $sequenceDate(15);
        return view("layouts/reservation", ['title' => "Prenota", "orari" => $orari, "date" => $sequenceDate]);
    }

    public function do_makeReservationDate(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $orari = array_reduce([
            ['08:00', '13:01'],
            ['15:00', '20:01']
        ], function($acc, $range) {
            $ora_inizio = new DateTime($range[0]);
            $ora_fine = new DateTime($range[1]);
            $intervallo = new DateInterval('PT30M');
            $orari = array_map(function($ora) {
                return $ora->format('H:i');
            }, iterator_to_array(new DatePeriod($ora_inizio, $intervallo, $ora_fine)));
            return array_merge($acc, $orari);
        }, []);
        $sequenceDate = function ($numero_date) {
            $date = array();
            $oggi = new DateTime();
            for ($i = 0; $i < $numero_date; $i++) {
                if ($i === 0) {
                    if ($oggi->format('N') < 6) {
                        $date[] = $oggi->format('Y-m-d');
                    }
                } else {
                    do {
                        $oggi->add(new DateInterval('P1D'));
                    } while ($oggi->format('N') >= 6);
                    $data = $oggi->format('Y-m-d');
                    $date[] = $data;
                }
            }
            return $date;
        };
        $sequenceDate = $sequenceDate(15);
        $data = $this->request->getPost("data");
        $ora = $this->request->getPost("ora");
        $user = new UserModel();
        $res = new ReservationModel();
        $result_r = $res->getReservations($this->session->get("user")["Telefono"], null, $data, true);
        $nope = false;
        $i = 0;
        while($nope === false && $i < count($result_r)){
            $result_r[$i]["Durate"] = str_replace(["{", "}", '"'], "", $result_r[$i]["Durate"]);
            $result_r[$i]["Durate"] = explode(",", $result_r[$i]["Durate"]);
            $durate = $result_r[$i]["Durate"];
            $totale_secondi = 0;
            foreach ($durate as $durata) {
                $totale_secondi += strtotime($durata) - strtotime('00:00:00');
            }
            $totale_minuti = round($totale_secondi / 60);
            $ora_pren = DateTime::createFromFormat('H:i', $ora);
            $orario_pren_datetime = DateTime::createFromFormat("H:i", substr($result_r[$i]['Ora_P'], 0, 5)); 
            $orario_fine_datetime = DateTime::createFromFormat('H:i', $orario_pren_datetime->format("H:i")); 
            $orario_fine_datetime->add(new DateInterval('PT' . $totale_minuti . 'M'));
            if ($ora_pren >= $orario_pren_datetime && $ora_pren <= $orario_fine_datetime) {
                $nope = true;
            }
            $i++;
        }
        if($nope){
            return view("layouts/reservation", ['title' => "Prenota", "error" => "Non puoi prenotare in questo orario, hai già un'altra prenotazione!", "date" => $sequenceDate, "orari" => $orari]);
        }
        $result_u = $user->getFreePersonale($data, $ora);
        $free = [];
        foreach($result_u as $us){
            $result_r = $res->getReservations($us["Telefono"], null, $data);
            if (count($result_r) == 0){
                array_push($free, $us);
                continue;
            }
            $nope = false;
            $i = 0;
            while($nope === false && $i < count($result_r)){
                $result_r[$i]["Durate"] = str_replace(["{", "}", '"'], "", $result_r[$i]["Durate"]);
                $result_r[$i]["Durate"] = explode(",", $result_r[$i]["Durate"]);
                $durate = $result_r[$i]["Durate"];
                $totale_secondi = 0;
                foreach ($durate as $durata) {
                    $totale_secondi += strtotime($durata) - strtotime('00:00:00');
                }
                $totale_minuti = round($totale_secondi / 60);
                $ora_pren = DateTime::createFromFormat('H:i', $ora);
                $orario_pren_datetime = DateTime::createFromFormat("H:i", substr($result_r[$i]['Ora_P'], 0, 5)); 
                $orario_fine_datetime = DateTime::createFromFormat('H:i', $orario_pren_datetime->format("H:i")); 
                $orario_fine_datetime->add(new DateInterval('PT' . $totale_minuti . 'M'));
                if ($ora_pren >= $orario_pren_datetime && $ora_pren <= $orario_fine_datetime) {
                    $nope = true;
                }
                $i++;
            }
            if(!$nope){
                array_push($free, $us);
            }
        }
        if(count($free) == 0){
            return view("layouts/reservation", ['title' => "Prenota", "error" => "Non ci sono parrucchieri disponibili per la data e l'ora selezionati!", "date" => $sequenceDate, "orari" => $orari]);
        }
        $treatments = new TreatmentModel();
        $result_t = $treatments->getTreatments();
        return view("layouts/reservation2", ['title' => "Prenota", "users" => $free,  "treatments" => $result_t, "data" => $data, "ora" => $ora]);
    }

    public function do_makeReservation(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $orari = array_reduce([
            ['08:00', '13:01'],
            ['15:00', '20:01']
        ], function($acc, $range) {
            $ora_inizio = new DateTime($range[0]);
            $ora_fine = new DateTime($range[1]);
            $intervallo = new DateInterval('PT30M');
            $orari = array_map(function($ora) {
                return $ora->format('H:i');
            }, iterator_to_array(new DatePeriod($ora_inizio, $intervallo, $ora_fine)));
            return array_merge($acc, $orari);
        }, []);
        $sequenceDate = function ($numero_date) {
            $date = array();
            $oggi = new DateTime();
            for ($i = 0; $i < $numero_date; $i++) {
                if ($i === 0) {
                    if ($oggi->format('N') < 6) {
                        $date[] = $oggi->format('Y-m-d');
                    }
                } else {
                    do {
                        $oggi->add(new DateInterval('P1D'));
                    } while ($oggi->format('N') >= 6);
                    $data = $oggi->format('Y-m-d');
                    $date[] = $data;
                }
            }
            return $date;
        };
        $sequenceDate = $sequenceDate(15);
        $res = new ReservationModel();
        $trattamento = new TreatmentModel();
        $user = new UserModel();

        $data = $this->request->getPost("data");
        $ora = $this->request->getPost("ora");
        $treats = $this->request->getPost("trattamento");

        if(!is_array($treats)){
            $treats = array($treats);
        }
        if(count($treats) > 3){
            return view("layouts/reservation", ['title' => "Prenota", "error" => "Non puoi prenotare più di 3 trattamenti!", "orari" => $orari, "date" => $sequenceDate]);
        }

        $user_p = $this->request->getPost("operatore");
        $res_user = $user->getNomeCognomeByTelefono($user_p);

        $dataToSend = [
            "Telefono_C" => $this->session->get("user")["Telefono"],
            "Data_P" => $data,
            "Ora_P" => $ora,
            "Telefono_P" => $user_p,
            "Trattamenti" => $treats
        ];

        try {
            $res->insertPrenotazione($dataToSend);
            $res_treats = $trattamento->getTrattamentiTitoliEDurata($dataToSend["Trattamenti"]);

            $emailValidator = \Config\Services::email();
            $emailValidator->setFrom("margheritasalon@gmail.com", "Ciao ". $this->session->get("user")["Username"]);
            $emailValidator->setTo($this->session->get("user")["Email"]);
            $emailValidator->setSubject("Prenotazione effettuata");
            $emailValidator->setMessage("
                    Gentile " . $this->session->get("user")["Nome"] . " " . $this->session->get("user")["Cognome"] . ",<br><br>

                    siamo lieti di informarla che la sua prenotazione è stata effettuata con successo!<br><br>

                    Riepilogo della prenotazione: <br>
                    - Data: " . $dataToSend["Data_P"] . " <br>
                    - Ora: " . $dataToSend["Ora_P"] . " <br>
                    - Trattamenti: " . implode(", ", $res_treats["Titoli"]) . " <br>
                    - Durata: " . $res_treats["Durata"] . " <br>
                    - Prezzo:  " . $res_treats["Prezzo"] . " <br>
                    - Operatore: " . $res_user["Nome"] . " " . $res_user["Cognome"] . " <br>

                    Grazie per aver scelto il nostro salone, siamo impazienti di accoglierla!<br><br>
                    Cordiali saluti,<br>
                    Il team del Margherita Salon ;)
                    ");
            $emailValidator->send();
            $emailValidator->printDebugger(['headers']);

            return redirect()->to(site_url('/saloncalendar'));
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            print_r($e->getMessage());
            //return view("layouts/reservation", ['title' => "Prenota", "error" => "Hai già una prenotazione per l'orario scelto!", "orari" => $orari, "date" => $sequenceDate]);
        }
    }

    public function removeRes($phone, $name, $date, $time){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "f") {
            return redirect()->to(site_url('/clienterror'));
        }
        $res = new ReservationModel();
        $user = new UserModel();
        $email_target = $user->getEmailByTelefono($phone);
        $res->deletePrenotazione($phone, $date, $time);
        $emailValidator = \Config\Services::email();
        $emailValidator->setFrom("margheritasalon@gmail.com", "Ciao ". $this->session->get("user")["Username"]);
        $emailValidator->setTo($email_target);
        $emailValidator->setSubject("Annullamento prenotazione");
        $emailValidator->setMessage("
                Gentile " . $this->session->get("user")["Nome"] . " " . $this->session->get("user")["Cognome"] . ",<br><br>

                le scriviamo per informarla che la sua prenotazione presso il nostro centro benessere per il giorno " . $date . " alle ore " . $time ." è stata annullata.<br>
                Ci scusiamo per l'inconveniente e speriamo di poterla accogliere nuovamente presso il nostro salone in futuro. <br><br>

                Anche " . $name . " si scusa per l'annullamento, purtroppo ha avuto un imprevisto :(.<br><br>

                Cordiali saluti,<br>
                Il team del Margherita Salon ;)
                ");
        $emailValidator->send();
        $emailValidator->printDebugger(['headers']);
        return redirect()->to(site_url('/personalcalendar'));
    }

    public function writeReview(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        $data = date("Y-m-d");
        $ora = date("H:i");
        $res = new ReservationModel();
        $result = $res->getResWithoutRev($this->session->get("user")["Telefono"], $data, $ora);
        if(count($result) === 0){
            return view("layouts/writeRev", ['title' => "Scrivi una recensione", "error" => "Non hai prenotazioni da recensire!"]);
        }
        return view("layouts/writeRev", ['title' => "Scrivi una recensione", "result" => $result]);
    }

    public function do_writeReview(){
        if($this->session->get("user") === null || $this->session->get("user")["Tipologia"] === "t") {
            return redirect()->to(site_url('/clienterror'));
        }
        helper(['form']);
        $data = date("Y-m-d");
        $ora = date("H:i");
        $res = new ReservationModel();
        $result = $res->getResWithoutRev($this->session->get("user")["Telefono"], $data, $ora);
        $rules = [
            'recensione' => 'required|min_length[20]|max_length[1000]'
        ];
        if(!$this->validate($rules)){
            return view("layouts/writeRev", ['title' => "Scrivi una recensione", "error1" => "La recensione deve essere lunga almeno 30 caratteri e non superare i 1000 caratteri!", "result" => $result]);
        }
        $rev = new ReviewsModel();
        $data_ora = $this->request->getPost("prenotazione");
        $data_ora = explode("|", $data_ora);
        $rate = intval($this->request->getPost("rate"));
        $text = $this->request->getPost("recensione");
        $r = $rev->insertReview($this->session->get("user")["Telefono"], $data_ora[0], $data_ora[1], $data, $ora, $rate, $text);
        if($r){
            return redirect()->to(site_url('/reviews'));
        } else {
            return view("layouts/writeRev", ['title' => "Scrivi una recensione", "error1" => "Errore nell'inserimento della recensione!", "result" => $result]);
        }
    }
}

?>
