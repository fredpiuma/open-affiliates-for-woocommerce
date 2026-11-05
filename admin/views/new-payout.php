<div class="af-new-payout-wrapper">
<?php if ( $data['step'] === 1 ) :?>
<!-- Step 1. -->
<div class="af-payout-setup-step-1">
 <div class="af-new-payout-inside">
    <div class="af-payout-setup-step-1-content">

        <form method="post" action="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=new_payout&step=2' );?>">

          <div class="af-payout-setup-section af-payout-setup-1-select-referrals" >
            <h3 class="af-new-payout-wrapper-content-title"><span>01</span> - <?php esc_html_e( 'Select Referrals', 'openaffiliates');?></h3>
            <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'Select which unpaid referrals you wish to include in this bulk payout.', 'openaffiliates');?></div>

              <div class="af-payout-setup-1-select-referrals-content af-new-payout-wrapper-content-box-row" >
                  <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-referrals">
                    <div class="af-new-payout-wrapper-content-item">
                      <input type="radio" name="select_referrals" value="older_than" checked />
                      <div class="af-new-payout-wrapper-content-item-label">
                      <?php echo esc_html__( 'All Unpaid Referrals older than ', 'openaffiliates') . $data['older_than_label'];?>
                      <span><?php
                          echo esc_html__( 'Total amount of ', 'openaffiliates');
                          if ( isset( $data['reports_data_custom_time']['total_payment'])){
                              echo af_format_price_and_currency( $data['currency_label'], $data['reports_data_custom_time']['total_payment'] );
                          }
                      ?></span>
                      </div>
                    </div>
                  </div>

                  <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-referrals">
                    <div class="af-new-payout-wrapper-content-item">
                      <input type="radio" name="select_referrals" value="all"  />
                      <div class="af-new-payout-wrapper-content-item-label">
                      <?php esc_html_e( 'All Unpaid Referrals', 'openaffiliates');?>
                      <span><?php
                          echo esc_html__( 'Total amount of ', 'openaffiliates');
                          if ( isset( $data['reports_data_all_time']['total_payment'])){
                              echo af_format_price_and_currency( $data['currency_label'], $data['reports_data_all_time']['total_payment'] );
                          }
                      ?></span>
                     </div>
                    </div>
                  </div>

                  <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-referrals">
                    <div class="af-new-payout-wrapper-content-item">
                      <input type="radio" name="select_referrals" value="custom_range" />
                      <div class="af-new-payout-wrapper-content-item-label">
                        <?php esc_html_e( 'Unpaid Referrals in custom Range', 'openaffiliates');?>
                        <span><?php esc_html_e( 'Filter Referrals by date range', 'openaffiliates');?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="af-new-payout-wrapper-content-box-row">
                  <div class="af-js-payout-setup-updaid-referrals-custom-range af-new-payout-wrapper-content-extra-box af-new-payout-wrapper-content-extra-box-referrals af-display-none">
                      <h4><?php esc_html_e('Custom Date Range', 'openaffiliates');?></h4>
                      <p><?php esc_html_e('Choose a predefined date range or specify one', 'openaffiliates');?></p>
                      <select name="custom_range_value" class="af-js-payout-setup-select-custom-range-value af-form-select af-form-element af-form-element-select af-form-select" >
                        <?php foreach ( $data['custom_range_values'] as $customRangeKey => $customRangeValue):?>
                            <option value="<?php echo $customRangeKey;?>" ><?php echo $customRangeValue;?></option>
                        <?php endforeach;?>
                      </select>
                      <div class="af-js-payout-setup-date-pickers af-display-none">
                          <h5><?php esc_html_e( 'Starting Date', 'openaffiliates');?></h5>
                          <input type="text" name="referrals_start_time" value="" class="af-js-payout-setup-referrals-custom-range-start form-control " />
                          <h5><?php esc_html_e( 'Ending Date', 'openaffiliates');?></h5>
                          <input type="text" name="referrals_end_time" value="" class="af-js-payout-setup-referrals-custom-range-end form-control " />
                      </div>
                  </div>
                  <input type="hidden" name="older_than" value="<?php echo $data['older_than'];?>" />
              </div>
          </div>

          <div class="af-payout-setup-section af-payout-setup-1-select-affiliates">
              <h3 class="af-new-payout-wrapper-content-title"><span>02</span> - <?php esc_html_e( 'Select Affiliates', 'openaffiliates');?></h3>
              <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'Choose which affiliates you would like to include in this bulk payout.', 'openaffiliates');?></div>
              <div class="af-payout-setup-1-select-affiliates-content af-new-payout-wrapper-content-box-row">

                <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-affiliates">
                  <div class="af-new-payout-wrapper-content-item">
                    <input type="radio" name="select_affiliates" value="all" checked />
                    <div class="af-new-payout-wrapper-content-item-label">
                      <?php esc_html_e( 'All Eligible Affiliates', 'openaffiliates');?>
                      <span><?php esc_html_e( 'With Unpaid Referrals', 'openaffiliates');?></span>
                    </div>
                  </div>
                </div>
                  <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-affiliates">
                    <div class="af-new-payout-wrapper-content-item">
                      <input type="radio" name="select_affiliates" value="selected_affiliates" />
                      <div class="af-new-payout-wrapper-content-item-label">
                        <?php esc_html_e( 'Only Selected Affiliates', 'openaffiliates');?>
                        <span><?php esc_html_e( 'Chosen Manually', 'openaffiliates');?></span>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="af-new-payout-wrapper-content-box-row">
                  <div class="af-js-select-specific-affiliates af-new-payout-wrapper-content-extra-box af-display-none">
                      <h4><?php esc_html_e('Select an Affiliate', 'openaffiliates');?></h4>
                      <div class="input-group">
                        <span class="input-group-addon" ><?php esc_html_e('Username', 'openaffiliates');?></span>
                        <input type="text"  class="form-control af-js-payout-setup-search-for-affiliates" id="usernames_search" />
                      </div>
                      <input type="hidden" value="" name="affiliates_list" id="usernames_search_hidden" />
                      <div id="af_username_search_tags"></div>
                  </div>
              </div>
          </div>

          <div class="af-payout-setup-section af-payout-setup-1-minimum-amount">
            <h3 class="af-new-payout-wrapper-content-title"><span>03</span> - <?php esc_html_e( 'Establish Minimum Amount', 'openaffiliates');?></h3>
            <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'This figure is employed to avoid disbursing negligible sums to affiliates.', 'openaffiliates');?></div>
              <div class="af-payout-setup-1-minimum-amount-content" >
                <div class="af-new-payout-wrapper-content-box-row">
                  <div class="af-new-payout-wrapper-content-extra-box">
                    <input type="number" min="0" step="0.01" value="<?php echo $data['minimum_amount'];?>" name="minimum_amount"  class="form-control "/>
                  </div>
                </div>
              </div>
          </div>

          <div class="af-payout-setup-section af-payout-setup-1-select-payment-method">
            <h3 class="af-new-payout-wrapper-content-title"><span>04</span> - <?php esc_html_e( 'Choose Payout Method', 'openaffiliates');?></h3>
            <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'Choose the payment method you prefer to use for this payout.', 'openaffiliates');?></div>

              <div class="af-payout-setup-1-select-payment-content  af-new-payout-wrapper-content-box-row">

                  <?php foreach ( $data['payout_methods'] as $paymentMethodValue => $paymentMethodDetails ):?>
                      <?php $class = $paymentMethodDetails['is_active'] ? '' : 'af-new-payout-wrapper-content-box-disabled';?>
                      <div class="af-new-payout-wrapper-content-box af-new-payout-wrapper-content-box-methods <?php echo $class;?>">
                        <div class="af-new-payout-wrapper-content-item">
                          <?php $checked = ( $data['default_payout_method'] === $paymentMethodValue ) ? 'checked' : '';?>
                          <input type="radio" name="payout_method" value="<?php echo $paymentMethodValue;?>" <?php if ( $paymentMethodDetails['is_active'] === false ){ echo 'disabled';}?> <?php echo $checked;?> />
                          <div class="af-new-payout-wrapper-content-item-label">
                            <?php echo $paymentMethodDetails['label'];?>
                            <span><?php echo $paymentMethodDetails['details'];?></span>
                          </div>
                        </div>
                      </div>
                  <?php endforeach;?>

              </div>
          </div>

          <div class="af-payout-setup-1-next-page">
              <input type="submit" name="af_payout_setup_next" class="af-first-button button" value="<?php esc_html_e( 'Preview Payout', 'openaffiliates' );?>" />
              <input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />
          </div>

        </form>

    </div>
