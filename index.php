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
 *  2012.02.03 - start project;
 *
 *  @author Bogdan Bodnaruk <babak.47031@gmail.com>
 *  @copyright 2012 Bogdan Bodnaruk
 */

//session_start();
error_reporting(E_ALL);

define('PATH', realpath(dirname(__FILE__)).'/');

include_once(PATH.'.config/config.php');
include_once(PATH.'.config/bootstrap.php');

$DRM = new Controller();

//Register::error('error')->line('10')->type('critical')->set_error();
//$DRM->run();
