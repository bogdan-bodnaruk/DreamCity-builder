<?php
//error_reporting(0);
class Controller_min extends Controller {
    private $css = '';
    private $js = '';
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

    public function index() {}

    public function css() {
        include_once(PATH.'.config/dependencies.php');
        $this->val('f');

        $this->temp = PATH.$this->registry()->config['app_path'].'/theme/.temp';
        $bundle = true;
        $filesDate = explode(';',$this->val['f']);
        for($i=0;$i<count($filesDate);$i++) {
            if(!empty($filesDate[$i]) && is_file($this->temp.'/'.md5($this->val['f']).'.css')) {
                if(filemtime($this->temp.'/'.md5($this->val['f']).'.css') < filemtime(PATH.$D_css[$filesDate[$i]])) {
                    $bundle = false;
                };
            };
        }


        if(is_file($this->temp.'/'.md5($this->val['f']).'.css') && $this->registry()->config['env']=='production' && $bundle) {
            header("Content-Encoding: gzip");
            header("Content-type: text/css", true);
            header("Cache-Control: must-revalidate, max-age=1200");
            header("Pragma: public");
            header('Vary: Accept-Encoding');
            header("ETag: ".md5($this->val['f']));
            $this->css = file_get_contents($this->temp.'/'.md5($this->val['f']).'.css');
            echo gzencode($this->css, 9, FORCE_GZIP);
            exit();
        } else {
            $files = explode(';',$this->val['f']);
            for($i=0;$i<count($files);$i++) {
                if(!empty($files[$i])) {
                    $this->css .= file_get_contents(PATH.$D_css[$files[$i]]);
                };
            }
            if($this->registry()->config['env']=='production') {
                $this->css = strtr($this->css, $this->colors);
				$this->css = preg_replace("/\s*([@{}:;,]|\)\s|\s\()\s*|\/\*([^*\\\\]|\*(?!\/))+\*\/|[\n\r\t]/s", '$1', $this->css);
				$this->css = strtr($this->css,
					array(':0px'	=> ':0',
						  ',0px'	=> ',0',
						  ' 0px'	=> ' 0',
					)
				);
                $this->css = strtr($this->css,
                    array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                        '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'])
                );

                header("Content-Encoding: gzip");
                header("Content-type: text/css", true);
                header("Pragma: public");
                header('Vary: Accept-Encoding');
                header("ETag: ".md5($this->val['f']));
                echo gzencode($this->css, 9, FORCE_GZIP);

                file_put_contents($this->temp.'/'.md5($this->val['f']).'.css', $this->css);
            } else {
                header("Content-type: text/css", true);
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Vary: Accept-Encoding');

                $this->css = strtr($this->css,
                    array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                          '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'])
                );
                echo $this->css;
            };
        }
    }

    public function js() {
        include_once(PATH.'.config/dependencies.php');
        $this->val('f');
        $this->val('e');
        $this->val('c');

        $this->temp = PATH.$this->registry()->config['app_path'].'/theme/.temp';
        $bundle = true;
        $filesDate = explode(';',$this->val['f']);
        for($i=0;$i<count($filesDate);$i++) {
            if(!empty($filesDate[$i]) && is_file($this->temp.'/'.md5($this->val['f']).'.js')) {
                if(filemtime($this->temp.'/'.md5($this->val['f']).'.js') < filemtime(PATH.$D_js[$filesDate[$i]])) {
                    $bundle = false;
                };
            };
        }

        if(is_file($this->temp.'/'.md5($this->val['f']).'.js') && $this->registry()->config['env']=='production' && $bundle) {
            header("Content-Encoding: gzip");
            header("Content-type: application/x-javascript");
            if($this->val['e']!=="") {
                header("Cache-Control: must-revalidate, max-age=".$this->val['e']);
            } else {
                header("Cache-Control: must-revalidate, max-age=1200");
            };
            header("Pragma: public");
            header('Vary: Accept-Encoding');
            header("ETag: ".md5($this->val['f']));
            $this->js = file_get_contents($this->temp.'/'.md5($this->val['f']).'.js');
            echo gzencode($this->js, 9, FORCE_GZIP);
            exit();
        } else {
            $files = explode(';',$this->val['f']);
            for($i=0;$i<count($files);$i++) {
                if(!empty($files[$i])) {
                    $this->js .= file_get_contents(PATH.$D_js[$files[$i]]);
                };
            }
            if($this->registry()->config['env']=='production') {
                if($this->val['c']!=='false') {
                    $this->js = strtr($this->js, $this->colors);
                    $this->js = strtr($this->js,
                        array('{env}'    =>  $this->registry()->config['env'],
                              '{locale}' =>  $this->lang,
                              '{library}'=>  $this->registry()->config['library_path'])
                    );

                    $this->js = preg_replace('/[ \t]*(?:\/\*(?:.(?!(?<=\*)\/))*\*\/|\/\/[^\n\r]*\n?\r?)/s', '', $this->js);
                    $this->js = preg_replace('/(\n)|(\r)|(\t)/s', '', $this->js);

                    $this->js = strtr($this->js,
                        array(';;'      =>  ';',
                            ": "      =>  ':',
                            ' ;'      =>  ';',
                            '; '      =>  ';',
                            '  '      =>  '',
                            ' {'      =>  '{',
                            ' }'      =>  '}',
                            ' { '     =>  '{',
                            ' } '     =>  '}',
                            '{ '      =>  '{',
                            '} '      =>  '}',
                            ' ('      =>  '(',
                            ' )'      =>  ')',
                            '( '      =>  '(',
                            ') '      =>  ')',
                            ' ) '     =>  ')',
                            ' ( '     =>  '(',
                            ' ['      =>  '[',
                            ' ]'      =>  ']',
                            '[ '      =>  '[',
                            '] '      =>  ']',
                            ' [ '     =>  '[',
                            ' ] '     =>  ']',
                            '; '      =>  ';',
                            ', '      =>  ',',
                            ' 0px'    =>  ' 0',
                            ':0px'    =>  ':0',
                            ' = '     =>  '=',
                            ' ='      =>  '=',
                            '= '      =>  '=',
                            ' > '     =>  '>',
                            ' < '     =>  '<',
                            ' ? '     =>  '?',
                            ' ?'      =>  '?',
                            '? '      =>  '?',
                            ' : '     =>  ':',
                            ' :'      =>  ':',
                            ': '      =>  ':',
                            ' + '     =>  '+',
                            ' +'      =>  '+',
                            '+ '      =>  '+',
                            ' || '    =>  '||',
                            ' ||'     =>  '||',
                            '|| '     =>  '||',
                            ' && '    =>  '&&',
                            ' &&'     =>  '&&',
                            '&& '     =>  '&&',
                        )
                    );
                };

                header("Content-Encoding: gzip");
                header("Content-type: application/x-javascript");
                header("Pragma: public");
                header('Vary: Accept-Encoding');
                header("ETag: ".md5($this->val['f']));
                echo gzencode($this->js, 9, FORCE_GZIP);

                file_put_contents($this->temp.'/'.md5($this->val['f']).'.js', $this->js);
            } else {
                header("Content-type: application/x-javascript");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header('Vary: Accept-Encoding');
                header("Pragma: no-cache");

                $this->js = strtr($this->js,
                    array('{path}'   =>  $this->registry()->config['base_href'].$this->registry()->config['app_path'].'/theme/images',
                          '{library}'=>  $this->registry()->config['base_href'].$this->registry()->config['library_path'])
                );
                echo $this->js;
            };
        }
    }
}