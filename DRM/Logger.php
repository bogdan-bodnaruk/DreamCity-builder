<?php
class Logger extends DRM {
    static private $text = '';
    static private $type = 'default';
    private $protect = 'all';

    static public function error($data) {
        if(self::registry()->config['log_error_to_file']) {
            if(!is_dir(PATH.'.log')) {
                mkdir(PATH.'.log');
                chmod(PATH.'.log', 0777);
            };
            file_put_contents(PATH.'.log/'.date('Y.m.d').'.log', date('Y.m.d H:i').' - '
                .$data.' called in http://'.$_SERVER ['SERVER_NAME'].$_SERVER ['REQUEST_URI']."\r", FILE_APPEND);
        };
    }
    
    static public function RA($text = 'No messagge') {
        self::$text = $text;
        return new self();
    }

    static public function type($type = 'default') {
        self::$type = $type;
        return new self();
    }

    public function protect($protect = 'all') {
        self::$protect = $protect;
        return $this;
    }

    public function save() {
        if($this->registry()->config['log_changes_to_db'] && $this->registry()->config['DB-connected']) {
            if($this->prev_other()) {
                $name = $this->db()->table('users')->select(array('name','surname'))->where('`login` = \''.$_SESSION['login'].'\'')->limit(1)->fetch();
                $this->db()->table('RA')
                           ->insert(array('message'   =>  self::$text,
                                          'time'      =>  'NOW()',
                                          'protect'   =>  $this->protect,
                                          'login'     =>  $_SESSION['login'],
                                          'name'      =>  $name['name'].' '.$name['surname'],
                                          'type'      =>  self::$type))
                           ->query();
            };
        };
    }

    private function prev_other() {
        $data = $this->db()->table('RA')->select()->order('id','DESC')->limit(1)->fetch();
        if($data['message'] == self::$text && $data['type'] == self::$type && $data['login'] == $_SESSION['login']) {
            return false;
        } else {
            return true;
        };
    }
}