<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

	<?php if ($data['services']): ?>
	<form action="<?php echo esc_url($data['form_action']);?>" method="post" class="af-js-public-add-to-wallet-form" >
		<input type="hidden" name="afcheck" value="<?php echo esc_attr($data['hash']);?>" />
		<div class="af-ap-field">
			<label class="af-ap-label af-special-label"><?php esc_html_e('Destination Service', 'openaffiliates');?></label>
			<select name="service_type" class="af-public-form-control"><?php
					foreach ($data['services'] as $k=>$v):
						?>
						<option value="<?php echo esc_attr($k);?>"><?php echo esc_html($v);?></option>
						<?php
					endforeach;
			?></select>
		</div>
			<label class="af-ap-label af-special-label"><?php esc_html_e('Referrals', 'openaffiliates');?></label>
			<?php if ($data['referrals']):?>
				<div class="af-wallet-table-wrapp">
					<table class="af-account-table">
						<thead>
							<tr>
								<th><?php esc_html_e('Select', 'openaffiliates');?></th>
								<th><?php esc_html_e("Amount", 'openaffiliates');?></th>
								<th><?php esc_html_e("Source", 'openaffiliates');?></th>
								<th><?php esc_html_e("Description", 'openaffiliates');?></th>
							</tr>
						</thead>
						<tbody class="af-alternate">
						<?php foreach ($data['referrals'] as $array) : ?>
							<tr>
								<td><input type="checkbox" onClick="afAddToWallet(this, <?php echo esc_attr($array['id']);?>, '#the_referrals_list');"/></td>
								<td><strong><?php echo af_format_price_and_currency($array['currency'], $array['amount']);?></strong></td>
								<td><?php echo (empty($array['source'])) ? '' : af_service_type_code_to_title($array['source']);?></td>
								<td><?php echo esc_af_content($array['description']);?></td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				</div>

			<?php endif;?>

		<input type="hidden" value="" id="the_referrals_list" name="referrals" />
		<div>
			<div class="af-aling-float-left">
				<input type="submit" value="<?php esc_html_e('Add On Wallet', 'openaffiliates');?>" name="save" class="button button-primary button-large af-js-add-to-wallet-submit-bttn" />
			</div>
			<div class="af-aling-float-right">
				<div class="af-wallet-total"><?php esc_html_e('Total Credit: ', 'openaffiliates');?> <span id="af_total_amount"><?php echo af_format_price_and_currency($data['currency'], '0');?></span></div>
			</div>
			<div class="af-clear"></div>
	   </div>
	</form>

	<?php else : ?>
		<?php esc_html_e('No service available!', 'openaffiliates');?>
	<?php endif;?>

</div>
