<?php
namespace app\controllers;

use App\Controllers\BaseController;

class test_LoginController extends BaseController{
    public function login(){
        return view('login/test_login');
    }
}
?>