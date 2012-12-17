<?php
class request extends Controller {
    public function index () {
        $this->_404();
    }
     
    public function _404() {
        Logger::error('404 - Page not found!');
        $this->registry()->PATH = PATH.'DRM';
        $this->template()->load('not_found.tpl')->show();
    }
}