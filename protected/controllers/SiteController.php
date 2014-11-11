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
        $users = new User();
        $users = $users->find(array('firstName' => 'Vasiliy'));
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
        $user = User::findOne(array('lastName' => 'Einstein'));
        $user->name = 'William Jr';
        $user->update();
        echo $this->twig->render('site/another.html', array('user' => $user));
    }

    function deleteAction()
    {
        $users = User::delete(array('id' => '5'));
        echo $this->twig->render('site/another.html', array('users' => $users));
    }
}
