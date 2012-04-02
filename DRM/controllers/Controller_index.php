<?php
class Controller_index extends Controller {
    
    public function index() {
        $this->val['content'] = Paginator::tpl('short_news.tpl')->table('news')->order('id')->load();
        $this->template()->load($this->val['content'])->main();
    }
}