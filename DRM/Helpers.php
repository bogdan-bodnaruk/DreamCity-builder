<?php
class Helpers extends DRM {
    static public $format;

    public function index() {}

    static public function parseDate($date, $format = 'mm/dd/yyyy') {
        $date = explode('/', $date);
        if($format == 'mm/dd/yyyy') {
            return array('mm'   => $date[0],
                         'dd'   => $date[1],
                         'yyyy' => $date[2]);
        };
    }

    static public function dayDiffs($date_from = 'now', $date_to = 'now', $format = 'mm/dd/yyyy') {
        self::$format = $format;
        return (self::returnTime($date_from)-self::returnTime($date_to))/86400;
    }


    static private function returnTime($date) {
        if($date == 'now' || empty($date)) {
            return mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        } else {
            $date = self::parseDate($date, self::$format);
            return mktime(0, 0, 0, $date['mm'], $date['dd'], $date['yyyy']);
        };
    }

    static public function direction() {
        if(self::getValue('direction')!=='') {
            setcookie('direction',self::getValue('direction'),time()+14400);
            Go::back();
        };
        return (isset($_COOKIE['direction']) && $_COOKIE['direction']== 'asc') ? 'ASC' : 'DESC';
    }

    static public function order($name = 'order') {
        if(self::getValue($name)!=='' && preg_match("/[a-z]{0,100}/", self::getValue($name))) {
            setcookie($name,self::getValue($name),time()+14400);
            Go::back();
        } elseif(!isset($_COOKIE[$name])) {
            setcookie($name,'id',time()+14400);
            Go::back();
        };
        return $_COOKIE[$name];
    }

    static public function getValue($type) {
        for($i=0; $i<count(self::registry()->values); $i++) {
            if(preg_match('/^'.$type.'\=[0-9a-zA-Z\,]+/', self::registry()->values[$i])) {
                list($text, $value) = explode('=', self::registry()->values[$i]);
                return $value;
            };
        }
        return '';
    }

    static public function get_file($file) {
        if (file_exists($file)) {
            if (ob_get_level()) {
                ob_end_clean();
            };
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            if ($fd = fopen($file, 'rb')) {
                while (!feof($fd)) {
                    print fread($fd, 1024);
                }
                fclose($fd);
            };
            exit;
        } else {
            Go::back();
        };
    }

    static public function view_file($file) {
        if (file_exists($file)) {
            if (ob_get_level()) {
                ob_end_clean();
            };
            header('Content-Type: application/images');
            if ($fd = fopen($file, 'rb')) {
                while (!feof($fd)) {
                    print fread($fd, 1024);
                }
                fclose($fd);
            };
            exit;
        } else {
            Go::back();
        };
    }
}