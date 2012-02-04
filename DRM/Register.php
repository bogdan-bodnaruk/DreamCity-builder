<?php
final class Register {
    static public $data = array();
    static public $obj;

    /*
     * @param Register::set($value, 'name'); Set some global value
     * @return none;
     */
    
    public function set($data, $name) {
        self::$data[$name] = $data;
    }
    
    /*
     * @param Register::get('name', str ['sub_name']); Get some value from register
     * @param $sub_name use if you want get some  element from array
     * @return assoc array (array('url' =>  'index'), etc)
     */
    
    public function get($name, $sub_name = '') {
        return empty($sub_name)
                ? self::$data[$name]
                : self::$data[$name][$sub_name];
    }
    
    /*
     *  @param Register::data()->set($data, 'name');
     *  @param Register::data()->get('name');
     *  @param Make values visible in other classes
     *  @return object Registry
     */
    
    function data() {
        if (!isset(self::$obj)) {
            $class = __CLASS__;
            self::$obj = new $class();
        };
        return self::$obj;
    }
}