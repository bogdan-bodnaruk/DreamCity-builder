<?php
class Controller_registration extends Controller {
    function index() {
        $this->val['captcha_error'] = '';
        $this->val['login_error'] = '';
            
        $this->val['captcha'] = '/library/kcaptcha/index.php?'.session_name().'='.session_id().date('i:s');
        if(isset($_SESSION['captcha_keystring']) && isset($_POST['captcha']) && $_SESSION['captcha_keystring']!==$_POST['captcha']) {
            $_SESSION['post_is_valide'] = false;
            $this->val['captcha_error'] = '<p class="'.$this->registry()->config['error_class'].'">'.$this->i18n()->captcha_error.'</p>';
        };
        unset($_SESSION['captcha_keystring']);

        if($_POST) {
            $user_login = preg_match('/[\'\^\"\#\|\!\$\%\&\*\>\<\}\{\]\[\~\`\;\/\\]]+/', $_POST['login']) ? '' : $_POST['login'];
            if($this->db()->table('users')->select('login')->where('`login`=\''.$user_login.'\'')->limit(1)->num()==1) {
                $_SESSION['post_is_valide'] = false;
                $this->val['login_error'] = '<p class="'.$this->registry()->config['warning_class'].'">'.$this->i18n->login_error.'</p>';
            };
        };
    
        $this->val['country_val'] = $this->i18n->country_val;
        $this->val['country_text'] = $this->i18n->country_text;
        isset($_SESSION['login']) ? Go::main() : $this->template()->load('registration.tpl')->show();
    }
    
    function user() {      
        if($_POST && $this->template()->post_is_valide()) {
            $this->db()
                 ->table('users')
                 ->insert(array('login'         =>  $this->template()->validate('login'),
                                'password'      =>  md5(md5($this->template()->validate('login').$this->template()->validate('password'))),
                                'email'         =>  $this->template()->validate('email'),
                                'name'          =>  $this->template()->validate('name'),
                                'sename'        =>  $this->template()->validate('se_name'),
                                'country'       =>  $this->template()->validate('country'),
                                'city'          =>  $this->template()->validate('city'),
                                'phone'         =>  $this->template()->validate('phone'),
                                'status'        =>  'user',
                                'date_register' =>  'now()',
                                'hash'          =>  md5($this->template()->validate('login').date('y:d:h:i:s').md5($this->registry()->config['base_href']))))
                 ->query();
                 
            $mail = new PHPMailer();
            $mail->AddAddress($this->registry()->config['admin_email']);
            $mail->Subject = $this->i18n->new_user;
            $mail->Body = 'New user ['.$_SESSION['login'].'] is registered on '.$this->registry()->config['base_href']; 
            $mail->Send();
            
            Go::to('registration/done/');
        } else {
            $this->index();  
        };
    }
    
    function done() {
        $this->template()->load('<p class="info">'.$this->i18n->register_susess.'</p>')->show();
    }
}