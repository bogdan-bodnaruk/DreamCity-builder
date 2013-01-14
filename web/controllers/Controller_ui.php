<?php
class Controller_ui extends Controller {
    public function index() {
        $this->val['value'] = 'test';
        $this->template()->load('ui/test_values.tpl')->show();
    }

    public function textfields() {
        $this->val['text'] = 'Test value';
        $this->template()->load('ui/textfield.tpl')->show();
    }

    public function textarea() {
        $this->template()->load('ui/textarea.tpl')->show();
    }

    public function submit_and_button() {
        $this->template()->load('ui/submit.tpl')->show();
    }

    public function ckeditor() {
        $this->template()->load('ui/ckeditor.tpl')->show();
    }

    public function select() {
        $this->val['data']['text_test1'] = array('{config::app_path}', 'test2');
        $this->template()->load('ui/select.tpl')->show();
    }

    public function radio() {
        $this->val['data']['array'] = array('{config::app_path}', 'qwe');
        $this->template()->load('ui/radio.tpl')->show();
    }

    public function checkbox() {
        $this->val['data']['array'] = array('{config::app_path}', 'test');
        $this->template()->load('ui/checkbox.tpl')->show();
    }
    
    public function specials() {
        $this->template()->load('ui/specials.tpl')->show();
    }

    public function fancybox() {
        $this->val['file']['data'] = array('3.jpg','4.jpg','5.jpg');
        $this->val['path'] = $this->registry()->config['library_path'].'/fancybox/demo/';
        $this->val['thumb_path'] = $this->registry()->config['library_path'].'/fancybox/demo/thumb/';
        $this->val['map'] = 'http://maps.google.com/?output=embed&amp;f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=London+Eye,+County+Hall,+Westminster+Bridge+Road,+London,+United+Kingdom&amp;hl=lv&amp;ll=51.504155,-0.117749&amp;spn=0.00571,0.016512&amp;sll=56.879635,24.603189&amp;sspn=10.280244,33.815918&amp;vpsrc=6&amp;hq=London+Eye&amp;radius=15000&amp;t=h&amp;z=17';

        $this->template()->load('ui/fancybox.tpl')->show();
    }

    public function kcaptcha() {
        $this->template()->load('ui/kcaptcha.tpl')->show();
    }

    public function validate() {
        $this->template()->load('ui/validate.tpl')->show();
    }
}