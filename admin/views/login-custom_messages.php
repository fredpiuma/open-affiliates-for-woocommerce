<div class="af-wrapper">
<form method="post" >
	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Custom Messages', 'openaffiliates');?></h3>

					<div class="inside af-custom-messages">
						<div class="af-form-line">
							<div class="af-inside-item">
							<div class="row">
								<div class="col-xs-10">
						<h2><?php esc_html_e('Login Messages', 'openaffiliates');?></h2>

							<div class="af-space"></div>

								<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Successfully Message', 'openaffiliates');?></div>
								<div class="af-input-text"><input type="text" name="af_login_succes" class="" value="<?php echo af_correct_text($data['metas']['af_login_succes']);?>"></div>
								</div>

								<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Default message for pending users', 'openaffiliates');?>
								</div>
									<div class="af-input-text">
										<input type="text" name="af_login_pending" class="" value="<?php echo af_correct_text($data['metas']['af_login_pending']);?>">
										<div class="af-field-details"><?php esc_html_e('This notice will appear during login process if the administrator has not approved the affiliate account.', 'openaffiliates');?></div>
									</div>

								</div>

								<div class="af-labels-special">
									<div class="af-label-text"><?php esc_html_e('Error Message', 'openaffiliates');?></div>
								<div class="af-input-text">
									<input type="text" name="af_login_error" class="" value="<?php echo af_correct_text($data['metas']['af_login_error']);?>">
									<div class="af-field-details"><?php esc_html_e('This notice will appear during login process if the email address or password were typed wrongly.', 'openaffiliates');?></div>
								</div>
								</div>

								<div class="af-labels-special">
									<div class="af-label-text"><?php esc_html_e('Email Pending', 'openaffiliates');?></div>
								<div class="af-input-text">
									<input type="text" name="af_login_error_email_pending" class="" value="<?php echo af_correct_text($data['metas']['af_login_error_email_pending']);?>">
									<div class="af-field-details"><?php esc_html_e('This notice will appear during the login procedure if the affiliate\'s email address has not been approved and he attempts to log in.', 'openaffiliates');?></div>
								</div>
								</div>

								<div class="inside">
								<div class="af-space"></div>
								<div class="af-line-break"></div>
								<div class="af-space"></div>
							</div>

							<h2><?php esc_html_e('Reset Password Messages', 'openaffiliates');?></h2>
								<div class="af-space"></div>
								<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Successfully Message', 'openaffiliates');?></div>
								<div class="af-input-text"><input type="text" name="af_reset_msg_pass_ok" class="" value="<?php echo af_correct_text($data['metas']['af_reset_msg_pass_ok']);?>"></div>
								</div>


								<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Error Message', 'openaffiliates');?>	</div>
								<div class="af-input-text">
									<input type="text" name="af_reset_msg_pass_err" class="" value="<?php echo af_correct_text($data['metas']['af_reset_msg_pass_err']);?>">
									<div class="af-field-details"><?php esc_html_e('This notice will appear during the reset password procedure if the affiliate\'s email address or current password is incorrectly typed.', 'openaffiliates');?></div>
								</div>
								</div>


								<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('reCaptcha Error Message', 'openaffiliates');?></div>
								<div class="af-input-text">
									<input type="text" name="af_login_error_on_captcha" class="" value="<?php echo af_correct_text($data['metas']['af_login_error_on_captcha']);?>">
										<div class="af-field-details"><?php esc_html_e('This notice will appear during the reset password procedure if the affiliate does not correctly fill out the form.', 'openaffiliates');?></div>
								</div>
								</div>
							</div>
							</div>
					</div>
				</div>
					<div id="af_save_changes" class="af-wrapp-submit-bttn">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
			</div>
			</div>
</form>
</div>
