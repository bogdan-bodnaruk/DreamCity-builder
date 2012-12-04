<?php
class Controller_logout extends Controller {
    public function index() {
        if($this->registry()->config['DB-connected']) {
            User::login($_SESSION['login'])->edit(array('online'=>0));
        };
        session_destroy();
        Go::reload($this->registry()->config['base_href'].$this->registry()->config['main_page']);
    }
}