<?php
class Controller_login extends Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->registry()->config['DB-connected']) {
            $this->val['db-not-connected-message'] = '<div class="db_not_connected">'.$this->i18n()->db_not_connected.'</div>';
        };
    }

	public function index() {

        if($_POST && $this->template()->post_is_valide()) {
            if(!$this->registry()->config['DB-connected']) {
                if($this->template()->validate('login')==$this->registry()->config['admin_login']
                    &&
                    md5($this->template()->validate('password'))==$this->registry()->config['admin_pass']) {

                    $_SESSION['login'] = $this->template()->validate('login');
                    Go::to('adminpanel');
                } else {
                    // TODO: Fix it or create new tag
                    $this->val['error'] = '<span id="login" class="drm-error">i<span class="tooltip">Wrong login or password!</span></span>';
                };
            } else {
                $login = $this->db()
                              ->table('users')
                              ->select()
                              ->where('`login` = \''.$this->template()->validate('login').'\'')
                              ->andwhere('`password` = \''.md5(md5($this->template()->validate('login').$this->template()->validate('password'))).'\'')
                              ->limit(1)
                              ->num();

                // TODO: Fix it or create new tag
                $this->val['error'] = $login == 0 ? '<span id="login" class="drm-error">i<span class="tooltip">'.$this->i18n->no_such_user.'</span></span>' : '';

                $this->template()->load('login.tpl')->show();

                if($this->template()->validate('login') == 1 && $_SESSION['status'] == 'guest') {

                    //TODO: unique code for user
                    $_SESSION['code_user'] = 12345;

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

	public function forgotpass() {
		if($_POST && $this->template()->post_is_valide()) {
			$this->template()->load('All good!')->show();
		} else { 
			$this->template()->load('forgotpass.tpl')->show();
		};
	}

    public function logout() {
        User::login($_SESSION['login'])->edit(array('online'=>0));
        session_destroy();
        setcookie('uid', '');
        setcookie('l', '');
        Go::reload($this->registry()->config['base_href'].$this->registry()->config['main_page']);
    }
}