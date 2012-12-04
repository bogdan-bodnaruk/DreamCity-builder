<?php
class Controller_index extends DRM {
    public function index() {
        setcookie('direction', 'DESC', time()+144000);
        setcookie('order', 'id', time()+144000);
        setcookie('onpage', $this->registry()->config['on_page'], time()+144000);
        Go::to('ui');
    }
}