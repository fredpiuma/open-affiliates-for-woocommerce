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
										<h2><?php esc_html_e('Error Messages', 'openaffiliates');?></h2>
									</div>
									<div class="col-xs-10">
										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Username already exists', 'openaffiliates');?></div>
											<div class="af-input-text">
												<input type="text" name="af_register_username_taken_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_username_taken_msg']);?>">
												<div class="af-field-details"><?php esc_html_e('This message means that the username have been chosen is already being used by another user.', 'openaffiliates');?></div>
											</div>
										</div>


										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Username is invalid', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_error_username_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_error_username_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Email Address already exists', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_email_is_taken_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_email_is_taken_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Email Address is invalid', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_invalid_email_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_invalid_email_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Email Addresses did not match', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_emails_not_match_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_emails_not_match_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Passwords did not match', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_pass_not_match_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_pass_not_match_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Password Only Characters and Digits', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_pass_letter_digits_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_pass_letter_digits_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Password Min Length', 'openaffiliates');?></div>
											<div class="af-input-text">
												<input type="text" name="af_register_pass_min_char_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_pass_min_char_msg']);?>">
													<div id="af_msg_alert" class="af-field-details"><?php esc_html_e('Where {X} will be the minimum length of password.', 'openaffiliates');?></div>
											</div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Password Characters, Digits and minimum one uppercase letter', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_pass_let_dig_up_let_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_pass_let_dig_up_let_msg']);?>"></div>
										</div>
										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Account is not approved yet', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_pending_user_msg" class="" value="<?php echo af_correct_text($data['metas']['af_register_pending_user_msg']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Required fields are missing', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_err_req_fields" class="" value="<?php echo af_correct_text($data['metas']['af_register_err_req_fields']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Required ReCaptcha', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_err_recaptcha" class="" value="<?php echo af_correct_text($data['metas']['af_register_err_recaptcha']);?>"></div>
										</div>

										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Terms of Services checkbox', 'openaffiliates');?></div>
											<div class="af-input-text"><input type="text" name="af_register_err_tos" class="" value="<?php echo af_correct_text($data['metas']['af_register_err_tos']);?>"></div>
										</div>
									</div>
									<div class="col-xs-10">
										<h2><?php esc_html_e('Success Message', 'openaffiliates');?></h2>
									</div>
									<div class="col-xs-10">
										<div class="af-labels-special"><div class="af-label-text"><?php esc_html_e('Registration process has Completed', 'openaffiliates');?></div>
											<div class="af-input-text">
												<input type="text" name="af_register_success_meg" class="" value="<?php echo af_correct_text($data['metas']['af_register_success_meg']);?>">
													<div class="af-field-details"><?php esc_html_e('This message will show up after the user has finish the registration step.', 'openaffiliates');?></div>
											</div>

										</div>

									</div>
									</div>
									</div>
							</div>
							<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" onClick="" class="button button-primary button-large" />
							</div>
						</div>
					</div>
			</form>
		</div>
