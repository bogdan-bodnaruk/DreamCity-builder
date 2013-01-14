<?php
error_reporting(E_ALL);
//error_reporting(0);
class Controller_min extends Controller {
    private $data = '';
    private $temp = '';
    private $hash_css = 0;
    private $hash_js = 0;

    public function __construct() {
        parent::__construct();
        include_once(PATH.'.config/dependencies.php');
        $this->_js = $_js;
        $this->_css = $_css;
        $this->temp = PATH.$this->registry()->config['app_path'].'/theme/bundle';
        $this->v = array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                         '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'],
                         '${break}' =>  "\n",
                         ':0px'	    => ':0',
                         ',0px'	    => ',0',
                         ' 0px'	    => ' 0',
                         ';;'       =>  ';',
                         '  '       =>  '',
        );
    }

	public function index() {
		$this->val('f'); 
		$this->val('type'); 

		if(is_file($this->temp.'/'.md5($this->val['f']).'.'.$this->val['type']) && $this->bundleIsValid('_'.$this->val['type'])) {
			$this->data = file_get_contents($this->temp.'/'.md5($this->val['f']).'.'.$this->val['type']);
		} else {
			$files = explode(';',$this->val['f']);
			for($i=0;$i<count($files);$i++) {
				if(!empty($files[$i])) {
					if($this->val['type']=='js') {
						$this->data .= file_get_contents(PATH.$this->_js[$files[$i]]).(count($files)>1 && $this->env() ? '${break}' : '');
					} else {
						$this->data .= file_get_contents(PATH.$this->_css[$files[$i]]);
					};
				};
			}
			if($this->env()) {
				$this->colors();
				$this->data = strtr($this->data, $this->colors);
				if($this->val['type'] == 'css') {
					$this->data = preg_replace("/\s*([@{}:;,]|\)\s|\s\()\s*|\/\*([^*\\\\]|\*(?!\/))+\*\/|[\n\r\t]/s", '$1', $this->data);    
				};
				if($this->val['type'] == 'js') {
					$this->val('c');
					if($this->val['c']!=='false') {
						$this->hash();
						$this->data = strtr($this->data,
							array('{env}'       =>  $this->registry()->config['env'],
								  '{locale}'    =>  $this->lang,
								  '{hash_css}'  =>  $this->hash_css,
								  '{hash_js}'   =>  $this->hash_js,
								  '{library}'   =>  $this->registry()->config['library_path'])
						);
						$regex = '(\{|\}|\(|\)|\[|\]|=|\:|\<|\>|\?|\+|\|\||\&&)';

						$this->data = preg_replace('/[ \t]*(?:\/\*(?:.(?!(?<=\*)\/))*\*\/|\/\/[^\n\r]*\n?\r?)/s', '', $this->data);
						$this->data = preg_replace('/(\n)|(\r)|(\t)/s', '', $this->data);
						$this->data = preg_replace('/(\s)+'.$regex.'/s', '$2', $this->data);
						$this->data = preg_replace('/'.$regex.'(\s)+/s', '$1', $this->data);
					};
				};
			};

			$this->data = strtr($this->data, $this->v);
			$this->createBundle($this->val['type']);
		};
		$this->cache();
		echo gzencode($this->data, 9, FORCE_GZIP);
	}
	
    private function clearBundleFolder() {
        exec("rm -r ".$this->temp);
    }

    private function bundleIsValid($type = '') {
        $bundle = true;
        $filesDate = explode(';',$this->val['f']);
        for($i=0;$i<count($filesDate);$i++) {
            if(!empty($filesDate[$i]) && is_file($this->temp.'/'.md5($this->val['f']).'.'.$type)) {
                if(filemtime($this->temp.'/'.md5($this->val['f']).'.'.$type) < filemtime(PATH.$this->$$type[$filesDate[$i]])) {
                    $bundle = false;
                };
            };
        }
        return !$this->env() ? false : $bundle;
    }

    private function env() {
        return $this->registry()->config['env']=='production' ? true : false;
    }
	
	private function createBundle($type = '') {
		if($this->registry()->config['min_write_bundles'] && $this->env()) {
			$this->val('e');
			if($this->val['e']!=='0') {
				file_put_contents($this->temp.'/'.md5($this->val['f']).'.'.$type, $this->data);
			};
		};
	}
	
	private function cache() {
		if($this->registry()->config['min_use_cache']) {
			$this->val('e');
			$cache = $this->val['e']!=="" ? $this->val['e'] : '1209600';
			header("Cache-Control: must-revalidate, max-age=".$cache);
			header("Pragma: public");
		} else {
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
		};
		header("Content-Encoding: gzip");
		header('Vary: Accept-Encoding');
		header("ETag: ".md5($this->val['f']));
		if($this->val['type']=='js') {
			header("Content-type: application/x-javascript");
		} else {
			header("Content-type: text/css", true);
		};
	}
	
    private function hash() {
        foreach($this->_css as $key => $value) {
            $this->hash_css += filemtime(PATH.$this->_css[$key]);
        }
        $this->hash_css = $this->registry()->config['min_use_cache'] ? $this->hash_css.'/' : '';

        foreach($this->_js as $key => $value) {
            $this->hash_js += filemtime(PATH.$this->_js[$key]);
        }
        $this->hash_js = $this->registry()->config['min_use_cache'] ? $this->hash_js.'/' : '';
    }
    
    private function colors() {
        $hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','a','b','c','d','e','f');

        for($i=0;$i<count($hex);$i++) {
            for($j=0;$j<count($hex);$j++) {
                for($h=0;$h<count($hex);$h++) {
                    $color_long = $hex[$i].$hex[$i].$hex[$j].$hex[$j].$hex[$h].$hex[$h];
                    $color_short = $hex[$i].$hex[$j].$hex[$h];
                    $this->colors['#'.$color_long] = '#'.$color_short;
                }
            }
        }
    }
}