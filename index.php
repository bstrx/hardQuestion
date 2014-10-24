<?php
require_once 'protected/core/Autoloader.php';
use core\Autoloader;
use core\Route;

$autoloader = new Autoloader();
$autoloader->register();

$q = trim($_GET['q'], "\/");
$router = new Route($q);
$router->runController();
