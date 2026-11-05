<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Unpaid Referrals', 'openaffiliates');?></div>

	<div class="af-payments-stats">
		<div class="row">
			<div class="col-xs-3">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-visits-af"></i>
					<div class="stats">
						<h4><?php echo esc_html($data['stats']['affiliates']);?></h4>
						<?php esc_html_e('Total Affiliates', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-3">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-rank-af"></i>
					<div class="stats">
						<h4><?php echo esc_html($data['stats']['referrals']);?></h4>
						<?php esc_html_e('Total Referrals', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-3">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-payments-unpaid-af"></i>
					<div class="stats">
						<h4><?php echo af_format_price_and_currency($data['stats']['currency'], round($data['stats']['unpaid_payments_value'], 2));?></h4>
						<?php esc_html_e('Total Unpaid Referrals', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-3">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-payments-paided-af"></i>
					<div class="stats">
						<h4><?php echo af_format_price_and_currency($data['stats']['currency'], round($data['stats']['paid_payments_value'], 2));?></h4>
						<?php esc_html_e('Total Paid Referrals', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-4">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-paid-referrals-af"></i>
					<div class="stats">
						<h4><?php echo esc_af_content($data['stats']['paid_referrals_count']);?></h4>
						<?php esc_html_e('Total number of Paid Referrals', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-4">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-referrals-af"></i>
					<div class="stats">
						<h4><?php echo esc_af_content($data['stats']['unpaid_referrals_count']);?></h4>
						<?php esc_html_e('Total number of Unpaid Referrals', 'openaffiliates');?>
					</div>
				</div>
			</div>

			<div class="col-xs-4">
				<div class="af-dashboard-top-box">
					<i class="fa-af fa-dashboard-payments-paid-af"></i>
					<div class="stats">
						<h4><?php echo esc_af_content($data['stats']['payments']);?></h4>
						<?php esc_html_e('Total number of Transactions', 'openaffiliates');?>
					</div>
				</div>
			</div>

	  </div>
	</div>

	<?php if (!empty($data['listing_items'])) : ?>
	<form method="post" id="form_payments">
					<table class="wp-list-table widefat fixed tags af-admin-tables">
						<thead>
							<tr>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Paid Referrals', 'openaffiliates');?></th>
								<th><?php esc_html_e('Unpaid Referrals', 'openaffiliates');?></th>
								<th><?php esc_html_e('Paid Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Unpaid Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('All Transactions', 'openaffiliates');?></th>
							</tr>
						</thead>
						<tbody class="ui-sortable af-alternate">
							<?php foreach ($data['listing_items'] as $id => $array): ?>
							<tr>
								<td>
									<div class="af-list-affiliates-name-label"><?php
										$uid = $af_db->get_uid_by_affiliate_id($id);
										echo esc_af_content($this->print_flag_for_affiliate($uid) . $array['username']);
									?></div>
									<?php
										if (!empty($data['payments_settings']) && !empty($data['payments_settings'][$id])):
											echo esc_html(" - ");
											$inside_array = $data['payments_settings'][$id];
											switch ($inside_array['type']):
												case 'paypal':
													$payment_class = ($inside_array['is_active']) ? 'af-payment-type-active-paypal' : '';
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">PayPal</span>
													<?php
													break;
												case 'bt':
													$payment_class = ($inside_array['is_active']) ? 'af-payment-type-active-bt' : '';
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('Direct Deposit', 'openaffiliates');?></span>
													<?php
													break;
												case 'stripe':
													$payment_class = '';
													if ($inside_array['is_active'] && !empty($inside_array['settings']) && !empty($inside_array['settings']['af_affiliate_stripe_name'])
														&& !empty($inside_array['settings']['af_affiliate_stripe_card_number']) && !empty($inside_array['settings']['af_affiliate_stripe_expiration_month'])
														&& !empty($inside_array['settings']['af_affiliate_stripe_expiration_year']) ) //&& !empty($inside_array['settings']['af_affiliate_stripe_cvc'])
													{
														$payment_class = 'af-payment-type-active-stripe';
													}
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>">Stripe</span>
													<?php
													break;
											endswitch;
										else :
											?>
											<?php
										endif;
									?>
								</td>
								<td><?php
									echo esc_html($array['count_paid']);
									if ($array['count_paid']){
										?>
										<div><a href="<?php echo esc_url($data['paid_referrals'] . '&affiliate=' . $id);?>"><?php esc_html_e('View', 'openaffiliates');?></a></div>
										<?php
									}
								?></td>
								<td><?php
									echo esc_af_content('<strong class="af-special-color">'.$array['count_unpaid'].'</strong>');
									if (!empty($array['count_unpaid'])):
										?>
										<div><a href="<?php echo esc_url($data['unpaid_link'] . '&affiliate=' . $id);?>"><?php esc_html_e('View', 'openaffiliates');?></a></div>
										<?php
									endif;
								?></td>

								<td><?php echo af_format_price_and_currency($array['paid_currency'], round($array['total_paid'], 2));?></td>

								<td><?php
									echo esc_af_content('<strong class="af-special-color">' . af_format_price_and_currency($array['unpaid_currency'], round($array['total_unpaid'], 2) ) . '</strong>');
									if (!empty($array['total_unpaid']) && (float)$array['total_unpaid'] > 0 ){
										?>
										<div><a href="<?php echo esc_url($data['pay_link'] . '&affiliate=' . $id);?>"><?php esc_html_e('Pay All', 'openaffiliates');?></a></div>
										<?php
									}
								?></td>
								<td><?php
									if ($array['has_transactions']){
										?>
											<div class="referral-status-verified"><a href="<?php echo esc_url($data['paid_link'] . '&affiliate=' . $id);?>"><?php esc_html_e('View', 'openaffiliates');?></a></div>
										<?php
									}
								?></td>
							</tr>

							<?php endforeach;?>
						</tbody>

						<tfoot>
							<tr>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Paid Referrals', 'openaffiliates');?></th>
								<th><?php esc_html_e('Unpaid Referrals', 'openaffiliates');?></th>
								<th><?php esc_html_e('Paid Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Unpaid Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('All Transactions', 'openaffiliates');?></th>
							</tr>
						</tfoot>
					</table>
	</form>
	<?php endif;?>
	<?php if (!empty($data['pagination'])) : ?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
