<?php
class Controller_menu extends Controller {
    function __construct() {
        parent::__construct();
        $this->val['value'] = array('head_1', 'head_2', 'normal');
        $this->val['text_type'] = $this->i18n->type_menu;
        User::login()->permissions()<99 ? Go::main() : '';
    }
    
    function index() {
        $this->val['table'] = Paginator::tpl('menu_list_paginate.tpl')->table('menu')->order('id', 'desc')->load();
        $this->template()->load('menu_list.tpl')->show();
    }
    
    function add() {
        $this->template()->load('add_menu.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('menu')
                 ->insert(array('name'      =>  $this->template()->validate('name'),
                                'lang'      =>  $this->template()->validate('lang'),
                                'protect'   =>  $this->template()->validate('protect'),
                                'type'      =>  $this->template()->validate('type')))
                 ->query();
            Go::to('menu/saved/');
        };
        $this->template()->load('add_menu.tpl')->show();
    }
    
    function edit() {
        $this->val('id');
        $this->val['data'] = $this->db()->table('menu')->select()->where('`id`=\''.$this->val['id'].'\'')->fetch();
        $this->template()->load('edit_menu.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('menu')
                 ->update(array('name'      =>  $this->template()->validate('name'),
                                'lang'      =>  $this->template()->validate('lang'),
                                'protect'   =>  $this->template()->validate('protect'),
                                'type'      =>  $this->template()->validate('type')))
                 ->where('`id`=\''.$this->val['id'].'\'')
                 ->limit(1)
                 ->query();
            Go::to('menu/saved/');
        };
        $this->template()->load('edit_menu.tpl')->show();
    }
    
    function delete() {
        $this->val('id');
        $this->db()
             ->table('menu')
             ->delete()
             ->where('`id`=\''.$this->val['id'].'\'')
             ->query();
        Go::to('menu/');
    }
    
    function info() {
        $this->val('id');
        $this->val['table'] = Paginator::tpl('menu_info_paginate.tpl')->table('route')->where('`menu_id`=\''.$this->val['id'].'\'')->order('id`+`position', 'desc')->load();
        $this->template()->load('menu_info.tpl')->show();
    }
    
    function saved() {
        $this->template()->load('<script>fade_alert()</script><p class="success">'.$this->i18n->saved.'</p>')->show();
        $this->index();
    }
    
    function add_route() {
        $this->val('id');
        $this->template()->load('add_route.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('route')
                 ->insert(array('name'      =>  $this->template()->validate('name'),
                                'route'     =>  $this->template()->validate('route'),
                                'menu_id'   =>  $this->val['id']))
                 ->query();
            Go::to('menu/info/id='.$this->val['id']);
        };
        $this->template()->load('add_route.tpl')->show();
    }
    
    function edit_route() {
        $this->val('id');
        $this->val('list');
        
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('route')
                 ->update(array('name'      =>  $_POST['name'],
                                'route'     =>  $_POST['route']))
                 ->where('`id` = \''.$this->val['id'].'\'')
                 ->limit(1)
                 ->query();
            Go::to('menu/saved_route/id='.$this->val['list'].'/');
        } else {
            $this->info();
        };
    }
    
    function delete_route() {
        $this->val('id');
        $this->val('list');
        
        $this->db()
             ->table('route')
             ->delete()
             ->where('`id` = \''.$this->val['id'].'\'')
             ->limit(1)
             ->query();
        Go::to('menu/info/id='.$this->val['list']);
    }
    
    function saved_route() {
        $this->val('id');
        $this->template()->load('<script>fade_alert();history.replaceState(null,null,"menu/info/id='.$this->val['id'].'/");</script>
                                 <p class="success">'.$this->i18n->saved.'</p>')->show();
        $this->info();
    }
    
    function up_route() {
        $this->val('id');
        $this->val('list');
        
        $count = $this->db()
                      ->table('route')
                      ->select('position')
                      ->where('`id`= \''.$this->val['id'].'\'')
                      ->limit(1)
                      ->fetch();
        
        $this->db()
             ->table('route')
             ->update(array('position' =>   $count['position']+1))
             ->where('`id`= \''.$this->val['id'].'\'')
             ->limit(1)
             ->query();
        Go::to('menu/saved_route/id='.$this->val['list'].'/');
    }
    
        
    function down_route() {
        $this->val('id');
        $this->val('list');
        
        $count = $this->db()
                      ->table('route')
                      ->select('position')
                      ->where('`id`= \''.$this->val['id'].'\'')
                      ->limit(1)
                      ->fetch();
        
        $this->db()
             ->table('route')
             ->update(array('position' =>   $count['position']-1))
             ->where('`id`= \''.$this->val['id'].'\'')
             ->limit(1)
             ->query();
        Go::to('menu/saved_route/id='.$this->val['list'].'/');
    }
}