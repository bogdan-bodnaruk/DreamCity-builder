<?php
class Session extends DRM {  
    function __construct() {
        $_SESSION['status'] = empty($_SESSION['login']) || !isset($_SESSION['login']) ?  'guest' : $this->check();
        $this->registry()->config['statistic'] && !isset($_COOKIE['statistic']) ? $this->statistic() : '';
    }
    
    private function check() {
        $data = $this->db()
                     ->table('users')
                     ->select(array('status','code_user','login'))
                     ->where('hash = \''.md5($_SESSION['code_user'].$_SERVER['REMOTE_ADDR'].$_SESSION['login']).'\'')
                     ->limit(1)
                     ->fetch();
                     
        if($data['code_user']==$_SESSION['code_user'] && $data['login']==$_SESSION['login']) {
            $this->db()
                 ->table('users')
                 ->update(array('online' => 'now()'))
                 ->where('login = "'.$_SESSION['login'].'"')
                 ->limit(1)
                 ->query();
                 
            $this->db()
                 ->table('users')
                 ->update(array('online' => '0'))
                 ->where('`online`<SUBTIME(NOW(),\'0 0:00:30\')')
                 ->query();
                 
            return $data['status'];
        } else {
            Go::to('logout');
        };
    }
    
    private function statistic() {
        $check = $this->db()
                    ->table('statistic')
                    ->select()
                    ->where('`ip` = \''.$_SERVER['REMOTE_ADDR'].'\'')
                    ->andwhere('`date` = \''.date("Y-m-d").'\'')
                    ->limit(1)
                    ->num();
        if($check == 0) {
            $this->db()
                 ->table('statistic')
                 ->insert(array('date'    =>  date("Y-m-d"),
                                'ip'      =>  $_SERVER['REMOTE_ADDR'],
                                'referer' =>  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                                'country' =>  'geoIP'))
                 ->query();
            setcookie("statistic", 'true', time()+7200);
        };
    }
}