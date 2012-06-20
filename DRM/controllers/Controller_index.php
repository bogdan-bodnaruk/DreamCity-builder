<?php
class Controller_index extends Controller {
    
    public function index() {      
        $this->val['content'] = Paginator::tpl('short_news.tpl')->table('news')->where('`protect`<=\''.User::login()->permissions().'\'')->order('id', 'desc')->load();
        $this->template()->load($this->val['content'].'{paginator_buttons}')->show();
    }
}