<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Project\PHP\Login\App\Router;
use Project\PHP\Login\Controller\HomeController;

Router::add('GET', '/', HomeController::class, 'index', []);

Router::run();