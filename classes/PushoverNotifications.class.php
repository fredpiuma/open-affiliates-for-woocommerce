<?php
if (!class_exists('PushoverNotifications')):

class PushoverNotifications{

	/*
	 * @param none
	 * @return none
	 */
	public function __construct(){
		require_once AF_PATH . 'classes/Pushover.class.php';
	}

	/*
	 * @param int, int, string, boolean
	 * @return boolean
	 */
	public function send_notification($uid=0, $rank=-1, $notification_type='', $send_to_admin=FALSE){
		if ($notification_type){
			global $af_db;
			$notification_data = $this->get_notification_data($notification_type, $rank);

			if ($notification_data && !empty($notification_data['pushover_status']) && !empty($notification_data['pushover_message'])){
				$meta = $af_db->return_settings_from_wp_option('pushover');
				$message = stripslashes($notification_data['pushover_message']);
				$message = af_replace_constants($message, $uid);
				$title = $notification_data['subject'];
				$title = af_replace_constants($title, $uid);

				$push = new Pushover();
				$app_token = get_option('af_pushover_app_token');
				if ($uid && !$send_to_admin){
					$user_token = get_user_meta($uid, 'af_pushover_token', TRUE);	/// USER
				} else {
					$user_token = $meta['af_pushover_admin_token'];  /// ADMIN
				}
				$sound = get_option('af_pushover_sound');
				$sound = empty($meta['af_pushover_sound']) ? 'bike' : $meta['af_pushover_sound'];
				$url = empty($meta['af_pushover_url']) ? '' : $meta['af_pushover_url'];
				$url_title = empty($meta['af_pushover_url_title']) ? '' : $meta['af_pushover_url_title'];

				$push->setToken($app_token);
				$push->setUser($user_token);
				$push->setTitle($title);
				$push->setMessage($message);
				$push->setUrl($url);
				$push->setUrlTitle($url_title);
				$push->setPriority(2); /// 0 || 1 || 2
				$push->setRetry(300); /// five minutes
				$push->setExpire(3600); /// one hour
				$push->setTimestamp(time());
				$push->setDebug(FALSE);
				$push->setSound($sound);
				return $push->send();
			}
		}
		return FALSE;
	}

	/*
	 * @param string
	 * @return array
	 */
	private function get_notification_data($type='', $rank=-1){
		global $wpdb;
		$table = $wpdb->prefix . "af_notifications";
		$q = $wpdb->prepare("SELECT id,type,rank_id,subject,message,pushover_message,pushover_status,status FROM $table
									WHERE
									type=%s
									AND rank_id=%d
									ORDER BY id DESC LIMIT 1;", $type, $rank);
		$data = $wpdb->get_row($q);
		if (empty($data)){
			$q = $wpdb->prepare("SELECT id,type,rank_id,subject,message,pushover_message,pushover_status,status FROM $table
										WHERE
										type=%s
										AND rank_id=-1
										ORDER BY id DESC LIMIT 1;", $type);
			$data = $wpdb->get_row($q);
		}
		return (array)$data;
	}

	public function sendCustom($title='', $message='', $uid=0)
	{
		global $af_db;
		$meta = $af_db->return_settings_from_wp_option('pushover');
		$message = stripslashes($message);
		$title = stripslashes($title);
		$message = af_replace_constants($message, $uid);
		$title = af_replace_constants($title, $uid);

		$push = new Pushover();
		$app_token = get_option('af_pushover_app_token');
		$user_token = get_user_meta($uid, 'af_pushover_token', TRUE);	/// USER
		$sound = get_option('af_pushover_sound');
		$sound = empty($meta['af_pushover_sound']) ? 'bike' : $meta['af_pushover_sound'];
		$url = empty($meta['af_pushover_url']) ? '' : $meta['af_pushover_url'];
		$url_title = empty($meta['af_pushover_url_title']) ? '' : $meta['af_pushover_url_title'];

		$push->setToken($app_token);
		$push->setUser($user_token);
		$push->setTitle($title);
		$push->setMessage($message);
		$push->setUrl($url);
		$push->setUrlTitle($url_title);
		$push->setPriority(2); /// 0 || 1 || 2
		$push->setRetry(300); /// five minutes
		$push->setExpire(3600); /// one hour
		$push->setTimestamp(time());
		$push->setDebug(FALSE);
		$push->setSound($sound);
		return $push->send();
	}

}

endif;
