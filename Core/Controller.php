<?php
    namespace MVC\core;

    class Controller{
        
        public function view($name) {
            include(__DIR__.'/../views/'.$name);
        }
    }
?>