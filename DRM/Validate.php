<?php
class Validate extends DRM {
    private $data;
    private $name;
    
    function __call($name, $values) {
        Logger::error('Method ['.$name.'] not isset in class ['.__CLASS__.']');
    }
    
    public function data($data) {
        $this->name = $data;
        $this->data = isset($_POST[$data]) ? $_POST[$data] : false;
        return $this;
    }
    
    public function text($min, $max) {
        $this->data = strtr($this->data, array('\'' =>  '&#39;',
                                               '"'  =>  '&quot;',
                                               '$'  =>  '&#36;',
                                               '='  =>  '&#61;',
                                               '+'  =>  '&#43;',
                                               ','  =>  '&#44;'));
        $regular = !preg_match("/[\'\^\"\$\*\>\<\}\{\]\[\~\`\\]]+/", $this->data);
        $error = 'Not text!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function date($min, $max) {
        $regular = preg_match("/^[0-9\/]+$/", $this->data);
        $error = 'Not date!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function phone($min, $max) {
        $regular = preg_match("/^[0-9\-\(\)\s\ \+]+$/", $this->data);
        $error = 'Not phone!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function none($min, $max) {
        $_SESSION['validate'][$this->name] = strtr($this->data, array('\\'=>''));
        return;
    }
    
    public function url($min, $max) {
        $regular = preg_match("/^[0-9\-\(\)\s\ \_\/\=\,\.]+$/", $this->data);
        $error = 'Not url!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function num($min, $max) {
        $regular = preg_match("/^[0-9\.\,]+$/", $this->data);
        $error = 'Not number!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function re_password() {
        if(isset($_POST['password']) && isset($_POST['re_password']) && $_POST['password']!==$_POST['re_password']) {
            $_SESSION['post_is_valide'] = false;
            return '<p class="'.$this->registry()->config['warning_class'].'">'.$this->i18n()->repassword_error.'</p>';
        };
    }
    
    public function email($min, $max) {
        $regular = preg_match("/^[a-zA-Z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/", $this->data);
        $error = 'Not email!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function web($min, $max) {
        $regular = preg_match("~(?:(?:ftp|https?)?://|www\.)(?:[a-z0-9\-]+\.)*[a-z]{2,6}(:?/[a-z0-9\-?\[\]=&;#]+)?~i", $this->data);
        $error = 'Not url!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function login($min, $max) {
        $regular = preg_match("/^[a-zA-Z0-9\.]+$/", $this->data);
        $error = 'Not email!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    protected function validate_($regular, $error, $min, $max) {
        $class = $this->registry()->config['warning_class'];
        $min = (int)$min = strtr($min, array('&#48'=>0));
        $max = (int)$max = strtr($max, array('&#48'=>0));
        if($this->data == false) {
            $text = '';
        } elseif(empty($this->data)) {
            $text = '<p class="'.$class.'" style="color: #FF0000;">Can\'t be empty!</p>';
        } elseif($regular==false) {
            $text = '<p class="'.$class.'" style="color: #FF0000;">'.$error.'</p>';
        } else {
            if(strlen($this->data)<$min) {
                $text = '<p class="'.$class.'" style="color: #FF0000;">Must be <'.$min.'!</p>';
            } elseif(strlen($this->data)>$max) {
                $text .= '<p class="'.$class.'" style="color: #FF0000;">Must be >'.$max.'</p>';
            } else {
                $text = '';
                $_SESSION['validate'][$this->name] = $this->data;
            };
        };
        !isset($_SESSION['post_is_valide']) ? $_SESSION['post_is_valide'] = true : '';
        if(!empty($text)) {
            $_SESSION['post_is_valide'] = false;
        };
        return $text;
    }
    
    public function check() {
        $text = '';
        preg_match("/[\'\^\"\$\%\&\*\>\<\}\{\]\[\~\`\;\\]]+/", $this->data)
            ?   $text = 'Must be a text'
            :   $_SESSION['validate'][$this->name] = $this->data;
        !isset($_SESSION['post_is_valide']) ? $_SESSION['post_is_valide'] = true : '';
        if(!empty($text)) {
            $_SESSION['post_is_valide'] = false;
        };
        return $text;
    }
}