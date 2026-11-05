<?php

if (!defined('WP_UNINSTALL_PLUGIN')){
	exit();
}

if ( !defined('AF_PATH')){
    define( 'AF_PATH', plugin_dir_path(__FILE__) );
}

if ( !defined('AF_URL')){
    define( 'AF_URL', plugin_dir_url(__FILE__) );
}

require_once AF_PATH . 'autoload.php';
require_once AF_PATH . 'utilities.php';

if ( get_option('af_keep_data_after_delete') == 1 ){
		return;
}


include AF_PATH . 'classes/AfDb.class.php';
$af_uninstall_object = new AfDb();
$af_uninstall_object->unistall();
