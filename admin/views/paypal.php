<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php  esc_html_e('PayPal - Payouts', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php  esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
<?php af_external_service_notice( "payout amounts, currency and the beneficiaries' PayPal e-mail addresses", 'PayPal (api.paypal.com)' );?>
			<div class="af-form-line">
			<?php if ((float)$phpversion>=5.4):?>
				<div class="row">
						<div class="col-xs-7">
							<h2><?php  esc_html_e('Activate/Hold PayPal Gateway', 'openaffiliates');?></h2>
							<p><?php  esc_html_e('Once activated you can process payments to your affiliate users via PayPal directly from the affiliate system.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_paypal_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_paypal_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_paypal_enable" value="<?php echo esc_attr($data['metas']['af_paypal_enable']);?>" id="af_paypal_enable" />
						</div>
						</div>

				<div class="row">
					<div class="col-xs-4">
						<h2><?php  esc_html_e('Sandbox Mode', 'openaffiliates');?></h2>
						<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_paypal_sandbox']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch af-js-paypal-sandbox-on-off" onClick="afCheckAndH(this, '#af_paypal_sandbox');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_paypal_sandbox" value="<?php echo esc_attr($data['metas']['af_paypal_sandbox']);?>" id="af_paypal_sandbox" />
					</div>
				</div>

				<div class="row">
					<div class="col-xs-10">
						<div class="af-js-paypal-sandbox-credentials  <?php echo ( !$data['metas']['af_paypal_sandbox'] ) ? "af-display-none" : '';?> ">
								<div class="af-form-line">
									<div class="input-group">
							         <span class="input-group-addon"><?php esc_html_e('Sandbox Client ID', 'openaffiliates');?></span>
									<input type="text" name="af_paypal_sandbox_client_id" value="<?php echo esc_attr($data['metas']['af_paypal_sandbox_client_id']);?>" class="form-control"/>
								</div>

								<div class="af-form-line"></div>

								<div class="input-group">
									<span class="input-group-addon"><?php  esc_html_e('Sandbox Client Secret', 'openaffiliates');?></span>
									<input type="text" name="af_paypal_sandbox_client_secret" value="<?php echo esc_attr($data['metas']['af_paypal_sandbox_client_secret']);?>" class="form-control"/>
								</div>
							</div>
						</div>

						<div class="af-js-paypal-live-credentials <?php echo ( $data['metas']['af_paypal_sandbox'] ) ? "af-display-none" : '';?>"  >
								<div class="af-form-line">
									<div class="input-group">
									<span class="input-group-addon"><?php  esc_html_e('Client ID', 'openaffiliates');?></span>
									<input type="text" name="af_paypal_client_id" value="<?php echo esc_attr($data['metas']['af_paypal_client_id']);?>" class="form-control" />
								</div>

								<div class="af-form-line"></div>

								<div class="input-group">
									<span class="input-group-addon"><?php  esc_html_e('Client Secret', 'openaffiliates');?></span>
									<input type="text" name="af_paypal_client_secret" value="<?php echo esc_attr($data['metas']['af_paypal_client_secret']);?>" class="form-control" />
								</div>
							</div>
						</div>

				</div>
				</div>

				<div>
					<ul class="af-info-list">
						<li><?php  esc_html_e('1. Go to ', 'openaffiliates');?><a href="https://developer.paypal.com/" target="_blank">https://developer.paypal.com/</a> <?php  esc_html_e('and login with your PayPal email and password.', 'openaffiliates');?></li>
						<li><?php  esc_html_e('2. After you have successfully logged in go to: ', 'openaffiliates');?> <a target="_blank" href="https://developer.paypal.com/developer/applications/">https://developer.paypal.com/developer/applications/</a> <?php  esc_html_e(' and create a new REST API application.', 'openaffiliates');?></li>
						<li><?php  esc_html_e('3. After you have created a new application, the "Client ID" and "Client Secret" will be available.', 'openaffiliates');?></li>
						<li><?php  esc_html_e( '4. Be sure your PayPal account has permissions for Payouts.', 'openaffiliates' );?> <a href='https://developer.paypal.com/developer/accountStatus/' target="_blank">https://developer.paypal.com/developer/accountStatus/</a></li>
					</ul>
				</div>

				<div id="af_save_changes" class="af-submit-form">
					<input type="submit" value="<?php  esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
				</div>
			<?php else : ?>
				<div class="af-color-red">
					<?php echo esc_html__("Your current version of PHP is ", 'openaffiliates') . $phpversion . esc_html__('. To use this feature You need >= PHP 5.4.', 'openaffiliates');?>
				</div>
			<?php endif;?>
		</div>
		</div>
	</div>
</form>
</div>
