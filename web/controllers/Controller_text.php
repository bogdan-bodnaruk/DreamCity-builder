<?php
class Controller_text extends Controller {
    public function index() {
        echo 1;
    }

    public function text() {
        $this->template()->load('textfields.tpl')->show();
    }
}