</div>
</div>
<!-- end of Step 1. -->

<?php elseif ( $data['step'] === 2 && isset( $data['payout_data'] ) ) :?>
<!-- Step 2. -->
<?php

\OpenAffiliates\Admin\Datatable::Scripts( '', 'payout_setup' );
?>
<div class="af-payout-setup-step-2-content">
  <div class="af-new-payout-inside">
        <?php if ( is_array( $data['payout_data'] ) && count( $data['payout_data'] ) > 0 ):?>
          <form method="post" action="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=manage_payouts' );?>" >

        <div class="af-payout-setup-step-2-content">
            <h3 class="af-new-payout-wrapper-content-title"><?php esc_html_e( 'Payout Summary', 'openaffiliates');?></h3>
            <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'Overview of Payout Details: Breakdown of Payments to Affiliates', 'openaffiliates');?></div>
            <table class="af-payout-summary-table">
              <tr>
                <th><?php esc_html_e( 'Payout Method', 'openaffiliates' );?></th>
                <td><?php echo $data['selected_payout_method_label'];?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Date Range', 'openaffiliates' );?></th>
                <td><?php
                          if ( isset( $data['date_range'] ) ){
                              echo $data['date_range'];
                          }
                ?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Affiliates', 'openaffiliates' );?></th>
                <td><?php echo $data['payout_data']['count_affiliates'];?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Referrals', 'openaffiliates' );?></th>
                <td><?php echo $data['payout_data']['count_all_referrals'];?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Payments', 'openaffiliates' );?></th>
                <td><?php echo $data['payout_data']['count_affiliates'];?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Total Amount to Pay', 'openaffiliates' );?></th>
                <td><?php echo af_format_price_and_currency( $data['currency_label'], $data['payout_data']['total_payment'] );?></td>
              </tr>
            </table>

        </div>
        <div class="af-payout-setup-2-next-page">
            <input type="submit" name="af_payout_setup_submit" class="af-first-button button" value="<?php esc_html_e( 'Create Payout', 'openaffiliates' );?>" />
            <input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

            <input type="hidden" name="currency" value="<?php echo $data['currency'];?>" />
            <input type="hidden" name="start_time" value="<?php echo $data['start_time'];?>" />
            <input type="hidden" name="end_time" value="<?php echo $data['end_time'];?>" />
            <input type="hidden" name="payout_method" value="<?php echo $data['selected_payout_method'];?>" />
            <input type="hidden" name="select_referrals_time" value="<?php echo $data['select_referrals_time'];?>" />

            <input type="hidden" name="payout_data" value='<?php echo json_encode( $data['payout_data'] );?>' />

        </div>
        <h3 class="af-new-payout-wrapper-content-title af-new-payout-wrapper-table-title"><?php esc_html_e( 'Payments to Affiliates', 'openaffiliates');?></h3>
        <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'List of Payments proceed through current Payout', 'openaffiliates');?></div>
              <div class="af-js-messages-for-datatable" ></div>


              <table class="af-js-list-payments-for-payouts af-display-none" id="af-dashboard-table">
                  <thead class="" >
                    <tr class="" >
                        <th class=""><?php esc_html_e('Affiliate Email');?></th>
                        <th class=""><?php esc_html_e('Affiliate Name');?></th>
                        <th class=""><?php esc_html_e('Amount');?></th>
                        <th class=""><?php esc_html_e('Payout Method');?></th>
                        <th class=""><?php esc_html_e('Referrals');?></th>
                        <th class=""><?php esc_html_e('Payment Details');?></th>
                    </tr>
                  </thead>
                  <tbody class="" >
                      <?php foreach ( $data['payout_data']['data_per_affiliate'] as $affiliateData ):?>
                          <tr class="">
                              <td class=""><a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $affiliateData['affiliate_id']);?>" target="_blank"><?php echo $affiliateData['email'];?></a></td>
                              <td class=""><?php echo $affiliateData['name'];?></td>
                              <td class=""><?php echo isset( $affiliateData['sum'] ) ? af_format_price_and_currency( $data['currency_label'], $affiliateData['sum'] ) : af_format_price_and_currency( $data['currency_label'], 0);?></td>
                              <td class=""><?php
                                  if ( $affiliateData['payout_method'] === 'stripe_v3' ){
                                      $affiliateData['payout_method'] = 'stripe';
                                  }
                                  echo isset( $data['payout_methods'][$affiliateData['payout_method']]['label'] ) ? $data['payout_methods'][$affiliateData['payout_method']]['label'] : $affiliateData['payout_method'];
                              ?></td>
                              <td class=""><?php echo $affiliateData['count_referrals'];?></td>
                              <td class=""><?php echo $affiliateData['payout_details'];?></td>
                          </tr>
                      <?php endforeach;?>
                  </tbody>
              </table>



          </form>
        <?php else :?>
            <div class=""><?php echo esc_html__('No entries for selected Filters.', 'openaffiliates');?></div>
        <?php endif;?>
    </div>

</div>
<!-- end of Step 2. -->
<?php else :?>
    <?php esc_html_e( "It seems like you've landed on the wrong page or entered an incorrect URL. Please double-check the web address and make sure it corresponds to the payout section.", 'openaffiliates');?>
<?php endif;?>
</div>
