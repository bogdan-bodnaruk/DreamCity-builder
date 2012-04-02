<?php
class Registry {
    static public $data = array();
    private static $instance;
    
    public static function get_instance() {
        if (empty(self::$instance)) {
            self::$instance = new Registry();
        };
        return self::$instance;
    }
    
    public function __clone() {
        die('Cloning the registry is not permitted');
    }
    
    function __get($name) {
        try {
            if(!isset(self::$data[$name])) {
                throw new Exception('Try get acces to undefined value ['.$name.'] in Registry');
            } else {
                return self::$data[$name];
            }
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }
    }
    
    function __set($name, $value) {
        self::$data[$name] = $value;
    }

    /*
     * @param Register::get('name', str ['sub_name']); Get some value from register
     * @param $sub_name use if you want get some  element from array
     * @return assoc array (array('url' =>  'index'), etc)
     */
    
    public function get($name, $sub_name = '') {
         if(empty($sub_name)) {
                return self::$data[$name];
         } elseif(!empty($sub_name) && isset(self::$data[$name][$sub_name])) {
                return self::$data[$name][$sub_name];
        } else {
            Logger::error('Try get acces to undefined value ['.$name.'] in Registry');
            return false;
        };
    }
}