<?php
class Controller_user extends Controller {
    public function __construct() {
        parent::__construct();
        if(User::login()->permissions()<=1) {
            Go::to('logout');
        };
    }

    public function index() {
        $this->val('login');
        User::login()->permissions()>80 ? '' : Go::main();
        if(empty($this->val['login'])) {
            $this->val['data'] = Paginator::tpl('user/list_data.tpl')
                                            ->table('users')
                                            ->where('1 = 1')
                                            ->order(Helpers::order(), Helpers::direction())
                                            ->load();
            $this->template()->load('user/list.tpl')->show();
        } else {
            $this->val['data'] = $this->db()->table('users')->select()->where('`login` = \''.$this->val['login'].'\'')->limit(1)->fetch();
            $this->template()->load('user/view.tpl')->show();
        }
    }

    public function add() {
        User::login()->permissions()>80 ? '' : Go::main();
        if($_POST && $this->template()->post_is_valide()) {
            User::add(array('login'     => $this->template()->validate('login'),
                            'password'  => md5(md5($this->template()->validate('login').$this->template()->validate('password'))),
                            'name'      => $this->template()->validate('name'),
                            'surname'   => $this->template()->validate('surname'),
                            'email'     => $this->template()->validate('email'),
                            'status'    => $this->template()->validate('status'),
                            'university'=> $this->template()->validate('university'))
            );
            Logger::RA('added new user')->type('add')->save();
            Go::to('user');
        };
        $this->template()->load('user/add.tpl')->show();
    }

    public function edit() {
        $this->val('login');
        $this->val['data'] = User::login($this->val['login'])->get();

        if($this->val['data']['status'] == 'Admin' && User::login()->permissions()<99) {
            Go::back();
        };

        empty($this->val['login']) ? $this->val['login'] = $_SESSION['login'] : '';
        if($_POST && $this->template()->post_is_valide()) {
            User::login($this->val['login'])->edit(
                array('name'      => $this->template()->validate('name'),
                      'surname'   => $this->template()->validate('surname'),
                      'email'     => $this->template()->validate('email'))
            );
            if(User::login()->permissions()>80 && isset($_POST['status'])) {
                User::login($this->val['login'])->edit(
                                    array('status'      =>  $this->template()->validate('status'),
                                          'university'  =>  $this->template()->validate('university')
                                    ));
                if($this->val['data']['status']!==$_POST['status']) {
                    Logger::RA($this->i18n()->changed_user.' <a href="user/view/login='.$this->val['login'].'" class="fancybox-ajax"><b>'
                                .$this->val['login'].'</b></a> '.$this->i18n()->to_status.' '.$this->template()->validate('status'))->type('edit')->save();
                } else {
                    Logger::RA($this->i18n()->edited_user.' <a href="user/view/login='.$this->val['login'].'" class="fancybox-ajax"><b>'.$this->val['login'].'</b></a>')->type('edit')->save();
                };
            };
            $this->val['saved'] = 'true';

            if(!empty($_POST['password']) || !empty($_POST['new_password']) || !empty($_POST['re_new_password'])) {
                if(empty($_POST['password'])) {
                    $this->val['empty_password'] = 'true';
                    $this->val['saved'] = 'false';
                };
                if(md5(md5($this->val['login'].$_POST['password'])) !== $this->val['data']['password']) {
                    $this->val['password_not_true'] = 'true';
                    $this->val['saved'] = 'false';
                };
                if($_POST['new_password'] !== $_POST['re_new_password']) {
                    $this->val['password_repeat'] = 'true';
                    $this->val['saved'] = 'false';
                };
                if(empty($_POST['new_password'])) {
                    $this->val['empty_new_password'] = 'true';
                    $this->val['saved'] = 'false';
                };
                if(empty($_POST['re_new_password'])) {
                    $this->val['empty_renew_password'] = 'true';
                    $this->val['saved'] = 'false';
                };

                if($this->val['saved'] == 'true') {
                    User::login($this->val['login'])->edit(array('password'=>md5(md5($this->val['login'].$_POST['new_password']))));
                    Go::to('logout');
                };
            };
        };
        $this->template()->load('user/edit.tpl')->show();
    }

    public function delete() {
        User::login()->permissions()>80 ? '' : Go::main();
        User::login($this->val('login'))->delete();
        Logger::RA($this->i18n()->deleted_user.' <b>'.$this->val['login'].'</b>');
        Go::back();
    }
}