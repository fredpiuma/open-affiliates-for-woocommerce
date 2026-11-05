<div class="form-row form-row-full options">

    <h2><?php esc_html_e( 'Open Affiliates - Static Coupon', 'openaffiliates' );?></h2>
    <p><?php esc_html_e( 'Link the Coupon to an Affiliate user. Every time this coupon is redeemed, followed by a complete purchase, the Affiliate user will be rewarded with a Referral.', 'openaffiliates' );?></p>
    <p class="form-field">
        <label><?php esc_html_e( 'Target Affiliate Username: ', 'openaffiliates' );?></label>
        <input class="short" type="text" name="af_affiliate_username" value="<?php echo isset( $data['af_affiliate_username'] ) ? $data['af_affiliate_username'] : '';?>" />
    </p>

    <p class="form-field">
        <label><?php esc_html_e('Referral Rate Type', 'openaffiliates');?></label>
          <select name="af_amount_type" class="select short">
              <?php if ( $data['types'] ):?>
                  <?php foreach ( $data['types'] as $key => $value ):?>
                      <option value="<?php echo esc_attr($key);?>" <?php echo ( $data['af_amount_type'] == $key ) ? 'selected' : '';?> ><?php echo esc_html($value);?></option>
                  <?php endforeach;?>
              <?php endif;?>
          </select>
    </p>

    <p class="form-field">
        <label><?php esc_html_e('Referral Rate', 'openaffiliates');?></label>
        <input type="number" step="0.01" min="0" class="short" name="af_amount_value" value="<?php echo esc_attr( $data['af_amount_value']);?>" />
    </p>

    <p class="form-field">
        <label><?php esc_html_e('Status', 'openaffiliates');?></label>
        <select name="af_status" class="select short">
            <option value="0" <?php echo ($data['af_status'] == 0 ) ? 'selected' : '';?> ><?php esc_html_e( 'Off', 'openaffiliates' );?></option>
            <option value="1" <?php echo ($data['af_status'] == 1 ) ? 'selected' : '';?> ><?php esc_html_e( 'On', 'openaffiliates' );?></option>
        </select>
    </p>

    <input type="hidden" name="af_static_coupon_id" value="<?php echo esc_attr($data['id']);?>" />

</div>
