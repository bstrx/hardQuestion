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

    /**
     * @param $fullName
     * @throws \Exception
     */
    public static function load($fullName)
    {
        $namespaces = explode('\\', $fullName);
        $className = array_pop($namespaces);
        $basePath = $_SERVER['DOCUMENT_ROOT'] . '/protected/';
        foreach ($namespaces as $namespace) {
            $basePath = $basePath . $namespace . DIRECTORY_SEPARATOR;
        }
        $basePath = $basePath . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($basePath)) {
            include_once($basePath);
        } else {
            throw new \Exception('There is no ' . $className . ' in that project');
        }
    }

}
