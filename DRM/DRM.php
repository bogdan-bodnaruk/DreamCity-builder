<?php
class DRM {
    static public $values;

    static function run($config) {
        include_once(PATH.'.config/routes.php');
        include_once(PATH.'.config/user_status.php');
        self::registry()->config = $config;
        self::registry()->routes = $routes;
        self::registry()->user_status = $user_status;
        self::db()->connect();
        new Session();
        new Router();
    }
    
    public function registry() {
        return Registry::get_instance();
    }
    
    public function db() {
        return new DB();
    }
    
    public function i18n() {
        return new i18n();
    }
    public function template() {
        return new Template();
    }
}