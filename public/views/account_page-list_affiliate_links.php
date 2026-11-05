<?php
wp_enqueue_script( 'af_sweetalert_js', AF_URL . 'assets/js/sweetalert.js', [], '9.4' );
wp_enqueue_style( 'af_sweetalert_css', AF_URL . 'assets/css/sweetalert.css' );
?>
<div class="af-ap-wrap af-js-list-affiliate-links-wrapp">

	<?php if ((!empty($data['affiliate_links']) && is_array($data['affiliate_links'])) || !empty($data['affiliate_links'])): ?>
    <div class="af-profile-box-wrapper">
    		<div class="af-profile-box-title"><span><?php esc_html_e("Generated Affiliate Links", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
								<table class="af-account-table">
									<thead>
										<tr>
											<th><?php esc_html_e("Landing Page", 'openaffiliates');?></th>
											<th><?php esc_html_e("Affiliate Link", 'openaffiliates');?></th>
											<th><?php esc_html_e("Campaign", 'openaffiliates');?></th>
											<th><?php esc_html_e("Created Date", 'openaffiliates');?></th>
											<th><?php esc_html_e("Actions", 'openaffiliates');?></th>
										</tr>
									</thead>
									<tbody class="af-alternate">
									<?php foreach ($data['affiliate_links'] as $array) : ?>
										<tr>
											<td><a href="<?php echo esc_url($array['base_url']);?>" target="_blank"><?php echo esc_url($array['base_url']);?></a></td>
											<td><?php echo esc_url($array['affiliate_url']);?></td>
											<td><?php echo esc_af_content($array['campaign']);?></td>
											<td><?php
											$date = new \DateTime();
											$date->setTimestamp( $array['create_date'] );
											$date->setTimezone( new \DateTimeZone('UTC') );
											$time = $date->format('Y-m-d H:i:s');
											echo af_convert_date_to_us_format($time);?></td>
											<td><span class="af-js-list-affiliate-links-copy" data-confirm="<?php esc_html_e( 'copied to clipboard', 'openaffiliates' );?>" data-link="<?php echo esc_url($array['affiliate_url']);?>" ><?php esc_html_e("Copy Link", 'openaffiliates');?></span> <span class="af-js-list-affiliate-links-remove" data-id="<?php echo esc_html($array['id']);?>"><?php esc_html_e("Remove", 'openaffiliates');?></span></td>
										</tr>
									<?php endforeach;?>
									</tbody>
								</table>
        </div>
        </div>
        </div>
        </div>

	<?php endif;?>
</div>

<?php if (!empty($data['pagination'])):?>
	<?php echo esc_af_content($data['pagination']);?>
<?php endif;?>
