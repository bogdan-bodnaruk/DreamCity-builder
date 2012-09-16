<?php
/*
 *  v.0.5
 *  
 *  This is a 5'th version of DreamCity. But this version will be in two editions:
 *      1) DreamCity framework (or builder)
 *      2) DreamCity CMS based on DreamCity framework
 *
 *  Project is just for fun, but probably it can be a good start up for busines.
 *  Versions will be graduating for 0.5(start dev) to 1.0 (release)
 *  
 *  2012.02.02 - ending support Dream City CMS builder v.0.3.9. It's last non
 *               MVC version for my web engine.
 *  2012.02.03 - start project (v.0.5);
 *  2012.03.11 - first up version. v.0.6
 *  2012.03.31 - Up version. v.0.7
 *  2012.04.07 - Up version v.0.7.5
 *  2012.09.16 - Up version v.0.8.0
 *
 *  @author Bogdan Bodnaruk <babak.47031@gmail.com>
 *  @copyright 2012 Bogdan Bodnaruk
 */

session_start();
error_reporting(E_ALL);

define('PATH', realpath(dirname(__FILE__)).'/');
include_once(PATH.'.config/config.php');
define('SYS_PATH', PATH.$config['system_path']);
define('APP_PATH', PATH.$config['app_path']);

date_default_timezone_set($config['time_zone']);

/*
 *  @param str $class name for autoload class
 *  @return object;
 */
function __autoload($class) {
    set_include_path(SYS_PATH);
    if(is_file(get_include_path().'/'.$class.'.php')) {
        include_once(get_include_path().'/'.$class.'.php'); 
    } else {
        Logger::error('Fatal Error: File ['.get_include_path().'/'.$class.'.php] NOT found! Please FIX it!');
    };              
}

DRM::run($config);