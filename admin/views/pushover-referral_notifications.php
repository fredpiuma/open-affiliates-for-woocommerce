<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('PushOver Referrals Notifications', 'openaffiliates');?></h3>
		<div class="inside">

			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold PushOver Referrals Notifications', 'openaffiliates');?></h2>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_pushover_referral_notifications_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_pushover_referral_notifications_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_pushover_referral_notifications_enabled" value="<?php echo esc_attr($data['metas']['af_pushover_referral_notifications_enabled']);?>" id="af_pushover_referral_notifications_enabled" />
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>


</form>

</div>
