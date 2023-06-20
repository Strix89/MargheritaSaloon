<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;

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
        $user = new UserModel();
        
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('psw'));

        $result = $user->where('Username', $username)->first();
        
        if(!isset($result)){
            $result = $user->where('Email', $username)->first();
        } 

        if(isset($result)){
            if(password_verify($password, $result['PSW'])){
                $this->session->set('user', $result);
                return view('/layouts/loading', ['title' => "Loading"]);
            } else {
                return view("/layouts/login", ['title' => "Login", 'error' => "Password errata!", "username" => $username, "password" => $password]);
            }
        } else{
            return view("/layouts/login", ['title' => "Login", 'error' => "Username/Email o password errati!", "username" => $username, "password" => $password]);
        }  
    }

    public function signup(){
        return view('/layouts/register', ['title' => "SignUp"]);
    }

    public function do_signup(){
        $user = new UserModel();

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
            'Tipologia' => false
        ];

        try {
            $result = $user->insert($data);
            $this->session->set('user', $data);
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
    }

    public function info(){
        return view('/layouts/info', ['title' => "Info"]);
    }

    public function contacts(){
        return view('/layouts/contacts', ['title' => "Contacts"]);
    }

    public function forgot(){
        return view('/layouts/forgot', ['title' => "Forgot"]);
    }
}
?> 