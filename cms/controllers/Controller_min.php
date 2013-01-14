<?php
error_reporting(E_ALL);
//error_reporting(0);
class Controller_min extends Controller {
    private $css = '';
    private $js = '';
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

    public function index() {}

    public function css() {
        $this->val('f');

        if(is_file($this->temp.'/'.md5($this->val['f']).'.css') && $this->bundleIsValid('_css')) {
            $this->css = file_get_contents($this->temp.'/'.md5($this->val['f']).'.css');
        } else {
            $files = explode(';',$this->val['f']);
            for($i=0;$i<count($files);$i++) {
                if(!empty($files[$i])) {
                    $this->css .= file_get_contents(PATH.$this->_css[$files[$i]]);
                };
            }
            if($this->env()) {
                $this->css = strtr($this->css, $this->colors);
				$this->css = preg_replace("/\s*([@{}:;,]|\)\s|\s\()\s*|\/\*([^*\\\\]|\*(?!\/))+\*\/|[\n\r\t]/s", '$1', $this->css);
            };
            $this->css = strtr($this->css, $this->v);
            $this->createBundle('css');
        };
        $this->cache();
        echo gzencode($this->css, 9, FORCE_GZIP);
    }

    public function js() {
        $this->val('f');

        if(is_file($this->temp.'/'.md5($this->val['f']).'.js') && $this->bundleIsValid('_js')) {
            $this->js = file_get_contents($this->temp.'/'.md5($this->val['f']).'.js');
        } else {
            $files = explode(';',$this->val['f']);
            for($i=0;$i<count($files);$i++) {
                if(!empty($files[$i])) {
                    $this->js .= file_get_contents(PATH.$this->_js[$files[$i]]);
                    if(count($files)>1 && $this->env()) {
                        $this->js = $this->js.'${break}';
                    }
                };
            }

            if($this->env()) {
                $this->val('c');
                if($this->val['c']!=='false') {
                    $this->hash();
                    $this->colors();
                    $this->js = strtr($this->js, $this->colors);
                    $this->js = strtr($this->js,
                        array('{env}'       =>  $this->registry()->config['env'],
                              '{locale}'    =>  $this->lang,
                              '{hash_css}'  =>  $this->hash_css,
                              '{hash_js}'   =>  $this->hash_js,
                              '{library}'   =>  $this->registry()->config['library_path'])
                    );
                    $regex = '(\{|\}|\(|\)|\[|\]|=|\:|\<|\>|\?|\+|\|\||\&&)';

                    $this->js = preg_replace('/[ \t]*(?:\/\*(?:.(?!(?<=\*)\/))*\*\/|\/\/[^\n\r]*\n?\r?)/s', '', $this->js);
                    $this->js = preg_replace('/(\n)|(\r)|(\t)/s', '', $this->js);
                    $this->js = preg_replace('/(\s)+'.$regex.'/s', '$2', $this->js);
                    $this->js = preg_replace('/'.$regex.'(\s)+/s', '$1', $this->js);
                };
            };
            $this->js = strtr($this->js, $this->v);
            $this->createBundle('js');
        };
        $this->cache();
        echo gzencode($this->js, 9, FORCE_GZIP);
    }

    private function clearBundleFolder() {
        exec("rm -r ".$this->temp);
    }

    private function createBundle($type = '') {
        if($this->registry()->config['min_write_bundles'] && $this->env()) {
            $this->val('e');
            if($this->val['e']!=='0') {
                file_put_contents($this->temp.'/'.md5($this->val['f']).'.'.$type, $type == 'js' ? $this->js : $this->css);
            };
        };
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
        if(!empty($this->js)) {
            header("Content-type: application/x-javascript");
        } else {
            header("Content-type: text/css", true);
        };
    }

    private function env() {
        return $this->registry()->config['env']=='production' ? true : false;
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
