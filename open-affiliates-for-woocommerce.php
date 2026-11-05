<?php

/*
Plugin Name: Open Affiliates
Plugin URI: https://github.com/fredpiuma/open-affiliates-for-woocommerce
Description: Open-source affiliate system for WooCommerce and other stores: referral tracking, commissions, ranks, MLM, payouts and affiliate portal.
Version: 1.0.0
Requires at least: 6.0
Requires PHP: 7.4
Author: Frederico de Castro
Author URI: https://www.fredericodecastro.com.br/links/
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: openaffiliates
Domain Path: /languages

@package        Open Affiliates
@author         Frederico de Castro
@license        GPL-2.0-or-later

Based on "Ultimate Affiliate Pro" 9.4.1 by WPIndeed Development (GPL). See CREDITS.md.
*/




class AF_Main{

	private static $instance = FALSE;



	public function __construct(){}


	/**

	* @param none

	* @return none

	*/

	public static function run()

	{

		if (self::$instance==TRUE){

			return;

		}

		self::$instance = TRUE;

		/// PATHS

		if (!defined('AF_PATH')){

			define('AF_PATH', plugin_dir_path(__FILE__));

		}

		if (!defined('AF_URL')){

			define('AF_URL', plugin_dir_url(__FILE__));

		}

		if (!defined('AF_MAIN_FILE_NAME')){

			$afMainFileName = str_replace( AF_PATH, '', __FILE__ );

			define('AF_MAIN_FILE_NAME', $afMainFileName );

		}

		if (!defined('AF_PROTOCOL')){

			if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){

				define('AF_PROTOCOL', 'https://');

			} else {

				define('AF_PROTOCOL', 'http://');

			}

		}



		if (!defined('AF_PLUGIN_VER')){

			define('AF_PLUGIN_VER', self::get_plugin_ver() );//used for updates

		}



		if (!defined('AF_REPO_URL')){
			define('AF_REPO_URL', 'https://github.com/fredpiuma/open-affiliates-for-woocommerce');
		}

		if (!defined('AF_DOCS_URL')){
			define('AF_DOCS_URL', AF_REPO_URL . '/tree/main/docs');
		}
		/// LANGUAGES

		add_action('init', array('AF_Main', 'af_load_language'));

		add_filter('send_password_change_email', array('AF_Main', 'af_update_passowrd_filter'), 99, 2);

		add_filter('wp_authenticate_user', array('AF_Main', 'af_authenticate_filter'), 9999, 3);



		require_once AF_PATH . 'autoload.php';

		require_once AF_PATH . 'utilities.php';

		require_once AF_PATH . 'classes/AfDb.class.php';



		register_activation_hook( __FILE__, array( 'AF_Main', 'onActivation') );



		add_filter( 'et_grab_image_setting', [ 'AF_Main', 'diviGrabImage' ], 999, 1 );



		global $af_db;

		$af_db = new AfDb();

		$AfGDPR = new OpenAffiliates\AfGDPR();

		require_once AF_PATH . 'classes/AfAjax.class.php';

		$af_ajax = new AfAjax();



		//since version 8.5

		// wizard

		$AfWizard = new \OpenAffiliates\Admin\Wizard();




		// end version 8.5



		add_action( 'init', [ 'AF_Main', 'createBaseObject'] );



		/// CRON

		require_once AF_PATH . 'classes/AfCronJobs.class.php';

		$af_cron_object = new AfCronJobs();



		/// ADMIN MENU && NOTIFICATIONS

		add_action('admin_bar_menu', array('AF_Main', 'af_add_custom_top_menu_dashboard'), 995);

		add_action('admin_bar_menu', array('AF_Main', 'add_custom_admin_bar_item'), 996);

		add_filter('query_vars', array('AF_Main', 'edit_query_vars'), 991, 1);

		add_action('init', array('AF_Main', 'do_add_rewrite_endpoint_af'), 30);

