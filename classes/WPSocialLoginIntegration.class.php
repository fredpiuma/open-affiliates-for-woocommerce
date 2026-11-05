<?php
if (!class_exists('WPSocialLoginIntegration')):

class WPSocialLoginIntegration{

	public function __construct(){}

	public static function run(){
		/*
		 * @param none
		 * @return none
		 */
		 global $af_db;
		 if ($af_db->is_magic_feat_enable('wp_social_login')){
		 	 add_action('wsl_hook_process_login_before_wp_safe_redirect', array('Af_Wp_Social_Login_Integration', 'af_wp_social_login_do_redirect'), 92, 0);
		 	 add_action('wsl_hook_process_login_after_wp_insert_user', array('Af_Wp_Social_Login_Integration', 'af_wp_social_login_after_register_action'), 90, 3);
		 }
	}

	public static function af_wp_social_login_do_redirect(){
		/*
		 * @param none
		 * @return none, will do redirect if it's case
		 */
		$redirect = get_option('af_wp_social_login_redirect_page');
		if ($redirect && $redirect!=-1){
			$url = get_permalink($redirect);
			if (!empty($url)){
				wp_safe_redirect($url);
				die();
			}
		}
	}

	public static function af_wp_social_login_after_register_action($user_id=0, $provider='', $hybridauth_user_profile=''){
		/*
		 * @param none
		 * @return none
		 */
		if ($user_id){
			global $af_db;
			/// save user to affiliate db
			$af_db->save_affiliate($user_id);
			/// rank
			$rank = get_option('af_wp_social_login_default_rank');
			if ($rank){
				$af_db->update_affiliate_rank_by_uid($user_id, $rank);
			}
			/// STORE AVATAR
	 		if (!empty($hybridauth_user_profile) && !empty($hybridauth_user_profile->photoURL)){
	 			update_user_meta($user_id, 'af_avatar', $hybridauth_user_profile->photoURL);
	 		}
			///ROLE
			$role = get_option('af_wp_social_login_default_role');
			if ($role){
				$u = new WP_User($user_id);
				$u->set_role($role);
			}
		}
	}

}

endif;
