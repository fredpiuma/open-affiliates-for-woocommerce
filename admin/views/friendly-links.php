<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Pretty Affiliate Links', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-8">
					<h2><?php esc_html_e('Activate/Hold Pretty Affiliate Links', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Affiliates will be able to use friendly links instead of the default one. They have a better looking structure and are easier to read. Ex: www.yourwebsite.com/ref/smith', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_friendly_links']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_friendly_links');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_friendly_links" value="<?php echo esc_attr($data['metas']['af_friendly_links']);?>" id="af_friendly_links" />
				</div>
			</div>
			<br/>
			<p><?php esc_html_e('This feature is recommended only when the referral format is based on username. Affiliates will not be able to build custom links into a friendly structure with variables inside. Ex: ?order=true', 'openaffiliates');?></p>
			<p><?php esc_html_e('Refreshing the WP permalinks may be required.', 'openaffiliates');?></p>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
		</div>
	</div>
</form>
</div>
