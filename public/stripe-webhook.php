<?php
if (empty($no_load)){
	require_once '../../../../wp-load.php';
}
if (!defined('AF_PATH')){
	define('AF_PATH', plugin_dir_path(__DIR__));
}
require_once AF_PATH . 'classes/PayoutStripe.class.php';

$object = new PayoutStripe();
$object->do_webhook();
exit;
