<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_html($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<form  method="post" class="af-change-password-form">

	<input type="hidden" name="af_payment_settings_nonce" value="<?php echo wp_create_nonce( 'af_payment_settings_nonce' );?>" class="af-js-payment-settings-nonce"/>

	<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Your Payout Method", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-8">
                  <select class="af-public-form-control" onChange="afPaymentType();" name="af_affiliate_payment_type"><?php
                      foreach ($data['payment_types'] as $k=>$v):
                          $selected = ($data['metas']['af_affiliate_payment_type']==$k) ? 'selected' : '';
                          ?>
                          <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php esc_html_e("Pay me by", 'openaffiliates');?> <?php echo esc_html($v);?></option>
                          <?php
                      endforeach;
                  ?></select>
                 </div>
             </div>
            <div class="af-account-notes"><?php esc_html_e("Before proceeding with the payment, please ensure that your payment information has been submitted correctly.", 'openaffiliates');?></div>

        </div>
	</div>
    <div class="af-profile-box-wrapper">
        <div class="af-profile-box-content af-no-padding">
        	<div class="af-row ">
            	<div class="af-col-xs-8">
	<div id="af_payment_with_paypal" class="af-display-none">
		<div class="af-account-title-label"><?php esc_html_e("Submit your PayPal Account Email Address", 'openaffiliates');?></div>
		<input class="af-public-form-control" type="text" value="<?php echo esc_attr($data['metas']['af_affiliate_paypal_email']);?>" name="af_affiliate_paypal_email" />
	</div>

	<div id="af_payment_with_bt" class="af-display-none">
		<div class="af-account-title-label"><?php esc_html_e("Bank Account details", 'openaffiliates');?></div>
        <div class="af-account-notes"><?php esc_html_e("You have the option to receive your earnings directly in your personal bank account", 'openaffiliates');?></div>
		<textarea class="af-public-form-control af-bank-transfer-box" name="af_affiliate_bank_transfer_data"><?php echo esc_html($data['metas']['af_affiliate_bank_transfer_data']);?></textarea>
	</div>

	<div id="af_payment_with_stripe_v3" class="af-display-none">
		<div><?php
			global $current_user;
			$uid = isset( $current_user->ID ) ? $current_user->ID : 0;

			$stripeObject = new \OpenAffiliates\PayoutStripeV3();
			$link = $stripeObject->generateAuthLink( $uid );
			if ( $link ){
				  if ( get_user_meta( $uid, 'af_stripe_v3_user_account_id' ) ){
					  ?>
					  <div class="af-account-title-label"><?php esc_html_e( 'Your Stripe Account is connected. You may connect a different account using the link below.', 'openaffiliates' );?></div>
					  <?php
				  }else{?>
					   <div class="af-account-title-label"><?php esc_html_e("Create or use your existing Stripe account for Connection", 'openaffiliates');?></div>
				  <?php
				  } ?>
					<div class="af-clear"></div>

         <div class="button button-primary button-large af-js-stripe-v3-auth-bttn" data-submit_label="<?php esc_html_e( 'Authentificate Into Stripe', 'openaffiliates' );?>" data-loading="<?php esc_html_e( 'Please wait...', 'openaffiliates' );?>" ><?php esc_html_e( 'Authentificate Into Stripe', 'openaffiliates' );?></div>

				 <div class="af-clear"></div>
				 <div class="af-display-none af-warning-box-margin-top" id="af_stripe_auth_message" ></div>
		 <?php }?>
	 	</div>
	</div>

	<div class="af-ap-field af-display-none" id="af_payment_with_stripe">
		<div>
			<label class="af-ap-label"><?php esc_html_e("Name on Card", 'openaffiliates');?></label>
			<input class="af-public-form-control" type="text" value="<?php echo esc_attr($data['metas']['af_affiliate_stripe_name']);?>" name="af_affiliate_stripe_name" />
		</div>
		<div>
			<label class="af-ap-label"><?php esc_html_e("Card Number", 'openaffiliates');?></label>
			<input class="af-public-form-control" type="text" value="<?php echo esc_attr($data['metas']['af_affiliate_stripe_card_number']);?>" name="af_affiliate_stripe_card_number" />
		</div>
		<div>
			<label class="af-ap-label"><?php esc_html_e("Expiration", 'openaffiliates');?></label>
			<div>
				<div class="af-display-inline">
					<select name="af_affiliate_stripe_expiration_month"><?php
						for ($m=1; $m<13; $m++):
							$selected = ($m==$data['metas']['af_affiliate_stripe_expiration_month']) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr($m);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($m);?></option>
							<?php
						endfor;
					?></select>
				</div>
				<div class="af-display-inline">
					<select name="af_affiliate_stripe_expiration_year"><?php
						$year = date('Y');
						for ($y=$year; $y<$year+10; $y++):
							$selected = ($y==$data['metas']['af_affiliate_stripe_expiration_year']) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr($y);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($y);?></option>
							<?php
						endfor;
					?></select>
				</div>
			</div>
		</div>
		<div>
			<label class="af-ap-label"><?php esc_html_e("Type", 'openaffiliates');?></label>
			<div>
				<select name="af_affiliate_stripe_card_type"><?php
					foreach ($data['stripe_card_types'] as $key=>$value):
						$selected = ($key==$data['metas']['af_affiliate_stripe_card_type']) ? 'selected' : '';
						?>
						<option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($value);?></option>
						<?php
					endforeach;
				?></select>
			</div>
		</div>
	</div>

	<div class="af-ap-field af-display-none" id="af_payment_with_stripe_v2">

		<div>
			<label class="af-ap-label"><?php esc_html_e("Type", 'openaffiliates');?></label>
			<div>
				<?php $user_type_arr = array('company' => esc_html__('Company', 'openaffiliates'), 'individual' => esc_html__('Individual', 'openaffiliates'));?>
				<select name="stripe_v2_meta_data[user_type]" class="stripe_v2_meta_data_user_type af-public-form-control" onChange="afStripeV2UpdateFields();"><?php
					foreach ($user_type_arr as $key=>$value):
						$selected = ($key==$data['stripe_v2']['user_type']) ? 'selected' : '';
						?>
						<option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($value);?></option>
						<?php
					endforeach;
				?></select>
			</div>
		</div>

		<div>
			<label class="af-ap-label"><?php esc_html_e("Country", 'openaffiliates');?></label>
			<div>
				<select name="stripe_v2_meta_data[country]" class="stripe_v2_meta_data_country af-public-form-control" onChange="afStripeV2UpdateFields();"><?php
					$countries = array(
										'gb' => 'UK',
										'us' => 'US',
										'ca' => 'Canada',
										'at' => 'Austria',
			 							'be' => 'Belgium',
										'dk' => 'Denmark',
			 							'fr' => 'France',
			 							'fi' => 'Finland',
			 							'de' => 'Germany',
			 							'ie' => 'Ireland',
			 							'it' => 'Italy',
			 							'lu' => 'Luxembourg',
			 							'nl' => 'Netherlands',
			 							'no' => 'Norway',
			 							'pt' => 'Portugal',
			 							'se' => 'Sweden',
			 							'es' => 'Spain',
			 							'ch' => 'Switzerland',
					);
					foreach ($countries as $key=>$value):
						$selected = ($key==$data['stripe_v2']['country']) ? 'selected' : '';
						?>
						<option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($value);?></option>
						<?php
					endforeach;
				?></select>
			</div>
		</div>

		<div class="af-stripe-v2-field" data-country="us" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("State", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[state]" value="<?php echo esc_attr($data['stripe_v2']['state']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("City", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[city]" value="<?php echo esc_attr($data['stripe_v2']['city']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="non_us" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Additional owners", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[additional_owners]" value="<?php echo (isset($data['stripe_v2']['additional_owners'])) ? $data['stripe_v2']['additional_owners'] : ''; ?>" />
		</div>

		<div class="af-stripe-v2-field af-js-routing-number" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Routing Number", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[routing_number]" value="<?php echo esc_attr($data['stripe_v2']['routing_number']);?>" />
		</div>

		<div class="af-stripe-v2-field af-js-transit-number" data-country="ca" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Transit Number", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[transit_number]" value="<?php echo esc_attr($data['stripe_v2']['transit_number']);?>" />
		</div>

		<div class="af-stripe-v2-field af-js-institution-number" data-country="ca" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Institution Number", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[institution_number]" value="<?php echo esc_attr($data['stripe_v2']['institution_number']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Account Number", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[account_number]" value="<?php echo esc_attr($data['stripe_v2']['account_number']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Birthday day", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[day]" min="1" max="31" value="<?php echo esc_attr($data['stripe_v2']['day']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Birthday month", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[month]" min="1" max="12" value="<?php echo esc_attr($data['stripe_v2']['month']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Birthday year", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[year]" min="1900" max="" value="<?php echo esc_attr($data['stripe_v2']['year']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("First Name", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[first_name]" value="<?php echo esc_attr($data['stripe_v2']['first_name']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Last Name", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[last_name]" value="<?php echo esc_attr($data['stripe_v2']['last_name']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Address", 'openaffiliates');?></label>
			<textarea class="af-public-form-control" name="stripe_v2_meta_data[line1]"><?php echo esc_attr($data['stripe_v2']['line1']);?></textarea>
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Postal Code", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[postal_code]" min="0" max="" value="<?php echo esc_attr($data['stripe_v2']['postal_code']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="us" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("SSN Last 4", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[ssn_last_4]" min="0" max="" value="<?php echo esc_attr($data['stripe_v2']['ssn_last_4']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="us" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Personal ID Number", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[personal_id_number]" min="0" max="" value="<?php echo esc_attr($data['stripe_v2']['personal_id_number']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Business Name", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[business_name]" value="<?php echo esc_attr($data['stripe_v2']['business_name']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Business Tax ID", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[business_tax_id]" value="<?php echo esc_attr($data['stripe_v2']['business_tax_id']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="non_us" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Personal Address - City", 'openaffiliates');?></label>
			<input type="text" class="af-public-form-control" name="stripe_v2_meta_data[personal_address.city]" value="<?php echo esc_attr($data['stripe_v2']['personal_address.city']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="non_us" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Personal Address - Line 1", 'openaffiliates');?></label>
			<textarea class="af-public-form-control" name="stripe_v2_meta_data[personal_address.line1]"><?php echo esc_attr($data['stripe_v2']['personal_address.line1']);?></textarea>
		</div>

		<div class="af-stripe-v2-field" data-country="non_us" data-type="company">
			<label class="af-ap-label"><?php esc_html_e("Personal Address Postal Code", 'openaffiliates');?></label>
			<input type="number" class="af-public-form-control" name="stripe_v2_meta_data[personal_address.postal_code]" min="0" max="" value="<?php echo esc_attr($data['stripe_v2']['personal_address.postal_code']);?>" />
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<label class="af-ap-label"><?php esc_html_e("Verification Document", 'openaffiliates');?></label>
			<div>
				<?php echo af_create_form_element(array('type' => 'file', 'name' => 'verification_document'));?>
			</div>
		</div>

		<div class="af-stripe-v2-field" data-country="all" data-type="all">
			<?php $checked = ($data['stripe_v2']['stripe_v2_tos']==1) ? 'checked' : '';?>
			<input type="checkbox" class="stripe_v2_tos" name="stripe_v2_meta_data[stripe_v2_tos]" value="1" disabled <?php echo esc_attr($checked);?> />
			<a href="#" class="af-js-payment-settings-stripe-tos" ><?php esc_html_e("Terms of service", 'openaffiliates');?></a>
		</div>

	</div>

	<?php if (!empty($data['errors'])):?>
		<div class="af-clear"></div>
		<div class="af-warning-box-margin-top">
			<?php echo esc_af_content($data['errors']);?>
		</div>
	<?php endif;?>

	<div class="af-change-password-field-wrap">
		<input type="submit" value="<?php esc_html_e("Save Changes", 'openaffiliates');?>" name="save_settings" class="button button-primary button-large" <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?>  />
	</div>
	<?php if (!empty($data['error'])) : ?>
		<div><?php echo esc_af_content($data['error']);?></div>
	<?php elseif (!empty($data['success'])) : ?>
		<div><?php echo esc_af_content($data['success']);?></div>
	<?php endif; ?>
</form>
    		</div>
            </div>
        </div>
	</div>
</div>
