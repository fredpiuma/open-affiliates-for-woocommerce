<div class="af-wrapper">
			<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Allow Self Referrals', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-form-line">
					<div class="row">
						<div class="col-xs-7">
							<h2><?php esc_html_e('Activate/Hold Allow Self Referrals', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Affiliates will be able to earn a commission on their own purchases via their own referral links.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_allow_own_referrence_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_allow_own_referrence_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_allow_own_referrence_enable" value="<?php echo esc_attr($data['metas']['af_allow_own_referrence_enable']);?>" id="af_allow_own_referrence_enable" />
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
