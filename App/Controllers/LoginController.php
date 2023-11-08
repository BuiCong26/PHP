<?php

namespace App\Controllers;

use App\Flash;
use \Core\View;
use \App\Models\User;
use mysqli;

class LoginController extends \Core\Controller
{
    public function signinAction()
    {
        $users = new User();
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        if(!empty($email)){
            $password_input = $_POST['pwd'];
            $result = User::login($email);
            if($result){
                if($password_input == $result['password']){
                    View::renderTemplate('login.html',['action'=>'loginSuccess']);
                    $_SESSION['auth'] = $email;
                    return;
                } else{
                    View::renderTemplate('login.html',['action'=>0]);
                    return;
                }
            }else {
                View::renderTemplate('login.html',['action'=>0]);
                return;
            }
        }
        View::renderTemplate('login.html');
    }

    public function signoutAction(){
        $_SESSION['auth'] = '';
        unset($_SESSION['auth']);
        header('Location: /login');
    }
}