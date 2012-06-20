<?php
class Controller_users extends Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->val['table'] = Paginator::tpl('users_paginate.tpl')->table('users')->order('id', 'desc')->load();
        $this->template()->load('users.tpl')->show();
    }
    
    function permissions() {
        $this->val('id');
        $protect = array_flip($this->registry()->user_status);
        $this->db()
             ->table('users')
             ->update(array('status'=>$protect[$_POST['protect']]))
             ->where('`id`=\''.$this->val['id'].'\'')
             ->limit(1)
             ->query();
       Go::back();
    }
}