<?php
namespace Core;

use Core\DbConnection1;

class Controller
{
    function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem('protected/templates');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => 'compilation_cache',
            'auto_reload' => true
        ));
    }

    function actionIndex()
    {

    }

    /**
     * @return DbConnection1
     */
    protected function getConnection()
    {
        return DbConnection1::getConnection();
    }
}
