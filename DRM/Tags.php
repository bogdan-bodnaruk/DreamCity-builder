<?php
class Tags extends DRM {
    private $D;
    private $i18n;

    public function __construct() {
        $this->validate = new Validate();
        $this->i18n = $this->i18n();
    }
	
    public function __get($name) {
        Logger::error('Try get unknown tag ['.$name.']');
    }

    public function text($type='text') {
        $value = isset($_POST[$this->D['name']]) && $type!=='password'
                ? $_POST[$this->D['name']]
                : $this->D['value'];
        $validate_type = $this->D['validate'];
        $class = $this->_class_($this->D['class'].' drm_'.($type=='password' ? 'password' : $validate_type));

        $input = '<input '.$this->D['style'].$class
                .(!empty($this->D['min']) ? ' data-min="'.$this->D['min'].'" ' : '')
                .$this->D['id'].' type="'.$type.'" name="'.$this->D['name']
                .'" value="'.$value.'" size="'.$this->D['size']
                .'" maxlength="'.$this->D['max'].'" '.$this->D['js']
                .$this->D['placeholder'].$this->D['required'].' />'
                .$this->validate->data($this->D['name'])->$validate_type($this->D['min'], $this->D['max']);
        return $input;
    }

    public function password() {
        return $this->text('password');
    }

    public function textarea() {
        $text = isset($_POST[$this->D['name']])
                ? $_POST[$this->D['name']]
                : $this->D['value'];
        $validate_type = $this->D['validate'];

        $input = '<textarea '.$this->D['style'].$this->D['class']
                .$this->D['id'].' name="'.$this->D['name']
                .'" rows='.$this->D['rows'].' cols="'.$this->D['cols']
                .'" '.$this->D['placeholder'].'maxlength="'.$this->D['max']
                .'" '.$this->D['js'].$this->D['required'].'>'.$text.'</textarea>'
                .$this->validate->data($this->D['name'])->$validate_type($this->D['min'], $this->D['max']);
        return $input;
    }

    public function ckeditor() {
        $this->D['id'] = 'id="cked-'.$this->D['cid'].'"';
        $this->D['class'] = 'class="'.$this->D['type'].'" ';
        return $this->textarea();
    }

    public function submit($type='submit') {
        $this->D['name'] = empty($this->D['name']) ? $type : $this->D['name'];
        unset($_SESSION[$this->D['name']]);
        $this->D['name'] !== 'submit' && isset($_POST[$this->D['name']]) ? $_SESSION[$this->D['name']] = '' : '';
        return '<input '.$this->D['style'].$this->D['class']
				.$this->D['id'].' type="'.$type.'" name="'.$this->D['name']
                .'" value="'.$this->D['value'].'" '.$this->D['js'].'/>';
    }

    public function button() {
        return $this->submit('button');
    }

    public function select() {
        $html = '<select name="'.$this->D['name'].'" '.$this->D['style']
                .$this->D['class'].$this->D['id'].$this->D['js'].'>';

        $value = !is_array($this->D['value']) ? $this->get_value($this->D['value']) : $this->D['value'];
        $text = !is_array($this->D['text']) ? $this->get_value($this->D['text']) : $this->D['text'];

        for($i=0;$i<count($value);$i++) {
            $selected = !empty($this->D['selected']) && $this->D['selected']==$value[$i] ? 'selected' : '';
            if(isset($_POST[$this->D['name']])) {
                $selected = $_POST[$this->D['name']]==$value[$i] ? 'selected' : '';
            };
            $html .= '<option value="'.$value[$i].'" '.$selected.'> '.$text[$i].'</option>';
        }
        return $html.'</select>'.$this->validate->data($this->D['name'])->check();
    }

    public function lang() {
        $this->D['text'] = $this->registry()->config['names_i18n'];
        $this->D['value'] = $this->registry()->config['all_i18n'];
		$this->D['name'] = empty($this->D['name']) ? 'lang' : $this->D['name'];
        $this->D['selected'] = empty($this->D['selected']) ? $this->registry()->config['default_i18n'] : $this->D['selected'];
        return $this->select();
    }

    public function permissions() {
        unset($this->D['value']);
        foreach($this->registry()->user_status as $key => $val) {
            $this->D['value'][] = $val;
            $this->D['text'][] = $key;
        }
		
        $this->D['selected'] = empty($this->D['selected']) ? User::login()->permissions() : $this->D['selected'];
        return $this->select();
    }

    public function radio() {
        $html = '';
        $value = $this->get_value($this->D['value']);
        $text = $this->get_value($this->D['text']);

        for($i=0;$i<count($value);$i++) {
            if(isset($this->D['checked']) && !empty($this->D['checked'])) {
                if(isset($_POST[$this->D['name']])) {
                    $checked = $value[$i]==$_POST[$this->D['name']] ? 'checked' : '';
                } else {
                    $checked = $value[$i]==$this->D['checked'] ? 'checked' : '';
                };
            };
            $html .= '<input type="radio" name="'.$this->D['name'].'" value="'.$value[$i].'" id="radio_'
                    .$this->D['name'].'_'.$i.'" '.$this->D['required'].' '.$this->D['class']
                    .(!isset($checked) ? '' : $checked).' />
                    <label for="radio_'.$this->D['name'].'_'.$i.'">&nbsp;'.$text[$i].'</label>';
        }
        return '<div class="radio_wrapper">'.$html.'</div>'
               .$this->validate->data($this->D['name'])->check();
    }

