<?php
class DRM {
    static public $values;
    
    static function run($config) {
        include_once(PATH.'.config/routes.php');
        include_once(PATH.'.config/user_status.php');

        self::registry()->config = $config;
        self::registry()->routes = $routes;
        self::registry()->user_status = $user_status;
        if(self::db()->connect()) {
            self::db()->connect();
            self::registry()->config += array('DB-connected' => true);
            self::registry()->config += self::db()->table('config')->select()->where('`id` = 1')->limit(1)->fetch();
            new Session();
        } else {
            self::registry()->config += array('DB-connected' => false);
        };
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