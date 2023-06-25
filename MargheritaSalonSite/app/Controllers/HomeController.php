<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;
use App\Models\VisitModel;
use CodeIgniter\HTTP\Response;

class HomeController extends BaseController
{
    public function index()
    {
        $page = new HomeModel();
        $product_images = $page->getRandomProductImages();
        $product_images = array_map(function($item){
            return $item . "_front.jpg";
        }, $product_images);
        if(count($product_images) < 6){
            for($i = count($product_images); $i < 6; $i++){
                $product_images[$i] = "None.jpg";
            }
        }
        $reviews = $page->getRandomComments();
        if(count($reviews) < 3){
            for($i = count($reviews); $i < 3; $i++){
                $reviews[$i] = (object) [
                    "Data" => "None",
                    "Nome" => "None",
                    "Cognome" => "None",
                    "Testo" => "None"
                ];
            }
        }
        $works_images = $page->getRandomWorks();
        $works_images = array_map(function($item){
            return $item . "_1.jpg";
        }, $works_images);
        if(count($works_images) < 6){
            for($i = count($works_images); $i < 6; $i++){
                $works_images[$i] = "None.jpg";
            }
        }
        if(!$this->session->get("visited") === true) { $this->record_visit(); }
        return view('/layouts/homeSalon', ['title' => "Home",
        'product_images' => $product_images, 
        'reviews' => $reviews,
        'works_images' => $works_images]);
    }

    public function login()
    {
        return view('/layouts/login', ['title' => "Login"]);
    }

    public function do_login(){
        helper(['form']);

        $user = new UserModel();

        $rules = [
            'username' => 'required',
            'psw' => 'required|min_length[6]|max_length[20]'
        ];
        
        if($this->validate($rules)){
            $username = trim($this->request->getPost('username'));
            $password = trim($this->request->getPost('psw'));

            $result = $user->where('Username', $username)->first();
        
            if(!isset($result)){
                $result = $user->where('Email', $username)->first();
            }    

            if(isset($result)){
                if(password_verify($password, $result['PSW'])){
                    $this->session->set('user', $result);
                    $user->setLogged($result['Telefono']);
                    return view('/layouts/loading', ['title' => "Loading"]);
                } else {
                    return view("/layouts/login", ['title' => "Login", 'error' => "Password errata!", "username" => $username, "password" => $password]);
                }
            } else {
                return view("/layouts/login", ['title' => "Login", 'error' => "Username/Email o password errati!", "username" => $username, "password" => $password]);
            }
        } else {
            return view("/layouts/login", ['title' => "Login", 'error' => implode("<br>",$this->validator->getErrors())]);
        }
    }

    public function signup(){
        return view('/layouts/register', ['title' => "SignUp"]);
    }

    public function do_signup(){
        helper(['form']);

        $user = new UserModel();
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email',
            'name' => 'required|alpha',
            'surname' => 'required|alpha',
            'phone' => 'required|regex_match[/^[0-9]{10}$/]',
            'psw' => 'required|min_length[6]|max_length[20]',
            'psw_confirm' => 'required|min_length[6]|max_length[20]'
        ];

        if($this->validate($rules)) {
            $username = trim($this->request->getPost('username'));
            $email = trim($this->request->getPost('email'));
            $name = ucfirst(strtolower(trim($this->request->getPost('name'))));
            $surname = ucfirst(strtolower(trim($this->request->getPost('surname'))));
            $phone = trim($this->request->getPost('phone'));
            $password = trim($this->request->getPost('psw'));
            $confirm_password = trim($this->request->getPost('psw_confirm'));

            if($password != $confirm_password){
                return view("/layouts/register", ["title" => "SignUp", "error" => "Le password non coincidono!", "username" => $username, "email" => $email, "name" => $name, "surname" => $surname, "phone" => $phone]);
            }

            $password = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'Nome' => $name,
                'Cognome' => $surname,
                'Email' => $email,
                'Username' => $username,
                'PSW' => $password,
                'Telefono' => $phone,
                'Tipologia' => false,
            ];

