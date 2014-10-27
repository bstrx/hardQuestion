<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Untitled Document</title>
</head>
<body>
<?php
require_once 'protected/core/Autoloader.php';
use core\Autoloader;
use core\Route;

$autoloader = new Autoloader();
$autoloader->register();

$q = trim($_GET['q'], "\/");
$router = new Route($q);
$router->runController();
?>
</body>
</html>