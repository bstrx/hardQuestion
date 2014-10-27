<?php
namespace core;

class Route
{
    private $q;

    /**
     * @param $q
     */
    public function __construct($q)
    {
        $this->q = $q;
    }

    public function runController()
    {
        try {
            // default controller/action
            $controllerName = 'Site';
            $actionName = 'index';
            $routes = explode('/', $this->q);

            // get controller name
            if (!empty($routes[0])) {
                $controllerName = $routes[0];
            }

            // get action name
            if (!empty($routes[1])) {
                $actionName = $routes[1];
            }

            //add prefix
            $controllerName = mb_convert_case($controllerName, MB_CASE_TITLE, "UTF-8") . 'Controller';
            $actionName = strtolower($actionName) . 'Action';

            $controllerName = 'controllers\\' . $controllerName;

            $controller = new $controllerName;
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                throw new \Exception('Action doesn`t exist');
            }
        } catch (\Exception $e) {
            echo sprintf('Error (File: %s line %s: %s)', $e->getFile(), $e->getLine(), $e->getMessage());
        }
    }
}
