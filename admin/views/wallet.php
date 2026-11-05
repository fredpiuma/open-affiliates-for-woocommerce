<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Wallet', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-8">
					<h2><?php esc_html_e('Activate/Hold Wallet', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Affiliates will have the option to spend their earnings directly in the website by using generated coupons with a specific flat discount.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_wallet_enable']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_wallet_enable');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_wallet_enable" value="<?php echo esc_attr($data['metas']['af_wallet_enable']);?>" id="af_wallet_enable" />
				</div>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<p><?php esc_html_e('Establish a minimum amount required for an affiliate to be able to move his earnings from his account into his wallet. Only referrals that are verified but not yet paid can be available for converting into coupons in an affiliate "Wallet".', 'openaffiliates');?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="input-group">
						<label class="input-group-addon"><?php esc_html_e('Minimum Amount', 'openaffiliates');?></label>
						<input type="number" class="form-control" step='<?php echo afInputNumerStep();?>' name="af_wallet_minimum_amount" value="<?php echo esc_attr($data['metas']['af_wallet_minimum_amount']);?>" />

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-4">
					<div class="input-group">
						<label class="iump-labels-special"><?php esc_html_e('Excluded sources:', 'openaffiliates');?></label>
						<div>
								<?php
									if ($data['metas']['af_wallet_exclude_sources']!='')
											$temp = explode(',', $data['metas']['af_wallet_exclude_sources']);
									else
											$temp = array();
									$types = af_get_active_services();
									foreach ($types as $key=>$value):?>
									<div>
										<label class="af-checkbox-wrapp">
										<input type="checkbox" <?php echo (in_array($key, $temp)) ? 'checked' : '';?> onClick="afMakeInputhString(this, '<?php echo esc_attr($key);?>', '#af_wallet_exclude_sources');" /> <?php echo esc_attr($value);?>
										<span class="af-checkmark"></span>
									</label>
									</div>
								<?php endforeach;?>
						</div>
						<input type="hidden" name="af_wallet_exclude_sources" value="<?php echo esc_attr($data['metas']['af_wallet_exclude_sources']);?>" id="af_wallet_exclude_sources"/>
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
