<?php
/*
 *  Website: http://babak.if.ua
 *  GIT: https://github.com/babak49/DreamCity-builder
 *
 *  Project is just for fun, but probably it can be a good start up for busines.
 *  Versions will be graduating for 0.5(start dev) to 1.0 (release)
 *  
 *  2012.02.02 - ending support Dream City CMS builder v.0.3.9. It's last non
 *               MVC version for my web engine.
 *  2012.02.03 - start project (v.0.5);
 *  2012.03.11 - first up version. v.0.6
 *  2012.03.31 - Up version. v.0.7
 *  2012.04.07 - v.0.7.5
 *  2012.09.16 - v.0.8.0 (commit b41248df62dba6257d1144db4d6fdfbc45f684a9)
 *  2012.10.02 - v.0.8.2 (commit 16deb33feea6550a0bcc174404931c3786e4f8a6)
 *  2012.12.03 - v.0.9.0 (commit 833662b0377d93feacf5926b6044117ae45ae617)
 *  2012.12.16 - v.0.9.4 (commit 18be9ecce3001ba2bef5ae5ab25c33b472dbc0ff)
 *  2013.01.13 - v.0.9.5 (commit 9204dac8f992db562a607ae61d63ae1662f77bef)
 *  2013.01.20 - v.0.9.6
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
define('CMS_PATH', PATH.$config['cms_path']);

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