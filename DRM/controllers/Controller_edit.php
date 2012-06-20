<?php
class Controller_edit extends Controller {
    function __construct() {
        parent::__construct();
        User::login()->permissions()>50 ? '' : Go::main();
        $this->val['comment'] = array('Yes', 'No'); //fix me!//
    }
    
    public function index() {
        Go::to('adminpanel');
    }
    
    public function news() {
        $this->val('id');
        
        $this->db()->table('news')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->num()==1
            ? $this->val['data'] = $this->db()->table('news')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->fetch()
            : Go::to('edit/no_such_page/');
        
        $this->template()->load('edit_news.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('news')
                 ->update(array('theme'         =>  $this->template()->validate('theme'),
                                'short_text'    =>  strtr($_POST['text'], array('\\'=>'')),
                                'full_text'     =>  strtr($_POST['full_text'], array('\\'=>'')),
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
        $this->template()->load('edit_news.tpl')->show();
    }
    
    public function page() {
        $this->val('id');
        
        $this->db()->table('pages')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->num()==1
            ? $this->val['data'] = $this->db()->table('pages')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->fetch()
            : Go::to('edit/no_such_page/');
            
        $this->val['selected'] = '';
        
        $menu = $this->db()->table('menu')->select(array('id', 'name'))->query();
        while($data = mysql_fetch_array($menu)) {
            $this->val['mid'][] = $data['id'];
            $this->val['name'][] = $data['name'];
        }
        
        $selected = $this->db()->table('route')->select(array('menu_id','id'))->where('`name` = \''.$this->val['data']['theme'].'\'')->limit(1)->fetch();
        $this->val['selected'] = $selected['menu_id'];
        
        $this->template()->load('edit_page.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $url = $this->template()->url('pages');
            $this->db()
                 ->table('pages')
                 ->update(array('theme'         =>  $this->template()->validate('theme'),
                                'text'          =>  strtr($_POST['text'], array('\\'=>'')),
                                'protect'       =>  $this->template()->validate('protect'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'comment'       =>  $this->template()->validate('comment'),
                                'url'           =>  $url))
                 ->where('`id` = \''.$this->val['id'].'\'')
                 ->limit(1)
                 ->query();
                 
            $this->db()
                 ->table('route')
                 ->update(array('name'      =>  $this->template()->validate('theme'),
                                'menu_id'   =>  $this->template()->validate('menu'),
                                'route'     =>  'page/'.$url))
                 ->where('`id` = \''.$selected['id'].'\'')
                 ->limit(1)
                 ->query();
            Logger::update($_SESSION['login'].' was edit <a href="/page/'.$this->template()->url('pages').'">'.$this->template()->validate('theme').'</a>');
            Go::to('edit/saved/');
        };
        $this->template()->load('edit_page.tpl')->show();
    }
    
    public function banner() {
        $this->val['side'] = array('Left', 'Right', 'Hidden');
        $this->val('id');
        
        $this->db()->table('banners')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->num()==1
            ? $this->val['data'] = $this->db()->table('banners')->select()->where('`id` = \''.$this->val['id'].'\'')->limit(1)->fetch()
            : Go::to('edit/no_such_page/');
            
        $this->template()->load('edit_banner.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('banners')
                 ->update(array('theme'         =>  $this->template()->validate('theme'),
                                'code'          =>  $this->template()->validate('code'),
                                'protect'       =>  $this->template()->validate('protect'),
                                'side'          =>  $this->template()->validate('side'),
                                'lang'          =>  $this->template()->validate('lang'),
                                'time'          =>  'NOW()',
                                'author'        =>  $_SESSION['login']))
                 ->where('`id` = \''.$this->val['id'].'\'')
                 ->limit(1)
                 ->query();
            Logger::update($_SESSION['login'].' was add new banner.');
            Go::to('add/saved/');
        };
        $this->template()->load('edit_banner.tpl')->show();
    }
    
    public function saved() {
        $this->template()->load('Saved.tpl')->show();
    }
    
    public function no_such_page() {
        $this->template()->load('no_such_page.tpl')->show();
    }
}