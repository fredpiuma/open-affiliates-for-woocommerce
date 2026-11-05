<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

<div class="af-stuffbox">
	<h3 class="af-h3"><?php esc_html_e('General Settings', 'openaffiliates');?></h3>
	<div class="inside">
		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-12">
					<h2><?php esc_html_e('Which Rate should be used for Referral calculation?', 'openaffiliates');?></h2>
					<p><?php esc_html_e('If there are multiple Rate set for the same action, like Ranks&Product Rates or multiple Product Rates decide which one will be taken in consideration', 'openaffiliates');?></p>
				</div>
				<div class="col-xs-6">
							<select name="af_referral_offer_type" class="form-control m-bot15"><?php
							$types = array('lowest'=>esc_html__('Lowest Amount', 'openaffiliates'), 'biggest'=>esc_html__('Biggest Amount', 'openaffiliates'));
							foreach ($types as $key=>$value){
								$selected = ($key==$data['metas']['af_referral_offer_type']) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($key)?>" <?php echo esc_attr($selected);?>><?php echo esc_html($value);?></option>
								<?php
							}
						?></select>
					</div>
				</div>
		</div>
		<div class="af-form-line">
					<h2><?php esc_html_e('Redirect', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Redirect Same Page Without URL parameters. This feature enhances the overall affiliate experience, providing a seamless and personalized approach to URL presentation.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_redirect_without_param']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_redirect_without_param');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_redirect_without_param" value="<?php echo esc_attr($data['metas']['af_redirect_without_param']);?>" id="af_redirect_without_param" />
		</div>

		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
				<h2><?php esc_html_e('Affiliate Link Settings', 'openaffiliates');?></h2>
				<br/>
				<p><?php esc_html_e('Set the Affiliate Link Variable name', 'openaffiliates');?></p>
					<div class="form-group">
						<input type="text" class="form-control" value="<?php echo esc_attr($data['metas']['af_referral_variable']);?>" name="af_referral_variable" />
					</div>
				</div>
				<div class="col-xs-12">
				<p><?php echo esc_html__('The URL variable for affiliate URLs. For example: ', 'openaffiliates')."<strong>".get_site_url().'/?'.esc_attr($data['metas']['af_referral_variable']).'=1</strong>';?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
				<h4><?php esc_html_e('Base Affiliate Link', 'openaffiliates');?></h4>
				<br/>
					<div class="form-group">
						<?php if (empty($data['metas']['af_referral_custom_base_link'])){
							 $data['metas']['af_referral_custom_base_link'] = get_home_url();
						}?>
						<input type="text" class="form-control" onBlur="afCheckBaseReferralLink(this.value, '<?php echo get_site_url();?>');" value="<?php echo esc_attr($data['metas']['af_referral_custom_base_link']);?>" name="af_referral_custom_base_link" />
					</div>
				</div>
				<div class="col-xs-12">
					<p id="base_referral_link_alert"><?php esc_html_e('Please insert a link from the website on which this plugin is installed.
Do not enter a link from a different website.', 'openaffiliates');?></p>
				</div>
			</div>

		</div>
		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
				<p class="af-labels-special"><?php esc_html_e('Affiliate Link Format:', 'openaffiliates');?></p>
				<select name="af_default_ref_format" class="form-control m-bot15"><?php
				$referral_format = array('id' => 'Affiliate ID', 'username'=>'Username');
				foreach ($referral_format as $k=>$v){
					$selected = ($data['metas']['af_default_ref_format']==$k) ? 'selected' : '';
					?>
					<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
					<?php
				}
				?></select>
			</div>
			<div class="col-xs-12">
				<p><?php echo esc_html__('Display affiliate URLs to affiliates with either their unique affiliate ID or Username appended. For Example: ', 'openaffiliates')."<strong>".get_site_url().'/?'.esc_attr($data['metas']['af_referral_variable']).'=1</strong>'.' or '."<strong>".get_site_url().'/?'.esc_attr($data['metas']['af_referral_variable']).'=admin</strong>';?></p>
				</div>
			</div>
		</div>

		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
						<p class="af-labels-special"><?php esc_html_e('Search into URL for both affiliate link format:', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_search_into_url_for_affid_or_username']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_search_into_url_for_affid_or_username');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_search_into_url_for_affid_or_username" value="<?php echo esc_attr($data['metas']['af_search_into_url_for_affid_or_username']);?>" id="af_search_into_url_for_affid_or_username" />
				</div>
			</div>
		</div>


	<div class="af-form-line">
		<div class="row">
			<div class="col-xs-12">
			<h4><?php esc_html_e('Affiliate Link URL Blacklist', 'openaffiliates');?></h4>
			<br/>
			<p><?php esc_html_e('If you wish to block specific affiliates’ websites from generating referrals for any reason, you can do it by placing here their website urls. Place one URL per line.', 'openaffiliates');?></p>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<textarea class="form-control"  name="af_blocked_referers"><?php echo esc_html($data['metas']['af_blocked_referers']);?></textarea>
				</div>
			</div>
		</div>
	</div>

		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
				<h4><?php esc_html_e('Campaign Settings', 'openaffiliates');?></h4>
				<br/>
				<p><?php esc_html_e('Set the Campaign Variable name', 'openaffiliates');?></p>
					<div class="form-group">
						<input type="text" class="form-control" value="<?php echo esc_attr($data['metas']['af_campaign_variable']);?>" name="af_campaign_variable"  />
					</div>
				</div>
			</div>
		</div>

			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-6">
					<h2><?php esc_html_e('Cookie Settings', 'openaffiliates');?></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><?php esc_html_e('Cookie Expiration:', 'openaffiliates');?></span>
						<input type="number" min="1" class="form-control" value="<?php echo esc_attr($data['metas']['af_cookie_expire']);?>" name="af_cookie_expire"/>
						<div class="input-group-addon"> <?php esc_html_e("Days", 'openaffiliates');?></div>
					</div>
					<p><?php esc_html_e('Enter how many days the affiliate tracking cookie should be valid for.', 'openaffiliates');?></p>

					</div>
				</div>
			</div>

			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-12">
						<h4><?php esc_html_e('Cookie Sharing', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Enable the sharing of tracking cookies across sub-domains within a multisite installation. When activated, cookies generated on domain.com will also be accessible on sub.domain.com. Please note that this functionality is specific to WordPress Multisite installations.', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_cookie_sharing']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_cookie_sharing');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_cookie_sharing" value="<?php echo esc_attr($data['metas']['af_cookie_sharing']);?>" id="af_cookie_sharing" />
					</div>
				</div>
			</div>


		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('Currency Settings', 'openaffiliates');?></h2>
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Currency:', 'openaffiliates');?></span>
						<select name="af_currency" class="form-control m-bot15"><?php
							$currency = af_get_currencies_list();
							foreach ($currency as $k=>$v){
								$selected = ($k==$data['metas']['af_currency']) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?></select>
						<p><?php esc_html_e('Choose your currency. Note that some payment gateways have currency restrictions.', 'openaffiliates');?></p>
					</div>
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Currency Symbol position:', 'openaffiliates');?></span>
						<select name="af_currency_position" class="form-control m-bot15"><?php
							$positions = [
															'left'        => esc_html__('Before - $10', 'openaffiliates'),
															'right'       => esc_html__('After - 10$', 'openaffiliates'),
															'left_space'  => esc_html__('Before with space - $ 10', 'openaffiliates'),
															'right_space' => esc_html__('After with space - 10 $', 'openaffiliates'),
							];
							foreach ($positions as $k=>$v){
								$selected = ($k==$data['metas']['af_currency_position']) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?></select>
						<p><?php esc_html_e('Choose the location of the currency symbol.', 'openaffiliates');?></p>
					</div>
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Thousands Separator', 'openaffiliates');?></span>
						<input type="text" value="<?php echo esc_attr($data['metas']['af_thousands_separator']);?>" name="af_thousands_separator" class="form-control" />
					</div>

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Decimals Separator', 'openaffiliates');?></span>
						<input type="text" value="<?php echo esc_attr($data['metas']['af_decimals_separator']);?>" name="af_decimals_separator" class="form-control" />
					</div>

					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Number of Decimals', 'openaffiliates');?></span>
						<input type="number" min="0" value="<?php echo esc_attr($data['metas']['af_num_of_decimals']);?>" name="af_num_of_decimals" class="form-control" />
					</div>

					</div>
				</div>
			</div>

			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-8">
							<h2><?php esc_html_e('Referral Calculation Settings', 'openaffiliates');?></h2>
						</div>

				<div class="col-xs-12">
						<h4><?php esc_html_e('Exclude Shipping', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Exclude shipping costs from referral calculations to ensure accurate commission attribution. This option allows you to customize how referrals are calculated by excluding the shipping expenses from the total sale value.', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_exclude_shipping']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_exclude_shipping');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_exclude_shipping" value="<?php echo esc_attr($data['metas']['af_exclude_shipping']);?>" id="af_exclude_shipping" />

		 </div>
		</div>
<div class="row">
	<div class="col-xs-12">
						<h4><?php esc_html_e('Exclude Tax', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Exclude taxes from referral calculations. When enabled, the plugin ensures that taxes are not factored into the referral calculation, allowing you to tailor your commission rules more precisely.', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_exclude_tax']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_exclude_tax');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_exclude_tax" value="<?php echo esc_attr($data['metas']['af_exclude_tax']);?>" id="af_exclude_tax" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h4><?php esc_html_e('Save Zero Value Referrals', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Allows you to control whether the plugin should store or skip referrals without actual sales or conversions. This can be valuable for tracking the overall impact of your affiliates, providing a comprehensive view of their efforts, regardless of immediate results.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_empty_referrals_enable']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_empty_referrals_enable');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_empty_referrals_enable" value="<?php echo esc_attr($data['metas']['af_empty_referrals_enable']);?>" id="af_empty_referrals_enable" />
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4><?php esc_html_e('Reject Commissions on Refund', 'openaffiliates');?></h4>
			<p><?php esc_html_e('Auto reject Unpaid Referrals when the original purchase is refunded or revoked.', 'openaffiliates');?></p>
			<label class="af_label_shiwtch af-switch-button-margin">
				<?php $checked = ($data['metas']['af_reject_refund_referrals']) ? 'checked' : '';?>
				<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_reject_refund_referrals');" <?php echo esc_attr($checked);?> />
				<div class="switch af-display-inline"></div>
			</label>
			<input type="hidden" name="af_reject_refund_referrals" value="<?php echo esc_attr($data['metas']['af_reject_refund_referrals']);?>" id="af_reject_refund_referrals" />
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h4><?php esc_html_e('New Customer Commissions', 'openaffiliates');?></h4>
			<p><?php esc_html_e("This setting ensures that affiliates receive commissions only for referring new customers, individuals making their initial purchase on your online store. When activated, referrals won't be generated for returning customers. However, subscriptions will consistently generate renewal referrals if you have configured subscription renewal referrals.", 'openaffiliates');?></p>
			<label class="af_label_shiwtch af-switch-button-margin">
				<?php $checked = ($data['metas']['af_new_customer_commissions']) ? 'checked' : '';?>
				<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_new_customer_commissions');" <?php echo esc_attr($checked);?> />
				<div class="switch af-display-inline"></div>
			</label>
			<input type="hidden" name="af_new_customer_commissions" value="<?php echo esc_attr($data['metas']['af_new_customer_commissions']);?>" id="af_new_customer_commissions" />
		</div>
	</div>
		</div>


		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-12">
					<h2><?php esc_html_e('Automatically Affiliate', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Every new user who signs up on your website is instantly enrolled as an affiliate eliminating the need for manual assignments. By automating the affiliate onboarding process, you save time and effortlessly expand your affiliate network.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_all_new_users_become_affiliates']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_all_new_users_become_affiliates');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_all_new_users_become_affiliates" value="<?php echo esc_attr($data['metas']['af_all_new_users_become_affiliates']);?>" id="af_all_new_users_become_affiliates" />
				</div>
			</div>
		</div>

				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-8">
							<h2><?php esc_html_e('Default Country', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Choose a default country for Affiliates submission form. If none is chosen default WordPress Locale will be used instead', 'openaffiliates');?></p>
									<select name="af_defaultcountry" class="form-control m-bot15">
									<option value="" >....</option>
									<?php
									$types = af_get_countries();
									foreach ($types as $key=>$value){
										$key = strtolower($key);
										$selected = ($key==$data['metas']['af_defaultcountry']) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($value);?></option>
										<?php
									}
								?></select>
					</div>
				</div>
			</div>

		<div id="af_save_changes" class="af-submit-form">
			<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
		</div>
	</div>

</div>
</form>
</div>