		add_action('init', array('AF_Main', 'af_gate'), 92);

		add_action( 'init', [ 'AF_Main', 'check_user_privilege' ], 1 );



		///other modules

		require_once AF_PATH . 'classes/WPSocialLoginIntegration.class.php';

		WPSocialLoginIntegration::run();



		$RewriteDefaultWpAvatar = new \OpenAffiliates\RewriteDefaultWpAvatar();

		$LoadTemplates = new \OpenAffiliates\LoadTemplates();

		if ( class_exists( 'WP_REST_Controller' ) ){

				$afRestAPI = new \OpenAffiliates\RestAPI();

		}

		$wpmlActions = new \OpenAffiliates\WPMLActions();

		$PayToBecomeAffiliate = new \OpenAffiliates\PayToBecomeAffiliate();



		/// elementor

		$elementorIntegration = new \OpenAffiliates\RegisterElementorWidgets();

		$gutenbergIntegration = new \OpenAffiliates\GutenbergEditorIntegration();

		$UploadFilesSecurity = new \OpenAffiliates\UploadFilesSecurity();



		$afGeneralActions = new \OpenAffiliates\GeneralActions();




		$WooSpecificReferralRates = new \OpenAffiliates\WooSpecificReferralRates();

		$WooCategoryReferralRates = new \OpenAffiliates\WooCategoryReferralRates();



		/// BP CUSTOM MENU ITEM

		$temp = $af_db->return_settings_from_wp_option('bp_account_page');

		if (!empty($temp['af_bp_account_page_enable']) && is_plugin_active('buddypress/bp-loader.php')){

			require AF_PATH . 'classes/BuddyPressCustomMenuItem.class.php';

			$bp_menu = new BuddyPressCustomMenuItem();

		}





		// dataTables

		$afDataTable = new \OpenAffiliates\Admin\Datatable();



		// nonce

		add_action( 'admin_head', 'AF_Main::adminNonce' );

		add_action( 'admin_head', 'AF_Main::afStyleForTopNotifications' );

