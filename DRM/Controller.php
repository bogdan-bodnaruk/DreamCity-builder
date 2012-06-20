<?php
abstract class Controller extends DRM {
    public $val;
    public $i18n;
    public $lang;
    
    function __construct() {
        $this->val = &parent::$values; 
        $this->i18n = &$this->i18n();
        $this->lang = isset($_COOKIE['i18n']) ? $_COOKIE['i18n'] : $this->registry()->config['default_i18n'];
        $this->bootstrap();
        $this->lang();
    }
    
    function val($type) {
        for($i=2; $i<count($this->registry()->values)+2; $i++) {
            if(preg_match('/'.$type.'\=[0-9a-zA-Z]+/', $this->registry()->values[$i])) {
                list($text, $this->val[$type]) = explode('=', $this->registry()->values[$i]);
                return $this->val[$type];
            };
        }
    }
    
    private function lang() {
        if(isset($_GET['lang'])) {
            $lang = strtr($_GET['lang'], array('%2F'=>'','/'=>''));
            for($i=0;$i<count($this->registry()->config['all_i18n']);$i++) {
                if($this->registry()->config['all_i18n'][$i]==$lang) {
                    setcookie('i18n', $lang, time()+36000, '/');
                    Go::reload($_SERVER['HTTP_REFERER']);
                };
            }
        };
    }
    
    function bootstrap() {
        
        $this->val['login_logout'] = User::login()->permissions()>0
        ? '<a href="profile/">'.$_SESSION['login'].'&nbsp;<img src="'.$this->registry()->config['app_path'].'/theme/images/Profile.png" style="margin-bottom: -2px;" height="17" alt="" /></a>&nbsp;|&nbsp;<a href="login/logout/">'.$this->i18n->logout.'&nbsp;<img src="'.$this->registry()->config['app_path'].'/theme/images/logout.png" style="margin-bottom: -2px;" height="14" alt="" /></a>'
        : '<a href="login">'.$this->i18n->enter.'</a>&nbsp;|&nbsp;<a href="registration">'.$this->i18n->registration.'</a>';
                
        $this->val['adminpanel'] = User::login()->permissions()>50 ? '<div id="adminpanel" onClick="open_panel()" >&nbsp;'.$this->i18n->adminpanel.'</div>' : '';
        
        $this->val['js'] = $this->registry()->config['ajax']=='1' ? '<script type="text/javascript" src="/library/jquery.form.js"></script><script type="text/javascript" src="/library/ajax.js"></script>' : '';
        User::login()->permissions()>50 ? $this->val['js'] .= '<script type="text/javascript" src="/library/ckeditor/ckeditor.js"></script>' : '';
        $news = $this->db()->table('news')->select()->where('`protect`<=\''.User::login()->permissions().'\'')->order('id', 'desc')->limit(3)->query();
        $data_news_main = '';
        while ($this->val['data_news'] = mysql_fetch_array($news)) {
            $data_news_main .= $this->template()->load('DRM/views/news_sidebar.tpl')->return_data();    
        }
        $this->val['last_news'] = '<div class="title"><a href="index/">'.$this->i18n->news.'</a></div>'.$data_news_main;
        
        $this->val['nav_head_1'] = '';
        $this->val['bottom_nav_head_1'] = '<div class="bottom_menu bottom_main_right">';
        $nav_head_1 = $this->db()->table('menu')->select('id')->where('`type`=\'head_1\'')->andwhere('`lang`=\''.$this->lang.'\'')->limit(1)->fetch();
        $nav_head_route = $this->db()->table('route')->select()->where('`menu_id`=\''.$nav_head_1['id'].'\'')->order('id`+`position', 'DESC')->query();
        while($head_1 = mysql_fetch_array($nav_head_route)) {
            $this->val['nav_head_1'] .= '<a href="'.$head_1['route'].'"><div>'.$head_1['name'].'</div></a>';
            $this->val['bottom_nav_head_1'] .= '<a href="'.$head_1['route'].'">'.$head_1['name'].'</a>';
        }
        $this->val['bottom_nav_head_1'] .= '</div>';
        
        $this->val['nav_head_2'] = '';
        $nav_head_2 = $this->db()->table('menu')->select('id')->where('`type`=\'head_2\'')->andwhere('`lang`=\''.$this->lang.'\'')->limit(1)->fetch();
        $nav_head_2_route = $this->db()->table('route')->select()->where('`menu_id`=\''.$nav_head_2['id'].'\'')->order('id`+`position', 'DESC')->query();
        while($head_2 = mysql_fetch_array($nav_head_2_route)) {
            $this->val['nav_head_2'] .= ' <a href="'.$head_2['route'].'"><div>'.$head_2['name'].'</div></a>';
        }
        
        $this->val['nav_normal'] = '';
        $nav_normal = $this->db()->table('menu')->select()->where('`type`=\'normal\'')->andwhere('`lang`=\''.$this->lang.'\'')->query();
        while($normal = mysql_fetch_array($nav_normal)) {
            $this->val['nav_normal'] .= '<div class="bottom_menu"><h2>'.$normal['name'].'</h2>';
            $nav_link = $this->db()->table('route')->select()->where('`menu_id`=\''.$normal['id'].'\'')->order('id`+`position')->query();
            while($data_nav_link = mysql_fetch_array($nav_link)) {
                $this->val['nav_normal'] .= '<p><a href="'.$data_nav_link['route'].'">'.$data_nav_link['name'].'</a></p>';
            }
            $this->val['nav_normal'] .= '</div>';
        }
        
        $this->val['baners'] = '';
        $baners = $this->db()->table('banners')->select()->where('`side`=\'Right\' AND `lang`=\''.$this->lang.'\'')->order('id`+`position')->query();
        while($data_baners = mysql_fetch_array($baners)) {
            $this->val['baners'] .= $data_baners['code'];
        }
    }
    
    abstract function index();
}