<?php
final class Controller {
    
    private $router;
    private $register;
    
    function __construct() {
        new Router();
        //$this->router = Register::data()->get('url');
   
        echo '<pre>';
        print_r($this->router);
        echo '</pre>';
    }
   
    
    function __destruct() {

    }
}