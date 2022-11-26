<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Project\PHP\Login\App\Router;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Controller\HomeController;
use Project\PHP\Login\Controller\UserController;

//Database::getConnection('test');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);


// User Controller
Router::add('GET', '/users/register', UserController::class, 'register', []);
Router::add('POST', '/users/register', UserController::class, 'postRegister', []);
//User Login

Router::run();