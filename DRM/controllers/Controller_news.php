<?php
class Controller_news extends Controller {
    private $id;
    private $theme;
    
    function __construct() {
        parent::__construct();
        if(count($this->registry()->values)>=1) {
            $value = $this->registry()->values[count($this->registry()->values)+1];

            if(!preg_match('/[\w\-\_]+/',$value)) {
                $this->id = (int)$value;
            } else {
                $this->theme = $value;
            };
        };
    }
    
    function index() {
        $this->__construct();
        if(!empty($this->id)) {
            $where = '`id` = \''.$this->id.'\'';
        } elseif(!empty($this->theme)) {
            $where = 'LOWER(`url`) = LOWER(\''.$this->theme.'\')';
        } else {
            $where = '1=1';
        };
        $num = $this->db()->table('news')->select()->where($where)->limit(1)->num();
        if($num == 0) {
            Go::to('404');
        } else {
            $this->val['news'] = $this->db()->table('news')->select()->where($where)->limit(1)->fetch();
            
            if($this->val['news']['protect']<=User::login()->permissions()) {
                $this->template()->load('news.tpl')->show();
            } elseif($this->val['news']['protect']=='1' && $this->val['news']['protect']>User::login()->permissions()) {
                $this->template()->load('register_to_view.tpl')->show();
            } else {
                Go::to('404');
            };
        };
    }
    
}