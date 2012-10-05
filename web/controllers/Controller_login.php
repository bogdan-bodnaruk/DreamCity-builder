<?php
class Controller_login extends Controller {
    public function __construct() {
        parent::__construct();
        if($this->registry()->config['DB-connected']) {
            $this->val['db-message-enable'] = 'false';
        };
        $this->val['login_error'] = 'false';
        $this->val['pass_error'] = 'false';
    }

	public function index() {

        if($_POST && $this->template()->post_is_valide()) {
            if(!$this->registry()->config['DB-connected']) {
                if($this->template()->validate('login')==$this->registry()->config['admin_login']
                    &&
                    md5($this->template()->validate('password'))==$this->registry()->config['admin_pass']) {
                    $_SESSION['status'] = 'admin';
                    $_SESSION['login'] = $this->template()->validate('login');
                    Go::to('install');
                } elseif($this->template()->validate('login')!==$this->registry()->config['admin_login']) {
                    $this->val['login_error'] = 'true';
                } elseif(md5($this->template()->validate('password'))!==$this->registry()->config['admin_pass']) {
                    $this->val['pass_error'] = 'true';
                };
            } else {
                if($this->db()->table('users')->select()->where('`login` = \''.$this->template()->validate('login').'\'')->limit(1)->num() == 0) {
                    $this->val['login_error'] = 'true';
                };

                $login = $this->db()
                              ->table('users')
                              ->select()
                              ->where('`login` = \''.$this->template()->validate('login').'\'')
                              ->andwhere('`password` = \''.md5(md5($this->template()->validate('login').$this->template()->validate('password'))).'\'')
                              ->limit(1)
                              ->num();

                $login == 0 ? $this->val['pass_error'] = 'true' : '';
                $this->template()->load('login.tpl')->show();

                if($this->template()->validate('login') == 1 && $_SESSION['status'] == 'guest') {
                    $_SESSION['code_user'] = $this->template()->hash(15);
                    $_SESSION['login'] = $this->template()->validate('login');
                    setcookie('l',md5($_SESSION['login']),time()+2678400);
                    setcookie('uid',md5($this->template()->validate('login').md5($_SERVER['REMOTE_ADDR'].$_SESSION['login'])),time()+2678400);
                    User::login($_SESSION['login'])
                            ->edit(array( 'online'      =>  'now()',
                                          'code_user'   =>  $_SESSION['code_user'],
                                          'last_login'  =>  'now()',
                                          'hash'        =>  md5($_SESSION['code_user'].$_SERVER['REMOTE_ADDR'].$_SESSION['login'])
                            ));
                    Go::reload();
                };
            };
        };
        isset($_SESSION['login']) ? Go::main() : $this->template()->load('login.tpl')->main();
	}

	public function reminder() {
		if($_POST && $this->template()->post_is_valide()) {
			$this->template()->load('All good!')->show();
		} else { 
			$this->template()->load('reminder.tpl')->show();
		};
	}

    public function logout() {
        if($this->registry()->config['DB-connected']) {
            User::login($_SESSION['login'])->edit(array('online'=>0));
            setcookie('uid', '');
            setcookie('l', '');
        }
        session_destroy();
        Go::reload($this->registry()->config['base_href'].$this->registry()->config['main_page']);
    }
}