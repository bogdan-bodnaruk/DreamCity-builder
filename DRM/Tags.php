<?php
class Tags extends DRM {
    private $property;
    private $i18n;

    public function __construct() {
        $this->validate = new Validate();
        $this->i18n = &$this->i18n();
    }
	
	public function __get($name) {
		Logger::error('Try get unknown tag ['.$name.']');
	}

    public function text($type='text') {
        $value = isset($_POST[$this->property['name']]) && $type!=='password'
                ? $_POST[$this->property['name']]
                : $this->property['value'];
        $validate_type = $this->property['validate'];

        $input = '<input '.$this->property['style'].$this->property['class']
                .$this->property['id'].'type="'.$type.'" name="'.$this->property['name']
                .'" value="'.$value.'" size="'.$this->property['size']
                .'"maxlength="'.$this->property['max'].'" '.$this->property['js']
                .$this->property['placeholder'].$this->property['required'].' />'
                .$this->validate->data($this->property['name'])->$validate_type($this->property['min'], $this->property['max']);
        return $input;
    }

    public function password() {
        return $this->text('password');
    }

    public function textarea() {
        $text = isset($_POST[$this->property['name']])
                ? $_POST[$this->property['name']]
                : $this->property['value'];
        $validate_type = $this->property['validate'];

        $input = '<textarea '.$this->property['style'].$this->property['class']
                .$this->property['id'].' name="'.$this->property['name']
                .'" rows='.$this->property['rows'].' cols="'.$this->property['cols']
                .'" '.$this->property['placeholder'].'maxlength="'.$this->property['max']
                .'" '.$this->property['js'].$this->property['required'].'>'.$text.'</textarea>'
                .$this->validate->data($this->property['name'])->$validate_type($this->property['min'], $this->property['max']);
        return $input;
    }

    public function ckeditor() {
        $this->property['id'] = 'id="cked-'.$this->property['cid'].'"';
        $this->property['class'] = 'class="'.$this->property['type'].'" ';
        return $this->textarea();
    }

    public function submit($type='submit') {
        $this->property['name'] = empty($this->property['name']) ? $type : $this->property['name'];
        unset($_SESSION[$this->property['name']]);
        $this->property['name'] !== 'submit' && isset($_POST[$this->property['name']]) ? $_SESSION[$this->property['name']] = '' : '';
        return '<input '.$this->property['style'].$this->property['class']
				.$this->property['id'].' type="'.$type.'" name="'.$this->property['name']
                .'" value="'.$this->property['value'].'" '.$this->property['js'].'/>';
    }

    public function button() {
        return $this->submit('button');
    }

    public function select() {
        $html = '<select name="'.$this->property['name'].'" '.$this->property['style']
                .$this->property['class'].$this->property['id'].$this->property['js'].'>';

        $value = !is_array($this->property['value']) ? $this->get_value($this->property['value']) : $this->property['value'];
        $text = !is_array($this->property['text']) ? $this->get_value($this->property['text']) : $this->property['text'];

        for($i=0;$i<count($value);$i++) {
            $selected = !empty($this->property['selected']) && $this->property['selected']==$value[$i] ? 'selected' : '';
            if(isset($_POST[$this->property['name']])) {
                $selected = $_POST[$this->property['name']]==$value[$i] ? 'selected' : '';
            };
            $html .= '<option value="'.$value[$i].'" '.$selected.'> '.$text[$i].'</option>';
        }
        return $html.'</select>'.$this->validate->data($this->property['name'])->check();
    }

    public function lang() {
        $this->property['text'] = $this->registry()->config['names_i18n'];
        $this->property['value'] = $this->registry()->config['all_i18n'];
		$this->property['name'] = empty($this->property['name']) ? 'lang' : $this->property['name'];
        $this->property['selected'] = empty($this->property['selected']) ? $this->registry()->config['default_i18n'] : $this->property['selected'];
        return $this->select();
    }

    public function permissions() {
        unset($this->property['value']);
        foreach($this->registry()->user_status as $key => $val) {
            $this->property['value'][] = $val;
            $this->property['text'][] = $key;
        }
		
        $this->property['selected'] = empty($this->property['selected']) ? User::login()->permissions() : $this->property['selected'];
        return $this->select();
    }

