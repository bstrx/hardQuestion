<?php
require_once 'vendor/autoload.php';
use Core\Route;

$q = trim($_GET['q'], "\/");
$router = new Route($q);
$router->runController();
?>
