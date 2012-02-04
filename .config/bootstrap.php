<?php
/*
 *  @param this file is only for start script
 */

set_include_path(PATH.$config['system_path']);

/*
 *  @param str $class name for autoload class
 *  @return object;
 */

function __autoload($class) {
    if(is_file(get_include_path().'/'.$class.'.php')) {
        include_once(get_include_path().'/'.$class.'.php'); 
    } else {
        die('Fatal Error: File ['.get_include_path().'/'.$class.'.php] NOT found! Please FIX it!');
    };
} 

Register::data()->set($config, 'config');

/*
 * SYS_PATH it's constant where saving location for user website
 */
 
!is_dir(PATH.$config['system_path'])
    ? user_error('Folder ['.$config['system_path'].'] not created!')
    : define('SYS_PATH', PATH.$config['system_path']);
    
