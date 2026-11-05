

<?php if (!empty($data['friendly_links'])):?>
<div class="af-ap-field">
  <label class="af-ap-label af-special-label"><?php esc_html_e("Friendly Links:", 'openaffiliates');?> </label>
  <select id="af_affiliate_bar_friendly_links" onChange="" class="af-public-form-control ">
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
  <select id="ap_affiliate_bar_ref_type" onChange="" class="af-public-form-control ">
    <option value="0"><?php echo esc_html($data['ref_type']);?></option>
    <option value="1"><?php esc_html_e('Custom Affiliate Slug', 'openaffiliates');?></option>
  </select>
</div>

<?php endif;?>

<div id="af_info_affiliate_bar_extra_info" data-affiliate_id="<?php echo isset( $data['affiliate_id'] ) ? $data['affiliate_id'] : '';?>"></div>

<div class="af-ap-field af-account-affiliatelinks-tab2">
  <div class="af-ap-label"><?php esc_html_e("Your Affiliate Link", 'openaffiliates');?> </div>
  <span><?php esc_html_e('Copy the generated link and paste it into your website', 'openaffiliates');?></span>
<textarea readonly class="af-account-url af-js-iab-affiliate-link" onclick="this.select()" onfocus="this.select()">
 <?php echo esc_af_content($data['url']);?>
</textarea>


</div>
