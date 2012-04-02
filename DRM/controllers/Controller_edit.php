<?php
class Controller_edit extends Controller {
    function __construct() {
        parent::__construct();
        User::login()->permissions()>50 ? '' : Go::main();
        $this->val['comments'] = array('Yes', 'No'); //fix me!//
    }
    
    public function index() {
        Go::to('adminpanel');
    }
    
    public function news() {
        $this->val('id');
        
        if($this->db()->table('news')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->num()==1) {
            $data = $this->db()->table('news')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->fetch();
        } else {
            Go::to('edit/no_such_page/');
        };

        foreach($data as $key=>$value) {
            $this->val[$key] = $value;
        }
        
        $this->template()->load('edit_news.tpl')->show();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('news')
                 ->update(array('theme'         =>  $this->template()->validate('theme'),
                                'short_text'    =>  $this->template()->validate('short_text'),
                                'full_text'     =>  $this->template()->validate('full_text'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'comment'       =>  $this->template()->validate('comment'),
                                'url'           =>  $this->template()->url('news')))
                 ->where('`id` = \''.$this->val['id'].'\'')
                 ->limit(1)
                 ->query();
            Logger::update($_SESSION['login'].' was edit <a href="/news/'.$this->template()->url('news').'">'.$this->template()->validate('theme').'</a>');
            Go::to('edit/saved/');
        };
    }
    
    public function page() {
        $this->val('id');
        
        if($this->db()->table('pages')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->num()==1) {
            $data = $this->db()->table('pages')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->fetch();
        } else {
            Go::to('edit/no_such_page/');
        };

        foreach($data as $key=>$value) {
            $this->val[$key] = $value;
        }
        $this->template()->load('edit_page.tpl')->show();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('pages')
                 ->insert(array('theme'         =>  $this->template()->validate('theme'),
                                'text'          =>  $this->template()->validate('text'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'comment'       =>  $this->template()->validate('comment'),
                                'url'           =>  $this->template()->url('pages')))
                 ->query();
            Logger::update($_SESSION['login'].' was edit <a href="/page/'.$this->template()->url('pages').'">'.$this->template()->validate('theme').'</a>');
            Go::to('edit/saved/');
        };
    }
    
    public function banner() {
        $this->val['side'] = array('Left', 'Right', 'Hidden');
        $this->template()->load('add_banner.tpl')->show();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('banners')
                 ->insert(array('theme'         =>  $this->template()->validate('theme'),
                                'code'          =>  $_POST['code'],
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'time'          =>  'NOW()',
                                'author'        =>  $_SESSION['login']))
                 ->query();
            Logger::update($_SESSION['login'].' was add new banner.');
            Go::to('add/saved/');
        };
    }
    
    public function saved() {
        $this->template()->load('Saved.tpl')->show();
    }
    
    public function no_such_page() {
        $this->template()->load('no_such_page.tpl')->show();
    }
}