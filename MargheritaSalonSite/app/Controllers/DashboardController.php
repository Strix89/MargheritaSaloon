<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;
use App\Models\VisitModel;
use App\Models\AnnounceModel;


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

    public function getSalonCalendar(){
        
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
        }
        return view("/layouts/AddAnnou", ['title' => "Inserisci Annuncio"]);
    }

    public function do_insertAnnounce(){
        if($this->session->get("user") === null) {
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
}

?>
