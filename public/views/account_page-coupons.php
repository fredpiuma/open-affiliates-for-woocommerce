<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Your Discount Coupons", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("Whenever a buyer makes a purchase with that coupon, you will automatically receive revenue. Promote available coupons to get more rewards.", 'openaffiliates');?>
                </div>
             </div>
                <div class="af-row ">
            	<div class="af-col-xs-12">
					<?php if (!empty($data['codes'])) : ?>
                        <table class="af-account-table">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Discount Code', 'openaffiliates');?></th>
                                    <th><?php esc_html_e('Discount value', 'openaffiliates');?></th>
                                    <th><?php esc_html_e('Source', 'openaffiliates');?></th>
                                    <th><?php esc_html_e('Reward', 'openaffiliates');?></th>
                                </tr>
                            </thead>
                            <tbody class="af-alternate">
                                <?php foreach ($data['codes'] as $arr) : ?>
                                    <tr>
                                        <td><?php echo esc_html($arr['code']);?></td>
																				<td><?php
																						if ( isset( $arr['customer_discount_type'] ) && isset( $arr['customer_discount_value'] ) ){
																								if ( $arr['customer_discount_type'] == 'percentage' || $arr['customer_discount_type'] =='percent' ){
																										echo esc_af_content($arr['customer_discount_value'] . '%');
																								} else {
																										echo af_format_price_and_currency(afCurrency($data['currency']), $arr['customer_discount_value'] );
																								}
																						}
																				?></td>
                                        <td><?php echo af_service_type_code_to_title($arr['type']);?></td>
                                        <td><?php
                                            $settings = unserialize($arr['settings']);
                                            if ($settings && isset($settings['amount_value']) && $settings['amount_value'] != '' ){
                                                if ($settings['amount_type']=='flat'){
                                                    echo af_format_price_and_currency(afCurrency($data['currency']), $settings['amount_value']);
                                                } else {
                                                    echo esc_af_content($settings['amount_value'] . '%');
                                                }
                                            } else if ( isset( $data['rank_data']['amount_type'] ) ) {
																								if ( $data['rank_data']['amount_type']=='percentage'){
																									//rank percentage
																								  echo esc_af_content($data['rank_data']['amount_value'] . '%');
																								} else {
																									//rank flat
																									echo af_format_price_and_currency( afCurrency($data['currency']), $data['rank_data']['amount_value'] );
																								}
																						}
                                        ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                    <?php else :?>
                     <div class="af-warning-box af-extra-margin-top"><?php esc_html_e('No Coupons have been assigned to your account yet.', 'openaffiliates');?></div>
                    <?php endif;?>
         </div>
    </div>
    </div>
</div>
</div>
<?php