    public function checkbox() {
        $html = '';
        $value = $this->get_value($this->D['value']);
        $text = $this->get_value($this->D['text']);

        $this->D['checked'] = explode('+', $this->D['checked']);
        for($i=0;$i<count($value);$i++) {
            if(isset($_POST[$this->D['name'].'_'.$i])) {
                $checked = $value[$i]==$_POST[$this->D['name'].'_'.$i] ? 'checked' : '';
            } else {
                if(count($this->D['checked'])==1 && !empty($this->D['checked'][0])) {
                    $checked = $value[$i]==$this->D['checked'][0] ? 'checked' : '';
                } elseif(count($this->D['checked'])>1) {
                    for($j=0;$j<count($this->D['checked']);$j++) {
                        if($value[$i]==$this->D['checked'][$j]) {
                            $checked = 'checked';
                        };
                    }
                };
            };
            $html .= '<input type="checkbox" name="'.$this->D['name'].'_'.$i.'" value="'.$value[$i].'" '
                    .$this->D['class'].' id="checkbox_'.$this->D['name'].'_'.$i.'" '
                    .(!isset($checked) ? '' : $checked).' />
                    <label for="checkbox_'.$this->D['name'].'_'.$i.'"> '.$text[$i].'</label>';
        }
        return '<div class="checkbox_wrapper">'.$html.'</div>'
               .$this->validate->data($this->D['name'])->check();
    }
	
	public function datepicker() {
		$this->D['id'] = 'id="datepicker-'.$this->D['name'].'" readonly="readonly" ';
		return $this->text();
	}
	
	public function window() {
		$button = $this->D['type']=='button'
					? '<button id="window-'.$this->D['name'].'">'.$this->D['value'].'</button>'
					: '<a href="#" id="window-'.$this->D['name'].'">'.$this->D['value'].'</a>';
				
		return $button.'<div id="window-'.$this->D['name'].'" title="'.$this->D['title']
                      .'" style="display: none;">'.$this->D['text'].'</div>';
	}

    public function fancybox() {
        $html = '';
        if($this->D['type']=='gallery') {
            $value = $this->get_value($this->D['file']);
            for($i=0;$i<count($value);$i++) {
                $max = $this->D['max']>0 ? ($i>$this->D['max']-1 ? 'style="display: none;"' : '') : '';
                if(!empty($value[$i])) {
                    $html .= '<a href="'.$this->D['path'].$value[$i].'" rel="gallery-'.$this->D['name'].'" '.$max.'>
                                <img src="'.$this->D['thumb_path'].$value[$i].'" alt="'.$value[$i].'" />
                              </a>';
                };
            }
            return empty($html) ? '' : '<div id="fancybox-'.$this->D['name'].'">'.$html.'</div>';
        } else {
            if(!empty($this->D['type'])) {
                return '<a href="'.$this->D['file'].'" class="fancybox-'.$this->D['type'].'">'.$this->D['title'].'</a>';
            };
        };
    }

    public function kcaptcha() {
        $this->D['style'] = 'style="width: 103px;" ';
        return '<img src="/'.$this->registry()->config['library_path'].'/kcaptcha/kcaptcha.php?'.session_name().'='.session_id().date('i:s').'" alt="kaptcha" />'
                .'<br />'.$this->text();
    }

    public function test() {
        if(empty($this->D['elseif'])) {
            if(eval('return '.$this->D['if'].';')) {
                return $this->D['then'];
            } else {
                return $this->D['else'];
            };
        } else {
            if(eval('return '.$this->D['if'].';')) {
                return $this->D['then'];
            } elseif(eval('return '.$this->D['elseif'].';')) {
                return $this->D['else_then'];
            } else {
                return $this->D['else'];
            };
        };
    }

    public function include_tpl() {
        return $this->template()->load($this->D['file'])->data();
    }

    public function message() {
        if(!empty($this->D['text']) && $this->D['enabled']=='true') {
            switch ($this->D['type']) {
                case 'success':
                    $html = '<div class="'.$this->registry()->config['success_class'].'" '.$this->D['style'].'>'.$this->D['text'].'</div>';
                break;
                case 'warning':
                    $html = '<div class="'.$this->registry()->config['warning_class'].'" '.$this->D['style'].'>'.$this->D['text'].'</div>';
                break;
                case 'error':
                    $html = '<div class="'.$this->registry()->config['error_class'].'" '.$this->D['style'].'>'.$this->D['text'].'</div>';
                break;
                case 'input':
                    $html = '<span '.$this->D['id'].' class="'.$this->registry()->config['error_class'].'">i<span class="tooltip">'.$this->D['text'].'</span></span>';
                break;
                default:
                    $html = '<div '.$this->D['id'].' '.$this->D['class'].' '.$this->D['style'].'>'.$this->D['text'].'</div>';
            }
            return $html;
        };
    }

