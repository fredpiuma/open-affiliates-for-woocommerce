<?php
class AfAjax{

	/**
	 * REGISTER ALL AJAX CALLS HERE
	 * @param none
	 * @return none
	 */
	public function __construct()
	{
		/// PUBLIC
		add_action('wp_ajax_af_ia_ajax_return_url_for_aff',array($this, 'ia_ajax_return_url_for_aff'));
		add_action('wp_ajax_nopriv_af_ia_ajax_return_url_for_aff', array($this, 'ia_ajax_return_url_for_aff'));

		add_action('wp_ajax_af_check_reg_field_ajax',array($this, 'af_check_reg_field_ajax'));
		add_action('wp_ajax_nopriv_af_check_reg_field_ajax', array($this, 'af_check_reg_field_ajax'));

		add_action('wp_ajax_af_check_logic_condition_value',array($this, 'af_check_logic_condition_value'));
		add_action('wp_ajax_nopriv_af_check_logic_condition_value', array($this, 'af_check_logic_condition_value'));

		add_action('wp_ajax_af_make_wp_user_affiliate_from_public',array($this, 'af_make_wp_user_affiliate_from_public'));
		add_action('wp_ajax_nopriv_af_make_wp_user_affiliate_from_public', array($this, 'af_make_wp_user_affiliate_from_public'));

		add_action('wp_ajax_af_get_amount_for_referral_list', array($this, 'af_get_amount_for_referral_list'));
		add_action('wp_ajax_nopriv_af_get_amount_for_referral_list', array($this, 'af_get_amount_for_referral_list'));

		add_action('wp_ajax_af_delete_wallet_item_via_ajax', array($this, 'af_delete_wallet_item_via_ajax'));
		add_action('wp_ajax_nopriv_af_delete_wallet_item_via_ajax', array($this, 'af_delete_wallet_item_via_ajax'));

		add_action('wp_ajax_nopriv_af_delete_attachment_ajax_action', array($this, 'af_delete_attachment_ajax_action'));
		add_action('wp_ajax_af_delete_attachment_ajax_action', array($this, 'af_delete_attachment_ajax_action'));

		add_action('wp_ajax_nopriv_af_check_if_username_is_affiliate', array($this, 'af_check_if_username_is_affiliate'));
		add_action('wp_ajax_af_check_if_username_is_affiliate', array($this, 'af_check_if_username_is_affiliate'));

		add_action('wp_ajax_nopriv_af_ap_reset_custom_banner', array($this, 'af_ap_reset_custom_banner'));
		add_action('wp_ajax_af_ap_reset_custom_banner', array($this, 'af_ap_reset_custom_banner'));

		add_action( 'wp_ajax_nopriv_af_ajax_get_banner_for_permalink', [$this, 'af_ajax_get_banner_for_permalink'] );
		add_action( 'wp_ajax_af_ajax_get_banner_for_permalink', [$this, 'af_ajax_get_banner_for_permalink'] );

		add_action( 'wp_ajax_nopriv_af_search_product_for_product_links', [$this, 'af_search_product_for_product_links'] );
		add_action( 'wp_ajax_af_search_product_for_product_links', [$this, 'af_search_product_for_product_links'] );

		add_action( 'wp_ajax_nopriv_af_product_link_popup', [$this, 'af_product_link_popup'] );
		add_action( 'wp_ajax_af_product_link_popup', [$this, 'af_product_link_popup'] );

		/// ADMIN
		add_action( 'wp_ajax_af_register_preview_ajax', array($this, 'af_register_preview_ajax'));
		add_action( 'wp_ajax_af_login_form_preview', array($this, 'af_login_form_preview'));
		add_action( 'wp_ajax_af_serialize_json', array($this, 'af_serialize_json'));
		add_action( 'wp_ajax_af_make_ranks_reorder', array($this, 'af_make_ranks_reorder'));
		add_action( 'wp_ajax_af_update_aweber', array($this, 'af_update_aweber') );
		add_action( 'wp_ajax_af_get_cc_list', array($this, 'af_get_cc_list') );
		add_action( 'wp_ajax_af_get_notification_default_by_type', array($this, 'af_get_notification_default_by_type'));
		add_action( 'wp_ajax_af_ajax_admin_popup_the_shortcodes', array($this, 'af_ajax_admin_popup_the_shortcodes'));
		add_action('wp_ajax_af_approve_affiliate', array($this, 'af_approve_affiliate'));
		add_action('wp_ajax_af_make_wp_user_affiliate', array($this, 'af_make_wp_user_affiliate'));
		add_action('wp_ajax_af_delete_currency_code_ajax', array($this, 'af_delete_currency_code_ajax'));
		add_action('wp_ajax_af_remove_slug_from_aff', array($this, 'af_remove_slug_from_aff'));
		add_action('wp_ajax_af_preview_user_listing', array($this, 'af_preview_user_listing'));
		add_action('wp_ajax_af_affiliate_simple_user', array($this, 'af_affiliate_simple_user'));
		add_action('wp_ajax_af_approve_user_email', array($this, 'af_approve_user_email'));
		add_action('wp_ajax_af_check_mail_server', array($this, 'af_check_mail_server'));
		add_action('wp_ajax_af_do_generate_payments_csv', array($this, 'af_do_generate_payments_csv'));
		add_action('wp_ajax_af_get_font_awesome_popup', array($this, 'do_get_font_awesome_popup'));
		add_action('wp_ajax_af_make_export_file', array($this, 'make_export_file'));
		add_action('wp_ajax_af_trigger_migration', array($this, 'af_trigger_migration'));
		add_action('wp_ajax_af_get_empty_progress_bar', array($this, 'af_get_empty_progress_bar'));
		add_action('wp_ajax_af_migrate_get_status', array($this, 'af_migrate_get_status'));
		add_action('wp_ajax_af_migrate_reset_log', array($this, 'af_migrate_reset_log'));
		add_action('wp_ajax_af_admin_send_email_popup', array($this, 'af_admin_send_email_popup'));
		add_action('wp_ajax_af_admin_do_send_email', array($this, 'af_admin_do_send_email'));

		add_action( 'wp_ajax_af_info_affiliate_bar_do_hide', [ $this, 'af_info_affiliate_bar_do_hide' ] );

		add_action( 'wp_ajax_nopriv_af_remove_media_post', [$this, 'af_remove_media_post'] );
		add_action( 'wp_ajax_af_remove_media_post', [$this, 'af_remove_media_post'] );

		add_action( 'wp_ajax_nopriv_af_ajax_make_csv', [$this, 'af_ajax_make_csv'] );
		add_action( 'wp_ajax_af_ajax_make_csv', [$this, 'af_ajax_make_csv'] );

		add_action( 'wp_ajax_af_ajax_make_csv_params_as_json', [ $this, 'af_ajax_make_csv_params_as_json' ] );

		add_action( 'wp_ajax_af_admin_delete_ranks', [$this, 'deleteRanks'] );

		add_action( 'wp_ajax_af_delete_referrer_link_for_affiliate', [$this, 'afDeleteReferrerLinkForAffiliate'] );

		add_action( 'wp_ajax_af_delete_landing_page_for_affiliate', [$this, 'afDeleteLandingPageForAffiliate'] );

		add_action( 'wp_ajax_af_delete_coupons_for_affiliate', [$this, 'afDeleteCouponsForAffiliate'] );

		add_action( 'wp_ajax_nopriv_af_ajax_save_campaign', [$this, 'saveCampaign'] );
		add_action( 'wp_ajax_af_ajax_save_campaign', [$this, 'saveCampaign'] );

		add_action( 'wp_ajax_nopriv_af_ajax_save_simple_link', [$this, 'saveSimpleLinks'] );
		add_action( 'wp_ajax_af_ajax_save_simple_link', [$this, 'saveSimpleLink'] );

		add_action( 'wp_ajax_af_ajax_notification_send_test_email', [$this, 'notificationSendTestEmail'] );
		add_action( 'wp_ajax_af_ajax_do_send_notification_test', [ $this, 'af_ajax_do_send_notification_test' ] );

		add_action( 'wp_ajax_af_ajax_do_remove_affiliate_link', [ $this, 'af_ajax_do_remove_affiliate_link' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_do_remove_affiliate_link', [ $this, 'af_ajax_do_remove_affiliate_link' ] );

		add_action( 'wp_ajax_af_ajax_load_list_affiliate_links_table', [ $this, 'af_ajax_load_list_affiliate_links_table' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_load_list_affiliate_links_table', [ $this, 'af_ajax_load_list_affiliate_links_table' ] );


		// ajax-upload.php
		add_action( 'wp_ajax_af_ajax_public_upload', [ $this, 'af_ajax_public_upload' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_public_upload', [ $this, 'af_ajax_public_upload' ] );

		// offers
		add_action( 'wp_ajax_af_ajax_offers_autocomplete', [ $this, 'af_ajax_offers_autocomplete' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_offers_autocomplete', [ $this, 'af_ajax_offers_autocomplete' ] );

		// coupons
		add_action( 'wp_ajax_af_ajax_coupons_autocomplete', [ $this, 'af_ajax_coupons_autocomplete' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_coupons_autocomplete', [ $this, 'af_ajax_coupons_autocomplete' ] );

		// stripe connect generate account id
		add_action( 'wp_ajax_af_ajax_stripe_generate_onboarding_url', [ $this, 'af_ajax_stripe_generate_onboarding_url' ] );
		add_action( 'wp_ajax_nopriv_af_ajax_stripe_generate_onboarding_url', [ $this, 'af_ajax_stripe_generate_onboarding_url' ] );

		do_action( 'af_action_ajax_was_loaded', time(), AF_PATH . 'classes/AfAjax.class.php' );

		add_action( 'wp_ajax_af_ajax_clean_notifications_logs', [ $this, 'af_ajax_clean_notifications_logs' ] );



		add_action( 'wp_ajax_af_ajax_update_integrations_status', [ $this, 'af_ajax_update_integrations_status' ] );

		add_action( 'wp_ajax_af_ajax_factory_reset', [ $this, 'af_ajax_factory_reset' ] );
	}

	/**
	 * @param none
	 * @return string
	 */
	public function ia_ajax_return_url_for_aff()
	{
		global $current_user;
		if ( empty( $current_user->ID ) ){
				die;
		}

		if ( !afPublicVerifyNonce() ){
				die;
		}

		if (!empty($_POST['aff_id']) && !empty($_POST['url'])){
			$param = 'ref';
			$aff_id = sanitize_text_field( $_POST['aff_id'] );
			$value = $aff_id;
			$campaign_variable = '';
			$campaign_value = '';

			global $af_db;
			$settings = $af_db->return_settings_from_wp_option('general-settings');
			if (!empty($settings['af_referral_variable'])){
				$param = $settings['af_referral_variable'];
			}

			$uid = $af_db->get_uid_by_affiliate_id($aff_id);
			if ( $uid != $current_user->ID ){
					die;
			}
			if (!empty($_POST['slug'])){
				$slug = $af_db->get_custom_slug_for_uid($uid);
				if ($slug){
					$value = $slug;
				}
			} else if ($uid && $settings['af_default_ref_format']=='username'){
				$user_info = get_userdata($uid);
				if (!empty($user_info->user_login)){

					$value = urlencode($user_info->user_login);
				}
			}

			if ( !empty( $_POST['post_id'] ) ){
					$postId = sanitize_text_field($_POST['post_id']);
					$url = get_permalink( $postId );
			}
			if ( !isset( $url ) ){
					$url = sanitize_text_field($_POST['url']);
			}

			if (!empty($_POST['campaign'])){
				$campaign_variable = get_option('af_campaign_variable');
				$campaign_value = sanitize_text_field($_POST['campaign']);
			}

			$arr['url'] = af_create_affiliate_link($url, $param, $value, $campaign_variable, $campaign_value, af_sanitize_array($_POST['friendly_links']));
			$arr['social'] = '';
			$arr['qr'] = '';

			// save it to db
			\OpenAffiliates\Db\GeneratedAffiliateLinks::save( [
						'aid'								=> af_sanitize_array( $_POST['aff_id'] ),
						'base_url'					=> $url,
						'affiliate_url'			=> $arr['url'],
						'campaign'					=> af_sanitize_array( $_POST['campaign'] ),
			] );

			/// SOCIAL
			if (af_is_social_share_intalled_and_active() && get_option('af_social_share_enable')){
				$shortcode = get_option('af_social_share_shortcode');
				if ($shortcode){
					$shortcode = stripslashes($shortcode);
					$shortcode = str_replace(']', '', $shortcode);
					$shortcode .= " is_affiliates=1"; ///just for safe
					$shortcode .= " custom_description='" . get_option('af_social_share_message') . "'";
					$shortcode .= " af_no_fb_js=1 ";
					$shortcode .= " custom_url='" . $arr['url'] ."']";
					$arr['social'] = do_shortcode($shortcode);
				}
			}
			/// QR CODE
			if ($af_db->is_magic_feat_enable('qr_code')){
				$img = af_generate_qr_code($arr['url'], $_POST['aff_id'] . '_custom_url');
				$arr['qr_code'] = '<div class="af-qr-code-wrapper">
								<img src="' . $img . '" />
								<a href="' . $img . '" download="' . basename($img) . '" class="af-qr-code-download">' . esc_html__('Download', 'openaffiliates') . '</a>
				</div>';
			}
			echo json_encode($arr);
		}
		die();
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_register_preview_ajax()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			global $af_db;
			require_once AF_PATH . 'classes/AffiliateAddEdit.class.php';
			$args = array(
						'user_id' => false,
						'type' => 'create',
						'tos' => true,
						'captcha' => true,
						'action' => '',
						'is_public' => true,
						'register_template' => isset($_REQUEST['template']) ? sanitize_text_field($_REQUEST['template']) : '',
			);
			$type = get_option( 'af_recaptcha_version' );
			if ( $type !== false && $type == 'v3' ){
					$args['captcha'] = false;
			}
			$obj = new AffiliateAddEdit($args);
			$data = $af_db->return_settings_from_wp_option('register');
			$data = $obj->form();
			$data['template'] = isset($_REQUEST['template']) ? sanitize_text_field($_REQUEST['template']) : '';
			ob_start();
			require_once AF_PATH . 'public/views/register.php';
			$output = ob_get_contents();
			ob_end_clean();
			echo esc_af_content($output);
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_login_form_preview()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			$metas['af_login_remember_me'] = af_sanitize_array($_REQUEST['remember']);
			$metas['af_login_register'] = af_sanitize_array($_REQUEST['register_link']);
			$metas['af_login_pass_lost'] = af_sanitize_array($_REQUEST['pass_lost']);
			$metas['af_login_template'] = af_sanitize_array($_REQUEST['template']);
			$metas['af_login_custom_css'] = af_sanitize_textarea_array($_REQUEST['css']);
			$metas['af_login_show_recaptcha'] = af_sanitize_array($_REQUEST['af_login_show_recaptcha']);
			$type = get_option( 'af_recaptcha_version' );
			if ( $type !== false && $type == 'v3' ){
					$metas['af_login_show_recaptcha'] = false;
			}
			require_once AF_PATH . 'public/AffiliateLogin.class.php';
			$object = new AffiliateLogin();
			echo esc_af_content($object->print_login_form($metas, 'unreg'));
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_check_reg_field_ajax()
	{
		global $af_db;
		if ( !afPublicVerifyNonce() ){
			die;
		}
		$register_msg = $af_db->return_settings_from_wp_option('register-msg');
		if (isset($_REQUEST['type']) && isset($_REQUEST['value'])){
			echo af_check_value_field( sanitize_text_field($_REQUEST['type']), sanitize_textarea_field($_REQUEST['value']), sanitize_textarea_field($_REQUEST['second_value']), $register_msg);
		} else if (isset($_REQUEST['fields_obj'])){
			$arr = af_sanitize_textarea_array($_REQUEST['fields_obj']);
			foreach ($arr as $k=>$v){
				$return_arr[] = array( 'type' => $v['type'], 'value' => af_check_value_field($v['type'], $v['value'], $v['second_value'], $register_msg) );
			}
			echo json_encode($return_arr);
		}
		die();
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_check_logic_condition_value()
	{
			if ( !afPublicVerifyNonce() ){
				die;
			}
			if (isset($_REQUEST['val']) && isset($_REQUEST['field'])){
				global $af_db;
				$fields_meta = $af_db->register_get_custom_fields();
				$key = af_array_value_exists($fields_meta, sanitize_textarea_field($_REQUEST['field']), 'name');
				if ($key!==FALSE){
					if (isset($fields_meta[$key]['conditional_logic_corresp_field_value'])){
						if ($fields_meta[$key]['conditional_logic_cond_type']=='has'){
							//has value
							if ($fields_meta[$key]['conditional_logic_corresp_field_value']==sanitize_textarea_field($_REQUEST['val'])){
								echo 1;
								die;
							}
						} else {
							//contain value
							if ( strpos( sanitize_textarea_field($_REQUEST['val']), $fields_meta[$key]['conditional_logic_corresp_field_value'])!==FALSE){
								echo 1;
								die;
							}
						}
					}
				}
			}
			echo 0;
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_make_ranks_reorder()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_REQUEST['new_order']) && isset($_REQUEST['rank_id']) && isset($_REQUEST['current_label'])){
				global $af_db;
				$data = $af_db->get_ranks();
				if ($_REQUEST['rank_id']==0){
					global $wpdb;
					$table = $wpdb->prefix . 'af_ranks';
					$query = "SELECT rank_order FROM $table ORDER BY rank_order DESC LIMIT 1";
					$data_db = $wpdb->get_row( $query );
					$old_order = (empty($data_db->rank_order)) ? 1 : $data_db->rank_order + 1;
					$arr['rank_order'] = $old_order;
					$arr['id'] = 0;
					$arr['label'] = af_sanitize_textarea_array($_REQUEST['current_label']);
					$object = new stdClass();
					foreach ($arr as $key => $value){
						$object->$key = $value;
					}
					$data[] = $object;
				}
				$ranks = af_custom_reorder_rank($data, sanitize_text_field($_REQUEST['rank_id']), sanitize_text_field( $_REQUEST['new_order']) );
				if (!function_exists('af_create_ranks_graphic')){
					require_once AF_PATH . 'admin/utilities.php';
				}
				echo af_create_ranks_graphic($ranks, sanitize_text_field($_REQUEST['rank_id']) );
			}
			die;
	}

	/**
	 * @param none
	 * @return int
	 */
	public function af_update_aweber()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			include_once AF_PATH .'classes/services/email_services/aweber/aweber_api.php';
			list($consumer_key, $consumer_secret, $access_key, $access_secret) = AWeberAPI::getDataFromAweberID( sanitize_text_field($_REQUEST['auth_code']) );
			update_option( 'af_aweber_consumer_key', $consumer_key );
			update_option( 'af_aweber_consumer_secret', $consumer_secret );
			update_option( 'af_aweber_acces_key', $access_key );
			update_option( 'af_aweber_acces_secret', $access_secret );
			echo 1;
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_get_cc_list()
	{
			if ( !afIsAdmin() ){
				  die;
			}
			if ( !afAdminVerifyNonce() ){
				die;
			}
			echo json_encode( af_return_cc_list( sanitize_text_field($_REQUEST['af_cc_user']), sanitize_text_field($_REQUEST['af_cc_pass']) ) );
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_get_notification_default_by_type()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_POST['type'])){
					$template = af_return_default_notification_content( sanitize_text_field($_POST['type']) );
					if ($template){
							echo json_encode($template);
					}
			}
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_ajax_admin_popup_the_shortcodes()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			require_once AF_PATH . 'admin/views/popup-shortcodes.php';
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_approve_affiliate()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_REQUEST['uid'])){
				$role = get_option('af_after_approve_role');
				if (empty($role)){
						$role = get_option('default_role');
				}
				$new_role = empty($role) ? 'subscriber' : $role;
				$uid = wp_update_user(array( 'ID' => sanitize_text_field($_REQUEST['uid']), 'role' => $new_role));
				af_send_user_notifications( sanitize_text_field($_REQUEST['uid']), 'affiliate_account_approve');
				echo 1;
			}
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_make_wp_user_affiliate()
	{
			if ( !afIsAdmin() ){
				 die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_REQUEST['uid'])){
				 	global $af_db;
				 	if ($af_db->is_user_admin( sanitize_text_field($_REQUEST['uid']) ) ){
				 		echo 2;
						die;
				 	}
					$inserted = $af_db->save_affiliate( sanitize_text_field($_REQUEST['uid']) );
					if ($inserted){
						/// put default rank on this new affiliate
						$default_rank = get_option('af_register_new_user_rank');
						$af_db->update_affiliate_rank_by_uid( sanitize_text_field($_REQUEST['uid']), $default_rank);
						echo 1;
					}
			}
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_make_wp_user_affiliate_from_public()
	{
		  global $current_user, $af_db;
			if ( !afPublicVerifyNonce() ){
					die;
			}
		  if (!empty($current_user) && !empty($current_user->ID)){
			 	$uid = $current_user->ID;
			 	if ($af_db->is_user_admin($uid)){
				 		echo 0;
						die;
			 	}

				$inserted = $af_db->save_affiliate($uid);
				if ($inserted){
					/// put default rank on this new affiliate
					$default_rank = get_option('af_register_new_user_rank');
					$af_db->update_affiliate_rank_by_uid($uid, $default_rank);

					/// SET MLM RELATION
					$af_db->set_mlm_relation_on_new_affiliate($inserted);

					//SEND NOTIFICATIONS
					af_send_user_notifications($uid, 'register', $default_rank);//notify the affiliate
					af_send_user_notifications($uid, 'admin_user_register', $default_rank);//notify the admin
				}
				$pid = get_option('af_general_user_page');
				if ($pid){
					 $new_url = get_permalink($pid);
				}
				if (!$new_url){
					 $new_url = get_home_url();
				}
				echo esc_af_content($new_url);
		 }
		 die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_delete_currency_code_ajax()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (isset($_REQUEST['code'])){
					$data = get_option('af_currencies_list');
					if (!empty($data[ sanitize_text_field($_REQUEST['code'] ) ] ) ){
							unset($data[ sanitize_text_field($_REQUEST['code']) ]);
							echo 1;
					}
					update_option('af_currencies_list', $data);
			}
			die;
	}

	/**
	 * @param none
	 * @return none
	 */
	public function af_remove_slug_from_aff()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_POST['uid'])){
			 		update_user_meta( sanitize_text_field($_POST['uid']), 'af_affiliate_custom_slug', '');
			}
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_get_amount_for_referral_list()
	{
			global $current_user;
			if ( empty( $current_user->ID ) ){
					die;
			}
			if ( !afPublicVerifyNonce() ){
					die;
			}
			if (!empty($_POST['r'])){
					global $af_db;
					$referral_list = explode(',', sanitize_textarea_field( $_POST['r']) );
					if (!empty($referral_list) && count($referral_list)){
							$amount = $af_db->get_amount_for_referrals($referral_list);
							echo esc_af_content($amount);
					}
			}
			die;
	}

	/**
	 * @param none
	 * @return int
	 */
	public function af_delete_wallet_item_via_ajax()
	{
		 if ( !afPublicVerifyNonce() ){
			  die;
		 }
		 if (!empty($_POST['code']) && !empty($_POST['type'])){
			 	 global $af_db;
				 global $current_user;
				 $uid = (empty($current_user->ID)) ? 0 : $current_user->ID;
				 $affiliate_id = $af_db->get_affiliate_id_by_wpuid($uid);
				 if ($affiliate_id){
						 $af_db->delete_wallet_item( sanitize_text_field($_POST['type']), $affiliate_id, sanitize_text_field($_POST['code']) );
						 echo 1;
				 }
		 }
		 die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_preview_user_listing()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_REQUEST['shortcode'])){
					define('IS_PREVIEW', TRUE);
					$shortcode = stripslashes( sanitize_textarea_field($_REQUEST['shortcode']) );
					require_once AF_PATH . 'public/AfMainPublic.class.php';
					$af_main_object = new AfMainPublic();
					echo do_shortcode($shortcode);
			}
			die;
	}

	/**
	 * @param none
	 * @return int
	 */
	public function af_delete_attachment_ajax_action()
	{
		 $uid = isset($_POST['user_id']) ? af_sanitize_array($_POST['user_id']) : 0;
		 $field_name = isset($_POST['field_name']) ? af_sanitize_array($_POST['field_name']) : '';
		 $attachment_id = isset($_POST['attachemnt_id']) ? af_sanitize_array($_POST['attachemnt_id']) : 0;

		 if (function_exists('is_user_logged_in') && is_user_logged_in()){
			 $current_user = wp_get_current_user();
			 if ( !empty($uid) && $uid == $current_user->ID ){
					 /// registered users
					 if ( !afPublicVerifyNonce() ){
 							die;
 					 }
					 if (!empty($attachment_id)){
							 $verify_attachment_id  = get_user_meta($uid, $field_name, TRUE);
							 if ($verify_attachment_id==$attachment_id){
									 wp_delete_attachment($attachment_id, TRUE);
									 update_user_meta($uid, $field_name, '');
									 echo 0;
									 die();
							 }
					 }
			 } else if (current_user_can('manage_options')){
					/// ADMIN, no extra checks
					if ( !afAdminVerifyNonce() ){
						  die;
					}
					wp_delete_attachment($attachment_id, TRUE);
					update_user_meta($uid, $field_name, '');
			 }
		 } else if ($uid==-1){
			 		if ( !afPublicVerifyNonce() ){
							die;
					}
				 /// unregistered user
				 $hash_from_user = isset($_POST['h']) ? af_sanitize_array($_POST['h']) : '';
				 $attachment_url = wp_get_attachment_url($attachment_id);
				 $attachment_hash = md5($attachment_url);
				 if (empty($hash_from_user) || empty($attachment_hash) || $hash_from_user!==$attachment_hash){
						 echo 1;die;
				 } else {
						 wp_delete_attachment($attachment_id, TRUE);
						 echo 0;
						 die;
				 }
		 }

		 echo 1;
		 die;
	}

	/**
	 * @param none
	 * @return none
	 */
	public function af_affiliate_simple_user()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
					die;
			}
			if (!empty($_POST['uid'])){
			 	global $af_db;
				$af_db->remove_user_from_affiliate( sanitize_text_field($_POST['uid']) );
			}
			die;
	}

	/**
	 * @param none
	 * @return int
	 */
	public function af_approve_user_email()
	{
		  if ( !afIsAdmin() ){
				die;
		  }
			if ( !afAdminVerifyNonce() ){
				die;
			}
		  if (!empty($_POST['uid'])){
		 	  update_user_meta( sanitize_text_field($_POST['uid']), 'af_verification_status', 1);
			  echo 1;
		  }
		  die;
	}

	/**
	 * @param none
	 * @return int
	 */
	public function af_check_mail_server()
	{
			if ( !afIsAdmin() ){
					die;
			}
			if ( !afAdminVerifyNonce() ){
				  die;
			}
			$from_email = '';
			$from_name = '';
			$from_email = get_option('af_notification_email_from');
			if (!$from_email){
				$from_email = get_option('admin_email');
			}
			$from_name = get_option('af_notification_name');
			if (empty($from_name)){
				$from_name = get_option("blogname");
			}
			$headers[] = "From: $from_name <$from_email>";
			$headers[] = 'Content-Type: text/html; charset=UTF-8';

			$to = get_option( 'af_admin_notification_address', false );// >= 8.5
			if (empty($to)){
				$to = get_option('admin_email');//we change the destination
			}

			$subject = get_option('blogname') . ': ' . esc_html__('Testing Your E-mail Server', 'openaffiliates');
			$content = esc_html__('Just a simple message to test if Your E-mail Server is working', 'openaffiliates');
			$sent = wp_mail($to, $subject, $content, $headers);

			if ( $sent ){
				  // notification log ( v. >= 8.5 )
					$log = [
						'notification_type'       => 'admin_check_email_server',
						'email_address'           => $to,
						'message'                 => $content,
						'subject'									=> $subject,
						'uid'                     => 0,
						'affiliate_id'            => 0,
						'rank_id'                 => 0,
					];
					\OpenAffiliates\Db\NotificationLogs::save( $log );
					// notification log ( v. >= 8.5 )
			}

			echo 1;
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
	public function af_check_if_username_is_affiliate()
	{
		 if ( $_POST['username'] ){
			 	global $af_db;
			 	$affiliate_id = $af_db->get_affiliate_id_by_username( sanitize_text_field($_POST['username']) );
				if (!$affiliate_id){
						echo 1;
						die;
				}
		 }
		 echo 0;
		 die;
	}


	/**
	 * @param none
	 * @return string
	 */
	public function af_do_generate_payments_csv()
	{
			if ( !afIsAdmin() ){
				 die;
			}
			if ( !afAdminVerifyNonce() ){
				 die;
			}
			require_once AF_PATH . 'classes/PayoutPaymentsExport.class.php';
			$obj = new PayoutPaymentsExport();

			if (!empty($_POST['min_date'])){
				$obj->set_min_date( sanitize_text_field($_POST['min_date']) );
			}
			if (!empty($_POST['max_date'])){
				$obj->set_max_date( sanitize_text_field($_POST['max_date']) );
			}
			if (!empty($_POST['payment_type'])){
				$obj->set_payment_type( sanitize_text_field($_POST['payment_type']) );
			}
			if (!empty($_POST['switch_status'])){
				$obj->set_new_status( sanitize_text_field($_POST['switch_status']) );
			}

			echo esc_af_content($obj->generate_csv());
			die;
	}

	/**
	 * @param none
	 * @return string
	 */
		public function do_get_font_awesome_popup()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					die;
				}
				ob_start();
				require_once AF_PATH . 'admin/views/popup-font_awesome.php';
				$output = ob_get_contents();
				ob_end_clean();
				echo esc_af_content($output);
				die;
		}


