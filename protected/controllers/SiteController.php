<?php
namespace controllers;

use Core\Controller;

class SiteController extends Controller
{
    function indexAction()
    {
        $sql = "SELECT id,content FROM `test`";
        $tests = $this->getConnection()->getNum($sql);
        echo $this->twig->render('site/index.html', array('tests' => $tests));
    }

    function anotherAction()
    {
        echo $this->twig->render('site/another.html');
    }
}
