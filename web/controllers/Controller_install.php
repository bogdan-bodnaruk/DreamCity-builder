<?php
class Controller_install extends Controller {
    public function __construct() {
        parent::__construct();
        $this->registry()->config['DB-connected'] ? Go::main() : '';
        $this->registry()->main_page = 'install/main.tpl';
    }

    public function index() {
        if(@mysql_connect($this->registry()->config['db_host'], $this->registry()->config['db_user'], $this->registry()->config['db_password'])) {
            Go::to('install/create_db/');
        } else {
            $this->template()->load('install/db_connect.tpl')->main();
        };
    }

    public function create_db() {
        $this->template()->load('install/create_db.tpl')->main();
    }
}