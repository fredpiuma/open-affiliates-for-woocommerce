<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Manage Transactions', 'openaffiliates');?></div>

		<?php if (!empty($data['subtitle'])):?>
			<h4><?php echo esc_af_content($data['subtitle']);?></h4>
		<?php endif;?>
	<div class="af-special-box af-transactions-export-box" >
		<div class="af-general-date-filter-wrap">
			<h3 class="af-transactions-export-title"><?php esc_html_e('Export Pending Transactions', 'openaffiliates');?></h3>
			<p><?php esc_html_e('Generate a CSV file to export pending transactions for manual Payout processing', 'openaffiliates');?></p>
			<div class="af-transactions-filter-box">
			<!--label class="af-label">Start:</label-->
			<input type="text" value="" class="af-general-date-filter" placeholder="<?php esc_html_e('From - mm/dd/yyyy', 'openaffiliates');?>" id="csv_min_date" />
			<!--label class="af-label">Until:</label-->-
			<input type="text" value="" class="af-general-date-filter" placeholder="<?php esc_html_e('To - mm/dd/yyyy', 'openaffiliates');?>" id="csv_max_date" />
			</div>
			<div class="af-transactions-filter-box">
				<label><?php esc_html_e('Payment System', 'openaffiliates');?></label>
				<select id="csv_payment_type">
					<option value=""><?php esc_html_e('All', 'openaffiliates');?></option>
					<option value="bank_transfer"><?php esc_html_e('Direct Deposit', 'openaffiliates');?></option>
					<option value="paypal"><?php esc_html_e('Paypal', 'openaffiliates');?></option>
					<option value="stripe_v3"><?php esc_html_e('Stripe', 'openaffiliates');?></option>
				</select>
			</div>
			<div class="af-transactions-filter-box">
				<label class="af_label_shiwtch af-switch-button-margin">
					<input type="checkbox" class="af-switch" onclick="afCheckAndH(this, '#csv_switch_status');" checked />
					<div class="switch af-display-inline"></div>
				</label>
				<label><?php esc_html_e("Change the transaction status to Complete ", 'openaffiliates');?></label>
				<input type="hidden" id="csv_switch_status" value="1" />
			</div>
			<div class="af-transactions-filter-box">
				<div class="af-special-button af-transactions-export-bt" onclick="afGeneratePaymentsCsv();"><i class="fa-af fa-export-csv"></i>Export CSV</div>
			</div>
			<div class="af-clear"></div>
			<div class="af-hidden-download-link af-display-none"><a href="" target="_blank"><?php esc_html_e("Click on this if download doesn't start automatically in 20 seconds!", 'openaffiliates');?></a></div>
		</div>
	</div>

	<?php if ( !empty( $data['error_users'] ) || !empty( $data['error_details_for_users'] ) ):?>

		<div class="af-wrapp-the-errors">
			<?php if ( !empty( $data['error_users'] ) ):?>
					<?php foreach ($data['error_users'] as $user ):?>
						<div><?php echo esc_html__('The Payment cannot be proceed for affiliate ', 'openaffiliates') . $user . esc_html__(' because of the payment settings.', 'openaffiliates');?></div>
					<?php endforeach;?>
			<?php endif;?>
			<?php if ( !empty( $data['error_details_for_users'] ) ):?>
					<?php foreach ($data['error_details_for_users'] as $details ):?>
						<div><?php echo esc_html__('The Payment cannot be proceed for affiliate ', 'openaffiliates') . $details['username'] . '. ' . $details['error_message'];?></div>
					<?php endforeach;?>
			<?php endif;?>
		</div>

	<?php endif;?>

	<?php if ( isset( $data['general_error_for_payment'] ) && $data['general_error_for_payment'] !== '' ):?>
			<div class="af-wrapp-the-errors"><?php echo $data['general_error_for_payment'];?></div>
	<?php endif;?>

	<?php if (!empty($data['listing_items'])) : ?>
	<div class="af-special-box">
	<?php echo esc_af_content($data['filter']);?>
	</div>

	<div class="af-transactions-check-payment">
		<button class="button button-primary button-large af-js-location-reload" data-url="<?php echo esc_url($data['update_payments']);?>" ><?php esc_html_e("Check Payments Status", 'openaffiliates');?></button>
	</div>




	<form  method="post" id="form_payments">

			<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

					<table class="wp-list-table widefat fixed tags af-admin-tables">
						<thead>
							<tr>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
								<th><?php esc_html_e('Created Date', 'openaffiliates');?></th>
								<th><?php esc_html_e('Updated Date', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Service Status', 'openaffiliates');?></th>
								<th><?php esc_html_e('Status', 'openaffiliates');?></th>
								<th class="af-transactions-actions-col"><?php esc_html_e('Action', 'openaffiliates');?></th>
							</tr>
						</thead>

						<tbody class="ui-sortable af-alternate">
							<?php foreach ($data['listing_items'] as $key => $array): ?>
							<tr>
								<td><div class="af-list-affiliates-name-label"><?php
									if (empty($u_ids[$array['affiliate_id']])){
										$u_ids[$array['affiliate_id']] = $af_db->get_uid_by_affiliate_id($array['affiliate_id']);
									}
									echo esc_af_content($this->print_flag_for_affiliate($u_ids[$array['affiliate_id']]) . $array['username']);
								?></div></td>
								<td><strong><?php echo af_format_price_and_currency($array['currency'], $array['amount']);?></strong></td>
								<td><span class="af-admin-aff-payment-type af-payment-type-active-<?php echo esc_attr($array['payment_type']);?>"><?php echo esc_html($array['payment_type']);?></span></td>
								<td><?php echo af_convert_date_to_us_format($array['create_date']);?></td>
								<td><?php echo af_convert_date_to_us_format($array['update_date']);?></td>
								<td><?php if ($array['payment_special_status']) {
									echo esc_html($array['payment_special_status']);
								} else {
									echo esc_html('-');
								}?></td>
								<td><?php
									switch ($array['status']){
										case 0:
											?>
												<div><strong><?php esc_html_e('Failed', 'openaffiliates');?></strong></div>
											<?php
											break;
										case 1:
											?>
												<div><strong><?php esc_html_e('Pending', 'openaffiliates');?></strong>
													<?php if ($array['payment_type']=='paypal'):?>
															<div class="af-transactions-warning"><?php esc_html_e("Press the 'Check Payments Status' button to get the lattest status of transaction.", 'openaffiliates');?></div>
													<?php endif;?>
												</div>
											<?php
											break;
										case 2:
											?>
												<div><strong><?php esc_html_e('Complete', 'openaffiliates');?></strong></div>
											<?php
											break;
									}
								?></td>
								<td>
									<div class="referral-status-verified"><a  href="<?php echo esc_url($data['view_transaction_url'] . '&id=' . $array['id']);?>"><?php esc_html_e('View Details', 'openaffiliates');?></a></div>
									<div>

									<?php
										if ($array['status']==2){
											?>
											<span class="refferal-chang-status af-js-transactions-change-status"
												data-id="<?php echo esc_attr($array['id']);?>"
												data-status="1"><?php esc_html_e('Mark as Pending', 'openaffiliates');?></span>
											<span>|</span>
											<?php
										} else if ($array['status']==1){
											?>
											<span class="refferal-chang-status af-js-transactions-change-status"
												data-id="<?php echo esc_attr($array['id']);?>"
												data-status="2"
											 	><?php esc_html_e('Mark as Complete', 'openaffiliates');?></span><span>|</span> <?php
										}
									?>
									<span class="refferal-chang-status af-js-transactions-delete-transaction"
											data-id="<?php echo esc_attr($array['id']);?>"><?php esc_html_e('Delete', 'openaffiliates');?></span>
									</div>
								</td>
							</tr>

							<?php endforeach;?>
						</tbody>
						<tfoot>
							<tr>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
								<th><?php esc_html_e('Created Date', 'openaffiliates');?></th>
								<th><?php esc_html_e('Updated Date', 'openaffiliates');?></th>
								<th><?php esc_html_e('Payment Service Status', 'openaffiliates');?></th>
								<th><?php esc_html_e('Status', 'openaffiliates');?></th>
								<th><?php esc_html_e('Action', 'openaffiliates');?></th>
							</tr>
						</tfoot>
					</table>
			<input type="hidden" name="transaction_id" id="transaction_id" value="" />
			<input type="hidden" name="new_status" id="new_status" value="" />
			<input type="hidden" name="delete_transaction" id="delete_transaction" value="" />
	</form>
<?php else : ?>
	<!-- developer -->
	<table class="wp-list-table widefat fixed tags af-admin-tables">
		<thead>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
				<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
				<th><?php esc_html_e('Created Date', 'openaffiliates');?></th>
				<th><?php esc_html_e('Updated Date', 'openaffiliates');?></th>
				<th><?php esc_html_e('Payment Service Status', 'openaffiliates');?></th>
				<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				<th class="af-transactions-actions-col"><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</thead>

		<tbody class="ui-sortable af-alternate">
			<tr>
				<td><?php esc_html_e('No items found.', 'openaffiliates');?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
				<th><?php esc_html_e('Payment Type', 'openaffiliates');?></th>
				<th><?php esc_html_e('Created Date', 'openaffiliates');?></th>
				<th><?php esc_html_e('Updated Date', 'openaffiliates');?></th>
				<th><?php esc_html_e('Payment Service Status', 'openaffiliates');?></th>
				<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</tfoot>
	</table>
	<!-- end dev -->
	<?php endif;?>
	<?php if (!empty($data['pagination'])) : ?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
