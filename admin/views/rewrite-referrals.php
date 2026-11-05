<div class="af-wrapper">
			<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Credit Last Referrer', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
					<div class="af-form-line">
					<div class="row">
						<div class="col-xs-10">
							<h2><?php esc_html_e('Activate/Hold Credit Last Referrer', 'openaffiliates');?></h2>
							<p><?php esc_html_e("Decides if a new customer is re-assigned to the first or last linked affiliate. If the same customer is referred to a different affiliate than the first one, you can decide if the reference will be changed or not.
Example: John is a customer that is linked to Smith (affiliate). John enters the website but does not buy anything. Later, John enters the website through Bob's link (affiliate) and makes a purchase. You can decide if John will be linked to the first affiliate (Smith), or the last one (Bob), therefore deciding which affiliate will receive referral.", 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_rewrite_referrals_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_rewrite_referrals_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_rewrite_referrals_enable" value="<?php echo esc_attr($data['metas']['af_rewrite_referrals_enable']);?>" id="af_rewrite_referrals_enable" />
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
