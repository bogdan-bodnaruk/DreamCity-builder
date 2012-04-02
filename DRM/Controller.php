<?php
abstract class Controller extends DRM {
    public $val;
    public $i18n;
    
    function __construct() {
        $this->val = &parent::$values; 
        $this->i18n = &$this->i18n();
    }
    
    function val($type) {
        for($i=2; $i<count($this->registry()->values)+2; $i++) {
            if(preg_match('/'.$type.'\=[0-9]{1,5}/', $this->registry()->values[$i])) {
                list($text, $this->val[$type]) = explode('=', $this->registry()->values[$i]);
            };
        }
    }
    
    abstract function index();
}