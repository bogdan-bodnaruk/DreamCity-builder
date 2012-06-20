<?php
class Go extends DRM {
    static public function main() {
        self::refresh(parent::registry()->config['base_href'].parent::registry()->config['main_page']);
    }
    
    static public function back() {
        $back = !isset($_SERVER['HTTP_REFERER']) ? self::main() : $_SERVER['HTTP_REFERER'];
        self::refresh($back);
    }
    
    static public function to($url = '') {
        self::refresh(parent::registry()->config['base_href'].($url=='/' ? '' : $url));
    }
    
    private function refresh($url) {
        if(parent::registry()->config['ajax']) {
            if(parent::registry()->config['ajax'] && ((isset($_GET['ajax']) && $_GET['ajax']=='true') || (isset($_POST['ajax']) && $_POST['ajax']=='true'))) {
                $url .= '?ajax=true';
            };
        };
        header('Location: '.$url);
    }
    
    static public function reload($destination='') {
        $destination = empty($destination) ? $_SERVER['HTTP_REFERER'] : $destination;
        echo '<script type="text/javascript">window.location.href="'.$destination.'"</script>';
    }
}