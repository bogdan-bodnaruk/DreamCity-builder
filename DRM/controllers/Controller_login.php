<?php
class Controller_login extends Controller {
    public function __construct() {
        parent::__construct();
        if($this->registry()->config['DB-connected']) {
            $this->val['db-message-enable'] = 'false';
        };
        $this->val['login_error'] = 'false';
        $this->val['pass_error'] = 'false';
        $this->registry()->main_page = 'empty.tpl';
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

                if($login == 1 && $_SESSION['status'] == 'guest') {
                    $_SESSION['code_user'] = $this->template()->hash(15);
                    $_SESSION['login'] = $this->template()->validate('login');

                    User::login($_SESSION['login'])
                            ->edit(array( 'online'      =>  'now()',
                                          'code_user'   =>  $_SESSION['code_user'],
                                          'last_login'  =>  'now()',
                                          'hash'        =>  md5($_SESSION['code_user'].$_SERVER['REMOTE_ADDR'].$_SESSION['login'])
                            ));
                    Logger::RA($_SESSION['login'])->type('login')->save();
                    Go::to('dashboard/all');
                };
                $this->template()->load('login.tpl')->show();
            };
        };
        if(isset($_SESSION['login'])) {
            Go::reload('dashboard');
        } else {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                Go::reload();
            } else {
				 $this->template()->load('login.tpl')->main();
            };
        };
	}
}