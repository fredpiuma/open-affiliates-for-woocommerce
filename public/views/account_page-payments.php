<div class="af-account-payments-tab">
<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<div class="af-row">
		<div class="afcol-md-2 af-account-payments-tab1">
			<div class="af-account-no-box af-account-box-lightgray"><div class="af-account-no-box-inside"><div class="af-count"><?php echo af_format_price_and_currency(afCurrency($data['currency']), $data['stats']['paid_payments_value']);?></div><div class="af-detail"><?php esc_html_e('Total Payments Amount', 'openaffiliates');?></div></div></div>
		</div>
		<div class="afcol-md-2 af-account-payments-tab2">
			<div class="af-account-no-box af-account-box-lightblue"><div class="af-account-no-box-inside"><div class="af-count"><?php echo esc_af_content($data['stats']['payments']);?></div><div class="af-detail"><?php esc_html_e('Total number of Payments', 'openaffiliates');?></div></div></div>
		</div>
	</div>
    <div class="af-profile-box-wrapper">
        <div class="af-profile-box-content af-no-padding">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
   						 <div class="af-account-payment-method-link">
			  				<?php esc_html_e('You can setup or change your ', 'openaffiliates')?> <strong><?php esc_html_e(' Payout details ', 'openaffiliates');?></strong> <?php esc_html_e(' form', 'openaffiliates');?>
              					<a href="<?php echo esc_url($data['payment_settings_url']);?>">
			  						<?php esc_html_e('here', 'openaffiliates');?>
              					</a>
                    		</div>
        		</div>
        	</div>
        </div>
     </div>
    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Withdrawn History", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">

	<?php if (!empty($data['listing_items'])) : ?>
                <div class="af-account-referrals-filter">
					<?php echo esc_af_content($data['filter']);?>
    			</div>
<div class="af-wrapper">
		<table class="af-account-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					<th><?php esc_html_e('Payment Method', 'openaffiliates');?></th>
					<th><?php esc_html_e('Created Date', 'openaffiliates');?></th>
					<th><?php esc_html_e('Updated Date', 'openaffiliates');?></th>
					<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				</tr>
			</thead>
			<tbody class="af-alternate">
				<?php foreach ($data['listing_items'] as $key => $array): ?>
				<tr>
					<td><strong><?php echo af_format_price_and_currency(afCurrency($array['currency']), $array['amount']);?></strong></td>
					<td><?php echo esc_html__($array['payment_type'], 'openaffiliates');?></td>
					<td><?php echo af_convert_date_to_us_format($array['create_date']);?></td>
					<td><?php echo af_convert_date_to_us_format($array['update_date']);?></td>
					<td class="af-special-label"><?php
						switch ($array['status']){
							case 0:
								?>
									<div class="af-status af-status-failed"><?php esc_html_e('Failed', 'openaffiliates');?></div>
								<?php
								break;
							case 1:
								?>
									<div class="af-status af-status-inactive"><?php esc_html_e('Pending', 'openaffiliates');?></div>
								<?php
								break;
							case 2:
								?>
									<div class="af-status af-status-active"><?php esc_html_e('Completed', 'openaffiliates');?></div>
								<?php
								break;
						}
					?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
         </div>
    <?php else: ?>
    	   <div class="af-account-detault-message">
              <div><?php esc_html_e('Here you will see all your proceeded Withdrawn once your earnings will be paid to your payment account.', 'openaffiliates');?></div>
          </div>
<?php endif;?>

	<?php if (!empty($data['pagination'])):?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>

        </div>
        </div>
        </div>
</div>
</div>
</div>
