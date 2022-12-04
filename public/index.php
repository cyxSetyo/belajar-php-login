<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Project\PHP\Login\App\Router;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Controller\HomeController;
use Project\PHP\Login\Controller\UserController;
use Project\PHP\Login\Controller\UserLoginController;
use Project\PHP\Login\Middleware\MushLoginMidlleware;
use Project\PHP\Login\Middleware\MushNotLoginMidlleware;

Database::getConnection('prod');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

// User Controller
Router::add('GET', '/users/register', UserController::class, 'register', [MushNotLoginMidlleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MushNotLoginMidlleware::class]);

//User Login
Router::add('GET', '/users/login', UserLoginController::class, 'login', [MushNotLoginMidlleware::class]);
Router::add('POST', '/users/login', UserLoginController::class, 'postLogin', [MushNotLoginMidlleware::class]);

//UserLogout
Router::add('GET', '/users/logout', UserLoginController::class, 'postLogout', [MushLoginMidlleware::class]);

Router::run();