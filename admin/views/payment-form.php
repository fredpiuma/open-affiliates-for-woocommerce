
<div class="af-wrapper af-payment-form-settings-wrapper">
	<div class="af-page-title"><?php esc_html_e('Manage Payout', 'openaffiliates');?></div>
	<form method="post" action="<?php echo esc_url($data['submit_link']);?>">

		<input type="hidden" name="af_admin_payment_nonce" value="<?php echo wp_create_nonce( 'af_admin_payment_nonce' );?>" />

		<div class="row">
				<?php
					$checked_paypal = '';
					$checked_bt = '';
					$checked_stripe = '';
					$checked_stripe_v2 = '';
					$checked_stripe_v3 = '';

					if (!empty($data['affiliate_pay']) && !empty($data['affiliate_pay']['payment_gateway_data']) && !empty($data['affiliate_pay']['payment_gateway_data']['type'])){
						switch ($data['affiliate_pay']['payment_gateway_data']['type']){
							case 'paypal':
								$checked_paypal = 'checked';
								break;
							case 'stripe':
								$checked_stripe = 'checked';
								break;
							case 'stripe_v2':
								$checked_stripe_v2 = 'checked';
								break;
							case 'stripe_v3':
								$checked_stripe_v3 = 'checked';
								break;
							case 'bank_transfer':
							default:
								$checked_bt = 'checked';
								break;
						}
					} else {
						$checked_bt = 'checked';
					}
				?>
				<div class="col-xs-4">
					<div class="payment-box">
						<h3><?php esc_html_e('Pay With', 'openaffiliates');?></h3>
						<p><?php esc_html_e('Choose one of the Payment Gateway Option. "Direct Deposit" is an offline alternative payment.', 'openaffiliates');?></p>
						<?php if (!empty($data['paypal'])):?>
						<div class="af-list-affiliates-name-label">
							<input type="radio" value="paypal" name="paywith" onClick="afPaymentFormPaymentStatus(this.value);" <?php echo esc_attr($checked_paypal);?> /> <?php esc_html_e('PayPal', 'openaffiliates');?>
						</div>
						<?php endif;?>
						<div  class="af-list-affiliates-name-label">
							<input type="radio" value="bank_transfer" name="paywith" onClick="afPaymentFormPaymentStatus(this.value);" <?php echo esc_attr($checked_bt);?> /> <?php esc_html_e('Direct Deposit', 'openaffiliates');?>
						</div>
						<?php if (!empty($data['stripe'])):?>
						<div class="af-list-affiliates-name-label">
							<input type="radio" value="stripe" name="paywith" onClick="afPaymentFormPaymentStatus(this.value);" <?php echo esc_attr($checked_stripe);?> /> <?php esc_html_e('Stripe', 'openaffiliates');?>
						</div>
						<?php endif;?>
						<?php if (!empty($data['stripe_v2'])):?>
						<div class="af-list-affiliates-name-label" >
							<input type="radio" value="stripe_v2" name="paywith" onClick="afPaymentFormPaymentStatus(this.value);" <?php echo esc_attr($checked_stripe_v2);?> /> <?php esc_html_e('Stripe', 'openaffiliates');?>
						</div>
						<?php endif;?>
						<?php if (!empty($data['stripe_v3'])):?>
						<div class="af-list-affiliates-name-label">
							<input type="radio" value="stripe_v3" name="paywith" onClick="afPaymentFormPaymentStatus(this.value);" <?php echo esc_attr($checked_stripe_v3);?> /> <?php esc_html_e('Stripe', 'openaffiliates');?>
						</div>
						<?php endif;?>
					</div>
				</div>

				<div class="col-xs-4">
					<?php $display = ($checked_bt) ? 'af-display-block' : 'af-display-none';?>
					<div class="payment-box <?php echo esc_attr($display);?>" id="payment_status_div">
						<h3><?php esc_html_e('Payment Status', 'openaffiliates');?></h3>
						<p><?php esc_html_e('As "Direct Deposit" payment option you can set for now the a temporary Payment status.', 'openaffiliates');?></p>
						<div  class="af-list-affiliates-name-label">
							<input type="radio" value="1" name="payment_status" /> <?php esc_html_e('Pending', 'openaffiliates');?>
						</div>
						<div class="af-list-affiliates-name-label">
							<input type="radio" value="2" name="payment_status" checked/> <?php esc_html_e('Complete', 'openaffiliates');?>
						</div>
					</div>
				</div>
			</div>
			<div class="af-buttons-wrapper">
				<input type="submit" value="<?php esc_html_e('Submit', 'openaffiliates');?>" name="do_payment" class="button button-primary button-large" />
				<button class="button button-primary button-large af-js-location-reload" data-url="<?php echo esc_url($data['return_url']);?>" ><?php esc_html_e('Cancel', 'openaffiliates');?></button>
			</div>
		<?php if (!empty($data['affiliate_pay'])) : ?>
		<table class="wp-list-table widefat fixed tags">
						<thead>
							<tr>
								<th><?php esc_html_e('Username', 'openaffiliates');?></th>
								<th><?php esc_html_e('Name', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Details', 'openaffiliates');?></th>
								<th><?php esc_html_e('Rank', 'openaffiliates');?></th>
								<th><?php esc_html_e('E-mail', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
							</tr>
						</thead>
				<tbody class="ui-sortable af-alternate">
				<tr>
					<td><?php echo esc_html($data['affiliate_pay']['username']);?></td>
					<td><?php echo esc_html($data['affiliate_pay']['name']);?></td>
					<td><?php
						if (!empty($data['affiliate_pay']['payment_gateway_data']) && !empty($data['affiliate_pay']['payment_gateway_data']['type'])){
							$temp_key = $data['affiliate_pay']['payment_gateway_data']['type'];
							switch ($temp_key):
								case 'paypal':
									$payment_class = ($data['affiliate_pay']['payment_gateway_data']['is_active']) ? 'af-payment-type-active-paypal' : '';
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">PayPal</span>
									<?php
									break;
								case 'bt':
									$payment_class = ($data['affiliate_pay']['payment_gateway_data']['is_active']) ? 'af-payment-type-active-bt' : '';
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('Direct Deposit', 'openaffiliates');?></span>
									<?php
									break;
								case 'stripe':
									$payment_class = '';
									if ($data['affiliate_pay']['payment_gateway_data']['is_active'] && !empty($data['affiliate_pay']['payment_gateway_data']['settings']) && !empty($data['affiliate_pay']['payment_gateway_data']['settings']['af_affiliate_stripe_name'])
										&& !empty($data['affiliate_pay']['payment_gateway_data']['settings']['af_affiliate_stripe_card_number']) && !empty($data['affiliate_pay']['payment_gateway_data']['settings']['af_affiliate_stripe_expiration_month'])
										&& !empty($data['affiliate_pay']['payment_gateway_data']['settings']['af_affiliate_stripe_expiration_year']) ) //&& !empty($data['affiliate_pay']['payment_gateway_data']['settings']['af_affiliate_stripe_cvc'])
									{
										$payment_class = 'af-payment-type-active-stripe';
									}
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">Stripe</span>
									<?php
									break;
								case 'stripe_v2':
									$payment_class = '';
									if ($data['affiliate_pay']['payment_gateway_data']['is_active']){
										$payment_class = 'af-payment-type-active-stripe_v2';
									}
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">Stripe</span>
									<?php
									break;
								case 'stripe_v3':
										$payment_class = '';
										if ($data['affiliate_pay']['payment_gateway_data']['is_active']){
											$payment_class = 'af-payment-type-active-stripe_v3';
										}
										?>
										<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">Stripe</span>
										<?php
										break;
							endswitch;
						} else {
							echo esc_html('-');
						}
					?></td>
					<td><?php
						echo af_return_payment_details_for_admin_table($data['affiliate_pay']['payment_gateway_data']);
					?></td>
					<td><?php echo esc_html($data['affiliate_pay']['rank']);?></td>
					<td><?php echo esc_html($data['affiliate_pay']['email']);?>
					<input type="hidden" value="<?php echo esc_attr($data['affiliate_pay']['email']);?>" name="email" /></td>
					<td><strong><?php echo esc_html($data['affiliate_pay']['amount'] . $data['currency']);?></strong>

				<input type="hidden" value="<?php echo esc_attr($data['affiliate_pay']['amount']);?>" name="amount" />
			<input type="hidden" value="<?php echo esc_attr($data['currency']);?>" name="currency" />
			<input type="hidden" value="<?php echo esc_attr($data['affiliate_pay']['referrals_in']);?>" name="referrals_in" />
			<input type="hidden" value="<?php echo esc_attr($data['affiliate_pay']['affiliate_id']);?>" name="affiliate_id" />
					</td>
				</tr>

				</tbody>
				<tfoot>
					<tr>
						<th><?php esc_html_e('Username', 'openaffiliates');?></th>
						<th><?php esc_html_e('Name', 'openaffiliates');?></th>
						<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
						<th><?php esc_html_e('Payment Details', 'openaffiliates');?></th>
						<th><?php esc_html_e('Rank', 'openaffiliates');?></th>
						<th><?php esc_html_e('E-mail', 'openaffiliates');?></th>
						<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					</tr>
				</tfoot>
				</table>


		<?php elseif (!empty($data['multiple_affiliates'])) :?>
			<table class="wp-list-table widefat fixed tags">
						<thead>
							<tr>
								<th><?php esc_html_e('Username', 'openaffiliates');?></th>
								<th><?php esc_html_e('Name', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Details', 'openaffiliates');?></th>
								<th><?php esc_html_e('Rank', 'openaffiliates');?></th>
								<th><?php esc_html_e('E-mail', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?php esc_html_e('Username', 'openaffiliates');?></th>
								<th><?php esc_html_e('Name', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Details', 'openaffiliates');?></th>
								<th><?php esc_html_e('Rank', 'openaffiliates');?></th>
								<th><?php esc_html_e('E-mail', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
							</tr>
						</tfoot>
				<tbody class="ui-sortable af-alternate">
			<?php foreach ($data['multiple_affiliates'] as $id => $array): ?>
				<?php $affiliates[] = $id;?>
				<tr>
					<td><?php echo esc_html($array['username']);?></td>
					<td><?php echo esc_html($array['name']);?></td>
					<td><?php
						if (!empty($array['payment_gateway_data']) && !empty($array['payment_gateway_data']['type'])){
							$temp_key = $array['payment_gateway_data']['type'];
							switch ($temp_key):
								case 'paypal':
									$payment_class = ($array['payment_gateway_data']['is_active']) ? 'af-payment-type-active-paypal' : '';
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">PayPal</span>
									<?php
									break;
								case 'bt':
									$payment_class = ($array['payment_gateway_data']['is_active']) ? 'af-payment-type-active-bt' : '';
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('Direct Deposit', 'openaffiliates');?></span>
									<?php
									break;
								case 'stripe':
									$payment_class = '';
									if ($array['payment_gateway_data']['is_active'] && !empty($array['payment_gateway_data']['settings']) && !empty($array['payment_gateway_data']['settings']['af_affiliate_stripe_name'])
										&& !empty($array['payment_gateway_data']['settings']['af_affiliate_stripe_card_number']) && !empty($array['payment_gateway_data']['settings']['af_affiliate_stripe_expiration_month'])
										&& !empty($array['payment_gateway_data']['settings']['af_affiliate_stripe_expiration_year']) ) //&& !empty($array['payment_gateway_data']['settings']['af_affiliate_stripe_cvc'])
									{
										$payment_class = 'af-payment-type-active-stripe';
									}
									?>
									<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">Stripe</span>
									<?php
									break;
							endswitch;
						} else {
							echo esc_html('-');
						}
					?></td>
					<td><?php
						echo af_return_payment_details_for_admin_table($array['payment_gateway_data']);
					?></td>
					<td><?php echo esc_html($array['rank']);?></td>
					<td><?php echo esc_html($array['email']);?></td>
					<td><strong><?php echo af_format_price_and_currency($data['currency'], $array['amount']);?></strong>

				<input type="hidden" value="<?php echo esc_attr($array['referrals']);?>" name="referrals[<?php echo esc_attr($id);?>]" />
				<input type="hidden" value="<?php echo esc_attr($array['amount']);?>" name="amount[<?php echo esc_attr($id);?>]" />
				<input type="hidden" value="<?php echo esc_attr($data['currency']);?>" name="currency[<?php echo esc_attr($id);?>]" />
					</td>
				</tr>
			<?php endforeach;?>

						</tbody>
				</table>
			<?php $affiliates = implode(',', $affiliates)?>
			<input type="hidden" value="<?php echo esc_attr($affiliates);?>" name="affiliates" />
		<?php endif;?>

	</form>
</div>
