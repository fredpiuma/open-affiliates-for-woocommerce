<div class="af-account-clicks-tab">
<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>
	<div class="af-row">
		<div class="afcol-md-3 af-account-visits-tab1">
			<div class="af-account-no-box af-account-box-lightgray"><div class="af-account-no-box-inside"><div class="af-count"><?php echo esc_html($data['stats']['visits']);?></div><div class="af-detail"><?php esc_html_e('Total Numbers of Clicks', 'openaffiliates');?></div>
            <div class="af-subnote"><?php echo esc_html__('How many times your affiliate link have been used', 'openaffiliates'); ?></div></div></div>
		</div>
		<div class="afcol-md-3 af-account-visits-tab2">
			<div class="af-account-no-box af-account-box-red"><div class="af-account-no-box-inside"><div class="af-count"><?php echo esc_html($data['stats']['conversions']);?></div><div class="af-detail"><?php esc_html_e('Conversions', 'openaffiliates');?></div>
                <div class="af-subnote"><?php echo esc_html__('If customer successfully completes a certain action', 'openaffiliates'); ?></div></div></div>
		</div>
		<div class="afcol-md-3 af-account-visits-tab3">
			<div class="af-account-no-box af-account-box-lightblue"><div class="af-account-no-box-inside"><div class="af-count"><?php echo esc_af_content($data['stats']['success_rate'] . '%');?></div><div class="af-detail"><?php esc_html_e('Success Rate', 'openaffiliates');?></div></div></div>
		</div>
	</div>
	<?php if ((!empty($data['items']) && is_array($data['items'])) || !empty($data['filtered'])):?>
    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Clicks History", 'openaffiliates');?></span></div>
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
					<th><?php esc_html_e("Landing Page", 'openaffiliates');?></th>
					<th><?php esc_html_e("From Page", 'openaffiliates');?></th>
					<th><?php esc_html_e("Browser", 'openaffiliates');?></th>
					<th><?php esc_html_e("Device", 'openaffiliates');?></th>
					<th><?php esc_html_e("Date", 'openaffiliates');?></th>
					<th><?php esc_html_e("Status", 'openaffiliates');?></th>
				</tr>
			</thead>
			<tbody class="af-alternate">
			<?php foreach ($data['items'] as $array) : ?>
				<tr>
					<td><a href="<?php echo esc_url($array['url']);?>" target="_blank"><?php echo esc_url($array['url']);?></a></td>
					<?php if ( isset( $array['ref_url'] ) && $array['ref_url'] !== '' ):?>
							<td><a href="<?php echo esc_url($array['ref_url']);?>" target="_blank"><?php echo esc_url($array['ref_url']);?></a></td>
					<?php else :?>
							<td>-</td>
					<?php endif;?>
					<td><?php echo esc_af_content($array['browser']);?></td>
					<td><?php echo esc_af_content($array['device']);?></td>
					<td><?php echo af_convert_date_to_us_format($array['visit_date']);?></td>
					<td class="af-special-label af-text-align-center"><?php
						if ($array['referral_id']){
								echo '<div class="af-status af-status-active">'.esc_html__('Converted', 'openaffiliates').'</div>';

						}else{
								echo '<div class="af-status af-status-inactive">'.esc_html__('Just Visit', 'openaffiliates').'</div>';
						}
					?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<?php else: ?>
			 <div class="af-account-detault-message">
						<div><?php esc_html_e('No Clicks found for your selection.', 'openaffiliates');?></div>
				</div>
		<?php endif;?>
        </div>
        </div>
        </div>
        </div>
			<?php else: ?>
				 <div class="af-account-detault-message">
							<div><?php esc_html_e('Here you will see all your Clicks that will be received based on your activity. Start your Affiliate campaing to earn commission.', 'openaffiliates');?></div>
					</div>
	<?php endif;?>
</div>

<?php if (!empty($data['pagination'])):?>
	<?php echo esc_af_content($data['pagination']);?>
<?php endif;?>
</div>
