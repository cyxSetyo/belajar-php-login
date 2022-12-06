<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Project\PHP\Login\App\Router;
use Project\PHP\Login\Config\Database;
use Project\PHP\Login\Controller\HomeController;
use Project\PHP\Login\Controller\UserController;
use Project\PHP\Login\Controller\UserLoginController;
use Project\PHP\Login\Middleware\MushLoginMidlleware;
use Project\PHP\Login\Middleware\MushNotLoginMidlleware;
use Project\PHP\Login\Repository\UserRepository;

Database::getConnection('prod');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);

// User Controller
Router::add('GET', '/users/register', UserController::class, 'register', [MushNotLoginMidlleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MushNotLoginMidlleware::class]);

//User Login
Router::add('GET', '/users/login', UserController::class, 'login', [MushNotLoginMidlleware::class]);
Router::add('POST', '/users/login', UserController::class, 'postLogin', [MushNotLoginMidlleware::class]);

//UserLogout
Router::add('GET', '/users/logout', UserController::class, 'postLogout', [MushLoginMidlleware::class]);

//UserUpdate
Router::add('GET', '/users/profile', UserController::class, 'updateProfile', [MushLoginMidlleware::class]);
Router::add('POST', '/users/profile', UserController::class, 'postUpdateProfile', [MushLoginMidlleware::class]);

//UpdatePAssword
Router::add('GET', '/users/password', UserController::class, 'updatePassword', [MushLoginMidlleware::class]);
Router::add('POST', '/users/password', UserController::class, 'postPassword', [MushLoginMidlleware::class]);

Router::run();