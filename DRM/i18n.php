<?php
class i18n extends DRM {
    protected $data;
    
    function __construct() {
        if(!isset($this->data)) {
            $current = isset($_COOKIE['i18n'])
                        ? $_COOKIE['i18n']
                        : $this->registry()->config['default_i18n'];
                        
            is_file(PATH.$this->registry()->config['library_path'].'/i18n/'.$current.'.php')
                    ? include (PATH.$this->registry()->config['library_path'].'/i18n/'.$current.'.php')
                    : '';
            $this->data = isset($i18n) ? $i18n : $this->data;
        };
    }
    
    function __get($name) {
        try {
            if(isset($this->data[$name])) {
               return $this->data[$name]; 
            } else {
                throw new Exception('Try to get undefined value ['.$name.'] in class ['.__CLASS__.']');  
            };
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }
    }
    
    function __set($name, $value) {
        Logger::error('Can\'t set i18n value ['.$name.'] = ['.$value.'] in class ['.__CLASS__.']');
    }
    
    function __call($name, $values) {
        Logger::error('Method ['.$name.'] not isset in class ['.__CLASS__.']');
    }
}