<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Admin Workflow Settings', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-12">
						<h2><?php esc_html_e('Update Frequency', 'openaffiliates');?></h2>
						<p><?php esc_html_e('Affiliate performances are regularly verified, and their Ranks are automatically updated through scheduled cron processes. Payouts are also periodically reviewed.', 'openaffiliates');?></p>
					</div>
				</div>
		</div>
		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
							<span class="af-labels-special"><?php esc_html_e('Update Affiliates Rank:', 'openaffiliates');?></span>
							<select name="af_update_ranks_interval" class="form-control m-bot15"><?php
								$values = array(
													'hourly' => esc_html__('Hourly', 'openaffiliates'),
													'twicedaily' => esc_html__('At every 12hours', 'openaffiliates'),
													'daily' => esc_html__('Daily', 'openaffiliates'),
								);
								foreach ($values as $k=>$v){
									$selected = ($data['metas']['af_update_ranks_interval']==$k) ? 'selected' : '';
									?>
									<option value="<?php echo esc_attr( $k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
									<?php
								}
							?></select>
						</div>
					</div>
			</div>
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-6">
							<span class="af-labels-special"><?php esc_html_e('Update Payments Status:', 'openaffiliates');?></span>
							<select name="af_update_payments_status" class="form-control m-bot15"><?php
								$values = array(
													'hourly' => esc_html__('Hourly', 'openaffiliates'),
													'twicedaily' => esc_html__('At every 12hours', 'openaffiliates'),
													'daily' => esc_html__('Daily', 'openaffiliates'),
								);
								foreach ($values as $k=>$v){
									$selected = ($data['metas']['af_update_payments_status']==$k) ? 'selected' : '';
									?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
									<?php
								}
							?></select>
						</div>
					</div>
			</div>


			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e('Keep Referral Status as Pending', 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_workflow_referral_status_dont_automatically_change']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_workflow_referral_status_dont_automatically_change');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_workflow_referral_status_dont_automatically_change" value="<?php echo esc_attr($data['metas']['af_workflow_referral_status_dont_automatically_change']);?>" id="af_workflow_referral_status_dont_automatically_change" />
					</span>
					<p class="af-form-setting-description"><?php esc_html_e("Don't change the Referral Status to Approved", 'openaffiliates');?></p>
				</div>
			</div>
			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e('Disable IP Address Logging', 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_workflow_disable_ip_address']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_workflow_disable_ip_address');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_workflow_disable_ip_address" value="<?php echo esc_attr($data['metas']['af_workflow_disable_ip_address']);?>" id="af_workflow_disable_ip_address" />
					</span>
					<p class="af-form-setting-description"><?php esc_html_e("Disable logging of the customer IP address  for improved GDPR compliance", 'openaffiliates');?></p>
				</div>
			</div>
			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e('Show Dashboard Notifications', 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_admin_workflow_dashboard_notifications']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_admin_workflow_dashboard_notifications');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_admin_workflow_dashboard_notifications" value="<?php echo esc_attr($data['metas']['af_admin_workflow_dashboard_notifications']);?>" id="af_admin_workflow_dashboard_notifications" />
					</span>
					<p class="af-form-setting-description"><?php esc_html_e("New Affiliates & Referrals", 'openaffiliates');?></p>
				</div>
			</div>
			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e('Data on Uninstall', 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_keep_data_after_delete']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_keep_data_after_delete');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
						</label>
							<input type="hidden" name="af_keep_data_after_delete" value="<?php echo esc_attr($data['metas']['af_keep_data_after_delete']);?>" id="af_keep_data_after_delete" />
						</span>
					<p class="af-form-setting-description"><?php esc_html_e("Keep all saved data for Open Affiliates when the plugin is deleted.", 'openaffiliates');?></p>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
		</div>
</form>
<div class="af-form-line" id="af_danger_zone" style="border:1px solid #d63638; border-radius:4px; padding:15px 20px; margin-top:30px;">
	<h3 class="af-h3" style="color:#d63638;"><?php esc_html_e('Danger Zone', 'openaffiliates');?></h3>
	<p class="af-form-setting-description">
		<?php esc_html_e('These actions cannot be undone. Export your data first.', 'openaffiliates');?>
		<a href="<?php echo esc_url(admin_url('admin.php?page=openaffiliates&tab=import_export'));?>"><?php esc_html_e('Export/Import', 'openaffiliates');?></a>
	</p>
	<div class="af-form-setting-wrapper">
		<label class="af-form-setting-label"><?php esc_html_e('Type RESET to enable the buttons', 'openaffiliates');?></label>
		<span class="af-form-setting-item">
			<input type="text" id="af_reset_confirm" value="" autocomplete="off" placeholder="RESET" />
		</span>
	</div>
	<div class="af-form-setting-wrapper">
		<label class="af-form-setting-label"><?php esc_html_e('Restore default settings', 'openaffiliates');?></label>
		<span class="af-form-setting-item">
			<button type="button" class="button af-reset-button" data-mode="settings" disabled><?php esc_html_e('Restore default settings', 'openaffiliates');?></button>
		</span>
		<p class="af-form-setting-description"><?php esc_html_e('Resets every Open Affiliates setting to its default. Affiliates, referrals, payments, clicks, banners, ranks and notifications are kept.', 'openaffiliates');?></p>
	</div>
	<div class="af-form-setting-wrapper">
		<label class="af-form-setting-label"><?php esc_html_e('Factory reset', 'openaffiliates');?></label>
		<span class="af-form-setting-item">
			<button type="button" class="button button-primary af-reset-button" data-mode="all" disabled><?php esc_html_e('Factory reset', 'openaffiliates');?></button>
		</span>
		<p class="af-form-setting-description"><?php esc_html_e('Deletes ALL Open Affiliates data (affiliates, referrals, payments, clicks, banners, ranks, notifications) and settings, trashes the default pages and starts the setup wizard again. WordPress users and WooCommerce orders are not touched.', 'openaffiliates');?></p>
	</div>
</div>
</div>

<?php
