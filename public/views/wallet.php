<div class="af-account-wallet-tab">
<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php
	$stats = 0;
	if(isset($data['stats']['wallet'])){
		$stats = $data['stats']['wallet'];
	}
?>



<div class="af-row">

	<div class="afcol-md-2 af-account-wallet-tab1">
		<div class="af-account-no-box af-account-box-lightgray">
			<div class="af-account-no-box-inside">
				<div class="af-count"> <?php echo af_format_price_and_currency($data['currency'], round($stats, 2) ); ?> </div>
				<div class="af-detail"><?php echo esc_html__('Available Wallet Credit', 'openaffiliates'); ?></div>
			</div>
		</div>
	</div>

	<div class="afcol-md-2 af-account-wallet-tab2">
		<div class="af-account-no-box af-account-box-red">
			<div class="af-account-no-box-inside">
				<div class="af-count"> <?php echo af_format_price_and_currency($data['currency'], round($data['stats']['unpaid_payments_value'], 2));?> </div>
				<div class="af-detail"><?php echo esc_html__('Available Deposit based on your Earnings', 'openaffiliates'); ?></div>
                <div class="af-subnote"><?php echo esc_html__('what can be converted in Credits into your Wallet', 'openaffiliates'); ?></div>
			</div>
		</div>
	</div>

</div>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>
<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php echo esc_html__('Wallet Credit', 'openaffiliates'); ?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                   <div class="af-account-detault-message">
                      <div><?php esc_html_e('You can deposit your unpaid referrals in your wallet. You can select a service and an amount to deposit, then you will receive a coupon for that service for that amount, which you can use to purchase items etc', 'openaffiliates');?></div>
                  </div>
          		</div>
             </div>
        </div>
     </div>
<?php if ($data['stats']['unpaid_payments_value'] && $data['stats']['unpaid_payments_value']>=$settings['af_wallet_minimum_amount']):?>
<div class="af-profile-box-wrapper">
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                   <div class="af-account-detault-message">
                     <a href="<?php echo esc_url($data['add_new']);?>" class="af-addd-to-wallet"><?php esc_html_e('Add New Credit', 'openaffiliates');?></a>
                  </div>
          		</div>
             </div>
        </div>
     </div>

<?php endif;?>

<?php if ($data['items']):?>
	<table class="af-account-table">
		<thead>
			<tr>
				<th><?php esc_html_e('Coupon Code', 'openaffiliates');?></th>
				<th><?php esc_html_e('Service', 'openaffiliates');?></th>
				<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</thead>
	<?php foreach ($data['items'] as $k=>$v):?>
		<tr>
			<td><strong><?php echo esc_af_content($v['code']);?></strong></td>
			<td><?php echo af_service_type_code_to_title($v['type']);?></td>
			<td><?php echo af_format_price_and_currency($data['currency'], $v['amount']);?></td>
			<td><span onClick="afRemoveWalletItem('<?php echo esc_attr($v['type']);?>', '<?php echo esc_attr($v['code']);?>');" class="af-pointer"><?php esc_html_e('Remove', 'openaffiliates');?></span></td>
		</tr>
	<?php endforeach;?>
	</table>
    <?php else: ?>
     <div class="af-profile-box-wrapper">
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                   <div class="af-account-detault-message">
                      <div><?php esc_html_e('Once you will convert your first Earnings into your Wallet you will find listed here all your credits.', 'openaffiliates');?></div>
                  </div>
          		</div>
             </div>
        </div>
     </div>
<?php endif;?>
</div>
</div>
