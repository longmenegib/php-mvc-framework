<?php

    class Router{
        private $url;
        private $routes = array();
        private $controllers = array();

        public function __construct(){
            $this->url = $_GET['url'];
        }

        //function permettant de reccupere l'url et la fonction correspondante
        public function get($path, $callable){
            $this->add($path, $callable, 'GET');
        }

        public function add($path, $callable, $method){
            $route = new Route($path, $callable);
            $this->routes[$method][] = $route;

            return $route;
        }
        
        //function appelant la function call() si la route correspondante
        public function run(){
            foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
                if($route->match($this->url)){
                    return $route->call();
                }
            }
            throw new RouterException('No matching routes');
        }
    }

    //class correspondante a la route
    class Route{
        private $path;
        private $callable;
        private $matches = [];
        private $varsNames = [];

        public function __construct($path, $callable){
            $this->path = trim($path, '/');
            $this->callable = $callable;
        }

        //function permettant de recupperer les variables d'une url
        public function match($url){
            $url = trim($url, '/');
            $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
            $regex = "#^$path$#i";
            if(!preg_match($regex, $url, $matches)){
                return false;
            }
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }

        //function permettant d'executer la function correspondante a l'url
        public function call(){
            if(is_string($this->callable)){
                $params = explode('/', $this->callable);
                $controller = 'MVC\\Controller\\' . $params[0];
                $controller = new $controller();
                
                return call_user_func_array([$controller, $params[1]], $this->matches);
            }else{
                return call_user_func_array($this->callable, $this->matches);
            }
        }

    }
?>