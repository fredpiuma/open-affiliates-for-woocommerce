<?php
function af_create_ranks_graphic($ranks_arr, $current){
	/*
	 * @param array
	 * @return string
	 */
	if (is_array($ranks_arr)){
		$new_arr = af_reorder_ranks($ranks_arr);//reorder ranks by order attr
		$output = '';
		$padding = 7;
		foreach ($new_arr as $k=>$v){
			$class = 'af-rank-item';
			if ($v->id==$current){
				$current_printed = TRUE;
				$class .= ' af-current-rank';
			}
			$output .= '<div class="'.$class.'" style = "padding: ' . $padding . 'px 5px;">' . $v->label . '</div>';
			$padding += 7;
		}
		if (empty($current_printed)){
			$output .= '<div class="af-rank-item af-current-rank" style = "padding: ' . $padding . 'px 5px;">' . esc_html__('Current Rank', 'openaffiliates') . '</div>';
		}
		$output = '<div class="rank-graphic-representation">' . $output . '</div>';
		return $output;
	}
	return '';
}

function af_return_errors(){
	/*
	 * @param none
	 * @return string
	 */
	$output = '';
	global $af_error_register, $af_db;
	if (!empty($af_error_register)){
		$output = '<div class="af-error-message">'.esc_html__('It seems that there was an issue saving your data: ', 'openaffiliates');
		$fields = $af_db->register_get_custom_fields();
		$labels = array();
		if (!empty($fields)){
			foreach ($fields as $field){
				$labels[$field['name']] = $field['label'];
			}
		}

		foreach ($af_error_register as $key=>$err){
			$output .= esc_html__('field ', 'openaffiliates') . $labels[$key] . ': ' . $err. "; ";
		}
		$output .= '</div>';
	}
	return $output;
}

function af_return_payment_details_for_admin_table($payment_details=array()){
	/*
	 * @param array
	 * @return string
	 */
	 $output = '-';
	 if (!empty($payment_details['type'])){
	 	switch ($payment_details['type']){
			case 'bt':
				if (!empty($payment_details['settings'])){
					$output = '<div class="af-payment-details-do-payment">' . esc_html__('Bank Transfer Details: ', 'openaffiliates') . $payment_details['settings'] . '</div>';
				} else {
					$output = '<div class="af-payment-details-do-payment">' . esc_html__('Incomplete Payment Settings', 'openaffiliates') . '</div>';
				}
				break;
			case 'paypal':
				if (!empty($payment_details['settings'])){
					$output = '<div class="af-payment-details-do-payment">' . esc_html__('PayPal E-mail Address: ', 'openaffiliates') . $payment_details['settings'] . '</div>';
				} else {
					$output = '<div class="af-payment-details-do-payment">' . esc_html__('Incomplete Payment Settings', 'openaffiliates') . '</div>';
				}
				break;
			case 'stripe':
				if (!empty($payment_details['settings']['af_affiliate_stripe_name'])
					&& !empty($payment_details['settings']['af_affiliate_stripe_card_number'])
					&& !empty($payment_details['settings']['af_affiliate_stripe_expiration_month']) && !empty($payment_details['settings']['af_affiliate_stripe_expiration_year'])){ //&& !empty($payment_details['settings']['af_affiliate_stripe_cvc'])
					$output = '<div class="af-payment-details-do-payment">';
					$output .= esc_html__("Name on Card: ", 'openaffiliates') . $payment_details['settings']['af_affiliate_stripe_name'] . ', ';
					$output .= esc_html__("Card Number: ", 'openaffiliates') . $payment_details['settings']['af_affiliate_stripe_card_number'] . ', ';

					$output .= esc_html__("Expiration: ", 'openaffiliates') . $payment_details['settings']['af_affiliate_stripe_expiration_month'] . '/' . $payment_details['settings']['af_affiliate_stripe_expiration_year'];
					$output .= '</div>';
				} else {
					$output = '<div class="af-payment-details-do-payment">' . esc_html__('Incomplete Payment Settings', 'openaffiliates') . '</div>';
				}
				break;
			case 'stripe_v2':
				$output = '';
				break;
			case 'stripe_v3':
				if ( empty( $payment_details['account_id'] ) ){
						$output = '<div class="af-payment-details-do-payment">' . esc_html__('Incomplete Payment Settings', 'openaffiliates') . '</div>';
				} else {
					$stripe_link = '';
					$sandbox = get_option( 'af_stripe_v3_sandbox' );
					if ( $sandbox ){
							$stripe_link = 'https://dashboard.stripe.com/test/connect/accounts/'.$payment_details['account_id'];
					}else{
							$stripe_link = 'https://dashboard.stripe.com/connect/accounts/'.$payment_details['account_id'];
					}
						$output = '<div class="af-payment-details-do-payment"><a href="' . $stripe_link . '" target="_blank">' . esc_html__( 'View Stripe Affiliate Account', 'openaffiliates') . '</a></div>';
				}
				break;
	 	}
	 }
	 return $output;
}

