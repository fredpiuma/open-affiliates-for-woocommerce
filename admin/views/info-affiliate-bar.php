<div class="af-wrapper af-admin-affiliate-bar-wrapper">

		<form  method="post">
			<div class="af-stuffbox">
				<h3 class="af-h3"><?php esc_html_e('Affiliate FlashBar', 'openaffiliates');?></h3>
				<div class="inside">
				<div class="row">
					<div class="col-xs-6">

					<div class="af-form-line">
						<h2><?php esc_html_e('Activate/Hold Info Affiliate FlashBar', 'openaffiliates');?></h2>
                        <p><?php esc_html_e('The quickest and easiest way to link to any page.FlashBar will show up at the top of every page affiliate visits. To generate an affiliate link just go to the specific page and use the available options from FlashBar.', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_info_affiliate_bar_enabled']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_enabled');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_info_affiliate_bar_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_enabled']);?>" id="af_info_affiliate_bar_enabled" />
          </div>
          			</div>
                    </div>
          <div class="row">
						<div class="col-xs-11">
						<img src="<?php echo AF_URL;?>assets/images/flashbar-demo.png" class="af-demo-image" alt="demo"/>
                        </div>
						</div>
        <div class="af-form-line">
					<div class="row">
					<div class="col-xs-6">
                    <h2><?php esc_html_e('FlashBar Logo', 'openaffiliates');?></h2>
								<p><?php esc_html_e('Personalize your FlashBar with your logo or leave the default one. The image will show up on the left side of the bar.', 'openaffiliates');?></p>
					<div class="form-group">
							<input type="text" class="form-control af-edit-input" name="af_info_affiliate_bar_logo" onClick="openMediaUp(this);" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_logo']);?>" />
							<i class="fa-af fa-trash-af af-display-inline" id="af_js_flashbar_trash_img" onclick="" title="<?php esc_html_e('Remove Logo', 'openaffiliates');?>" ></i>
					</div>
					</div>
          </div>

					<div class="row">
					<div class="col-xs-4">
							<h2><?php esc_html_e( 'Links Section', 'openaffiliates' );?></h2>
                            <p><?php esc_html_e('Will help affiliates to easily generates affiliates links with just 2 clicks. ', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_links_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_links_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_links_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_links_section_enabled']);?>" id="af_info_affiliate_bar_links_section_enabled" />
							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Section name', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_links_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_links_label'] );?>" />
							</div>
							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( "'Get affiliate link' label", 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_links_get_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_links_get_label'] );?>" />
							</div>
					</div>
                    </div>


					<div class="row">
					<div class="col-xs-4">
							<h2><?php esc_html_e( 'Banner Section', 'openaffiliates' );?></h2>
							<p><?php esc_html_e('Based on current page Featured Image, affiliates may generated banners links. ', 'openaffiliates');?></p>
                            <label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_banner_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_banner_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_banner_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_banner_section_enabled']);?>" id="af_info_affiliate_bar_banner_section_enabled" />

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Section name', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_banner_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_banner_label'] );?>" />
							</div>

							<div class="form-group">
									<h6><?php esc_html_e( 'Default Banner', 'openaffiliates' );?></h6>
									<input type="text" class="form-control af-edit-input"  name="af_info_affiliate_bar_banner_default_value" onClick="openMediaUp(this);" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_banner_default_value']);?>" />
									<i class="fa-af fa-trash-af af-display-inline" id="af_js_iab_trash_banner" onclick="" title="<?php esc_html_e('Remove Logo', 'openaffiliates');?>"></i>
							</div>

					</div>
                    </div>


					<div class="row">
					<div class="col-xs-4">
							<h2><?php esc_html_e( 'Social Section', 'openaffiliates' );?></h2>
                            <p><?php esc_html_e('Place social Share icons with one generated Shortcode. We recommend "Social Share&Locker" plugin. ', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_social_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_social_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_social_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_social_section_enabled']);?>" id="af_info_affiliate_bar_social_section_enabled" />

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Section name', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_social_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_social_label'] );?>" />
							</div>

							<div>
									<h2><?php esc_html_e( 'Shortcode', 'openaffiliates' );?></h2>
									<p><?php esc_html_e( 'You can generate the social share shortcode from the "Social Share &amp; Locker" dashboard and paste it here.' , 'openaffiliates' );?><strong><?php esc_html_e( '"Social Share&Locker" plugin is required.' , 'openaffiliates' );?></strong></p>
									<p><a href="<?php echo admin_url( 'admin.php?page=ism_manage&amp;tab=shortcode' );?>" target="_blank"><?php esc_html_e( 'Click here', 'openaffiliates' );?></a><?php esc_html_e( ' to grab a new shortcode.', 'openaffiliates' );?></p>
									<textarea name="af_info_affiliate_bar_social_shortcode" class="af-special-shortcode"><?php echo stripslashes($data['metas']['af_info_affiliate_bar_social_shortcode']);?></textarea>
							</div>
						</div>
            </div>


					<div class="row">
					<div class="col-xs-5">
							<h2><?php esc_html_e( 'Stats Section', 'openaffiliates' );?></h2>
                            <p><?php esc_html_e('Important stats and counts about current Page may show up into FlashBar so affiliate user will better understand the potential of that page.". ', 'openaffiliates');?></p>
							<h4><?php esc_html_e( 'Personal Stats', 'openaffiliates' );?></h4>
                            <p><?php esc_html_e('Counts about how many visits and referrals current page generated for logged affiliate user.". ', 'openaffiliates');?></p>
                            <label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_stats_personal_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_stats_personal_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_stats_personal_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_stats_personal_section_enabled']);?>" id="af_info_affiliate_bar_stats_personal_section_enabled" />

							<h2><?php esc_html_e( 'General Stats', 'openaffiliates' );?></h2>
                            <p><?php esc_html_e('Conversion Rate value is provided being calculated based on all affiliates performances related to current page.". ', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_stats_general_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_stats_general_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_stats_general_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_stats_general_section_enabled']);?>" id="af_info_affiliate_bar_stats_general_section_enabled" />

                            <h4><?php esc_html_e( 'Customizable Labels', 'openaffiliates' );?></h4>
							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Section name', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_stats_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_stats_label'] );?>" />
							</div>

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Visits label', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_visits_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_visits_label'] );?>" />
							</div>

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Referrals label', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_referrals_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_referrals_label'] );?>" />
							</div>

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Insigts label', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_insigts_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_insigts_label'] );?>" />
							</div>

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( "'Conversion rate' label", 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_conversion_rate_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_conversion_rate_label'] );?>" />
							</div>

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( "Perfomance label", 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_overall_performance_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_overall_performance_label'] );?>" />
							</div>


					</div>
                    </div>


					<div class="row">
					<div class="col-xs-4">
							<h2><?php esc_html_e( 'Menu Section', 'openaffiliates' );?></h2>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_info_affiliate_bar_menu_section_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_info_affiliate_bar_menu_section_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_info_affiliate_bar_menu_section_enabled" value="<?php echo esc_attr($data['metas']['af_info_affiliate_bar_menu_section_enabled']);?>" id="af_info_affiliate_bar_menu_section_enabled" />

							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e( 'Section name', 'openaffiliates' );?></span>
									<input type="text" class="form-control" name="af_info_affiliate_bar_menu_label" value="<?php echo stripslashes( $data['metas']['af_info_affiliate_bar_menu_label'] );?>" />
							</div>

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

<?php
