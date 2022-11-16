<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BelajarPhpMvc\Belajar\PHP\MVC\App\Router;
use BelajarPhpMvc\Belajar\PHP\MVC\Controller\HomeController;

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/hello', HomeController::class, 'Hello');
Router::add('GET', '/register', HomeController::class, 'register');
Router::add('GET', '/about', HomeController::class, 'about');

Router::run();