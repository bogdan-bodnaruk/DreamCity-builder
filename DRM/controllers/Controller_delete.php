<?php
class Controller_delete extends Controller {
    function __construct() {
        parent::__construct();
        User::login()->permissions()==99 ? '' : Go::main();
    }
    
    function index() {
        Go::back();
    }
    
    function news() {
        $this->val('id');
        $name = $this->db()->table('news')->select('theme')->where('`id` = \''.$this->val['id'].'\'')->fetch();
        $this->db()->table('news')->delete()->where('`id` = \''.$this->val['id'].'\'')->query();
        Logger::update($_SESSION['login'].' was deleted news '.$name['theme']);
        Go::back();
    }
    
    function page() {
        $this->val('id');
        $name = $this->db()->table('pages')->select('theme')->where('`id` = \''.$this->val['id'].'\'')->fetch();
        $this->db()->table('pages')->delete()->where('`id` = \''.$this->val['id'].'\'')->query();
        Logger::update($_SESSION['login'].' was deleted page '.$name['theme']);
        Go::back();
    }
    
    function banner() {
        $this->val('id');
        $name = $this->db()->table('banners')->select(array('theme', 'id'))->where('`id` = \''.$this->val['id'].'\'')->fetch();
        $this->db()->table('banners')->delete()->where('`id` = \''.$this->val['id'].'\'')->query();
        Logger::update($_SESSION['login'].' was deleted banner '.empty($name['theme']) ? 'where id = '.$name['id'] : $name['theme']);
        Go::back();
    }
    
    function user() {
        $this->val('id');
        $name = $this->db()->table('users')->select('login')->where('`id`=\''.$this->val['id'].'\'')->limit(1)->fetch();
        $this->db()->table('users')->delete()->where('`id`=\''.$this->val['id'].'\'')->limit(1)->query();
        Logger::update($_SESSION['login'].' deleted user '.$name['login']);
        Go::back();
    }
}