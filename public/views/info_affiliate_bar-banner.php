<div class="af_info_bar_banner_wrapp"><?php echo esc_af_content($data['banner']);?></div>
<div class="af-info-bar-banner-size">
  <div class="af-ap-label af-special-label">
    <?php echo esc_html__('Banner Size', 'openaffiliates'); ?>
  </div>
  <select id="af_iab_banner_select_size" onChange="" class="af-public-form-control ">
      <option value="thumbnail"><?php echo esc_html__('Small', 'openaffiliates'); ?></option>
      <option value="medium"><?php echo esc_html__('Medium', 'openaffiliates'); ?></option>
      <option value="large"><?php echo esc_html__('Large', 'openaffiliates'); ?></option>
  </select>
</div>
<textarea id="af_info_bar_banner_the_value" readonly class="af-account-url" onclick="this.select()" onfocus="this.select()"><?php echo esc_af_content($data['banner']);?></textarea>
<div id="af_info_affiliate_bar_extra_info" data-affiliate_id="<?php echo isset( $data['affiliate_id'] ) ? $data['affiliate_id'] : '';?>" data-affiliate_id="<?php echo isset( $data['uid'] ) ? $data['uid'] : '';?>"></div>
