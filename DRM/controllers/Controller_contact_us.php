<?php
class Controller_contact_us extends Controller {
    function index() {
        $this->val['country_val'] = $this->i18n->country_val;
        $this->val['country_text'] = $this->i18n->country_text;
        $this->val['captcha_error'] = '';
        
        $this->val['captcha'] = '/library/kcaptcha/index.php?'.session_name().'='.session_id().date('i:s');
        if(isset($_SESSION['captcha_keystring']) && isset($_POST['captcha']) && $_SESSION['captcha_keystring']!==$_POST['captcha']) {
            $_SESSION['post_is_valide'] = false;
            $this->val['captcha_error'] = '<p class="'.$this->registry()->config['error_class'].'">'.$this->i18n()->captcha_error.'</p>';
        };
        unset($_SESSION['captcha_keystring']);
        
        if(isset($_SESSION['login'])) {
            $this->val['data'] = $this->db()->table('users')
                                    ->select(array('name', 'sename', 'email', 'country', 'city', 'phone'))
                                    ->where('`login`=\''.$_SESSION['login'].'\'')
                                    ->limit(1)
                                    ->fetch();
        } else {
            $this->val['data'] = array();  
        };
        
        $this->template()->load('contact_us.tpl')->return_data();
        if($_POST && $this->template()->post_is_valide()) {
            $this->val['name'] = $this->template()->validate('name');
            $this->val['sename'] = $this->template()->validate('sename');
            $this->val['country'] = $this->template()->validate('country');
            $this->val['city'] = $this->template()->validate('city');
            $this->val['phone'] = $this->template()->validate('phone');
            $this->val['email'] = $this->template()->validate('email');
            $this->val['theme'] = $this->template()->validate('theme');
            $this->val['text'] = $this->template()->validate('text');
            
            $mail = new PHPMailer();
            $mail->AddAddress($this->registry()->config['admin_email']);
            $mail->Subject = $this->i18n->contact_us;
            $mail->Body = $this->template()->load('contact_us_email.tpl')->return_data(); 
            $mail->Send();
            
            Go::to('contact_us/done/');  
        } else {
            $this->template()->load('contact_us.tpl')->show();  
        };
    }
    
    function done() {
        $this->template()->load('<p class="success">'.$this->i18n->message_sent.'</p>')->show();
    }
}