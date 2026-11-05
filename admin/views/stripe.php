<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Stripe - Payouts', 'openaffiliates');?></h3>
		<div class="inside">
<?php af_external_service_notice( 'payout amounts, currency and connected-account data', 'Stripe (api.stripe.com, connect.stripe.com)' );?>
				<div class="row">
						<div class="col-xs-7">
							<h3><?php esc_html_e('Activate/Hold Stripe Gateway', 'openaffiliates');?></h3>
							<p><?php esc_html_e('Once activated you can process payments to your affiliate users via Stripe directly from the affiliate system.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_stripe_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_stripe_enable');" <?php echo esc_attr($checked);?> disabled />
								<div class="switch af-display-inline af-opacity-disabled"></div>
							</label>
							<input type="hidden" name="af_stripe_enable" value="<?php echo esc_attr($data['metas']['af_stripe_enable']);?>" id="af_stripe_enable" />
							<p><strong><?php esc_html_e('This Stripe API is deprecated. Use Stripe V3 module instead.', 'openaffiliates');?></strong></p>
						</div>
				</div>
				<div class="af-line-break"></div>
				<div class="row">
					<div class="col-xs-4">
						<h4><?php esc_html_e('Sandbox', 'openaffiliates');?></h4>
						<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_stripe_sandbox']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_stripe_sandbox');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_stripe_sandbox" value="<?php echo esc_attr($data['metas']['af_stripe_sandbox']);?>" id="af_stripe_sandbox" />
					</div>
				</div>
				<div class="af-line-break"></div>
				<div class="row">
					<div class="col-xs-6">
						<div class="af-form-line">
							<label class="af-label"><?php esc_html_e('Sandbox Secret Key', 'openaffiliates');?></label>
							<div>
								<input type="text" name="af_stripe_sandbox_secret_key" value="<?php echo esc_attr($data['metas']['af_stripe_sandbox_secret_key']);?>" />
							</div>
						</div>
						<div class="af-form-line">
							<label class="af-label"><?php esc_html_e('Sandbox Publishable Key', 'openaffiliates');?></label>
							<div>
								<input type="text" name="af_stripe_sandbox_publishable_key" value="<?php echo esc_attr($data['metas']['af_stripe_sandbox_publishable_key']);?>" />
							</div>
						</div>
						<div class="af-form-line">
							<label class="af-label"><?php esc_html_e('Live Secret Key', 'openaffiliates');?></label>
							<div>
								<input type="text" name="af_stripe_secret_key" value="<?php echo esc_attr($data['metas']['af_stripe_secret_key']);?>" />
							</div>
						</div>
						<div class="af-form-line">
							<label class="af-label"><?php esc_html_e('Live Publishable Key', 'openaffiliates');?></label>
							<div>
								<input type="text" name="af_stripe_publishable_key" value="<?php echo esc_attr($data['metas']['af_stripe_publishable_key']);?>" />
							</div>
						</div>
					</div>
				</div>

				<div>
					<ul class="af-info-list">
						<?php

							$notification_url = site_url();
							$notification_url = trailingslashit($notification_url);
							$notification_url = add_query_arg('af_act', 'stripe_payout', $notification_url);
						?>
						<li><?php esc_html_e('1. Go to', 'openaffiliates');?> <a href="http://stripe.com" target="_blank">http://stripe.com</a> <?php esc_html_e(' and login with username and password.', 'openaffiliates');?></li>
						<li><?php esc_html_e('2. Click on "Dashboard", and then select "Your account" -> "Account settings".', 'openaffiliates');?></li>
						<li><?php esc_html_e('3. A popup will appear and you must go to API Keys, here you will find the "Secret Key" and "Publishable Key".', 'openaffiliates');?></li>
						<li><?php echo esc_html__('4. Do notforget to set Your Webhook at: ', 'openaffiliates') . '<b>' . $notification_url . '</b>';?></li>
						<li><?php esc_html_e('5. Be sure you use the same currency in the Stripe account and in the "Open Affiliates" settings.', 'openaffiliates');?></li>
						<li><?php echo esc_html__('For testing purposes, you can find card credentials here: ', 'openaffiliates') . '<a href="https://stripe.com/docs/testing#test-debit-card-numbers" target="_blank">https://stripe.com/docs/testing#test-debit-card-numbers</a>';?></li>
					</ul>
				</div>

				<div class="af-submit-form">
					<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
				</div>
		</div>
	</div>
</form>
