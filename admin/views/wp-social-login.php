<?php
if (defined('WORDPRESS_SOCIAL_LOGIN_ABS_PATH')){
	$is_set = TRUE;
}

?>
<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('WP Social Login Integration', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>

		<div class="inside">


				<div class="af-form-line">
					<h2><?php esc_html_e('Activate/Hold WP Social Login Integration', 'openaffiliates');?></h2>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_wp_social_login_on']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_wp_social_login_on');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_wp_social_login_on" value="<?php echo esc_attr($data['metas']['af_wp_social_login_on']);?>" id="af_wp_social_login_on" />
				</div>

				<?php if (empty($is_set)):?>
					<div class="af-form-line">
					<?php echo esc_html__("Wp Social Login it's not active on Your system. You can find ", 'openaffiliates') . '<a href="https://wordpress.org/plugins/wordpress-social-login/" target="_blank">' . esc_html__('here', 'openaffiliates') . '.</a>';?>
					</div>
				<?php else:?>

				<div class="af-form-line">
					<h2><?php esc_html_e('Login/Register Redirect', 'openaffiliates');?></h2>
					<div class="af-form-line">
						<select name="af_wp_social_login_redirect_page">
							<?php foreach ($data['pages'] as $post_id=>$title):?>
								<?php $selected = ($data['metas']['af_wp_social_login_redirect_page']==$post_id) ? 'selected' : '';?>
								<option value="<?php echo esc_attr($post_id);?>" <?php echo esc_attr($selected);?> ><?php echo esc_af_content($title);?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>

				<div class="af-form-line">
					<h2><?php esc_html_e('WP Role', 'openaffiliates');?></h2>
					<div><strong><?php esc_html_e('Predefined Wordpress Role Assign to new Users:', 'openaffiliates');?></strong></div>
					<select name="af_wp_social_login_default_role">
					<?php
						if (empty($data['metas']['af_wp_social_login_default_role'])){
							$data['metas']['af_wp_social_login_default_role'] = get_option('af_register_new_user_role');
						}
						$roles = af_get_wp_roles_list();
						if ($roles){
							foreach ($roles as $k=>$v){
								$selected = ($data['metas']['af_wp_social_login_default_role']==$k) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						}
					?>
					</select>
				</div>

				<div class="af-form-line">
					<?php
						if (empty($data['metas']['af_wp_social_login_default_rank'])){
							$data['metas']['af_wp_social_login_default_rank'] = get_option('af_register_new_user_rank');
						}
					?>
					<div><strong><?php esc_html_e('Rank assigned to new User', 'openaffiliates');?></strong></div>
					<select name="af_wp_social_login_default_rank">
						<option value="0" <?php echo ($data['metas']['af_wp_social_login_default_rank']==-1) ? 'selected' : '';?> ><?php esc_html_e('None', 'openaffiliates');?></option>
						<?php
							if ($data['ranks'] && count($data['ranks'])){
								foreach ($data['ranks'] as $key=>$object){
								?>
									<option value="<?php echo esc_attr($object->id);?>" <?php echo ($data['metas']['af_wp_social_login_default_rank']==$object->id) ? 'selected' : '';?> ><?php echo esc_html($object->label);?></option>
								<?php
								}
							}
						?>
					</select>
				</div>


				<h4><?php esc_html_e('WordPress Social Login - Shortcode:', 'openaffiliates');?></h4>
				<div class="af-user-list-shortcode-wrapp">
					<div class="content-shortcode af-text-align-center">
						<span class="the-shortcode">[wordpress_social_login]</span>
					</div>
				</div>

				<div>
					<a href="<?php echo admin_url('options-general.php?page=wordpress-social-login');?>"><?php esc_html_e('Wordpress Social Login - Settings', 'openaffiliates');?></a>
				</div>

				<div class="af-submit-form">
					<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
				</div>

			<?php endif;?>

		</div>
	</div>
</form>
</div>
<?php
