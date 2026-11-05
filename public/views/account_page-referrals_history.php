<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<?php if ((!empty($data['items']) && is_array($data['items'])) || !empty($data['filtered'])): ?>
	<div>
    <div class="af-profile-box-wrapper">
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <div class="af-account-referrals-filter">
					<?php echo esc_af_content($data['filter']);?>
    			</div>
                </div>
            </div>
        </div>
    </div>
		<?php if (!empty($data['items']) && is_array($data['items'])): ?>
    <table class="af-account-table">
			  <thead>
				<tr>
					<th><?php esc_html_e("Campaign", 'openaffiliates');?></th>
					<th><?php esc_html_e("Amount", 'openaffiliates');?></th>
					<th><?php esc_html_e("From", 'openaffiliates');?></th>
					<th><?php esc_html_e("Description", 'openaffiliates');?></th>
					<th><?php esc_html_e("Date", 'openaffiliates');?></th>
					<th><?php esc_html_e('Payment', 'openaffiliates');?></th>
					<th><?php esc_html_e("Status", 'openaffiliates');?></th>
				</tr>
			  </thead>
			  <tbody class="af-alternate">
			<?php foreach ($data['items'] as $array) : ?>
				<tr>
					<td><?php
						if ($array['campaign']) {
							echo esc_af_content($array['campaign']);
						} else {
							echo esc_html('-');
						}
					?></td>
					<td><strong><?php echo af_format_price_and_currency(afCurrency($array['currency']), $array['amount']);?></strong></td>
					<td><?php echo (empty($array['source'])) ? '' : af_service_type_code_to_title($array['source']);?></td>
					<td><?php echo esc_af_content($array['description']);?></td>
					<td><?php echo af_convert_date_to_us_format($array['date']);?></td>
					<td><?php
						switch ($array['payment']){
							case 0:
								echo '<div class="af-status af-status-processing">'.esc_html__('Unpaid', 'openaffiliates').'</div>';
								break;
							case 1:
								echo '<div class="af-status af-status-inactive">'.esc_html__('Pending', 'openaffiliates').'</div>';
								break;
							case 2:
								echo '<div class="af-status af-status-active">'.esc_html__('Paid', 'openaffiliates').'</div>';
								break;
						}
					?></td>
					<td class="af-special-label"><?php
						if ($array['status']==0){
							echo '<div class="af-status af-status-failed">'.esc_html__('Rejected', 'openaffiliates').'</div>';
						} else if ($array['status']==1){
							echo '<div class="af-status af-status-inactive">'.esc_html__('Pending', 'openaffiliates').'</div>';
						} else if ($array['status']==2){
							echo '<div class="af-status af-status-active">'.esc_html__('Approved', 'openaffiliates').'</div>';
						}
					?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php else: ?>
			 <div class="af-account-detault-message">
						<div><?php esc_html_e('No Referrals found for your selection.', 'openaffiliates');?></div>
				</div>
<?php endif;?>
	</div>
    <?php else: ?>
    	   <div class="af-account-detault-message">
              <div><?php esc_html_e('Here you will see all your Rewards and Commission that will be received based on your activity. Start your Affiliate campaing to earn commission.', 'openaffiliates');?></div>
          </div>
<?php endif;?>

<?php if (!empty($data['pagination'])):?>
	<?php echo esc_af_content($data['pagination']);?>
<?php endif;?>
</div>
