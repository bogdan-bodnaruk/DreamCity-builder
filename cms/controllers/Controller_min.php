<?php
class Controller_min extends Controller {
    private $css = '';
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

    public function index() {

    }

    public function css() {
        $this->val('f');
        $files = explode(';',$this->val['f']);
        for($i=0;$i<count($files);$i++) {
            if(!empty($files[$i])) {
                $this->css .= file_get_contents(PATH.$this->registry()->config['client_css'].'/'.$files[$i].'.css');
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
                )
            );

            header("Content-Encoding: gzip");
            header("Content-type: text/css", true);
            header("Cache-Control: max-age=2592000");
            header("Pragma: public");
            echo gzencode($this->css, 9, FORCE_GZIP);
        } else {
            header("Content-type: text/css", true);
            echo $this->css;
        };
    }
}