		add_action( 'wp_head', 'AF_Main::publicNonce' );



	}



	public static function createBaseObject()

	{

			//if ( defined('DOING_AJAX') && DOING_AJAX ){

					//return;

			//}

			if ( is_admin() && current_user_can( 'manage_options' ) && !defined('DOING_AJAX')){

				/// ADMIN

				require_once AF_PATH . 'admin/AfMainAdmin.class.php';

				$af_main_object = new AfMainAdmin();

			} else{

				/// PUBLIC

				require_once AF_PATH . 'public/AfMainPublic.class.php';

				$af_main_object = new AfMainPublic();

			}



	}



	public static function onActivation()

	{

			global $af_db;

			include AF_PATH . 'classes/AfCronJobs.class.php';

			$crons = new \AfCronJobs();

			$crons->registerCrons();

			// since 8.5 - wizard

			if ( $af_db->affiliateTableExists() ){

					// table exists so we'll not run the wizard

					update_option( 'af_wizard_complete', -1 );

			} else {

					// fresh install. run the wizard

					update_option( 'af_wizard_complete', 0 );

			}

			// end of since 8.5 - wizard

	}



	public static function af_gate(){

		/*

		 * @param none

		 * @return none

		 */

		 if (!empty($_GET['af_act'])){

			$action = sanitize_text_field($_GET['af_act']);

		 } else {

		 	global $wp_query;

			if (!empty($wp_query)){

				 $action = get_query_var('af_act');

			}

		 }

		 if (!empty($action)){

		 	$no_load = TRUE;

		 	switch ($action){

				case 'stripe_payout':

					require_once AF_PATH . 'public/stripe-webhook.php';

					break;

				case 'password_reset':

					require_once AF_PATH . 'public/arrive.php';

					break;

				case 'email_verification':

					require_once AF_PATH . 'public/arrive.php';

					break;

				case 'migrate':

					$params = array(

								'serviceType'   => isset($_POST['service_type']) ? af_sanitize_array($_POST['service_type']) : false,

								'entityType'    => isset($_POST['entity_type']) ? af_sanitize_array($_POST['entity_type']) : false,

								'offset'        => isset($_POST['offset']) ? af_sanitize_array($_POST['offset']) : 0,

								'assignRank'    => isset($_POST['assignRank']) ? af_sanitize_array($_POST['assignRank']) : false

					);

					$object = new \OpenAffiliates\Migration\BaseMigration();

					$object->run($params);

					break;

				case 'tracking':

						$type = isset($_GET['type']) ? $_GET['type'] : '';

						if (empty($type)){

								return;

						}

						switch ($type){

								case 'cpm':

									$object = new \OpenAffiliates\CPM($_GET['affiliate']);

									break;

						}

						break;

				case 'stripe_v3_auth':

					// authentificate user in stripe. processing response.

					$stripe = new \OpenAffiliates\PayoutStripeV3();

					$stripe->authAffiliate();

					$accountPageId = get_option( 'af_general_user_page' );

					if ( $accountPageId ){

							$redirect = get_permalink( $accountPageId );

					}

					if ( !empty( $redirect ) ){

							// redirect to account page - payment settings

							$redirect = add_query_arg( 'af_aff_subtab', 'payments_settings', $redirect );

					} else {

							// redirect home. no account page set properly

							$redirect = get_home_url();

					}

					wp_safe_redirect( $redirect );

					exit;

					break;

				case 'stripe_v3_webhook':

					$stripe = new \OpenAffiliates\PayoutStripeV3();

					$stripe->webhook();

					break;

				default:

					$home = get_home_url();

					wp_safe_redirect($home);

					exit;

		 	}

		 }

	}



	public static function do_add_rewrite_endpoint_af(){

		add_rewrite_endpoint('af', EP_ROOT | EP_PAGES );

	}



	public static function af_load_language(){

		/*

		 * @param none

		 * @return none

		 */

		load_plugin_textdomain( 'openaffiliates', false, dirname(plugin_basename(__FILE__)) . '/languages/' );

	}



	public static function af_update_passowrd_filter($return, $user_data){

		/*

		 * @param return - boolean, $user_data - array

		 * @return boolean

		 */

		if (isset($user_data['ID']) && $return){

			$sent_mail = af_send_user_notifications($user_data['ID'], 'change_password');

			if ($sent_mail){

				return FALSE;

			}

		}

		return $return;

	}



	public static function edit_query_vars($vars){

		$vars[] = "af";

		return $vars;

	}



	public static function af_add_custom_top_menu_dashboard(){

		/*

		 * =============== DASHBOARD TOP MENU =================

		 * @param none

		 * @return none

		 */



		global $wp_admin_bar;

		if (!is_admin() || !is_admin_bar_showing()){

			return;

		}



		/// PARENT

		$wp_admin_bar->add_menu(array(

					'id'    => 'af_dashboard_menu',

					'title' => 'Open Affiliates',

					'href'  => admin_url( 'admin.php?page=openaffiliates' ),

					'meta'  => array(),

		));



		///ITEMS

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_pages', 'title'=>esc_html__('Affiliate Pages', 'openaffiliates'), 'href'=>'#', 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_showcases', 'title'=>esc_html__('Showcases', 'openaffiliates'), 'href'=>'#', 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_magic_feat', 'title'=>esc_html__('Extensions', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=magic_features'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_ranks', 'title'=>esc_html__('Ranks', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=ranks'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_offers', 'title'=>esc_html__('Product Rates', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=offers'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_visits', 'title'=>esc_html__('Clicks', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=visits'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_notifications', 'title'=>esc_html__('Email Notifications', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=notifications'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_shortcodes', 'title'=>esc_html__('Shortcodes', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=shortcodes'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu', 'id'=>'af_dashboard_menu_general', 'title'=>esc_html__('General Settings', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=settings'), 'meta'=>array()));



		/// SHOWCASES

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_showcases', 'id'=>'af_dashboard_menu_showcases_rf', 'title'=>esc_html__('Registration Form', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=register'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_showcases', 'id'=>'af_dashboard_menu_showcases_lf', 'title'=>esc_html__('Login Form', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=login'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_showcases', 'id'=>'af_dashboard_menu_showcases_ta', 'title'=>esc_html__('Top Affiliates', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=top_affiliates'), 'meta'=>array()));

		$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_showcases', 'id'=>'af_dashboard_menu_showcases_ap', 'title'=>esc_html__('Affiliate Portal', 'openaffiliates'), 'href'=>admin_url('admin.php?page=openaffiliates&tab=account_page'), 'meta'=>array()));



		/// DEFAULT PAGES

		$array = array(

							'af_general_login_default_page' => esc_html__('Affiliate Login', 'openaffiliates'),

							'af_general_register_default_page'=> esc_html__('Affiliate Registration', 'openaffiliates'),

							'af_general_lost_pass_page' => esc_html__('Lost Password', 'openaffiliates'),

							'af_general_logout_page' => esc_html__('LogOut', 'openaffiliates'),

							'af_general_user_page' => esc_html__('Affiliate Portal', 'openaffiliates'),

							'af_general_tos_page' => esc_html__('TOS', 'openaffiliates'),

		);

		foreach ($array as $k=>$v){

			$page = get_option($k);

			$permalink = get_permalink($page);

			if ($permalink){

				$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_pages', 'id'=>'af_dashboard_menu_pages_' . $k, 'title'=>$v, 'href'=>$permalink, 'meta'=>array('target'=>'_blank')));

			}

		}



		//. MAGIC FEATURES

		global $af_db;

		$array = $af_db->get_magic_feat_item_list();

		if ($array){

			foreach ($array as $key=>$item){

				$wp_admin_bar->add_menu(array('parent'=>'af_dashboard_menu_magic_feat', 'id'=>'af_dashboard_menu_magic_feat_' . $key, 'title'=>$item['label'], 'href'=>$item['link'], 'meta'=>array()));

			}

		}

	}



	public static function add_custom_admin_bar_item(){

			/*

			 * @param none

			 * @return none

			 */

			 if ( (int)get_option( 'af_wizard_complete', -1 ) === 0 ){

				 		return;

			 }

		global $wp_admin_bar;

		if (!is_admin() || !is_admin_bar_showing()){

			return;

		}

		global $wpdb, $af_db;

			if (!empty($_GET['page']) && $_GET['page']=='openaffiliates' && !empty($_GET['tab'])){

				switch ($_GET['tab']){

					case 'affiliates':

						$af_db->reset_dashboard_notification('affiliates');

						break;

					case 'referrals':

						$af_db->reset_dashboard_notification('referrals');

						break;

				}

			}







			$admin_workflow = $af_db->return_settings_from_wp_option('general-admin_workflow');



			if (!$admin_workflow['af_admin_workflow_dashboard_notifications']){

				return;

			}



			$new_affiliates = $af_db->get_dashboard_notification_value('affiliates');

			$new_referrals = $af_db->get_dashboard_notification_value('referrals');



			if (!is_admin() || ! is_admin_bar_showing()){

				return;

			}



			$wp_admin_bar->add_menu( array(

				'id'    => 'af_affiliates',

				'title' => '<span class="af-top-bar-count">' . $new_affiliates . '</span>New Affiliates',

				'href'  => admin_url('admin.php?page=openaffiliates&tab=affiliates'),

				'meta'  => array ( 'class' => 'af-top-notf-admin-menu-bar' )

			));



			$wp_admin_bar->add_menu( array(

				'id'    => 'af_referrals',

				'title' => '<span class="af-top-bar-count">' . $new_referrals . '</span>New Referrals',

				'href'  => admin_url('admin.php?page=openaffiliates&tab=referrals'),

				'meta'  => array ( 'class' => 'af-top-notf-admin-menu-bar' )

			));



	}



	public static function afStyleForTopNotifications(){

		$custom_css = '

		.af-top-bar-count{

				display: inline-block !important;

				vertical-align: top !important;

			padding: 2px 7px !important;

				background-color: #d54e21 !important;

				color: #fff !important;

				font-size: 9px !important;

				line-height: 17px !important;

				font-weight: 600 !important;

				margin: 5px !important;

				vertical-align: top !important;

				-webkit-border-radius: 10px !important;

				border-radius: 10px !important;

				z-index: 26 !important;

		}

		li#wp-admin-bar-af-ihc-link{

	    display: block;

	     width: 100%;

	     background-color: #ed5a4c !important;

	     color: #fff !important;

	     padding: 5px 0 5px 4px;

	  }

		li#wp-admin-bar-af-ihc-link a{

			color:#fff !important;

		}

		li.af-addons-link-wrapp, li#wp-admin-bar-af-pro-addons-link{

			display: block;

	     width: 100%;

	     background-color: #eee !important;

	     color: #fff !important;

	     padding: 5px 0 5px 4px;

			 background-color: #284051 !important;

	     padding: 4px 0 4px 0px !important;

		}

		li.af-addons-link-wrapp a, li#wp-admin-bar-af-pro-addons-link a{

			color:#333 !important;

			color: #53E2F3 !important;

		}';



		wp_register_style( 'dummy-handle', false );

		wp_enqueue_style( 'dummy-handle' );

		wp_add_inline_style( 'dummy-handle', stripslashes($custom_css) );

	}





	/**

	 * @param none

	 * @return float

	 */

	public static function get_plugin_ver(){

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$plugin_data = get_plugin_data( AF_PATH . 'open-affiliates-for-woocommerce.php', false, false);

		return $plugin_data['Version'];

	}





	public static function af_authenticate_filter($user_data=null, $username='', $password=''){

			if ($user_data==null){

				 return $user_data;

			}

			if (is_object($user_data) && !empty($user_data->roles) && in_array('pending_user', $user_data->roles)){

				$errors = new WP_Error();

        		$errors->add('title_error', 'Pending User');

        		return $errors;

			}

			return $user_data;

	}



	/**

	 * @param none

	 * @return none

	 */

	public static function adminNonce()

	{

			$nonce = wp_create_nonce( 'afAdminNonce' );

			echo esc_af_content("<meta name='af-admin-token' content='$nonce'>");

	}



	/**

	 * @param none

	 * @return none

	 */

	public static function publicNonce()

	{

			$nonce = wp_create_nonce( 'afPublicNonce' );

	    echo esc_af_content("<meta name='af-token' content='$nonce'>");

	}



	public static function check_user_privilege()

	{

		if ( !is_admin() ){

				return;

		}

		if ( defined('DOING_AJAX') && DOING_AJAX ){

				return;

		}

		$uid = get_current_user_id();

		$role = '';

		$user = new WP_User( $uid );

		$public_home = home_url();

		if ( !is_super_admin( $uid ) && $user && !empty($user->roles) && !empty($user->roles[0]) && !in_array( 'administrator', $user->roles )){

		 $allowed_roles = get_option('af_dashboard_allowed_roles');

		 if ($allowed_roles){

			 $roles = explode(',', $allowed_roles);

			 $show = false;

			 foreach ( $roles as $role ){

					 if ( !empty( $role ) && !empty( $user->roles ) && in_array( $role, $user->roles ) ){

						 $show = true;

					 }

			 }



			 if ( !$show ){

				 wp_redirect(home_url());

				 exit();

			 }



		 } else {

			 wp_redirect($public_home);

			 exit();

		 }

	 }

	}



	public static function diviGrabImage( $bool=true )

	{

			return false;

	}



}



AF_Main::run();

