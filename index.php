<?php
require_once 'protected/core/route.php';
$q = trim($_GET['q'], "\/");
$router = new Route($q);
$router->runController();
