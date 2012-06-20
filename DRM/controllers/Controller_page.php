<?php
class Controller_page extends Controller {
    private $id;
    private $theme;
    
    function __construct() {
        parent::__construct();
        if(count($this->registry()->values)>=1) {
            $value = $this->registry()->values[count($this->registry()->values)+1];

            if(preg_match('/[0-9]+/',$value)) {
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
        $num = $this->db()->table('pages')->select()->where($where)->limit(1)->num();
        if($num == 0) {
            Go::to('404');
        } else {
            $this->val['page'] = $this->db()->table('pages')->select()->where($where)->limit(1)->fetch();
            
            if($this->val['page']['protect']<=User::login()->permissions()) {
                $this->template()->load('page.tpl')->show();
            } elseif($this->val['page']['protect']=='1' && $this->val['page']['protect']>User::login()->permissions()) {
                $this->template()->load('register_to_view.tpl')->show();
            } else {
                Go::to('404');
            };
        };
    }
    
}