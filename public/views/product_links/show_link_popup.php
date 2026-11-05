<div class="af-show-link-popup-wrapp">
    <div class="af-the-popup">
        <div class="af-popup-top">
						<div class="title"><?php esc_html_e('Product Link', 'openaffiliates');?></div>
						<div class="close-bttn af-js-close-product-link-popup"></div>
						<div class="clear"></div>
        </div>
        <div class="af-popup-content">
            <?php if (!empty($data['friendly_links'])):?>
              <div class="af-ap-field">
                <label class="af-ap-label af-special-label"><?php esc_html_e("Friendly Links:", 'openaffiliates');?> </label>
                <select id="af_show_link_friendly_link" class="af-public-form-control ">
                  <option value="0"><?php esc_html_e('Off', 'openaffiliates');?></option>
                  <option value="1"><?php esc_html_e('On', 'openaffiliates');?></option>
                </select>
              </div>
            <?php endif;?>

            <?php if (!empty($data['custom_affiliate_slug']) && !empty($data['the_slug'])):?>
              <?php
                $ref_type = ($data['af_default_ref_format']=='username') ? esc_html__('Username', 'openaffiliates') : 'Id';
              ?>
              <div class="af-ap-field">
                <label class="af-ap-label af-special-label"><?php esc_html_e("Referrence Type:", 'openaffiliates');?> </label>
                <select id="af_show_link_ref_type" class="af-public-form-control ">
                  <option value="0"><?php echo esc_html($data['ref_type']);?></option>
                  <option value="1"><?php esc_html_e('Custom Affiliate Slug', 'openaffiliates');?></option>
                </select>
              </div>

            <?php endif;?>

            <div class="af-ap-field af-account-affiliatelinks-tab2">
              <div class="af-ap-label"><?php esc_html_e("Your Affiliate Link", 'openaffiliates');?> </div>
              <span><?php esc_html_e('Copy the generated link and paste it into your website', 'openaffiliates');?></span>
              <textarea readonly class="af-account-url af-js-show-links-the-link" onclick="this.select()" onfocus="this.select()"><?php
              echo esc_url($data['url']);?></textarea>
            </div>

						<div id="af_show_link_affiliate_id" data-affiliate_id="<?php echo esc_attr($data['affiliate_id']);?>" data-post_id="<?php echo esc_attr($data['post_id']);?>" ></div>

        </div>
    </div>
</div>
<?php
