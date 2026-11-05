<?php if (!empty($meta_arr['af_login_custom_css'])):
					wp_register_style( 'dummy-handle', false );
					wp_enqueue_style( 'dummy-handle' );
					wp_add_inline_style( 'dummy-handle', stripslashes($meta_arr['af_login_custom_css']) );
	?>
<?php endif;?>
<div class="af-pass-form-wrap <?php echo esc_attr($meta_arr['af_login_template']);?>">
	<?php
	if (!empty($data['success_message'])){
		echo esc_af_content("<div class='af-reset-pass-success-msg'>" . $data['success_message'] . '</div>');
	} else if (!empty($data['error_message'])){
		echo esc_af_content("<div class='af-wrapp-the-errors'>" . $data['error_message'] . '</div>');
	}
	?>
	<form method="post" >
		<input type="hidden" name="af_reset_password_nonce" value="<?php echo wp_create_nonce( 'af_reset_password_nonce' );?>" />
		<input name="afaction" type="hidden" value="reset_pass">

	<?php switch ($meta_arr['af_login_template']){
		 case 'af-login-template-2': ?>
			<div class="af-form-line-fr">
					<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address');?>" />
			</div>
			<div class="af-form-line-fr af-form-submit"><input type="submit" value="<?php esc_html_e('Reset Password', 'ulp');?>" name="Submit"></div>
	<?php break;?>

	<?php case 'af-login-template-3': ?>
		<div >
			<div class="af-form-line-fr">
				<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address');?>" />
			</div>
			<div class="af-form-line-fr af-form-submit">
				<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large af-reset-password-button" />
			</div>
			<div class="af-clear"></div>
		</div>
	<?php break;?>

		<?php case 'af-login-template-4': ?>
			<div class="af-form-line-fr">
				<i class="fa-af fa-username-af"></i><input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
			</div>
			<div class="af-form-line-fr af-form-submit">
				<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="af-reset-password-button" />
			</div>
		<?php break;?>

		<?php case 'af-login-template-5': ?>
			<div class="af-form-line-fr">
					<span class="af-form-label-fr af-form-label-username"><?php esc_html_e('Username or Email Address', 'openaffiliates');?></span>
				  <input type="text" value="" name="email_or_userlogin" class="af-email-field" placeholder="" />
			</div>
			<div class="af-form-line-fr af-form-submit">
				<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="af-reset-password-button" />
			</div>
		<?php break;?>

				<?php case 'af-login-template-6': ?>
					<div class="af-form-line-fr">
							<span class="af-form-label-fr af-form-label-username"><b><?php esc_html_e('Username or Email Address', 'openaffiliates');?></b></span>
						  <input type="text" value="" name="email_or_userlogin" class="af-email-field" placeholder="" />
					</div>
					<div class="af-temp6-row-right">
							<div class="af-form-line-fr af-form-submit">
								<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="af-reset-password-button" />
							</div>
					</div>
				<?php break;?>

				<?php case 'af-login-template-8':?>
					<div class="af-form-line-fr">
						<i class="fa-af fa-username-af"></i>
						<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large af-reset-password-button" />
					</div>
				<?php break;?>

				<?php case 'af-login-template-9':?>
					<div class="af-form-line-fr">
						<i class="fa-af fa-username-af"></i>
						<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large af-reset-password-button" />
					</div>
				<?php break;?>

				<?php case 'af-login-template-10':?>
					<div class="af-form-line-fr">
						<i class="fa-af fa-username-af"></i>
						<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large  af-reset-password-button" />
					</div>
				<?php break;?>
                <?php case 'af-login-template-11':?>
					<div class="af-form-line-fr">
						<i class="fa-af fa-username-af"></i>
						<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large  af-reset-password-button" />
					</div>
				<?php break;?>
                <?php case 'af-login-template-12':?>
					<div class="af-form-line-fr">
						<i class="fa-af fa-username-af"></i>
						<input type="text" value="" name="email_or_userlogin" placeholder="<?php esc_html_e('Username or Email Address', 'openaffiliates');?>" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large af-reset-password-button" />
					</div>
				<?php break;?>
                <?php case 'af-login-template-13': ?>
                	<div class="af-form-pass-additional-content">
					<?php esc_html_e('To reset your password, please enter your email address or username below', 'openaffiliates');?>
					</div>
			<div class="af-form-line-fr">
				  <input type="text" value="" name="email_or_userlogin" class="af-email-field" placeholder="<?php esc_html_e('Enter your Username or Email Address', 'openaffiliates');?>" />
			</div>
			<div class="af-form-line-fr af-form-submit">
				<input type="submit" value="<?php esc_html_e('Reset My Password', 'openaffiliates');?>" name="Submit" class="af-reset-password-button" />
			</div>
		<?php break;?>

				<?php default:?>
					<div class="af-form-line-fr">
						<span class="af-form-label-fr af-form-label-username"><?php esc_html_e('Username or Email Address', 'openaffiliates');?></span>
						<input type="text" value="" name="email_or_userlogin" />
					</div>
					<div class="af-form-line-fr af-form-submit">
						<input type="submit" value="<?php esc_html_e('Reset Password', 'openaffiliates');?>" name="Submit" class="button button-primary button-large" />
					</div>
				<?php break;?>

	<?php }?>

	</form>

</div>
