<?php
namespace controllers;

use core\Controller;
use core\DbConnection1;

class SiteController extends Controller
{
    function indexAction()
    {
        $a = 'index';
        echo 'Welcome to the ' . $a . ' page';

        $config = array(
            'host' => 'localhost',
            'user' => 'root',
            'port' => '3306',
            'pass' => '12071990',
            'name' => 'hardquestion',
            'charset' => 'utf8'
        );

        $db = DbConnection1::getConnection($config);
        $sql = "SELECT id,content FROM `test`";
        $result = $db->getAssoc($sql);

        echo '<h2>Таблица тестов:</h2> <table border="1">';
        foreach ($result as $id => $content) {
            echo '<tr><td>' . $id . '</td><td>' . $content . '</td><tr>';
        }
        echo '</table>';
    }

    function anotherAction()
    {
        $a = 'another';
        echo 'Welcome to the ' . $a . ' page';
    }
}
