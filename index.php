<?php
    require_once __DIR__ . '/core/Controller.php';
    require_once __DIR__ . '/core/Model.php';
    require_once __DIR__ . '/core/Route.php';
    require_once __DIR__ . '/core/autoload.inc.php';

    require_once './Controller/indexController.php';

    
    define('statics', 'public/assets/'); //define css path
  
    $router = new Router();//create our router
    
    //default routes
    $router->get('/', "indexController/index");
    $router->get('/doc', "indexController/documentation");

    $router->run();
?>