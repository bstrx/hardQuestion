<?php
namespace controllers;

use Core\Controller;
use models\User;

class SiteController extends Controller
{
    function indexAction()
    {
        $sql = "SELECT id,content FROM `test`";
        $tests = $this->getConnection()->getAssoc($sql);
        echo $this->twig->render('site/index.html', array('tests' => $tests));
    }

    function anotherAction()
    {
        $arr = array('firstName' => 'Vasiliy');
        $users = User::find($arr);
        echo $this->twig->render('site/another.html', array('users' => $users));
    }

    function createAction()
    {
        $user = new User();
        $user->name = 'Albert';
        $user->surname = 'Einstein';
        $user->save();
    }

    function updateAction()
    {
        $arr = array('lastName' => 'Einstein');
        $user = User::findOne($arr);
        $user->name = 'William';
        $user->update();
    }
}
