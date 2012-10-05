<?php
class Template extends DRM {
    private $html;
    private $tags;
    private $i18n;
    private $null = array('&#48'=>'0');

    public function __construct() {
        $this->tags = new Tags();
        $this->i18n = $this->i18n();
    }
    
    function __call($name, $values) {
        Logger::error('Method ['.$name.'] not isset in class ['.__CLASS__.']');
    }

    public function load($file = '&nbsp;') {
        if(preg_match("/[\w]+\.tpl/", $file)) {
            $file = preg_match("/[.tpl]{4}$/", $file)
                    ? file_get_contents($this->registry()->PATH.'/views/'.$file)
                    : file_get_contents($file);
        };
        $this->html = strtr($file, array_flip($this->null));
        $this->render();
        return $this;
    }
    
    public function ajax() {
        echo strtr($this->html, $this->null);
    }
    
    public function show() {
        $this->registry()->config['ajax'] && ($_GET['ajax']=='true' || $_POST['ajax']=='true')
            ? $this->ajax()
            : $this->main();
    }

    public function data() {
        return strtr($this->html, $this->null);
    }
    
    public function main($value = '') {
        $value = empty($value) ? $this->registry()->config['main_content_value'] : $value;
        parent::$values[$value] = $this->html;
        //Todo: check it for no errors
        $main = $this->registry()->main_page;
        $main = !empty($main)
                ? $this->registry()->main_page
                : $this->registry()->config['main_template'];
        $this->load($main);
        $this->ajax();
    }

    private function render() {
        $data = array();

        $this->html = strtr($this->html, $this->get_value());
        preg_match_all("/[\#\#]{2}[a-z]+[\-\>]{2}(.*)[\#\#]{2}/u", $this->html, $val);
        for($i=0;$i<count($val[0]);$i++) {
            $value = strtr($val[0][$i], array('##'=>''));
            list($type, $values)  = explode('->', $value);
            $values = explode(';',strtr($values, array('['=>'',']'=>'')));

            for($j=0;$j<count($values);$j++) {
                if(!empty($values[$j])) {
                    list($key, $properties) = explode('=', $values[$j], 2);
                    $tags[$key] = $properties;
                };
            }
            $data['##'.$value.'##'] = $this->tags->return_input($type, $tags);
            unset($type, $tags);
        }
        $this->html = strtr($this->html, $data);
        $this->html = strtr($this->html, $this->get_value('safe'));
    }

    public function hash($lenght = 1) {
        $code = '';
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
        $chars_lenght = strlen($chars) - 1;
        while (strlen($code) < $lenght) {
            $code .= $chars[mt_rand(0,$chars_lenght)];
        }
        return $code;
    }

    private function get_value($type = '') {
        $array = array();
        if($type == 'safe') {
            preg_match_all("/[\{][\w\_\-\/\:\,\;]+[\}]/", $this->html, $val);
            $type = array('{'=>'','}'=>'');
        } else {
            preg_match_all("/[\$\{]{2}[\w\_\-\/\:\,\;]+[\}]/", $this->html, $val);
            $type = array('${'=>'','}'=>'');
        };
        for($i=0;$i<count($val[0]);$i++) {
            $value = strtr($val[0][$i], $type);
            if(preg_match("/[\:\:]/", $value)) {
                $value = explode('::', $value);
                switch($value[0]) {
                    case('config'):
                        $array[$val[0][$i]] = $this->registry()->get($value[0], $value[1]);
                    break;
                    case('session'):
                        $array[$val[0][$i]] = isset($_SESSION[$value[1]]) ? $_SESSION[$value[1]] : '';
                    break;
                    case('i18n'):
                        $array[$val[0][$i]] = $this->i18n->$value[1];
                    break;
                };
            } elseif (isset(parent::$values[$value])) {
                $array[$val[0][$i]] = parent::$values[$value];
            } else {
                $array[$val[0][$i]] = '';
            };
        }
        return $array;
    }

    public function post_is_valide() {
        return isset($_SESSION['post_is_valide']) ? true : false;
    }
    
    public function url($table = '') {
        $try = $this->db()->table($table)->select('theme')->where('`theme` = \''.$this->validate('theme').'\'')->num();
        $array = array(' '      => '_',
						'/'		=>	'_',
                       '%20'    => '_',
                       ','      => '_');
        return $try<=1 ? strtr($this->validate('theme'), $array) : strtr($this->validate('theme').$try, $array);
    }

    public function validate($data) {
        $value = isset($_POST[$data]) ? $_POST[$data] : '';
        $value = strtr($value, array('\'' =>  '&#39;',
                                     '"'  =>  '&quot;',
                                     '$'  =>  '&#36;'));

        return $value;
    }

    function __destruct() {
        unset($this->html);
    }
}