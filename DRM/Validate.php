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
        $regular = !preg_match("/[\'\^\"\#\|\!\$\%\&\*\>\<\}\{\]\[\~\`\;\/\\]]+/", $this->data);
        $error = 'Not text!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function none($min, $max) {
        return '';
    }
    
    public function num($min, $max) {
        $regular = preg_match("/[0-9\.]+/", $this->data);
        $error = 'Not number!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function email($min, $max) {
        $regular = preg_match("/^[a-zA-Z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/", $this->data);
        $error = 'Not email!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    public function login($min, $max) {
        $regular = preg_match("/^[a-zA-Z0-9\.]+$/", $this->data);
        $error = 'Not email!';
        return $this->validate_($regular, $error, $min, $max);
    }
    
    protected function validate_($regular, $error, $min, $max) {
        $class = $this->registry()->config['error_class'];
        if($this->data == false) {
            $text = '';
        } elseif(empty($this->data)) {
            $text = '<p class="'.$class.'" style="color: #FF0000;">Can\'t be empty!</p>';
        } elseif($regular==false) {
            $text = '<p class="'.$class.'" style="color: #FF0000;">'.$error.'</p>';
        } else {
            if(strlen($this->data)<(int)$min) {
                $text = '<p class="'.$class.'" style="color: #FF0000;">Must be <'.$min.'!</p>';
            } elseif(strlen($this->data)>(int)$max) {
                $text = '<p class="'.$class.'" style="color: #FF0000;">Must be >'.$max.'</p>';
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
        preg_match("/[\'\^\"\#\|\!\$\%\&\*\>\<\}\{\]\[\~\`\;\/\\]]+/", $this->data)
            ?   $text = 'Must be a text'
            :   $_SESSION['validate'][$this->name] = $this->data;
        !isset($_SESSION['post_is_valide']) ? $_SESSION['post_is_valide'] = true : '';
        if(!empty($text)) {
            $_SESSION['post_is_valide'] = false;
        };
        return $text;
    }
}