<?php
include_once(PATH.'.config/config.php');
define('SYS_PATH', PATH.$config['system_path']);
define('APP_PATH', PATH.$config['app_path']);

/*
 *  @param str $class name for autoload class
 *  @return object;
 */
function __autoload($class) {
    set_include_path(SYS_PATH);
    if(is_file(get_include_path().'/'.$class.'.php')) {
        include_once(get_include_path().'/'.$class.'.php'); 
    } else {
        die('Fatal Error: File ['.get_include_path().'/'.$class.'.php] NOT found! Please FIX it!');
    };              
} 