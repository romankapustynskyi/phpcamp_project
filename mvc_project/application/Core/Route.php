<?php
namespace application\Core;

class Route
{
    public static function route()
    {
        $contoller_name = "Users";
        $action_name = "index";
        $parameter = null;

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if(!empty($routes[2])) {
            $contoller_name = $routes[2];

            if(!empty($routes[3])) {
                $action_name = $routes[3];
            }

            if(isset($routes[4]) && ($routes[4] == 0 | !empty($routes[4]))) {
                $parameter = $routes[4];
            }
        }
        
        $controllerClassName = "application\Controller\Controller_" . ucfirst($contoller_name);
        $action_name = "action_" . $action_name;

        $controllerObject = new $controllerClassName;
        
        if(method_exists($controllerObject, $action_name)) {
            $controllerObject->$action_name($parameter);
        }
    }
}