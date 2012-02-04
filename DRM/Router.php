<?php
class Router {
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
        $this->check_app_path();
        $this->clean_up();
        $this->parse_url();
    }
    
    /*
     *  @param create array from str url and if last element is empty put "index"
     *  @return none;
     */
    
    private function parse_url() {
        $path = explode('/', $this->path);
        end($path)=='' ? $path[count($path)-1] = 'index' : '';

        foreach ($path as $key => $value){
            if(empty($value)) {
                unset($path[$key]);
            };
        }
        $this->path = $path;
        //Register::data()->set($path, 'url');
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
     *  @param - this function check application folder
     *  @return - none; If app folder dosn't exist show error and stop script
     */
    
    private function check_app_path() {
        $this->app_path = Register::get('config', 'app_path');
        if(!is_dir(PATH.$this->app_path)) {
            die('Fatal Error: APP dir ['.PATH.$this->app_path.'] NOT found! Please FIX it!');
        };
    }
    
    function __destruct() {
        unset($this->path);
    }
}