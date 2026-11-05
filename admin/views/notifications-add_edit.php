			<form action="<?php echo esc_url($data['form_action_url']);?>" method="post">

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

<div class="af-wrapper">
		<div class="af-stuffbox">
				<h3 class="af-h3"><?php esc_html_e('Add new Email Notification', 'openaffiliates');?></h3>
				<div class="inside">
					<div class="af-form-line">
						<h2><?php esc_html_e('Email Notification Action', 'openaffiliates');?></h2>
						<select name="type" id="notf_type" onChange="afReturnNotification();" class="af-form-select af-form-element af-form-element-select af-form-select">
						<?php foreach ($data['actions_available'] as $k=>$v):?>
							<?php
								switch ($k){
									case 'admin_user_register':
										echo esc_af_content(' <optgroup label="' . esc_html__('-----Affiliate Manager Notifications-----', 'openaffiliates') . '">');
										break;
									case 'register':
										echo esc_af_content(' </optgroup><optgroup label="' . esc_html__('-----Affiliate Notifications-----', 'openaffiliates') . '"></optgroup>');
										echo esc_af_content(' <optgroup label="' . esc_html__('Registration Process', 'openaffiliates') . '">');
										break;

									case 'user_update':
										echo esc_af_content(' </optgroup><optgroup label="' . esc_html__('Affiliate Account', 'openaffiliates') . '">');
										break;

									case 'reset_password_process':
										echo esc_af_content(' </optgroup><optgroup label="' . esc_html__('Reset Password Process', 'openaffiliates') . '">');
										break;
										case 'affiliate_payment_fail':
											echo esc_af_content(' </optgroup><optgroup label="' . esc_html__('Payouts Process', 'openaffiliates') . '">');
											break;
									case 'email_check':
										echo esc_af_content(' </optgroup><optgroup label="' . esc_html__('Double Email Verification', 'openaffiliates') . '">');
										break;

								}
							?>
							<?php $selected = ($k==$data['type']) ? 'selected' : '';?>
							<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
							<?php
								/*switch ($k){
									case 'register_lite_send_pass_to_user':
									case 'affiliate_payment_complete':
									case 'change_password':
									case 'rank_change':
									case 'admin_affiliate_update_profile':
									case 'email_check_success':
										//echo esc_af_content('</optgroup>');
										break;
								}*/
							?>
						<?php endforeach;
						echo esc_af_content('</optgroup>');
						?>
						</select>
						<div class="af-notification-description-wrap">
							<div id="" class="af-js-notification-description af-notification-description"><?php if ( isset( $data['notification_description'] ) ){ echo $data['notification_description'];}?></div>
					 	</div>
					</div>
					<div class="af-special-line">
						<h2><?php esc_html_e('Choose the Target Rank', 'openaffiliates')?></h2>
						<select name="rank_id" class="af-form-select af-form-element af-form-element-select af-form-select">
						<?php foreach ($data['ranks_available'] as $k=>$v):?>
							<?php $selected = ($k==$data['rank_id']) ? 'selected' : '';?>
							<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
						<?php endforeach;?>
						</select>
					</div>
					<div class="af-form-line">
						<h2><?php esc_html_e('Email Subject', 'openaffiliates');?></h2>
						<div class="row">
							<div class="col-xs-8">
								<div class="form-group">
									<input type="text" class="form-control" value="<?php echo esc_attr($data['subject']);?>" name="subject" id="notf_subject" />
								</div>
								<p><?php esc_html_e('Enter the subject line for current notification type. Support template tags.', 'openaffiliates');?></p>
							</div>
						</div>
					</div>
					<div class="af-form-line">
						<h2><?php esc_html_e('Message to be Sent', 'openaffiliates');?></h2>
						<div class="af-notification-edit-editor">
							<?php wp_editor( $data['message'], 'notf_message', array('textarea_name'=>'message', 'quicktags'=>TRUE) );?>
						</div>
						<div class="af-notification-edit-constants">
							<h4><?php esc_html_e('Template Tags', 'openaffiliates');?></h4>
						<?php
							$constants = array(	"{username}",
												"{first_name}",
												"{last_name}",
												"{user_id}",
												'{affiliate_id}',
												"{user_email}",
												"{account_page}",
												"{login_page}",
												"{blogname}",
												"{blogurl}",
												"{siteurl}",
												'{rank_id}',
												'{rank_name}',
												'{NEW_PASSWORD}',
												'{password_reset_link}',
							);
							$extra_constants = af_get_custom_constant_fields();
							foreach ($constants as $v){
								?>
								<div class="af-tag-wrap"><span class="af-tag-code"><?php echo esc_html($v);?></span></div>
								<?php
							}
							?>
						</div>
						<div class="af-notification-edit-constants">
						<?php
							echo esc_af_content("<h4>" . esc_html__('Custom Fields Tags', 'openaffiliates') . "</h4>");
							foreach ($extra_constants as $k=>$v){
								?>
								<div class="af-tag-wrap"><span class="af-tag-code"><?php echo esc_html($k);?></span></div>
								<?php
							}
						?>
						</div>

						<div class="af-clear"></div>

					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
					</div>
				</div>
			</div>
		</div>
						<!-- PUSHOVER -->
						<?php if ($af_db->is_magic_feat_enable('pushover')):?>
							<div class="af-stuffbox">
							<h3 class="af-h3"><?php esc_html_e('Pushover Notification', 'openaffiliates');?></h3>
								<div class="inside">
									<div class="iump-form-line">
										<span class="af-labels-special"><?php esc_html_e('Pushover Notification', 'openaffiliates');?></span>
										<label class="af_label_shiwtch af-switch-button-margin">
											<?php $checked = (empty($data['pushover_status'])) ? '' : 'checked';?>
											<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#pushover_status');" <?php echo esc_attr($checked);?> />
											<div class="switch af-display-inline"></div>
										</label>
										<input type="hidden" name="pushover_status" value="<?php echo isset($data['pushover_status']) ? $data['pushover_status'] : '';?>" id="pushover_status" />
									</div>

									<div class="af-form-line">
										<label class="af-labels-special"><?php esc_html_e('Pushover Message:', 'openaffiliates');?></label>
										<textarea name="pushover_message" class="af-pushover_message" onBlur="afCheckFieldLimit(1024, this);"><?php echo isset($data['pushover_message']) ? stripslashes($data['pushover_message']) : '';?></textarea>
										<div><i><?php esc_html_e('Only Plain Text and up to ', 'openaffiliates');?><strong>1024</strong><?php esc_html_e(' characters are available!', 'openaffiliates');?></i></div>
									</div>
									<div id="af_save_changes" class="af-submit-form">
										<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
									</div>
								</div>
							</div>
						<?php else :?>
							<input type="hidden" name="pushover_message" value=""/>
							<input type="hidden" name="pushover_status" value=""/>
						<?php endif;?>
						<!-- PUSHOVER -->

				<input type="hidden" name="status" value="1" />
				<input type="hidden" name="id" value="<?php echo esc_attr($data['id']);?>" class="af-js-add-edit-notification-id" />
</div>
	</form>
