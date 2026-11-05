<div id="af_woo_wsr_variation_settings" clas="panel woocommerce_options_panel" >
    <div class="form-row form-row-full options">
    <h4><?php esc_html_e( 'Open Affiliates - Custom Referral Rate', 'openaffiliates' );?></h4>
    <p class="form-row form-row-full"><?php esc_html_e( 'Customize Referral Rate for this product variation. These settings will be used to calculate Referrals when this product is purchased.', 'openaffiliates');?></p>
    <p class="form-row form-row-full">
        <label><?php esc_html_e('Referral Rate Type', 'openaffiliates');?></label>
            <select name="af-woo-wsr-variable-product-type[<?php echo esc_attr($data['variantion_id']);?>]">
                <?php if ( $data['types'] ):?>
                    <?php foreach ( $data['types'] as $key => $value ):?>
                        <option value="<?php echo esc_attr($key);?>" <?php echo ( $data['af-woo-wsr-type'] == $key ) ? 'selected' : '';?> ><?php echo esc_html($value);?></option>
                    <?php endforeach;?>
                <?php endif;?>
            </select>
    </p>

    <p class="form-row form-row-full">
        <label><?php esc_html_e('Referral Rate', 'openaffiliates');?></label>
        <input type="number" step="0.01" min="0" name="af-woo-wsr-variable-product-value[<?php echo esc_attr($data['variantion_id']);?>]" value="<?php echo esc_attr($data['af-woo-wsr-value']);?>" />
    </p>
    <?php
    $offerType = get_option( 'af_referral_offer_type' );
    if ( $offerType == 'biggest' ){
    		$offerType = esc_html__( 'Biggest', 'openaffiliates' );
    } else {
    		$offerType = esc_html__( 'Lowest', 'openaffiliates' );
    }
    echo esc_html__( 'If there are multiple Amounts set for the same action, like Ranks, Offers, Product or Category rate the ', 'openaffiliates' ) . '<strong>' . $offerType . '</strong> ' . esc_html__( 'will be taken in consideration. You may change that from', 'openaffiliates' ) . ' <a href="' . admin_url( 'admin.php?page=openaffiliates&tab=settings' ) . '" target="_blank">' . esc_html__( 'here.', 'openaffiliates' ) . '</a>';
    ?>

    <p class="form-row form-row-full">
        <?php $checked = (int)($data['af-woo-excluded-variable_prod']) === 1 ? 'checked' : '';?>
        <label><?php esc_html_e('Disable Referrals', 'openaffiliates');?></label>

        <input type="checkbox" class="checkbox" onClick="afCheckAndH(this, '#af-woo-excluded-variable_prod');"  <?php echo $checked;?> />
        <input type="hidden" name="af-woo-excluded-variable_prod" value="<?php echo $data['af-woo-excluded-variable_prod'];?>" id="af-woo-excluded-variable_prod" />

    </p>
    <p class="form-field"><?php echo esc_html__( 'Enabling this option will prevent referrals from being generated for this product. This setting takes precedence over all other referral rate configurations.', 'openaffiliates' );?></p>



  </div>
</div>
