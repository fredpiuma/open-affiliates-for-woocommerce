<p class="<?php echo esc_attr($data['class']);?> af-fair-checkout-reward-wrapper">
	<?php if (self::$checkout_referrals_select_settings['af_checkout_select_referral_label']):?>
		<label><?php echo esc_af_content($data['require'] . self::$checkout_referrals_select_settings['af_checkout_select_referral_label']);?></label>
	<?php endif;?>
		<?php if (self::$checkout_referrals_select_settings['af_checkout_select_referral_s_type']==1):?>
			<select name="af_affiliate_username" class="<?php echo esc_attr($data['select_class']);?>" <?php echo esc_attr($data['require_on_input']);?> >
				<option value="">...</option>
				<?php
				foreach ($data['affiliates'] as $id => $label):
					?>
					<option value="<?php echo esc_attr($id);?>" ><?php echo esc_html($label);?></option>
					<?php
				endforeach;
			?></select>
		<?php else :?>
			<input type="text" value="" name="af_affiliate_username_text" class="<?php echo esc_attr($data['input_class']);?>" <?php echo esc_attr($data['require_on_input']);?> onBlur="afAffiliateUsernameTest(this.value);" id="af_affiliate_username_text"/>
		<?php endif;?>
</p>
