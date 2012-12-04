<?php
abstract class Controller extends DRM {
    public $val;
    public $i18n;
    public $lang;
    
    function __construct() {
        $this->val = &parent::$values; 
        $this->lang = isset($_COOKIE['i18n']) ? $_COOKIE['i18n'] : $this->registry()->config['default_i18n'];
        $this->bootstrap();
        $this->lang();
    }
    
    function val($type) {
        $this->val[$type] = Helpers::getValue($type);
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