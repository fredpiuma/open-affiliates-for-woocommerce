<div class="af-wrapper">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('View Referral Details', 'openaffiliates');?></h3>
		<div class="inside">
			<?php if (!empty($data['metas'])):?>
				<div>
					<label><?php echo esc_html__('Visit Id:', 'openaffiliates');?></label>
					<?php echo esc_html($data['metas']['visit_id']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Referral User WP Id:', 'openaffiliates');?></label>
					<?php echo esc_html($data['metas']['refferal_wp_uid']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Campaign:', 'openaffiliates');?></label>
					<?php echo esc_html($data['metas']['campaign']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Affiliate:', 'openaffiliates');?></label>
					<?php echo esc_html($data['metas']['affiliate_id']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Description:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['description']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Source:', 'openaffiliates');?></label>
					<?php echo af_service_type_code_to_title($data['metas']['source']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Reference:', 'openaffiliates');?></label>
					<?php
						$link = '';
						if (!empty($data['metas']['reference'])){
							switch ($data['metas']['source']){
								case 'woo':
									if (!empty($data['woo_order_base_link'])){
										$link = $data['woo_order_base_link'] . $data['metas']['reference'] . '&action=edit';
									}
									break;
								case 'edd':
									if (!empty($data['edd_order_base_link'])){
										$link = $data['edd_order_base_link'] . $data['metas']['reference'];
									}
									break;
								case 'ump':
									if (function_exists('ihc_get_payment_id_by_order_id')){
										$payment_id = ihc_get_payment_id_by_order_id($data['metas']['reference']);
										if ($payment_id){
											if (!empty($data['ump_order_base_link'])){
												$link = $data['ump_order_base_link'] . $payment_id;
											}
										}
									}
									break;
								case 'mlm':
									$the_ref = $array['reference'];
									$the_ref = str_replace('mlm_', '', $the_ref);
									$link = $data['mlm_order_base_link'] . $the_ref;
									break;
							}
						}
						if (!empty($link)){
							echo esc_af_content('<a href="' . esc_url($link) . '" target="_blank">' . $data['metas']['reference'] . '</a>');
						} else {
							echo esc_af_content($data['metas']['reference']);
						}
				?>
				</div>

				<div>
					<label><?php echo esc_html__('Reference Details:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['reference_details']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Referral Parent:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['parent_referral_id']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Referral Child:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['child_referral_id']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Amount:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['amount'] . ' ' . $data['currency']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Date:', 'openaffiliates');?></label>
					<?php echo esc_af_content($data['metas']['date']);?>
				</div>

				<div>
					<label><?php echo esc_html__('Status:', 'openaffiliates');?></label>
					<?php
						switch ($data['metas']['status']){
							case 0:
								_e('Rejected', 'openaffiliates');
								break;
							case 1:
								_e('Unverfied', 'openaffiliates');
								break;
							case 2:
								_e('Verified', 'openaffiliates');
								break;
						}
					?>
				</div>

				<div>
					<label><?php echo esc_html__('Payment Status:', 'openaffiliates');?></label>
					<?php
						switch ($data['metas']['payment']){
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
					?>
				</div>


			<?php else: ?>
				<?php esc_html_e("No details available!", 'openaffiliates');?>
			<?php endif;?>
		</div>
	</div>
</div>
