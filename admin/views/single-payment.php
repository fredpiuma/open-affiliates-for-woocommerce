<div class="af-payout-setup-step-2-content">
  <div class="af-new-payout-inside">

        <div class="af-payout-setup-step-2-content">
            <h3 class="af-new-payout-wrapper-content-title"><?php esc_html_e( 'Payment Summary', 'openaffiliates');?></h3>
            <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'Overview of Payment Details: Breakdown of Referrals to Payment', 'openaffiliates');?></div>
            <table class="af-payout-summary-table">
              <tr>
                <th><?php esc_html_e( 'Affiliate', 'openaffiliates' );?></th>
                <td><?php echo $data['payment_details']['email'];?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Amount', 'openaffiliates' );?></th>
                <td><?php echo af_format_price_and_currency( afCurrency( $data['payment_details']['currency'] ), $data['payment_details']['amount']);?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Payout Method', 'openaffiliates' );?></th>
                <td><?php
                    if ( $data['payment_details']['payment_type'] === 'stripe_v3' ){
                        $data['payment_details']['payment_type'] = 'stripe';
                    }
                    echo isset( $data['payout_methods'][$data['payment_details']['payment_type']] ) ? $data['payout_methods'][$data['payment_details']['payment_type']] : $data['payment_details']['payment_type'];
                ?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Status', 'openaffiliates' );?></th>
                <td><?php
                  switch ($data['payment_details']['status']){
                    case 0:
                            esc_html_e('Failed', 'openaffiliates');
                      break;
                    case 1:
                            esc_html_e('Processing', 'openaffiliates');
                      break;
                    case 2:
                            esc_html_e('Paid', 'openaffiliates');
                      break;
                  }
                  ?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Description', 'openaffiliates' );?></th>
                <td><?php if ( $data['payment_details']['payment_details'] ){
                        $paymentDetails = json_decode( $data['payment_details']['payment_details'], true );// since version 9.1
                        if ( isset( $paymentDetails['af_affiliate_paypal_email'] )
                        && !empty( $paymentDetails['af_affiliate_paypal_email']['label'] )
                        && !empty( $paymentDetails['af_affiliate_paypal_email']['value'] ) ){
                            echo $paymentDetails['af_affiliate_paypal_email']['label'] . ' : ' . $paymentDetails['af_affiliate_paypal_email']['value'];
                        } else if ( isset( $paymentDetails['af_affiliate_bank_transfer_data'] )
                        && !empty( $paymentDetails['af_affiliate_bank_transfer_data']['label'] )
                        && !empty( $paymentDetails['af_affiliate_bank_transfer_data']['value'] ) ){
                            echo $paymentDetails['af_affiliate_bank_transfer_data']['label'] . ' : ' . $paymentDetails['af_affiliate_bank_transfer_data']['value'];
                        }
                  }?></td>
              </tr>
              <tr>
                <th><?php esc_html_e( 'Created time', 'openaffiliates' );?></th>
                <td><?php echo af_convert_date_to_us_format($data['payment_details']['create_date']);?></td>
              </tr>
            </table>

        </div>

        <div class="af-payout-setup-2-next-page">
            <select class="af-js-single-payment-new-status af-form-select af-form-element af-form-element-select af-form-select"><?php foreach ( $data['status_types'] as $type => $label ):?>
                <?php if ( (int)$data['payment_details']['status'] === (int)$type ){
                    continue;
                }?>
                <option value="<?php echo $type;?>" ><?php echo $label;?></option>
            <?php endforeach;?></select>
            <div class="af-first-button button-small af-js-payment-change-status" data-id="<?php echo $data['payment_details']['id'];?>" ><?php esc_html_e('Update Status', 'openaffiliates');?></div>
        </div>

        <?php if ( !empty($data['payment_method_details'])):?>

        <h3 class="af-new-payout-wrapper-content-title af-new-payout-wrapper-table-title"><?php echo esc_html__( 'Affiliate Payment details', 'openaffiliates' );?></h3>
        <div class="af-new-payout-wrapper-content-title-description"><?php echo esc_html__( 'Payment details submitted by affiliates for payout processing', 'openaffiliates' );?></div>
        <div class="af-new-payout-payment-details"><?php echo $data['payment_method_details'];?></div>

        <?php endif;?>

        <h3 class="af-new-payout-wrapper-content-title af-new-payout-wrapper-table-title"><?php esc_html_e( 'Referrals', 'openaffiliates');?></h3>
        <div class="af-new-payout-wrapper-content-title-description"><?php esc_html_e( 'List of Referrals for current Payment', 'openaffiliates');?></div>
        <div class="af-js-messages-for-datatable" ></div>

        <?php
        \OpenAffiliates\Admin\Datatable::Scripts( '', 'referrals_for_payment' );

        // ready for reference links
        $available_systems = af_get_active_services();
        if (!empty($available_systems['woo'])){
          $woo_order_base_link = admin_url('post.php?post=');// must add &action=edit after id
        }
        if (!empty($available_systems['ulp'])){
          $ulp_order_base_link = admin_url('post.php?post=');// must add &action=edit after id
        }
        if (!empty($available_systems['edd'])){
          $edd_order_base_link = admin_url('edit.php?post_type=download&page=edd-payment-history&view=view-order-details&id=');
        }
        if (!empty($available_systems['ump'])){
          $ump_order_base_link = admin_url('admin.php?page=ihc_manage&tab=order-edit&order_id=');
        }
        $mlm_order_base_link = admin_url('admin.php?page=openaffiliates&tab=referral_list_details&id=');
        $user_sign_up_link = admin_url('user-edit.php?user_id=');
        $urlAddEdit = admin_url('admin.php?page=openaffiliates&tab=referrals&subtab=add_edit');


        ?>
        <table class="af-js-list-payments-for-payouts af-display-none" id="af-dashboard-table">
            <thead class="" >
              <tr class="" >
                  <th class=""><?php esc_html_e('Referral ID', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Affiliate ID', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Source', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Reference', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Description', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Amount', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Created Time', 'openaffiliates');?></th>
                  <th class=""><?php esc_html_e('Status', 'openaffiliates');?></th>
              </tr>
            </thead>
            <tbody class="" >
                <?php global $af_db;?>
                <?php foreach ( $data['payment_details']['referrals'] as $referralData ):?>
                    <tr class="" onmouseover="afDhSelector('#referral_<?php echo esc_attr($referralData['id']);?>', 1);" onmouseout="afDhSelector('#referral_<?php echo esc_attr($referralData['id']);?>', 0);" >
                        <td class=""><?php echo $referralData['id'];
                        ?><div id="referral_<?php echo esc_attr($referralData['id']);?>" class="af-visibility-hidden">
