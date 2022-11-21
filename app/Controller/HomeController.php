<?php

namespace Project\PHP\Login\Controller;

use Project\PHP\Login\App\View;

class HomeController
{
    function index()
    {
        View::render('Home/index', [
            "title" => "Login Management"
        ]);
    }

}