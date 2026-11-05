<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Unpaid Referrals', 'openaffiliates');?></div>

		<?php if (!empty($data['subtitle'])):?>
			<h4><?php echo esc_af_content($data['subtitle']);?></h4>
		<?php endif;?>

	<?php if (!empty($data['listing_items'])) : ?>
	<div class="af-special-box">
	<?php echo esc_af_content($data['filter']);?>
	</div>

	<form action="<?php echo esc_url($data['pay_link']);?>" method="post" id="form_payments">

				<?php if ( !empty( $_POST['udf'] ) ):?>
						<input type="hidden" name="start_date" value="<?php echo esc_attr( sanitize_text_field( $_POST['udf'] ) );?>" />
				<?php elseif ( !empty( $_GET['udf'] ) ):?>
						<input type="hidden" name="start_date" value="<?php echo esc_attr( sanitize_text_field( $_GET['udf'] ) );?>" />
				<?php endif;?>
				<?php if ( !empty( $_POST['udu'] ) ):?>
						<input type="hidden" name="end_date" value="<?php echo esc_attr( sanitize_text_field( $_POST['udu'] ) );?>" />
				<?php elseif ( !empty( $_GET['udu'] ) ):?>
						<input type="hidden" name="end_date" value="<?php echo esc_attr( sanitize_text_field( $_GET['udu'] ) );?>" />
				<?php endif;?>

				<div class="af-delete-wrapp">
					<input type="submit" value="<?php esc_html_e('Payout All/Selected Referrals', 'openaffiliates');?>" name="submit_select_pay" class="button button-primary button-large do-the-payment">
				</div>
					<table class="wp-list-table widefat fixed tags af-admin-tables">
						<thead>
							<tr>
								<th class="af-table-check-col"><input type="checkbox" onClick="afSelectAllCheckboxes( this, '.af-referral' );" /></th>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
							</tr>
						</thead>

						<tbody class="ui-sortable af-alternate">
							<?php foreach ($data['listing_items'] as $key => $array): ?>
							<tr>
								<?php $checked = ( !empty( $data['selected_referrences'] ) && in_array( $array['id'], $data['selected_referrences'] ) ) ? 'checked' : '';?>
								<th><input type="checkbox" value="<?php echo esc_attr($array['id']);?>" name="referrals[]" class="af-referral" <?php echo esc_attr($checked);?> /></th>
								<td>
									<div class="af-list-affiliates-name-label"><?php
										if (empty($u_ids[$array['affiliate_id']])){
											$u_ids[$array['affiliate_id']] = $af_db->get_uid_by_affiliate_id($array['affiliate_id']);
										}
										echo esc_af_content($this->print_flag_for_affiliate($u_ids[$array['affiliate_id']]) . $array['username']);
									?></div>
									<?php
										if (!empty($data['payments_settings']) && !empty($data['payments_settings'][$array['affiliate_id']])):
											echo esc_af_content(" - ");
											$inside_array = $data['payments_settings'][$array['affiliate_id']];
											switch ($inside_array['type']):
												case 'paypal':
													$payment_class = ($inside_array['is_active']) ? 'af-payment-type-active-paypal' : '';
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('PayPal', 'openaffiliates');?></span>
													<?php
													break;
												case 'bt':
													$payment_class = ($inside_array['is_active']) ? 'af-payment-type-active-bt' : '';
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('Direct Deposit', 'openaffiliates');?></span>
													<?php
													break;
												case 'stripe':
													$payment_class = ($inside_array['is_active']) ? 'af-payment-type-active-stripe' : '';
													?>
													<span class="af-admin-aff-payment-type <?php echo esc_attr($payment_class);?>"><?php esc_html_e('Stripe', 'openaffiliates');?></span>
													<?php
													break;
											endswitch;
										else :
											?>
											<?php
										endif;
									?>
								</td>
								<td><?php echo esc_af_content($array['reference']);?></td>
								<td><?php echo af_format_price_and_currency($array['currency'], $array['amount']);?></td>
								<td><?php echo af_convert_date_to_us_format($array['date']);?></td>
							</tr>

							<?php endforeach;?>
						</tbody>
						<tfoot>
							<tr>
								<th><input type="checkbox" onClick="afSelectAllCheckboxes( this, '.af-referral' );" /></th>
								<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
								<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
								<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
								<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
							</tr>
						</tfoot>
					</table>
				<div class="af-delete-wrapp">
					<input type="submit" value="<?php esc_html_e('Payout All/Selected Referrals', 'openaffiliates');?>" name="submit_select_pay" class="button button-primary button-large do-the-payment">
				</div>
	</form>
<?php else: ?>
	<!-- developer -->
	<table class="wp-list-table widefat fixed tags af-admin-tables">
		<thead>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
				<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
				<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
			</tr>
		</thead>

		<tbody class="ui-sortable af-alternate">
			<tr>
				<td><?php esc_html_e('No items found.', 'openaffiliates');?> </td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
				<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
				<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
			</tr>
		</tfoot>
	</table>
	<!-- end dev -->
	<?php endif;?>
	<?php if (!empty($data['pagination'])) : ?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
