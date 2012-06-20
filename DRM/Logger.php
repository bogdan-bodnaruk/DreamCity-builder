<?php
class Logger extends DRM {
    static public function error($data) {
        file_put_contents(PATH.'.log/'.date('Y.m.d').'.log', date('Y.m.d H:i').' - '
            .$data.' called in http://'.$_SERVER ['SERVER_NAME'].$_SERVER ['REQUEST_URI']."\r", FILE_APPEND); 
    }
    
    static public function update($text = 'No messagge :(', $protect = 'all') {
        parent::db()->table('updates')
                    ->insert(array('message'   =>  $text,
                                   'time'      =>  'NOW()',
                                   'protect'   =>  $protect))
                    ->query();
    }
}