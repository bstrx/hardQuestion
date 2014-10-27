<?php
namespace core;

class Autoloader
{
    /**
     * Registers autoloader
     *
     * @throws \Exception
     */
    public function register()
    {
        if (!spl_autoload_register('core\Autoloader::load')) {
            throw new \Exception('Could not register ' . __NAMESPACE__ . '\'s class autoload function');
        }
    }

    public static function load($fullName)
    {
        $namespaces = explode('\\', $fullName);
        $className = array_pop($namespaces);
        $basePath = $_SERVER['DOCUMENT_ROOT'] . '/protected/';
        foreach ($namespaces as $namespace) {
            $basePath = $basePath . $namespace . '/';
        }
        $basePath = $basePath . str_replace('_', '/', $className) . '.php';
        if (file_exists($basePath)) {
            include_once($basePath);
        } else {
            throw new \Exception('There is no ' . $className . ' in that project');
        }
    }

}
