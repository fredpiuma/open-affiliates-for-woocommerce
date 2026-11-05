<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<form  method="post" class="af-change-password-form">

	<input type="hidden" value="<?php echo wp_create_nonce( 'af_public_change_password_nonce' );?>" name="af_public_change_password_nonce" />

	<div class="af-change-password-field-wrap">
		<label class="af-change-password-label"><?php esc_html_e("Current Password", 'openaffiliates');?></label>
		<input class="af-change-password-field" type="password" value="" name="old_pass" />
        <div class="af-change-password-field-details"><?php esc_html_e("we need your current password to confirm your changes", 'openaffiliates');?></div>
	</div>
	<div class="af-change-password-field-wrap">
		<label class="af-change-password-label"><?php esc_html_e("New Password", 'openaffiliates');?></label>
		<input class="af-change-password-field" type="password" value="" name="pass1" />
	</div>
	<div class="af-change-password-field-wrap">
		<label class="af-change-password-label"><?php esc_html_e("Confirm New Password", 'openaffiliates');?></label>
		<input class="af-change-password-field" type="password" value="" name="pass2" />
	</div>
	<div class="af-change-password-field-wrap">
		<div class="af-change-password-submit-button-wrap">
			<input type="submit" value="<?php esc_html_e("Save Changes", 'openaffiliates');?>" name="update_pass" class="button button-primary button-large" <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?> />
		</div>
	</div>
	<?php if (!empty($data['error'])) : ?>
		<div><?php echo esc_af_content($data['error']);?></div>
	<?php elseif (!empty($data['success'])) : ?>
		<div><?php echo esc_af_content($data['success']);?></div>
	<?php endif; ?>
</form>
</div>
