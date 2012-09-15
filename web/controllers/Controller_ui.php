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

    public function fancybox() {
        $this->val['file']['data'] = array('3.jpg','4.jpg','5.jpg');
        $this->val['path'] = $this->registry()->config['library_path'].'/fancybox/demo/';
        $this->val['thumb_path'] = $this->registry()->config['library_path'].'/fancybox/demo/thumb/';
        $this->val['map'] = 'http://maps.google.com/?output=embed&f=q&source=s_q&hl=en&geocode=&q=London+Eye,+County+Hall,+Westminster+Bridge+Road,+London,+United+Kingdom&hl=lv&ll=51.504155,-0.117749&spn=0.00571,0.016512&sll=56.879635,24.603189&sspn=10.280244,33.815918&vpsrc=6&hq=London+Eye&radius=15000&t=h&z=17';

        $this->template()->load('fancybox.tpl')->show();
    }

    public function kcaptcha() {
        $this->template()->load('kcaptcha.tpl')->show();
    }
}