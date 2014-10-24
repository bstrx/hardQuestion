<?php
namespace controllers;

use core\Controller;

class SiteController extends Controller
{
    function indexAction()
    {
        $a = 'index';
        echo 'Welcome to the ' . $a . ' page';
    }

    function anotherAction()
    {
        $a = 'another';
        echo 'Welcome to the ' . $a . ' page';
    }
}
