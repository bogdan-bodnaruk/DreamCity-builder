<?php
abstract class Controller extends Registry_interface {
    public $template;
    public $val;
    
    function __construct() {
        $this->template = new Template();
        $this->val = &parent::$values;
    }
    abstract function index();
}