if ( !function_exists( 'af_admin_get_payment_gateway_label_for_affiliate' ) ):
/**
 * @param int
 * @param int
 * @return string
 */
function af_admin_get_payment_gateway_label_for_affiliate( $affiliateId=0, $uid=0 )
{
		global $af_db;
			if ( $affiliateId === 0 ){
					return '';
			}
			$data = $af_db->get_affiliate_payment_type( 0, $affiliateId );

			if ( empty( $data ) ){
					return '<span class="af-admin-aff-payment-type">-</span>';
			}
			$base_view_payment_settings_url = admin_url('admin.php?page=openaffiliates&tab=view_payment_settings&uid=');
			$output = '';
			switch ($data['type']){
				case 'paypal':
					$payment_class = ($data['is_active']) ? 'af-payment-type-active-paypal' : '';
					$output = '<a href="'.esc_url($base_view_payment_settings_url . $uid).'" target="_blank">
											<span class="af-admin-aff-payment-type ' . esc_attr($payment_class) . '">' . esc_html__('PayPal', 'openaffiliates') . '</span>
					</a>';
					break;
				case 'bt':
					$payment_class = ($data['is_active']) ? 'af-payment-type-active-bt' : '';
					$output = '<a href="' . esc_url($base_view_payment_settings_url . $uid) . '" target="_blank">
						<span class="af-admin-aff-payment-type ' . esc_attr($payment_class) . '">' . esc_html__('Direct Deposit', 'openaffiliates') . '</span>
					</a>';
					break;
				case 'stripe':
					$payment_class = ($data['is_active']) ? 'af-payment-type-active-stripe' : '';
					$output = '<a href="' . esc_url($base_view_payment_settings_url . $uid) . '" target="_blank">
											<span class="af-admin-aff-payment-type ' . esc_attr($payment_class) . '">' . esc_html__('Stripe', 'openaffiliates') . '</span>
										</a>';
					break;
				case 'stripe_v2':
					$payment_class = ($data['is_active']) ? 'af-payment-type-active-stripe' : '';
					$output = '<a href="' . esc_url($base_view_payment_settings_url . $uid) . '" target="_blank">
						<span class="af-admin-aff-payment-type ' . esc_attr($payment_class) . '">' . esc_html__('Stripe', 'openaffiliates') . '</span>
					</a>';
					break;
				case 'stripe_v3':
					$payment_class = ($data['is_active']) ? 'af-payment-type-active-stripe' : '';
					$output = '<a href="'.esc_url($base_view_payment_settings_url . $uid).'" target="_blank">
											<span class="af-admin-aff-payment-type ' . esc_attr($payment_class) . '">' . esc_html__('Stripe', 'openaffiliates') . '</span>
										</a>';
					break;
			}
			return $output;
}
endif;
