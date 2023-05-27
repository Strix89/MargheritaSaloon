<?php

namespace App\Controllers;

class MainController extends BaseController
{
    public function index()
    {
        helper("html");
        return view('homeSalon', ['title' => "Home"]);
    }
}
?> 