<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return view('/layouts/homeSalon', ['title' => "Home"]);
    }

    public function login()
    {
        return view('/layouts/login', ['title' => "Login"]);
    }

    public function signup(){
        return view('/layouts/register', ['title' => "SignUp"]);
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