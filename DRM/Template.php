<?php
class Template extends DRM { 
    private $html;
    private $property;
    private $validate_type;
    private $i18n;
    
    function __construct() {
        $this->validate = new Validate();
        $this->i18n = &$this->i18n();	
    }
    
    function __call($name, $values) {
        Logger::error('Method ['.$name.'] not isset in class ['.__CLASS__.']');
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
	    return $this->textarea().'
		    <script type="text/javascript">
			    if (CKEDITOR.instances["'.$this->property['cid'].'"]) { 
				    delete CKEDITOR.instances["'.$this->property['cid'].'"] 
			    };

			    CKEDITOR.replace("'.$this->property['cid'].'",
			    {
				    toolbar : "'.$this->property['type'].'",
				    width: "'.$this->property['rows'].'"
			    });
		    </script>';
	}
	
    public function submit($type='submit') {
        $this->property['name'] = empty($this->property['name']) ? $type : $this->property['name'];
		unset($_SESSION[$this->property['name']]);
		$this->property['name'] !== 'submit' && isset($_POST[$this->property['name']]) ? $_SESSION[$this->property['name']] = '' : '';
		$input = '<input '.$this->property['style'].$this->property['class']
                 .$this->property['id'].' type="'.$type.'" name="'.$this->property['name']
                 .'" value="'.$this->property['value'].'" '.$this->property['js'].'/>';
        return $input;
    }
    
    public function button() {
        return $this->submit('button');
    }
    
    public function select() {
        $html = '<select name="'.$this->property['name'].'" '.$this->property['style']
                .$this->property['class'].$this->property['id'].$this->property['js'].'>';
        
        $value = is_array($this->property['value']) ? $this->property['value'] : parent::$values[$this->property['value']];
        $text = is_array($this->property['text']) ? $this->property['text'] : parent::$values[$this->property['text']];
        
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
        $this->property['value'] = $this->registry()->config['all_i18n'];
        parent::$values[$this->property['text']] = $this->registry()->config['names_i18n'];
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
        for($i=0;$i<count(parent::$values[$this->property['value']]);$i++) { //parent::$values[$this->property['value']]
            $checked = !empty($this->property['checked'])
						&& $this->property['checked']==parent::$values[$this->property['value']][$i]
						&& empty($_POST[$this->property['name']]) ? 'checked' : '';
            
            if(isset($_POST[$this->property['name']])) {
                $checked = $_POST[$this->property['name']]==parent::$values[$this->property['value']][$i] ? 'checked' : $checked;
            };
            $html .= '<input type="radio" name="'.$this->property['name'].'" value="'.parent::$values[$this->property['value']][$i]
		    .'" id="radio_'.$this->property['name'].'_'.$i.'" '.$checked.' '.$this->property['required']
		    .' /><label for="radio_'.$this->property['name'].'_'.$i.'">&nbsp;'
		    .parent::$values[$this->property['text']][$i].'</label>';
        }
        return $html.$this->validate->data($this->property['name'])->check();
    }
    
