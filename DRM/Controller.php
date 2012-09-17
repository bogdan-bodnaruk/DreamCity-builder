<?php
abstract class Controller extends DRM {
    public $val;
    public $i18n;
    public $lang;
    
    function __construct() {
        $this->val = &parent::$values; 
        $this->i18n = &$this->i18n();
        $this->lang = isset($_COOKIE['i18n']) ? $_COOKIE['i18n'] : $this->registry()->config['default_i18n'];
        $this->bootstrap();
        $this->lang();
    }
    
    function val($type) {
        for($i=2; $i<count($this->registry()->values)+2; $i++) {
            if(preg_match('/'.$type.'\=[0-9a-zA-Z]+/', $this->registry()->values[$i])) {
                list($text, $this->val[$type]) = explode('=', $this->registry()->values[$i]);
                return $this->val[$type];
            };
        }
    }
    
    private function lang() {
        if(isset($_GET['lang'])) {
            $lang = strtr($_GET['lang'], array('%2F'=>'','/'=>''));
            for($i=0;$i<count($this->registry()->config['all_i18n']);$i++) {
                if($this->registry()->config['all_i18n'][$i]==$lang) {
                    setcookie('i18n', $lang, time()+36000, '/');
                    Go::reload($_SERVER['HTTP_REFERER']);
                };
            }
        };
    }
    
    function bootstrap() {
        !isset($_SESSION['status']) ? $_SESSION['status'] = 'guest' : '';
    }
    
    abstract function index();
}