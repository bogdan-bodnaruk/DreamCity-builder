<?php
class Go extends DRM {
    static public function main() {
        header('Location: '.parent::registry()->config['base_href']);
    }
    
    static public function back() {
        header('Location: '.!isset($_SERVER['HTTP_REFERER']) ? self::main() : $_SERVER['HTTP_REFERER']);
    }
    
    static public function to($url) {
        header('Location: '.parent::registry()->config['base_href'].$url);
    }
}