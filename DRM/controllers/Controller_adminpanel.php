<?php
class Controller_adminpanel extends DRM {
    public function index() {
        $_SESSION['status']=='admin'
            ? $this->template()->load('adminpanel.tpl')->show()
            : Go::back();
    }
    
    public function ajax() {
        $_SESSION['status']=='admin'
            ? $this->template()->load('adminpanel.tpl')->ajax()
            : Go::main();
    }
}