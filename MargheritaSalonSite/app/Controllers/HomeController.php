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
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('psw');

        $result = $user->where('Username', $username)->first();
        
        if(!isset($result)){
            $result = $user->where('Email', $username)->first();
        } 

        if(isset($result)){
            if(password_verify($password, $result['PSW'])){
                
            } else {
                return view("/layouts/login", ['title' => "Login", 'error' => "Password errata", "username" => $username, "password" => $password]);
            }
        } else{
            return view("/layouts/login", ['title' => "Login", 'error' => "Username/email o password errati", "username" => $username, "password" => $password]);
        }  
    }

    public function signup(){
        return view('/layouts/register', ['title' => "SignUp"]);
    }

    public function do_signup(){
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