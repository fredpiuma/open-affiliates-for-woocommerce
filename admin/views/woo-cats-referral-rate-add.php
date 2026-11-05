<div id="af_woo_cats"  >
    <h3><?php esc_html_e( 'Open Affiliates - Custom Referral Rate', 'openaffiliates');?></h3>
    <p class="form-field">
        <label><?php esc_html_e('Referral Rate Type', 'openaffiliates');?></label>
          <select name="af_referral_type" class="select short">
              <?php if ( $data['types'] ):?>
                  <?php foreach ( $data['types'] as $key => $value ):?>
                      <option value="<?php echo esc_attr($key);?>" <?php echo ( $data['af_referral_type'] == $key ) ? 'selected' : '';?> ><?php echo esc_html($value);?></option>
                  <?php endforeach;?>
              <?php endif;?>
          </select>
    </p>
    <p class="form-field">
        <label><?php esc_html_e('Referral Rate', 'openaffiliates');?></label>
        <input type="number" step="0.01" min="0" class="short" name="af_referral_value" value="<?php echo esc_attr($data['af_referral_value']);?>" />
    </p>
    <p class="form-field">
    <?php
    $offerType = get_option( 'af_referral_offer_type' );
    if ( $offerType == 'biggest' ){
    		$offerType = esc_html__( 'Biggest', 'openaffiliates' );
    } else {
    		$offerType = esc_html__( 'Lowest', 'openaffiliates' );
    }
    echo esc_html__( 'If there are multiple Amounts set for the same action, like Ranks, Offers, Product or Category rate the ', 'openaffiliates' ) . '<strong>' . $offerType . '</strong> ' . esc_html__( 'will be taken in consideration. You may change that from', 'openaffiliates' ) . ' <a href="' . admin_url( 'admin.php?page=openaffiliates&tab=settings' ) . '" target="_blank">' . esc_html__( 'here.', 'openaffiliates' ) . '</a>';
    ?>
    </p>
    <p class="form-field">
        <?php $checked = (int)($data['af_excluded']) === 1 ? 'checked' : '';?>
        <label><?php esc_html_e( 'Disable Referrals for Category', 'openaffiliates');?></label>
        <input type="checkbox" class="checkbox" onClick="afCheckAndH(this, '#af_excluded');"  <?php echo $checked;?> />
        <input type="hidden" name="af_excluded" value="<?php echo $data['af_excluded'];?>" id="af_excluded" />
    </p>
    <p class="form-field">
          <?php
          echo esc_html__( 'Enabling this option will prevent referrals from being generated for any products within this category. This setting supersedes all other referral rate configurations.', 'openaffiliates' );
          ?>
    </p>
</div>
