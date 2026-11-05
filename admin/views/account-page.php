<?php
require_once AF_PATH . 'admin/font-awesome_codes.php';
$font_awesome = af_return_font_awesome();
$custom_css = '';
?>

<?php
 foreach ($font_awesome as $base_class => $code):
	$custom_css .= "." . $base_class . ":before{".
		"content: '\\".$code."';".
	"}";
endforeach;
foreach ($data['available_tabs'] as $k=>$v):
  if ( !isset( $v['af_tab_' . $k . '_icon_code'] ) || $v['af_tab_' . $k . '_icon_code'] === ''|| $v['af_tab_' . $k . '_icon_code'] === false ){ continue;}
$custom_css .= ".fa-" . $k . "-account-af:before{".
"content:'\\".$v['af_tab_' . $k . '_icon_code']."';".
"}";
endforeach;

wp_enqueue_script( 'wp-theme-plugin-editor' );
wp_enqueue_style( 'wp-codemirror' );
wp_enqueue_script( 'code-editor' );
wp_enqueue_style( 'code-editor' );

wp_register_style( 'dummy-handle', false );
wp_enqueue_style( 'dummy-handle' );
wp_add_inline_style( 'dummy-handle', $custom_css );
 ?>

<div class="af-page-title">
	<span class="second-text">
		<?php esc_html_e('Affiliate Portal', 'openaffiliates');?>
	</span>
</div>
<div class="af-wrapper">
<div class="af-stuffbox">
	<div class="af-shortcode-display">
		[af-account-page]
	</div>
</div>