    public function return_input($type, $array) {
        $this->properties($array);
		return $this->$type();
    }

    private function get_value($value) {
        if(preg_match('/[\{][\w\_\-\/\:\,\;]+[\}]/', $value)) {
            $data = explode('::', strtr($value, array('{'=>'','}'=>'')));
            switch($data[0]) {
                case 'config':
                    return $this->registry()->get($data[0], $data[1]);
                break;
                case 'session':
                    return isset($_SESSION[$data[1]]) ? $_SESSION[$data[1]] : '';
                break;
                case 'i18n':
                    return $this->i18n->$data[1];
                break;
                default:
                    return parent::$values[$data[0]][$data[1]];
                break;
            }
        } else {
            $data = explode(',', strtr($value, array('$'=>'','['=>'',']'=>'')));
            foreach($data as $key=>$val) {
                $value = explode('::', strtr($val, array('|'=>'')));
                switch($value[0]) {
                    case 'config':
                        $array[$key] = $this->registry()->get($value[0], $value[1]);
                    break;
                    case 'session':
                        $array[$key] = isset($_SESSION[$value[1]]) ? $_SESSION[$value[1]] : '';
                    break;
                    case 'i18n':
                        $array[$key] = $this->i18n->$value[1];
                    break;
                    default:
                        $array[$key] = $val;
                    break;
                }
            }
            return $array;
        };
    }

    public function properties($array) {
        $this->D = array('name'       =>  !isset($array['name']) ? '' : $array['name'],
                         'value'      =>  !isset($array['value']) ? '' : $array['value'],
                         'validate'   =>  !isset($array['validate']) ? 'text' : $array['validate'],
                         'style'      =>  !isset($array['style']) ? '' : $this->style($array['style']),
                         'id'         =>  !isset($array['id']) ? '' : $this->id($array['id']),
                         'cid'        =>  !isset($array['id']) ? '' : $array['id'],
                         'title'      =>  !isset($array['title']) ? '' : $array['title'],
                         'file'       =>  !isset($array['file']) ? '' : $array['file'],
                         'path'       =>  !isset($array['path']) ? '' : $array['path'],
                         'thumb_path' =>  !isset($array['thumb_path']) ? '' : $array['thumb_path'],
                         'class'      =>  !isset($array['class']) ? '' : $this->_class_($array['class']),
                         'size'       =>  !isset($array['size']) ? $this->registry()->config['input_size'] : $array['size'],
                         'min'        =>  !isset($array['min']) ? 0 : $array['min'],
                         'max'        =>  !isset($array['max']) ? $this->registry()->config['input_max_chars'] : $array['max'],
                         'required'   =>  !isset($array['required']) ? 'required' : '',
                         'placeholder'=>  !isset($array['placeholder']) ? '' : 'placeholder="'.$array['placeholder'].'" ',
                         'rows'       =>  !isset($array['rows'])  ? $this->registry()->config['textarea_rows'] : $array['rows'],
                         'cols'       =>  !isset($array['cols'])  ? $this->registry()->config['textarea_cols'] : $array['cols'],
                         'is_null'    =>  !isset($array['is_null']) && !isset($array['required']) ?  'true' : 'false',
                         'selected'   =>  !isset($array['selected']) ? '' : $array['selected'],
                         'enabled'    =>  !isset($array['enabled']) || empty($array['enabled']) ? 'false' : $array['enabled'],
                         'checked'    =>  !isset($array['checked']) ? '' : $array['checked'],
                         'text'       =>  !isset($array['text']) ? '' : $array['text'],
                         'js'         =>  !isset($array['js']) ? '' : $this->script($array['js']),
                         'if'         =>  !isset($array['if']) ? '' : $array['if'],
                         'elseif'     =>  !isset($array['elseif']) ? '' : $array['elseif'],
                         'then'       =>  !isset($array['then']) ? '' : $array['then'],
                         'else_then'  =>  !isset($array['else_then']) ? '' : $array['else_then'],
                         'else'       =>  !isset($array['else']) ? '' : $array['else'],
                         'type'       =>  !isset($array['type']) ? 'Basic' : $array['type']);
    }

    private function style($data='') {
        return !empty($data) ? 'style = "'.strtr($data,array('+'=>';')).'" ' : '';
    }

    private function id($data='') {
        return !empty($data) ? 'id = "'.$data.'" ' : '';
    }

    private function _class_($data='') {
		if(preg_match("/^[class]{5}/", $data)) {
			return 'class = "'. strtr($data, array('class = "' =>'', '"'=>'')).'" ';
		} else {
			return !empty($data) ? 'class = "'.$data.'" ' : ''; 
		};
    }

    private function script($data='') {
        $js = '';
        $data = explode('+', $data);
        for($i=0;$i<count($data);$i++) {
            list($action, $property) = explode(':', $data[$i]);
            $js .= $action.'="'.$property.'" ';
        }
        return $js;
    }

}