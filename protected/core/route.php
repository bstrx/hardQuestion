<?php
class Route
{
    static function runController()
    {
        require_once 'protected/core/controller.php';
        try {
            // default controller/action
            $controller_name = 'Site';
            $action_name = 'index';

            $routes = explode('/', $_GET['q']);

            // get controller name
            if (!empty($routes[0])) {
                $controller_name = $routes[0];
            }

            // get action name
            if (!empty($routes[1])) {
                $action_name = $routes[1];
            }

            //add prefix
            $model_name = mb_convert_case($controller_name, MB_CASE_TITLE, "UTF-8");
            $controller_name = $model_name . 'Controller';
            $action_name = strtolower($action_name) . 'Action';

            //include model class
            $model_path = "protected/models/" . $model_name . '.php';
            if (file_exists($model_path)) {
                include $model_path;
            }

            // include controller class
            $controller_path = "protected/controllers/" . $controller_name . '.php';
            if (file_exists($controller_path)) {
                include $controller_path;
            } else {
                throw new Exception('Controller doesn`t exist');
            }

            // create controller
            $controller = new $controller_name;
            $action = $action_name;

            if (method_exists($controller, $action)) {
                // get controller's action
                $controller->$action();
            } else {
                throw new Exception('Action doesn`t exist');
            }
        }
        catch (Exception $e) {
            echo "Error (File: ".$e->getFile().", line ".
                $e->getLine()."): ".$e->getMessage();
        }

    }

}

?>
