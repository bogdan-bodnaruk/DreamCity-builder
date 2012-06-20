<?php
class Controller_block extends Controller {
    function index() {
        $this->template()->load('./'.$this->registry()->config['app_path'].'/views/block.tpl')->ajax();
    }
    
    public function enter() {
        if($_POST) {
            $user_login = preg_match('/[\'\^\"\#\|\!\$\%\&\*\>\<\}\{\]\[\~\`\;\/\\]]+/', $_POST['login']) ? '' : $_POST['login'];
            $user_passowrd = preg_match('/[\'\^\"\#\|\!\$\%\&\*\>\<\}\{\]\[\~\`\;\/\\]]+/', $_POST['password']) ? '' : $_POST['password'];

            $login = $this->db()
                          ->table('users')
                          ->select()
                          ->where('`login` = \''.$user_login.'\'')
                          ->andwhere('`password` = \''.md5(md5($user_login.$user_passowrd)).'\'')
                          ->limit(1)
                          ->num();           
            if($login == 1 && $_SESSION['status'] == 'guest') {
                $_SESSION['code_user'] = 12345;
                $_SESSION['login'] = $user_login;
                setcookie('l',md5($_SESSION['login']),time()+2678400);
                setcookie('uid',md5($this->template()->validate('login').md5($_SERVER['REMOTE_ADDR'].$_SESSION['login'])),time()+2678400);
                User::login($_SESSION['login'])
                    ->edit(array('online'=>'now()','code_user'=>$_SESSION['code_user'],'last_login'=>'now()','hash'=>md5($_SESSION['code_user'].$_SERVER['REMOTE_ADDR'].$_SESSION['login'])));
                Go::reload();
            };
        };
    }
}