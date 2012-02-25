<?php
class Router extends Registry_interface {
    private $path;
    private $url;
    private $app_path;
    
    function __construct() {
        $this->url = strtolower($_SERVER['QUERY_STRING']);
        $this->init();
    }
    
    /*
     * @param run router
     */
    
    protected function init() {
        $this->clean_up();
        $this->load();
    }
    
    /*
     *  @param create array from str url and if last element is empty put "index"
     *  @return none;
     */
    
    private function parse_url() {
        $path = explode('/', $this->path);

        foreach ($path as $key => $value){
            if(empty($value)) {
                unset($path[$key]);
            };
        }
        $this->path = $path;
    }
    
    /*
     *   @param clean_up - check is url clean.
     *   @return checked url or if not cut bed simbols and redirect to clean url
     */
    
    private function clean_up() {
        $array = array('"'  => '',
                       '\\' => '',
                       '\'' => '',
                       '@'  => '',
                       '$'  => '',
                       '^'  => '',
                       '#'  => '',
                       '%'  => '',
                       '?'  => '',
                       ' '  => '',
                       '..' => '',
                       '<'  => '',
                       '>'  => '',
                       '&'  => '');
        $this->path = strtr($this->url,$array+array('href='=>''));
        $this->url!==strtr($this->url,$array) ? $this->reload_page() : '';
    }
    
    /*
     * @param - using whith clean_up function for refresh page
     * @return - none; 
     */
    
    private function reload_page() {
        header('Location: '.BASE_HREF.$this->path);
    }
    
    /*
     *  @param - load controller
     *  @return - none;
     */
    
    private function load() {
        set_include_path(PATH);    
        if($this->registry()->get('routes', $this->path)) {
            $this->path = $this->registry()->get('routes', $this->path);
        }; 
        $this->parse_url();
        
        $PATH = '/controllers/Controller_'.$this->path[0].'.php';

        if(is_file(APP_PATH.$PATH) || is_file(SYS_PATH.$PATH)) {
            $class = 'Controller_'.$this->path[0];
            $PATH = is_file(APP_PATH.$PATH) ? APP_PATH.$PATH : SYS_PATH.$PATH;
            include_once($PATH);
        } else {
            $class = 'sys_404';
            include_once(SYS_PATH.'/controllers/sys_404.php');
        };
        
        $controller = new $class();
        $action = !isset($this->path[1]) || is_callable(array($controller, $this->path[1])) == false
                    ? 'index'
                    : $this->path[1];
        unset($this->path[0], $this->path[1]);
        
        $this->registry()->set($this->path, 'values');
        
        $controller->$action();
    }
    
    function __destruct() {
        unset($this->path);
    }
}