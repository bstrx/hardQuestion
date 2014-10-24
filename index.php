<?php
require_once 'protected/core/Autoloader.php';
use core\test\testClass;
use Autospace\myAutoload;
use core\Route;

$autoloader = new myAutoload();
$autoloader->register();

$test = new testClass();
$q = trim($_GET['q'], "\/");
$router = new Route($q);
$router->runController();