	/**
	 * @param none
	 * @return string
	 */
		public function make_export_file()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					die;
				}
				global $wpdb, $af_db;
				require_once AF_PATH . 'classes/import-export/AfExport.class.php';
				$export = new AfExport();
				$hash = bin2hex( random_bytes( 20 ) );
				$filename = $hash . '.xml';
				$targetFile = AF_PATH . 'temporary/' . $filename;
				$export->setFile( $targetFile );
				$export->deleteOldFiles();
				if (!empty($_POST['import_users'])){

					$export->setGetUsers(TRUE);
				}
				if (!empty($_POST['import_settings'])){
					///////// SETTINGS
					$values = $af_db->get_all_af_wp_options();
					$export->setEntity( array('full_table_name' => $wpdb->base_prefix . 'options', 'table_name' => 'options', 'values' => $values) );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_banners', 'table_name' => 'af_banners') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_notifications', 'table_name' => 'af_notifications') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_ranks', 'table_name' => 'af_ranks') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_offers', 'table_name' => 'af_offers') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_offers_affiliates_reference', 'table_name' => 'af_offers_affiliates_reference') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_mlm_relations', 'table_name' => 'af_mlm_relations') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_ranks_history', 'table_name' => 'af_ranks_history') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_landing_commissions', 'table_name' => 'af_landing_commissions') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_coupons_code_affiliates', 'table_name' => 'af_coupons_code_affiliates') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_reports', 'table_name' => 'af_reports') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_ref_links', 'table_name' => 'af_ref_links') );

					// since version 8.6
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_generated_affiliate_links', 'table_name' => 'af_generated_affiliate_links') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_banners_meta', 'table_name' => 'af_banners_meta') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_affiliate_referral_users_relations', 'table_name' => 'af_affiliate_referral_users_relations') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_cpm', 'table_name' => 'af_cpm') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_notifications_logs', 'table_name' => 'af_notifications_logs') );
					$export->setEntity( array('full_table_name' => $wpdb->prefix . 'af_campaigns', 'table_name' => 'af_campaigns') );
					// end 8.6
				}
				if ($export->run()){
					/// print link to file
					echo AF_URL . 'temporary/' . $filename;
				} else {
					/// no entity
					echo 0;
				}
				die;
		}

	/**
	 * @param none
	 * @return none
	 */
		public function af_trigger_migration()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					die;
				}
				$serviceType = isset($_POST['serviceType']) ? sanitize_text_field($_POST['serviceType']) : false;

				if (empty($serviceType)){
						echo 0;
						die;
				}
				$data = get_option('af_do_migrate_log');
				if (isset($data[$serviceType])){
						unset($data[$serviceType]);
						update_option('af_do_migrate_log', $data);
				}
				$assignRank = isset($_POST['assignRank']) ? sanitize_text_field($_POST['assignRank']) : '';

				$postRequest = array(
			          'service_type'  => $serviceType,
			          'entity_type'   => false,
			          'offset'        => 0,
			          'assignRank'    => $assignRank
				);
				$curl = curl_init( admin_url('admin.php?af_act=migrate') );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, $postRequest );
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

				$response = curl_exec($curl);
				curl_close($curl);
				exit;
		}

	/**
	 * @param none
	 * @return string
	 */
		public function af_get_empty_progress_bar()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					 die;
				}
				include AF_PATH . 'admin/views/empty-progress-bar.php';
				die;
		}

		/**
		 * @param none
		 * @return int
		 */
		public function af_migrate_get_status()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					 die;
				}
				$serviceType = isset($_POST['serviceType']) ? sanitize_text_field($_POST['serviceType']) : '';
				if (empty($serviceType)){
						echo -1;
						die;
				}
				$data = get_option('af_do_migrate_log');
				$logData = isset($data[$serviceType]) ? $data[$serviceType] : false;
				if (empty($logData)){
					 echo -1;
					 die;
				}
				if ($logData=='completed'){
						echo 100;
						die;
				}
				$total = 0;
				$total += empty($logData['affiliates-count']) ? 0 : $logData['affiliates-count'];
				$total += empty($logData['referrals-count']) ? 0 : $logData['referrals-count'];
				$current = 0;
				$current += empty($logData['affiliates-offset']) ? 0 : $logData['affiliates-offset'];
				$current += empty($logData['referrals-offset']) ? 0 : $logData['referrals-offset'];
				$percentage = (100 * $current)/$total;
				echo (int)$percentage;
				die;
		}

		/**
		 * @param none
		 * @return int
		 */
		public function af_migrate_reset_log()
		{
			if ( !afIsAdmin() ){
				 die;
			}
			if ( !afAdminVerifyNonce() ){
				die;
			}
			$serviceType = isset($_POST['serviceType']) ? sanitize_text_field($_POST['serviceType']) : '';
			if (empty($serviceType)){
					echo -1;
					die;
			}
			$data = get_option('af_do_migrate_log');
			if (isset($data[$serviceType])){
					unset($data[$serviceType]);
					update_option('af_do_migrate_log', $data);
					echo 1;
			}
			die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_ap_reset_custom_banner()
		{
				global $current_user;
				$uid = isset($current_user->ID) ? $current_user->ID : 0;
				if ( !afPublicVerifyNonce() ){
					die;
				}
				if (empty($uid)){
						die;
				}
				$banner = isset($_POST['oldBanner']) ? af_sanitize_array($_POST['oldBanner']) : '';
				if (empty($banner)){
						die;
				}
				update_user_meta($uid, 'af_account_page_personal_header', $banner);
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_admin_send_email_popup()
		{
				if ( !afIsAdmin() ){
					  die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				global $af_db;
				$uid = empty($_POST['uid']) ? 0 : af_sanitize_array($_POST['uid']);
				if (empty($uid)){
						die;
				}
				$toEmail = $af_db->get_user_col_value($uid, 'user_email');
				if (empty($toEmail)){
						die;
				}
				$fromEmail = '';
				$fromEmail = get_option('af_notifications_from_email_addr');
				if (empty($fromEmail)){
						$fromEmail = get_option('admin_email');
				}
				$view = new \OpenAffiliates\AfView();
				$view->setTemplate(AF_PATH . 'admin/views/send-email-popup.php');
				$view->setContentData([
																'toEmail' 		=> $toEmail,
																'fromEmail' 	=> $fromEmail,
																'fullName'		=> $af_db->getUserFullName($uid),
																'website'			=> get_option('blogname')
				], true);
				echo esc_af_content($view->getOutput());
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_admin_do_send_email()
		{
				if ( !afIsAdmin() ){
					 die;
				}
				if ( !afAdminVerifyNonce() ){
					 die;
				}
				$to = empty($_POST['to']) ? '' : af_sanitize_array($_POST['to']);
				$from = empty($_POST['from']) ? '' : af_sanitize_array($_POST['from']);
				$subject = empty($_POST['subject']) ? '' : af_sanitize_array($_POST['subject']);
				$message = empty($_POST['message']) ? '' :  stripslashes(htmlspecialchars_decode(af_format_str_like_wp(af_sanitize_textarea_array($_POST['message']))));
				$headers = [];

				if (empty($to) || empty($from) || empty($subject) || empty($message)){
						die;
				}

				$from_name = get_option('af_notification_name');
				$from_name = stripslashes($from_name);
				if (!empty($from) ){ // && !empty($from_name)
					$headers[] = "From: $from_name <$from>";
				}
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				$sent = wp_mail($to, $subject, $message, $headers);

				if ( $sent ){
						// notification log ( v. >= 8.5 )
						$log = [
							'notification_type'       => 'admin_send_direct_email',
							'email_address'           => $to,
							'message'                 => $message,
							'subject'									=> $subject,
							'uid'                     => 0,
							'affiliate_id'            => 0,
							'rank_id'                 => 0,
						];
						\OpenAffiliates\Db\NotificationLogs::save( $log );
						// notification log ( v. >= 8.5 )
				}

				echo esc_af_content($sent);
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_info_affiliate_bar_do_hide()
		{
				setcookie( 'af_info_affiliate_bar_hide', 1, time() + 60 * 60 * 24, '/', af_server_host() );
				echo 1;
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_ajax_get_banner_for_permalink()
		{
				if ( !afPublicVerifyNonce() ){
				  	die;
				}
				if ( empty( $_POST['uid'] ) || empty( $_POST['affiliate_id'] ) || empty( $_POST['url'] ) || empty( $_POST['size'] ) ){
						echo esc_html('');
						die;
				}
				$AffiliateMarketingBuilder = new \OpenAffiliates\AffiliateMarketingBuilder();
				$AffiliateMarketingBuilder->setUid( af_sanitize_array( $_POST['uid'] ) )->setAffiliateId( af_sanitize_array( $_POST['affiliate_id'] ) )->setCurrentPermalink( af_sanitize_array( $_POST['url'] ) );
				$banner = $AffiliateMarketingBuilder->getBannerForPermalink( af_sanitize_array( $_POST['size'] ) );
				if ( !$banner ){
	            $banner = $AffiliateMarketingBuilder->getDefaultBAnnerForPermalink();
				}
				echo esc_af_content($banner);
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_search_product_for_product_links()
		{

				if ( afIsAdmin() ){
						if ( isset( $_POST['labelsOn'] ) && $_POST['labelsOn'] !== false && $_POST['labelsOn'] !== true ){
								// admin on public
								$dataViaAjax = json_encode( base64_decode( $_POST['labelsOn'] ), true );
								if (  !wp_verify_nonce( sanitize_text_field($dataViaAjax[0]), 'afAdminPreviewPortal' ) ){
									echo 1;
										die;
								}
						} else {
								// admin check
								if ( !afAdminVerifyNonce() ){
										echo 2;
										die;
								}
						}
				} else {
						// public
						if ( !afPublicVerifyNonce() ){
								die;
						}
				}
				global $af_db;
				$limit = 5;
				$returnData = [
									'html'				=> '',
									'offset'			=> $_POST['offset'],
									'showMore'		=> 0,
				];

				$typeOfService = get_option( 'af_product_links_source' );
				if ( !$typeOfService ){
						echo json_encode(af_sanitize_array($returnData));
						die;
				}
				if ( isset( $dataViaAjax[1] ) ){
						// affiliate
						$affiliateId = $dataViaAjax[1];
				} else {
						$uid = af_get_uid();
						if ( !$uid ){
								echo json_encode(af_sanitize_array($returnData));
								die;
						}
						$affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
				}

				if ( !$affiliateId ){
						echo json_encode(af_sanitize_array($returnData));
						die;
				}

				$productsObject = new \OpenAffiliates\Db\Products();
				$productsObject->setLimit( $limit )
											 ->setOffset( af_sanitize_array( $_POST['offset'] ) )
											 ->setType( $typeOfService )
											 ->setSearchPhrase( af_sanitize_array( $_POST['search'] ) )
											 ->setOrderBy( af_sanitize_array( $_POST['orderBy'] ) )
											 ->setAffiliateId( $affiliateId );
				if ( !empty($_POST['category']) ){
						$productsObject->setProductCategory( af_sanitize_array( $_POST['category'] ) );
				}
				$products = $productsObject->getResults();
				$productsCount = $productsObject->getCount();

				$viewObject = new \OpenAffiliates\AfView();
				$html = '';
				if ( !$products ){
						echo json_encode( $returnData );
						die;
				}

				if ( $productsCount > $returnData['offset'] + $limit ){
						$returnData['showMore'] = 1;
				}


				$AffiliateMarketingBuilder = new \OpenAffiliates\AffiliateMarketingBuilder();
				$AffiliateMarketingBuilder->setUid( $uid )->setAffiliateId( $affiliateId );
				$showReward = get_option( 'af_product_links_reward_calculation' );

				foreach ( $products as $productData ){
						$productData['showReward'] = $showReward;
						$productData['affiliateLink'] = $AffiliateMarketingBuilder->setCurrentPermalink( $productData['permalink'] )->getPermalinkForAffiliate();
						$html .= $viewObject->setContentData( $productData )->setTemplate( AF_PATH . 'public/views/product_links/single_product.php' )->getOutput();
				}
				$returnData['count'] = $productsCount;
				$returnData['offset'] = sanitize_text_field($_POST['offset']) + count( $products );
				$returnData['html'] = $html;
				echo json_encode( $returnData );
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_product_link_popup()
		{
				global $af_db;
				if ( empty($_POST['postId']) ){
						echo esc_html('');
						die;
				}
				// 8.6
				if ( isset( $_POST['labelsOn'] ) && current_user_can( 'administrator') ){
						$dataViaAjax = json_decode( base64_decode( $_POST['labelsOn'] ), true );
				}
				//8.6
				$permalink = get_permalink( af_sanitize_array( $_POST['postId'] ) );
				if ( isset( $dataViaAjax[1] ) ){
						// affiliate
						$affiliateId = $dataViaAjax[1];
						$uid = $af_db->get_uid_by_affiliate_id( $affiliateId );
				}
				if ( empty( $uid ) ){
						$uid = af_get_uid();
				}

				if ( empty( $uid ) ) {
						echo esc_html('');
						die;
				}
				$affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
				if ( empty( $affiliateId ) ) {
						echo esc_html('');
						die;
				}
				if ( !afPublicVerifyNonce() ){
					  die;
				}
				$AffiliateMarketingBuilder = new \OpenAffiliates\AffiliateMarketingBuilder();
				$AffiliateMarketingBuilder->setUid( $uid )->setAffiliateId( $affiliateId )->setCurrentPermalink( $permalink );
				$data = [
							'friendly_links'          	=> $af_db->is_magic_feat_enable('friendly_links'),
							'custom_affiliate_slug'   	=> $af_db->is_magic_feat_enable('custom_affiliate_slug'),
							'the_slug'									=> $af_db->get_custom_slug_for_uid( $uid ),
							'af_default_ref_format'		=> get_option('af_default_ref_format'),
							'ref_type'									=> (get_option('af_default_ref_format')=='username') ? esc_html__('Username', 'openaffiliates') : 'Id',
							'affiliate_id'							=> $affiliateId,
							'url'												=> $AffiliateMarketingBuilder->getPermalinkForAffiliate(),
							'post_id'										=> af_sanitize_array( $_POST['postId'] ),
				];
				$view = new \OpenAffiliates\AfView();
				$output = $view->setContentData( $data )->setTemplate( AF_PATH . 'public/views/product_links/show_link_popup.php' )->getOutput();
				echo esc_af_content( $output );
				die;
		}


		/**
		 * @param none
		 * @return string
		 */
		public function af_remove_media_post()
		{
				if ( afIsAdmin() ){
						// admin check
						if ( !afAdminVerifyNonce() ){
								die;
						}
				} else {
						// public
						if ( !afPublicVerifyNonce() ){
							die;
						}
				}
				if ( empty( $_POST['postId'] ) ){
						return;
				}
				wp_delete_attachment( af_sanitize_array( $_POST['postId'] ), true );
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_ajax_make_csv()
		{
				if ( !afIsAdmin() ){
					  die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				if ( empty( $_POST['exportType'] ) ){
						echo 0;
						die;
				}
				$filters = isset($_POST['filters']) ? json_decode( stripslashes(af_sanitize_textarea_array($_POST['filters'])), true ) : false;

				$exportCsvObject = new \OpenAffiliates\ExportDataAsCsv();
				$link = $exportCsvObject->setTypeOfData( sanitize_text_field($_POST['exportType']) )
																->setFilters( $filters )
														 		->run()
														 		->getDownloadLink();
				if ( !$link ){
						echo 0;
						die;
				}
				echo esc_af_content($link);
				die;
		}

		/**
		 * @param none
		 * @return none
		 */
		public function af_ajax_make_csv_params_as_json()
		{
				if ( !afIsAdmin() ){
						echo json_encode([
																'status'						=> 0,
																'reason'						=> 'private',
						]);
						die;
				}
				if ( !afAdminVerifyNonce() ){
						echo json_encode([
																'status'						=> 0,
																'reason'						=> 'private',
						]);
						die;
				}
				if ( empty( $_POST['exportType'] ) ){
						echo json_encode([
																'status'						=> 0,
																'reason'						=> 'export type not provided',
						]);
						die;
				}
				$filters = isset($_POST['filters']) ? json_decode( stripslashes(af_sanitize_textarea_array($_POST['filters'])), true ) : false;

				$exportCsvObject = new \OpenAffiliates\ExportDataAsCsv();
				$link = $exportCsvObject->setTypeOfData( sanitize_text_field($_POST['exportType']) )
																->setFilters( $filters )
																->run()
																->getDownloadLink();
				if ( !$link ){
						echo json_encode([
																'status'							=> 0,
																'reason'							=> 'No data available',
																'errorMessageAsHtml'	=> '<div class="af-js-notice-for-export af-warning-box" >' . esc_html__('No entries available for selected options.', 'openaffiliates') . '</div>',
						]);
						die;
				}
				echo json_encode([
														'status'							=> 1,
														'file'								=> $link,
														'htmlSuccessMessage'	=> '<span class="af-download-csv-link"><p>'.esc_html__('If your download did not start automatically, click the link to manually initiate the download process:', 'openaffiliates').' <a href="' . $link . '">' . esc_html__( 'download CSV file', 'openaffiliates' ) . '</a></p></span>',
				]);
				die;
		}

		/**
		 * @param none
		 * @return none
		 */
		public function deleteRanks()
		{
				global $af_db;
				if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
						echo esc_html('error');
						die;
				}
				if ($af_db->ranks_get_count()>1){
						$af_db->delete_rank( sanitize_text_field( $_POST['id'] ) );
						echo esc_html('success');
						die;
				} else {
					 esc_html_e('You cannot have less than one rank.', 'openaffiliates');
					die;
				}
		}

		/**
		 * @param none
		 * @return none
		 */
		public function afDeleteReferrerLinkForAffiliate()
		{
				global $af_db;
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				if ( empty( $_POST['id'] ) ){
						echo 0;
						die;
				}
				$af_db->simple_links_delete_link( sanitize_text_field($_POST['id']) );
				die;
		}

		/**
		 * @param none
		 * @return none
		 */
		public function afDeleteLandingPageForAffiliate()
		{
				global $af_db;
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				if ( empty( $_POST['id'] ) ){
						echo 0;
						die;
				}
				update_post_meta( sanitize_text_field($_POST['id']), 'af_landing_page_affiliate_id', '' );
				die;
		}

		public function afDeleteCouponsForAffiliate()
		{
				global $af_db;
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				if ( empty( $_POST['id'] ) ){
						echo 0;
						die;
				}
				$af_db->delete_coupon_affiliate_pair( sanitize_text_field($_POST['id']) );
				die;
		}

		public function saveCampaign()
		{
				global $af_db;
				// public
				if ( !afPublicVerifyNonce() ){
					die;
				}
				$uid = af_get_uid();
				if ( empty( $uid ) ) {
						die;
				}
				$affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
				if ( empty( $affiliateId ) ){
						die;
				}
				if ( !empty($_POST['campaignName']) ){
						$_POST['campaignName'] = sanitize_text_field( $_POST['campaignName'] );
						$_POST['campaignName'] = preg_replace( '/[^A-Za-z0-9\-\_]/', '', $_POST['campaignName'] );
						$af_db->add_empty_campaign( $affiliateId, $_POST['campaignName']);
						echo 1;
				}
				die;
		}

		public function saveSimpleLink()
		{
				global $af_db;
				// public
				if ( !afPublicVerifyNonce() ){
					die;
				}
				$uid = af_get_uid();
				if ( empty( $uid ) ) {
						die;
				}
				$affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
				if ( empty( $affiliateId ) ){
						die;
				}
				foreach ( $_POST as $postKey => $postValue ){
						$_POST[ $postKey ] = sanitize_text_field( $postValue );
				}
				$data = [ 'affiliate_id' => $affiliateId, 'url' => $_POST['url'] ];
				$inserted = $af_db->simple_links_save_link($data, 0);///set status as 0 (pending)
				if ( isset( $_POST['currentUrl'] ) && $inserted < 1 ){
						$_POST['currentUrl'] = add_query_arg( 'af_aff_subtab', 'simple_links', $_POST['currentUrl'] );
						$_POST['currentUrl'] = add_query_arg( 'message', $inserted, $_POST['currentUrl'] );
						echo esc_af_content($_POST['currentUrl']);
						die;
				}
				die;
		}

		public function notificationSendTestEmail()
		{
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				include_once AF_PATH . 'admin/views/notification-send-email-test.php';
				die;
		}

		function af_ajax_do_send_notification_test()
		{
			if ( !afIsAdmin() ){
					echo 0;
					die;
			}
			if ( !afAdminVerifyNonce() ){
				 echo 0;
				 die;
			}
			$notificationId = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : 0;
			$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
			afSendTestNotification( $notificationId, $email );
			echo 1;
			die;
		}

		public function af_ajax_do_remove_affiliate_link()
		{
				if ( !afPublicVerifyNonce() ){
					die;
				}
				\OpenAffiliates\Db\GeneratedAffiliateLinks::delete( af_sanitize_array( $_POST['id'] ) );
				die;
		}

		public function af_ajax_load_list_affiliate_links_table()
		{
				global $current_user, $af_db;
				if ( !afPublicVerifyNonce() ){
					die;
				}
				if ( !isset( $current_user->ID ) ){
						die;
				}
				$aid = $af_db->get_affiliate_id_by_wpuid( $current_user->ID );
				if ( !$aid ){
						die;
				}
				$data['affiliate_links'] = \OpenAffiliates\Db\GeneratedAffiliateLinks::getAllForAId( $aid );

				$fullPath = AF_PATH . 'public/views/account_page-list_affiliate_links.php';
				$searchFilename = 'account_page-list_affiliate_links.php';
				$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

				require $template;

				die;
		}


		/**
		 * @param none
		 * @return none
		 */
		public function af_ajax_public_upload()
		{
				$viaWpAjax = true;
				include AF_PATH . 'public/ajax-upload.php';
				die;
		}

		/**
		 * @param none
		 * @return none
		 */
		public function af_ajax_offers_autocomplete()
		{
				$viaWpAjax = true;
				include AF_PATH . 'admin/af-offers-ajax-autocomplete.php';
				die;
		}

		/**
		 * @param none
		 * @return none
		 */
		public function af_ajax_coupons_autocomplete()
		{
				$viaWpAjax = true;
				include AF_PATH . 'admin/af-coupons-ajax-autocomplete.php';
				die;
		}

		/**
		 * @param none
		 * @return string
		 */
		public function af_ajax_stripe_generate_onboarding_url()
		{
				global $current_user;
				if ( !afPublicVerifyNonce() ){
						echo json_encode([
																'status'			=> 0,
																'account_id'  => '',
																'url'					=> '',
																'message'			=> esc_html__( 'Error', 'openaffiliates'),//'access denied',
						]);
						die;
				}
				if ( !isset( $current_user->ID ) ){
					echo json_encode([
															'status'			=> 0,
															'account_id'  => '',
															'url'					=> '',
															'message'			=> esc_html__( 'Error', 'openaffiliates'),//'no user id provided',
					]);
					die;
				}
				require_once AF_PATH  . 'classes/services/stripe-php-master/vendor/autoload.php';
				$sandbox = get_option( 'af_stripe_v3_sandbox' );
				if ( $sandbox ){
						$secret = get_option( 'af_stripe_v3_sandbox_secret_key' );
				} else {
						$secret = get_option( 'af_stripe_v3_secret_key' );
				}
				if ( $secret == '' ){
						echo json_encode([
																'status'			=> 0,
																'account_id'  => '',
																'url'					=> '',
																'message'			=> esc_html__( 'Error', 'openaffiliates'),//'no secret key',
						]);
						die;
				}
				$stripe = new \Stripe\StripeClient( $secret );
				$params = [
									//'country' => 'US',
									'type' => 'express',
									'capabilities' => [
										'transfers' => ['requested' => true],
									],
									'business_type' => 'individual',
				];
				$account = $stripe->accounts->create( $params );
				$accountId = isset( $account->id ) ? $account->id : 0;
				if ( $accountId === 0 || $accountId === '' || $accountId === false ){
						echo json_encode([
																'status'			=> 0,
																'account_id'  => $accountId,
																'url'					=> '',
																'message'			=> esc_html__( 'Error', 'openaffiliates'),//"can't create account id",
						]);
						die;
				}
				$notificationUrl = site_url();
				$notificationUrl = trailingslashit( $notificationUrl );
				$oauthRedirectBackPage = $notificationUrl . '?af_act=stripe_v3_auth';

				$responseFromStripe = $stripe->accountLinks->create([
				  'account' 			=> $accountId,
				  'refresh_url' 	=> $oauthRedirectBackPage,
				  'return_url' 		=> $oauthRedirectBackPage,
				  'type' 					=> 'account_onboarding',
				]);
				if ( isset( $responseFromStripe->url ) && $responseFromStripe->url !== '' ){
						// save account id
						update_user_meta( $current_user->ID, 'af_stripe_v3_user_account_id-pending', $accountId );
						update_user_meta( $current_user->ID, 'af_affiliate_payment_type', 'stripe_v3' );

						// return response
						echo json_encode([
																'status'			=> 1,
																'account_id'  => $accountId,
																'url'					=> $responseFromStripe->url,
																'message'			=> 'success',
						]);
						die;
				}
				echo json_encode([
														'status'			=> 0,
														'account_id'  => $accountId,
														'url'					=> '',
														'message'			=> esc_html__( 'Error', 'openaffiliates'),//"can't create url for authentification.",
				]);
				die;
		}


		/**
		 * Reset de fábrica. mode=settings restaura só as configurações; mode=all apaga também os dados.
		 * Exige administrador, token do painel e a palavra RESET.
		 * @param none
		 * @return none
		 */
		public function af_ajax_factory_reset()
		{
				if ( !afIsAdmin() || !current_user_can( 'manage_options' ) ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				$mode = isset( $_POST['mode'] ) ? sanitize_text_field( wp_unslash( $_POST['mode'] ) ) : '';
				$confirm = isset( $_POST['confirm'] ) ? sanitize_text_field( wp_unslash( $_POST['confirm'] ) ) : '';
				if ( $confirm !== 'RESET' || !in_array( $mode, array( 'settings', 'all' ), true ) ){
						wp_send_json_error( array( 'message' => __( 'Type RESET to confirm.', 'openaffiliates' ) ) );
				}
				global $af_db;
				if ( $mode === 'settings' ){
						$af_db->reset_settings();
						$redirect = admin_url( 'admin.php?page=openaffiliates&tab=settings&subtab=admin_workflow' );
				} else {
						$af_db->factory_reset();
						if ( !class_exists( 'AfCronJobs' ) ){
								require_once AF_PATH . 'classes/AfCronJobs.class.php';
						}
						$crons = new \AfCronJobs();
						$crons->registerCrons();
						update_option( 'af_wizard_complete', 0 );// fresh install: the setup wizard runs again
						$redirect = admin_url( 'admin.php?page=openaffiliates' );
				}
				wp_send_json_success( array( 'redirect' => $redirect ) );
		}

		public function af_ajax_clean_notifications_logs()
		{
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				$olderThen = isset( $_POST['older_then'] ) ? sanitize_text_field( $_POST['older_then'] ) : false;
				if ( !$olderThen ){
						die;
				}
				$olderThen = time() - ( $olderThen * 24 * 60 * 60 );
				\OpenAffiliates\Db\NotificationLogs::deleteMany($olderThen);
				die;
		}



		/**
		 * @param none
		 * @return none
		 */
		public function af_ajax_update_integrations_status()
		{
				if ( !afIsAdmin() ){
						die;
				}
				if ( !afAdminVerifyNonce() ){
						die;
				}
				if ( !isset( $_POST['type'] ) || !isset( $_POST['value'] ) ){
						die;
				}
				\OpenAffiliates\Integrations::update( sanitize_text_field( $_POST['type'] ), sanitize_text_field( $_POST['value'] ) );
				die;
		}

}