<a target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=openaffiliates&tab=referrals&subtab=add_edit&id=' . $referralData['id'] ) );?>"><?php echo esc_html__('Edit', 'openaffiliates');?></a>
                        </div></td>
                        <td class=""><a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $referralData['affiliate_id'] );?>" target="_blank"><?php echo $referralData['affiliate_id'];?></a></td>
                        <td class=""><a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $referralData['affiliate_id'] );?>" target="_blank"><?php echo $referralData['affiliate_email'];?></a><div><?php
                            echo $af_db->get_full_name_of_user( $referralData['affiliate_id'] );
                        ?></div></td>
                        <td class=""><?php echo $data['sources'][$referralData['source']];?></td>
                        <td class=""><?php
                        //////////////////// Reference
                        $reference = '';
                        if (!empty($referralData['reference'])){
                          switch ($referralData['source']){
                            case 'woo':
                              if (!empty($woo_order_base_link)){
                                $link = $woo_order_base_link . $referralData['reference'] . '&action=edit';
                              }
                              $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $referralData['reference'] . '</a>');
                              break;
                            case 'ulp':
                              if (!empty($ulp_order_base_link)){
                                $link = $ulp_order_base_link . $dataObject->reference . '&action=edit';
                              }
                              $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $referralData['reference'] . '</a>');
                              break;
                            case 'edd':
                              if (!empty($edd_order_base_link)){
                                $link = $edd_order_base_link . $referralData['reference'];
                              }
                              $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $referralData['reference'] . '</a>');
                              break;
                            case 'ump':
                              $link = $ump_order_base_link . $referralData['reference'];
                              $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $referralData['reference'] . '</a>');
                              break;
                            case 'mlm':
                              $the_ref = $referralData['reference'];
                              $the_ref = str_replace('mlm_', '', $the_ref);
                              $link = $mlm_order_base_link . $the_ref;
                              $reference = esc_html__('Referral', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $the_ref . '</a>');
                              break;
                            case 'User SignUp':
                              if (!empty($referralData['reference']) && strpos($referralData['reference'], 'user_id_')!==FALSE){
                                $uid_sign_up = str_replace('user_id_', '', $referralData['reference'] );
                                $link = $user_sign_up_link . $uid_sign_up;
                                $reference = esc_html__('User ID', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $uid_sign_up . '</a>');
                              }
                              break;
                            default:
                              $link = apply_filters( 'af_admin_dashboard_custom_referrence_link', '', $referralData );
                              if(!empty($link)){
                                $reference = esc_af_content('<a href="' . $link . '" target="_blank">' . $referralData['reference'] . '</a>');
                              }

                              break;
                          }
                        }
                        echo $reference;
                        //////////////////// End of Reference
                        ?></td>
                        <td class=""><?php echo $referralData['description'];?></td>
                        <td class=""><?php echo af_format_price_and_currency( afCurrency( $referralData['currency'] ), $referralData['amount']);?></td>
                        <td class=""><?php echo af_convert_date_to_us_format($referralData['date']);?></td>
                        <td class=""><?php
                          switch ( $referralData['payment'] ){
                              case 0:
                                ?>
                                    <div class="referral-status-refuse af-status af-status-failed"><?php echo $data['status_types'][$referralData['payment']];?></div>
                                <?php
                                break;
                              case 1:
                                ?>
                                    <div class="referral-status-unverified af-status af-status-inactive"><?php echo $data['status_types'][$referralData['payment']];?></div>
                                <?php
                                break;
                              case 2:
                                ?>
                                    <div class="referral-status-verified af-status af-status-active"><?php echo $data['status_types'][$referralData['payment']];?></div>
                                <?php
                                break;
                          }
                        ?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>"></div>


    </div>

</div>