    public function radio() {
        $html = '';
        $value = $this->get_value($this->property['value']);
        $text = $this->get_value($this->property['text']);

        for($i=0;$i<count($value);$i++) {
            if(isset($this->property['checked']) && !empty($this->property['checked'])) {
                if(isset($_POST[$this->property['name']])) {
                    $checked = $value[$i]==$_POST[$this->property['name']] ? 'checked' : '';
                } else {
                    $checked = $value[$i]==$this->property['checked'] ? 'checked' : '';
                };
            };
            $html .= '<input type="radio" name="'.$this->property['name'].'" value="'.$value[$i].'" id="radio_'
                    .$this->property['name'].'_'.$i.'" '.$this->property['required'].' '.$this->property['class']
                    .(!isset($checked) ? '' : $checked).' />
                    <label for="radio_'.$this->property['name'].'_'.$i.'">&nbsp;'.$text[$i].'</label>';
        }
        return '<div class="radio_wrapper">'.$html.'</div>'
               .$this->validate->data($this->property['name'])->check();
    }

    public function checkbox() {
        $html = '';
        $value = $this->get_value($this->property['value']);
        $text = $this->get_value($this->property['text']);

        $this->property['checked'] = explode('+', $this->property['checked']);
        for($i=0;$i<count($value);$i++) {
            if(isset($_POST[$this->property['name'].'_'.$i])) {
                $checked = $value[$i]==$_POST[$this->property['name'].'_'.$i] ? 'checked' : '';
            } else {
                if(count($this->property['checked'])==1 && !empty($this->property['checked'][0])) {
                    $checked = $value[$i]==$this->property['checked'][0] ? 'checked' : '';
                } elseif(count($this->property['checked'])>1) {
                    for($j=0;$j<count($this->property['checked']);$j++) {
                        if($value[$i]==$this->property['checked'][$j]) {
                            $checked = 'checked';
                        };
                    }
                };
            };
            $html .= '<input type="checkbox" name="'.$this->property['name'].'_'.$i.'" value="'.$value[$i].'" '
                    .$this->property['class'].' id="checkbox_'.$this->property['name'].'_'.$i.'" '
                    .(!isset($checked) ? '' : $checked).' />
                    <label for="checkbox_'.$this->property['name'].'_'.$i.'"> '.$text[$i].'</label>';
        }
        return '<div class="checkbox_wrapper">'.$html.'</div>'
               .$this->validate->data($this->property['name'])->check();
    }
	
	public function datepicker() {
		$this->property['id'] = 'id="datepicker-'.$this->property['name'].'"';
		return $this->text();
	}
	
	public function window() {
		$button = $this->property['type']=='button'
					? '<button id="window-'.$this->property['name'].'">'.$this->property['value'].'</button>'
					: '<a href="#" id="window-'.$this->property['name'].'">'.$this->property['value'].'</a>';
				
		return $button.'<div id="window-'.$this->property['name'].'" style="display: none;">'.$this->property['text'].'</div>';
	}

    public function fancybox() {
        $html = '<div id="fancybox_'.$this->property['cid'].'">';
        $data = explode(';', $this->property['value']);
        for($i=0;$i<count($data);$i++) {
            if(!empty($data[$i])) {
                $html .= '<a href="'.$this->property['text'].'/src/'.$data[$i].'.jpg" class="fancybox" data-fancybox-group="gallery-'.
                         $this->property['cid'].'" '.($i>$this->property['min'] ? 'style="display: none;"' : '').'>
                         <img class="apply_img" style="margin: 0;" src="'.$this->property['text'].'/thumbs/'.$data[$i].'.jpg" alt="galery_'.$i.'" />
                         </a>';
            };
        }
        return empty($this->property['value']) ? '<img src="'.$this->registry()->config['app_path'].'/theme/images/no_photo.png" alt="no photo" />' : $html .= '</div>';
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
        $this->property = array('name'       =>  !isset($array['name']) ? '' : $array['name'],
                                'value'      =>  !isset($array['value']) ? '' : $array['value'],
                                'validate'   =>  !isset($array['validate']) ? 'text' : $array['validate'],
                                'style'      =>  !isset($array['style']) ? '' : $this->style($array['style']),
                                'id'         =>  !isset($array['id']) ? '' : $this->id($array['id']),
                                'cid'        =>  !isset($array['id']) ? '' : $array['id'],
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
                                'checked'    =>  !isset($array['checked']) ? '' : $array['checked'],
                                'text'       =>  !isset($array['text']) ? '' : $array['text'],
                                'js'         =>  !isset($array['js']) ? '' : $this->script($array['js']),
                                'type'       =>	 !isset($array['type']) ? 'Basic' : $array['type']);
    }

    private function style($data='') {
        return !empty($data) ? 'style = "'.strtr($data,array('+'=>';')).'" ' : '';
    }

    private function id($data='') {
        return !empty($data) ? 'id = "'.$data.'" ' : '';
    }

    private function _class_($data='') {
        return !empty($data) ? 'class = "'.$data.'" ' : '';
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