    public function checkbox() {
        $html = '';
	$this->property['checked'] = explode('+', $this->property['checked']);
        for($i=0;$i<count(parent::$values[$this->property['value']]);$i++) {
            $checked = isset($_POST[$this->property['name'].'_'.$i]) && (parent::$values[$this->property['value']][$i]==$_POST[$this->property['name'].'_'.$i])
                || !isset($_POST[$this->property['name'].'_'.$i]) && $this->property['checked'][$i]==parent::$values[$this->property['value']][$i]
                ? 'checked' : '';
            $html .= '<input type="checkbox" name="'.$this->property['name'].'_'.$i.'" value="'
                .parent::$values[$this->property['value']][$i].'" '.$this->property['class'].' id="checkbox_'.$this->property['name']
                .'_'.$i.'" '.$checked.' /><label for="checkbox_'.$this->property['name'].'_'.$i.'"> '
                .parent::$values[$this->property['text']][$i].'</label>';
        }
        return $html.$this->validate->data($this->property['name'])->check();
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
	
    public function load($file = '&nbsp;') {
	if(preg_match("/[\w]+\.tpl/", $file)) {
	    if(preg_match("/[\/]{1,}/", $file)) {
		$file = file_get_contents($file);
	    } else {
		$file = file_get_contents($this->registry()->PATH.'/views/'.$file);
	    };
	};
        $this->html = strtr($file, array('0'=>'&#48'));
        $this->fetch_values();
        $this->fetch_input();
        return $this;
    }
    
    public function ajax() {
        echo strtr($this->html, array('&#48'=>'0'));
    }
    
    public function show() {
	if($this->registry()->config['ajax'] && ((isset($_GET['ajax']) && $_GET['ajax']=='true') || (isset($_POST['ajax']) && $_POST['ajax']=='true'))) {
	    $this->ajax();
	} else {
	    $this->main();
	};
    }
    
    public function return_data() {
        return strtr($this->html, array('&#48'=>'0'));
    }
    
    public function main($value = '') {
        $value = empty($value) ? $this->registry()->config['main_content_value'] : $value;
        !isset(parent::$values['css']) ? parent::$values['css'] = '' : '';
        !isset(parent::$values['js']) ? parent::$values['js'] = '' : '';
        parent::$values[$value] = $this->html;
        $this->registry()->PATH = APP_PATH;
        $this->load($this->registry()->config['main_template']);
        echo strtr($this->html, array('&#48'=>'0'));
    }
    
    private function fetch_input() {
        $data = array();
        preg_match_all("/[\#\#]{2}[a-z]+[\-\>]{2}(.*)[\#\#]{2}/u", $this->html, $val);
        for($i=0;$i<count($val[0]);$i++) {
            $value = strtr($val[0][$i], array('##'=>''));		
            list($type, $values)  = explode('->', $value);
            $values = strtr($values, array('['=>'',']'=>''));
            $values = explode('^',$values);
            $array = array();
            for($j=0;$j<count($values);$j++) {
                if(!empty($values[$j])) {
                    list($key, $properties) = explode('=', $values[$j], 2);
					$array[$key] = $properties;
                }
            }
            $data['##'.$value.'##'] = $this->return_input($type, $array);		
            unset($type, $array);
        }
        $this->html = strtr($this->html, $data);
    }

    private function fetch_values() {
        $array = array('');
        preg_match_all("/[\{][\w\_\-\/\:\,\;]+[\}]/", $this->html, $val);
        for($i=0;$i<count($val[0]);$i++) {
            $value = strtr($val[0][$i], array('{'=>'','}'=>''));
            if (preg_match("/[\:\:]/", $value)) {
                $value = explode('::', $value);
                if($value[0] == 'config') {
                    $array[$val[0][$i]] = $this->registry()->get($value[0], $value[1]);
                } elseif($value[0] == 'i18n') {
                    $array[$val[0][$i]] = $this->i18n->$value[1];
                } else {
                    $array[$val[0][$i]] = isset(parent::$values[$value[0]][$value[1]]) ? parent::$values[$value[0]][$value[1]] : '';
                };
            } elseif (isset(parent::$values[$value]) && !is_array(parent::$values[$value])) {
                $array[$val[0][$i]] = parent::$values[$value];
            } elseif (isset(parent::$values[$value]) && is_array(parent::$values[$value])) {
                $array[$val[0][$i]] = $value;
            }
        }
        $this->html = strtr($this->html, $array);
    }

    private function properties($array) {
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
				'type'       =>	 !isset($array['type']) ? 'Basic' : $array['type'],
				);

    }
    
    public function css($file) {
        $this->get_file($file, __FUNCTION__);
    }
    
    public function js($file) {
		$this->get_file($file, __FUNCTION__);
    }
    
    private function get_file($file, $type) {
        !isset(parent::$values[$type]) ? parent::$values[$type] = '' : '';
        $file = preg_match('/^[http\:\/\/]{7}/', $file)
            ? $file
            : $this->registry()->PATH.'/theme/'.$type.'/'.$file;
        try {
            if(@file_get_contents($file)) {
				if($type == 'js') {
					parent::$values[$type] .= '<script type="text/javascript" src="'.$file.'"></script>';
				} elseif($type == 'css') {
					parent::$values[$type] .= '<link href="'.$file.'" rel="stylesheet" type="text/css" />';
				};
            } else {
				throw new Exception('File '.$file.' not found! Please check it!');
            }
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }
    }
    
    private function return_input($type, $array) {
        $this->properties($array);
        return $this->$type();
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
    
    public function post_is_valide() {
        $data = isset($_SESSION['post_is_valide']) ? $_SESSION['post_is_valide'] : false;
        unset($_SESSION['post_is_valide']);
        return $data;
    }
    
    public function validate($data) {
		$value = isset($_SESSION['validate'][$data]) ? $_SESSION['validate'][$data]: '';
        return $value;
    }
    
    public function url($table = '') {
        $try = $this->db()
                 ->table($table)
                 ->select('theme')
                 ->where('`theme` = \''.$this->validate('theme').'\'')
                 ->num();
        $array = array(' '      => '_',
                       '%20'    => '_',
                       ','      => '_',
					   
                       );
        return ($try == 0 || $try == 1) ? strtr($this->validate('theme'), $array) : strtr($this->validate('theme').$try, $array);
    }
    
    function __destruct() {
        unset($this->html);
    }
}