<div class="af-ap-wrap">

	<?php do_action( 'af_public_action_account_page_affiliate_links_before_content' );?>

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>
	<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Tracking details", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-8">
                	<div class=" af-account-affiliatelinks-tab1">
                	<?php if (empty($data['print_username'])): ?>
						<span><?php esc_html_e("Tracking ID:", 'openaffiliates');?></span> <span class=" af-special-label"><?php echo esc_html($data['affiliate_id']);?></span>
					<?php else:?>
						<span><?php esc_html_e("Tracking Code:", 'openaffiliates');?></span> <span class=" af-special-label"><?php echo esc_html($data['print_username']);?></span>
					<?php endif;?>
                    <div class="af-account-notes">
                    		<?php esc_html_e("Your unique identificator will be used for tracking new leads", 'openaffiliates');?>
                    </div>
                    </div>
                    <div class="af-account-affiliatelinks-tab2">
        				<span><?php esc_html_e("Default Affiliate Link:", 'openaffiliates');?></span> <span class=" af-special-label"><a href="<?php echo esc_url($data['home_url']);?>" target="_blank"><?php echo esc_url($data['home_url']);?></a></span>
                	</div>
                </div>
                <div class="af-col-xs-4">
                	<?php if (!empty($data['qr_home'])):?>
                      <div class="af-qr-code-wrapper af-account-affiliatelinks-tab3">
                          <img src="<?php echo esc_url($data['qr_home']);?>" />
                          <a href="<?php echo esc_url($data['qr_home']);?>" class="af-button-primary" download="<?php echo basename($data['qr_home']);?>"><?php esc_html_e('Download', 'openaffiliates');?></a>
                      </div>
                  <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($data['home_url_slug'])):?>
    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Custom Slug", 'openaffiliates');?></span></div>
    	<div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-8">
                    <div class="af-account-affiliatelinks-tab7">
        				<span><?php esc_html_e("Alternative Slug Link:", 'openaffiliates');?></span> <span class=" af-special-label"><a href="<?php echo esc_url($data['home_url_slug']);?>" target="_blank"><?php echo esc_url($data['home_url_slug']);?></a></span>
                         <div class="af-account-notes">
                    		<?php esc_html_e("You can change your custom Affiliate slug anytime from ", 'openaffiliates');?>
                            <a href="<?php echo esc_url($data['affiliate_slug_url']);?>">
			  						<?php esc_html_e('here', 'openaffiliates');?>
              					</a>
                    	</div>
                	</div>
                </div>
                <div class="af-col-xs-4">
                	<?php if (!empty($data['qr_custom_slug'])):?>
                      <div class="af-qr-code-wrapper af-account-affiliatelinks-tab4">
                          <img src="<?php echo esc_url($data['qr_custom_slug']);?>" />
                          <a href="<?php echo esc_url($data['qr_custom_slug']);?>" class="af-button-primary" download="<?php echo basename($data['qr_custom_slug']);?>"><?php esc_html_e('Download', 'openaffiliates');?></a>
                      </div>
                  <?php endif;?>
                </div>
            </div>
        </div>
	<?php endif;?>

     <?php if (!empty($data['social_links'])):?>
     <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Social Links", 'openaffiliates');?></span></div>
    	<div class="af-profile-box-content">
        	<?php echo esc_af_content($data['social_links']);?>
        </div>
     </div>
    <?php endif;?>

