<?php
if (!class_exists('AfMainAdmin')){
	class AfMainAdmin{
		private $version_param_name_db = 'af_plugin_version';
		private $amount_type_list = array();
		private $admin_view_path = '';
		private $base_admin_url;
		private $error_messages = array();
		private $items_per_page = array(5, 25, 50, 100, 200, 500);
		private $new_affiliates = 0;
		private $new_referrals = 0;
		private $plugin_version = '';

		public function __construct(){
			/*
			 * @param none
			 * @return none
			 */

			$this->plugin_version = AF_PLUGIN_VER;
			/// INSTALL / UPDATE
			$current_plugin_version = $this->get_current_plugin_version();

			if ($current_plugin_version===FALSE){
				//plugin first activation
				$this->run_install();
				update_option($this->version_param_name_db, AF_PLUGIN_VER);
			} else if (AF_PLUGIN_VER!=$current_plugin_version){
				// run updates
				$this->run_updates( $current_plugin_version );
				update_option($this->version_param_name_db, AF_PLUGIN_VER);
			}

			$this->plugin_version = $current_plugin_version;

			$this->admin_view_path = AF_PATH . 'admin/views/';
			require_once AF_PATH . 'admin/utilities.php';

			/// check for cron, curl, etc
			$this->check_system();


			// CREATE plugin menu
			add_action('admin_menu', array($this, 'add_menu'), 72 );

			//SCRIPTS && STYLE
			add_action("admin_enqueue_scripts", array($this, 'add_style_scripts') );

			/// pages & posts editor buttons
			add_action('init', array($this, 'add_custom_bttns'), 23);

			/// print column on pages
			add_filter( 'display_post_states', array($this, 'dashboard_print_af_column'), 999, 2 );

			/// Meta Box
			add_action('add_meta_boxes', array($this, 'create_page_meta_box') );

			/// save meta form values
			add_action('save_post', array($this, 'save_meta_box_values'), 99, 3);

			/// global errors
			add_action('admin_notices', array($this, 'return_global_errors'), 99);

			/// edit wordpress user stuff
			add_action('edit_user_profile', array($this, 'edit_wp_user'), 99);
			add_action('show_user_profile', array($this, 'edit_wp_user'), 99);

			/// DELETE USER FROM WP
			add_action('deleted_user', array($this, 'af_delete_affiliate_by_uid'), 99, 1);


			$this->referral_action();

			add_action( 'af_print_admin_page', [ $this, 'hooksAndFilters' ], 99, 1 );

			// user page
			$userPage = new \OpenAffiliates\Admin\UserProfile();

			// woo coupons
			add_action( 'woocommerce_coupon_options', [ $this, 'wooCouponsSettings' ] );
			add_action( 'woocommerce_coupon_options_save', [ $this, 'wooSaveCoupons' ] );

			//Adds Extra links into Plugins table
			add_filter( 'plugin_row_meta', array($this, 'af_plugin_row_meta'), 10, 2 );

			//if (!af_is_ihc_active()){
				add_action( 'admin_menu' , array($this, 'af_manage_ump') );
				add_action( 'admin_head', array($this, 'af_manage_ump_add_jquery') );
			//}

			//payout setup
			$payouts = new \OpenAffiliates\Admin\Payouts();

		}


		private function get_current_plugin_version()
		{
				if ( is_multisite() ){
						global $wpdb;
						$table = $wpdb->base_prefix . 'options';
						$query = $wpdb->prepare( "SELECT option_value FROM $table WHERE option_name=%s ", $this->version_param_name_db );
						$data = $wpdb->get_row( $query );
						if ( $data && !empty( $data->option_value ) ){
								return $data->option_value;
						}
						return false;
				}
				return get_option( $this->version_param_name_db );
		}

		private function run_install(){
			/*
			 * Run only @ first activation. Create DB Tables. Default Settings.
			 * @param none
			 * @return none
			 */
			global $af_db;
			$af_db->create_tables();
			$af_db->create_pending_role();
			$af_db->create_default_pages();
			$af_db->create_demo_banners();
			$af_db->create_default_redirects();
			//$this->install_default_notifications();
			//$this->install_default_ranks();
		}

		/**
		 * @param int
		 * @return none
		 */
		private function run_updates( $current_plugin_version='' )
		{
			 global $af_db;
			 $af_db->create_tables();
			 $af_db->modify_tables();



			 /// Register Fields
			 $post_data = array( 'id' => 0, 'display_admin'=>1, 'display_public_reg'=>1, 'display_public_ap'=>1, 'name'=>'af_country', 'label'=>'Country', 'type'=>'af_country', 'native_wp' => 0, 'req' => 0, 'sublabel' => '' );
			 $af_db->register_save_custom_field($post_data);
			 $data = $af_db->register_get_custom_fields();
			 $pass1_key = af_get_array_key_for_subarray_element($data, 'name', 'pass1');
			 if ( $pass1_key > -1 ){
			 	 $arr = $data[$pass1_key];
				 $arr['id'] = $pass1_key;
				 $arr['display_public_ap'] = 0;
				 $af_db->register_save_custom_field($arr);
			 }
			 if (isset($arr)){
				  unset($arr);
			 }
			 $pass2_key = af_get_array_key_for_subarray_element($data, 'name', 'pass2');
			 if ( $pass2_key > -1 ){
				 $arr = $data[$pass2_key];
				 $arr['id'] = $pass2_key;
				 $arr['display_public_ap'] = 0;
				 $af_db->register_save_custom_field($arr);
			 }
			 $array =array();
			 $key = af_get_array_key_for_subarray_element( $data, 'name', 'af_optin_accept' );

			 if ( $key == -1 ){

					  $array = [
						 				'id' 										=> '',
										'display_admin'					=> 0,
										'display_public_reg'		=> 0,
										'display_public_ap'			=> 0,
										'name'									=> 'af_optin_accept',
										'label'									=> esc_html__( 'I would like to subscribe to newsletter list', 'openaffiliates' ),
										'type'									=> 'single_checkbox',
										'native_wp' 						=> 0,
										'req' 									=> 0,
										'sublabel' 							=> ''
					  ];
					  $af_db->register_save_custom_field( $array );

			 }
			 if (isset($array)){
				 unset($array);
			}
			if (isset($key)){
				unset($key);
		 }
			 $key = af_get_array_key_for_subarray_element( $data, 'name', 'af_affiliate_paypal_email' );

			 if ( $key == -1 ){
					  $array = [
						 				'id' 										=> '',
										'display_admin'					=> 1,
										'display_public_reg'		=> 0,
										'display_public_ap'			=> 0,
										'name'									=> 'af_affiliate_paypal_email',
										'label'									=> esc_html__( 'Payment Email (PayPal)', 'openaffiliates' ),
										'type'									=> 'text',
										'native_wp' 						=> 0,
										'req' 									=> 0,
										'sublabel' 							=> 'Your PayPal payment email, to which we will send commission payments. Can be the same as your account email.'
					  ];
					  $af_db->register_save_custom_field( $array );

			 }
			 if (isset($array)){
					unset($array);
			 }
			 if (isset($key)){
				 unset($key);
			}
			 $key = af_get_array_key_for_subarray_element( $data, 'name', 'af_affiliate_bank_transfer_data' );

			 if ( $key == -1 ){
				 $array = [
								 'id' 									=> '',
								 'display_admin'				=> 1,
								 'display_public_reg'		=> 0,
								 'display_public_ap'		=> 0,
								 'name'									=> 'af_affiliate_bank_transfer_data',
								 'label'								=> esc_html__( 'Direct Deposit (Payout details)', 'openaffiliates' ),
								 'type'									=> 'textarea',
								 'native_wp' 						=> 0,
								 'req' 									=> 0,
								 'sublabel' 						=> 'Bank Account details for Wire transfer.'
				 ];
			 		 $af_db->register_save_custom_field( $array );

			 }
			 if (isset($array)){
					unset($array);
			 }
			 if (isset($key)){
				 unset($key);
			}

			 //

			 $af_db->check_update_notifications();
			 $this->removeOldImportFiles();
		}

		private function removeOldImportFiles()
		{
				$directory = AF_PATH;
				$files = scandir( $directory );
				foreach ( $files as $file ){
						$fileFullPath = $directory . $file;
						if ( file_exists( $fileFullPath ) && filetype( $fileFullPath ) == 'file' ){
								$extension = pathinfo( $fileFullPath, PATHINFO_EXTENSION );
								if ( $extension == 'xml' && $file == 'export.xml' ){
										unlink( $fileFullPath );
								} else if ( $extension == 'csv' && ( $file == 'affiliates.csv' || $file == 'referrals.csv' || $file == 'visits.csv' ) ){
										unlink( $fileFullPath );
								}
						}
				}
		}

		private function check_system(){
			/*
			 * @param none
			 * @return none
			 */

			$wp_cron = ( defined('DISABLE_WP_CRON') && DISABLE_WP_CRON ) ? FALSE : TRUE;
			if ( !$wp_cron ){
				$this->error_messages[] = esc_html__('Crons are disabled on your WordPress Website. Some functionality and processes may not work properly.', 'openaffiliates');
			}
			global $af_db;

			/// curl
			if ( !function_exists('curl_version') || !curl_version() ){
					$this->error_messages[] = esc_html__('cURL is not working or is disabled on your Website environment. Please contact your Hosting provider.', 'openaffiliates');
			}

			// cookie
			$af_test_cookie = get_option( 'af_test_cookie' );
			if ( !$af_test_cookie || !isset($_COOKIE['af_test_cookie']) ){
					setcookie( 'af_test_cookie', 1, time() + 360 * 30 * 60 * 60, '/' );
					update_option( 'af_test_cookie', 1 );
			} elseif ($af_test_cookie != 0){
					if (isset($_COOKIE['af_test_cookie'])) {
							//verification is closed until cookie will expire
							update_option( 'af_test_cookie', 0 );
					} else {
							$this->error_messages[] = esc_html__('Cookies are not stored or setcookie() PHP function is disabled on your Website environment.', 'openaffiliates');
							//try to set again to check if the problem gone
							setcookie( 'af_test_cookie', 1, time() + 360 * 30 * 60 * 60, '/' );
					}
			}

			if ( $af_db->is_magic_feat_enable('paypal') ){
				$temp_array = $af_db->return_settings_from_wp_option('paypal');
				if ( empty( $temp_array['af_paypal_sandbox'] ) ){
					if ( empty( $temp_array['af_paypal_client_id'] ) || empty( $temp_array['af_paypal_client_secret'] ) ){
						$this->error_messages[] = esc_html__('The PayPal Payout module has not been configured correctly.', 'openaffiliates');
					}
				} else {
					if ( empty( $temp_array['af_paypal_sandbox_client_id'] ) || empty( $temp_array['af_paypal_sandbox_client_secret'] ) ){
						$this->error_messages[] = esc_html__('The PayPal Payout module has not been configured correctly.', 'openaffiliates');
					}
				}
			}
			if ( $af_db->is_magic_feat_enable('stripe') ){
				$temp_array = $af_db->return_settings_from_wp_option('stripe');
				if ( empty( $temp_array['af_stripe_sandbox'])){
					if ( empty( $temp_array['af_stripe_secret_key'] ) || empty($temp_array['af_stripe_publishable_key'] ) ){
						$this->error_messages[] = esc_html__('Stripe Payout module has not been configured correctly.', 'openaffiliates');
					}
				} else {
					if ( empty( $temp_array['af_stripe_sandbox_secret_key'] ) || empty($temp_array['af_stripe_sandbox_publishable_key'] ) ){
						$this->error_messages[] = esc_html__('Stripe Payout module has not been configured correctly.', 'openaffiliates');
					}
				}
			}

			if ( $af_db->affiliates_with_no_rank_exists() ){
				$this->error_messages[] = esc_html__('Some Affiliates users do not have assigned a Rank and they may not be rewarded. Check your stage ', 'openaffiliates') . ' <a href="' . admin_url('admin.php?page=openaffiliates&tab=affiliates') . '" target="_blank">' . esc_html__('here', 'openaffiliates') . '</a>';
			}

			$cropFunctions = [
												'getimagesize',
												'imagecreatefrompng',
												'imagecreatefromjpeg',
												'imagecreatefromgif',
												'imagecreatetruecolor',
												'imagecopyresampled',
												'imagerotate',
												'imagesx',
												'imagesy',
												'imagecolortransparent',
												'imagecolorallocate',
												'imagejpeg',
			];
			foreach ( $cropFunctions as $cropFunction ){
					if ( !function_exists( $cropFunction ) ){
							$functionsErrors[] = $cropFunction .'()';
					}
			}
			if ( !empty($functionsErrors) ){
					$this->error_messages[] = esc_html__('Following functions: ', 'openaffiliates') . implode( ', ', $functionsErrors )
					. esc_html__( ' are disabled on your Website environment. Avatar feature may not work properly. Please contract your Hosting provider.', 'openaffiliates');
			}
		}

		public function return_global_errors(){
			/*
			 * @param none
			 * @return none
			 */
			if (current_user_can('manage_options')){
				echo esc_af_content($this->print_marketing(TRUE));
			}
		}

		private function print_marketing($is_global=FALSE){

				return '';
		}

		private function printFopenError()
		{
				$allow = ini_get( 'allow_url_fopen' );
				if ( !$allow ){
					echo esc_af_content('<div class="af-error-global-dashboard-message"><strong>' . esc_html__("'allow_url_fopen' directive is disabled. In order for Open Affiliates to work properly this directive has to be set 'on'. Contact your hosting provider for more details.", 'openaffiliates') . ' </strong></div>');
				}
		}

		private function install_default_notifications(){
			/*
			 * @param none
			 * @return none
			 */
			global $af_db;
			$array = array( 'admin_user_register',
							'register',
							'reset_password_process',
							'reset_password',
							'change_password',
							'user_update',
							'rank_change',
							'email_check',
							'email_check_success',
							'register_lite_send_pass_to_user',
			);
			foreach ($array as $type){
				if (!$af_db->notification_type_exists($type)){
					$template = af_return_default_notification_content($type); ///get default notification content
					$data['type'] = $type;
					$data['rank_id'] = -1;
					$data['subject'] = addslashes($template['subject']);
					$data['message'] = addslashes($template['content']);
					$data['status'] = 1;
					$data['pushover_message'] = '';
					$data['pushover_status'] = '';
					$af_db->save_notification($data);///and save it
					unset($data);
				}
			}
		}

		private function install_default_ranks(){
			/*
			 * @param none
			 * @return none
			 */
			global $af_db;
			$rank_1 = array(
								'id' => 1,
								'slug' => 'rank_1',
								'label' => __( 'Basic', 'openaffiliates' ),
								'amount_type' => 'percentage',
								'amount_value' => 10,
								'achieve' => '',
								'rank_order' => 1,
								'color' => '0bb586',
								'description' => __( 'A Demo Rank', 'openaffiliates' ),
								'bonus' => '',
								'pay_per_click' => '',
								'cpm_commission' => '',
								'sign_up_amount_value' => -1,
								'lifetime_amount_type' => '',
								'lifetime_amount_value' => -1,
								'reccuring_amount_type' => '',
								'reccuring_amount_value' => -1,
								'mlm_amount_type' => '',
								'mlm_amount_value' => '',
								'status' => 1,
			);
			$rank_2 = array(
								'id' => 2,
								'slug' => 'rank_2',
								'label' => __( 'Premium', 'openaffiliates' ),
								'amount_type' => 'percentage',
								'amount_value' => 15,
								'achieve' => '{"i":1,"type_1":"referrals_number","value_1":"100"}',
								'rank_order' => 2,
								'color' => 'f8ba01',
								'description' => __( 'A Demo Rank', 'openaffiliates' ),
								'bonus' => '',
								'pay_per_click' => '',
								'cpm_commission' => '',
								'sign_up_amount_value' => -1,
								'lifetime_amount_type' => '',
								'lifetime_amount_value' => -1,
								'reccuring_amount_type' => '',
								'reccuring_amount_value' => -1,
								'mlm_amount_type' => '',
								'mlm_amount_value' => '',
								'status' => 1,
			);
			$af_db->rank_save_update($rank_1);
			$af_db->rank_save_update($rank_2);
		}

		public function add_menu(){
			/*
			 * @param none
			 * @return none
			 */
			add_menu_page('Open Affiliates', 'Open Affiliates', 'manage_options',	'openaffiliates', array($this, 'output') , 'dashicons-networking');
		}

		public function output(){
			/*
			 * @param none
			 * @return none (print html)
			 */
			$currency = get_option('af_currency');
			$this->amount_type_list = array('percentage'=> esc_html__('Percentage (%)', 'openaffiliates'), 'flat' => esc_html__('Flat Rate', 'openaffiliates').' ('.$currency.')');

			$tab = (empty($_GET['tab'])) ? 'dashboard' : sanitize_text_field($_GET['tab']);
			$this->base_admin_url = admin_url('admin.php?page=openaffiliates&tab=' . $tab);
			$this->print_head($tab);
			switch ($tab){
				case 'dashboard':
					$this->print_dashboard();
					break;
				case 'affiliates':
					$this->print_affiliates();
					break;
				case 'ranks':
					$this->print_ranks();
					break;
				case 'offers':
					$this->print_offers();
					break;
				case 'landing_commissions':
					$this->print_landing_commissions();
					break;
				case 'banners':
					$this->print_banners();
					break;
				case 'visits':
					$this->print_visits();
					break;
				case 'referrals':
					$this->print_referrals();
					break;
				case 'payments':
					$this->print_payments();
					break;
				case 'notifications':
					$this->print_notifications();
					break;
				case 'reports':
					$this->print_reports();
					break;
				case 'settings':
					$this->print_settings();
					break;
				case 'showcases':
					$this->print_showcases();
					break;
				case 'register':
					$this->print_register();
					break;
				case 'login':
					$this->print_login();
					break;
				case 'account_page':
					$this->print_account_page();
					break;
				case 'opt_in':
					$this->print_opt_in();
					break;
				case 'magic_features':
					$this->print_magic_features();
					break;
				case 'integrations':
					$this->print_integrations();
					break;
				case 'shortcodes':
					$this->print_shortcodes();
					break;
				case 'about':
					$this->print_about();
					break;
				case 'top_affiliates':
					$this->print_top_affiliates();
					break;
				case 'top_affiliates_settings':
					$this->print_top_affiliates_settings();
					break;
				case 'referral_list_details':
					$this->referral_list_details();
					break;
				case 'view_payment_settings':
					$this->print_view_payment_settings();
					break;
				case 'import_export':
					$this->print_import_export();
					break;
				case 'notification-logs':
					$this->print_notifications_logs();
					break;
				default:
					do_action( 'af_print_admin_page', $tab );
					break;
			}
			$this->print_footer();
		}

		private function print_head($tab){
			/*
			 * @param string
			 * @return string
			 */
			global $af_db;
			$data['admin_workflow'] = $af_db->return_settings_from_wp_option('general-admin_workflow');

			switch ($tab){
				case 'affiliates':
					$af_db->reset_dashboard_notification('affiliates');
					break;
				case 'referrals':
					$af_db->reset_dashboard_notification('referrals');
					break;
			}

			if ($data['admin_workflow']['af_admin_workflow_dashboard_notifications']){
				$data['affiliates_notification_count'] = $af_db->get_dashboard_notification_value('affiliates');
				$data['referrals_notification_count'] = $af_db->get_dashboard_notification_value('referrals');
			}


			$data['tab'] = $tab;
			$data['base_url'] = admin_url('admin.php?page=openaffiliates');
			$data['menu_items'] = array(
											'affiliates' => esc_html__('Affiliates', 'openaffiliates'),
											'ranks' => esc_html__('Ranks', 'openaffiliates'),
											'offers' => esc_html__('Product Rates', 'openaffiliates'),
											//removed
											//'landing_commissions' => esc_html__('Landing Commissions (CPA)', 'openaffiliates'),
											//added
											'integrations' => esc_html__('Integrations', 'openaffiliates'),
											'banners' => esc_html__('Creatives', 'openaffiliates'),
											'showcases' => esc_html__('Showcases', 'openaffiliates'),
											'visits' => esc_html__('Clicks', 'openaffiliates'),
											'referrals' => esc_html__('Referrals', 'openaffiliates'),
											'payments' => esc_html__('Payouts', 'openaffiliates'),
											'notifications' => esc_html__('Email Notifications', 'openaffiliates'),
											'magic_features' => esc_html__('Extensions', 'openaffiliates'),
											'reports' => esc_html__('Reports', 'openaffiliates'),
											'settings' => esc_html__('General Settings', 'openaffiliates'),
			);
			$data['right_tabs'] = array(
											'shortcodes' => esc_html__('Shortcodes', 'openaffiliates'),
											'import_export' => esc_html__('Export/Import', 'openaffiliates'),
											'about' => esc_html__('About & Support', 'openaffiliates'),
			);
			$plugin_vs = $this->plugin_version;

			$payoutsModel = new \OpenAffiliates\Db\Payouts();
			/*if ( $payoutsModel->haveEntries() ){
					unset( $data['menu_items']['payments'] );
					$data['menu_items']['manage_payouts'] = esc_html__('Payouts', 'openaffiliates');
			}
			*/
			require_once $this->admin_view_path . 'header.php';
		}

		private function print_top_messages(){
			/*
			 * @param none
			 * @return string
			 */
			echo esc_af_content($this->print_marketing(FALSE));
			echo esc_af_content($this->printFopenError());
			require_once $this->admin_view_path . 'top-messages.php';
		}

		private function print_footer(){

			$plugin_vs = $this->plugin_version;
			require_once $this->admin_view_path . 'footer.php';
		}

		private function print_dashboard(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['base_url'] = admin_url('admin.php?page=openaffiliates');
			/*$data['stats'] = $af_db->stats_for_dashboard();
			$data['currency'] = afCurrency();
			$data['rank_arr'] = $af_db->get_affilitated_per_rank();
			$data['last_referrals'] = $af_db->get_last_referrals();
			$data['top_affiliates'] = $af_db->get_top_affiliates_by_amount();*/
			//$this->print_top_messages();
			require_once $this->admin_view_path . 'dashboard.php';
		}


		/*
		 * @param none
		 * @return none
		 */
		private function print_import_export(){
			global $af_db;
			if (!empty($_POST['import']) && !empty($_FILES['import_file']) && !empty($_POST['af_admin_import_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_import_nonce']), 'af_admin_import_nonce' ) ){
				////////////////// IMPORT
				$filename = AF_PATH . 'import.xml';
				move_uploaded_file($_FILES['import_file']['tmp_name'], $filename);
				require_once AF_PATH . 'classes/import-export/AfImport.class.php';
				require_once AF_PATH . 'classes/import-export/AfAffiliatesImport.class.php';
				$import = new AfAffiliatesImport();
				$import->setFile($filename);
				$import->run();
			} else if ( !empty($_POST['import_csv_affiliates']) && !empty($_FILES['import_file_affiliates']) && !empty($_POST['af_admin_import_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_import_nonce']), 'af_admin_import_nonce' ) ){
					// import affiliates via CSV file
					$filename = AF_PATH . 'import.csv';
					move_uploaded_file($_FILES['import_file_affiliates']['tmp_name'], $filename);
					require_once AF_PATH . 'classes/import-export/ImportCSV.php';
					$ImportCSV = new \OpenAffiliates\ImportExport\ImportCSV();
					$responseFromImportCSV = $ImportCSV->setFile( $filename )
					                      ->setType( 'affiliates' )
					                      ->proceed();
			} else if ( !empty($_POST['import_csv_referrals']) && !empty($_FILES['import_file_referrals']) && !empty($_POST['af_admin_import_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_import_nonce']), 'af_admin_import_nonce' ) ){
					// import referrals via CSV file
					$filename = AF_PATH . 'import.csv';
					move_uploaded_file($_FILES['import_file_referrals']['tmp_name'], $filename);
					require_once AF_PATH . 'classes/import-export/ImportCSV.php';
					$ImportCSV = new \OpenAffiliates\ImportExport\ImportCSV();
					$responseFromImportCSV = $ImportCSV->setFile( $filename )
					                      ->setType( 'referrals' )
					                      ->proceed();
			}
			$this->print_top_messages();
			require_once $this->admin_view_path . 'import-export.php';
		}

		private function check_curl(){
			/*
			 * @param none
			 * @return boolean
			 */
			return (function_exists('curl_version')) ? TRUE : FALSE;
		}

		private function print_affiliates(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			require_once AF_PATH . 'classes/AffiliateAddEdit.class.php';
			$current_url = af_current_url();
			$current_url = remove_query_arg('af_list_item', $current_url);
			$currency = afCurrency();

			if (isset($_POST['Update'])){
				/// UPDATE AFFILIATE
				$args = array(
						'type' => 'edit',
						'tos' => FALSE,
						'captcha' => FALSE,
						'is_public' => FALSE,
						'user_id' => sanitize_text_field($_POST['user_id']),
				);
				$obj = new AffiliateAddEdit($args);
				$save_err = $obj->save_update_user();
			} else if (isset($_POST['Submit'])){
				/// CREATE AFFILIATE
				$args = array(
						'user_id' => FALSE,
						'type' => 'create',
						'tos' => FALSE,
						'captcha' => FALSE,
						'is_public' => FALSE,
				);
				$obj = new AffiliateAddEdit($args);
				$save_err = $obj->save_update_user();
			} else if (!empty($_POST['delete_affiliate']) && !empty($_POST['af_admin_list_affiliate_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_list_affiliate_nonce']), 'af_admin_list_affiliate_nonce' )){
				/// DELETE AFFILIATE
				$af_db->delete_affiliates(array($_POST['delete_affiliate']));
			} else if (!empty($_POST['do_action']) && !empty($_POST['affiliate_id_arr']) && !empty($_POST['af_admin_list_affiliate_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_list_affiliate_nonce']), 'af_admin_list_affiliate_nonce' ) ){
				if ( $_POST['do_action']=='delete' ){
					$af_db->delete_affiliates( af_sanitize_array($_POST['affiliate_id_arr']) );
				} else if ($_POST['do_action']=='update_ranks'){
					require_once AF_PATH . 'public/ChangeRanks.class.php';
					$update_rank_object = new ChangeRanks( af_sanitize_array($_POST['affiliate_id_arr']) );
				}
			}

			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=affiliates&subtab=add_edit');
			$data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=affiliates');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$data['show_cpm'] = $af_db->is_magic_feat_enable('cpm_commission') ? true : false;
			$data['show_ppc'] = $af_db->is_magic_feat_enable('pay_per_click') ? true : false;

			/// OUTPUT
			if ($data['subtab']=='list'){
				/// MANAGE AFFILIATES

				$url = admin_url('admin.php?page=openaffiliates&tab=affiliates');
				$limit = (isset($_GET['af_limit'])) ? sanitize_text_field($_GET['af_limit']) : 25;
				$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
				$total_items = $af_db->get_affiliates(-1, -1, TRUE, '', '');

				if ($current_page>1){
					$offset = ( $current_page - 1 ) * $limit;
				} else {
					$offset = 0;
				}
				if ($offset + $limit>$total_items){
					$limit = $total_items - $offset;
				}

				require_once AF_PATH . 'classes/AfPagination.class.php';
				$limit = (isset($_GET['af_limit'])) ? sanitize_text_field($_GET['af_limit']) : 25;
				$pagination = new AfPagination(array(
						'base_url' => $current_url,
						'param_name' => 'af_list_item',
						'total_items' => $total_items,
						'items_per_page' => $limit,
						'current_page' => $current_page,
				));

				$order_by = 'a.start_data';
				$order_type = 'DESC';
				if (!empty($_REQUEST['orderby_user'])){
					switch ($_REQUEST['orderby_user']){
						case 'display_name':
							$order_by = 'u.display_name';
							break;
						case 'user_login':
							$order_by = 'u.user_login';
							break;
						case 'user_email':
							$order_by = 'u.user_email';
							break;
						case 'ID':
							$order_by = 'u.ID';
							break;
						case 'user_registered':
							$order_by = 'u.user_registered';
							break;
					}
				}
				if (!empty($_REQUEST['ordertype_user'])){
					$order_type = af_sanitize_textarea_array($_REQUEST['ordertype_user']);
				}

				$data['ranks_list'] = af_get_wp_roles_list();
				$data['pagination'] = $pagination->output();
				$data['listing_affiliates'] = $af_db->get_affiliates($limit, $offset, FALSE, $order_by, $order_type);
				$data['errors'] = af_return_errors();
				$data['base_list_url'] = $url;
				$data['base_visits_url'] = admin_url('admin.php?page=openaffiliates&tab=visits');
				$data['base_referrals_url'] = admin_url('admin.php?page=openaffiliates&tab=referrals');
				$data['base_paid_url'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=paid_referrals');
				$data['base_unpaid_url'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=unpaid');
				$data['base_pay_now'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=payment_form');
				$data['base_reports_url'] = admin_url('admin.php?page=openaffiliates&tab=reports');
				$data['affiliate_profile_url'] = admin_url('admin.php?page=openaffiliates&tab=user_profile');
				$data['base_transations_url'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions');
				$data['base_view_payment_settings_url'] = admin_url('admin.php?page=openaffiliates&tab=view_payment_settings&uid=');
				$data['email_verification'] = $af_db->is_magic_feat_enable('email_verification');
				$data['mlm_on'] = $af_db->is_magic_feat_enable('mlm');
				$data['mlm_matrix_link'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=mlm_view_affiliate_children&affiliate_name=');
				$data['rankings'] = $af_db->affiliatesGetRanking();
				if ( $data['rankings'] ){
						end($data['rankings']);
						$key = current( $data['rankings'] );
						if ( $key ){
								$data['rankings_last_place'] = $key + 1;
						}
						reset( $data['rankings'] );
				}
				require_once $this->admin_view_path . 'affiliates-list.php';
			} else {
				/// ADD EDIT AFFILIATES
				$id = (empty($_GET['id'])) ? FALSE : sanitize_text_field($_GET['id']);
				$type = $id ? 'edit' : 'create';
				$args = array(
						'user_id' => $id,
						'type' => $type,
						'tos' => FALSE,
						'captcha' => FALSE,
						'action' => $data['url-manage'],
						'is_public' => FALSE,
				);
				$obj = new AffiliateAddEdit($args);
				$data = $obj->form();
				$data['template'] = '';
				$data['action'] = admin_url('admin.php?page=openaffiliates&tab=affiliates');
				ob_start();
				require_once AF_PATH . 'public/views/register.php';
				$data['output'] = ob_get_contents();
				ob_end_clean();
				require_once $this->admin_view_path . 'affiliates-add_edit.php';
			}

		}

		private function print_ranks(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=ranks&subtab=add_edit');
			$data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=ranks');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$data['achieve_types'] = array(-1=>'...', 'referrals_number'=>'Number of Referrals (Rewards)', 'total_amount'=>'Total Earnings');

			/// OUTPUT
			if ($data['subtab']=='list'){
				if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					if(empty($_POST['slug']) || empty($_POST['label']) || empty($_POST['amount_value'])){
						$data['alert_message'] = esc_html__('Required fields are missing. Please ensure that all mandatory fields such as Slug, Name, and Rate are filled out', 'openaffiliates');

					}else{
					$rankId = $af_db->rank_save_update( af_sanitize_array($_POST) );

					// 8.5
					if ( isset( $_POST['set_as_default_rank'] ) && (int)( sanitize_text_field( $_POST['set_as_default_rank'] ) ) === 1 ){
							update_option( 'af_register_new_user_rank', $rankId );
					}
					// 8.5

					// also update the ranks order. since version 8.1
					$ranks = $af_db->get_ranks();
					$ranks = af_reorder_ranks( $ranks );
					$currentOrder = 1;
					foreach ( $ranks as $key=>$rankData ){
							$af_db->rankUpdateOrder( $rankData->id, $currentOrder );
							$currentOrder++;
					}
					// end of version 8.1
					}
				}

				$data['ranks'] = $af_db->get_ranks();
				$data['ranks'] = af_reorder_ranks($data['ranks']);//reorder
				require_once $this->admin_view_path . 'ranks-list.php';
			} else {
				$id = (empty($_GET['id'])) ? 0 : sanitize_text_field($_GET['id']);
				$data['ranks'] = $af_db->get_ranks();
				$data['graphic'] = af_create_ranks_graphic($data['ranks'], $id);
				$data['maximum_ranks'] = count($data['ranks']);
				if ($id==0){
					 $data['maximum_ranks']++;
				}
				$data['metas'] = $af_db->get_rank($id);
				$data['metas']['af_register_new_user_rank'] = get_option( 'af_register_new_user_rank' );
				$data['amount_types'] = $this->amount_type_list;
				$temp_data = $af_db->return_settings_from_wp_option('sign_up_referrals');
				$data['display-signup_referrals'] = $af_db->is_magic_feat_enable('sign_up_referrals');
				$data['display-lifetime_commissions'] = $af_db->is_magic_feat_enable('lifetime_commissions');
				$data['display-reccuring_referrals'] = $af_db->is_magic_feat_enable('reccuring_referrals');
				$data['display-mlm'] = $af_db->is_magic_feat_enable('mlm');
				$data['mlm_matrix_depth'] = get_option('af_mlm_matrix_depth');
				$data['bonus_enabled'] = $af_db->is_magic_feat_enable('bonus_on_rank');
				$data['pay_per_click_enabled'] = $af_db->is_magic_feat_enable('pay_per_click');
				$data['cpm_commission_enabled'] = $af_db->is_magic_feat_enable('cpm_commission');
				require_once $this->admin_view_path . 'ranks-add_edit.php';
			}
		}

		private function print_offers(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=offers&subtab=add_edit');
			$data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=offers');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$currency = afCurrency();

			if ($data['subtab']=='add_edit'){
				/// ADD EDIT
				$id = (empty($_GET['id'])) ? 0 : sanitize_text_field($_GET['id']);
				$data['metas'] = $af_db->get_offer($id);
				$data['amount_types'] = $this->amount_type_list;
				if (!empty($data['metas']['affiliates'])){
					foreach ($data['metas']['affiliates'] as $id){
						$data['affiliates']['username'][$id] = $af_db->get_wp_username_by_affiliate_id($id);
					}
					$data['affiliates']['username'][-1] = 'All Affiliates';
				}

				if (!empty($data['metas']['products'])){
					$data['metas']['products'] = explode(',', $data['metas']['products']);
					switch ($data['metas']['source']){
						case 'woo':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->woo_get_product_title_by_id($id);
							}
							break;
						case 'ump':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->ump_get_level_label_by_id($id);
							}
							break;
						case 'edd':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->edd_get_label_by_id($id);
							}
							break;
						case 'ulp':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->ulp_get_label_by_id($id);
							}
							break;
					}
				}
				require_once $this->admin_view_path . 'offers-add_edit.php';
			} else {
				/// LISTING
				if ( !empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					$saved = $af_db->save_offer( af_sanitize_textarea_array($_POST) );
					if ($saved<1){
						$data['errors'] = esc_html__('Required fields are missing. Please ensure that all mandatory fields such as Name and Rate are filled out', 'openaffiliates');// and Date Range
					}
				} else if (!empty($_POST['delete_offers'])  && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					$af_db->delete_offers($_POST['delete_offers']);
				}
				$data['listing_items'] = $af_db->get_offers();
				require_once $this->admin_view_path . 'offers-list.php';
			}
		}

		private function print_landing_commissions(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=landing_commissions&subtab=add_edit');
			$data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=landing_commissions');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$currency = afCurrency();

			if ($data['subtab']=='add_edit'){
				/// ADD EDIT
				$id = (empty($_GET['slug'])) ? '' : sanitize_text_field($_GET['slug']);
				$data['metas'] = $af_db->get_landing_commission($id);
				require_once $this->admin_view_path . 'landing-commissions-add_edit.php';
			} else {
				/// LISTING
				if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					if(empty($_POST['slug']) || empty($_POST['amount_value'])){
						$data['alert_message'] = esc_html__('Required fields are missing. Please ensure that all mandatory fields such as Slug and Price Value are filled out', 'openaffiliates');

					}else{
						$saved = $af_db->save_landing_commission( af_sanitize_textarea_array($_POST) );
						if ($saved<1){
							$data['errors'] = esc_html__('It seems that there was an issue saving your data. Please try again later', 'openaffiliates');
						}
					}
				} else if (!empty($_POST['delete_landing_referral']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					$af_db->delete_landing_commission( af_sanitize_array($_POST['delete_landing_referral']) );
				}
				$data['listing_items'] = $af_db->get_landing_commissions();

				require_once $this->admin_view_path . 'landing-commissions-list.php';
			}
		}

		private function print_referrals(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=referrals&subtab=add_edit');
			$data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=referrals');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);

			if ($data['subtab']=='add_edit'){
				/// ADD EDIT
				$data['affiliates'] = $af_db->get_affiliates();
				$id = (empty($_GET['id'])) ? 0 : sanitize_text_field($_GET['id']);
				$data['metas'] = $af_db->get_referral($id);
				$data['status_posible'] = array(0=>'Rejected', 1=>'Pending', 2=>'Approved');
				$data['payment_posible'] = array(0 => 'Unpaid', 1 => 'Pending', 2 => 'Paid');
				require_once $this->admin_view_path . 'referrals-add_edit.php';
			} else {
				/// LISTING
				if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					/// SAVE UPDATE
					if(empty($_POST['affiliate_id']) || empty($_POST['amount']) || empty($_POST['currency']) || empty($_POST['date'])){
						$data['alert_message'] = esc_html__('Required fields are missing. Please ensure that all mandatory fields such as Affiliate, Amount, Currency and Date Value are filled out', 'openaffiliates');

					}else{
					$save_answer = $af_db->save_referral_from_admin( af_sanitize_textarea_array($_POST) );
					if (!$save_answer){
						$data['error'] = esc_html__('It seems that there was an issue saving your data. Please try again later', 'openaffiliates');
					} else {
						/// SAVE affiliate referral relation
						$old_affiliate = $af_db->search_affiliate_id_for_current_user( sanitize_text_field($_POST['refferal_wp_uid']) );
						if ($old_affiliate){
							$rewrite_referrals = get_option('af_rewrite_referrals_enable');
							if ($rewrite_referrals){
								/// update user - affiliate relation, use new affiliate
								$af_db->update_affiliate_referral_user_relation_by_ids($old_affiliate, sanitize_text_field($_POST['affiliate_id']), sanitize_text_field($_POST['refferal_wp_uid']) );
							}
						} else {
							/// insert user - affiliate relation
							$af_db->insert_affiliate_referral_user_new_relation( sanitize_text_field($_POST['affiliate_id']), sanitize_text_field($_POST['refferal_wp_uid']) );
						}
					}
					}
				} else if (!empty($_POST['change_status']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					/// CHANGE STATUS
					if (strpos($_POST['change_status'], '-')!==FALSE){
						$status_data = explode('-', $_POST['change_status']);
						if (isset($status_data[0]) && isset($status_data[1])){
							$af_db->change_referral_status($status_data[0], $status_data[1]);
						}
					}
				} else if (isset($_POST['referral_list']) && $_POST['referral_list'] &&
						(isset($_POST['list_action']) && $_POST['list_action']!=-1) || (isset($_POST['list_action_2']) && $_POST['list_action_2']!=-1)
					&& !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					/// CHANGE STATUS && DELETE

					if (isset($_POST['list_action']) && sanitize_text_field($_POST['list_action'])!=-1){
						$action = sanitize_text_field($_POST['list_action']);
					} else if (isset($_POST['list_action_2']) && sanitize_text_field($_POST['list_action_2'])!=-1){
						$action = sanitize_text_field($_POST['list_action_2']);
					}

					if ($action=='delete'){
						$data['current_actions'] = 'delete';
						foreach ($_POST['referral_list'] as $id){
							$af_db->delete_referrals( sanitize_text_field($id) );
						}
					} else {
						switch ($action){
							case 'refuse':
								$data['current_actions'] = 'refuse';
								$status = 0;
								break;
							case 'pending':
								$data['current_actions'] = 'pending';
								$status = 1;
								break;
							case 'complete':
								$data['current_actions'] = 'complete';
								$status = 2;
								break;
						}
						foreach ($_POST['referral_list'] as $id){
							$af_db->change_referral_status($id, $status);
						}
					}
				} else if (!empty($_POST['delete_referral']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					/// single delete
					foreach ($_POST['delete_referral'] as $id){
						$af_db->delete_referrals( sanitize_text_field($id));
					}
				}
				$available_systems = af_get_active_services();
				/// VIEW
				$where = array();
				if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
					$where[] = " r.date>'" . sanitize_textarea_field($_REQUEST['udf']) . "' ";
					$where[] = " r.date<'" . sanitize_textarea_field($_REQUEST['udu']) . "' ";
					$data['url-manage'] .= '&udf=' . sanitize_textarea_field($_REQUEST['udf']) . '&udu=' . sanitize_textarea_field($_REQUEST['udu']);
				}
				if (isset($_REQUEST['u_sts']) && $_REQUEST['u_sts']!=-1){
					$where[] = " r.status='" . sanitize_textarea_field($_REQUEST['u_sts']) . "' ";
					$data['url-manage'] .= '&u_sts=' . sanitize_textarea_field($_REQUEST['u_sts']);
				}
				if (!empty($_REQUEST['aff_u'])){
					$where[] = " ((u.user_login LIKE '%" . sanitize_textarea_field($_REQUEST['aff_u']) . "%') OR  (u.user_email LIKE '%" . sanitize_textarea_field($_REQUEST['aff_u']) . "%') )";
					$data['url-manage'] .= '&aff_u=' . sanitize_textarea_field($_REQUEST['aff_u']);
				}
				if (isset($_REQUEST['u_source']) && sanitize_text_field($_REQUEST['u_source']) != -1 ){
					$where[] = " r.source LIKE '%" . sanitize_text_field($_REQUEST['u_source']) . "%' ";
					$data['url-manage'] .= '&u_source=' . sanitize_text_field($_REQUEST['u_source']);
				}
				if (!empty($_GET['affiliate_id'])){
					$where[] = "r.affiliate_id=" . sanitize_text_field($_GET['affiliate_id']);
					$data['url-manage'] .= '&affiliate_id=' . sanitize_text_field($_GET['affiliate_id']);
					$wpuid = $af_db->get_uid_by_affiliate_id( sanitize_text_field($_GET['affiliate_id']) );
					$username = $af_db->get_username_by_wpuid($wpuid);
					$full_name = $af_db->get_full_name_of_user( sanitize_text_field($_GET['affiliate_id']) );
					$data['subtitle'] = esc_html__('View Referrals for', 'openaffiliates') . " $full_name ($username)";
				}

				$limit = (empty($_GET['af_limit'])) ? 25 : sanitize_text_field($_GET['af_limit']);
				$data['url-manage'] .= '&af_limit=' . $limit;
				$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
				$total_items = $af_db->get_referrals(-1, -1, TRUE, '', '', $where);
				if ($current_page>1){
					$offset = ( $current_page - 1 ) * $limit;
				} else {
					$offset = 0;
				}
				if ($offset + $limit>$total_items){
					$limit = $total_items - $offset;
				}
				require_once AF_PATH . 'classes/AfPagination.class.php';
				$limit = (empty($_GET['af_limit'])) ? 25 : sanitize_text_field($_GET['af_limit']);
				$pagination = new AfPagination(array(
						'base_url' 				=> $data['url-manage'],
						'param_name' 			=> 'af_list_item',
						'total_items' 		=> $total_items,
						'items_per_page' 	=> $limit,
						'current_page' 		=> $current_page,
				));

				$data['base_list_url'] = $data['url-manage'];
				$data['pagination'] = $pagination->output();
				$data['listing_items'] = $af_db->get_referrals($limit, $offset, FALSE, 'r.id', 'DESC', $where); /// r.date DESC
				$source_arr = array();
				foreach($available_systems as $v=>$k){
					$source_arr[$v] = af_service_type_code_to_title($k);
				}
				$data['filter'] = af_return_date_filter($data['url-manage'],
															array(
																0 => esc_html__('Rejected', 'openaffiliates'),
					 											1 => esc_html__('Pending', 'openaffiliates'),
					 											2 => esc_html__('Approved', 'openaffiliates'),
															),
															$source_arr,
															TRUE
				);

				$data['actions'] = array(
											-1 => '...',
											'delete' => esc_html__('Delete', 'openaffiliates'),
											'refuse' => esc_html__('Mark as Rejected', 'openaffiliates'),
											'pending' => esc_html__('Mark as Pending', 'openaffiliates'),
											'complete' => esc_html__('Mark as Approved', 'openaffiliates'),
				);
				if (empty($data['current_actions'])){
					$data['current_actions'] = -1;
				}

				if (!empty($available_systems['woo'])){
					$data['woo_order_base_link'] = admin_url('post.php?post=');// must add &action=edit after id
				}
				if (!empty($available_systems['ulp'])){
					$data['ulp_order_base_link'] = admin_url('post.php?post=');// must add &action=edit after id
				}
				if (!empty($available_systems['edd'])){
					$data['edd_order_base_link'] = admin_url('edit.php?post_type=download&page=edd-payment-history&view=view-order-details&id=');
				}
				if (!empty($available_systems['ump'])){
					$data['ump_order_base_link'] = admin_url('admin.php?page=ihc_manage&tab=payments&details_id=');
				}
				$data['mlm_order_base_link'] = admin_url('admin.php?page=openaffiliates&tab=referral_list_details&id=');
				$data['user_sign_up_link'] = admin_url('user-edit.php?user_id=');
				require_once $this->admin_view_path . 'referrals-list.php';
			}
		}

		private function referral_list_details(){
			/*
			 * @param none
			 * @return string
			 */
			 global $af_db;
			 $data['currency'] = afCurrency();
			 $data['metas'] = array();
			 if(isset($_GET['id'])){
				 $data['metas'] = $af_db->get_referral( sanitize_text_field( $_GET['id'] ) );
			 }

			 $available_systems = af_get_active_services();
			 if (in_array('woo', $available_systems)){
				$data['woo_order_base_link'] = admin_url('post.php?post=');// must add &action=edit after id
			 }
			 if (in_array('ulp', $available_systems)){
				$data['ulp_order_base_link'] = admin_url('post.php?post=');// must add &action=edit after id
			 }
			 if (in_array('edd', $available_systems)){
				$data['edd_order_base_link'] = admin_url('edit.php?post_type=download&page=edd-payment-history&view=view-order-details&id=');
			 }
			 if (in_array('ump', $available_systems)){
			 	$data['ump_order_base_link'] = admin_url('admin.php?page=ihc_manage&tab=payments&details_id=');
			 }
			 require_once $this->admin_view_path . 'referral-list-details.php';
		}

		/**
		 * CREATIVES
		 * @param none
		 * @return string
		 */
		private function print_banners()
		{
			$this->print_top_messages();
			global $af_db;
			$BannersMeta = new \OpenAffiliates\Db\BannersMeta();
			if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_textarea_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				/// SAVE
				$bannerId = $af_db->save_banner($_POST);
				//
				if ( isset( $_POST['notes'] ) ){
						$BannersMeta->save( $bannerId, 'notes', sanitize_textarea_field( $_POST['notes'] ) );
				}
				if ( isset( $_POST['alt_text'] ) ){
					  $BannersMeta->save( $bannerId, 'alt_text', sanitize_textarea_field( $_POST['alt_text'] ) );
				}
				if ( isset( $_POST['content_type'] ) ){
						$BannersMeta->save( $bannerId, 'content_type', sanitize_textarea_field( $_POST['content_type'] ) );
				}
				if ( isset( $_POST['text_content'] ) ){
						$BannersMeta->save( $bannerId, 'text_content', sanitize_textarea_field( $_POST['text_content'] ) );
				}
			} else if (!empty($_POST['delete_banner']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_textarea_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				/// DELETE
				$af_db->delete_banners($_POST);
			}

			/// SET METAS
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=banners&subtab=add_edit');
			$data['form_action_url'] = admin_url('admin.php?page=openaffiliates&tab=banners');
			if ($data['subtab']=='add_edit'){
				wp_enqueue_style( 'afmultiselect', AF_URL . 'assets/css/jquery.multiselect.css', array(), '9.3' );
				wp_enqueue_script( 'afmultiselectfunctions', AF_URL . 'assets/js/jquery.multiselect.js', ['jquery'], '9.3' );

				$banner_id = (empty($_GET['id'])) ? 0 : sanitize_text_field($_GET['id']);
				$metas = $af_db->get_banner($banner_id);
				$data = array_merge($data, $metas);
				$data['notes'] = $BannersMeta->getOne( $banner_id, 'notes' );
				$data['alt_text'] = $BannersMeta->getOne( $banner_id, 'alt_text' );
				$data['content_type']	= $BannersMeta->getOne( $banner_id, 'content_type' );
				$data['text_content']	= $BannersMeta->getOne( $banner_id, 'text_content' );
				if ( $data['content_type'] === false ){
						$data['content_type'] = 'image';
				}
				if ( $data['text_content'] === false ){
						$data['text_content'] = '';
				}
			} else {
				$data['listing_items'] = $af_db->get_banners();
			}

			/// FINAL OUTPUT
			if ($data['subtab']=='add_edit'){
				require_once $this->admin_view_path . 'banners-add_edit.php';
			} else {
				require_once $this->admin_view_path . 'banners-list.php';
			}

		}

		private function print_view_payment_settings(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$uid = (empty($_GET['uid'])) ? 0 : sanitize_text_field($_GET['uid']);
			$data['metas'] = $af_db->get_affiliate_payment_settings($uid);

			$this->print_top_messages();
			require_once $this->admin_view_path . 'affiliate-payment-settings.php';
		}

		private function print_payments(){
			/*
			 * @param none
			 * @return string
			 */
			/// PRINT SUBMENU

			global $af_db;

			$data['submenu'] = array(
									// since version v.8.6
				          admin_url('admin.php?page=openaffiliates&tab=payments&subtab=manage_payouts') => esc_html__( 'Mass Payouts', 'openaffiliates' ),
									admin_url('admin.php?page=openaffiliates&tab=payments&subtab=manage_payments') => esc_html__( 'Payments', 'openaffiliates' ),
									// end of version v.8.6

									admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list') 							=> esc_html__('Payments For Affiliates', 'openaffiliates'),
									// deprecated since version v.8.6 :
									//admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list_all_unpaid') 	=> esc_html__('All Unpaid Referrals', 'openaffiliates'),
									//admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list_all_paid') 		=> esc_html__('All Paid Referrals', 'openaffiliates'),
									//admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions') 			=> esc_html__('All Transactions', 'openaffiliates'),
									// end of deprecated
			);
			$data['submenu'] = apply_filters( 'af_admin_filter_payments_submenu', $data['submenu'] );


			// since version v.8.6
			$payoutsModel = new \OpenAffiliates\Db\Payouts();
			if ( empty( $_GET['subtab'] ) ){
					if ( $payoutsModel->haveEntries() ){
							$subtab = 'manage_payouts';
					} else {
							// no
							$subtab = 'manage_payments';
					}
			} else {
					$subtab = sanitize_text_field($_GET['subtab']);
			}
			// end of v.8.6

			require_once $this->admin_view_path . 'submenu.php';

			$this->print_top_messages();
			// $subtab = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);

			switch ($subtab){
				case 'list':

					/// VIEW
					$limit = 30;
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$total_items = $af_db->get_payments(-1, -1, TRUE);
					$total_items = (empty($total_items[0])) ? 0 : $total_items[0];
					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list');
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$pagination = new AfPagination(array(
							'base_url' => $url,
							'param_name' => 'af_list_item',
							'total_items' => $total_items,
							'items_per_page' => $limit,
							'current_page' => $current_page,
					));
					$data['pagination'] = $pagination->output();

					$data['listing_items'] = $af_db->get_payments($limit, $offset, FALSE);
					$data['stats'] = $af_db->get_stats_for_payments();
					$data['stats']['currency'] = afCurrency();
					$data['pay_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=payment_form');
					$data['unpaid_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=unpaid');
					$data['paid_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions');
					$data['paid_referrals'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=paid_referrals');

					if ($data['listing_items']){
						$data['payments_settings'] = array();
						foreach ($data['listing_items'] as $id=>$arr){
							if (empty($data['payments_settings'][$id])){
								$data['payments_settings'][$id] = $af_db->get_affiliate_payment_type(0, $id);
							}
						}
					}

					require_once $this->admin_view_path . 'payments.php';
					break;
				case 'list_all_unpaid':
					/// VIEW
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list_all_unpaid');
					$limit = 30;
					$where = array();

					$where[] = " amount>0 ";// added since 8.2

					if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
						$where[] = " date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
						$where[] = " date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
						$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
					}
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$total_items = $af_db->get_all_referral_by_payment_status(0, -1, -1, TRUE, '', '', $where);
					$total_items = (empty($total_items[0])) ? 0 : $total_items[0];
					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					$data['pay_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=payment_form');
					$data['listing_items'] = $af_db->get_all_referral_by_payment_status(0, $limit, $offset, FALSE, 'date', 'DESC', $where);
					if ($data['listing_items']){
						$data['payments_settings'] = array();
						foreach ($data['listing_items'] as $arr){
							if (empty($data['payments_settings'][$arr['affiliate_id']])){
								$data['payments_settings'][$arr['affiliate_id']] = $af_db->get_affiliate_payment_type(0, $arr['affiliate_id']);
							}
						}
					}
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$pagination = new AfPagination(array(
							'base_url' => $url,
							'param_name' => 'af_list_item',
							'total_items' => $total_items,
							'items_per_page' => $limit,
							'current_page' => $current_page,
					));
					$data['pagination'] = $pagination->output();
					$data['filter'] = af_return_date_filter($url);
					require_once $this->admin_view_path . 'payments-list-all_unpaid.php';
					break;
				case 'list_all_paid':
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=list_all_paid');
					$limit = 30;
					$where = array();
					if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
						$where[] = " date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
						$where[] = " date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
						$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
					}
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$total_items = $af_db->get_all_referral_by_payment_status(2, -1, -1, TRUE, '', '', $where);
					$total_items = (empty($total_items[0])) ? 0 : $total_items[0];
					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$data['listing_items'] = $af_db->get_all_referral_by_payment_status(2, $limit, $offset, FALSE, 'date', 'DESC', $where);
					$pagination = new AfPagination(array(
							'base_url' => $url,
							'param_name' => 'af_list_item',
							'total_items' => $total_items,
							'items_per_page' => $limit,
							'current_page' => $current_page,
					));
					$data['pagination'] = $pagination->output();
					$data['filter'] = af_return_date_filter($url);
					require_once $this->admin_view_path . 'payments-list-all_paid.php';
					break;
				case 'transactions':
					/// ACTIONS
					if (!empty($_POST['do_payment']) && !empty($_POST['af_admin_payment_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_payment_nonce']), 'af_admin_payment_nonce' ) ){
						if (empty($_POST['affiliates'])){
							$errors = $this->do_single_payment( af_sanitize_textarea_array($_POST) );
							if (!empty($errors['error_users'])){
								$data['error_users'] = $errors['error_users'];
							}

							if ( !empty( $errors['error_details_for_users'] ) ){
									$data['error_details_for_users'] = $errors['error_details_for_users'];
							}
							if ( !empty( $errors['general_error_for_payment'] ) ){
									$data['general_error_for_payment'] = $errors['general_error_for_payment'];
							}
						} else {
							$errors = $this->do_multiple_payments( af_sanitize_textarea_array($_POST) );

							if (!empty($errors['error_users'])){
								$data['error_users'] = $errors['error_users'];
							}
							if ( !empty( $errors['error_details_for_users'] ) ){
									$data['error_details_for_users'] = $errors['error_details_for_users'];
							}
							if ( !empty( $errors['general_error_for_payment'] ) ){
									$data['general_error_for_payment'] = $errors['general_error_for_payment'];
							}

						}
					}

					if (!empty($_POST['transaction_id']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->change_transaction_status( sanitize_text_field($_POST['transaction_id']), sanitize_text_field($_POST['new_status']) );
					} else if (!empty($_POST['delete_transaction']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->cancel_transaction( sanitize_text_field($_POST['delete_transaction']));
					} else if (!empty($_GET['do_update_payments'])){
						$af_db->update_paypal_transactions();
					}

					/// VIEW
					$affiliate_id = (empty($_GET['affiliate'])) ? 0 : sanitize_text_field($_GET['affiliate']);
					if ($affiliate_id){
						$wpuid = $af_db->get_uid_by_affiliate_id($affiliate_id);
						$username = $af_db->get_username_by_wpuid($wpuid);
						$full_name = $af_db->get_full_name_of_user($affiliate_id);
						$data['subtitle'] = esc_html__('View Transactions for', 'openaffiliates') . " $full_name ($username)";
					}
					$limit = 30;
					$where = array();
					if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
						$where[] = " create_date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
						$where[] = " create_date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
						$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
					}
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$total_items = (int)($af_db->get_transactions($affiliate_id, -1, -1, TRUE, '', '', $where));

					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions');
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$pagination = new AfPagination(array(
							'base_url' => $url,
							'param_name' => 'af_list_item',
							'total_items' => $total_items,
							'items_per_page' => $limit,
							'current_page' => $current_page,
					));

					$data['listing_items'] = $af_db->get_transactions($affiliate_id, $limit, $offset, FALSE, 'create_date', 'DESC', $where);
					$data['pagination'] = $pagination->output();
					$data['filter'] = af_return_date_filter($url);
					$data['view_transaction_url'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=view_transaction_details');
					$data['update_payments'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions&do_update_payments=1');
					require_once $this->admin_view_path . 'transactions.php';
					break;
				case 'unpaid':
					$limit = 30;
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=unpaid&affiliate=' . sanitize_text_field($_GET['affiliate']));
					$where = array();

					$where[] = " amount>0 ";// added since 8.2

					if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
						$where[] = " date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
						$where[] = " date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
						$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
					}

					if (!empty($_GET['affiliate'])){
						$wpuid = $af_db->get_uid_by_affiliate_id( sanitize_text_field($_GET['affiliate']) );
						$username = $af_db->get_username_by_wpuid($wpuid);
						$full_name = $af_db->get_full_name_of_user(sanitize_text_field($_GET['affiliate']));
						$data['subtitle'] = esc_html__('View Unpaid Referrals for', 'openaffiliates') . " $full_name ($username)";
					}
					$total_items = $af_db->get_unpaid_payments_for_affiliate( sanitize_text_field($_GET['affiliate']), -1, -1, TRUE, '', '', $where);
					$total_items = (empty($total_items[0])) ? 0 : $total_items[0];
					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					$data['listing_items'] = $af_db->get_unpaid_payments_for_affiliate( sanitize_text_field($_GET['affiliate']), $limit, $offset, FALSE, '', '', $where);
					if ($data['listing_items']){
						$data['payments_settings'] = array();
						if(isset($_GET['affiliate'])){
							$data['payments_settings'][ sanitize_text_field($_GET['affiliate']) ] = $af_db->get_affiliate_payment_type(0, sanitize_text_field($_GET['affiliate']) );
						}

					}
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$pagination = new AfPagination(array(
							'base_url' 					=> $url,
							'param_name' 				=> 'af_list_item',
							'total_items' 			=> $total_items,
							'items_per_page' 		=> $limit,
							'current_page' 			=> $current_page,
					));
					$data['pagination'] = $pagination->output();
					$data['pay_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=payment_form&affiliate=' . sanitize_text_field($_GET['affiliate']) );
					$data['filter'] = af_return_date_filter($url);
					$data['selected_referrences'] = [];
					$data['selected_referrences'] = apply_filters( 'af_admin_payments_list_unpaid_for_affiliate_selected_referrences', $data['selected_referrences'] );
					require_once $this->admin_view_path . 'payments-list-all_unpaid.php';
					break;
				case 'paid_referrals':
					/// VIEW
					$limit = 30;
					$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
					$where = array();
					if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
						$where[] = " date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
						$where[] = " date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
						$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
					}
					if (!empty($_GET['affiliate'])){
						$wpuid = $af_db->get_uid_by_affiliate_id( sanitize_text_field($_GET['affiliate']) );
						$username = $af_db->get_username_by_wpuid($wpuid);
						$full_name = $af_db->get_full_name_of_user(sanitize_text_field($_GET['affiliate']));
						$data['subtitle'] = esc_html__('View Paid Referrals for', 'openaffiliates') . " $full_name ($username)";
					}
					$total_items = $af_db->get_paid_referrals_for_affiliate(sanitize_text_field($_GET['affiliate']), -1, -1, TRUE, '', '', $where);
					$total_items = (empty($total_items[0])) ? 0 : $total_items[0];
					if ($current_page>1){
						$offset = ( $current_page - 1 ) * $limit;
					} else {
						$offset = 0;
					}
					if ($offset + $limit>$total_items){
						$limit = $total_items - $offset;
					}
					$url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=paid_referrals&affiliate=' . sanitize_text_field($_GET['affiliate']));
					$data['listing_items'] = $af_db->get_paid_referrals_for_affiliate( sanitize_text_field( $_GET['affiliate']), $limit, $offset, FALSE, '', '', $where);
					require_once AF_PATH . 'classes/AfPagination.class.php';
					$limit = 30;
					$pagination = new AfPagination(array(
							'base_url' => $url,
							'param_name' => 'af_list_item',
							'total_items' => $total_items,
							'items_per_page' => $limit,
							'current_page' => $current_page,
					));
					$data['pagination'] = $pagination->output();
					$data['filter'] = af_return_date_filter($url);
					require_once $this->admin_view_path . 'payments-list-all_paid.php';
					break;
				case 'payment_form':
					/// ACTIONS
					if (!empty($_POST['referrals'])){
						$ids = implode(',', af_sanitize_array($_POST['referrals']));
						if (empty($_GET['affiliate'])){
							/// get details for affiliate that has the selected referrals
							$data['multiple_affiliates'] = $af_db->get_affiliate_payment_details_for_referral_list($ids);
						} else {
							//details for one affiliate with some referal ids .
							$data['affiliate_pay'] = $af_db->get_affiliate_payment_details(sanitize_text_field($_GET['affiliate']), $ids);
						}
					} else if (!empty($_GET['affiliate'])){
						// one affiliate with all referrals with filter or not
						$startFrom = isset( $_POST['start_date'] ) ? sanitize_text_field( $_POST['start_date'] ) : false;
						$endDate = isset( $_POST['end_date'] ) ? sanitize_text_field( $_POST['end_date'] ) : false;

						if ( !empty( $startDate ) || !empty( $endDate ) ){
								// with time filter
								$where = [];
								global $wpdb;
								if (!empty($startDate) ){
									$where[] = $wpdb->prepare( " date>%s ", $startDate );
								}
								if ( !empty( $endDate ) ){
									$where[] = $wpdb->prepare( " date<%s ", $endDate );
								}
								$where[] = $wpdb->prepare( " affiliate_id=%d ", sanitize_text_field( $_GET['affiliate'] ) );
								$referralsFromFilter = $af_db->get_all_referral_by_payment_status( 0, -1, -1, false, '', '', $where );
								$ids = [];
								if ( $referralsFromFilter ){
										foreach ( $referralsFromFilter as $referralItem ){
												if ( isset( $referralItem['id'] ) ){
														$ids[] = $referralItem['id'];
												}
										}
								}
								$referralList = implode(',', $ids );
								$data['affiliate_pay'] = $af_db->get_affiliate_payment_details( sanitize_text_field($_GET['affiliate']), $referralList );
						} else {
								// standard
								$data['affiliate_pay'] = $af_db->get_affiliate_payment_details( sanitize_text_field($_GET['affiliate']) );
						}
					}

					/// VIEW
					$data['currency'] = get_option( 'af_currency' );
					$data['submit_link'] = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions');
					$data['return_url'] = admin_url('admin.php?page=openaffiliates&tab=payments');
					$data['paypal'] = $af_db->is_magic_feat_enable('paypal');
					$data['stripe'] = $af_db->is_magic_feat_enable('stripe');
					$data['stripe_v2'] = $af_db->is_magic_feat_enable('stripe_v2');
					$data['stripe_v3'] = $af_db->is_magic_feat_enable('stripe_v3');
					require_once $this->admin_view_path . 'payment-form.php';
					break;
				case 'view_transaction_details':
					$data['listing_items'] = array();
					if(isset($_GET['id'])){
						$data['listing_items'] = $af_db->get_transation_details( sanitize_text_field($_GET['id']) );
					}

					if ($data['listing_items'] && isset($data['listing_items'][0]) && isset($data['listing_items'][0]['affiliate_id'])){
						$affiliate_id = $data['listing_items'][0]['affiliate_id'];
						$data['payments_settings'] = $data['payments_settings']= $af_db->get_affiliate_payment_type(0, $affiliate_id);
					}
					$data['payment_details_on_transaction'] = array();
					if(isset($_GET['id'])){
						$data['payment_details_on_transaction'] = $af_db->get_payment_details_on_transaction_by_id( sanitize_text_field($_GET['id']) );
					}

					require_once $this->admin_view_path . 'payments-list-all_paid.php';
					break;
				default:
					do_action( 'af_admin_dashboard_payment_tab_custom_subtab', $subtab );
					break;
			}

		}

		private function do_single_payment($post_data=array()){
			/*
			 * @param array
			 * @return boolean
			 */
			if (empty($post_data)){
				 return;
			}
			global $af_db;
			$ids = (empty($post_data["referrals_in"])) ? array() : explode(',', af_sanitize_textarea_array($post_data["referrals_in"]) );
			switch ($post_data['paywith']):
				case 'bank_transfer':
					/// bank transfer
					$af_db->change_referrals_status($ids, sanitize_text_field($post_data['payment_status']));/// set referral payment as complete
					$data = array(
									'payment_type' => 'bank_transfer',
									'transaction_id' => '-',
									'referral_ids' => af_sanitize_textarea_array($post_data["referrals_in"]),
									'affiliate_id' => sanitize_text_field($post_data['affiliate_id']),
									'amount' => sanitize_text_field($post_data['amount']),
									'currency' => sanitize_text_field($post_data['currency']),
									'create_date' => current_time( 'Y-m-d H:i:s' ), //date('Y-m-d H:i:s', time()),
									'update_date' => current_time( 'Y-m-d H:i:s' ), //date('Y-m-d H:i:s', time()),
									'status' => sanitize_text_field($post_data['payment_status']),
					);
					$af_db->add_payment($data);
					return TRUE;
					break;
				case 'paypal':
					/// paypal

					$post_data['amount'] = sanitize_text_field($post_data['amount']);
					$post_data['amount'] = floatval($post_data['amount'] );
					$post_data['currency'] = sanitize_text_field($post_data['currency']);
					$post_data['currency'] = strtoupper($post_data['currency']);
					$email = $af_db->get_paypal_email_addr( sanitize_text_field($post_data['affiliate_id']) );


					// validate amount
					if ( !is_numeric($post_data['amount']) || !is_float($post_data['amount']) || $post_data['amount'] <= 0 || strlen(intval($post_data['amount'])) > 7){
							$return['error_details_for_users'][] = [
									'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) ),
									'error_message'		=> esc_html__( 'The amount must be non-negative number, may optionally contain exactly 2 decimal places separated by point, limited to 7 digits before the decimal point', 'openaffiliates' ),
							];
							return $return;
					}

					if ( strlen($post_data['currency']) != 3){
						$return['error_details_for_users'][] = [
								'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) ),
								'error_message'		=> esc_html__( 'Currency code must be 3-character ISO 4217 value (upper case)', 'openaffiliates' ),
						];
						return $return;
				  }

					// validate email
					if ( !is_email( $email ) ){
							$return['error_details_for_users'][] = [
									'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) ),
									'error_message'		=> esc_html__( 'The Paypal Email address is Invalid', 'openaffiliates' ),
							];
							return $return;
					}

					require_once AF_PATH . 'classes/PayoutPayPal.class.php';
					$object = new \PayoutPayPal();
					if ( $object->isAvailableAndActive() === false ){
							// no api keys, out
							$return['general_error_for_payment'] = $object->getErrorDetails();
							return $return;
					}

					$object->add_payment( $email, sanitize_text_field($post_data['amount']), sanitize_text_field($post_data['currency']) );
					$batch_id = $object->do_payout();
					if ($batch_id){
						$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
						$data = array(
								'payment_type' => 'paypal',
								'transaction_id' => $batch_id,
								'referral_ids' => af_sanitize_textarea_array($post_data["referrals_in"]),
								'affiliate_id' => sanitize_text_field($post_data['affiliate_id']),
								'amount' => sanitize_text_field($post_data['amount']),
								'currency' => sanitize_text_field($post_data['currency']),
								'create_date' => current_time( 'Y-m-d H:i:s' ),
								'update_date' => current_time( 'Y-m-d H:i:s' ),
								'status' => 1,
						);
						$af_db->add_payment($data);
						return TRUE;
					} else {
							$errorDetails = $object->getErrorDetails();
							if ( $errorDetails ){
									/// error deatils
									$return['error_details_for_users'][] = [
											'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) ),
											'error_message'		=> $errorDetails,
									];
							} else {
									// general error
									$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) );
									$errorDetails = esc_html__( 'The Payment cannot be proceed because of the payment settings.', 'openaffiliates' );
							}
							$data = array(
									'payment_type' 				=> 'paypal',
									'transaction_id' 			=> '',
									'referral_ids' 				=> af_sanitize_textarea_array($post_data["referrals_in"]),
									'affiliate_id' 				=> sanitize_text_field($post_data['affiliate_id']),
									'amount' 							=> sanitize_text_field($post_data["amount"]),
									'currency' 						=> sanitize_text_field($post_data['currency']),
									'create_date' 				=> current_time( 'Y-m-d H:i:s' ),
									'update_date' 				=> current_time( 'Y-m-d H:i:s' ),
									'status' 							=> 0,
									'errors'							=> $errorDetails,
							);

							$af_db->add_payment($data);
					}

					return $return;
					break;
				case 'stripe':
					require_once AF_PATH . 'classes/PayoutStripe.class.php';
					$object = new PayoutStripe();
					$transaction_id = $object->do_payout(0, sanitize_text_field($post_data['affiliate_id']), sanitize_text_field($post_data['amount']), sanitize_text_field($post_data['currency']) );
					if ($transaction_id){
						$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
						$data = array(
								'payment_type' => 'stripe',
								'transaction_id' => $transaction_id,
								'referral_ids' => af_sanitize_textarea_array($post_data["referrals_in"]),
								'affiliate_id' => sanitize_text_field($post_data['affiliate_id']),
								'amount' => sanitize_text_field($post_data['amount']),
								'currency' => sanitize_text_field($post_data['currency']),
								'create_date' => current_time( 'Y-m-d H:i:s' ),
								'update_date' => current_time( 'Y-m-d H:i:s' ),
								'status' => 1,
						);
						$af_db->add_payment($data);
						return TRUE;
					}
					$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) );
					return $return;
					break;
				case 'stripe_v2':
					require_once AF_PATH . 'classes/PayoutStripeV2.class.php';
					$object = new PayoutStripeV2();
					$transaction_id = $object->do_payout(0, sanitize_text_field($post_data['affiliate_id']), sanitize_text_field($post_data['amount']), sanitize_text_field($post_data['currency']) );
					if ($transaction_id){
						$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
						$data = array(
								'payment_type' => 'stripe_v2',
								'transaction_id' => $transaction_id,
								'referral_ids' => af_sanitize_textarea_array($post_data["referrals_in"]),
								'affiliate_id' => sanitize_text_field($post_data['affiliate_id']),
								'amount' => sanitize_text_field($post_data['amount']),
								'currency' => sanitize_text_field($post_data['currency']),
								'create_date' => current_time( 'Y-m-d H:i:s' ),
								'update_date' => current_time( 'Y-m-d H:i:s' ),
								'status' => 1,
						);
						$af_db->add_payment($data);
						return TRUE;
					}
					$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) );
					return $return;
					break;
				case 'stripe_v3':
					$object = new \OpenAffiliates\PayoutStripeV3();
					$transaction_id = $object->do_payout(0, sanitize_text_field($post_data['affiliate_id']), sanitize_text_field($post_data['amount']), sanitize_text_field($post_data['currency']) );

					if ($transaction_id){
						$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
						$data = array(
								'payment_type' 				=> 'stripe_v3',
								'transaction_id' 			=> $transaction_id,
								'referral_ids' 				=> af_sanitize_textarea_array($post_data["referrals_in"]),
								'affiliate_id' 				=> sanitize_text_field($post_data['affiliate_id']),
								'amount' 							=> sanitize_text_field($post_data['amount']),
								'currency' 						=> sanitize_text_field($post_data['currency']),
								'create_date' 				=> current_time( 'Y-m-d H:i:s' ),
								'update_date' 				=> current_time( 'Y-m-d H:i:s' ),
								'status' 							=> 1,
						);
						$af_db->add_payment($data);
						return TRUE;
					}
					$haveError = $object->getErrorMessage();
					if ( $haveError ){
							$return['error_details_for_users'][] = [
									'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field( $post_data['affiliate_id'] ) ),
									'error_message'		=> $haveError,
							];
					} else {
							$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($post_data['affiliate_id']) );
					}
					return $return;
					break;
			endswitch;
		}

		private function do_multiple_payments($post_data=array()){
			/*
			 * @param array
			 * @return none
			 */
			if (empty($post_data)){
				 return;
			}
			global $af_db;
			switch ($post_data['paywith']):
				case 'bank_transfer':
					/// bank transfer
					$affiliates_arr = (empty($post_data['affiliates'])) ? '' : explode(',', af_sanitize_textarea_array($post_data['affiliates']) );
					if ($affiliates_arr){
						foreach ($affiliates_arr as $affiliate_id){
							$ids = (empty($post_data["referrals"][$affiliate_id])) ? array() : explode(',', af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]) );
							$af_db->change_referrals_status($ids, sanitize_text_field($post_data['payment_status']) );/// set referral payment status as complete
							$data = array(
									'payment_type' => 'bank_transfer',
									'transaction_id' => '-',
									'referral_ids' => af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]),
									'affiliate_id' => $affiliate_id,
									'amount' => sanitize_text_field($post_data["amount"][$affiliate_id]),
									'currency' => sanitize_text_field($post_data['currency'][$affiliate_id]),
									'create_date' => current_time( 'Y-m-d H:i:s' ),
									'update_date' => current_time( 'Y-m-d H:i:s' ),
									'status' => sanitize_text_field($post_data['payment_status']),
							);
							$af_db->add_payment($data);
						}
						return TRUE;
					}
					break;
				case 'paypal':
					/// paypal
					$return = array();
					$affiliates_arr = (empty($post_data['affiliates'])) ? '' : explode(',', af_sanitize_textarea_array($post_data['affiliates']) );

					if ($affiliates_arr){
						require_once AF_PATH . 'classes/PayoutPayPal.class.php';
						$object = new PayoutPayPal();
						if ( $object->isAvailableAndActive() === false ){
								// no api keys, out
								$return['general_error_for_payment'] = $object->getErrorDetails();
								return $return;
						}
						foreach ($affiliates_arr as $affiliate_id){
							$ids = (empty($post_data["referrals"][$affiliate_id])) ? array() : explode(',', af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]) );

							$post_data["amount"][$affiliate_id] = sanitize_text_field($post_data["amount"][$affiliate_id]);
							$post_data["amount"][$affiliate_id] = floatval($post_data["amount"][$affiliate_id] );
							$post_data['currency'][$affiliate_id] = sanitize_text_field($post_data['currency'][$affiliate_id]);
							$post_data['currency'][$affiliate_id] = strtoupper($post_data['currency'][$affiliate_id]);
							$email = $af_db->get_paypal_email_addr( sanitize_text_field($affiliate_id) );


							// validate amount
							if ( !is_numeric($post_data["amount"][$affiliate_id]) || !is_float($post_data["amount"][$affiliate_id]) || $post_data["amount"][$affiliate_id] <= 0 || strlen(intval($post_data["amount"][$affiliate_id])) > 7){
									$return['error_details_for_users'][] = [
											'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($affiliate_id) ),
											'error_message'		=> esc_html__( 'The amount must be non-negative number, may optionally contain exactly 2 decimal places separated by point, limited to 7 digits before the decimal point', 'openaffiliates' ),
									];
									return $return;
							}

							if ( strlen($post_data['currency'][$affiliate_id]) != 3){
								$return['error_details_for_users'][] = [
										'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($affiliate_id) ),
										'error_message'		=> esc_html__( 'Currency code must be 3-character ISO 4217 value (upper case)', 'openaffiliates' ),
								];
								return $return;
						  }

							// validate email
							if ( !is_email( $email ) ){
									$return['error_details_for_users'][] = [
											'username'				=> $af_db->get_wp_username_by_affiliate_id( sanitize_text_field($affiliate_id) ),
											'error_message'		=> esc_html__( 'The Paypal Email address is Invalid', 'openaffiliates' ),
									];
									return $return;
							}


							$object = new PayoutPayPal();

							$object->add_payment($email, sanitize_textarea_field($post_data["amount"][$affiliate_id]), sanitize_textarea_field($post_data['currency'][$affiliate_id]) );
							$batch_id = $object->do_payout();

							if ($batch_id){
								$af_db->change_referrals_status($ids, 1);///set referral payment status as pending
								$status = 1;
							} else {
									if (empty($return['error_users'])){
										$return['error_users'] = array();
									}
									$errorDetails = $object->getErrorDetails();
									if ( $errorDetails ){
											/// error deatils
											$return['error_details_for_users'][] = [
													'username'				=> $af_db->get_wp_username_by_affiliate_id($affiliate_id),
													'error_message'		=> $errorDetails,
											];
									} else {
											// general error
											$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id($affiliate_id);
											$errorDetails = esc_html__( 'The Payment cannot be proceed because of the payment settings.', 'openaffiliates' );
									}
									$batch_id = '';
									$status = 0;
							}

							/// insert transaction
							$data = array(
									'payment_type' 				=> 'paypal',
									'transaction_id' 			=> $batch_id,
									'referral_ids' 				=> sanitize_text_field($post_data["referrals"][$affiliate_id]),
									'affiliate_id' 				=> $affiliate_id,
									'amount' 							=> sanitize_text_field($post_data["amount"][$affiliate_id]),
									'currency' 						=> sanitize_text_field($post_data['currency'][$affiliate_id]),
									'create_date' 				=> current_time( 'Y-m-d H:i:s' ),
									'update_date' 				=> current_time( 'Y-m-d H:i:s' ),
									'status' 							=> $status,
									'errors'							=> (isset($errorDetails)) ? $errorDetails : '',
							);
							$af_db->add_payment($data);

							unset($object);
						}
					}
					return $return;
					break;
				case 'stripe':
					$return = array();
					$affiliates_arr = (empty($post_data['affiliates'])) ? '' : explode(',', af_sanitize_array($post_data['affiliates']) );
					if ($affiliates_arr){
						require_once AF_PATH . 'classes/PayoutStripe.class.php';
						foreach ($affiliates_arr as $affiliate_id){
							$ids = (empty($post_data["referrals"][$affiliate_id])) ? array() : explode(',', $post_data["referrals"][$affiliate_id]);
							$object = new PayoutStripe();
							$transaction_id = $object->do_payout(0, $affiliate_id, $post_data["amount"][$affiliate_id], $post_data['currency'][$affiliate_id]);
							if ($transaction_id){
								$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
								$data = array(
										'payment_type' => 'stripe',
										'transaction_id' => $transaction_id,
										'referral_ids' => af_sanitize_textarea_array( $post_data["referrals"][$affiliate_id]),
										'affiliate_id' => $affiliate_id,
										'amount' => sanitize_text_field($post_data["amount"][$affiliate_id]),
										'currency' => sanitize_text_field($post_data['currency'][$affiliate_id]),
										'create_date' => current_time( 'Y-m-d H:i:s' ),
										'update_date' => current_time( 'Y-m-d H:i:s' ),
										'status' => 1,
								);
								$af_db->add_payment($data);
							} else {
								if (empty($return['error_users'])){
									$return['error_users'] = array();
								}
								$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id($affiliate_id);
							}
							unset($object);
						}
					}
					return $return;
					break;
				case 'stripe_v2':
					$return = array();
					$affiliates_arr = (empty($post_data['affiliates'])) ? '' : explode(',', af_sanitize_textarea_array($post_data['affiliates']) );
					if ($affiliates_arr){
						require_once AF_PATH . 'classes/PayoutStripeV2.class.php';
						foreach ($affiliates_arr as $affiliate_id){
							$ids = (empty($post_data["referrals"][$affiliate_id])) ? array() : explode(',', $post_data["referrals"][$affiliate_id]);
							$object = new PayoutStripeV2();
							$transaction_id = $object->do_payout(0, $affiliate_id, $post_data["amount"][$affiliate_id], $post_data['currency'][$affiliate_id]);
							if ($transaction_id){
								$af_db->change_referrals_status($ids, 1);/// set referral payment status as pending
								$data = array(
										'payment_type' => 'stripe_v2',
										'transaction_id' => $transaction_id,
										'referral_ids' => af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]),
										'affiliate_id' => $affiliate_id,
										'amount' => sanitize_text_field($post_data["amount"][$affiliate_id]),
										'currency' => sanitize_text_field($post_data['currency'][$affiliate_id]),
										'create_date' => current_time( 'Y-m-d H:i:s' ),
										'update_date' => current_time( 'Y-m-d H:i:s' ),
										'status' => 1,
								);
								$af_db->add_payment($data);
							} else {
								if (empty($return['error_users'])){
									$return['error_users'] = array();
								}
								$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id($affiliate_id);
							}
							unset($object);
						}
					}
					return $return;
					break;
				case 'stripe_v3':
					$return = [];
					$affiliates_arr = (empty($post_data['affiliates'])) ? '' : explode(',', $post_data['affiliates']);
					if ($affiliates_arr){
						foreach ($affiliates_arr as $affiliate_id){
							$ids = (empty($post_data["referrals"][$affiliate_id])) ? array() : explode(',', af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]) );
							$object = new \OpenAffiliates\PayoutStripeV3();
							$transaction_id = $object->do_payout( 0, $affiliate_id, $post_data["amount"][$affiliate_id], $post_data['currency'][$affiliate_id] );
							if ($transaction_id){
								$af_db->change_referrals_status( $ids, 1 );/// set referral payment status as pending
								$data = array(
										'payment_type' 			=> 'stripe_v3',
										'transaction_id' 		=> $transaction_id,
										'referral_ids' 			=> af_sanitize_textarea_array($post_data["referrals"][$affiliate_id]),
										'affiliate_id' 			=> $affiliate_id,
										'amount' 						=> sanitize_text_field($post_data["amount"][$affiliate_id]),
										'currency' 					=> sanitize_text_field($post_data['currency'][$affiliate_id]),
										'create_date' 			=> current_time( 'Y-m-d H:i:s' ),
										'update_date' 			=> current_time( 'Y-m-d H:i:s' ),
										'status' 						=> 1,
								);
								$af_db->add_payment($data);
							} else {
								$haveError = $object->getErrorMessage();
								if ( $haveError ){
										$return['error_details_for_users'][] = [
												'username'				=> $af_db->get_wp_username_by_affiliate_id( $affiliate_id ),
												'error_message'		=> $haveError,
										];
								} else {
										$return['error_users'][] = $af_db->get_wp_username_by_affiliate_id( $affiliate_id );
								}
							}
							unset($object);
						}
					}
					return $return;
					break;
			endswitch;
		}

		private function print_notifications(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;

			if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				/// SAVE
				$af_db->save_notification($_POST);
			} else if (!empty($_POST['delete_notification']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				/// DELETE
				$af_db->delete_notification($_POST['delete_notification']);
			}

			$data['form_action_url'] = admin_url('admin.php?page=openaffiliates&tab=notifications');
			$data['subtab'] = (empty($_GET['subtab'])) ? 'list' : sanitize_text_field($_GET['subtab']);
			$data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=notifications&subtab=add_edit');
			$data['actions_available'] = $af_db->notificationsActions();
			$data['email_verification'] = $af_db->is_magic_feat_enable('email_verification');
			if (empty($data['email_verification'])){
				unset($data['actions_available']['email_check']);
				unset($data['actions_available']['email_check_success']);
				unset($data['actions_available']['test_notification']);
				unset($data['actions_available']['slug_username_errors']);
				unset($data['actions_available']['admin_check_email_server']);
				unset($data['actions_available']['admin_send_direct_email']);
				unset($data['actions_available']['af_referral_notification']);
				unset($data['actions_available']['af_admin_referral_notification']);
			}
			$data['ranks'] = $af_db->get_rank_list();

			if ($data['subtab']=='add_edit'){
				$data['ranks_available'] = array( -1 => esc_html__('All', 'openaffiliates') ) + $data['ranks'];
				//and the rest of ranks..

				$id = (empty($_GET['id'])) ? 0 : sanitize_text_field($_GET['id']);
				$metas = $af_db->get_notification($id);
				$temporary = af_return_default_notification_content($metas['type']);
				if ( isset( $temporary['description'] ) ){
						$metas['notification_description'] = $temporary['description'];
				}
				$data = array_merge($data, $metas);
			} else {
				$data['listing_items'] = $af_db->get_notifications();
			}

			if ($data['subtab']=='add_edit'){
				require_once $this->admin_view_path . 'notifications-add_edit.php';
			} else {
				require_once $this->admin_view_path . 'notifications-list.php';
			}

		}


		private function print_showcases(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			$data['url_register_settings'] = admin_url('admin.php?page=openaffiliates&tab=register');
			$data['url_login'] = admin_url('admin.php?page=openaffiliates&tab=login');
			$data['url_account_page'] = admin_url('admin.php?page=openaffiliates&tab=account_page');
			$data['url_top_affiliates'] = admin_url('admin.php?page=openaffiliates&tab=top_affiliates');
			require_once $this->admin_view_path . 'showcases.php';
		}

		private function print_reports(){
			/*
			 * @param none
			 * @return string
			 */
			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=reports&subtab=reports') => esc_html__('Reports', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=reports&subtab=achievements') => esc_html__('Achievements', 'openaffiliates'),
			);
			require_once $this->admin_view_path . 'submenu.php';
			$this->print_top_messages();

			global $af_db;
			$subtab = (empty($_GET['subtab'])) ? 'reports' : sanitize_text_field($_GET['subtab']);
			if ($subtab=='reports'){
				$data['select_values'] = array(
						'today' => esc_html__('Today', 'openaffiliates'),
						'yesterday' => esc_html__('Yesterday', 'openaffiliates'),
						'this_week' => esc_html__('This Week', 'openaffiliates'),
						'last_week' => esc_html__('Last Week', 'openaffiliates'),
						'this_month' => esc_html__('This Month', 'openaffiliates'),
						'last_month' => esc_html__('Last Month', 'openaffiliates'),
						'this_quarter' => esc_html__('This Quarter', 'openaffiliates'),
						'last_quarter' => esc_html__('Last Quarter', 'openaffiliates'),
						'this_year' => esc_html__('This Year', 'openaffiliates'),
						'last_year' => esc_html__('Last Year', 'openaffiliates'),
						'custom' => esc_html__('Custom', 'openaffiliates'),
						//'all_time' => esc_html__('All Time', 'openaffiliates'),
				);
				$data['selected'] = (isset($_POST['search'])) ? af_sanitize_array($_POST['search']) : 'last_month';
				$affiliate_id = (empty($_REQUEST['affiliate_id'])) ? 0 : sanitize_text_field($_REQUEST['affiliate_id']);
				$affiliate_name = (empty($_POST['affiliate_name'])) ? 0 : sanitize_text_field($_POST['affiliate_name']);

				if ($affiliate_id){
					$wpuid = $af_db->get_uid_by_affiliate_id($affiliate_id);
					$username = $af_db->get_username_by_wpuid($wpuid);
					$full_name = $af_db->get_full_name_of_user($affiliate_id);
					$data['subtitle'] =  " $full_name ($username)";
					$data['affiliate_id'] = $affiliate_id;
				}
				if (!empty($affiliate_name)){
					$affiliate_id = $af_db->get_affiliate_id_by_username_or_email($affiliate_name);
				}

				$data['currency'] = afCurrency();

				/*********** GRAPHS STUFF *******/

				$data['custom_start_date'] = false;
				$data['custom_end_date'] = false;
				$data['tick_size'] = '1';
				if ($data['selected']=='today' || $data['selected']=='yesterday'){
					// day
					$data['tick_type'] = 'hour';
				} else if ($data['selected']=='last_week' || $data['selected']=='last_month'  || $data['selected']=='this_week'  || $data['selected']=='this_month'){
					// month week
					$data['tick_type'] = 'day';
					$data['tick_size'] = '1';
				} else if( $data['selected']=='this_quarter' || $data['selected']=='last_quarter'){
					 // last/this quarter
					 $data['tick_type'] = 'day';
					 $data['tick_size'] = '7';
				}else if($data['selected']=='all_time'){
					/// all time
					$data['tick_type'] = 'year';
				} else {
					// custom
					$data['tick_type'] = 'month';
					$data['tick_size'] = '1';
				}

				/// ---- temporary
				$start = '';
				$end =  date('Y-m-d H:i:s', time() );
				switch( $data['selected'] ){
					case 'today':
						$start = strtotime('00:00:00');
						$start = date('Y-m-d H:i:s', $start);
						break;
					case 'yesterday':
						$start = strtotime('-1 day', strtotime('00:00:00') );
						$start = date('Y-m-d H:i:s', $start);
						$end = date('Y-m-d H:i:s', strtotime('00:00:00') );
						break;
					case 'last_week':
						$start = strtotime('Monday last week');
						$start = date('Y-m-d H:i:s', $start );
						$end =  strtotime('last Monday');
						$end = date('Y-m-d H:i:s', $end);
						break;
					case 'this_week':
						$start = strtotime('last Monday');
						$start = date('Y-m-d H:i:s', $start );
					break;
					case 'this_month':
						$start = strtotime('first day of this month midnight');
						$start = date('Y-m-d H:i:s', $start);
					break;
					case 'last_month':
						$start = strtotime('first day of last month midnight');
						$start = date('Y-m-d H:i:s', $start);
						$end =  strtotime('last day of last month midnight');
						$end = date('Y-m-d H:i:s', $end);
						break;
					case 'this_quarter':
						$start = strtotime((new DateTime('first day of -' . (((date('n') - 1) % 3) + 0) . ' month'))->format('Y-m-d'));
						$start = date('Y-m-d H:i:s', $start);
					break;
					case 'last_quarter':
						$start = strtotime((new DateTime('first day of -' . (((date('n') - 1) % 3) + 3) . ' month'))->format('Y-m-d'));
						$start = date('Y-m-d H:i:s', $start);
						$end =  strtotime((new DateTime('first day of -' . (((date('n') - 1) % 3) + 0) . ' month'))->format('Y-m-d'));
						$end = date('Y-m-d H:i:s', $end);
						break;
					case 'this_year':
						$start = strtotime('first day of january this year midnight');
						$start = date('Y-m-d H:i:s', $start);

						$difference = time() - strtotime( $start );
						$difference = $difference / ( 24 * 60 * 60 );

						if ( $difference <= 1 ){
								// hours
								$data['tick_type'] = 'hour';
								$data['tick_size'] = '1';
						} else if ( $difference > 1 && $difference <= 31 ){
								// days
								$data['tick_type'] = 'day';
								$data['tick_size'] = '1';
						} else if ( $difference > 31 && $difference <= 92 ){
								// days
								$data['tick_type'] = 'day';
								$data['tick_size'] = '7';
						} else if ( $difference > 92 ){
								// months
								$data['tick_type'] = 'month';
								$data['tick_size'] = '1';
						}
					break;
					case 'last_year':
						$start = strtotime('first day of january last year midnight');
						$start = date('Y-m-d H:i:s', $start);
						$end =  strtotime('first day of january this year midnight');
						$end = date('Y-m-d H:i:s', $end);
						break;
					case 'custom':
						$start = sanitize_text_field( $_POST['udf'] );
						if(isset($_POST['udu']) && $_POST['udu'] != ''){
							$end = sanitize_text_field( $_POST['udu'] );
						}else{
							$end = date('Y-m-d', time());
						}

						$data['custom_start_date'] = $start;
						$data['custom_end_date'] = $end;
						$difference = strtotime( $end ) - strtotime( $start );
						$difference = $difference / ( 24 * 60 * 60 );

						if ( $difference <= 1 ){
								// hours
								$data['tick_type'] = 'hour';
								$data['tick_size'] = '1';
						} else if ( $difference > 1 && $difference <= 31 ){
								// days
								$data['tick_type'] = 'day';
								$data['tick_size'] = '1';
						} else if ( $difference > 31 && $difference <= 92 ){
								// days
								$data['tick_type'] = 'day';
								$data['tick_size'] = '7';
						} else if ( $difference > 92 ){
								// months
								$data['tick_type'] = 'month';
								$data['tick_size'] = '1';
						}

						break;
					case 'all_time':
						$start = $af_db->getFirstVisitDate();
						$data['custom_start_date'] = $start;
						$data['custom_end_date'] = $end;
						$difference = strtotime( $end ) - strtotime( $start );
						$difference = $difference / ( 24 * 60 * 60 );
						if ( $difference <= 1 ){
								// hours
								$data['tick_type'] = 'hour';
								$data['tick_size'] = '1';
						} else if ( $difference > 1 && $difference < 91 ){
								// days
								$data['tick_type'] = 'day';
								$data['tick_size'] = '1';
						} else if ( $difference > 90 ){
								// months
								$data['tick_type'] = 'month';
								$data['tick_size'] = '1';
						}
						break;
				}
				//// end of temporary

				$data['reports'] = $af_db->get_stats_for_reports($data['selected'], $affiliate_id, $data['custom_start_date'], $data['custom_end_date']);

				/// GRAPH VISITS
				$data['visit_graph'] = $af_db->get_visits_for_graph($data['selected'], 'all', $affiliate_id, $data['custom_start_date'], $data['custom_end_date'] );
				$data['visit_graph_success'] = $af_db->get_visits_for_graph($data['selected'], 'success', $affiliate_id, $data['custom_start_date'], $data['custom_end_date']);


				/// GRAPH REFERRALS
				$data['referrals_graph'] = $af_db->get_referrals_for_graph($data['selected'], -1, $affiliate_id, $data['custom_start_date'], $data['custom_end_date'] );
				$data['referrals_graph-refuse'] = $af_db->get_referrals_for_graph($data['selected'], 0, $affiliate_id, $data['custom_start_date'], $data['custom_end_date'] );
				$data['referrals_graph-unverified'] = $af_db->get_referrals_for_graph($data['selected'], 1, $affiliate_id, $data['custom_start_date'], $data['custom_end_date'] );
				$data['referrals_graph-verified'] = $af_db->get_referrals_for_graph($data['selected'], 2, $affiliate_id, $data['custom_start_date'], $data['custom_end_date'] );


				//af_debug_var( $data['referrals_graph']);

				$temporaryData = afGetArrayDate( $start, $end, $data['tick_type'] );
				$data['visit_graph'] = afArrayIntersectKeepKeys($temporaryData, $data['visit_graph'] );
				$data['visit_graph_success'] = afArrayIntersectKeepKeys($temporaryData, $data['visit_graph_success'] );
				$data['referrals_graph'] = afArrayIntersectKeepKeys($temporaryData, $data['referrals_graph'] );
				$data['referrals_graph-refuse'] = afArrayIntersectKeepKeys($temporaryData, $data['referrals_graph-refuse'] );
				$data['referrals_graph-unverified'] = afArrayIntersectKeepKeys($temporaryData, $data['referrals_graph-unverified'] );
				$data['referrals_graph-verified'] = afArrayIntersectKeepKeys($temporaryData, $data['referrals_graph-verified'] );

//echo '----';
				//af_debug_var( $data['referrals_graph'] );
				/*
				af_debug_var( $data['visit_graph'] );
				af_debug_var( $data['visit_graph_success'] );
				af_debug_var( $data['referrals_graph-refuse'] );
				af_debug_var( $data['referrals_graph-unverified'] );
				af_debug_var( $data['referrals_graph-verified'] );
				*/

				require_once $this->admin_view_path . 'reports.php';

			} else if ($subtab=='achievements') {
				if ( !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$search = (empty($_POST['search'])) ? '' : sanitize_textarea_field($_POST['affiliate_username']);
				} else {
						$search = '';
				}

				$data['current_url'] = admin_url('admin.php?page=openaffiliates&tab=reports&subtab=achievements_for_affiliate');
				$data['history'] = $af_db->get_last_rank_achievements(50, $search);
				require_once $this->admin_view_path . 'achievements.php';
			}
		}

		private function print_settings(){
			/*
			 * @param none
			 * @return string
			 */
			/// PRINT SUBMENU
			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=general') => esc_html__('General Settings', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=default_pages') => esc_html__('Pages Setup', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=redirects') => esc_html__('Redirects Setup', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=notification_settings') => esc_html__('Notifications Settings', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=payout') => esc_html__('Payout Settings', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=admin_workflow') => esc_html__('Admin Workflow', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=public_workflow') => esc_html__('Public Workflow', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=access') => esc_html__('WP Dashboard Access', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=uploads') => esc_html__('Uploads Settings', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=settings&subtab=captcha') => esc_html__('reCaptcha Setup', 'openaffiliates'),
			);

			$this->print_top_messages();

			require_once $this->admin_view_path . 'settings-header.php';
			///

			$currency = afCurrency();

			global $af_db;
			$data['subtab'] = (empty($_GET['subtab'])) ? 'general' : sanitize_text_field($_GET['subtab']);

			switch ($data['subtab']){
				case 'general':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-settings', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-settings');
					require_once $this->admin_view_path . 'settings-general.php';
					break;

				case 'redirects':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-redirects', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-redirects');
					require_once $this->admin_view_path . 'settings-redirects.php';
					break;
				case 'default_pages':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-default_pages', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-default_pages');
					require_once $this->admin_view_path . 'settings-default_pages.php';
					break;
				case 'captcha':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-captcha', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-captcha');
					require_once $this->admin_view_path . 'settings-captcha.php';
					break;
				case 'uploads':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-uploads', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-uploads');
					require_once $this->admin_view_path . 'settings-uploads.php';
					break;
				case 'notification_settings':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-notification', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-notification');
					require_once $this->admin_view_path . 'notification-settings.php';
					break;
				case 'access':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						update_option('af_dashboard_allowed_roles', af_sanitize_textarea_array($_POST['af_dashboard_allowed_roles']) );
					}
					$meta_value = get_option('af_dashboard_allowed_roles');
					$meta_values = (empty($meta_value)) ? array() : explode(',', $meta_value);
					require_once $this->admin_view_path . 'access.php';
					break;
				case 'admin_workflow':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$data['metas'] = $af_db->return_settings_from_wp_option('general-admin_workflow');
						$af_db->save_settings_wp_option('general-admin_workflow', af_sanitize_textarea_array($_POST) );
						if (!empty($data['metas']['af_update_ranks_interval']) && strcmp($data['metas']['af_update_ranks_interval'], af_sanitize_textarea_array($_POST['af_update_ranks_interval']))<>0){
							/// cron settings has been change
							require_once AF_PATH . 'classes/AfCronJobs.class.php';
							$cron_object = new AfCronJobs();
							$cron_object->update_cron_time( af_sanitize_textarea_array($_POST['af_update_ranks_interval']) );
						}
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-admin_workflow');
					require_once $this->admin_view_path . 'settings-admin_workflow.php';
					break;
				case 'payout':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){

						// since v. v.8.6
						if ( get_option('af_default_payment_system', 'bt') !== 'paypal' && sanitize_text_field( $_POST['af_default_payment_system'] ) === 'paypal' ){
								// paypal is set to default payout method, so we add the paypal email field into register form
								$registerFields = $af_db->register_get_custom_fields();
								$key = af_get_array_key_for_subarray_element( $registerFields, 'name', 'af_affiliate_bank_transfer_data' );
								if ( $key !== -1 ){
										$registerFields[$key]['display_public_reg'] = 0;
										$registerFields[$key]['display_public_ap'] = 0;
										$storeArray = $registerFields[$key];
										$storeArray['id'] = $key;
										$af_db->register_save_custom_field($storeArray);
								}
								$key = af_get_array_key_for_subarray_element( $registerFields, 'name', 'af_affiliate_paypal_email' );
								if ( $key !== -1 ){
										$registerFields[$key]['display_public_reg'] = 1;
										$registerFields[$key]['display_public_ap'] = 1;
										$storeArray = $registerFields[$key];
										$storeArray['id'] = $key;
										$af_db->register_save_custom_field($storeArray);
								}
						}
						// end of v.8.6

						$af_db->save_settings_wp_option('general-public_workflow', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-public_workflow');
					$data['payment_types'] = $af_db->get_payment_types_available();
					require_once $this->admin_view_path . 'settings-payout.php';
					break;
				case 'public_workflow':
					if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('general-public_workflow', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('general-public_workflow');
					$data['payment_types'] = $af_db->get_payment_types_available();
					require_once $this->admin_view_path . 'settings-public_workflow.php';
					break;
			}

			require_once $this->admin_view_path . 'settings-footer.php';
		}

		private function print_register(){
			/*
			 * @param none
			 * @return string
			 */

			/// PRINT SUBMENU
			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=register&subtab=register_showcase') => esc_html__('Register Showcase', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=register&subtab=custom_messages') => esc_html__('Custom Messages', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=register&subtab=custom_fields') => esc_html__('Custom Fields', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=opt_in') => esc_html__('Opt-In Settings', 'openaffiliates'),
			);
			require_once $this->admin_view_path . 'submenu.php';
			///

			$this->print_top_messages();
			global $af_db;

			$subtab = (empty($_GET['subtab'])) ? 'register_showcase' : sanitize_text_field($_GET['subtab']);
			switch ($subtab){
				case 'register_showcase':
					/// REGISTER SETTINGS
					if (isset($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('register', $_POST);
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('register', FALSE, FALSE);
					require_once $this->admin_view_path . 'register-settings.php';
					break;
				case 'custom_fields':
					/// SAVE/UPDATE/DELETE
					if (isset($_POST['delete_custom_field']) && $_POST['delete_custom_field']!='' && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->register_delete_custom_field($_POST['delete_custom_field']);
					} else if ( !empty($_POST['save_field']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->register_save_custom_field( af_sanitize_textarea_array($_POST) );
					} else if ( !empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						//update order of fields...
						$af_db->register_update_order( af_sanitize_textarea_array($_POST) );
					}
					///
					/// MANAGE CUSTOM FIELDS
					$data['register_fields'] = $af_db->register_get_custom_fields();
					ksort($data['register_fields']);
					$data['url_edit_custom_fields'] = admin_url('admin.php?page=openaffiliates&tab=register&subtab=custom_fields-add_edit');
					require_once $this->admin_view_path . 'register-custom_fields.php';
					break;
				case 'custom_fields-add_edit':
					/// ADD/UPDATE CUSTOM FIELD
					$data['form_submit'] = admin_url('admin.php?page=openaffiliates&tab=register&subtab=custom_fields');
					$data['field_types'] = array(
													'text' => esc_html__('Text', 'openaffiliates'),
													'textarea' => esc_html__('Textarea', 'openaffiliates'),
													'date' => esc_html__('Date Picker', 'openaffiliates'),
													'number' => esc_html__('Number', 'openaffiliates'),
													'select' => esc_html__('Select', 'openaffiliates'),
													'multi_select' => esc_html__('Multiselect Box', 'openaffiliates'),
													'checkbox' => esc_html__('Checkbox', 'openaffiliates'),
													'radio' => esc_html__('Radio', 'openaffiliates'),
													'file' => esc_html__('File Upload', 'openaffiliates'),
													'plain_text' => esc_html__('Plain Text', 'openaffiliates'),
													'conditional_text' => esc_html__('Verification Code', 'openaffiliates'),
					);
					$data['id'] = (!isset($_GET['id'])) ? '' : sanitize_text_field($_GET['id']);
					$data['metas'] = $af_db->register_get_field($data['id']);
					$data['disabled_items'] = array(
																						'confirm_email',
																						'tos',
																						'name',
																						'recaptcha',
																						'af_avatar',
																						'af_country',
																						'af_optin_accept',
					);
					$data['disabled'] = (in_array($data['metas']['name'], $data['disabled_items'])) ? 'disabled' : '';
					$data['register_fields'] = array('-1'=>'...') + $af_db->register_get_custom_fields(TRUE, array('social_media', 'upload_image', 'plain_text', 'file', 'capcha'));
					if (empty($data['metas']['conditional_logic_corresp_field'])){
						$data['metas']['conditional_logic_corresp_field'] = -1;
					}
					require_once $this->admin_view_path . 'register-custom_fields_add_edit.php';
					break;
				case 'custom_messages':
					if ( isset($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						$af_db->save_settings_wp_option('register-msg', af_sanitize_textarea_array($_POST) );
					}
					$data['metas'] = $af_db->return_settings_from_wp_option('register-msg', FALSE, FALSE);
					require_once $this->admin_view_path . 'register-custom_messages.php';
					break;
			}
		}

		private function print_login(){
			/*
			 * @param none
			 * @return string
			 */
			/// PRINT SUBMENU
			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=login') => esc_html__('Login Showcase', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=login&subtab=custom_messages') => esc_html__('Custom Messages', 'openaffiliates')
			);
			require_once $this->admin_view_path . 'submenu.php';
			///

			$this->print_top_messages();
			global $af_db;
			$data['subtab'] = (empty($_GET['subtab'])) ? '' : sanitize_text_field($_GET['subtab']);

			if ($data['subtab']=='custom_messages'){
				if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					$af_db->save_settings_wp_option('login-messages', af_sanitize_textarea_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('login-messages');
				require_once $this->admin_view_path . 'login-custom_messages.php';
			} else {
				if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
					$af_db->save_settings_wp_option('login', af_sanitize_textarea_array($_POST) );
				}
				$data['login_templates'] = array(

													9 => '(#9) ' . esc_html__('Radius Gradient Theme', 'openaffiliates'),
													8 => '(#8) ' . esc_html__('Border Pink Theme', 'openaffiliates'),
													10 => '(#10) ' . esc_html__('Simple BootStrap Theme', 'openaffiliates'),
													11 => '(#11) ' . esc_html__('Flat new Style', 'openaffiliates'),
													13 => '(#13) ' . esc_html__('Ultimate Member', 'openaffiliates'),
													12 => '(#12) ' . esc_html__('MegaBox', 'openaffiliates'),
													1 => '(#1) ' . esc_html__('Standard Theme', 'openaffiliates'),
													2 =>'(#2) '. esc_html__('Basic Theme', 'openaffiliates'),
													3 => '(#3) ' . esc_html__('BlueBox Theme', 'openaffiliates'),
													4 =>  '(#4) ' . esc_html__('Simple Green Theme', 'openaffiliates'),
													5 => '(#5) ' . esc_html__('Labels Theme', 'openaffiliates'),
													6 => '(#6) ' . esc_html__('Premium Theme', 'openaffiliates'),
													7 => '(#7) ' . esc_html__('Double Long Theme', 'openaffiliates')
				);
				$data['metas'] = $af_db->return_settings_from_wp_option('login');
				require_once $this->admin_view_path . 'login.php';
			}
		}

		private function print_account_page(){
			/*
			 * @param none
		 	 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				$af_db->save_settings_wp_option('account_page', af_sanitize_textarea_array( $_POST ) );
			}
			$data['top_themes'] = array(
									'af-ap-top-theme-1' => esc_html__('Template 1', 'openaffiliates'),
									'af-ap-top-theme-2' => esc_html__('Template 2', 'openaffiliates'),
									'af-ap-top-theme-3' => esc_html__('Template 3', 'openaffiliates'),
			);
			$data['themes'] = array(
									'af-ap-theme-1' => esc_html__('Template 1', 'openaffiliates'),
									'af-ap-theme-2' => esc_html__('Template 2', 'openaffiliates'),
									'af-ap-theme-3' => esc_html__('Template 3', 'openaffiliates'),
									'af-ap-theme-4' => esc_html__('Template 4', 'openaffiliates'),
			);
			$data['metas'] = $af_db->return_settings_from_wp_option('account_page');
			$data['available_tabs'] = $af_db->account_page_get_menu(FALSE, FALSE, TRUE);
			require_once $this->admin_view_path . 'account-page.php';
		}

		private function print_opt_in(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('opt_in', af_sanitize_textarea_array($_POST) );
			}
			$email_list = get_option('af_email_list');
			$data['email_list'] = (empty($email_list)) ? '' : $email_list;
			$data['metas'] = $af_db->return_settings_from_wp_option('opt_in');
			require_once AF_PATH . 'classes/OptInMailServices.class.php';
			$obj = new OptInMailServices();
			require_once $this->admin_view_path . 'opt-in.php';
		}

		private function print_visits(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['delete_visits']) && !empty($_POST['af_admin_forms_nonce']) && wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
				$af_db->delete_visits($_POST['delete_visits']);
			}

			$url = admin_url('admin.php?page=openaffiliates&tab=visits');
			$where = array();
			if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
				$where[] = " v.visit_date>'" . sanitize_text_field($_REQUEST['udf']) . "' ";
				$where[] = " v.visit_date<'" . sanitize_text_field($_REQUEST['udu']) . "' ";
				$url .= '&udf=' . sanitize_text_field($_REQUEST['udf']) . '&udu=' . sanitize_text_field($_REQUEST['udu']);
			}
			if (!empty($_REQUEST['aff_u'])){
				$where[] = " ((u.user_login LIKE '%" . sanitize_text_field($_REQUEST['aff_u']) . "%') OR  (u.user_email LIKE '%" . sanitize_text_field($_REQUEST['aff_u']) . "%') )";
				$url .= '&aff_u=' . sanitize_text_field($_REQUEST['aff_u']);
			}
			if (isset($_REQUEST['u_sts'])){
				switch($_REQUEST['u_sts']){
					case 0:
							$where[] = " v.referral_id =0";

							break;
					case 1:
							$where[] = " v.referral_id!=0 ";
							break;
				}
				$url .= '&u_sts=' . sanitize_text_field($_REQUEST['u_sts']);
			}

			if (!empty($_REQUEST['affiliate_id'])){
				$where[] = "v.affiliate_id=" . sanitize_text_field($_REQUEST['affiliate_id']);
				$url .= '&affiliate_id=' . sanitize_text_field($_REQUEST['affiliate_id']);
				$wpuid = $af_db->get_uid_by_affiliate_id( sanitize_text_field($_REQUEST['affiliate_id']));
				$username = $af_db->get_username_by_wpuid($wpuid);
				$full_name = $af_db->get_full_name_of_user( sanitize_text_field($_REQUEST['affiliate_id']));
				$data['subtitle'] = esc_html__('View Clicks for', 'openaffiliates') . " $full_name ($username)";
			}

			$data['base_list_url'] = $url;
			$limit = (empty($_GET['af_limit'])) ? 25 : sanitize_text_field($_GET['af_limit']);
			$url .= '&af_limit=' . $limit;
			$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
			$total_items = (int)$af_db->get_visits(-1, -1, TRUE, '', '', $where );
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}
			$data['listing_items'] = $af_db->get_visits($limit, $offset, FALSE, 'v.visit_date', 'DESC', $where);
			$data['filter'] = af_return_date_filter($url,
																								array(
																									0 => esc_html__('Just Visit', 'openaffiliates'),
																									1 => esc_html__('Converted', 'openaffiliates'),
																								),
																								 array(),
																								 TRUE);

			require_once AF_PATH . 'classes/AfPagination.class.php';
			$limit = (empty($_GET['af_limit'])) ? 25 : sanitize_text_field($_GET['af_limit']);

			$pagination = new AfPagination(array(
														'base_url' => $url,
														'param_name' => 'af_list_item',
														'total_items' => $total_items,
														'items_per_page' => $limit,
														'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();

			require_once $this->admin_view_path . 'visits.php';
		}

		private function print_magic_features(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['feature_types'] = $af_db->get_magic_feat_item_list();
			/// PRINT SUBMENU
			foreach ($data['feature_types'] as $k=>$v){
				if($k != 'new_extension'){
					$data['submenu'][$v['link']] = isset( $v['label'] ) ? $v['label'] : '';
				}
			}
			//require_once $this->admin_view_path . 'submenu.php';
			///

			if (!empty($_GET['subtab'])){
				switch ($_GET['subtab']){
					case 'sign_up_referrals':
						$this->print_sign_up_referrals();
						break;
					case 'lifetime_commissions':
						$this->print_lifetime_commissions();
						break;
					case 'reccuring_referrals':
						$this->print_reccuring_referrals();
						break;
					case 'social_share':
						$this->print_social_share();
						break;
					case 'paypal':
						$this->print_paypal();
						break;
					case 'allow_one_referrence':
						$this->print_allow_own_referrence();
						break;
					case 'mlm':
						$this->print_mlm();
						break;
					case 'edit_affiliate_referral_relation':
						$this->edit_affiliate_referral_relation();
						break;
					case 'add_new_affiliate_referral_relation':
						$this->add_new_affiliate_referral_relation();
						break;
					case 'rewrite_referrals':
						$this->print_rewrite_referrals();
						break;
					case 'bonus_on_rank':
						$this->print_bonus_on_rank();
						break;
					case 'opt_in':
						$this->print_opt_in();
						break;
					case 'stripe':
						$this->print_stripe();
						break;
					case 'coupons':
						$this->print_coupons();
						break;
					case 'friendly_links':
						$this->print_friendly_links();
						break;
					case 'custom_affiliate_slug':
						$this->print_custom_affiliate_slug();
						break;
					case 'mlm_view_affiliate_children':
						$this->print_mlm_view_affiliate_children();
						break;
					case 'wallet':
						$this->print_wallet();
						break;
					case 'checkout_select_referral':
						$this->print_checkout_select_referral();
						break;
					case 'woo_account_page':
						$this->print_woo_account_page();
						break;
					case 'bp_account_page':
						$this->print_bp_account_page();
						break;
					case 'referral_notifications':
						$this->print_referral_notifications();
						break;
					case 'admin_referral_notifications':
						$this->print_admin_referral_notifications();
						break;
					case 'periodically_reports':
						$this->print_periodically_reports();
						break;
					case 'qr_code':
						$this->print_qr_code();
						break;
					case 'email_verification':
						$this->print_email_verification();
						break;
					case 'custom_currencies':
						$this->print_custom_currencies();
						break;
					case 'source_details':
						$this->print_source_details();
						break;
					case 'wp_social_login':
						$this->print_wp_social_login();
						break;
					case 'stripe_v2':
						$this->print_stripe_v2();
						break;
					case 'pushover':
						$this->print_pushover();
						break;
					case 'max_amount':
						$this->print_max_amount();
						break;
					case 'simple_links':
						$this->print_simple_links();
						break;
					case 'account_page_menu':
						$this->print_account_page_menu();
						break;
					case 'migrate_affiliates_pro':
						$this->migrate_affiliates_pro();
						break;
					case 'migrate_wp_affiliates':
						$this->migrate_wp_affiliates();
						break;
					case 'migrate_affiliate_wp':
						$this->migrate_affiliate_wp();
						break;
					case 'ranks_pro':
						$this->ranks_pro();
						break;
					case 'landing_pages':
						$this->landing_pages();
						break;
					case 'pay_per_click':
						$this->pay_per_click();
						break;
					case 'cpm_commission':
						$this->cpm_commission();
						break;
					case 'pushover_referral_notifications':
						$this->pushover_referral_notifications();
						break;
					case 'rest_api':
						$this->rest_api();
						break;
					case 'pay_to_become_affiliate':
						$this->pay_to_become_affiliate();
						break;
					case 'info_affiliate_bar':
						$this->info_affiliate_bar();
						break;
					case 'product_links':
						$this->product_links();
						break;
					case 'stripe_v3':
						$this->stripe_v3();
						break;
					case 'weekly_email_summary':
						$this->weekly_email_summary();
						break;
				}
			} else {
				/// LIST THE FEATURES
				$this->print_top_messages();
				require_once $this->admin_view_path . 'magic-features.php';
			}
		}
		private function print_integrations(){
			/*
			 * @param none
			 * @return string
			 */
			 $data['integrations'] = \OpenAffiliates\Integrations::getSystems();

			 $this->print_top_messages();
			 require_once $this->admin_view_path . 'integrations.php';
		}
		private function print_wp_social_login(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('wp_social_login', af_sanitize_textarea_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('wp_social_login');
			$data['pages'] = $af_db->af_get_all_pages();
			$data['ranks'] = $af_db->get_ranks();
			$data['ranks'] = af_reorder_ranks($data['ranks']);//reorder
			require_once $this->admin_view_path . 'wp-social-login.php';
		}

		private function print_sign_up_referrals(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('sign_up_referrals', af_sanitize_textarea_array($_POST) );
				if (isset($_POST['signup_ranks_value'])){
					foreach ($_POST['signup_ranks_value'] as $id=>$value){
						if ($value==''){
							$value = -1;
						}
						$af_db->update_rank_column('sign_up_amount_value', $id, $value);
					}
				}
			}
			$data['amount_types'] = $this->amount_type_list;
			$data['metas'] = $af_db->return_settings_from_wp_option('sign_up_referrals');
			$data['rank_list'] = $af_db->get_rank_list();
			$data['rank_value_array'] = $af_db->get_column_value_for_each_rank('sign_up_amount_value');
			require_once $this->admin_view_path . 'sign-up-referrals.php';
		}

		private function print_lifetime_commissions(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_GET['delete'])){
				$af_db->affiliate_referrals_delete_relation( sanitize_text_field($_GET['delete']) );
			} else if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('lifetime_commissions', af_sanitize_textarea_array($_POST) );
				if (isset($_POST['lifetime_ranks_amount_type'])){
					foreach ($_POST['lifetime_ranks_amount_type'] as $id=>$value){
						$af_db->update_rank_column('lifetime_amount_type', sanitize_text_field($id), af_sanitize_textarea_array($value) );
					}
				}
				if (isset($_POST['lifetime_ranks_value'])){
					foreach ($_POST['lifetime_ranks_value'] as $id=>$value){
						if ($value==''){
							$value = -1;
						}
						$af_db->update_rank_column('lifetime_amount_value', sanitize_text_field($id), sanitize_text_field($value) );
					}
				}
			} else if (!empty($_POST['search'])){
				$data['affiliate_referrals_table_data'] = $af_db->get_affiliate_user_relation( sanitize_text_field($_POST['affiliate_username']), sanitize_text_field($_POST['username']) );
			} else if ( !empty($_POST['save-new-relation'] ) && !empty( $_POST['affiliate'] ) && !empty( $_POST['referral_uid'] ) ){
					$af_db->insert_affiliate_referral_user_new_relation( sanitize_text_field($_POST['affiliate']), sanitize_text_field($_POST['referral_uid'] ));
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('lifetime_commissions');
			$data['rank_list'] = $af_db->get_rank_list();
			$data['default_rank_amount_type_array'] = $af_db->get_column_value_for_each_rank('amount_type');
			$data['default_rank_amount_value_array'] = $af_db->get_column_value_for_each_rank('amount_value');
			$data['rank_amount_type_array'] = $af_db->get_column_value_for_each_rank('lifetime_amount_type');
			$data['rank_amount_value_array'] = $af_db->get_column_value_for_each_rank('lifetime_amount_value');
			$data['amount_types'] = $this->amount_type_list;
			$data['current_url'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=lifetime_commissions');
			$data['edit_relation'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=edit_affiliate_referral_relation');
			require_once $this->admin_view_path . 'lifetime-commissions.php';
		}

		private function edit_affiliate_referral_relation(){
			/*
			 * @param none
			 * @return none
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->update_affiliate_referral_user_relation( sanitize_text_field($_POST['id']), sanitize_text_field($_POST['affiliate']) );
			}
			$data['edit_data'] = array();
			if(isset($_GET['id'])){
				$data['edit_data'] = $af_db->get_affiliate_user_relation_by_id( sanitize_text_field( $_GET['id'] ) );
			}

			$data['affiliates'] = $af_db->get_affiliates_username_id_pair();
			require_once $this->admin_view_path . 'edit-affiliate-referral-relation.php';
		}

		/**
		 * @param none
		 * @return none
		 */
		private function add_new_affiliate_referral_relation()
		{
				global $af_db;
				$this->print_top_messages();
				$data = [
									'affiliates'  => $af_db->get_affiliates_username_id_pair(),
									'users'			  => $af_db->getUsers(),
				];
				require_once $this->admin_view_path . 'add-new-affiliate-referral-relation.php';
		}

		private function print_reccuring_referrals(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('reccuring_referrals', af_sanitize_textarea_array($_POST) );
				if (isset($_POST['reccuring_ranks_amount_type'])){
					foreach ($_POST['reccuring_ranks_amount_type'] as $id=>$value){
						$af_db->update_rank_column('reccuring_amount_type', sanitize_text_field($id), sanitize_text_field($value) );
					}
				}
				if (isset($_POST['reccuring_ranks_value'])){
					foreach ($_POST['reccuring_ranks_value'] as $id=>$value){
						if ($value==''){
							$value = -1;
						}
						$af_db->update_rank_column('reccuring_amount_value', sanitize_text_field($id), sanitize_text_field($value) );
					}
				}
			}

			$data['metas'] = $af_db->return_settings_from_wp_option('reccuring_referrals');
			$data['rank_list'] = $af_db->get_rank_list();
			$data['default_rank_amount_type_array'] = $af_db->get_column_value_for_each_rank('amount_type');
			$data['default_rank_amount_value_array'] = $af_db->get_column_value_for_each_rank('amount_value');
			$data['rank_amount_type_array'] = $af_db->get_column_value_for_each_rank('reccuring_amount_type');
			$data['rank_amount_value_array'] = $af_db->get_column_value_for_each_rank('reccuring_amount_value');
			$data['amount_types'] = $this->amount_type_list;
			require_once $this->admin_view_path . 'reccuring-referrals.php';
		}

		private function print_social_share(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('social_share', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('social_share');
			$data['social_share_page'] = admin_url('admin.php?page=ism_manage&tab=shortcode');
			require_once $this->admin_view_path . 'social-share.php';
		}

		private function print_paypal(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$phpversion = phpversion();
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('paypal', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('paypal');
			require_once $this->admin_view_path . 'paypal.php';
		}

		private function print_stripe(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('stripe', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('stripe');
			require_once $this->admin_view_path . 'stripe.php';
		}

		private function stripe_v3()
		{
				$this->print_top_messages();
				global $af_db;
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('stripe_v3', af_sanitize_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('stripe_v3');
				require_once $this->admin_view_path . 'stripe-v3.php';
		}

		/**
		 * @param none
		 * @return string
		 */
		public function weekly_email_summary()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$previousData = $af_db->return_settings_from_wp_option('weekly_email_summary');
					if ( (int)sanitize_text_field( $_POST['af_wes_enabled'] ) === 1 ){
							if ( (int)$previousData['af_wes_enabled'] === 0 ){
									// enable cron
									wp_schedule_event( afUnixtimestampForNextDayNumber( (int)sanitize_text_field( $_POST['af_wes_day_of_week'] ) ), 'weekly', 'af_cron_job_admin_weely_reports' );
							} else if ( (int)$previousData['af_wes_day_of_week'] !== (int)sanitize_text_field( $_POST['af_wes_day_of_week'] ) ){
									// rewrite cron to another day of week
									wp_clear_scheduled_hook( 'af_cron_job_admin_weely_reports' );
									wp_schedule_event( afUnixtimestampForNextDayNumber( (int)sanitize_text_field( $_POST['af_wes_day_of_week'] ) ), 'weekly', 'af_cron_job_admin_weely_reports' );
							}

					} else if ( (int)sanitize_text_field( $_POST['af_wes_enabled'] ) === 0 ){
							// disable cron
							wp_clear_scheduled_hook( 'af_cron_job_admin_weely_reports' );
					}
					$af_db->save_settings_wp_option('weekly_email_summary', af_sanitize_array($_POST) );
				}
				$data = $af_db->return_settings_from_wp_option('weekly_email_summary');
				$data['days_of_week'] = afDaysOfWeek();
				require_once $this->admin_view_path . 'weekly_email_summary.php';
		}

		private function print_stripe_v2(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('stripe_v2', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('stripe_v2');
			require_once $this->admin_view_path . 'stripe-v2.php';
		}

		/*
		 * @param none
		 * @return string
		 */
		private function print_pushover(){
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['af_save'])){
				$af_db->save_settings_wp_option('pushover', af_sanitize_array($_POST) );

				if ( empty( $_POST['af_pushover_enabled'] ) ){
						// deactivate tab
						$af_db->deactivateApTab( 'pushover' );
				} else {
						// activate tab
						$af_db->activateApTab( 'pushover' );
				}
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('pushover');
			require_once $this->admin_view_path . 'pushover.php';
		}

		private function print_coupons(){
			/*
			 * @param none
			 * @return string
			 */
			 global $af_db;
			 if (!empty($_POST['delete_coupons'])){
			 	$af_db->delete_coupon_affiliate_pair( af_sanitize_array($_POST['delete_coupons']) );
			 }
			 $data['amount_types'] = $this->amount_type_list;
			 $data['url-add_edit'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=coupons');
			 $data['url-manage'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=coupons');
			 if (isset($_GET['add_edit'])){
			 	$data['metas'] = $af_db->get_coupon_data( sanitize_text_field($_GET['add_edit']) );
				$data['affiliate'] = $af_db->get_wp_username_by_affiliate_id($data['metas']['affiliate_id']);
			 	require_once $this->admin_view_path . 'coupons-add_edit.php';
			 } else {
				 // coupon entity
				if (!empty($_POST['save'])){
						$saved = $af_db->save_coupon_affiliate_pair( af_sanitize_array($_POST) );
						if ($saved<1){
							$data['errors'] = esc_html__('Required fields are missing. Please ensure that all mandatory fields such as Code and Affiliate are filled out', 'openaffiliates');
						}
				} else if (!empty($_POST['delete_coupon'])){
						$af_db->delete_coupon_affiliate_pair( af_sanitize_array($_POST['delete_coupon']) );
				}
				/// coupon settings
				if (!empty($_POST['af_save'])){
						$af_db->save_settings_wp_option('coupons', af_sanitize_array($_POST) );

						if ( empty( $_POST['af_coupons_enable'] ) ){
								// deactivate tab
								$af_db->deactivateApTab( 'coupons' );
						} else {
								// activate tab
								$af_db->activateApTab( 'coupons' );
						}
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('coupons');
				$data['listing_items'] = $af_db->get_coupons_affiliates_pairs();
			 	require_once $this->admin_view_path . 'coupons-list.php';
			 }
		}

		private function print_allow_own_referrence(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('allow_own_referrence', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('allow_own_referrence');
			require_once $this->admin_view_path . 'allow-own-referrence.php';
		}

		private function print_mlm(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('mlm', af_sanitize_array($_POST) );

				if ( empty( $_POST['af_mlm_enable'] ) ){
						// deactivate tab
						$af_db->deactivateApTab( 'mlm' );
				} else {
						// activate tab
						$af_db->activateApTab( 'mlm' );
				}
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('mlm');
			$data['amount_types'] = $this->amount_type_list;
			$data['matrix_types'] = array(
													'unilevel' => esc_html__('The Unilevel Plan', 'openaffiliates'),
													'force' => esc_html__('The Force Matrix Plan', 'openaffiliates'),
													'binary' => esc_html__('Binary Plan', 'openaffiliates'),
			);
			$data['search_submit_url'] = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=mlm_view_affiliate_children');
			require_once $this->admin_view_path . 'mlm.php';
		}

		private function print_mlm_view_affiliate_children(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			$affiliate_name = (empty($_REQUEST['affiliate_name'])) ? 0 : sanitize_text_field($_REQUEST['affiliate_name']);

			$affiliate_id = $af_db->get_affiliate_id_by_username($affiliate_name);


	  	$affiliate_full_name = $af_db->get_full_name_of_user($affiliate_id);
			if($affiliate_full_name == ''){
				 $affiliate_full_name = 	$affiliate_name;
			}
			$affiliateuid = $af_db->get_uid_by_affiliate_id($affiliate_id);
			$affiliate_avatar = af_get_avatar_for_uid($affiliateuid );

			require_once AF_PATH . 'classes/MLMGetChildren.class.php';
			$children_object = new MLMGetChildren($affiliate_id);
			$data['items'] = $children_object->get_results();
			$data['parent'] = $af_db->mlm_get_parent($affiliate_id);
			if (empty($data['parent'])){
					$data['parent'] = '';
					$data['parent_id'] ='';
			} else {
					$parentUid = $af_db->get_uid_by_affiliate_id($data['parent']);
					$data['parent_id'] = $data['parent'];
					$data['parent_full_name'] = $af_db->get_full_name_of_user($data['parent']);
					$data['parent'] = $af_db->get_username_by_wpuid($parentUid);
					if($data['parent_full_name'] == ''){
						 $data['parent_full_name'] = $data['parent'];
					}
					$data['parent_avatar'] = af_get_avatar_for_uid($parentUid);
			}
			require_once $this->admin_view_path . 'mlm-view_affiliate_children.php';
		}

		private function print_rewrite_referrals(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('rewrite_referrals', af_sanitize_textarea_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('rewrite_referrals');
			require_once $this->admin_view_path . 'rewrite-referrals.php';
		}

		private function print_bonus_on_rank(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('bonus_on_rank', af_sanitize_textarea_array( $_POST ) );
				if (isset($_POST['bonus_ranks_value'])){
					foreach ($_POST['bonus_ranks_value'] as $id=>$value){
						$af_db->update_rank_column_force_empty('bonus', sanitize_text_field($id), af_sanitize_textarea_array($value) );
					}
				}
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('bonus_on_rank');
			$data['rank_list'] = $af_db->get_rank_list();
			$data['rank_value_array'] = $af_db->get_column_value_for_each_rank('bonus');
			$data['amount_types'] = $this->amount_type_list;

			require_once $this->admin_view_path . 'bonus-on-rank.php';
		}

		private function print_friendly_links(){
			/*
			 * @oaram none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				if ( empty( $_POST['af_friendly_links'] ) ){
						// deactivate tab
						$af_db->deactivateApTab( 'friendly_links' );
				} else {
						// activate tab
						$af_db->activateApTab( 'friendly_links' );
				}

				$af_db->save_settings_wp_option('friendly_links', af_sanitize_textarea_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('friendly_links');
			require_once $this->admin_view_path . 'friendly-links.php';
		}

		private function print_wallet(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('wallet', af_sanitize_textarea_array($_POST) );

				if ( empty( $_POST['af_wallet_enable'] ) ){
						// deactivate tab
						$af_db->deactivateApTab( 'wallet' );
				} else {
						// activate tab
						$af_db->activateApTab( 'wallet' );
				}

			}
			$data['metas'] = $af_db->return_settings_from_wp_option('wallet');
			require_once $this->admin_view_path . 'wallet.php';
		}

		private function print_max_amount(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('max_amount', af_sanitize_textarea_array($_POST) );
			}
			$data['ranks'] = $af_db->get_ranks();
			$data['metas'] = $af_db->return_settings_from_wp_option('max_amount');
			$data['amount_types'] = $this->amount_type_list;
			require_once $this->admin_view_path . 'max-amount.php';
		}

		private function print_simple_links(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('simple_links', af_sanitize_textarea_array($_POST) );
				$af_db->simple_links_save_link( af_sanitize_textarea_array($_POST), 1);
			} else if (!empty($_GET['delete'])){
				$af_db->simple_links_delete_link( sanitize_text_field($_GET['delete']) );
			} else if (!empty($_GET['approve'])){
				$af_db->simple_links_approve_link( sanitize_text_field($_GET['approve']) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('simple_links');

			if (!empty($_GET['affiliate_id'])){
				$where = " affiliate_id=" . sanitize_text_field($_GET['affiliate_id']) . " ";
			} else {
				$where = '';
			}
			$current_url = af_current_url();
			$url = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=simple_links');
			$limit = (isset($_GET['af_limit'])) ? sanitize_text_field($_GET['af_limit']) : 25;
			$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
			$total_items = $af_db->simple_links_get_counts($where);
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}
			require_once AF_PATH . 'classes/AfPagination.class.php';
			$limit = (isset($_GET['af_limit'])) ? sanitize_text_field($_GET['af_limit']) : 25;
			$pagination = new AfPagination(array(
					'base_url' => $current_url,
					'param_name' => 'af_list_item',
					'total_items' => $total_items,
					'items_per_page' => $limit,
					'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();
			$limit = 25;
			$data['items'] = $af_db->simple_links_get_items($limit, $offset, '', '', $where);

			require_once $this->admin_view_path . 'simple-links.php';
		}


		/*
		 * @param none
		 * @return string
		 */
		private function print_account_page_menu(){
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('account_page_menu', af_sanitize_array($_POST) );
				if (!empty($_POST['slug'])){
					$af_db->account_page_save_custom_menu_item( af_sanitize_array($_POST) );
				}
			} else if (!empty($_GET['delete'])){
				$af_db->account_page_menu_delete_custom_item( sanitize_text_field($_GET['delete']) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('account_page_menu');
			$data['menu'] = $af_db->account_page_get_menu(TRUE);
			$data['standard_tabs'] = $af_db->account_page_get_menu(TRUE, TRUE);
			$this->print_top_messages();
			require_once $this->admin_view_path . 'account-page_menu.php';
		}


		private function print_top_affiliates(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=top_affiliates') => esc_html__('Shortcode Generator', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=top_affiliates_settings') => esc_html__('Additional Settings', 'openaffiliates')
			);
			require_once $this->admin_view_path . 'submenu.php';
			$this->print_top_messages();
			require_once $this->admin_view_path . 'top-affiliates.php';
		}

		private function print_top_affiliates_settings(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('top_affiliate_list', af_sanitize_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('top_affiliate_list');

			$data['submenu'] = array(
					admin_url('admin.php?page=openaffiliates&tab=top_affiliates') => esc_html__('Shortcode Generator', 'openaffiliates'),
					admin_url('admin.php?page=openaffiliates&tab=top_affiliates_settings') => esc_html__('Settings', 'openaffiliates')
			);
			require_once $this->admin_view_path . 'submenu.php';
			$this->print_top_messages();
			require_once $this->admin_view_path . 'top-affiliates_settings.php';
		}

		private function print_custom_affiliate_slug(){
			/*
			 * @oaram none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('custom_affiliate_slug', af_sanitize_array($_POST) );

				if ( empty( $_POST['af_custom_affiliate_slug_on'] ) ){
						// deactivate tab
						$af_db->deactivateApTab( 'custom_affiliate_slug' );
				} else {
						// activate tab
						$af_db->activateApTab( 'custom_affiliate_slug' );
				}
			} else if (!empty($_POST['affiliate_id']) && !empty($_POST['slug'])){
				$uid = $af_db->get_uid_by_affiliate_id( sanitize_text_field($_POST['affiliate_id']) );
				if ($uid){
					$saved = $af_db->save_custom_slug_for_uid($uid, sanitize_text_field($_POST['slug']) );
				}
			}

			$url = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=custom_affiliate_slug');
			$current_url = $url;
			$limit = 25;
			$current_page = (empty($_GET['af_list_item'])) ? 1 : af_sanitize_array($_GET['af_list_item']);
			$total_items = $af_db->get_all_affiliates_slug(0, 0, TRUE);

			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}

			require_once AF_PATH . 'classes/AfPagination.class.php';
			$pagination = new AfPagination(array(
					'base_url' => $current_url,
					'param_name' => 'af_list_item',
					'total_items' => $total_items,
					'items_per_page' => $limit,
					'current_page' => $current_page,
			));

			$data['pagination'] = $pagination->output();
			$limit = 25;
			$data['items'] = $af_db->get_all_affiliates_slug($limit, $offset);
			$data['metas'] = $af_db->return_settings_from_wp_option('custom_affiliate_slug');
			require_once $this->admin_view_path . 'custom-affiliate-slug.php';
		}

		private function print_checkout_select_referral(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('checkout_select_referral', af_sanitize_textarea_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('checkout_select_referral');

			$usernames = array();
			$aff_list = '';
			if (!empty($data['metas']['af_checkout_select_affiliate_list'])){
				$aff_list = explode(',', $data['metas']['af_checkout_select_affiliate_list']);
				foreach ($aff_list as $id){
					$usernames[$id] = $af_db->get_wp_username_by_affiliate_id($id);
				}
				$usernames[-1] = 'All';
			}

			require_once $this->admin_view_path . 'checkout-select-referral.php';
		}

		private function print_woo_account_page(){
			/*
			 * @param none
			 * @return string
			 */
			 $this->print_top_messages();
			 global $af_db;
			 if (!empty($_POST['save'])){
			     $af_db->save_settings_wp_option('woo_account_page', af_sanitize_array($_POST) );
			 }
			 $data['metas'] = $af_db->return_settings_from_wp_option('woo_account_page');
			 require_once $this->admin_view_path . 'woo-account_page.php';
		}

		private function print_bp_account_page(){
			/*
			 * @param none
			 * @return string
			 */
			 $this->print_top_messages();
			 global $af_db;
			 if (!empty($_POST['save'])){
			     $af_db->save_settings_wp_option('bp_account_page', af_sanitize_array($_POST) );
			 }
			 $data['metas'] = $af_db->return_settings_from_wp_option('bp_account_page');
			 require_once $this->admin_view_path . 'bp-account-page.php';
		}

		private function migrate_affiliates_pro()
		{
				global $af_db;
				$this->print_top_messages();
				$data['ranks_available'] = $af_db->get_rank_list();
				require_once $this->admin_view_path . 'migrate-affiliates_pro.php';
		}

		private function migrate_wp_affiliates()
		{
				global $af_db;
				$this->print_top_messages();
				$data['ranks_available'] = $af_db->get_rank_list();
				require_once $this->admin_view_path . 'migrate-wp_affiliates.php';
		}

		private function migrate_affiliate_wp()
		{
				global $af_db;
				$this->print_top_messages();
				$data['ranks_available'] = $af_db->get_rank_list();
				require_once $this->admin_view_path . 'migrate-affiliate_wp.php';
		}

		private function ranks_pro()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
						if (get_option('af_ranks_pro_reset_day')!=af_sanitize_array($_POST['af_ranks_pro_reset_day']) ){
								update_option('af_ranks_pro_reset_day', af_sanitize_array($_POST['af_ranks_pro_reset_day']) );
								$object = new \OpenAffiliates\ResetRanks();
								$object->doSchedule();
						}
						$af_db->save_settings_wp_option('ranks_pro', af_sanitize_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('ranks_pro');
				require_once $this->admin_view_path . 'ranks-pro.php';
		}

		private function landing_pages()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_GET['delete'])){
						$af_db->removeAffiliateLandingPage( af_sanitize_array($_GET['delete']) );
				}
				if (!empty($_POST['save'])){
						$af_db->save_settings_wp_option('landing_pages', af_sanitize_textarea_array($_POST) );

						if ( empty( $_POST['af_landing_pages_enabled'] ) ){
								// deactivate tab
								$af_db->deactivateApTab( 'landing_pages' );
						} else {
								// activate tab
								$af_db->activateApTab( 'landing_pages' );
						}
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('landing_pages');
				$data['items'] = $af_db->getLandingPages();
				require_once $this->admin_view_path . 'landing-pages.php';
		}

		private function pay_per_click()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('pay_per_click', af_sanitize_array($_POST) );
					if (isset($_POST['pay_per_click_value'])){
						foreach ($_POST['pay_per_click_value'] as $id=>$value){
							$af_db->update_rank_column_force_empty('pay_per_click', sanitize_text_field($id), af_sanitize_array($value) );
						}
					}
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('pay_per_click');
				$data['rank_list'] = $af_db->get_rank_list();
				$data['rank_value_array'] = $af_db->get_column_value_for_each_rank('pay_per_click');
				$data['amount_types'] = $this->amount_type_list;

				require_once $this->admin_view_path . 'pay-per-click.php';
		}

		private function cpm_commission()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('cpm_commission', af_sanitize_textarea_array($_POST) );
					if (isset($_POST['cpm_commission_value'])){
						foreach ($_POST['cpm_commission_value'] as $id=>$value){
							$af_db->update_rank_column_force_empty('cpm_commission', sanitize_text_field($id), af_sanitize_textarea_array( $value ) );
						}
					}
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('cpm_commission');
				$data['rank_list'] = $af_db->get_rank_list();
				$data['rank_value_array'] = $af_db->get_column_value_for_each_rank('cpm_commission');
				$data['amount_types'] = $this->amount_type_list;

				require_once $this->admin_view_path . 'cpm-commission.php';
		}

		private function pushover_referral_notifications()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('pushover_referral_notifications', af_sanitize_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('pushover_referral_notifications');
				require_once $this->admin_view_path . 'pushover-referral_notifications.php';
		}

		private function rest_api()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('rest_api', af_sanitize_textarea_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('rest_api');
				$data['base_url'] = get_option('siteurl');
				require_once $this->admin_view_path . 'rest-api.php';
		}

		private function pay_to_become_affiliate()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('pay_to_become_affiliate', af_sanitize_textarea_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option('pay_to_become_affiliate');
				$data['metas']['products'] = array();
				if (!empty($data['metas']['af_pay_to_become_affiliate_target_products'])){
					$data['metas']['products'] = explode(',', $data['metas']['af_pay_to_become_affiliate_target_products']);
					switch ($data['metas']['af_pay_to_become_affiliate_target_product_group']){
						case 'woo':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->woo_get_product_title_by_id($id);
							}
							break;
						case 'ump':
							foreach ($data['metas']['products'] as $id){
								$data['products']['label'][$id] = $af_db->ump_get_level_label_by_id($id);
							}
							break;
					}
				}
				$data['base_url'] = get_option('siteurl');
				require_once $this->admin_view_path . 'pay-to-become-affiliate.php';
		}

		private function info_affiliate_bar()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
					$af_db->save_settings_wp_option('info_affiliate_bar', af_sanitize_textarea_array($_POST) );
				}
				$data['metas'] = $af_db->return_settings_from_wp_option( 'info_affiliate_bar' );
				require_once $this->admin_view_path . 'info-affiliate-bar.php';
		}

		private function print_notifications_logs()
		{
				require_once $this->admin_view_path . 'notification_logs.php';
		}

		private function product_links()
		{
				global $af_db;
				$this->print_top_messages();
				if (!empty($_POST['save'])){
						$af_db->save_settings_wp_option( 'product_links', af_sanitize_textarea_array($_POST) );

						if ( empty( $_POST['product_links_enable'] ) ){
								// deactivate tab
								$af_db->deactivateApTab( 'product_links' );
						} else {
								// activate tab
								$af_db->activateApTab( 'product_links' );
						}
				}
				$data['metas'] = $af_db->return_settings_from_wp_option( 'product_links' );
				require_once $this->admin_view_path . 'product-links.php';
		}

		private function print_referral_notifications(){
			/*
			 * @param none
			 * @return string
			 */
			 global $af_db;
			 if (!empty($_POST['save'])){
			     $af_db->save_settings_wp_option('referral_notifications', af_sanitize_textarea_array($_POST) );
			 }
			 $data['metas'] = $af_db->return_settings_from_wp_option('referral_notifications');

			 if (!class_exists('AffiliateNotificationReports')){
				 require_once AF_PATH . 'classes/AffiliateNotificationReports.class.php';
			 }
			 $object = new AffiliateNotificationReports();
			 $data['notification_constants'] = $object->notification_constants();

			 $this->print_top_messages();
			 require_once $this->admin_view_path . 'referral-notifications.php';
		}


		/**
		 * @param none
		 * @return none
		 */
		private function print_admin_referral_notifications(){
			 global $af_db;
			 if (!empty($_POST['save'])){
			     $af_db->save_settings_wp_option('admin_referral_notifications', af_sanitize_textarea_array($_POST) );
			 }
			 $data['metas'] = $af_db->return_settings_from_wp_option('admin_referral_notifications');

			 if (!class_exists('AffiliateNotificationReports')){
				 require_once AF_PATH . 'classes/AffiliateNotificationReports.class.php';
			 }
			 $object = new AffiliateNotificationReports();
			 $data['notification_constants'] = $object->notification_constants();

			 $this->print_top_messages();
			 require_once $this->admin_view_path . 'admin_referral_notifications.php';
		}

		private function print_periodically_reports(){
			/*
			 * @param none
			 * @return string
			 */
			 global $af_db;
			 if (!empty($_POST['save'])){

				/// CRON
			 	$data['metas'] = $af_db->return_settings_from_wp_option('periodically_reports');
			    if ($_POST['af_periodically_reports_cron_hour']!=$data['metas']['af_periodically_reports_cron_hour']){
			    	/// fire the CRON
			    	$base_time = strtotime(date('m/d/Y', time()));
					$input_hour = sanitize_text_field($_POST['af_periodically_reports_cron_hour']);
					$time = $base_time + ($input_hour*3600);
					wp_schedule_event($time, 'daily', 'af_cron_send_reports_to_affiliate');
			    }

				/// SAVE THE OPTIONS
			    $af_db->save_settings_wp_option('periodically_reports', af_sanitize_textarea_array($_POST) );
			 }

			 $schedule = wp_next_scheduled('af_cron_send_reports_to_affiliate');

			 $data['metas'] = $af_db->return_settings_from_wp_option('periodically_reports');
			 if (!class_exists('AffiliateNotificationReports')){
				 require_once AF_PATH . 'classes/AffiliateNotificationReports.class.php';
			 }
			 $object = new AffiliateNotificationReports();
			 $data['reports_constants'] = $object->report_constants();

			 $this->print_top_messages();
			 require_once $this->admin_view_path . 'periodically-reports.php';
		}

		private function print_qr_code(){
			/*
			 * @param none
			 * @return string
			 */
			 global $af_db;
			 if (!empty($_POST['save'])){
			     $af_db->save_settings_wp_option('qr_code', af_sanitize_textarea_array($_POST) );
			 }
			 $data['metas'] = $af_db->return_settings_from_wp_option('qr_code');

			 $this->print_top_messages();
			 require_once $this->admin_view_path . 'qr_code.php';
		}

		private function print_email_verification(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('email_verification', af_sanitize_textarea_array($_POST) );
			}
			$data['metas'] = $af_db->return_settings_from_wp_option('email_verification');
			$data['payment_types'] = $af_db->get_payment_types_available();
			$data['pages'] = $af_db->af_get_all_pages();
			require_once $this->admin_view_path . 'email-verification.php';
		}

		private function print_custom_currencies(){
			/*
			 * @param none
			 * @return none
			 */
			if (!empty($_POST['new_currency_code']) && !empty($_POST['new_currency_name'])){
				$db_data = get_option('af_currencies_list');
				if (empty($db_data[sanitize_text_field($_POST['new_currency_code'])])){
					$db_data[$_POST['new_currency_code']] = sanitize_text_field($_POST['new_currency_name']);
				}
				update_option('af_currencies_list', $db_data);
			}
			$currencies = af_get_currencies_list('custom');
			require_once $this->admin_view_path . 'settings-custom_currencies.php';
		}

		public function add_custom_bttns(){
			/*
			 * @param none
			 * @return none
			 */
			if (defined('DOING_AJAX') && DOING_AJAX) {
				return;
			}
			if (is_user_logged_in()){
				if (!current_user_can('edit_posts') || !current_user_can('edit_pages')){
					 return;
				}
				//if (get_user_option('rich_editing') == 'true') {
					add_filter('mce_buttons', array($this, 'af_register_button'));
					add_filter("mce_external_plugins", array($this, "af_js_bttns_return"));
				//}
			}
		}

		public function af_register_button($arr=array()){
			/*
			 * @param array
			 * @return array
			 */
			array_push($arr, 'af_button_forms');
			return $arr;
		}

		public function af_js_bttns_return($arr=array()){
			/*
			 * @param array
			 * @return array
			 */
			$arr['af_button_forms'] =  AF_URL . 'assets/js/admin-bttns.js';
			return $arr;
		}

		public function add_style_scripts(){
			/*
			 * @param none
			 * @return none
			 */
			global $pagenow, $wp_version;
			$is_plugin_page = FALSE;
			if (!empty($_GET['page']) && sanitize_text_field($_GET['page'])=='openaffiliates'){
				$is_plugin_page = TRUE;
			}
			wp_enqueue_style('af_font_awesome', AF_URL . 'assets/css/font-awesome.css', array(), '9.3' );
			wp_enqueue_style('af_main_admin_style', AF_URL . 'assets/css/main_admin.css', array(), '9.3-' . AF_PLUGIN_VER . '-' . (int)@filemtime( AF_PATH . 'assets/css/main_admin.css' ) );
			if ($is_plugin_page){
				wp_enqueue_style('af_bootstrap_style', AF_URL . 'assets/css/bootstrap.css', array(), '9.3' );
				wp_enqueue_style('af_bootstrap_theme_style', AF_URL . 'assets/css/bootstrap-theme.css', array(), '9.3' );
				wp_enqueue_style('af_main_public_style', AF_URL . 'assets/css/main_public.min.css', array(), '9.3' );
				wp_enqueue_style('af_templates', AF_URL . 'assets/css/templates.min.css', array(), '9.3' );
			}
			if ( !isset( $_GET['page'] ) || ( sanitize_text_field($_GET['page'])!='et_divi_options' && sanitize_text_field($_GET['page'])!='wpcf7' ) ){
					wp_enqueue_style('af_jquery-ui.min.css', AF_URL . 'assets/css/jquery-ui.min.css', array(), '9.3' );
			}

			wp_enqueue_script('jquery');
			wp_enqueue_media();
			//wp_register_script('af_admin_js', AF_URL . 'assets/js/admin-functions.min.js', ['jquery'], '9.3' );
			wp_register_script('af_admin_js', AF_URL . 'assets/js/admin-functions.js', ['jquery'], '9.3-' . AF_PLUGIN_VER . '-' . (int)@filemtime( AF_PATH . 'assets/js/admin-functions.js' ) );

			if ( version_compare ( $wp_version , '5.7', '>=' ) ){
					wp_add_inline_script( 'af_admin_js', "var af_url='" . get_site_url() . "';" );
					wp_add_inline_script( 'af_admin_js', "var af_gif_loading='" . AF_URL . 'assets/images/loading.gif' . "';" );
					wp_add_inline_script( 'af_admin_js', "var afPluginUrl='" . AF_URL . "';" );
					wp_add_inline_script( 'af_admin_js', 'var afI18n=' . wp_json_encode( array(
						'connected' => __( 'Connected', 'openaffiliates' ),
						'adminCannotBecomeAffiliate' => __( 'Admin cannot become Affiliate!', 'openaffiliates' ),
						'resetWorking' => __( 'Working...', 'openaffiliates' ),
						'resetError' => __( 'Something went wrong. Try again!', 'openaffiliates' ),
					) ) . ';' );
					wp_add_inline_script( 'af_admin_js', "var afAdminAjaxNonce='" . wp_create_nonce( 'afAdminAjaxNonce' ) . "';" );
			} else {
					wp_localize_script( 'af_admin_js', 'af_url', get_site_url() );
					wp_localize_script( 'af_admin_js', 'af_gif_loading', AF_URL . 'assets/images/loading.gif' );
					wp_localize_script( 'af_admin_js', 'afPluginUrl', AF_URL );
					wp_localize_script( 'af_admin_js', 'afAdminAjaxNonce', wp_create_nonce( 'afAdminAjaxNonce' ) );
			}
			if ( $pagenow == 'plugins.php' ){
					if ( version_compare ( $wp_version , '5.7', '>=' ) ){
							wp_add_inline_script( 'af_admin_js', "var afKeepData=" . get_option('af_keep_data_after_delete') . ";" );
					} else {
							wp_localize_script( 'af_admin_js', 'afKeepData', get_option('af_keep_data_after_delete') );
					}
					wp_enqueue_script( 'af_sweetalert_js', AF_URL . 'assets/js/sweetalert.js', ['jquery'], '9.3' );
					wp_enqueue_style( 'af_sweetalert_css', AF_URL . 'assets/css/sweetalert.css', array(), '9.3' );
			}
			wp_enqueue_script('af_admin_js');

			if ($is_plugin_page){
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-datepicker');
				wp_enqueue_script('jquery-ui-autocomplete');
				wp_enqueue_script('af-jquery.flot.js', AF_URL . 'assets/js/jquery.flot.js', array( 'jquery' ), '9.3' );
				wp_enqueue_script('af-bootstrap.js', AF_URL . 'assets/js/bootstrap.js', array('jquery'), '9.3' );
				wp_enqueue_script('af-jquery.flot.pie.js', AF_URL . 'assets/js/jquery.flot.pie.js', array('jquery'), '9.3' );
				wp_enqueue_script('af-jquery_form_module', AF_URL . 'assets/js/jquery.form.js', array('jquery'), '9.3' );
				wp_enqueue_script('af-jquery.uploadfile', AF_URL . 'assets/js/jquery.uploadfile.min.js', array('jquery'), '9.3' );
				wp_enqueue_script('af-jquery.flot.time.js', AF_URL . 'assets/js/jquery.flot.time.js', array('jquery'), '9.3' );
				wp_register_script('af_public', AF_URL . 'assets/js/public-functions.min.js', ['jquery'], '9.3' );

				if ( version_compare ( $wp_version , '5.7', '>=' ) ){
						wp_add_inline_script( 'af_public', "var ajax_url='" . admin_url('admin-ajax.php') . "';" );
						wp_add_inline_script( 'af_public', "var afMigrationCompleteMessage='" . esc_html__('Process completed!', 'openaffiliates') . "';" );
				} else {
						wp_localize_script( 'af_public', 'ajax_url', admin_url('admin-ajax.php') );
						wp_localize_script( 'af_public', 'afMigrationCompleteMessage', esc_html__('Process completed!', 'openaffiliates') );
				}
				wp_enqueue_script('af_public');
				wp_enqueue_style('af_select2_style', AF_URL . 'assets/css/select2.min.css', array(), '9.3' );
				wp_enqueue_script( 'af-select2', AF_URL . 'assets/js/select2.min.js', array(), '9.3' );

				wp_enqueue_script( 'af_sweetalert_js', AF_URL . 'assets/js/sweetalert.js', ['jquery'], '9.3' );
				wp_enqueue_style( 'af_sweetalert_css', AF_URL . 'assets/css/sweetalert.css', array(), '9.3' );

				if (!empty($_GET['tab']) && sanitize_text_field($_GET['tab'])=='import_export'){
						wp_enqueue_style( 'afmultiselect', AF_URL . 'assets/css/jquery.multiselect.css', array(), '9.3' );
		        wp_enqueue_script( 'afmultiselectfunctions', AF_URL . 'assets/js/jquery.multiselect.js', ['jquery'], '9.3' );
						wp_enqueue_style( 'afdatatable', AF_URL . 'assets/css/datatable.css', array(), '9.3' );
						//wp_enqueue_script( 'af_csv_export', AF_URL . 'assets/js/csv_export.js', ['jquery'] );
						wp_enqueue_script( 'af_import_export', AF_URL . 'assets/js/AfImportExport.js', ['jquery'], '9.3' );
				}
			}

		}


		public function referral_action(){
			/*
			 * @param none
			 * @return none
			 */
			/// main referral
			require_once AF_PATH . 'public/Referral_Main.class.php';
			$object = new Referral_Main();

			/************** services ****************/
			/// WOO
			require_once AF_PATH . 'public/services/Af_Woo.class.php';
			$woo = new Af_Woo();

			/// UMP
			require_once AF_PATH . 'public/services/Af_UMP.class.php';
			$ump = new Af_UMP();

			/// EDD
			require_once AF_PATH . 'public/services/Af_Easy_Digital_Download.class.php';
			$edd = new Af_Easy_Digital_Download();

			/// ULP
			require_once AF_PATH . 'public/services/Af_Ulp.php';
			$ulp = new Af_Ulp();
		}


		public function dashboard_print_af_column($states, $post){
			/*
			 * @param string, object
			 * @return none, print a string if it's case
			 */
			if (isset($post->ID) ){
				$str = '';
				//////////// DEFAULT PAGES
				if (get_post_type($post->ID)=='page'){
					global $af_db;
					$pages = $af_db->return_settings_from_wp_option('general-default_pages');

					switch ($post->ID){
						case $pages['af_general_login_default_page']:
							$print = esc_html__('Affiliates - Login Page', 'openaffiliates');
							break;
						case $pages['af_general_register_default_page']:
							$print = esc_html__('Affiliates - Registration Page', 'openaffiliates');
							break;
						case $pages['af_general_lost_pass_page']:
							$print = esc_html__('Affiliates - Lost Password', 'openaffiliates');
							break;
						case $pages['af_general_logout_page']:
							$print = esc_html__('Affiliates - LogOut Page', 'openaffiliates');
							break;
						case $pages['af_general_user_page']:
							$print = esc_html__('Affiliates - User Page', 'openaffiliates');
							break;
						case $pages['af_general_tos_page']:
							$print = esc_html__('Affiliates - TOS', 'openaffiliates');
							break;
					}
					if (!empty($print)){
						$str .= '<div class="af-dashboard-list-posts-col-default-pages">' . $print . '</div>';
					}
				}
				if (!empty($str)){
					$states[] = $str;
				}
			}
			return $states;
		}

		public function create_page_meta_box(){
			/*
			 * @param
			 * @return
			 */
			global $post, $af_db;
			add_meta_box(
						'af_default_pages',//id
						__('Affiliates Pro - Default Pages', 'openaffiliates'),
						array($this, 'print_page_meta_box'),
						'page',
						'side',
						'high'
			);

			$postTypes = $af_db->get_all_post_types();
			foreach ($postTypes as $postType){
					add_meta_box(
								'af_affiliate_landing_page',//id
								__('Affiliates Pro - Affiliate Landing Pages', 'openaffiliates'),
								array($this, 'print_affiliate_landing_page_meta_box'),
								$postType,
								'side',
								'high'
					);
			}

			// woo
			add_meta_box(
						'af_woo_referral_details',//id
						__('Affiliates Pro - Referral Details', 'openaffiliates'),
						array($this, 'wooMetaBoxReferralDetails'),
						'shop_order',
						'side',
						'high'
			);

			// woo new
			add_meta_box(
						'af_woo_referral_details',//id
						__('Affiliates Pro - Referral Details', 'openaffiliates'),
						array($this, 'wooNewMetaBoxReferralDetails'),
						'woocommerce_page_wc-orders',
						'side',
						'high'
			);

		}

		public function wooMetaBoxReferralDetails()
		{
				global $post, $af_db;
				$postId = isset( $post->ID ) ? $post->ID : 0;
				$view = new \OpenAffiliates\AfView();
				$referralDetails = $af_db->getReferralsForReferrence( $postId );
				$output = $view->setTemplate( AF_PATH . 'admin/views/af-woo-orders-metabox.php' )
									->setContentData( [ 'referrals' => $referralDetails ] )
									->getOutput();
				echo esc_af_content( $output );
		}

		public function wooNewMetaBoxReferralDetails( $post )
		{
			global $af_db;
			$postId = 0;
			if ( $post instanceof WC_Order ) {
				$postId= $post->get_id();
			} else {
				$postId = $post->ID;
			}
			$view = new \OpenAffiliates\AfView();
			$referralDetails = $af_db->getReferralsForReferrence( $postId );
			$output = $view->setTemplate( AF_PATH . 'admin/views/af-woo-orders-metabox.php' )
								->setContentData( [ 'referrals' => $referralDetails ] )
								->getOutput();
			echo esc_af_content( $output );
		}

		public function print_affiliate_landing_page_meta_box()
		{
				global $post, $af_db;
				$data['af_landing_page_affiliate_id'] = get_post_meta($post->ID, 'af_landing_page_affiliate_id', true);
				$data['affiliate_uid'] = $af_db->get_uid_by_affiliate_id($data['af_landing_page_affiliate_id']);
				$data['affiliate_usename'] = $af_db->get_username_by_wpuid($data['affiliate_uid']);
				require_once $this->admin_view_path . 'landing-pages_meta_box.php';
		}

		public function print_page_meta_box(){
			/*
			 * @param none
			 * @return string
			 */
			global $post;
			global $af_db;
			$data['types'] = array(
							'af_general_login_default_page' => esc_html__('Affiliate Login', 'openaffiliates'),
							'af_general_register_default_page' => esc_html__('Affiliate Registration', 'openaffiliates'),
							'af_general_lost_pass_page' =>  esc_html__('Lost Password', 'openaffiliates'),
							'af_general_logout_page' =>  esc_html__('LogOut', 'openaffiliates'),
							'af_general_user_page' =>  esc_html__('Affiliate Portal', 'openaffiliates'),
							'af_general_tos_page' => esc_html__('TOS', 'openaffiliates'),
			);
			$data['current_page_type'] = $af_db->get_current_page_type($post->ID);
			$data['unset_pages'] = $af_db->get_default_unset_pages();
			require_once $this->admin_view_path . 'page-meta_box.php';
		}

		public function save_meta_box_values($post_id=0){
			/*
			 * @param int
			 * @return none
			 */
			if (!empty($_POST['af_set_page_as_default_something'])){
				global $af_db;
				$af_db->set_default_page($_POST['af_set_page_as_default_something'], sanitize_text_field($_POST['af_post_id']) );
			}
			if (isset($_POST['af_landing_page_affiliate_id'])){
					update_post_meta($post_id, 'af_landing_page_affiliate_id', sanitize_text_field($_POST['af_landing_page_affiliate_id']) );
			}
		}

		public function print_about(){
			/*
			 * @param none
			 * @return string
			 */
			require_once $this->admin_view_path . 'about.php';
		}

		public function print_shortcodes(){
			/*
			 * @param none
			 * @return string
			 */
			 require_once $this->admin_view_path . 'shortcodes.php';
		}

		public function edit_wp_user($user_object){
			/*
			 * @param object
			 * @return string
			 */
			if (current_user_can('edit_user') && current_user_can('manage_options') && $user_object && !empty($user_object->data) && !empty($user_object->data->user_login)){
				global $af_db;
				$data['is_affiliate'] = $af_db->get_affiliate_id_by_username($user_object->data->user_login);
				$data['id'] = $user_object->data->ID;
				ob_start();
				require $this->admin_view_path . 'edit-wp-user.php';
				$output = ob_get_contents();
				ob_end_clean();
				echo esc_af_content($output);
			}
		}

		public function af_delete_affiliate_by_uid($id=0){
			/*
			 * FIRE WHEN A USER IT's DELETED FROM WP
			 * @param int
			 * @return none
			 */
			 if ($id){
				global $af_db;
				$affiliate_id = $af_db->get_affiliate_id_by_wpuid($id);
				if ($affiliate_id){
					$af_db->delete_affiliate_details($affiliate_id);
				}
			}
		}

		private function print_flag_for_affiliate($user_id=0){
			/*
			 * @param int
			 * @return string
			 */
			 if ($user_id){
			 	 $flag_src = get_user_meta($user_id, 'af_country', TRUE);
				 if ($flag_src){
				 	$countries = af_get_countries();
					$country = $countries[strtoupper($flag_src)];
					$title = (empty($country)) ? '' : $country;
 				 	return '<span class="af-affiliate-flag-wrapp"><img src="' . AF_URL . 'assets/flags/' . $flag_src . '.svg" title="' . $title . '" class="af-affiliate-admin-flag" /></span>';
				 }
			 }
			 return '';
		}

		private function print_source_details(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['save'])){
				$af_db->save_settings_wp_option('source_details', af_sanitize_array($_POST) );
			}
			$data['fields_available'] = array(
												'user_login' => 'Username',
												'first_name' => esc_html__('First Name', 'openaffiliates'),
												'last_name' => esc_html__('Last Name', 'openaffiliates'),
												'phone' => esc_html__('Phone', 'openaffiliates'),
												'email' => esc_html__('E-mail', 'openaffiliates'),
												'order_date' => esc_html__('Order Date', 'openaffiliates'),
												'order_amount' => esc_html__('Order Amount', 'openaffiliates'),
												'shipping_address' => esc_html__('Shipping Address', 'openaffiliates'),
												'billing_address' => esc_html__('Billing Address', 'openaffiliates'),
												'cart_items' => esc_html__('Cart Items', 'openaffiliates'),
			);
			$data['metas'] = $af_db->return_settings_from_wp_option('source_details');
			require_once $this->admin_view_path . 'source-details.php';
		}

		public function hooksAndFilters( $tab='' )
		{
				if ( !$tab ){
						return;
				}
				if ( $tab != 'hooks' ){
						return;
				}
				$object = new \OpenAffiliates\SearchFiltersAndHooks();
				$object->setPluginName( 'open-affiliates-for-woocommerce' )->setNameShouldContain( [ 'af' ] )->SearchFiles( AF_PATH );
				$data = $object->getResults();
				$view = new \OpenAffiliates\AfView();
				$output = $view->setTemplate( AF_PATH . 'admin/views/hooks.php' )
									->setContentData( $data )
									->getOutput();
				echo esc_af_content( $output );
		}

		public function wooCouponsSettings()
		{
				global $post, $af_db;
				$data = [
									'product_id' => isset( $post->ID ) ? $post->ID : 0,
									'types'			 => [
																		'flat' 					=> esc_html__( 'Flat ', 'openaffiliates') . '(' . afCurrency() .')',
																		'percentage'		=> esc_html__( 'Percentage ', 'openaffiliates') . '(%)',
									],
									'af_affiliate_username'		=> '',
									'af_amount_type'						=> '',
									'af_amount_value'					=> '',
									'id'												=> 0,
				];
				$code = isset( $post->post_title ) ? $post->post_title : '';
				$couponData = $af_db->get_coupon_data( $code );
				if ( $couponData && isset( $couponData['affiliate_id'] ) ){
						$data['af_affiliate_username'] = $af_db->get_wp_username_by_affiliate_id( $couponData['affiliate_id'] );
						$data['af_amount_type'] = isset( $couponData['amount_type'] ) ? $couponData['amount_type'] : '';
						$data['af_amount_value'] = isset( $couponData['amount_value'] ) ? $couponData['amount_value'] : '';
						$data['id'] = isset( $couponData['id'] ) ? $couponData['id'] : 0;
						$data['af_status'] = isset( $couponData['status'] ) ? $couponData['status'] : 0;
				}
				$view = new \OpenAffiliates\AfView();
				$output = $view->setTemplate( AF_PATH . 'admin/views/woo-coupons-settings.php' )
									->setContentData( $data )
									->getOutput();
				echo esc_af_content( $output );
		}

		public function wooSaveCoupons()
		{
				global $af_db;
				if ( empty( $_POST['af_affiliate_username'] ) ){
						return;
				}
				if ( empty( $_POST['post_title'] ) ){
						return;
				}
				$affiliateId = $af_db->get_affiliate_id_by_username( sanitize_text_field( $_POST['af_affiliate_username'] ) );
				$data = [
									'amount_type' 		=> isset( $_POST['af_amount_type'] ) ? sanitize_text_field($_POST['af_amount_type']) : '',
									'amount_value' 		=> isset( $_POST['af_amount_value'] ) ? sanitize_text_field($_POST['af_amount_value']) : '',
									'affiliate_id'		=> $affiliateId,
									'type'						=> 'woo',
									'code'						=> af_sanitize_textarea_array( $_POST['post_title'] ),
									'id'							=> isset( $_POST['af_static_coupon_id'] ) ? sanitize_text_field($_POST['af_static_coupon_id']) : false,
									'status'					=> isset( $_POST['af_status'] ) ? sanitize_text_field($_POST['af_status']) : false,
				];
				$af_db->save_coupon_affiliate_pair( $data );
		}

		/**
		 * Plugin row meta links
		 *
		 * @param array $input already defined meta links
		 * @param string $file plugin file path and name being processed
		 * @return array $input
		 */
		public function af_plugin_row_meta( $input, $file ) {

			$afMainFile = str_replace( WP_PLUGIN_DIR . '/', '', AF_PATH );
			$afMainFile .= AF_MAIN_FILE_NAME;
			if ( $file != $afMainFile ) {
				return $input;
			}

			$links = [
				'<a href="' . esc_url( AF_DOCS_URL ) . '" target="_blank">' . esc_html__( 'Documentation', 'openaffiliates' ) . '</a>',
				'<a href="' . esc_url( AF_REPO_URL . '/blob/main/CHANGELOG.md' ) . '" target="_blank">' . esc_html__( 'ChangeLog', 'openaffiliates' ) . '</a>'
			];

			$input = array_merge( $input, $links );

			return $input;

		}

		public function af_manage_ump() {
			global $submenu;
			$capability = 'manage_options';
			//$capability = apply_filters( 'af_filter_admin_capability_for_dashboard_menu', $capability );

			$submenu['openaffiliates'][300] = [ esc_html__( 'Dashboard', 'openaffiliates' ),	$capability, 'admin.php?page=openaffiliates&tab=dashboard', esc_html__( 'Dashboard', 'openaffiliates' ), 'af-admin-menu-dashboard-item', 'af-admin-menu-dashboard-item', '' ];
			$submenu['openaffiliates'][301] = [ esc_html__( 'Affiliates', 'openaffiliates' ),	$capability, 'admin.php?page=openaffiliates&tab=affiliates', esc_html__( 'Affiliates', 'openaffiliates' ), '', '', '' ];
			$submenu['openaffiliates'][302] = [ esc_html__( 'Ranks', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=ranks', esc_html__( 'Ranks', 'openaffiliates' ), '' , ''];
			$submenu['openaffiliates'][303] = [ esc_html__( 'Product Rates', 'openaffiliates' ), $capability , 'admin.php?page=openaffiliates&tab=offers', esc_html__( 'Product Rates', 'openaffiliates' ), '', '' ];
			$submenu['openaffiliates'][304] = [ esc_html__( 'Creatives', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=banners', esc_html__( 'Creatives', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][305] = [ esc_html__( 'Showcases', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=showcases', esc_html__( 'Showcases', 'openaffiliates' ), '' , '' ];
				$submenu['openaffiliates'][321] = [ esc_html__( 'Registration Form', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=register', esc_html__( 'Registration Form', 'openaffiliates' ), '' , '' ];
				$submenu['openaffiliates'][322] = [ esc_html__( 'Login Form', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=login', esc_html__( 'Login Form', 'openaffiliates' ), '' , '' ];
				$submenu['openaffiliates'][323] = [ esc_html__( 'Affiliate Portal', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=account_page', esc_html__( 'Affiliate Portal', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][306] = [ esc_html__( 'Clicks', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=visits', esc_html__( 'Clicks', 'openaffiliates' ), '' , '','' ];
			$submenu['openaffiliates'][307] = [ esc_html__( 'Referrals', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=referrals', esc_html__( 'Referrals', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][308] = [ esc_html__( 'Payouts', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=payments', esc_html__( 'Payment History', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][324] = [ esc_html__( 'Pay Affiliates', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=payments&subtab=new_payout', esc_html__( 'Pay Affiliates', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][325] = [ esc_html__( 'Mass Payouts', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=payments&subtab=manage_payouts', esc_html__( 'Mass Payouts', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][309] = [ esc_html__( 'Email Notifications', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=notifications', esc_html__( 'Email Notifications', 'openaffiliates' ), '' , ''];
			$submenu['openaffiliates'][310] = [ esc_html__( 'Extensions', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=magic_features', esc_html__( 'Extensions', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][311] = [ esc_html__( 'Reports', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=reports', esc_html__( 'Reports', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][312] = [ esc_html__( 'General Settings', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=settings', esc_html__( 'General Settings', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][314] = [ esc_html__( 'Shortcodes', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=shortcodes', esc_html__( 'Shortcodes', 'openaffiliates' ), '' , '' ];
			$submenu['openaffiliates'][317] = [ esc_html__( 'About & Support', 'openaffiliates' ), $capability, 'admin.php?page=openaffiliates&tab=about', esc_html__( 'About & Support', 'openaffiliates' ), '' , '' ];

			if ( isset( $_GET['page'] ) && sanitize_text_field( $_GET['page'] ) === 'openaffiliates' && isset( $_GET['tab'] ) ){
					switch ( sanitize_text_field( $_GET['tab'] ) ){
							case 'affiliates':
								$submenu['openaffiliates'][301][4] = 'current';
								break;
							case 'ranks':
								$submenu['openaffiliates'][302][4] = 'current';
								break;
							case 'offers':
								$submenu['openaffiliates'][303][4] = 'current';
								break;
							case 'banners':
								$submenu['openaffiliates'][304][4] = 'current';
								break;
							case 'showcases':
								$submenu['openaffiliates'][305][4] = 'current';
								break;
							case 'visits':
								$submenu['openaffiliates'][306][4] = 'current';
								break;
							case 'referrals':
								$submenu['openaffiliates'][307][4] = 'current';
								break;
							case 'payments':
								$submenu['openaffiliates'][308][4] = 'current';
								break;
							case 'notifications':
								$submenu['openaffiliates'][309][4] = 'current';
								break;
							case 'magic_features':
								$submenu['openaffiliates'][310][4] = 'current';
								break;
							case 'reports':
								$submenu['openaffiliates'][311][4] = 'current';
								break;
							case 'settings':
								$submenu['openaffiliates'][312][4] = 'current';
								break;
							case 'shortcodes':
								$submenu['openaffiliates'][314][4] = 'current';
								break;
							case 'about':
								$submenu['openaffiliates'][317][4] = 'current';
								break;
					}
			}

		}

		public function af_manage_ump_add_jquery() {
			?>
		    <script type="text/javascript">
		        jQuery( function() {
		            jQuery('.af-ihc-link-wrapp').attr('target','_blank');
		        });
		    </script>
		    <?php
		}



	}
}
