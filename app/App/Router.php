<?php

namespace Project\PHP\Login\App;

class Router
{
    private static array $routes = [];

    public static function add(string $method, 
                               string $path, 
                               string $controller, 
                               string $function) : void
    {
        //TODO ADD URL Mapping
        self::$routes [] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function
        ];
    }

    public static function run() : void
    {
        //TODO ADD URL controller
        $path = '/';
        if(isset($_SERVER['PATH_INFO'])){
            $path = $_SERVER['PATH_INFO'];
        }

        $method = $_SERVER['REQUEST_METHOD'];
    
        foreach(self::$routes as $route){
            if($path == $route['path'] && $method == $route['method']){
                //echo "CONTROLLER : " . $route ['controller'] . ", FUNCTION : " . $route['function'];
                
                $controller = new $route['controller'];
                $function = $route['function'];
                $controller->$function();
                return;
            }
        }

        http_response_code(404);
        echo "Controller Not Found";
    }


}