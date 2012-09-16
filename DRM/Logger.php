<?php
class Logger extends DRM {
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
    
    static public function update($text = 'No messagge :(', $protect = 'all') {
        if(!self::registry()->config['log_changes_to_db'] || !self::registry()->config['DB-connected']) {
            parent::db()->table('updates')
                        ->insert(array('message'   =>  $text,
                                       'time'      =>  'NOW()',
                                       'protect'   =>  $protect))
                        ->query();
        }
    }
}