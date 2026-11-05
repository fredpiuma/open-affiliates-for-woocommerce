<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Admin Referral Notifications', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
					<h2><?php esc_html_e('Activate/Hold Admin Referral Notifications', 'openaffiliates');?></h2>
					<p><?php esc_html_e('If this module is activated, admins have the option to receive instant notifications when an affiliate gets a new referral.', 'openaffiliates');?></p>
					<label class="af_bp_account_page_enable  af-switch-button-margin">
					<?php $checked = ($data['metas']['af_admin_referral_notifications_enable']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_admin_referral_notifications_enable');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_admin_referral_notifications_enable" value="<?php echo esc_attr($data['metas']['af_admin_referral_notifications_enable']);?>" id="af_admin_referral_notifications_enable" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
					<h4><?php esc_html_e('Notification Subject', 'openaffiliates');?></h4>
					<div class="input-group">
					<span class="input-group-addon" id="basic-addon1"><?php esc_html_e('Subject', 'openaffiliates');?></span>
					<input type="text" class="af-field-text-with-padding form-control" name="af_admin_referral_notification_subject" value="<?php echo esc_attr($data['metas']['af_admin_referral_notification_subject']);?>"/>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h4><?php esc_html_e('Notification Content', 'openaffiliates');?></h4>
					<div class="af-wp_editor af-wp-editor-box">
					<?php wp_editor(stripslashes($data['metas']['af_admin_referral_notification_content']), 'af_admin_referral_notification_content', array('textarea_name'=>'af_admin_referral_notification_content', 'editor_height'=>400));?>
					</div>
					<div class="af-wp-editor-constants">
						<?php echo esc_af_content("<h4>" . esc_html__('Referral details Tags', 'openaffiliates') . "</h4>"); ?>
						<?php foreach ($data['notification_constants'] as $key=>$value) : ?>
							<div ><?php echo esc_af_content('<span><strong>'.$value . '</strong></span> : ') . $key;?></div>
						<?php endforeach; ?>
							<div ><?php echo esc_af_content('<span><strong>' . esc_html__('WooCommerce Order Details', 'openaffiliates') . '</strong></span> : {WOOCOMMERCE_ORDER_DETAILS}');?></div>
						<?php
						echo esc_af_content("<h4>" . esc_html__('Native Fields Tags', 'openaffiliates') . "</h4>");
							$constants = array(	"{username}",
												"{first_name}",
												"{last_name}",
												"{user_id}",
												"{user_email}",
												"{account_page}",
												"{login_page}",
												"{blogname}",
												"{blogurl}",
												"{siteurl}",
												'{rank_id}',
												'{rank_name}',
							);
							$extra_constants = af_get_custom_constant_fields();
							foreach ($constants as $v){
								?>
								<div><?php echo esc_html($v);?></div>
								<?php
							}
							echo esc_af_content("<h4>" . esc_html__('Custom Fields Tags', 'openaffiliates') . "</h4>");
							foreach ($extra_constants as $k=>$v){
								?>
								<div><?php echo esc_html($k);?></div>
								<?php
							}

						?>
					</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
		</div>
	</div>
</form>
</div>