<div class="metabox-holder af af-admin-account-page-settings">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Top Section', 'openaffiliates');?></h3>

			<div class="inside">

			<div class="af-register-select-template">
				<?php esc_html_e('Select Template', 'openaffiliates');?>
				<select name="af_ap_top_theme"><?php
					foreach ($data['top_themes'] as $k=>$v){
						$selected = ($k==$data['metas']['af_ap_top_theme']) ? 'selected' : '';
						?>
						<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
						<?php
					}
				?></select>
			</div>
      <div class="inside">
        <div class="af-form-line af-no-border">
      				<h2><?php esc_html_e('Affiliate Banner Image', 'openaffiliates');?></h2>
      				<p><?php esc_html_e('The cover or background image, based on what theme you have chosen', 'openaffiliates');?></p>
      				<div class="input-group">
      				<label class="af_label_shiwtch af-onbutton">
  					<?php $checked = ($data['metas']['af_ap_edit_background']) ? 'checked' : '';?>
  					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_background');" <?php echo esc_attr($checked);?> />
  					<div class="switch af-display-inline"></div>
  				</label>
  				<input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_background']);?>" name="af_ap_edit_background" id="af_ap_edit_background" />
  				<label></label>
  				</div>
  					<div class="row">
  						<div class="col-xs-6">
                <p><?php esc_html_e('Upload a custom Banner image to replace the default one.', 'openaffiliates');?></p>
  							<div class="form-group">
  								<input type="text" class="form-control af-banner-field" onClick="openMediaUp(this);" value="<?php  echo esc_attr($data['metas']['af_ap_edit_background_image']);?>" name="af_ap_edit_background_image" id="af_ap_edit_background_image"/>
  								<i class="fa-af fa-trash-af" id="af_js_edit_background_image_trash" onclick="" title="<?php esc_html_e('Remove Background Image', 'openaffiliates');?>"></i>

  							</div>
  						</div>
  					</div>
  			</div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e('Affiliate Avatar Image', 'openaffiliates');?></h2>
          <p><?php esc_html_e('If Affiliates have the option to upload their own Avatar, this one can show on Affiliate Portal. ', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
  					<?php $checked = ($data['metas']['af_ap_edit_show_avatar']) ? 'checked' : '';?>
  					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_avatar');" <?php echo esc_attr($checked);?> />
  					<div class="switch af-display-inline"></div>
  				</label>
  				<input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_avatar']);?>" name="af_ap_edit_show_avatar" id="af_ap_edit_show_avatar" />
        </div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e('Display Earnings', 'openaffiliates');?></h2>
          <p><?php esc_html_e('showing or presenting the amount of money earned or received. ', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
  					<?php $checked = ($data['metas']['af_ap_edit_show_earnings']) ? 'checked' : '';?>
  					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_earnings');" <?php echo esc_attr($checked);?> />
  					<div class="switch af-display-inline"></div>
  				</label>
  				<input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_earnings']);?>" name="af_ap_edit_show_earnings" id="af_ap_edit_show_earnings" />
        </div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e('Display Referrals Count', 'openaffiliates');?></h2>
          <p><?php esc_html_e('Showing the total number of referrals that have been made. The count is displayed to track the success and impact of the affiliate program', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
            <?php $checked = ($data['metas']['af_ap_edit_show_referrals']) ? 'checked' : '';?>
            <input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_referrals');" <?php echo esc_attr($checked);?> />
            <div class="switch af-display-inline"></div>
          </label>
          <input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_referrals']);?>" name="af_ap_edit_show_referrals" id="af_ap_edit_show_referrals" />
        </div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e('Display Achievement Status until the new Rank', 'openaffiliates');?></h2>
          <p><?php esc_html_e('This means to show or present the current level of accomplishment or success until reaching the next rank. ', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
  					<?php $checked = ($data['metas']['af_ap_edit_show_achievement']) ? 'checked' : '';?>
  					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_achievement');" <?php echo esc_attr($checked);?> />
  					<div class="switch af-display-inline"></div>
  				</label>
  				<input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_achievement']);?>" name="af_ap_edit_show_achievement" id="af_ap_edit_show_achievement" />
        </div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e("Display current Affiliate's Rank", 'openaffiliates');?></h2>
          <p><?php esc_html_e('Showcasing the current position or level of an affiliate within a ranking system ', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
            <?php $checked = ($data['metas']['af_ap_edit_show_rank']) ? 'checked' : '';?>
            <input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_rank');" <?php echo esc_attr($checked);?> />
            <div class="switch af-display-inline"></div>
          </label>
          <input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_rank']);?>" name="af_ap_edit_show_rank" id="af_ap_edit_show_rank" />
        </div>

        <div class="af-form-line af-no-border">
          <h2><?php esc_html_e('Display EPC Metrics', 'openaffiliates');?></h2>
          <p><?php esc_html_e('Show the key performance indicators related to Earnings Per Click (EPC). EPC metrics are used to measure the effectiveness and profitability of affiliate campaigns. ', 'openaffiliates');?></p>
          <label class="af_label_shiwtch af-onbutton">
            <?php $checked = ($data['metas']['af_ap_edit_show_metrics']) ? 'checked' : '';?>
            <input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ap_edit_show_metrics');" <?php echo esc_attr($checked);?> />
            <div class="switch af-display-inline"></div>
          </label>
          <input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_edit_show_metrics']);?>" name="af_ap_edit_show_metrics" id="af_ap_edit_show_metrics" />
        </div>

      </div>

			<div class="inside">
				<h2><?php esc_html_e('Welcome Message', 'openaffiliates');?></h2>
        <p><?php esc_html_e('Customize the Top Message with Affiliate personal information', 'openaffiliates');?></p>
				<div class="af-wp_editor af-wp-editor">
				<?php wp_editor(stripslashes($data['metas']['af_ap_welcome_msg']), 'af_ap_welcome_msg', array('textarea_name'=>'af_ap_welcome_msg', 'editor_height'=>200));?>
				</div>
				<div class="af-constants-first">
					<h4><?php esc_html_e('Regular Tags', 'openaffiliates');?></h4>
					<?php
						$constants = array(	"{username}",
											"{first_name}",
											"{last_name}",
											"{user_id}",
											"{user_email}",
											"{user_registered}",
											"{flag}",
											"{account_page}",
											"{login_page}",
											"{blogname}",
											"{blogurl}",
											"{siteurl}",
											'{rank_id}',
											'{rank_name}'
							);
						$extra_constants = af_get_custom_constant_fields();
						foreach ($constants as $v){
							?>
							<div><?php echo esc_html($v);?></div>
							<?php
						}
						?>
						</div>
						<div class="af-constants-second">
							<h4><?php esc_html_e('Custom Fields Tags', 'openaffiliates');?></h4>
						<?php
						foreach ($extra_constants as $k=>$v){
							?>
							<div><?php echo esc_html($k);?></div>
							<?php
						}
					?>
							</div>
				</div>
				<div class="af-clear"></div>


			<div class="inside">
				<div id="af_save_changes" class="af-wrapp-submit-bttn">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large"  />

					</div>
			</div>
		</div>
		</div>
		<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Content Section', 'openaffiliates');?></h3>

			<div class="inside">
			<div class="af-register-select-template">
				<?php esc_html_e('Select Template', 'openaffiliates');?>
				<select name="af_ap_theme"><?php
					foreach ($data['themes'] as $k=>$v){
						$selected = ($k==$data['metas']['af_ap_theme']) ? 'selected' : '';
						?>
						<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
						<?php
					}
				?></select>
			</div>
			</div>
      
			<div class="inside">
      <div class="af-form-line">
        <div class="af-ap-tabs-wrapper">
					<div class="af-ap-tabs-list">
						<?php  foreach ($data['available_tabs'] as $k=>$v):?>
							<div class="af-ap-tabs-list-item <?php echo (isset($v['type']) && $v['type'] == 'subtab') ? 'af-ap-subtabs' : '';?> <?php echo (isset($v['print_link']) && $v['print_link'] == FALSE) ? 'af-ap-tab-nolink' : ''; ?>"
                onClick="<?php echo esc_attr((isset($v['print_link']) && $v['print_link'] == FALSE) ? '' : 'afApMakeVisible("'.$k.'", this);'); ?>" id="<?php echo esc_attr('af_tab-' . $k);?>">
                <?php $icon_class = '';
                    if (isset($v['type']) && $v['type'] == 'tab' && isset($v['print_link']) && $v['print_link'] == FALSE){
                      $icon_class = 'fa-af fa-account-down-af';
                    }else{
                    $icon_class = 'fa-af fa-' . $k . '-account-af';
                    }?>
                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                <?php echo esc_html($v['af_tab_' . $k . '_menu_label']);?>
              </div>
						<?php endforeach;?>
						<div class="af-clear"></div>
					</div>
					<div class="af-ap-tabs-settings">
						<?php

						$tabs = explode(',', $data['metas']['af_ap_tabs']);
						$i = 0;

						foreach ($data['available_tabs'] as $k=>$v):?>
							<div class="af-ap-tabs-settings-item" id="<?php echo esc_attr('af_tab_item_' . $k);?>">
								<div class="input-group">
									<h2><?php echo esc_html($v['af_tab_' . $k . '_menu_label']);?></h2>
									<p><?php esc_html_e('Show/Hide', 'openaffiliates');?> <?php echo esc_html($v['af_tab_' . $k . '_menu_label']);?> <?php esc_html_e('from Affiliate Portal', 'openaffiliates');?></p>
									<label class="af_label_shiwtch  af-onbutton">
										<?php $checked = (in_array($k, $tabs)) ? 'checked' : '';?>
										<input type="checkbox" class="af-switch" onClick="afMakeInputhString(this, '<?php echo esc_attr($k);?>', '#af_ap_tabs');" <?php echo esc_attr($checked);?> />
										<div class="switch af-display-inline af-activate-tab-btn"></div>
									</label>
								</div>
								<?php if (isset($data['metas']['af_tab_' . $k . '_menu_label'])) : ?>
									<div class="row">
										<div class="col-xs-12">
											<div class="input-group">
												<span class="input-group-addon"><?php esc_html_e('Menu Label', 'openaffiliates');?></span>
												<input type="text" class="form-control" placeholder="" value="<?php echo esc_attr($data['metas']['af_tab_' . $k . '_menu_label']);?>" name="<?php echo esc_attr('af_tab_' . $k . '_menu_label');?>">
											</div>
								</div>
							</div>
								<?php endif;?>
								<?php if (isset($data['metas']['af_tab_' . $k . '_title'])) : ?>
									<div class="row">
										<div class="col-xs-12">
											<div class="input-group">
												<span class="input-group-addon"><?php esc_html_e('Tab Title', 'openaffiliates');?></span>
												<input type="text" class="form-control" placeholder="" value="<?php echo esc_attr($data['metas']['af_tab_' . $k . '_title']);?>" name="<?php echo esc_attr('af_tab_' . $k . '_title');?>">
											</div>
										</div>
									</div>
								<?php endif;?>


									<!-- ICON SELECT - SHINY -->
									<div class="row af-row-icon">
										<div class="col-xs-4">
									   		<div class="input-group">
												<label><?php esc_html_e('Menu Icon', 'openaffiliates');?></label>
											<div class="af-icon-select-wrapper">
												<div class="af-icon-input">
													<div id="<?php echo esc_attr('af_shiny_select_' . $k);?>" class="af-shiny-select-html"></div>
												</div>
								   				<div class="af-icon-arrow" id="<?php echo esc_attr('af_icon_arrow_' . $k);?>"><i class="fa-af fa-arrow-af"></i></div>
												<div class="af-clear"></div>
											</div>

									   		</div>
										</div>
									</div>
									<span class="af-js-account-page-icon-details" data-slug="<?php echo esc_attr($k);?>"
										data-icon_code="<?php echo isset($data['metas']['af_tab_' . $k . '_icon_code']) ? esc_attr($data['metas']['af_tab_' . $k . '_icon_code']) : '';?>" ></span>

									<!-- ICON SELECT - SHINY -->


								<?php if (isset($data['metas']['af_tab_' . $k . '_content'])) : ?>
									<div>
										<div class="af-wp-editor"><?php
											wp_editor(stripslashes($data['metas']['af_tab_' . $k . '_content']), 'af_tab_' . $k . '_content', array('textarea_name' => 'af_tab_' . $k . '_content', 'editor_height'=>200));
										?></div>
										<div class="af-constants-first">
											<?php
												echo esc_af_content("<h4>" . esc_html__('Regular Tags', 'openaffiliates') . "</h4>");
												foreach ($constants as $v){
													?>
													<div><?php echo esc_html($v);?></div>
													<?php
												}
										?>
										</div>
										<div class="af-constants-second">
										<?php
												echo esc_af_content("<h4>" . esc_html__('Custom Fields Tags', 'openaffiliates') . "</h4>");
												foreach ($extra_constants as $k=>$v){
													?>
													<div><?php echo esc_html($k);?></div>
													<?php
												}
											?>
										</div>
									</div>
								<?php endif;?>
							</div>
						<?php endforeach;?>
					</div>
          <div class="af-clear"></div>
        </div>
				<input type="hidden" value="<?php echo esc_attr($data['metas']['af_ap_tabs']);?>" id="af_ap_tabs" name="af_ap_tabs" />
				<div id="af_save_changes" class="af-wrapp-submit-bttn">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large"  />
					</div>
        </div>
			   </div>
		</div>
		<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Bottom Section', 'openaffiliates');?></h3>

			<div class="inside">
        <div class="af-form-line">
				<h2><?php esc_html_e('Bottom Message', 'openaffiliates');?></h2>
        <p><?php esc_html_e('Additional information may be placed on the bottom of Affiliate Portal', 'openaffiliates');?></p>
				<div class="af-wp_editor af-wp-editor">
				<?php wp_editor(stripslashes($data['metas']['af_ap_footer_msg']), 'af_ap_footer_msg', array('textarea_name'=>'af_ap_footer_msg', 'editor_height'=>200));?>
				</div>
				<div class="af-constants-first">
					<h4><?php esc_html_e('Regular Tags', 'openaffiliates');?></h4>
					<?php
						$constants = array(	"{username}",
											"{first_name}",
											"{last_name}",
											"{user_id}",
											"{user_email}",
											"{user_registered}",
											"{account_page}",
											"{login_page}",
											"{blogname}",
											"{blogurl}",
											"{siteurl}",
											'{rank_id}',
											'{rank_name}'
							);
						$extra_constants = af_get_custom_constant_fields();
						foreach ($constants as $v){
							?>
							<div><?php echo esc_html($v);?></div>
							<?php
						}
						?>
						</div>
						<div class="af-constants-second">
							<h4><?php esc_html_e('Custom Fields Tags', 'openaffiliates');?></h4>
						<?php
						foreach ($extra_constants as $k=>$v){
							?>
							<div><?php echo esc_html($k);?></div>
							<?php
						}
					?>
							</div>
            </div>
				</div>
				<div class="af-clear"></div>
				<div id="af_save_changes" class="af-wrapp-submit-bttn">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
		</div>
			<div class="af-stuffbox af-custom-css-box-wrapper">
		<h3 class="af-h3"><?php esc_html_e('Custom CSS:', 'openaffiliates');?></h3>
			<div class="af-form-line">
					<textarea id="af_account_page_custom_css"  name="af_account_page_custom_css" class="af-dashboard-textarea-full af-custom-css-box"><?php echo stripslashes($data['metas']['af_account_page_custom_css']);?></textarea>
					<div id="af_save_changes" class="af-wrapp-submit-bttn">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
			</div>

		</div>
</form>
</div>
</div>