<?php do_action( 'af_public_action_account_page_affiliate_links_after_content' );?>

    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Affiliate Link Generator", 'openaffiliates');?></span></div>
    	<div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                	<div class="af-account-link-generator af-account-affiliatelinks-tab5">
                      <p><?php esc_html_e("If you'd like to add your own affiliate links with a different URL, follow this structure. Simply take the following URL and create a custom affiliate link for it.", 'openaffiliates');?></p>
                      <?php if (!empty($data['campaigns'])) : ?>
                      <div class="af-ap-field">
                          <label class="af-ap-label af-special-label"><?php esc_html_e("Campaign:", 'openaffiliates');?> </label>
                          <select id="campaigns_select" class="af-public-form-control ">
                          <?php foreach ($data['campaigns'] as $value) : ?>
                              <option value="<?php echo esc_attr($value);?>"><?php echo esc_html($value);?></option>
                          <?php endforeach;?>
                          </select>
                      </div>
                      <?php endif; ?>

                      <?php if (!empty($friendly_links)):?>
                      <div class="af-ap-field">
                          <label class="af-ap-label af-special-label"><?php esc_html_e("Friendly Links:", 'openaffiliates');?> </label>
                          <select id="friendly_links" class="af-public-form-control ">
                              <option value="0"><?php esc_html_e('Default link format', 'openaffiliates');?></option>
                              <option value="1"><?php esc_html_e('Friendly link format', 'openaffiliates');?></option>
                          </select>
                      </div>
                      <?php endif;?>

                      <?php if (!empty($custom_affiliate_slug) && !empty($the_slug)):?>
                          <?php
                              $ref_type = ($this->general_settings['af_default_ref_format']=='username') ? esc_html__('Tracking Code', 'openaffiliates') : 'Tracking ID';
                          ?>
                      <div class="af-ap-field">
                          <label class="af-ap-label af-special-label"><?php esc_html_e("Referrence Type:", 'openaffiliates');?> </label>
                          <select id="ref_type" class="af-public-form-control ">
                              <option value="0"><?php echo esc_html($ref_type);?></option>
                              <option value="1"><?php esc_html_e('Custom Slug', 'openaffiliates');?></option>
                          </select>
                      </div>
                      <?php endif;?>

                      <div class="af-ap-field">
                          <label class="af-ap-label af-special-label"><?php esc_html_e("Specific Website page:", 'openaffiliates');?> </label>
                          <input type="text" value="" id="ia_generate_aff_custom_url"  class="af-public-form-control ">
                      </div>
                      <span><?php esc_html_e("Enter any URL from this website in the form above to generate a referral link", 'openaffiliates');?></span>
                      <div class="af-ap-generate-links-result af-visibility-hidden"></div>
                      <div class="af-ap-generate-social-result af-visibility-hidden"></div>
                      <div class="af-ap-generate-qr-code af-visibility-hidden"></div>
                      <div class="af-ap-field">
                          <button type="button" class="af-button-primary" onClick="iaGenerateLink(<?php echo esc_attr($data['affiliate_id']);?>);"><?php esc_html_e("Generate Link", 'openaffiliates');?></button>
                      </div>
                     </div>
                </div>
            </div>
        </div>
     </div>

    <!--div class="af-account-alert-warning af-account-affiliatelinks-tab1">
		<?php if (empty($data['print_username'])): ?>
			<label class="af-ap-label"><?php esc_html_e("Your Affiliate ID is:", 'openaffiliates');?></label> <strong class=" af-special-label"><?php echo esc_html($data['affiliate_id']);?></strong>
		<?php else:?>
			<label class="af-ap-label"><?php esc_html_e("Your Affiliate Name is:", 'openaffiliates');?></label> <strong class=" af-special-label"><?php echo esc_html($data['print_username']);?></strong>
		<?php endif;?>
	</div>
	<div class="af-ap-field af-account-affiliatelinks-tab2">
		<label class="af-ap-label"><?php esc_html_e("Your referral URL is:", 'openaffiliates');?> </label>
	<div class="af-account-url">
		<a href="<?php echo esc_url($data['home_url']);?>" target="_blank"><?php echo esc_url($data['home_url']);?></a>
	</div>

	<?php if (!empty($data['qr_home'])):?>
		<div class="af-qr-code-wrapper af-account-affiliatelinks-tab3">
			<img src="<?php echo esc_url($data['qr_home']);?>" />
			<a href="<?php echo esc_url($data['qr_home']);?>" class="af-qr-code-download" download="<?php echo basename($data['qr_home']);?>"><?php esc_html_e('Download', 'openaffiliates');?></a>
		</div>
	<?php endif;?>

	<?php if (!empty($data['home_url_slug'])):?>
		<label class="af-ap-label"><?php esc_html_e("Your Custom Slug:", 'openaffiliates');?> </label>
		<div class="af-account-url-slug">
			<a href="<?php echo esc_url($data['home_url_slug']);?>" target="_blank"><?php echo esc_url($data['home_url_slug']);?></a>
		</div>

		<?php if (!empty($data['qr_custom_slug'])):?>
			<div class="af-qr-code-wrapper af-account-affiliatelinks-tab4">
				<img src="<?php echo esc_url($data['qr_custom_slug']);?>" />
				<a href="<?php echo esc_url($data['qr_custom_slug']);?>" class="af-qr-code-download" download="<?php echo basename($data['qr_custom_slug']);?>"><?php esc_html_e('Download', 'openaffiliates');?></a>
			</div>
		<?php endif;?>

	<?php endif;?>

	</div>
	<div><?php echo esc_af_content($data['social_links']);?></div>
  <div class="af-account-link-generator af-account-affiliatelinks-tab5">
	<h4><?php esc_html_e("Link Generator", 'openaffiliates');?></h4>
	<p><?php esc_html_e("If you'd prefer to append your own affiliate links with an alternate incoming URL, use the following structure. To build your link, take the following URL and append it with the Alternate Incoming URL you want to use.", 'openaffiliates');?></p>
	<?php if (!empty($data['campaigns'])) : ?>
	<div class="af-ap-field">
		<label class="af-ap-label af-special-label"><?php esc_html_e("Campaign:", 'openaffiliates');?> </label>
		<select id="campaigns_select" class="af-public-form-control ">
		<?php foreach ($data['campaigns'] as $value) : ?>
			<option value="<?php echo esc_attr($value);?>"><?php echo esc_html($value);?></option>
		<?php endforeach;?>
		</select>
	</div>
	<?php endif; ?>

	<?php if (!empty($friendly_links)):?>
	<div class="af-ap-field">
		<label class="af-ap-label af-special-label"><?php esc_html_e("Friendly Links:", 'openaffiliates');?> </label>
		<select id="friendly_links" class="af-public-form-control ">
			<option value="0"><?php esc_html_e('Off', 'openaffiliates');?></option>
			<option value="1"><?php esc_html_e('On', 'openaffiliates');?></option>
		</select>
	</div>
	<?php endif;?>

	<?php if (!empty($custom_affiliate_slug) && !empty($the_slug)):?>
		<?php
			$ref_type = ($this->general_settings['af_default_ref_format']=='username') ? esc_html__('Username', 'openaffiliates') : 'Id';
		?>
	<div class="af-ap-field">
		<label class="af-ap-label af-special-label"><?php esc_html_e("Referrence Type:", 'openaffiliates');?> </label>
		<select id="ref_type" class="af-public-form-control ">
			<option value="0"><?php echo esc_html($ref_type);?></option>
			<option value="1"><?php esc_html_e('Custom Affiliate Slug', 'openaffiliates');?></option>
		</select>
	</div>
	<?php endif;?>

	<div class="af-ap-field">
		<label class="af-ap-label af-special-label"><?php esc_html_e("Specific URL:", 'openaffiliates');?> </label>
		<input type="text" value="" id="ia_generate_aff_custom_url"  class="af-public-form-control ">
		<span><?php esc_html_e("Enter any URL from this website in the form above to generate a referral link!", 'openaffiliates');?></span>
	</div>
	<div class="af-ap-generate-links-result af-visibility-hidden"></div>
	<div class="af-ap-generate-social-result af-visibility-hidden"></div>
	<div class="af-ap-generate-qr-code af-visibility-hidden"></div>
	<div class="af-ap-field">
		<button type="button" onClick="iaGenerateLink(<?php echo esc_attr($data['affiliate_id']);?>);"><?php esc_html_e("Generate Link", 'openaffiliates');?></button>
	</div>
   </div-->


</div>
