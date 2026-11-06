<?php
if (!class_exists('AffiliateAccountPage')){
	class AffiliateAccountPage{
		private $uid;
		private $affiliate_id;
		private $general_settings;
		private $current_url;
		private $account_page_base_url;
		private $account_page_settings;
		private $public_extra_settings;
		private $preview 			= false;

		public function __construct($uid, $affiliate_id){
			/*
			 * @param int
			 * @return none
			 */
			wp_enqueue_style( 'af_jquery-ui.min.css', AF_URL . 'assets/css/jquery-ui.min.css');
			global $af_db;
			$this->uid = $uid;
			$this->affiliate_id = $affiliate_id;
			$this->general_settings = $af_db->return_settings_from_wp_option('general-settings');
			$this->public_extra_settings = $af_db->return_settings_from_wp_option('general-public_workflow');
			$this->account_page_settings = $af_db->return_settings_from_wp_option('account_page');
			$this->current_url = af_current_url();

			/// CREATE BASE URL
			$this->account_page_base_url = $this->current_url;
			$remove_get_attr = array('af_aff_subtab', 'af_register', 'af_list_item', 'udf', 'udu', 'u_sts', 'add_new');
			foreach ($remove_get_attr as $key){
				if (!empty($_GET[$key])){
					$this->account_page_base_url = remove_query_arg($key, $this->account_page_base_url);
				}
			}
		}

		public function output(){
			/*
			 * @param none
			 * @return string
			 */
			ob_start();

			$tab = (empty($_GET['af_aff_subtab'])) ? 'overview' : $_GET['af_aff_subtab'];

			/// HEAD
			$this->head();

			/// CONTENT
			if (empty($tab)){
				$this->run_overview();
			} else {
					switch ($tab){
						case 'affiliate_link':
							$this->run_affiliate_link();
							break;
						case 'banners':
							$this->run_banners();
							break;
						case 'change_pass':
							$this->run_change_password();
							break;
						case 'edit_account':
							$this->run_edit_account();
							break;
						case 'campaigns':
							$this->run_campaigns();
							break;
						case 'visits':
							$this->run_visits();
							break;
						case 'campaign_reports':
							$this->run_campaign_reports();
							break;
						case 'referrals':
							$this->run_referrals();
							break;
						case 'reports':
							$this->run_reports();
							break;
						case 'payments':
							$this->run_payments();
							break;
						case 'overview':
							$this->run_overview();
							break;
						case 'payments_settings':
							$this->run_payment_settings();
							break;
						case 'referrals_history':
							$this->run_referrals_history();
							break;
						case 'help':
							$this->run_help();
							break;
						case 'coupons':
							$this->print_coupons();
							break;
						case 'custom_affiliate_slug':
							$this->print_custom_affiliate_slug();
							break;
						case 'mlm':
							$this->print_mlm_page();
							break;
						case 'wallet':
							$this->print_wallet();
							break;
						case 'referral_notifications':
							$this->print_referral_notifications();
							break;
						case 'source_details':
							$this->print_source_details();
							break;
						case 'pushover_notifications':
							$this->print_pushover_notifications();
							break;
						case 'simple_links':
							$this->run_simple_links();
							break;
						case 'landing_pages':
							$this->landing_pages();
							break;
						case 'iab_settings':
							$this->iab_settings();
							break;
						default:
							$customTabContent = '';
							$customTabContent = apply_filters( 'af_account_page_custom_tab_content', $customTabContent, $tab );
							// @description run on account page, print the content for custom tab. @paramn custom tab content (string), slug of the tab
							if ( $customTabContent ){
									echo esc_af_content($customTabContent);
							} else {
									$this->run_custom_tab($tab);
							}
							break;
					}
			}


			/// FOOTER
			$this->footer();
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}

		private function create_link_for_aff($link='', $slug=''){
			/*
			 * @param string, boolean
			 * @return string
			 */
			if ($link){
				$value = $this->affiliate_id;
				$param = 'ref';

				if (!empty($this->general_settings['af_referral_variable'])){
					$param = $this->general_settings['af_referral_variable'];
				}
				if ($slug){
					$value = $slug;
				} else if (!empty($this->general_settings['af_default_ref_format']) && $this->general_settings['af_default_ref_format']=='username'){
					$user_info = get_userdata($this->uid);
					if (!empty($user_info->user_login)){

						$value = urlencode($user_info->user_login);
					}
				}
				$link = af_create_affiliate_link($link, $param, $value);
			}
			return $link;
		}

		private function head(){
			/*
			 * @param none
			 * @return none (print html)
			 */
			global $af_db;

			$exclude_tabs = array();
			if (!$af_db->is_magic_feat_enable('coupons')){
				$exclude_tabs[] = 'coupons';
			}
			if (!$af_db->is_magic_feat_enable('custom_affiliate_slug')){
				$exclude_tabs[] = 'custom_affiliate_slug';
			}
			if (!$af_db->is_magic_feat_enable('mlm')){
				$exclude_tabs[] = 'mlm';
			}
			if (!$af_db->is_magic_feat_enable('pushover')){
				$exclude_tabs[] = 'pushover';
			}
			if (!$af_db->is_magic_feat_enable('wallet')){
				$exclude_tabs[] = 'wallet';
			}
			if (!$af_db->is_magic_feat_enable('referral_notifications') && !$af_db->is_magic_feat_enable('periodically_reports')){
				$exclude_tabs[] = 'referral_notifications';
			}
			if (!$af_db->is_magic_feat_enable('simple_links')){
				$exclude_tabs[] = 'simple_links';
			}
			if (!$af_db->is_magic_feat_enable('landing_pages')){
				$exclude_tabs[] = 'landing_pages';
			}
			$custom_menu = $af_db->account_page_get_custom_menu_items();

			$data['show_tab_list'] = $this->account_page_settings['af_ap_tabs'];
			if ($data['show_tab_list']){
				$data['show_tab_list'] = explode(',', $data['show_tab_list']);
				foreach ($data['show_tab_list'] as $k=>$v){
					if ( empty( $v['url'] ) ){
							$data['urls'][$v] = add_query_arg('af_aff_subtab', $v, $this->account_page_base_url);
					}
				}
				$data['urls']['logout'] = add_query_arg('afaction', 'logout', $this->account_page_base_url );//modify logout link
			} else {
				$data['show_tab_list'] = array();
			}

			$data['af_account_page_custom_css'] = stripslashes($this->account_page_settings['af_account_page_custom_css']);

			$data['message'] = af_replace_constants($this->account_page_settings['af_ap_welcome_msg'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			if ($this->account_page_settings['af_ap_edit_show_avatar']){
				$data['avatar'] = af_get_avatar_for_uid($this->uid);
			}
			if ($this->account_page_settings['af_ap_edit_show_rank']){
				 $data['top-rank'] = 1;
			}
			if ($this->account_page_settings['af_ap_edit_show_earnings']){
				 $data['top-earning'] = 1;
			}
			if ($this->account_page_settings['af_ap_edit_show_referrals']){
				 $data['top-referrals'] = 1;
			}
			if ($this->account_page_settings['af_ap_edit_show_achievement']){
				 $data['top-achievement'] = 1;
			}
			if ($this->account_page_settings['af_ap_edit_background']){
				 $data['top-background'] = 1;
			}

			if ($this->account_page_settings['af_ap_edit_background_image']){
				 $data['top-background-image'] = $this->account_page_settings['af_ap_edit_background_image'];
			}
			$data['af_ap_edit_show_metrics'] = $this->account_page_settings['af_ap_edit_show_metrics'];
			if ($data['af_ap_edit_show_metrics']){
					$data['metrics'] = [];
					$data['metrics'][3] = $af_db->getEPCdata('3months', $this->affiliate_id);
					$data['metrics'][7] = $af_db->getEPCdata('7days', $this->affiliate_id);
			}


			$data['af_ap_top_theme'] = (empty($this->account_page_settings['af_ap_top_theme'])) ? 'af-ap-top-theme-1' : $this->account_page_settings['af_ap_top_theme'];
			$data['af_ap_theme'] = (empty($this->account_page_settings['af_ap_theme'])) ? 'af-ap-theme-1' : $this->account_page_settings['af_ap_theme'];
			$data['selected_tab'] = (empty($_GET['af_aff_subtab'])) ? '' : $_GET['af_aff_subtab'];

			$data['stats'] = $af_db->get_stats_for_payments($this->affiliate_id);
			$data['stats']['currency'] = afCurrency();

			 $current_rank_id = $af_db->get_affiliate_rank($this->affiliate_id);
			if(!empty($current_rank_id) && $current_rank_id>0){
				$current_rank = $af_db->get_rank($current_rank_id);
				$data['rank'] = $current_rank;
			}

			$data['achieved'] = $af_db->get_next_rank_achieved_percetage($this->affiliate_id);
			$data['next_rank'] = $af_db->get_affiliate_next_rank($this->affiliate_id);

			$order = get_option('af_account_page_menu_order');
			$data['available_tabs'] = $af_db->account_page_get_menu();
			$data['af_account_page_personal_header'] = get_user_meta($this->uid, 'af_account_page_personal_header', true);
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$fullPath = AF_PATH . 'public/views/account_page-header.php';
			$searchFilename = 'account_page-header.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function print_top_messages(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$payment_settings = $af_db->get_affiliate_payment_type($this->uid);

			if (empty($payment_settings['is_active']) && empty($this->public_extra_settings['af_hide_payments_warnings']) && !empty($this->public_extra_settings['af_payments_warnings_message'])){
				$data['payment_url'] = $url = add_query_arg('af_aff_subtab', 'payments_settings', $this->account_page_base_url);
				$data['warning_messages'][] = stripslashes( $this->public_extra_settings['af_payments_warnings_message'] ) . ' <a href="'.$data['payment_url'].'">'. esc_html__('here', 'openaffiliates').'</a>';
			}

			$fullPath = AF_PATH . 'public/views/account_page-top_messages.php';
			$searchFilename = 'account_page-top_messages.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function footer(){
			global $af_db;

			$data['footer_content'] = af_replace_constants($this->account_page_settings['af_ap_footer_msg'], $this->uid);
			$data['footer_content'] = stripslashes($data['footer_content']);

			$fullPath = AF_PATH . 'public/views/account_page-footer.php';
			$searchFilename = 'account_page-footer.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_affiliate_link(){
			/*
			 * @param none
			 * @return none (print html)
			 */
			global $af_db;
			$do_qr = $af_db->is_magic_feat_enable('qr_code');

			$link_for_aff = get_option('af_referral_custom_base_link');
			if (empty($link_for_aff)){
					$link_for_aff = get_home_url();
			}
			$data['home_url'] = $this->create_link_for_aff($link_for_aff);

			if ($do_qr){
				$data['qr_home'] = af_generate_qr_code($data['home_url'], $this->affiliate_id . '_home_url');
			}
			$custom_affiliate_slug = $af_db->is_magic_feat_enable('custom_affiliate_slug');

			if ($custom_affiliate_slug){
				$the_slug = $af_db->get_custom_slug_for_uid($this->uid);
				if (!empty($the_slug)){
					$data['home_url_slug'] = $this->create_link_for_aff(get_home_url(), $the_slug);
					if ($do_qr){
						$data['qr_custom_slug'] = af_generate_qr_code($data['home_url_slug'], $this->affiliate_id . '_home_url_slug');
					}
				}
			}
			$custom_affiliate_slug = $af_db->is_magic_feat_enable('custom_affiliate_slug');
			$friendly_links = $af_db->is_magic_feat_enable('friendly_links');

			$data['affiliate_id'] = $this->affiliate_id;
			$data['campaigns'] = $af_db->get_campaigns_for_affiliate_id($this->affiliate_id);
			$data['campaigns'][-1] = '...';
			ksort($data['campaigns']);
			$data['social_links'] = '';
			if (af_is_social_share_intalled_and_active() && get_option('af_social_share_enable')){
				$shortcode = get_option('af_social_share_shortcode');
				if ($shortcode){
					$shortcode = stripslashes($shortcode);
					$shortcode = str_replace(']', '', $shortcode);
					$shortcode .= " is_affiliates=1"; ///just for safe
					$shortcode .= " custom_description='" . get_option('af_social_share_message') . "'";
					$shortcode .= " custom_url='" . $data['home_url'] ."']";
					$data['social_links'] = do_shortcode($shortcode);
				}
			}
			if (get_option('af_default_ref_format')=='username' && $this->uid){
				$user_info = get_userdata($this->uid);
				$data['print_username'] = (empty($user_info->user_login)) ? '' : $user_info->user_login;
			}
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_affiliate_link_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_affiliate_link_title'];

			$data['affiliate_slug_url'] = $url = add_query_arg('af_aff_subtab', 'custom_affiliate_slug', $this->account_page_base_url);

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-generate_links.php';
			$searchFilename = 'account_page-generate_links.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;

			//Affiliate Links tables
			$data['affiliate_links'] = array();
			$url = add_query_arg('af_aff_subtab', 'affiliate_link', $this->account_page_base_url);
			$limit = 20;

			$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);

			$total_items = 1;

			$data['affiliate_links'] = \OpenAffiliates\Db\GeneratedAffiliateLinks::getAllForAId( $this->affiliate_id );

			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}



			$limit = 20;
			require AF_PATH . 'classes/AfPagination.class.php';
			$pagination = new AfPagination(array(
														'base_url' => $url,
														'param_name' => 'af_list_item',
														'total_items' => $total_items,
														'items_per_page' => $limit,
														'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();

			if(isset($data['affiliate_links']) && is_array($data['affiliate_links']) && count($data['affiliate_links']) > 0){
				$fullPath = AF_PATH . 'public/views/account_page-list_affiliate_links.php';
				$searchFilename = 'account_page-list_affiliate_links.php';
				$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

				require $template;
			}
		}

		private function run_overview(){
			/*
			 * @param none
			 * @return none (print html)
			 */

			global $af_db;

			$post_overview = get_user_meta($this->uid, 'af_overview_post', true);
			if ($post_overview && $post_overview!=-1){
				//print the post for user
				$post = get_post($post_overview);
				$data['message'] = $post->post_content;
			} else {
				//predifined message
				$data['message'] = af_replace_constants($this->account_page_settings['af_tab_overview_content'], $this->uid);
				$data['message'] = stripslashes($data['message']);
				$data['message'] = af_correct_text($data['message'], true);
			}
			$data['title'] = $this->account_page_settings['af_tab_overview_title'];

			$data['stats'] = $af_db->get_stats_for_payments($this->affiliate_id);

			$data['stats']['currency'] = afCurrency();

			$data['help_url'] = $url = add_query_arg('af_aff_subtab', 'help', $this->account_page_base_url);
			$data['statsForLast30'] = $af_db->getReferralsAmountForLastDays( $this->affiliate_id, 30 );
			$data['referralsStats'] = $af_db->get_stats_for_reports( 'last_month', $this->affiliate_id );

			$data['referralsExtraStats'] = $af_db->get_referral_report_by_date( $this->affiliate_id, date( 'Y-m-d h:i:s', time() - 30 * 24 * 60 * 60 ), date( 'Y-m-d h:i:s', time() ) );

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-overview.php';
			$searchFilename = 'account_page-overview.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_banners(){
			/*
			 * @param none
		 	 * @return none (print html)
			 */
			global $af_db;
			$data['listing_items'] = $af_db->get_banners();
			$BannersMeta = new \OpenAffiliates\Db\BannersMeta();
			if ($data['listing_items'] && is_array($data['listing_items'])){
				$param = 'ref';
				$value = $this->affiliate_id;
				if (!empty($this->general_settings['af_referral_variable'])){
					$param = $this->general_settings['af_referral_variable'];
				}
				if (!empty($this->general_settings['af_default_ref_format']) && $this->general_settings['af_default_ref_format']=='username'){
					$user_info = get_userdata($this->uid);
					if (!empty($user_info->user_login)){
						$value = $user_info->user_login;
					}
				}

				$prettify = $af_db->is_magic_feat_enable('friendly_links');
				$pixelTracking = $af_db->is_magic_feat_enable('cpm_commission');
				$data['pixel_tracking'] = '';
				if ($pixelTracking){
						$pixelTrackingUrl = get_home_url() . '?af_act=tracking&type=cpm&affiliate=' . $this->affiliate_id;
						$data['pixel_tracking'] = "<img src='{$pixelTrackingUrl}' style = 'display: none; width: 1px; height: 1px; border: none;'/>";
				}

				foreach ($data['listing_items'] as $k => $arr){
					if (isset($data['listing_items'][$k]->url)){
						$data['listing_items'][$k]->url =  af_create_affiliate_link($data['listing_items'][$k]->url, $param, $value, '', '', $prettify);
					}
					$data['listing_items'][$k]->notes = $BannersMeta->getOne( $data['listing_items'][$k]->id, 'notes' );
					$data['listing_items'][$k]->alt_text = $BannersMeta->getOne( $data['listing_items'][$k]->id, 'alt_text' );
					$data['listing_items'][$k]->content_type = $BannersMeta->getOne( $data['listing_items'][$k]->id, 'content_type' );
					$data['listing_items'][$k]->text_content = $BannersMeta->getOne( $data['listing_items'][$k]->id, 'text_content' );
				}
			}
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_banners_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_banners_title'];
			$data['show_social'] = false;
			$data['social_shortcode'] = '';
			if ( af_is_social_share_intalled_and_active() && get_option( 'af_social_share_enable' ) ){
					$currentVersion = af_get_plugin_version( WP_PLUGIN_DIR . '/indeed-social-media/indeed-social-media.php');
					if ( version_compare( $currentVersion, 7.9, '>=' ) ){
							$data['show_social'] = get_option( 'af_social_share_enable_on_creatives' );
							$data['social_shortcode'] = get_option( 'af_social_share_shortcodeon_creatives' );
					}
			}

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-banners.php';
			$searchFilename = 'account_page-banners.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_change_password(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['update_pass'])){
				if (empty($_POST['old_pass']) || empty($_POST['pass1']) || empty($_POST['pass2'])){
					$data['error'] = esc_html__("Please complete all fields!", 'openaffiliates');
				} else {

					$_POST['old_pass'] = sanitize_text_field( $_POST['old_pass'] );
					$_POST['pass1'] = sanitize_text_field( $_POST['pass1'] );
					$_POST['pass2'] = sanitize_text_field( $_POST['pass2'] );

					$user = get_user_by( 'id', $this->uid );
					if ( $user && wp_check_password( $_POST['old_pass'], $user->data->user_pass,  $this->uid)
							&& !empty( $_POST['af_public_change_password_nonce'] ) && wp_verify_nonce( $_POST['af_public_change_password_nonce'], 'af_public_change_password_nonce' )
				 ){
						if ($_POST['pass1']==$_POST['pass2']){
							$_POST['pass1'] = sanitize_text_field( $_POST['pass1'] );
							wp_set_password($_POST['pass1'],  $this->uid);

							$data['success'] = esc_html__("Your have changed your Password!", 'openaffiliates');
						} else {
							$data['error'] = esc_html__("Passwords not match!", 'openaffiliates');
						}
					} else {
						$data['error'] = esc_html__("Old Password is not correct!", 'openaffiliates');
					}
				}
			}
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_change_pass_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_change_pass_title'];
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-change_password.php';
			$searchFilename = 'account_page-change_password.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_edit_account(){
			/*
			 * @param none
			 * @return string
			 */
			require AF_PATH . 'classes/AffiliateAddEdit.class.php';

			$args = array(
						'user_id' => $this->uid,
						'type' => 'edit',
						'tos' => FALSE,
						'captcha' => FALSE,
						'action' => '',
						'is_public' => TRUE,
			);
			$obj = new AffiliateAddEdit($args);
			$data = $obj->form();
			$data['template'] = get_option('af_register_template');
			$data['action'] = '';
			ob_start();

			$fullPath = AF_PATH . 'public/views/profile.php';
			$searchFilename = 'profile.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );
			require $template;

			$data['output'] = ob_get_contents();
			ob_end_clean();
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_edit_account_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_edit_account_title'];

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-edit_account.php';
			$searchFilename = 'account_page-edit_account.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_campaigns(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['af_delete_campaign']) && !empty( $_POST['af_campaign_nonce']) && wp_verify_nonce( $_POST['af_campaign_nonce'], 'af_campaign_nonce' ) ){
				$_POST['af_delete_campaign'] = sanitize_text_field( $_POST['af_delete_campaign'] );
				$af_db->delete_campaign_by_id($this->affiliate_id, $_POST['af_delete_campaign']);
			}
			/*
			else if ( !empty($_POST['campaign_name']) && !empty( $_POST['af_campaign_nonce']) && wp_verify_nonce( $_POST['af_campaign_nonce'], 'af_campaign_nonce' ) ){
				$_POST['campaign_name'] = sanitize_text_field( $_POST['campaign_name'] );
				$af_db->add_empty_campaign($this->affiliate_id, $_POST['campaign_name']);
			}
			*/
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_campaigns_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_campaigns_title'];

			$data['campaigns'] = $af_db->get_campaigns_for_affiliate_id($this->affiliate_id);
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-campaigns.php';
			$searchFilename = 'account_page-campaigns.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_visits(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$limit = 25;
			$url = add_query_arg('af_aff_subtab', 'visits', $this->account_page_base_url);
			$where = array();
			$data['filtered'] = FALSE;

			if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
				$data['filtered'] = TRUE;

				$_REQUEST['udf'] = sanitize_text_field( $_REQUEST['udf'] );
				$_REQUEST['udu'] = sanitize_text_field( $_REQUEST['udu'] );
				//$_REQUEST['udf'] = filter_var( $_REQUEST['udf'], FILTER_SANITIZE_STRING );
				//$_REQUEST['udu'] = filter_var( $_REQUEST['udu'], FILTER_SANITIZE_STRING );
				$_REQUEST['udf'] = preg_replace( "([^0-9-]*)", '', $_REQUEST['udf'] );
				$_REQUEST['udu'] = preg_replace( "([^0-9-]*)", '', $_REQUEST['udu'] );
				$where[] = "v.visit_date>'" . $_REQUEST['udf'] . "' ";
				$where[] = "v.visit_date<'" . $_REQUEST['udu'] . "' ";
				$url .= '&udf=' . $_REQUEST['udf'] . '&udu=' . $_REQUEST['udu'];
			}
			$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
			$where[] = "v.affiliate_id=" . $this->affiliate_id;

			$total_items = (int)$af_db->get_visits(-1, -1, TRUE, '', '', $where);

			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}
			$data['items'] = $af_db->get_visits($limit, $offset, FALSE, 'visit_date', 'DESC', $where);

			$limit = 25;
			require AF_PATH . 'classes/AfPagination.class.php';
			$pagination = new AfPagination(array(
														'base_url' => $url,
														'param_name' => 'af_list_item',
														'total_items' => $total_items,
														'items_per_page' => $limit,
														'current_page' => $current_page,
			));


			$data['pagination'] = $pagination->output();
			$data['filter'] = af_return_date_filter($url);
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_visits_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_visits_title'];
			$data['stats'] = $af_db->get_stats_for_reports('', $this->affiliate_id);

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-list_visits.php';
			$searchFilename = 'account_page-list_visits.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_campaign_reports(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$limit = 25;
			$url = add_query_arg('af_aff_subtab', 'campaign_reports', $this->account_page_base_url);
			$where = array();
			$current_page = (empty($_GET['af_list_item'])) ? 1 : sanitize_text_field($_GET['af_list_item']);
			$total_items = (int)$af_db->get_campaigns_reports_for_affiliate_id($this->affiliate_id, 0, 0, TRUE, '', '', $where);
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}
			$data['items'] = $af_db->get_campaigns_reports_for_affiliate_id($this->affiliate_id, $limit, $offset, FALSE, '', '', $where);

			require AF_PATH . 'classes/AfPagination.class.php';
			$limit = 25;
			$pagination = new AfPagination(array(
					'base_url' => $url,
					'param_name' => 'af_list_item',
					'total_items' => $total_items,
					'items_per_page' => $limit,
					'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_campaign_reports_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true );
			$data['title'] = $this->account_page_settings['af_tab_campaign_reports_title'];
			$data['campaign_page_url'] = $url = add_query_arg('af_aff_subtab', 'campaigns', $this->account_page_base_url);
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-campaign_reports.php';
			$searchFilename = 'account_page-campaign_reports.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_referrals(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$limit = 25;
			$url = add_query_arg('af_aff_subtab', 'referrals', $this->account_page_base_url);
			$where = array();
			$data['filtered'] = FALSE;

			if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
				$data['filtered'] = TRUE;

				$_REQUEST['udf'] = sanitize_text_field( $_REQUEST['udf'] );
				$_REQUEST['udu'] = sanitize_text_field( $_REQUEST['udu'] );

				$where[] = " r.date>'" . $_REQUEST['udf'] . "' ";
				$where[] = " r.date<'" . $_REQUEST['udu'] . "' ";
				$url .= '&udf=' . $_REQUEST['udf'] . '&udu=' . $_REQUEST['udu'];
			}
			if (isset($_REQUEST['u_sts']) && $_REQUEST['u_sts']!=-1){
				$_REQUEST['u_sts'] = sanitize_text_field( $_REQUEST['u_sts'] );

				$where[] = " r.status='" . $_REQUEST['u_sts'] . "' ";
				$url .= '&u_sts=' . $_REQUEST['u_sts'];
			}
			$where[] = "r.affiliate_id=" . $this->affiliate_id;
			$where[] = "r.payment=0";
			$current_page = (empty($_GET['af_list_item'])) ? 1 : $_GET['af_list_item'];
			$total_items = (int)$af_db->get_referrals(-1, -1, TRUE, '', '', $where);
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}

			$data['items'] = $af_db->get_referrals($limit, $offset, FALSE, 'date', 'DESC', $where);

			require AF_PATH . 'classes/AfPagination.class.php';
			$limit = 25;
			$pagination = new AfPagination(array(
														'base_url' => $url,
														'param_name' => 'af_list_item',
														'total_items' => $total_items,
														'items_per_page' => $limit,
														'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();
			$filter_url = add_query_arg('af_aff_subtab', 'referrals', $this->account_page_base_url);
			$data['filter'] = af_return_date_filter($filter_url,
														array(	0 => esc_html__('Rejected', 'openaffiliates'),
					 											1 => esc_html__('Pending', 'openaffiliates'),
					 											2 => esc_html__('Approved', 'openaffiliates'),
														),array());
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_referrals_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_referrals_title'];
			$data['stats'] = $af_db->get_stats_for_referrals('', $this->affiliate_id);
			$data['currency'] = afCurrency();

			$data['print_source_details'] = $af_db->is_magic_feat_enable('source_details');
			$data['source_details_url'] = add_query_arg('af_aff_subtab', 'source_details', $this->account_page_base_url);

			$data['full_referrals_url'] = $url = add_query_arg('af_aff_subtab', 'referrals_history', $this->account_page_base_url);

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-referrals.php';
			$searchFilename = 'account_page-referrals.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_payments(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$limit = 25;
			$url = add_query_arg('af_aff_subtab', 'payments', $this->account_page_base_url);
			$where = array();
			if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
				$_REQUEST['udf'] = sanitize_text_field( $_REQUEST['udf'] );
				$_REQUEST['udu'] = sanitize_text_field( $_REQUEST['udu'] );

				$where[] = " create_date>'" . $_REQUEST['udf'] . "' ";
				$where[] = " create_date<'" . $_REQUEST['udu'] . "' ";
				$url .= '&udf=' . $_REQUEST['udf'] . '&udu=' . $_REQUEST['udu'];
			}
			if (isset($_REQUEST['u_sts']) && $_REQUEST['u_sts']!=-1){
				$_REQUEST['u_sts'] = sanitize_text_field( $_REQUEST['u_sts'] );

				$where[] = " status='" . $_REQUEST['u_sts'] . "' ";
				$url .= '&u_sts=' . $_REQUEST['u_sts'];
			}

			$current_page = (empty($_GET['af_list_item'])) ? 1 : $_GET['af_list_item'];
			$total_items = (int)$af_db->get_transactions($this->affiliate_id, 0, 0, TRUE, '', '', $where);
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}
			require AF_PATH . 'classes/AfPagination.class.php';
			$limit = 25;
			$pagination = new AfPagination(array(
					'base_url' => $url,
					'param_name' => 'af_list_item',
					'total_items' => $total_items,
					'items_per_page' => $limit,
					'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();
			$data['listing_items'] = $af_db->get_transactions($this->affiliate_id, $limit, $offset, FALSE, '', '', $where);
			$filter_url = add_query_arg('af_aff_subtab', 'payments', $this->account_page_base_url);
			$data['filter'] = af_return_date_filter($filter_url,
														array(
																0 => esc_html__('Failed', 'openaffiliates'),
																1 => esc_html__('Pending', 'openaffiliates'),
					 											2 => esc_html__('Complete', 'openaffiliates'),
														),
														array()
			);
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_payments_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_payments_title'];
			$data['stats'] = $af_db->get_stats_for_payments($this->affiliate_id);
			$data['currency'] = afCurrency();
			$data['payment_settings_url'] = $url = add_query_arg('af_aff_subtab', 'payments_settings', $this->account_page_base_url);


			$fullPath = AF_PATH . 'public/views/account_page-payments.php';
			$searchFilename = 'account_page-payments.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_reports(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data = $af_db->get_stats_for_reports('', $this->affiliate_id);
			$data['achivements'] = $af_db->get_last_rank_achievements(-1, '', $this->affiliate_id);
			$data['currency'] = afCurrency();
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_reports_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true );
			$data['title'] = $this->account_page_settings['af_tab_reports_title'];
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-reports.php';
			$searchFilename = 'account_page-reports.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_payment_settings(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!empty($_POST['save_settings']) && !empty($_POST['af_payment_settings_nonce']) && wp_verify_nonce( $_POST['af_payment_settings_nonce'], 'af_payment_settings_nonce' ) ){
				if ($_POST['af_affiliate_payment_type']=='stripe_v2'){
					/// STRIPE V2
					$af_db->save_stripe_v2_meta_user_data($this->uid, $_POST); /// save meta
					require AF_PATH . 'classes/PayoutStripeV2.class.php';
					$stripe_v2 = new PayoutStripeV2();
					if (!empty($_POST['stripe_v2_meta_data']['stripe_v2_tos'])){
						$stripe_id = $stripe_v2->register_user($this->uid); /// register user to stripe
					}
					if (empty($stripe_id)){
						$data['errors'] = $stripe_v2->getErrorMessage();
						if (empty($data['errors'])){
								$data['errors'] = esc_html__('You must accept the \'Terms of service\' before saving the settings.', 'openaffiliates');
						}
					}
				} else if ($_POST['af_affiliate_payment_type']==='paypal'){
						if ( isset( $_POST['af_affiliate_paypal_email'] ) && !is_email( sanitize_email( $_POST['af_affiliate_paypal_email'] ) ) ){
								$data['errors'] = esc_html__( "The Email address that You provide it's not valid.", 'openaffiliates');
						}
				}
				if ( empty( $data['errors'] ) ){
						$af_db->save_affiliate_payment_settings($this->uid, $_POST);
				}

			}
			$data['metas'] = $af_db->get_affiliate_payment_settings($this->uid);
			$data['stripe_v2'] = $af_db->get_affiliate_stripe_v2_payment_settings($this->uid);
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_payments_settings_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true );
			$data['title'] = $this->account_page_settings['af_tab_payments_settings_title'];
			$data['payment_types'] = $af_db->get_payment_types_available();
			$data['stripe_card_types'] = array(
												'individual' => esc_html__('Individual', 'openaffiliates'),
												'corporation' => esc_html__('Corporation', 'openaffiliates'),
			);
			$this->print_top_messages();
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$fullPath = AF_PATH . 'public/views/account_page-payment_settings.php';
			$searchFilename = 'account_page-payment_settings.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_referrals_history(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$limit = 25;
			$url = add_query_arg('af_aff_subtab', 'referrals_history', $this->account_page_base_url);//// referrals
			$where = array();
			$data['filtered'] = FALSE;

			if (!empty($_REQUEST['udf']) && !empty($_REQUEST['udu'])){
				$data['filtered'] = TRUE;

				$_REQUEST['udf'] = sanitize_text_field( $_REQUEST['udf'] );
				$_REQUEST['udu'] = sanitize_text_field( $_REQUEST['udu'] );

				$where[] = " r.date>'" . $_REQUEST['udf'] . "' ";
				$where[] = " r.date<'" . $_REQUEST['udu'] . "' ";
				$url .= '&udf=' . $_REQUEST['udf'] . '&udu=' . $_REQUEST['udu'];
			}
			if (isset($_REQUEST['u_sts']) && $_REQUEST['u_sts']!=-1){
				$_REQUEST['u_sts'] = sanitize_text_field( $_REQUEST['u_sts'] );

				$where[] = " r.status='" . $_REQUEST['u_sts'] . "' ";
				$url .= '&u_sts=' . $_REQUEST['u_sts'];
			}
			$where[] = "r.affiliate_id=" . $this->affiliate_id;

			$current_page = (empty($_GET['af_list_item'])) ? 1 : $_GET['af_list_item'];
			$total_items = (int)$af_db->get_referrals(-1, -1, TRUE, '', '', $where);
			if ($current_page>1){
				$offset = ( $current_page - 1 ) * $limit;
			} else {
				$offset = 0;
			}
			if ($offset + $limit>$total_items){
				$limit = $total_items - $offset;
			}

			$data['items'] = $af_db->get_referrals($limit, $offset, FALSE, 'date', 'DESC', $where);

			require AF_PATH . 'classes/AfPagination.class.php';
			$limit = 25;
			$pagination = new AfPagination(array(
														'base_url' => $url,
														'param_name' => 'af_list_item',
														'total_items' => $total_items,
														'items_per_page' => $limit,
														'current_page' => $current_page,
			));
			$data['pagination'] = $pagination->output();
			$filter_url = add_query_arg('af_aff_subtab', 'referrals_history', $this->account_page_base_url);/// referrals
			$data['filter'] = af_return_date_filter($filter_url);

			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_referrals_history_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true );
			$data['title'] = $this->account_page_settings['af_tab_referrals_history_title'];
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-referrals_history.php';
			$searchFilename = 'account_page-referrals_history.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function run_help(){
			/*
			 * @param none
			 * @return string
			 */
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_help_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_help_title'];
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-help.php';
			$searchFilename = 'account_page-help.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function print_coupons(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_coupons_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_coupons_title'];
			$this->print_top_messages();
			$data['codes'] = $af_db->get_coupons_for_affiliate($this->affiliate_id);
			$data['currency'] = afCurrency();
			$current_rank_id = $af_db->get_affiliate_rank($this->affiliate_id);
			$data['rank_data'] = $af_db->get_rank( $current_rank_id );

			$fullPath = AF_PATH . 'public/views/account_page-coupons.php';
			$searchFilename = 'account_page-coupons.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function print_custom_affiliate_slug(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_custom_affiliate_slug_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_custom_affiliate_slug_title'];
			$data['slug_condition_min'] = get_option('af_custom_affiliate_slug_min_ch');
			$data['slug_condition_max'] = get_option('af_custom_affiliate_slug_max_ch');
			$data['slug_condition_rule'] = get_option('af_custom_affiliate_slug_rule');
			switch($data['slug_condition_rule']){
				case 1:
						$data['slug_condition_rule'] = esc_html__(' and must contains charatects and digits', 'openaffiliates');
						break;
				case 2: $data['slug_condition_rule'] = esc_html__(' and must contains one uppercase letter, charactes and digits', 'openaffiliates');
						break;
				default:
						$data['slug_condition_rule'] = '';
						break;
			}
			$this->print_top_messages();
			if (isset($_POST['af_affiliate_custom_slug'])){
				$saved = $af_db->save_custom_slug_for_uid($this->uid, $_POST['af_affiliate_custom_slug']);
			}
			$data['af_affiliate_custom_slug'] = $af_db->get_custom_slug_for_uid($this->uid);
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$fullPath = AF_PATH . 'public/views/account_page-custom_affiliate_slug.php';
			$searchFilename = 'account_page-custom_affiliate_slug.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function landing_pages()
		{
				global $wpdb, $af_db;
				$data['pages'] = $af_db->getLandingPagesForAffiliate($this->affiliate_id);
				$data['content'] = (isset($this->account_page_settings['af_tab_landing_pages_content'])) ? af_replace_constants($this->account_page_settings['af_tab_landing_pages_content'], $this->uid) : '';
				$data['title'] = (isset($this->account_page_settings['af_tab_landing_pages_title'])) ? af_replace_constants($this->account_page_settings['af_tab_landing_pages_title'], $this->uid) : '';
				$data['content'] = $this->clean_text($data['content']);
				$data['title'] = $this->clean_text($data['title']);

				$fullPath = AF_PATH . 'public/views/account_page-landing_pages.php';
				$searchFilename = 'account_page-landing_pages.php';
				$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

				require $template;
		}

		private function print_mlm_page(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_mlm_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true );
			$data['title'] = $this->account_page_settings['af_tab_mlm_title'];
			$this->print_top_messages();
			require AF_PATH . 'classes/MLMGetChildren.class.php';
			$children_object = new MLMGetChildren($this->affiliate_id);
			$data['items'] = $children_object->get_results();
			$data['af_affiliate_custom_slug'] = $af_db->get_custom_slug_for_uid($this->uid);
			$data['username'] = $af_db->get_username_by_wpuid($this->uid);

			$data['full_name'] = $af_db->get_full_name_of_user($this->affiliate_id);
			if($data['full_name'] == ''){
				 $data['full_name'] = $data['username'];
			}
			$data['id'] = $this->affiliate_id;
			$data['avatar'] = af_get_avatar_for_uid($this->uid);

			$data['parent'] = $af_db->mlm_get_parent($this->affiliate_id);
			if (empty($data['parent'])){
					$data['parent'] = '';
					$data['parent_id'] = '';
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

			$fullPath = AF_PATH . 'public/views/account_page-mlm.php';
			$searchFilename = 'account_page-mlm.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function print_wallet(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			$this->print_top_messages();
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_wallet_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_wallet_title'];
			$data['currency'] = afCurrency();

			$settings = $af_db->return_settings_from_wp_option('wallet');
			if (empty($_GET['add_new'])){
				//// LISTING
				$hash_check = get_user_meta($this->uid, 'af_wallet_hash', TRUE);
				if (!empty($_POST['afcheck']) && !empty($hash_check) // isset($_POST['save']) &&
							&& $hash_check==$_POST['afcheck'] && !empty($_POST['referrals'])){
					$_POST['referrals'] = sanitize_text_field( $_POST['referrals'] );
					$_POST['service_type'] = sanitize_text_field( $_POST['service_type'] );
					$referral_list = explode(',', $_POST['referrals']);
					$af_db->create_wallet_item($_POST['service_type'], $referral_list, $this->affiliate_id);
					update_user_meta($this->uid, 'af_wallet_hash', '');
				}
				$eclude_sources = isset($settings['af_wallet_exclude_sources']) ? $settings['af_wallet_exclude_sources'] : '';
				$data['stats'] = $af_db->get_stats_for_payments($this->affiliate_id, $eclude_sources);
				$data['items'] = $af_db->get_all_wallet_items_for_affiliate($this->affiliate_id);
				$data['stats']['wallet'] = 0;
				if ($data['items']){
					foreach ($data['items'] as $item){
						$data['stats']['wallet'] += $item['amount'];
					}
				}
				$base_url = add_query_arg('af_aff_subtab', 'wallet', $this->account_page_base_url);
				$data['add_new'] = add_query_arg('add_new', 'true', $base_url);
				require AF_PATH . 'public/views/wallet.php';
			} else {
				/// ADD NEW
				$data['form_action'] = add_query_arg('af_aff_subtab', 'wallet', $this->account_page_base_url);
				$data['services'] = af_get_active_services();
				if (!empty($settings['af_wallet_exclude_sources']) && $settings['af_wallet_exclude_sources']!=-1){
						$excluded_sevices = explode(',', $settings['af_wallet_exclude_sources']);
						foreach ($excluded_sevices as $service_type){
								if (isset($data['services'][$service_type])){
									 unset($data['services'][$service_type]);
								}
						}
				}
				$where[] = "r.payment=0 ";
				$where[] = "r.status=2 ";
				$where[] = "r.affiliate_id=" . $this->affiliate_id;

				//if (!empty($settings['af_wallet_exclude_sources'])){
				//		$where [] = "r.source NOT IN ('{$settings['af_wallet_exclude_sources']}')";
				//}

				$data['referrals'] = $af_db->get_referrals(-1, -1, FALSE, '', '', $where);
				$data['hash'] = time() . $this->uid;
				update_user_meta($this->uid, 'af_wallet_hash', $data['hash']);

				$fullPath = AF_PATH . 'public/views/wallet-add_new.php';
				$searchFilename = 'wallet-add_new.php';
				$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

				require $template;
			}

		}


		private function print_referral_notifications(){
			/*
			 * @param none
			 * @return string
			 */
			global $af_db;
			if (!$af_db->is_magic_feat_enable('referral_notifications') && !$af_db->is_magic_feat_enable('periodically_reports')){
				return;///out
			}
			if (!empty($_POST['save_settings'])){
				$af_db->save_meta_user_options('user_notifications', $this->uid, $_POST);

				/// REPORTS
				if($af_db->is_magic_feat_enable('periodically_reports')){
				$data['report_settings'] = $af_db->affiliate_get_report_settings($this->affiliate_id);
				if ($data['report_settings']['period']!=$_POST['period']){
					/// a change was made so we must do update
					if ($_POST['period']>0){
						/// enable the reports
						$array['affiliate_id'] = $this->affiliate_id;
						$array['email'] = $af_db->get_email_by_uid($this->uid);
						$array['period'] = sanitize_text_field($_POST['period']);
						$af_db->save_affiliate_report_settings($this->affiliate_id, $array);
					} else {
						$af_db->delete_affiliate_report_settings($this->affiliate_id);
					}
				}
				}
			}
			$data['message'] = af_replace_constants($this->account_page_settings['af_tab_referral_notifications_content'], $this->uid);
			$data['message'] = stripslashes($data['message']);
			$data['message'] = af_correct_text($data['message'], true);
			$data['title'] = $this->account_page_settings['af_tab_referral_notifications_title'];
			$data['metas'] = $af_db->af_get_meta_user_options('user_notifications', $this->uid);
			$data['module_settings_notf'] = $af_db->return_settings_from_wp_option('referral_notifications');
			$data['module_settings_reports'] = $af_db->return_settings_from_wp_option('periodically_reports');
			$data['report_settings'] = $af_db->affiliate_get_report_settings($this->affiliate_id);

			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-referral_notifications.php';
			$searchFilename = 'account_page-referral_notifications.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}

		private function print_source_details(){
			/*
			 * @param none
			 * @return string
			 */
			$this->print_top_messages();
			$referral_id = (empty($_GET['reference'])) ? 0 : sanitize_text_field($_GET['reference']);
			global $af_db;
			$data['fields_data'] = $af_db->get_source_details_for_reference($referral_id);
			$data['all_fields'] = array(
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

			$fullPath = AF_PATH . 'public/views/account_page-source_details.php';
			$searchFilename = 'account_page-source_details.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}


		/*
		 * @param none
		 * @return none
		 */
		private function print_pushover_notifications(){
			global $current_user;
			// 8.6
			if ( isset( $this->uid ) && $this->uid > 0 ){
					$uid = $this->uid;
			} else {
					$uid = empty($current_user->ID) ? 0 : $current_user->ID;
			}
			// 8.6

			if (!empty($_POST['af_pushover_token'])){
					$_POST['af_pushover_token'] = sanitize_text_field( $_POST['af_pushover_token'] );
					update_user_meta($uid, 'af_pushover_token', $_POST['af_pushover_token']);
			}
			$data['af_pushover_token'] = get_user_meta($uid, 'af_pushover_token', TRUE);
			$data['content'] = (isset($this->account_page_settings['af_tab_pushover_notifications_content'])) ? af_replace_constants($this->account_page_settings['af_tab_pushover_notifications_content'], $this->uid) : '';
			$data['title'] = (isset($this->account_page_settings['af_tab_pushover_notifications_title'])) ? af_replace_constants($this->account_page_settings['af_tab_pushover_notifications_title'], $this->uid) : '';
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$this->print_top_messages();

			$fullPath = AF_PATH . 'public/views/account_page-pushover_notifications.php';
			$searchFilename = 'account_page-pushover_notifications.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}


		/*
		 * @param none
		 * @return string
		 */
		private function run_simple_links(){
			global $af_db;
			if ( isset( $_GET['message'] ) ){
				if ( $_GET['message']==0 ){
					$data['err'] = esc_html__('Your Referrer Link can not be registered.', 'openaffiliates');
				} else if ($_GET['message']==-1){
					$data['err'] = esc_html__('This Referrer Link already exist. Please submit a different one.', 'openaffiliates');
				}
			}

			if (!empty($_GET['del'])){
				$_GET['del'] = sanitize_text_field( $_GET['del'] );
				$af_db->simple_links_delete_link($_GET['del']);
			}
			$data['max_limit'] = get_option('af_simple_links_limit');
			$data['url'] = remove_query_arg('del', $this->current_url);
			$data['url'] = remove_query_arg('message', $this->current_url);
			$data['items'] = $af_db->simple_links_get_items_for_affiliate($this->affiliate_id);
			$data['content'] = (isset($this->account_page_settings['af_tab_simple_links_content'])) ? af_replace_constants($this->account_page_settings['af_tab_simple_links_content'], $this->uid) : '';
			$data['title'] = (isset($this->account_page_settings['af_tab_simple_links_title'])) ? af_replace_constants($this->account_page_settings['af_tab_simple_links_title'], $this->uid) : '';
			$this->print_top_messages();
			if($this->preview){
				$data['preview'] = TRUE;
			}
			$fullPath = AF_PATH . 'public/views/account_page-simple_links.php';
			$searchFilename = 'account_page-simple_links.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}


		/*
		 * @param string
		 * @return string
		 */
		private function run_custom_tab($tab=''){
			$key = $tab;
			$data['content'] = (isset($this->account_page_settings['af_tab_' . $key . '_content'])) ? af_replace_constants($this->account_page_settings['af_tab_' . $key . '_content'], $this->uid) : '';
			$data['title'] = (isset($this->account_page_settings['af_tab_' . $key . '_title'])) ? af_replace_constants($this->account_page_settings['af_tab_' . $key . '_title'], $this->uid) : '';
			$data['content'] = $this->clean_text($data['content']);
			$data['title'] = $this->clean_text($data['title']);

			$fullPath = AF_PATH . 'public/views/account_page-custom_tab.php';
			$searchFilename = 'account_page-custom_tab.php';
			$template = apply_filters('af_filter_on_load_template', $fullPath, $searchFilename );

			require $template;
		}


		/*
		 * @param string
		 * @return stirng
		 */
		private function clean_text($string=''){
			/*
			 * @param string
			 * @return string
			 */
			 return stripslashes($string);
		}

		private function iab_settings()
		{
				global $af_db;
				if ( !empty($_POST['save']) && !empty($_POST['af_iab_settings_nonce']) && wp_verify_nonce( $_POST['af_iab_settings_nonce'], 'af_iab_settings_nonce' ) ){
						$af_db->saveIabUserSettings( $this->uid, $_POST );
				}
				$data['settings'] = $af_db->getIabUserSettings( $this->uid );
				$data['content'] = (isset($this->account_page_settings['af_tab_iab_settings_content'])) ? af_replace_constants($this->account_page_settings['af_tab_iab_settings_content'], $this->uid) : '';
				$data['title'] = (isset($this->account_page_settings['af_tab_iab_settings_title'])) ? af_replace_constants($this->account_page_settings['af_tab_iab_settings_title'], $this->uid) : '';
				$data['content'] = $this->clean_text($data['content']);
				$data['title'] = $this->clean_text($data['title']);
				$fullPath = AF_PATH . 'public/views/account_page-iab_settings.php';
				$searchFilename = 'account_page-iab_settings.php';
				$template = apply_filters( 'af_filter_on_load_template', $fullPath, $searchFilename );
				$viewObject = new \OpenAffiliates\AfView();
				$output = $viewObject->setTemplate( $template )->setContentData( $data )->getOutput();
				echo esc_af_content($output);
		}

		public function setPreview( $input=false )
		{
				$this->preview = $input;
				return $this;
		}

		public function isPreview()
		{
				return $this->preview;
		}

	}//end class
}//end if
