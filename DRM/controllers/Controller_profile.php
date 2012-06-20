<?php
class Controller_profile extends Controller {
    function __construct() {
        parent::__construct();
        $this->val['country_val'] = $this->i18n->country_val;
        $this->val['country_text'] = $this->i18n->country_text;
        $this->val['data'] = $this->db()->table('users')->select()->where('`login`=\''.$_SESSION['login'].'\'')->limit(1)->fetch();
    }
    
    function index() {
        !isset($_SESSION['login']) ? Go::to('login/logout/') : $this->template()->load('profile.tpl')->show();
    }
    
    function save() {
        $this->template()->load('profile.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('users')
                 ->update(array('email'    =>  $this->template()->validate('email'),
                                'name'     =>  $this->template()->validate('name'),
                                'sename'   =>  $this->template()->validate('se_name'),
                                'country'  =>  $this->template()->validate('country'),
                                'city'     =>  $this->template()->validate('city'),
                                'phone'    =>  $this->template()->validate('phone')))
                 ->where('`login` = \''.$_SESSION['login'].'\'')
                 ->limit(1)
                 ->query();
                 
            if(md5(md5($_SESSION['login'].$this->template()->validate('old_password')))==$this->val['data']['password']) {
                $this->db()
                 ->table('users')
                 ->update(array('password'  =>  md5(md5($_SESSION['login'].$this->template()->validate('password')))))
                 ->where('`login` = \''.$_SESSION['login'].'\'')
                 ->limit(1)
                 ->query();
            };
            Go::to('profile/done/');
        } else {
            $this->index();  
        };
    }
    
    function done() {
        $this->template()->load('<p class="success">'.$this->i18n->saved.'</p>')->show();
    }
}