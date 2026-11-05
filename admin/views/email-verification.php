<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Email Verification', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">

			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold Email Verification', 'openaffiliates');?></h2>
				<p><?php esc_html_e('Requires the email address for new Affiliates to be verified before they will be able to login. If the email address is not confirmed, the user account may be automatically deleted after a certain time.', 'openaffiliates');?></p>
				<div>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_register_double_email_verification']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_register_double_email_verification');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_register_double_email_verification" value="<?php echo esc_attr($data['metas']['af_register_double_email_verification']);?>" id="af_register_double_email_verification" />
					<p>
						<?php esc_html_e('Be sure that your notifications for','openaffiliates');?> "<strong>Double Email Verification</strong>" <?php esc_html_e(' are properly set.','openaffiliates');?>
					</p>
				</div>
			</div>

		<div class="af-inside-item">
			<div class="row">
				<div class="col-xs-5">

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Activation Link Expire Time', 'openaffiliates');?></span>
							<select name="af_double_email_expire_time" class="form-control m-bot15">
								<?php
									$arr = array(
															'-1' => 'Never',
															'900' => '15 Minutes',
															'3600' => '1 Hour',
															'43200' => '12 Hours',
															'86400' => '1 Day',
															);
									foreach ($arr as $k=>$v){
										?>
										<option value="<?php echo esc_attr($k)?>" <?php echo ($k==$data['metas']['af_double_email_expire_time']) ? 'selected' : '';?> >
											<?php echo esc_html($v);?>
										</option>
										<?php
									}
								?>
							</select>
					</div>

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Success Redirect', 'openaffiliates');?></span>
							<select name="af_double_email_redirect_success" class="form-control m-bot15">
								<option value="-1" <?php echo ($data['metas']['af_double_email_redirect_success']==-1) ? 'selected' : '';?> >...</option>
								<?php
									if ($data['pages']){
										foreach ($data['pages'] as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_double_email_redirect_success']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
					</div>

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Error Redirect', 'openaffiliates');?></span>
							<select name="af_double_email_redirect_error" class="form-control m-bot15">
								<option value="-1" <?php echo ($data['metas']['af_double_email_redirect_error']==-1) ? 'selected' : '';?> >...</option>
								<?php
									if ($data['pages']){
										foreach ($data['pages'] as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_double_email_redirect_error']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
					</div>

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Delete User if is not verified', 'openaffiliates');?></span>
							<select name="af_double_email_delete_user_not_verified" class="form-control m-bot15">
								<?php
									$arr = array(
															'-1' => 'Never',
															'1' => 'After 1 day',
															'7' => 'After 7 days',
															'14' => 'After 14 days',
															'30' => 'After 30 days',
															);
									foreach ($arr as $k=>$v){
										?>
										<option value="<?php echo esc_attr($k);?>" <?php echo ($k==$data['metas']['af_double_email_delete_user_not_verified']) ? 'selected' : '';?> >
											<?php echo esc_html($v);?>
										</option>
										<?php
									}
								?>
							</select>
					</div>

				</div>
			</div>
		</div>

		<div id="af_save_changes" class="af-submit-form">
			<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
		</div>

		</div>
	</div>
</form>
</div>
