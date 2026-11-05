<?php
if (!class_exists('AffiliateLogin')){
	class AffiliateLogin{

		public function __construct(){}

		public function print_login_form($args=array(), $user_role='unreg', $affiliate_id=0){
			/*
			 * @param array
			 * @return none
			 */
			global $af_db;
			$meta_arr = $af_db->return_settings_from_wp_option('login');
			foreach ($meta_arr as $key=>$value){
				if (isset($args[$key])){
					$meta_arr[$key] = $args[$key];
				}
			}

			///////////// LOGIN FORM
			require_once AF_PATH . 'public/views/login_form.php';
			$str = '';
			$msg = '';



			//print the message
			if (!empty($_GET['af_success_login'])){
				/************************** SUCCESS ***********************/
				$msg .= get_option('af_login_succes');
				if (!empty($msg)){
					$str .= '<div class="af-login-success">' . af_correct_text($msg) . '</div>';
				}
			} else if (!empty($_GET['af_pending_email'])){
				/************************ PENDING EMAIL ********************/
				$arr = $af_db->return_settings_from_wp_option('login-messages', false, true);
				if (isset($arr['af_login_error_email_pending']) && $arr['af_login_error_email_pending']){
					$login_faild = $arr['af_login_error_email_pending'];
				} else {
					$login_faild = esc_html__('Error', 'openaffiliates');
				}
				$str .= '<div class="af-login-error">' . af_correct_text($login_faild) . '</div>';
			} else if (!empty($_GET['af_login_fail'])){
				/************************** FAIL *****************************/
				$login_faild = af_correct_text(get_option('af_login_error'));
				if (empty($login_faild)){
					$arr = $af_db->return_settings_from_wp_option('login-messages', false, true);
					if (isset($arr['af_login_error']) && $arr['af_login_error']){
						$login_faild = $arr['af_login_error'];
					} else {
						$login_faild = esc_html__('Error', 'openaffiliates');
					}
				}
				$str .= '<div class="af-login-error">' . af_correct_text($login_faild) . '</div>';
			} else if (!empty($_GET['af_login_pending'])){
				/*********************** PENDING ******************************/
				$str .= '<div class="af-login-pending">' . af_correct_text(get_option('af_login_pending')) . '</div>';
			} else if (!empty($_GET['af_fail_captcha'])){
				$login_faild = af_correct_text(get_option('af_login_error_on_captcha'));
				if (!$login_faild){
					$login_faild = esc_html__('Captcha Error', 'openaffiliates');
				}
				$str .= '<div class="af-login-error-wrapper"><div class="af-login-error">' . $login_faild . '</div></div>';
			}

			if ($affiliate_id){
				if ($user_role!='unreg'){
					////////////REGISTERED USER
					if ($user_role=='pending'){
						//pending user
						$msg = af_correct_text(get_option('af_register_pending_user_msg', true));
						if ($msg){
							$str .= '<div class="af-login-pending">' . $msg . '</div>';
						}
					}
				} else {
					/////////////UNREGISTERED
					$str .= af_print_form_login($meta_arr);
				}
			} else {
				/// NOT AFFILIATE
				$str .= af_print_form_login($meta_arr);
			}

			return $str;
		}

		public function do_login($url=''){
			/*
			 * @param none
			 * @return int (user id)
			 */
			global $af_db;
			if (!empty($_POST['log']) && !empty($_POST['pwd'])){

				/// CHECK RECAPTCHA
				if (get_option('af_login_show_recaptcha')){
					$this->check_recaptcha($url);
				}

				$arr['user_login'] = sanitize_user($_POST['log']);
				$arr['user_password'] = sanitize_text_field($_POST['pwd']);
				$arr['remember'] = ( isset( $_POST['rememberme'] ) == 'forever' ) ? true : false;
				$user = wp_signon($arr, true);
				if (!is_wp_error($user)){

					//============== Check E-mail verification status
					$this->af_check_email_verification_status($user->ID, $url);

					/// CHECK IF USER IT's AFFILIATE
					$affiliate_id = $af_db->affiliate_get_id_by_uid($user->ID);

					if (!$affiliate_id){
						/// NOT AFFILIATE ERROR
						wp_clear_auth_cookie();//logout
						do_action( 'wp_logout' );
						nocache_headers();
						$url = add_query_arg( array('af_login_fail'=>'true'), $url );
						wp_redirect( $url );
						exit();
					} else if ($affiliate_id && isset($user->roles[0]) && $user->roles[0]=='pending_user'){
						//=================== PENDING USER
						wp_clear_auth_cookie();//logout
						do_action( 'wp_logout' );
						nocache_headers();
						$url = add_query_arg( array('af_login_pending' => 'true'), $url );
						wp_redirect( $url );
						exit();
					} else {
						//================== LOGIN SUCCESS
						$url = add_query_arg( array( 'af_success_login' => 'true' ), $url );
						$redirect_p_id = get_option('af_general_login_redirect');
						if ($redirect_p_id && $redirect_p_id!=-1){
							$redirect_url = get_permalink($redirect_p_id);
							if ($redirect_url){
								wp_redirect( $redirect_url );
								exit();
							}
						}
						wp_redirect( $url );
						exit();
					}
				}
				if($user->get_error_message() == 'Pending User'){
					wp_clear_auth_cookie();//logout
					do_action( 'wp_logout' );
					nocache_headers();

					$url = add_query_arg( array('af_login_pending' => 'true'), $url );
					wp_redirect( $url );
					exit();
				}
			}

			//===================== LOGIN FAILD
			$url = add_query_arg( array('af_login_fail'=>'true'), $url );
			wp_redirect( $url );
			exit();
		}


		public function af_check_email_verification_status($uid = 0, $redirect_url=''){
			/*
			 * logout and redirect if verification status is -1
			 * @param int, string
			 * @return none
			 */
			if (get_option('af_register_double_email_verification')){
				$email_verification = get_user_meta($uid, 'af_verification_status', TRUE);
				if ($email_verification==-1){
					wp_clear_auth_cookie();//logout
					do_action( 'wp_logout' );
					nocache_headers();
					if (!$redirect_url){
						$redirect_url = home_url();
					}
					$redirect_url = add_query_arg(array('af_pending_email'=>'true'), $redirect_url);
					wp_redirect( $redirect_url );
					exit();
				}
			}
		}

		private function check_recaptcha($url='')
		{
				$type = get_option( 'af_recaptcha_version' );
				if ( $type !== false && $type == 'v3' ){
						 $secret = get_option('af_recaptcha_private_v3');
				} else {
						 $secret = get_option('af_recaptcha_private');
				}

				if ($secret){
					if (isset($_POST['g-recaptcha-response'])){
						if (!class_exists('ReCaptcha')){
							require_once AF_PATH . 'classes/services/recaptcha/autoload.php';
						}
						$recaptcha = new \ReCaptcha\ReCaptcha($secret);
						$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
						if (!$resp->isSuccess()){
							$captcha_error = TRUE;
						}
					} else {
						$captcha_error = TRUE;
					}
				}
				if (!empty($captcha_error)){
					$url = add_query_arg( array('af_fail_captcha'=>'true'), $url );
					wp_redirect( $url );
					exit();
				}
		}


	}//end of class
}//endif