            try {
                $result = $user->insert($data);
                $this->session->set('user', $data);
                $user->setLogged($data['Telefono']);
                $emailValidator = \Config\Services::email();
                $emailValidator->setFrom("margheritasalon@gmail.com", "Ciao ". $username);
                $emailValidator->setTo($email);
                $emailValidator->setSubject("Benvenuto al Margherita Salon");
                $emailValidator->setMessage("
                Caro/Cara " . $name . " " . $surname . ",<br><br>

                Benvenuto/a al nostro salone! Siamo felici di averti come nuovo/a cliente e ti ringraziamo per aver scelto i nostri servizi.<br>             
                Con la tua registrazione al nostro sito, ora hai accesso a una serie di funzionalità esclusive, tra cui la prenotazione online dei nostri servizi e l'accesso alla visualizzazione dei nostri prodotti migliori e agli annunci.<br>               
                Ti ricordiamo che il nostro salone offre una vasta gamma di servizi di alta qualità, tra cui tagli di capelli, acconciature, trattamenti per capelli, colorazioni e molto altro ancora. Siamo certi che troverai il servizio perfetto per soddisfare le tue esigenze.<br>
                Non esitare a contattarci se hai domande o necessiti di assistenza. Il nostro team di professionisti è sempre a tua disposizione per offrirti il miglior servizio possibile.<br>
                Grazie ancora per aver scelto il nostro salone di parruccheria e ti auguriamo una piacevole esperienza con noi!<br><br>
                
                Cordiali saluti,<br>
                Il team del Margherita Salon ;)
                ");
                $emailValidator->send();
                $emailValidator->printDebugger(['headers']);
                return view("/layouts/loading", ["title" => "Loading"]);
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                if(strpos($e->getMessage(), "Email")) {
                    return view("/layouts/register", ["title" => "SignUp", "error" => "Email già utilizzata! Sei già registrato?", "username" => $username, "name" => $name, "surname" => $surname, "phone" => $phone]);
                } else if (strpos($e->getMessage(), "Username")) {
                    return view("/layouts/register", ["title" => "SignUp", "error" => "Username già utilizzato! Sei già registrato?", "email" => $email, "name" => $name, "surname" => $surname, "phone" => $phone]);
                } else if (strpos($e->getMessage(), "Telefono")) {
                    return view("/layouts/register", ["title" => "SignUp", "error" => "Telefono già utilizzato! Sei già registrato?", "email" => $email, "name" => $name, "surname" => $surname, "username" => $username]);
                } else {
                    return view("/layouts/register", ["title" => "SignUp", "error" => "Errore durante la registrazione!", "username" => $username, "email" => $email, "name" => $name, "surname" => $surname, "phone" => $phone]);
                }
            }
        } else {
            return view("/layouts/register", ["title" => "SignUp", "error" => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function info(){
        return view('/layouts/info', ['title' => "Info"]);
    }

    public function contacts(){
        return view('/layouts/contacts', ['title' => "Contacts"]);
    }

    public function forgot(){
        if($this->session->get('user') != null){
            return redirect()->to(site_url('home'));
        }
        return view('/layouts/forgot', ['title' => "Forgot"]);
    }

    public function do_forgot(){
        helper(['form']);

        $user = new UserModel();
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email'
        ];

        if($this->validate($rules)){
            $email = $this->request->getPost('email');

            $result = $user->where('Email', $email)->first();
            if($result){
                $token = bin2hex(random_bytes(20));
                $user->update($result['Telefono'], ['Token' => $token]);
                $resetLink = site_url('passforgot/' . $token);
                $emailValidator = \Config\Services::email();
                $emailValidator->setFrom("margheritasalon@gmail.com", "Oh no ". $result['Username']);
                $emailValidator->setTo($email);
                $emailValidator->setSubject("Sembra che tu abbia dimenticato la tua password :(");
                $emailValidator->setMessage("
                Caro/Cara " . $result["Nome"] . " " . $result["Cognome"] . ",<br><br>
                
                Sembra che tu abbia dimenticato la tua password! Non preoccuparti, capita a tutti.<br>
                Per recuperare la tua password, clicca sul seguente link: " . $resetLink . "<br>
                Attento/a, il link è utilizzabile 1 sola volta!<br><br>
                ");
                $emailValidator->send();
                $emailValidator->printDebugger(['headers']);
                return view("/layouts/forgot", ["title" => "Forgot", "success" => "Ti abbiamo inviato una mail!<br>Controlla la tua casella di posta elettronica per recuperare la password!"]);
            } else {
                return view("/layouts/forgot", ["title" => "Forgot", "error" => "Email non registrata!<br>Sei sicuro di aver inserito l'email corretta?"]);
            }
        } else {
            return view("/layouts/forgot", ["title" => "Forgot", "error" => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function resetpswforgot($token){
        $user = new UserModel();
        $result = $user->where('Token', $token)->first();
        if($result){
            $this->session->set('token', $result['Token']);
            $this->session->set('user', $result);
            $user->update($result['Telefono'], ['Token' => null]);
            return view("/layouts/resetForgot", ["title" => "Reset Password"]);
        } else {
            return redirect()->to(site_url('/clienterror'));
        }
    }

    public function do_resetpswforgot(){
        helper(['form']);
        if(!$this->session->has('token')){
            return redirect()->to(site_url('/clienterror'));
        }
        $user = new UserModel();
        $rules = [
            'password' => 'required|min_length[6]|max_length[20]',
            'confpassword' => 'required|min_length[6]|max_length[20]'
        ];
        if($this->validate($rules)){
            $password = $this->request->getPost('password');
            $confpassword = $this->request->getPost('confpassword');
            if($password != $confpassword){
                return view("/layouts/resetForgot", ["title" => "Reset Password", "error" => "Le password non coincidono!"]);
            }
            $user->update($this->session->get("user")["Telefono"], ['PSW' => password_hash($password, PASSWORD_BCRYPT)]);
            $this->session->remove('token');
            $this->session->remove('user');
            return view("/layouts/resetForgot", ["title" => "Reset Password", "success" => "Password modificata con successo!<br>Prova a loggarti!"]);
        } else {
            return view("/layouts/resetForgot", ["title" => "Reset Password", "error" => implode("<br>", $this->validator->getErrors())]);
        }
    }

    public function record_visit(){
       $visitobj = new VisitModel();

        $ip_address = $_SERVER['REMOTE_ADDR'];

        $visit = [
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => inet_ntop(substr(inet_pton($ip_address), -4)) 
        ];

        $visitobj->insert($visit);
        $this->session->set('visited', true);
    }

    public function show404()
    {
        return view("layouts/clientError", ["title" => "Client Error"]);
    }
}
?> 