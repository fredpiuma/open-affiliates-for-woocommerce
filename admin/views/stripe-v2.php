<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Stripe v2 - Payouts', 'openaffiliates');?></h3>
		<div class="inside">
<?php af_external_service_notice( 'payout amounts, currency and connected-account data', 'Stripe (api.stripe.com, connect.stripe.com)' );?>
			<div class="af-form-line">
				<div class="row">
						<div class="col-xs-7">
							<h2><?php esc_html_e('Activate/Hold Stripe Gateway', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Once activated you can process payments to your affiliate users via Stripe directly from the affiliate system.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_stripe_v2_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_stripe_v2_enable');" <?php echo esc_attr($checked);?> disabled />
								<div class="switch af-display-inline af-opacity-disabled"></div>
							</label>
							<input type="hidden" name="af_stripe_v2_enable" value="<?php echo esc_attr($data['metas']['af_stripe_v2_enable']);?>" id="af_stripe_v2_enable" />
							<p><strong><?php esc_html_e('This Stripe API is deprecated. Please use Stripe V3 module instead.', 'openaffiliates');?></strong></p>
						</div>
				</div>

				<div class="row">
					<div class="col-xs-4">
						<h2><?php esc_html_e('Sandbox', 'openaffiliates');?></h2>
						<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_stripe_v2_sandbox']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_stripe_v2_sandbox');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_stripe_v2_sandbox" value="<?php echo esc_attr($data['metas']['af_stripe_v2_sandbox']);?>" id="af_stripe_v2_sandbox" />
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<div class="af-form-line">

							<div class="input-group">
							<label class="input-group-addon"><?php esc_html_e('Sandbox Secret Key', 'openaffiliates');?></label>
								<input type="text" name="af_stripe_v2_sandbox_secret_key" value="<?php echo esc_attr($data['metas']['af_stripe_v2_sandbox_secret_key']);?>" / class="form-control">
						 </div>
						 <div class="af-form-line"></div>
						 <div class="input-group">
							<label class="input-group-addon"><?php esc_html_e('Sandbox Publishable Key', 'openaffiliates');?></label>
							<input type="text" name="af_stripe_v2_sandbox_publishable_key" value="<?php echo esc_attr($data['metas']['af_stripe_v2_sandbox_publishable_key']);?>" class="form-control" />
							</div>
							<div class="af-form-line"></div>
							<div class="input-group">
							<label class="input-group-addon"><?php esc_html_e('Live Secret Key', 'openaffiliates');?></label>
								<input type="text" name="af_stripe_v2_secret_key" value="<?php echo esc_attr($data['metas']['af_stripe_v2_secret_key']);?>" class="form-control" />
							</div>
							<div class="af-form-line"></div>
							<div class="input-group">
							<label class="input-group-addon"><?php esc_html_e('Live Publishable Key', 'openaffiliates');?></label>
								<input type="text" name="af_stripe_v2_publishable_key" value="<?php echo esc_attr($data['metas']['af_stripe_v2_publishable_key']);?>" class="form-control" />
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
						<li><?php esc_html_e('2. Click on "Dashboard".', 'openaffiliates');?></li>
						<li><?php esc_html_e('3. In left you will find a menu that contains "Developers" section. Enter into this section and you will find the API Keys("Secret Key" and "Publishable Key").', 'openaffiliates');?></li>
						<li><?php echo esc_html__('4. Do not forget to set Your Webhook at: ', 'openaffiliates') . '<b>' . $notification_url . '</b>';?></li>
						<li><?php esc_html_e('5. Be sure you use the same currency in the Stripe account and in the "Open Affiliates" settings.', 'openaffiliates');?></li>
						<li><?php echo esc_html__('For testing purposes, you can find card credentials here: ', 'openaffiliates') . '<a href="https://stripe.com/docs/testing#test-debit-card-numbers" target="_blank">https://stripe.com/docs/testing#test-debit-card-numbers</a>';?></li>
					</ul>
				</div>

				<div id="af_save_changes" class="af-submit-form">
					<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
				</div>
			</div>
		</div>
	</div>
</form>

<div class="af-stuffbox">
	<h3 class="af-h3"><?php esc_html_e('Additional informations', 'openaffiliates');?></h3>
	<div class="inside">
			<div class="row">
					<div class="col-xs-7">
						<div><?php esc_html_e('Accepted countries:', 'openaffiliates');?></div>
						<div>- United States (US)</div>
						<div>- Great Britain (GB)</div>
						<div>- Denmark (DK)</div>
						<div>- Germany (DE)</div>
						<div>- Belgium (BE)</div>
						<div>- Italy (IT)</div>
						<div>- Switzerland (CH)</div>
						<div>- Austria (AT)</div>
						<div>- Finland (FI)</div>
						<div>- Netherlands (NL)</div>
						<div>- Norway (NO)</div>
						<div>- Sweden (SE)</div>
						<div>- Spain (ES)</div>
						<div>- Republic of Ireland (IE)</div>
						<div>- Luxembourg (LU)</div>
						<div>- Portugal (PT)</div>
					</div>
					<?php echo esc_html__('You can find more details here: ', 'openaffiliates') . '<a href="https://stripe.com/docs/connect/testing" target="_blank">https://stripe.com/docs/connect/testing</a>';?>
				</div>
		</div>
</div>

<div class="af-stuffbox">
	<h3 class="af-h3"><?php esc_html_e('Testing payout data', 'openaffiliates');?></h3>
	<div class="inside">
			<div class="row">
					<div class="col-xs-7">
							<div><?php echo esc_html__('Country: ', 'openaffiliates') . ' US';?></div>
							<div><?php echo esc_html__('Bank number. Account: ', 'openaffiliates') . ' 000123456789 . ' . esc_html__('Rounting: ', 'openaffiliates') . ' 110000000 .';?></div>
							<div><?php echo esc_html__('Personal ID numbers: ', 'openaffiliates') . ' 000000000 .';?></div>
							<div><?php echo esc_html__('Business tax ID: ', 'openaffiliates') . ' 000000000 .';?></div>
					</div>
				</div>
		</div>
</div>
