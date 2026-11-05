<div class="af-wrapper">
	<div>
		<div class="af-page-title">
			<?php esc_html_e('Manage Showcases', 'openaffiliates');?>
		</div>
		<div class="metabox-holder af">
			<div class="af-popup-content showcases-wrapp af-text-align-center">
		        <div class="af-showcases-wrapper">
			    	<a href="<?php echo esc_url($data['url_register_settings']);?>"><div class="af-popup-shortcodevalue"><i class="fa-af fa-user-plus-af"></i><?php esc_html_e('Registration Form', 'openaffiliates');?><span><?php esc_html_e('Templates, Custom Fields, Special Settings, Custom Messages', 'openaffiliates');?></span></div></a>
			        <a href="<?php echo esc_url($data['url_login']);?>"><div class="af-popup-shortcodevalue"><i class="fa-af fa-sign-in-af"></i><?php esc_html_e('Login Form', 'openaffiliates');?><span><?php esc_html_e('Templates, Display Options, Custom Messages', 'openaffiliates');?></span></div></a>
			        <a href="<?php echo esc_url($data['url_account_page']);?>"><div class="af-popup-shortcodevalue"><i class="fa-af fa-user-af"></i><?php esc_html_e('Affiliate Portal', 'openaffiliates');?><span><?php esc_html_e('Templates, ShowUp fields, ShowUp Tabs, Predefined Overview', 'openaffiliates');?></span></div>  </a>
					<a href="<?php echo esc_url($data['url_top_affiliates']);?>"><div class="af-popup-shortcodevalue"><i class="fa-af fa-top-affiliates-af"></i><?php esc_html_e('Top Affiliates', 'openaffiliates');?><span><?php esc_html_e('Public Affiliates List ordered by Earnings, Referrals or Visits', 'openaffiliates');?></span></div>  </a>
					<div class="af-clear"></div>
		        </div>
		    </div>
		</div>
	</div>


</div>
