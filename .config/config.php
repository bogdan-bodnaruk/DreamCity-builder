<?php
$config = array(/* main settings */
                'system_path'       =>  'DRM',
                'library_path'	    =>  'library',
                'app_path'	        =>	'web',
                'main_page'         =>  'index',
                'encoding'          =>  'UTF-8',
                'main_template'     =>  'main.tpl',
                'main_content_value'=>  'content',      
                'base_href'         =>  'http://engine.drm/',
                'time_zone'         =>  'Europe/Kiev',
                'statistic'         =>  true,
                'default_i18n'      =>  'en',
                'all_i18n'          =>  array('all', 'en', 'ua'),
                'names_i18n'        =>  array('All', 'English', 'Українська'),
                'title'             =>  'DRM',
                'comment'           =>  'true',
                'ajax'              =>  false,
                'env'               =>  'test', //if production whan all css and js will be minimized production
                'client_css'        =>  'web/theme/css',

                /* default values for html */
                'input_size'        =>  15,
                'input_max_chars'   =>  1000,
                'textarea_cols'     =>  25,
                'textarea_rows'     =>  5,
                'warning_class'     =>  'warning',
                'error_class'       =>  'error',
                
                /* db settings */
                'db_host'           =>  'localhost',
                'db_user'           =>  'root',
                'db_password'       =>  'root',
                'db_table'          =>  'engine',
                'db_encoding'       =>  'utf8',
                
                /*paginator */
                'on_page'           =>  5,
                'paginator_class'   =>  'class="paginator"',
                'active_link'       =>  'class="active_link"',
                'paginator_link'    =>  'class="link"'
        );

$config['library'] = ($config['env'] == 'production') ? '/'.$config['library_path'].'/min/?f='.$config['library_path'] : $config['library_path'];