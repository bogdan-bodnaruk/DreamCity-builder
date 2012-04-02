<?php
abstract class Controller extends DRM {
    public $val;
    public $i18n;
    
    function __construct() {
        $this->val = &parent::$values; 
        $this->i18n = &$this->i18n();
        
        $this->val['adminpanel'] = User::login()->permissions()>50 ? '<div id="adminpanel" onClick="open_panel()" >&nbsp;'.$this->i18n->adminpanel.'</div>' : '';
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