<?php
namespace Project\PHP\Login\Controller;

use Project\PHP\Login\App\View;

class UserController
{
    public function register()
    {
        View::render('User/register', [
            "title" => "Form Register",
            //"error" => "upsdsas"
        ]);
    }

    public function postregister()
    {

    }
}