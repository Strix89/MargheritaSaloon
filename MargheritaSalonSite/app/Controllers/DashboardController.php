<?php

namespace App\Controllers;

use App\Models\HomeModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index(){
        return view("/layouts/dashboard", ['title' => "Dashboard"]);
    }

    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}

?>
