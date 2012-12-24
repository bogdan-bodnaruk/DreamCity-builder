<?php
class Controller_min extends Controller {
    private $css = '';
    private $temp = '';

    private $colors = array(
        '#000000' =>  '#000',
        '#111111' =>  '#111',
        '#222222' =>  '#222',
        '#333333' =>  '#333',
        '#444444' =>  '#444',
        '#555555' =>  '#555',
        '#666666' =>  '#666',
        '#777777' =>  '#777',
        '#888888' =>  '#888',
        '#999999' =>  '#999',
        '#AAAAAA' =>  '#AAA',
        '#BBBBBB' =>  '#BBB',
        '#CCCCCC' =>  '#CCC',
        '#DDDDDD' =>  '#DDD',
        '#EEEEEE' =>  '#EEE',
        '#FFFFFF' =>  '#FFF',
        '#FF0000' =>  '#F00'
    );

    public function __construct() {
        parent::__construct();
    }

    public function index() {

    }

    public function css() {
        include_once(PATH.'.config/dependencies.php');
        $this->val('f');
        $this->temp = PATH.$this->registry()->config['app_path'].'/theme/.temp';

        $files = explode(';',$this->val['f']);
        for($i=0;$i<count($files);$i++) {
            if(!empty($files[$i])) {
                $this->css .= file_get_contents(PATH.$D_css[$files[$i]]);
            };
        }
        if($this->registry()->config['env']=='production') {
            $this->css = strtr($this->css, $this->colors);
            $this->css = preg_replace("/[\/*]{2}(.)+[*\/]{2}/sU", '', $this->css);
            $this->css = strtr($this->css,
                array(';;'      =>  ';',
                      "\r"      =>  '',
                      "\n"      =>  '',
                      "\t"      =>  '',
                      ": "      =>  ':',
                      ' ;'      =>  ';',
                      '  '      =>  '',
                      ' {'      =>  '{',
                      ', '      =>  ',',
                      ' 0px'    =>  ' 0',
                      ':0px'    =>  ':0',
                      ' /'      =>  '',
                      '/**/'    =>  '',
                )
            );

            $this->css = strtr($this->css,
                array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                      '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'])
            );

            header("Content-Encoding: gzip");
            header("Content-type: text/css", true);
            header("Cache-Control: max-age=2592000");
            header("Pragma: public");
            header("ETag: ".md5($this->val['f']));
            echo gzencode($this->css, 9, FORCE_GZIP);

            file_put_contents($this->temp.'/'.md5($this->val['f']).'.css', $this->css);
        } else {
            header("Content-type: text/css", true);
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            $this->css = strtr($this->css,
                array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                      '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'])
            );
            echo $this->css;
        };
    }
}