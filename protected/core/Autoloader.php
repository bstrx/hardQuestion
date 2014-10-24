<?php
namespace Autospace;

class myAutoload
{
    /**
     * Registers autoloader
     *
     * @throws \Exception
     */
    public function register()
    {
        if (!spl_autoload_register(__NAMESPACE__ . '\myAutoload::load')) {
            throw new \Exception('Could not register ' . __NAMESPACE__ . '\'s class autoload function');
        }
    }

    public static function load($fullName)
    {
        $namespaces = explode('\\', $fullName);
        $className = array_pop($namespaces);
        //var_dump($className); die();
        $basePath = $_SERVER['DOCUMENT_ROOT'] . '/protected/';
        foreach ($namespaces as $k => $v) {
            $basePath = $basePath . $v . '/';
        }
        if (file_exists($basePath . str_replace('_', '/', $className) . '.php')) {
            include_once($basePath . str_replace('_', '/', $className) . '.php');
        } else {
            throw new \Exception('There is no ' . $className . ' in that project');
        }
    }

}
