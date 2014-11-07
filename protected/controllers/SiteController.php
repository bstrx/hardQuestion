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
        $users = User::find(array('firstName' => 'Vasiliy'));
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
        $user->name = 'Bruce';
        $user->update();
    }

    function deleteAction()
    {
        $users = User::delete(array('id' => '6'));
        $users = User::find();
        echo $this->twig->render('site/another.html', array('users' => $users));
    }
}
