<?php
class Controller_login extends Controller {
    public function index() {
        isset($_SESSION['login']) ? Go::main() : $this->template()->load('login.tpl')->show();
    }
    
    public function enter() {
        $login = $this->db()
                      ->table('users')
                      ->select()
                      ->where('`login` = \''.$_POST['login'].'\'')
                      ->andwhere('`password` = \''.md5(md5($_POST['login'].$_POST['password'])).'\'')
                      ->limit(1)
                      ->num();
        if($login == 1 && $_SESSION['status'] == 'guest') {
            $_SESSION['code_user'] = 12345;
            $_SESSION['login'] = $_POST['login'];
            setcookie('l',md5($_SESSION['login']),time()+2678400);
            setcookie('uid',md5($_POST['login'].md5($_SERVER['REMOTE_ADDR'].$_SESSION['login'])),time()+2678400);
            User::login($_SESSION['login'])
                ->edit(array('online'=>'now()','code_user'=>$_SESSION['code_user'],'hash'=>md5($_SESSION['code_user'].$_SERVER['REMOTE_ADDR'].$_SESSION['login'])));
        };
        Go::to('login');
    }
    
    public function logout() {
        User::login($_SESSION['login'])->edit(array('online'=>0));
        session_destroy();
        setcookie('uid', '');
        setcookie('l', '');
        Go::back();
    }
}