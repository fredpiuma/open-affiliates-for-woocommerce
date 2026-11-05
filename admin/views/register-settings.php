<?php wp_enqueue_style( 'af-croppic_css', AF_URL . 'assets/css/croppic.css' );?>
<?php wp_enqueue_script( 'af-jquery_mousewheel', AF_URL . 'assets/js/jquery.mousewheel.min.js', array('jquery'), null );?>
<?php wp_enqueue_script( 'af-croppic', AF_URL . 'assets/js/croppic.js', array('jquery'), null );?>
<?php wp_enqueue_script( 'af-image_croppic', AF_URL . 'assets/js/image_croppic.js', array('jquery'), null );?>
<?php
wp_enqueue_script( 'wp-theme-plugin-editor' );
wp_enqueue_style( 'wp-codemirror' );
wp_enqueue_script( 'code-editor' );
wp_enqueue_style( 'code-editor' );
 ?>
<div class="af-page-title"><span class="second-text"><?php esc_html_e('Registration Form', 'openaffiliates');?></span>
</div>
<div class="af-wrapper">
<div class="af-stuffbox">
	<div class="af-shortcode-display">
		[af-register]
	</div>
</div>

<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Registration Form Display', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-register-select-template">
				<?php
					$templates = array(
										'af-register-9'=>'(#9) '.esc_html__('Radius Theme', 'openaffiliates'),
										'af-register-14'=>'(#14) '.esc_html__('Ultimate Member', 'openaffiliates'),
										'af-register-10'=>'(#10) '.esc_html__('BootStrap Theme', 'openaffiliates'),
										'af-register-8'=>'(#8) '.esc_html__('Simple Border Theme', 'openaffiliates'),
										'af-register-13'=>'(#13) '.esc_html__('Double BootStrap Theme', 'openaffiliates'),
										'af-register-11'=>'(#11) '.esc_html__('Double Simple Border Theme', 'openaffiliates'),
										'af-register-12'=>'(#12) '.esc_html__('Dobule Radius Theme', 'openaffiliates'),
										'af-register-7'=>'(#7) '.esc_html__('BackBox Theme', 'openaffiliates'),
										'af-register-6'=>'(#6) '.esc_html__('Double Strong Theme', 'openaffiliates'),
										'af-register-5'=>'(#5) '.esc_html__('Strong Theme', 'openaffiliates'),
										'af-register-4'=>'(#4) '.esc_html__('PlaceHolder Theme', 'openaffiliates'),
										'af-register-3'=>'(#3) '.esc_html__('Blue Box Theme', 'openaffiliates'),
										'af-register-2'=>'(#2) '.esc_html__('Basic Theme', 'openaffiliates'),
										'af-register-1'=>'(#1) '.esc_html__('Standard Theme', 'openaffiliates')
					);
				?>
				<?php esc_html_e('Registration Form Template', 'openaffiliates');?>
				<select name="af_register_template" id="af_register_template" onChange="afRegisterPreview();" >
					<?php
						foreach ($templates as $k=>$v){
						?>
							<option value="<?php echo esc_attr($k);?>" <?php echo ($k==$data['metas']['af_register_template']) ? 'selected' : '';?> >
								<?php echo esc_html($v);?>
							</option>
						<?php
						}
						?>
				</select>
			</div>

			<div>
				<div id="register_preview"></div>
			</div>

			<div class="af-clear"></div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Additional Settings', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h2><?php esc_html_e('Rank Settings', 'openaffiliates');?></h2>
				<div id="rank_assign_to_user">
					<h4><?php esc_html_e('Set the default Rank for Affiliates', 'openaffiliates');?></h4>
					<p><?php esc_html_e('This ensures that new affiliates are automatically assigned to this default Rank upon registration, streamlining the onboarding process.', 'openaffiliates');?></p>
					<select name="af_register_new_user_rank">
						<option value="0" <?php echo ($data['metas']['af_register_new_user_rank']==0) ? 'selected' : '';?> ><?php esc_html_e('None', 'openaffiliates');?></option>
					<?php
					$ranks = $af_db->get_rank_list();
					if (!empty($ranks) && is_array($ranks)){
						foreach ($ranks as $id=>$v){
						?>
							<option value="<?php echo esc_attr($id);?>" <?php echo ($data['metas']['af_register_new_user_rank']==$id) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
						<?php
						}
					}
					?>
					</select>
				</div>
		</div>
		<div class="af-form-line">
			<h2><?php esc_html_e('New Affiliates WordPress Role', 'openaffiliates');?></h2>
			<div><?php esc_html_e('Assign a specific WordPress role to new affiliates upon registration for streamlined user management.', 'openaffiliates');?></div>
				<select name="af_register_new_user_role">
				<?php
					$roles = af_get_wp_roles_list();
					if ($roles){
						foreach ($roles as $k=>$v){
							$selected = ($data['metas']['af_register_new_user_role']==$k) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
							<?php
						}
					}
				?>
				</select>
			<p><?php esc_html_e('If the "Pending" Role is set the user cannot login until the Admin manually approves the user.', 'openaffiliates');?></p>
		</div>

		<div class="af-form-line">
			<div><h4><?php esc_html_e('After Approval', 'openaffiliates');?></h4></div>
				<p><?php esc_html_e('After the Administrator has approved the Affiliate account, assign a specific WordPress role', 'openaffiliates');?></p>
				<select name="af_after_approve_role">
				<?php
					$roles = af_get_wp_roles_list();
					if ($roles){
						foreach ($roles as $k=>$v){
							$selected = ($data['metas']['af_after_approve_role']==$k) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
							<?php
						}
					}
				?>
				</select>
		</div>

		<div class="af-form-line">

		<h2><?php esc_html_e('Password Requirements', 'openaffiliates');?></h2>

		<div class="row">
			<div class="col-xs-4">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon1"><?php esc_html_e('Minimum Length', 'openaffiliates');?></span>
				<input type="number" value="<?php echo esc_attr($data['metas']['af_register_pass_min_length']);?>" name="af_register_pass_min_length" min="4" class="form-control" />
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-xs-4">
				<h4><?php esc_html_e('Password Strength Options', 'openaffiliates');?></h4>
					<select name="af_register_pass_options"  class="form-control m-bot15">
						<option value="1" <?php echo ($data['metas']['af_register_pass_options']==1) ? 'selected' : '';?> ><?php esc_html_e('Standard', 'openaffiliates');?></option>
						<option value="2" <?php echo ($data['metas']['af_register_pass_options']==2) ? 'selected' : '';?> ><?php esc_html_e('Characters and digits', 'openaffiliates');?></option>
						<option value="3" <?php echo ($data['metas']['af_register_pass_options']==3) ? 'selected' : '';?> ><?php esc_html_e('Characters, digits, minimum one uppercase letter', 'openaffiliates');?></option>
					</select>
				</div>
			</div>
			</div>
			<div class="af-form-line">
				<h2><?php esc_html_e('Administrator Notification', 'openaffiliates');?></h2>
				<p><?php esc_html_e('Once a new user registers, administrators will receive immediate notifications at the default Email Administrator address, ensuring swift awareness of new registrations on your WordPress site. Stay informed and manage user accounts effectively.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_register_admin_notify']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_register_admin_notify');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_register_admin_notify" value="<?php echo esc_attr($data['metas']['af_register_admin_notify']);?>" id="af_register_admin_notify" />
			</div>

			<div class="af-form-line">
				<div>
					<h2><?php esc_html_e('Automatic Login after Registration', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Automatically log in newly registered affiliates after completing the registration process for a seamless and user-friendly experience', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_register_auto_login']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_register_auto_login');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
						<input type="hidden" name="af_register_auto_login" value="<?php echo esc_attr($data['metas']['af_register_auto_login']);?>" id="af_register_auto_login" />

				</div>
			</div>
			<div class="af-form-line">
				<h2><?php esc_html_e('Terms & Conditions Label', 'openaffiliates');?></h2>
				<p><?php esc_html_e('This label serves as a quick reference for affiliates to understand the legal obligations and guidelines associated with their account', 'openaffiliates');?></p>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" name="af_register_terms_c" class="form-control m-bot15" value="<?php echo af_correct_text($data['metas']['af_register_terms_c']);?>" />
					</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>

				<div class="af-stuffbox af-custom-css-box-wrapper">
					<h3 class="af-h3"><?php esc_html_e('Custom CSS', 'openaffiliates');?></h3>
						<div class="af-form-line">
							<textarea name="af_register_custom_css" id="af_register_custom_css" class="af-dashboard-textarea" onBlur="afRegisterLockerPreview();"><?php
							echo stripslashes($data['metas']['af_register_custom_css']);
							?></textarea>
						<div id="af_save_changes" class="af-wrapp-submit-bttn">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>

			</form>
		</div>
