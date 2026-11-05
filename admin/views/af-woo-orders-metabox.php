<?php if ( $data['referrals'] ):?>
    <?php global $af_db;?>
    <?php foreach ( $data['referrals'] as $referralObject ):?>
        <div><?php echo esc_af_content('<b>Affiliate user: </b><a href="'.admin_url('admin.php?page=openaffiliates&tab=user_profile&affiliate_id='.$referralObject->affiliate_id).' " target="_blank">' . $af_db->get_username_by_wpuid( $af_db->get_uid_by_affiliate_id( $referralObject->affiliate_id ) ).'</a>');?></div>
        <div><?php echo esc_af_content("<b>Amount: </b>" . af_format_price_and_currency( $referralObject->currency, $referralObject->amount ));?></div>
        <div><?php echo esc_af_content("<b>Client Username: </b>" .  $af_db->get_username_by_wpuid( $referralObject->refferal_wp_uid ));?></div>
        <div><?php echo esc_af_content("<b>Description: </b>" . $referralObject->description);?></div>
        <div><?php echo esc_af_content("<b>Referral Status: </b>");
          switch ($referralObject->payment){
            case 0:
              esc_html_e('Unpaid', 'openaffiliates');
              break;
            case 1:
              esc_html_e('Pending', 'openaffiliates');
              break;
            case 2:
              esc_html_e('Complete', 'openaffiliates');
              break;
          }?>
        </div>
    <?php endforeach;?>
<?php else :?>
    <?php esc_html_e( 'No referrals for this order.', 'openaffiliates' );?>
<?php endif;?>
