<?php
    namespace MVC\Controller;

    use MVC\Core\Controller as BaseController;

    class IndexController extends BaseController{

        public function index(){

            $this->view('index.php');
        }
        public function documentation(){
            
            $this->view('doc.php');
        }
    }
?>