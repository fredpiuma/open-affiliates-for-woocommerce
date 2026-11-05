<?php
$enabled = af_is_social_share_intalled_and_active();
?>
<div class="af-wrapper">
			<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Social Share', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
					<div class="af-form-line">
						<div class="row">
						<div class="col-xs-7">
							<h2><?php esc_html_e('Activate/Hold Social Share', 'openaffiliates');?></h2>
							<p><?php esc_html_e("This Feature will work only if You have ","openaffiliates");?> '<strong><?php esc_html_e(" Social Share & Locker Pro Wordpress Plugin ", "openaffiliates");?></strong>' <?php esc_html_e(" installed and activated.","openaffiliates");?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_social_share_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_social_share_enable');" <?php echo esc_attr($checked);?> <?php echo (!$enabled) ? 'disabled' : '';?>/>
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_social_share_enable" value="<?php echo esc_attr($data['metas']['af_social_share_enable']);?>" id="af_social_share_enable" />
						</div>
						</div>

						<div class="row">
						<div class="col-xs-6">
							<h2><?php esc_html_e('Custom Share Message', 'openaffiliates');?></h2>
							<p><?php esc_html_e('For a better share action, you may set a custom message that will be listed besides the affiliate links.', 'openaffiliates');?></p>

							<textarea name="af_social_share_message" class="af-custom-css-box"><?php echo af_correct_text($data['metas']['af_social_share_message']);?></textarea>
						</div>
						</div>

						<div class="row">
						<div class="col-xs-6">
							<h2><?php esc_html_e('Shortcode', 'openaffiliates');?></h2>
							<p><?php esc_html_e('You can generate the social share shortcode from the "Social Share & Locker" dashboard and paste it here.', 'openaffiliates');?></p>
							<p><?php
								if ($enabled){
									echo esc_af_content('<a href="' . $data['social_share_page'] . '" target="_blank">' . esc_html__('Click here', 'openaffiliates') . '</a>' . esc_html__(' to grab a new shortcode.', 'openaffiliates'));
								}
								?></p>
							<textarea name="af_social_share_shortcode" class="af-custom-css-box"><?php echo af_correct_text($data['metas']['af_social_share_shortcode']);?></textarea>
							</div>
						</div>
<?php
 $installed_plugins = get_plugins();
 $plugin_slug = 'indeed-social-media/indeed-social-media.php';
 if(array_key_exists( $plugin_slug, $installed_plugins ) || in_array( $plugin_slug, $installed_plugins, true )){
	 $currentVersion = af_get_plugin_version( WP_PLUGIN_DIR . '/indeed-social-media/indeed-social-media.php');
	 if ( version_compare( $currentVersion, 7.8, '<' ) ){
	 		$enabled = false;
	 }
 }

?>
						<div class="row">
								<div class="col-xs-7">
									<h2><?php esc_html_e('Activate/Hold Social Share on Creatives', 'openaffiliates');?></h2>
									<p><?php esc_html_e("This Feature will work only if You have ","openaffiliates");?> '<strong><?php esc_html_e(" Social Share & Locker Pro Wordpress Plugin ", "openaffiliates");?></strong>' <?php esc_html_e(" installed and activated.","openaffiliates");?></p>
									<?php if ( !$enabled ):?>
											<p><?php esc_html_e("In order for this feature to work properly You need Social Share & Locker Pro >7.9 version.", "openaffiliates");?></p>
									<?php endif;?>
									<label class="af_label_shiwtch af-switch-button-margin">
										<?php $checked = ($data['metas']['af_social_share_enable_on_creatives']) ? 'checked' : '';?>
										<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_social_share_enable_on_creatives');" <?php echo esc_attr($checked);?> <?php echo (!$enabled) ? 'disabled' : '';?>/>
										<div class="switch af-display-inline"></div>
									</label>
									<input type="hidden" name="af_social_share_enable_on_creatives" value="<?php echo esc_attr($data['metas']['af_social_share_enable_on_creatives']);?>" id="af_social_share_enable_on_creatives" />
								</div>
						</div>

						<div class="row">
						<div class="col-xs-6">
							<h2><?php esc_html_e('Shortcode', 'openaffiliates');?></h2>
							<p><?php esc_html_e('You can generate the social share shortcode from the "Social Share & Locker" dashboard and paste it here.', 'openaffiliates');?></p>
							<p><?php
								if ($enabled){
									echo esc_af_content('<a href="' . $data['social_share_page'] . '" target="_blank">' . esc_html__('Click here', 'openaffiliates') . '</a>' . esc_html__(' to grab a new shortcode.', 'openaffiliates'));
								}
								?></p>
							<textarea name="af_social_share_shortcodeon_creatives" class="af-custom-css-box"><?php echo af_correct_text($data['metas']['af_social_share_shortcodeon_creatives']);?></textarea>
							</div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
			</form>
</div>
