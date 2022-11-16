<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Project\PHP\Login\App\Router;
use Project\PHP\Login\Controller\HomeController;

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/hello', HomeController::class, 'hello');
Router::add('GET', '/register', HomeController::class, 'register');
Router::add('GET', '/about', HomeController::class, 'about');

Router::run();