<?php
namespace OpenAffiliates\Services;
class Af_Native extends \Referral_Main{
	private $source_type = 'af';
	private static $affiliate_from_coupon = 0;
	private static $checkout_referrals_select_settings = array();
	private static $check_require_error = FALSE;

	public function __construct(){


    $this->check_for_selected_affiliate();
    add_action('af_register_form_before_submit_button', [$this, 'insert_affiliate_select']);
    add_filter('af_register_process_filter_errors', [$this, 'check_require'], 1, 1 );

	}


	public function check_for_selected_affiliate(){
		 global $af_db;
		 if (empty(self::$checkout_referrals_select_settings)){
		 	self::$checkout_referrals_select_settings = $af_db->return_settings_from_wp_option('checkout_select_referral');
		 }
		 if (self::$checkout_referrals_select_settings['af_checkout_select_referral_enable']){
		 	if (!empty($_POST['af_affiliate_username'])){
		 		self::$affiliate_id = sanitize_text_field($_POST['af_affiliate_username']);
		 	} else if (!empty($_POST['af_affiliate_username_text'])){
				$_POST['af_affiliate_username_text'] = sanitize_text_field( $_POST['af_affiliate_username_text'] );
		 		$temp = $af_db->get_affiliate_id_by_username($_POST['af_affiliate_username_text']);
				if ($temp){
					self::$affiliate_id = $temp;
				}
		 	}
		 }
	}

	public function insert_affiliate_select($output='', $is_public=FALSE){
		 global $af_db;
		 $string = '';
		 if (empty(self::$checkout_referrals_select_settings)){
		 	self::$checkout_referrals_select_settings = $af_db->return_settings_from_wp_option('checkout_select_referral');
		 }
		 /// check it's enable
		 if (self::$checkout_referrals_select_settings['af_checkout_select_referral_enable']){ ///  && $is_public
		 	$this->set_affiliate_id();
		 	if (self::$affiliate_id && !self::$checkout_referrals_select_settings['af_checkout_select_referral_rewrite']){
		 		return $output; /// OUT
		 	}
			$who = self::$checkout_referrals_select_settings['af_checkout_select_affiliate_list'];
			$type = self::$checkout_referrals_select_settings['af_checkout_select_referral_name'];
			$data['affiliates'] = $af_db->get_affiliates_for_checkout_select($who, $type);
			if ( get_option( 'af_checkout_select_referral_require', 0 ) != 0 ){
					$data['require'] = '<span class="af-color-red">*</span>';
			} else {
					$data['require'] = '';
			}
			$data['class'] = 'af-form-line-register';
			$data['select_class'] = '';
			$data['input_class'] = '';
			$data['require_on_input'] = '';
			ob_start();
			require_once AF_PATH . 'public/views/checkout_referral_select.php';
			$string = ob_get_contents();
			ob_end_clean();
		 }
		 if (!empty(self::$check_require_error)){
		 	$string .= '<div class="af-register-notice">' . esc_html__('Please complete all required fields!', 'openaffiliates') . '</div>';
		 }
		 echo esc_af_content($output . $string);
	}

	public function check_require($errors){
	 	 global $af_db;
		 if (empty(self::$checkout_referrals_select_settings)){
		 	self::$checkout_referrals_select_settings = $af_db->return_settings_from_wp_option('checkout_select_referral');
		 }

		 /// REQUIRE
		 if (self::$checkout_referrals_select_settings['af_checkout_select_referral_require']){
			 /// will not print 1, just to stop the form submiting
			 if (isset($_POST['af_affiliate_username']) && $_POST['af_affiliate_username']==''){
			 	$errors['af_affiliate_username'] = 1;
			 	self::$check_require_error = TRUE;
			 } else if (isset($_POST['af_affiliate_username_text']) && $_POST['af_affiliate_username_text']==''){
			 	$errors['af_affiliate_username_text'] = 1;
			 	self::$check_require_error = TRUE;
			 }
		 }

		 ///
		 if (isset($_POST['af_affiliate_username_text']) && $_POST['af_affiliate_username_text']!=''){
			 $_POST['af_affiliate_username_text'] = sanitize_text_field( $_POST['af_affiliate_username_text'] );
		 	 $affiliate_id = $af_db->get_affiliate_id_by_username($_POST['af_affiliate_username_text']);
			 if (!$affiliate_id){
				 $errors['af_affiliate_username_text'] = 1;
				 self::$check_require_error = TRUE;
			 }
		 }

		 return $errors;
	}

}
