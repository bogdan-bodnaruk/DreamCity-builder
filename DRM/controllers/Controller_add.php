<?php
class Controller_add extends Controller {
    
    function __construct() {
        parent::__construct();
        User::login()->permissions()>50 ? '' : Go::main();
        $this->val['comment'] = array('Yes', 'No'); //fix me!//
    }
    
    public function index() {
        Go::to('adminpanel');
    }
    
    public function news() {
        $this->template()->load('add_news.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('news')
                 ->insert(array('theme'         =>  $this->template()->validate('theme'),
                                'short_text'    =>  $this->template()->validate('short_text'),
                                'full_text'     =>  $this->template()->validate('full_text'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'time'          =>  'NOW()',
                                'author'        =>  $_SESSION['login'],
                                'comment'       =>  $this->template()->validate('comment'),
                                'url'           =>  $this->template()->url('news')))
                 ->query();
            Logger::update($_SESSION['login'].' was add <a href="/news/'.$this->template()->url('news').'">'.$this->template()->validate('theme').'</a>');
            Go::to('add/saved/');
        };
        $this->template()->load('add_news.tpl')->show();
    }
    
    public function page() {
        $menu = $this->db()->table('menu')->select(array('id', 'name'))->query();
        while($data = mysql_fetch_array($menu)) {
            $this->val['id'][] = $data['id'];
            $this->val['name'][] = $data['name'];
        }
        
        $this->template()->load('add_page.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $url = $this->template()->url('pages');
            $this->db()
                 ->table('pages')
                 ->insert(array('theme'         =>  $this->template()->validate('theme'),
                                'text'          =>  $this->template()->validate('text'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'time'          =>  'NOW()',
                                'author'        =>  $_SESSION['login'],
                                'comment'       =>  $this->template()->validate('comment'),
                                'url'           =>  $url))
                 ->query();
            $this->db()
                 ->table('route')
                 ->insert(array('name'      =>  $this->template()->validate('theme'),
                                'menu_id'   =>  $this->template()->validate('menu'),
                                'route'     =>  'page/'.$url))
                 ->query();
            Logger::update($_SESSION['login'].' was add <a href="/page/'.$this->template()->url('pages').'">'.$this->template()->validate('theme').'</a>');
            Go::to('add/saved/');
        };
        $this->template()->load('add_page.tpl')->show();
    }
    
    public function banner() {
        $this->val['side'] = array('Right', 'Hidden');
        $this->template()->load('add_banner.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('banners')
                 ->insert(array('theme'         =>  $this->template()->validate('theme'),
                                'code'          =>  $this->template()->validate('code'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'time'          =>  'NOW()',
                                'side'          =>  $this->template()->validate('side'),
                                'author'        =>  $_SESSION['login']))
                 ->query();
            Logger::update($_SESSION['login'].' was add new banner.');
            Go::to('add/saved/');
        };
        $this->template()->load('add_banner.tpl')->show();
    }
    
    public function saved() {
        $this->template()->load('Saved.tpl')->show();
    }
}