<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('BuddyPress Account Page', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
					<h2><?php esc_html_e('Activate/Hold Affiliate Section', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Fully integrate a user "Affiliate Account" in their "BuddyPress Profile". Once activated, a new tab in their "BuddyPress" menu will show up.', 'openaffiliates');?></p>
					<label class="af_bp_account_page_enable af-switch-button-margin">
					<?php $checked = ($data['metas']['af_bp_account_page_enable']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_bp_account_page_enable');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_bp_account_page_enable" value="<?php echo esc_attr($data['metas']['af_bp_account_page_enable']);?>" id="af_bp_account_page_enable" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-5">
					<div class="input-group input-group-extra-margin">
						<span class="input-group-addon" ><?php esc_html_e('Menu Label', 'openaffiliates');?></span>
						<input type="text" class="form-control" name="af_bp_account_page_name" value="<?php echo esc_attr($data['metas']['af_bp_account_page_name']);?>" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-5">
					<div class="input-group">
						<span class="input-group-addon" ><?php esc_html_e('Menu Position', 'openaffiliates');?></span>
						<input type="number" class="form-control" name="af_bp_account_page_position" value="<?php echo esc_attr($data['metas']['af_bp_account_page_position']);?>" min=1 />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-7">
					<h2><?php esc_html_e('Non-Affiliate Users', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Even the non-affiliate users will see the new option but instead of "Affiliate Account Page", custom content will show up.', 'openaffiliates');?></p>
					<label class="woo_account_page_enable af-switch-button-margin">
					<?php $checked = ($data['metas']['af_bp_account_page_show_to_everyone']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_bp_account_page_show_to_everyone');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_bp_account_page_show_to_everyone" value="<?php echo esc_attr($data['metas']['af_bp_account_page_show_to_everyone']);?>" id="af_bp_account_page_show_to_everyone" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h4><?php esc_html_e('Custom Content for Non-Affiliate Users:', 'openaffiliates');?></h4>
					<div class="af-wp_editor af-wp-editor-box">
					<?php wp_editor(stripslashes($data['metas']['af_bp_account_page_non_affiliate_content']), 'af_bp_account_page_non_affiliate_content', array('textarea_name'=>'af_bp_account_page_non_affiliate_content', 'editor_height'=>200));?>
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
