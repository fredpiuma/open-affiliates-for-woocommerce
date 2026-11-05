<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Paid Referrals', 'openaffiliates');?></div>

		<?php if (!empty($data['subtitle'])):?>
			<h4><?php echo esc_af_content($data['subtitle']);?></h4>
		<?php endif;?>

	<?php if (!empty($data['listing_items'])) : ?>

		<?php
			if (!empty($data['filter'])):
				echo esc_af_content('<div class="af-special-box">'.$data['filter'].'</div>');
			endif;
		?>

		<table class="wp-list-table widefat fixed tags af-admin-tables">
			<thead>
				<tr>
					<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
					<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
					<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
					<th><?php esc_html_e('Paid', 'openaffiliates');?></th>
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
					<td><?php echo esc_html($array['reference']);?></td>
					<td><?php echo af_format_price_and_currency($array['currency'], $array['amount']);?></td>
					<td><?php echo af_convert_date_to_us_format($array['date']);?></td>
					<td><?php
						switch ($array['payment']){
							case 0:
								_e('Unpaid', 'openaffiliates');
								break;
							case 1:
								_e('Pending', 'openaffiliates');
								break;
							case 2:
								_e('Complete', 'openaffiliates');
								break;
						}
					?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
					<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
					<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
					<th><?php esc_html_e('Paid', 'openaffiliates');?></th>
				</tr>
			</tfoot>
		</table>

	<?php else: ?>
		<!-- developer -->
		<table class="wp-list-table widefat fixed tags af-admin-tables">
			<thead>
				<tr>
					<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
					<th><?php esc_html_e('Reference', 'openaffiliates');?></th>
					<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					<th><?php esc_html_e('Created Time', 'openaffiliates');?></th>
					<th><?php esc_html_e('Paid', 'openaffiliates');?></th>
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
					<th><?php esc_html_e('Paid', 'openaffiliates');?></th>
				</tr>
			</tfoot>
		</table>
		<!-- end dev -->
	<?php endif;?>

	<?php if (!empty($data['payments_settings']['type'])):?>
		<h3><?php esc_html_e('Payment Details', 'openaffiliates')?></h3>
		<?php if (!empty($data['payment_details_on_transaction'])):?>
			<?php if (!empty($data['payment_details_on_transaction']['payment_type'])):?>
				<div>
					<label><?php esc_html_e('Payment Type', 'openaffiliates');?>: </label><?php echo esc_html($data['payment_details_on_transaction']['payment_type']);?>
					<?php unset($data['payment_details_on_transaction']['payment_type']);?>
				</div>
			<?php endif;?>

			<?php if (!empty($data['payment_details_on_transaction']['errors'])):?>
				<div>
					<label><?php esc_html_e( 'Errors:', 'openaffiliates' );?> </label> <?php echo esc_html($data['payment_details_on_transaction']['errors']);?>
					<?php unset($data['payment_details_on_transaction']['errors']);?>
				</div>
			<?php endif;?>

			<?php foreach ($data['payment_details_on_transaction'] as $temp_array):?>
				<div>
					<label><?php echo esc_html($temp_array['label']);?>: </label> <?php echo esc_html($temp_array['value']);?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		<?php endif;?>

	<?php if (!empty($data['pagination'])) : ?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
