<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Email Notifications Settings', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h4><?php esc_html_e('Sender Details', 'openaffiliates');?></h4>
			</div>
			<div class="af-form-line">
			 <div class="row">
					<div class="col-xs-8">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e("Email Address", 'openaffiliates');?></span>
							<input type="text" class="form-control" name="af_notification_email_from" value="<?php echo esc_attr($data['metas']['af_notification_email_from']);?>"/>
						</div>
						<p><?php esc_html_e('Set the email address which emails wil be sent from. This will act as the "from" and "reply-to" address.', 'openaffiliates');?>
					</div>
				</div>
			</div>
			<div class="af-form-line">
			 <div class="row">
					<div class="col-xs-8">
						<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e("From Name", 'openaffiliates');?></span>
									<input type="text" class="form-control" name="af_notification_name" value="<?php echo esc_attr($data['metas']['af_notification_name']);?>"/>
						</div>
						<p><?php esc_html_e('Customze the email from Name. The standard is to use your Site Name.', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="af-form-line">
				<h4><?php esc_html_e('Affiliate Manager Notifications Email Address(es)', 'openaffiliates');?></h4>
				<p><?php esc_html_e('The email address(es) to receive Affiliate Manager notifications. Separate multiple email addresses with a comma (,).', 'openaffiliates');?>
			</div>
			<div class="af-form-line">
			 <div class="row">
					<div class="col-xs-8">
						<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e("Affiliate Manager Email Address", 'openaffiliates');?></span>
									<input type="text" class="form-control" name="af_admin_notification_address" value="<?php echo esc_attr($data['metas']['af_admin_notification_address']);?>"/>
						</div>
					</div>
				</div>
			</div>

			<div class="af-form-line">
				<h2><?php esc_html_e('Notification Logs', 'openaffiliates');?></h2>
				<p><?php esc_html_e('Clean Up the Email Notifcations logs longer than a certain period', 'openaffiliates');?>
			</div>
			<div class="af-form-line">
				<?php $we_have_logs = \OpenAffiliates\Db\NotificationLogs::countAll();?>
				<?php if ($we_have_logs):?>
						 <div class="row">
								<div class="col-xs-8">
							<select id="af_older_then_select" class="form-control">
									<option value="">...</option>
									<option value="1"><?php esc_html_e('older than One Day', 'openaffiliates'); ?></option>
									<option value="7"><?php esc_html_e('older than One Week', 'openaffiliates'); ?></option>
									<option value="30"><?php esc_html_e('older than One Month', 'openaffiliates'); ?></option>
							</select>
							</div>
						</div>
						<div class="button button-primary button-large af-first-button af-text-center" onclick="afDoCleanUpLogs('');">Clean Up</div>
					<?php else :?>
						<div class="iump-form-line">
						       <?php esc_html_e('No notification logs yet', 'openaffiliates');?>
	          </div>
					<?php endif;?>
				</div>



			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" onClick="" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>
</div>
