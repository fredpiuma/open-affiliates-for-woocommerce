<div class="af-wrapper">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Affiliate Payment Settings');?></h3>
		<div class="inside">
			<?php
			if (!empty($data['metas']['af_affiliate_payment_type'])):
				$types = array('stripe'=>'Stripe', 'paypal'=>'PayPal', 'bt'=>'Direct Deposit', 'stripe_v2' => 'Stripe', 'stripe_v3' => 'Stripe');
				echo esc_af_content("<div><label>" . esc_html__('Payment Type:', 'openaffiliates') . "</label> " . $types[$data['metas']['af_affiliate_payment_type']] . "</div>");
				switch ($data['metas']['af_affiliate_payment_type']){
					case 'stripe':
						?>
						<div><label><?php echo esc_html__("Name on Card:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_stripe_name']);?></div>
						<div><label><?php echo esc_html__("Card Number:", 'openaffiliates');?></label> <?php  echo esc_html($data['metas']['af_affiliate_stripe_card_number']);?></div>
						<!-- div><label><?php echo esc_html__("CVC:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_stripe_cvc']);?></div -->
						<div><label><?php echo esc_html__("Expiration:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_stripe_expiration_month']) . '/'. esc_html($data['metas']['af_affiliate_stripe_expiration_year']);?></div>
						<div><label><?php echo esc_html__("Type:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_stripe_card_type']);?></div>
						<?php
						break;
					case 'bt':
						?>
						<div><label><?php echo esc_html__("Bank Transfer Details:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_bank_transfer_data']);?></div>
						<?php
						break;
					case 'paypal':
						?>
						<div><label><?php echo esc_html__("PayPal E-mail Address:", 'openaffiliates');?></label> <?php echo esc_html($data['metas']['af_affiliate_paypal_email']);?></div>
						<?php
						break;
					case 'stripe_v2':
						$uids = 0;
						if(isset($_GET['uid'])){
							$uids = sanitize_text_field($_GET['uid']);
						}
						$stripe_v2_data = $af_db->get_affiliate_stripe_v2_payment_settings($uids);
						$possible = array(
											'first_name' => esc_html__('First Name', 'openaffiliates'),
											'last_name' => esc_html__('Last Name', 'openaffiliates'),
											'first_name' => esc_html__('First Name', 'openaffiliates'),
											'day' => esc_html__('Birth day', 'openaffiliates'),
											'month' => esc_html__('Month', 'openaffiliates'),
											'year' => esc_html__('Year', 'openaffiliates'),
											'country' => esc_html__('Country', 'openaffiliates'),
											'state' => esc_html__('State', 'openaffiliates'),
											'city' => esc_html__('City', 'openaffiliates'),
											'line1' => esc_html__('Line1', 'openaffiliates'),
											'postal_code' => esc_html__('Postal Code', 'openaffiliates'),
											'user_type' => esc_html__('User Type', 'openaffiliates'),
											'routing_number' => esc_html__('Routing Number', 'openaffiliates'),
											'account_number' => esc_html__('Account Number', 'openaffiliates'),
											'ssn_last_4' => esc_html__('SSN last 4', 'openaffiliates'),
											'personal_id_number' => esc_html__('Personal id number', 'openaffiliates'),
											'business_name' => esc_html__('Business name', 'openaffiliates'),
											'business_tax_id' => esc_html__('Business tax id', 'openaffiliates'),
											'personal_address.city' => esc_html__('Personal Address City', 'openaffiliates'),
											'personal_address.line1' => esc_html__('Personal Address Line1', 'openaffiliates'),
											'personal_address.postal_code' => esc_html__('Personal Address Postal Code', 'openaffiliates'),
						);
						?>

						<?php foreach ($possible as $key=>$label):?>
							<?php if (isset($stripe_v2_data[$key])):?>
							<div><label><?php echo esc_html($label);?>:</label> <?php echo esc_html($stripe_v2_data[$key]);?></div>
							<?php endif;?>
						<?php endforeach;?>

						<?php
						break;
					case 'stripe_v3':
						$accountId = get_user_meta( $uid, 'af_stripe_v3_user_account_id', true );
						if ( $accountId != false && $accountId != '' ):
							$stripe_link = '';
							$sandbox = get_option( 'af_stripe_v3_sandbox' );
							if ( $sandbox ){
									$stripe_link = 'https://dashboard.stripe.com/test/connect/accounts/'.$accountId;
							}else{
									$stripe_link = 'https://dashboard.stripe.com/connect/accounts/'.$accountId;
							}
							?>
							<div class="af-payment-details-do-payment">
									<a href="<?php echo esc_url($stripe_link);?>" target="_blank"><?php
									_e( 'View Stripe Affiliate Account', 'openaffiliates');
							?></a></div>
					<?php else :?>
						<div class="af-payment-details-do-payment"><?php esc_html_e('Incomplete Payment Settings', 'openaffiliates');?></div>
						<?php endif;
						break;
				}
			endif;
			?>
		</div>
	</div>
</div>
