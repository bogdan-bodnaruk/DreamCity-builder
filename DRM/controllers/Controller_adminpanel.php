<?php
class Controller_adminpanel extends Controller {
    public function __construct() {
        parent::__construct();
        User::permissions()!==99 ? Go::mail() : '';
    }
    
    public function index() {
        $this->template()->load('adminpanel.tpl')->show();
    }
    
    public function ajax() {
        $this->val['count_apply'] = $this->db()->table('apply')->select()->where('`status` = \'apply\'')->num();
        $this->template()->load('adminpanel_ajax.tpl')->ajax();
    }
}