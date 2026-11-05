<div class="af-account-referrals-tab">
<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<?php if ((!empty($data['items']) && is_array($data['items'])) || !empty($data['filtered'])): ?>
	<div>
	<?php if (!empty($data['items']) && is_array($data['items'])): ?>
	<div class="af-row">
		<div class="afcol-md-3 af-account-referrals-tab1">
			<div class="af-account-no-box af-account-box-lightgray"><div class="af-account-no-box-inside"><div class="af-count"><?php echo af_format_price_and_currency(afCurrency($data['currency']), $data['stats']['verified_referrals_amount']);?></div><div class="af-detail"><?php esc_html_e("Approved Referrals Amount", 'openaffiliates');?></div></div></div>
		</div>
		<div class="afcol-md-3 af-account-referrals-tab2">
			<div class="af-account-no-box af-account-box-lightyellow"><div class="af-account-no-box-inside"><div class="af-count"><?php echo af_format_price_and_currency(afCurrency($data['currency']), $data['stats']['unverified_referrals_amount']);?></div><div class="af-detail"><?php esc_html_e("Pending Referrals Amount", 'openaffiliates');?></div></div></div>
		</div>
		<div class="afcol-md-3 af-account-referrals-tab3">
			<div class="af-account-no-box af-account-box-lightblue"><div class="af-account-no-box-inside"><div class="af-count"><?php echo esc_af_content($data['stats']['referrals']);?></div><div class="af-detail"><?php esc_html_e('Total Number of Referrals', 'openaffiliates');?></div></div></div>
		</div>
	</div>
	<?php endif; ?>
    <div class="af-profile-box-wrapper">
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                   <div class="af-account-detault-message">
                   		<?php esc_html_e('Here are listed only Unpaid Referrals that have not been withdrawn yet. For a complete list of referrals check ', 'openaffiliates');?>
              					<a href="<?php echo esc_url($data['full_referrals_url']);?>">
			  						<?php esc_html_e('this section', 'openaffiliates');?>
              					</a>
                  </div>
          		</div>
             </div>
        </div>
    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Rewards and Commissions", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <div class="af-account-referrals-filter">
					<?php echo esc_af_content($data['filter']);?>
    			</div>
		<?php if (!empty($data['items']) && is_array($data['items'])): ?>
		<table class="af-account-table">
			  <thead>
				<tr>
					<th class="af-account-referrals-table-col1"><?php esc_html_e("ID", 'openaffiliates');?></th>
					<th class="af-account-referrals-table-col2"><?php esc_html_e("Campaign", 'openaffiliates');?></th>
					<th class="af-account-referrals-table-col3"><?php esc_html_e("Amount", 'openaffiliates');?></th>
					<th class="af-account-referrals-table-col4"><?php esc_html_e("From", 'openaffiliates');?></th>
					<?php if (!empty($data['print_source_details'])):?>
						<th class="af-account-referrals-table-col5"><?php esc_html_e('Source Details', 'openaffiliates');?></th>
					<?php endif;?>
					<th class="af-account-referrals-table-col6"><?php esc_html_e("Description", 'openaffiliates');?></th>
					<th class="af-account-referrals-table-col7"><?php esc_html_e("Received on", 'openaffiliates');?></th>
					<th class="af-account-referrals-table-col8"><?php esc_html_e("Status", 'openaffiliates');?></th>
				</tr>
			  </thead>
			  <tbody class="af-alternate">
			<?php foreach ($data['items'] as $array) : ?>
				<tr>
					<td class="af-account-referrals-table-col1"><?php echo esc_af_content($array['id']);?></td>
					<td class="af-account-referrals-table-col2"><?php
						if ($array['campaign']) {
							echo esc_af_content($array['campaign']);
						} else {
							echo esc_af_content('-');
						}
					?></td>
					<td  class="af-account-referrals-table-col3"><strong><?php echo af_format_price_and_currency(afCurrency($array['currency']), $array['amount']);?></strong></td>
					<td class="af-account-referrals-table-col4"><?php echo (empty($array['source'])) ? '' : af_service_type_code_to_title($array['source']);?></td>
					<?php if (!empty($data['print_source_details'])):?>
						<td class="af-account-referrals-table-col5"><?php
							if ($af_db->referral_has_source_details($array['id'])):
								$url = add_query_arg('reference', $array['id'], $data['source_details_url']);
								?>
								<a href="<?php echo esc_url($url);?>" target="_blank"><?php esc_html_e('View', 'openaffiliates');?></a>
								<?php
							else :
								echo esc_html('-');
							endif;
						?></td>
					<?php endif;?>
					<td class="af-account-referrals-table-col6"><?php echo esc_af_content($array['description']);?></td>
					<td class="af-account-referrals-table-col7"><?php echo af_convert_date_to_us_format($array['date']);?></td>
					<td class="af-special-label af-account-referrals-table-col8"><?php
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
			<?php if (!empty($data['pagination'])):?>
                <?php echo esc_af_content($data['pagination']);?>
            <?php endif;?>
        </div>
        </div>
        </div>
        </div>
	</div>
    <?php else: ?>
    	   <div class="af-account-detault-message">
              <div><?php esc_html_e('Here you will see all your Rewards and Commission that will be received based on your activity. Start your Affiliate campaign to earn commission.', 'openaffiliates');?></div>
          </div>
<?php endif;?>

</div>
</div>
</div>
