<?php
if (!class_exists('BuddyPressCustomMenuItem')):

	class BuddyPressCustomMenuItem{
		private $metas = array();
		private $is_affiliate = FALSE;

		public function __construct(){
			/*
			 * ALL THE ACTIONS & FILTERS
			 * @param none
			 * @return none
			 */
			add_action('bp_setup_nav', array($this, 'do_setup_bp_nav'), 99);
		}

		public function do_setup_bp_nav(){
			/*
			 * @param
			 * @return
			 */
			global $af_db;
			global $current_user;
			$this->metas = $af_db->return_settings_from_wp_option('bp_account_page');
			if (!empty($current_user) && !empty($current_user->ID)){
				$this->is_affiliate = $af_db->is_user_affiliate_by_uid($current_user->ID);
			}

			if (!$this->is_affiliate && !$this->metas['af_bp_account_page_show_to_everyone']){
				return;/// OUT
			}

			global $bp;

			bp_core_new_nav_item( array(
					'name' => $this->metas['af_bp_account_page_name'],
					'slug' => 'af',
					'position' => $this->metas['af_bp_account_page_position'],
					'show_for_displayed_user' => false,
					'screen_function' => 'af_bp_content_action',
					'item_css_id' => 'af',
					'default_subnav_slug' => 'af'
				)
			);
			bp_core_new_subnav_item( array(
					'name' => esc_html__('Open Affiliates', 'openaffiliates'),
					'slug' => 'af',
					'show_for_displayed_user' => false,
					'parent_url' => trailingslashit( bp_displayed_user_domain() . 'af'),
					'parent_slug' => 'af',
					'position' => $this->metas['af_bp_account_page_position'],
					'screen_function' => array($this, 'af_bp_content_action'),
					'item_css_id' => 'af',
					'user_has_access' => bp_is_my_profile()
				)
			);
		}


		public function af_bp_content_action(){
			/*
			 * @param none
			 * @return none
			 */
			 add_action('bp_template_content', array($this, 'af_bp_do_the_content'));
			 bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
		}

		public function af_bp_do_the_content(){
			/*
			 * @param none
			 * @return
			 */
			 if ($this->is_affiliate){
			 	echo do_shortcode('[af-account-page]');
			 } else {
		 		/// non affiliates
		 		echo stripslashes($this->metas['af_bp_account_page_non_affiliate_content']);
		 	}
		}

	}

endif;
