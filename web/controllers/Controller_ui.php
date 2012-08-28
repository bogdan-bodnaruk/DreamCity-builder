<?php
class Controller_ui extends Controller {
    public function index() {
        $this->val['value'] = 'test';
        $this->template()->load('test_values.tpl')->show();
    }

    public function textfields() {
        $this->val['text'] = 'Test value';
        $this->template()->load('textfield.tpl')->show();
    }

    public function textarea() {
        $this->template()->load('textarea.tpl')->show();
    }

    public function submit_and_button() {
        $this->template()->load('submit.tpl')->show();
    }

    public function ckeditor() {
        $this->template()->load('ckeditor.tpl')->show();
    }

    public function select() {
        $this->val['data']['text_test1'] = array('{config::app_path}', 'test2');
        $this->template()->load('select.tpl')->show();
    }

    public function radio() {
        $this->val['data']['array'] = array('{config::app_path}', 'qwe');
        $this->template()->load('radio.tpl')->show();
    }

    public function checkbox() {
        $this->val['data']['array'] = array('{config::app_path}', 'test');
        $this->template()->load('checkbox.tpl')->show();
    }
    
    public function specials() {
        $this->template()->load('specials.tpl')->show();
    }
}