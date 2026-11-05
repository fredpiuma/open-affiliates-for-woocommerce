<div class="af-wrapper af-affiliate-userprofile">
    <div class="af-stuffbox">
        <div class="af-h3"><?php esc_html_e( 'Affiliate Profile', 'openaffiliates' );?></div>
        <div class="inside">
            <?php if ( empty($data) ):?>
                <h4><?php esc_html_e( 'No details for this Affiliate user.', 'openaffiliates' );?></h4>
            <?php else:?>
				<div class="row">
                	<div class="col-xs-12">
                    	<div class="af-userprofile-mainname-wrapper">
                          <div class="row">
                           <div class="col-xs-1">
                           <?php if ( $data['ranking_possition'] > -1 ):?>
                           		<div class="af-userprofile-top-wrapper">
                                		<img src="<?php echo AF_URL;?>assets/images/af_trophy.png" alt="<?php echo esc_attr($data['ranking_possition']);?>"/>
                                        <div class="af-userprofile-top-position">
                                        	#<?php echo esc_html($data['ranking_possition']);?>
                                        </div>
                                        <div class="af-userprofile-top-details">
                                        <?php esc_html_e( "based on performance", 'openaffiliates' );?>
                                        </div>
                                </div>
                            <?php endif;?>
                           </div>
                            <div class="col-xs-5">
                        	<div class="af-userprofile-mainname">
                        	 <?php if ( !empty( $data['user_meta']['first_name']) && !empty( $data['user_meta']['last_name'] ) ):?>
                   				 <?php echo esc_html($data['user_meta']['first_name'].' '.$data['user_meta']['last_name']).' ('.esc_html($data['user_meta']['nickname']).')';?>
               				 <?php endif;?>
                       		</div>
                            <div class="af-userprofile-links">
                            	<span class="af-userprofile-links-label"><?php esc_html_e( "Affiliate Link", 'openaffiliates' );?>: </span><a href="<?php echo esc_url($data['affiliate_link']);?>" target="_blank"><?php echo esc_html($data['affiliate_link']);?></a> <span class="js-af-copy af-userprofile-copyclipboard"><?php esc_html_e( 'Copy to Clipboard', 'openaffiliates' );?></span> <div class="div-notice"><?php esc_html_e( '(for testing purpose use the affiliate link into a fresh incognito browser window)', 'openaffiliates' );?></div>
                            </div>
                            <div class="af-userprofile-links">
                            	<span class="af-userprofile-links-label"><?php esc_html_e( "Affiliate ID", 'openaffiliates' );?>: </span><?php echo esc_html($data['affiliate_id']); ?>
                            </div>
                            <?php if ( $data['custom_slug'] ):?>
                                <div class="af-userprofile-links">
                                	<span class="af-userprofile-links-label"><?php esc_html_e( "Custom Slug", 'openaffiliates' );?>: </span><?php echo esc_html($data['custom_slug']);?>
                                </div>
                            <?php endif;?>

                           </div>
                           <div class="col-xs-6">
                           	<div class="row af-userprofile-rank-row">
                            	<div class="col-xs-5">
                                	<div class="af-userprofile-rank af-currentrank">
                                    	<div class="af-userprofile-rank-title"><?php echo isset( $data['current_rank_data']['label'] ) ? esc_html($data['current_rank_data']['label']) : '';?>
                                        <?php if ( isset( $data['current_rank_data']['amount_type'] ) ):?>
                                         <div class="af-userprofile-rank-reward">(<?php if ( $data['current_rank_data']['amount_type'] == 'percentage' ){
                                           echo esc_html($data['current_rank_data']['amount_value'].'%');
                                         }else{
                                           echo af_format_price_and_currency($data['currency'], $data['current_rank_data']['amount_value']);
                                         } ?>
											  <?php esc_html_e( 'reward', 'openaffiliates' );?>)</div>
                                        <?php endif;?>
                                              </div>
                                        <ul>
                                            <?php if ( $data['bonus_enabled'] && !empty( $data['current_rank_data']['bonus'] ) ):?>
                                                <li><?php esc_html_e( 'Achievement Bonus', 'openaffiliates' );?>: <?php echo af_format_price_and_currency($data['currency'], $data['current_rank_data']['bonus']);?></li>
                                            <?php endif;?>

                                            <?php if ( $data['sign_up_enabled'] ):?>

                                                <?php if ( empty( $data['current_rank_data']['sign_up_amount_value'] ) || $data['current_rank_data']['sign_up_amount_value'] < 0 ):?>
                                                    <li><?php esc_html_e( 'SignUp Referrals', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['default_sign_up_referrals'] ) . esc_html__( '(default value)', 'openaffiliates');?></li>
                                                <?php else : ?>
                                                    <li><?php esc_html_e( 'SignUp Referrals', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['sign_up_amount_value'] );?></li>
                                                <?php endif;?>

                                            <?php endif;?>

                                            <?php if ( $data['lifetime_commission'] ):?>
                                                <li>

                                                    <?php esc_html_e( 'LifeTime Comission', 'openaffiliates' );?>:
                                                    <?php if ( !empty( $data['current_rank_data']['lifetime_amount_value'] ) && $data['current_rank_data']['lifetime_amount_value'] > -1.00 ):?>
                                                        <?php if ( $data['current_rank_data']['lifetime_amount_type'] == 'percentage' ):?>
                                                            <?php echo esc_html($data['current_rank_data']['lifetime_amount_value']);?>%
                                                        <?php else :?>
                                                            <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['lifetime_amount_value'] );?>
                                                        <?php endif;?>
                                                    <?php else :?>
                                                      <?php if ( isset( $data['current_rank_data']['amount_type'] ) ):?>
                                                      <?php if ( $data['current_rank_data']['amount_type'] == 'percentage' ):?>
                                                          <?php echo esc_html($data['current_rank_data']['amount_value']);?>%
                                                      <?php else :?>
                                                          <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['amount_value'] );?>
                                                      <?php endif;?>
                                                      <?php endif;?>
                                                      <?php esc_html_e( '(Rank amount)', 'openaffiliates' );?>
                                                    <?php endif;?>

                                                </li>
                                            <?php endif;?>

                                            <?php if ( $data['reccuring_referrals'] ):?>
                                                <li>

                                                    <?php esc_html_e( 'Reccurring Referrals', 'openaffiliates' );?>:
                                                    <?php if ( !empty( $data['current_rank_data']['reccuring_amount_value'] ) && $data['current_rank_data']['reccuring_amount_value'] > -1.00 ):?>
                                                        <?php if ( $data['current_rank_data']['reccuring_amount_type'] == 'percentage' ):?>
                                                            <?php echo esc_html($data['current_rank_data']['reccuring_amount_value']);?>%
                                                        <?php else :?>
                                                            <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['reccuring_amount_value'] );?>
                                                    <?php endif;?>

                                                    <?php else :?>
                                                        <?php if ( isset( $data['current_rank_data']['amount_type'] ) ):?>
                                                          <?php if ( $data['current_rank_data']['amount_type'] == 'percentage' ):?>
                                                              <?php echo esc_html($data['current_rank_data']['amount_value']);?>%
                                                          <?php else :?>
                                                              <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['amount_value'] );?>
                                                          <?php endif;?>
                                                          <?php esc_html_e( '(Rank amount)', 'openaffiliates' );?>
                                                        <?php endif;?>
                                                    <?php endif;?>

                                                </li>
                                            <?php endif;?>

                                            <?php if ( $data['pay_per_click'] && !empty( $data['current_rank_data']['pay_per_click'] ) && $data['current_rank_data']['pay_per_click'] > -1.00 ):?>
                                                <li><?php esc_html_e( 'PPC Amount', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['pay_per_click'] );?></li>
                                            <?php endif;?>

                                            <?php if ( $data['cpm_commission'] && !empty( $data['current_rank_data']['cpm_commission'] ) && $data['current_rank_data']['cpm_commission'] > -1.00 ):?>
                                                <li><?php esc_html_e( 'CPM Amount', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['current_rank_data']['cpm_commission'] );?></li>
                                            <?php endif;?>

                                        </ul>
                                    </div>
                                </div>

                                <?php if ( $data['next_rank_data'] ):?>

                                <div class="af-achievenextrank">
                                        	<?php esc_html_e( 'Next Rank', 'openaffiliates' );?>
                                            <div class="af-achievement-condition">
                                            <div><?php esc_html_e('Achievement condition', 'openaffiliates');?></div>
                                            <?php
                                            $achieve_types= array(-1=>'...', 'referrals_number'=>'Number of Referrals', 'total_amount'=>'Total Amount');
;                                           $achieve = json_decode( $data['next_rank_data']['achieve'], TRUE);
                                            if ($achieve):
                                            for ($i=1; $i<=$achieve['i']; $i++):?>
                                              <div class="af-admin-listing-ranks-achieve">
                                                <div><strong><?php echo esc_html($achieve_types[$achieve['type_' . $i]]);?></strong></div>
                                                <div><?php echo esc_html__('From: ', 'openaffiliates');
                                                  if ($achieve['type_' . $i]=='total_amount'){
                                                    echo af_format_price_and_currency( $data['currency'], $achieve['value_' . $i] );
                                                  } else {
                                                      echo esc_html($achieve['value_' . $i]) . '';
                                                  }
                                                  ?></div>
                                              </div>
                                            <?php
                                              endfor;
                                            else:
                                              ?>
                                              <div class="af-admin-listing-ranks-achieve">
                                                <?php esc_html_e('None', 'openaffiliates');?>
                                              </div>
                                              <?php
                                            endif;
                                            ?>
                                          </div>
                                        </div>
                                <div class="col-xs-2">

                                </div>
                                <div class="col-xs-5">
                                    <div class="af-userprofile-rank af-nextrank">
                                    	<div class="af-userprofile-rank-title"><?php echo esc_html($data['next_rank_data']['label']);?>
                                        <div class="af-userprofile-rank-reward">(<?php if ( $data['next_rank_data']['amount_type'] == 'percentage' ){
                                          echo esc_html($data['next_rank_data']['amount_value'].'%');
                                        }else{
                                          echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['amount_value'] );
                                        }?>
											  <?php esc_html_e( 'reward', 'openaffiliates' );?>)</div>
                                        </div>
                                        <ul>

                                          <?php if ( $data['bonus_enabled'] && !empty( $data['next_rank_data']['bonus'] ) ):?>
                                              <li><?php esc_html_e( 'Achievement Bonus', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['bonus'] );?></li>
                                          <?php endif;?>

                                          <?php if ( $data['sign_up_enabled'] ):?>
                                              <?php if ( !empty( $data['next_rank_data']['sign_up_amount_value'] ) && $data['next_rank_data']['sign_up_amount_value'] > -1.00 ):?>
                                                  <li><?php esc_html_e( 'SignUp Referrals', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['sign_up_amount_value'] );?></li>
                                              <?php else :?>
                                                  <li><?php esc_html_e( 'SignUp Referrals', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['amount_value'] );?></li>
                                              <?php endif;?>
                                          <?php endif;?>

                                          <?php if ( $data['lifetime_commission'] ):?>
                                              <li>

                                                  <?php esc_html_e( 'LifeTime Comission', 'openaffiliates' );?>:
                                                  <?php if ( !empty( $data['next_rank_data']['lifetime_amount_value'] ) && $data['next_rank_data']['lifetime_amount_value'] > -1.00 ):?>
                                                      <?php if ( $data['next_rank_data']['lifetime_amount_type'] == 'percentage' ):?>
                                                          <?php echo esc_html($data['next_rank_data']['lifetime_amount_value']);?>%
                                                      <?php else :?>
                                                          <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['lifetime_amount_value'] );?>
                                                      <?php endif;?>
                                                  <?php else :?>
                                                      <?php if ( $data['next_rank_data']['amount_type'] == 'percentage' ):?>
                                                          <?php echo esc_html($data['next_rank_data']['amount_value']);?>%
                                                      <?php else :?>
                                                          <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['amount_value'] );?>
                                                      <?php endif;?>
                                                      <?php esc_html_e( '(Rank amount)', 'openaffiliates' );?>
                                                  <?php endif;?>

                                              </li>
                                          <?php endif;?>

                                          <?php if ( $data['reccuring_referrals'] ):?>
                                              <li>
                                                  <?php esc_html_e( 'Reccurring Referrals', 'openaffiliates' );?>:
                                                  <?php if ( !empty( $data['next_rank_data']['reccuring_amount_value'] ) && $data['current_rank_data']['reccuring_amount_value'] > -1.00 ):?>
                                                      <?php if ( $data['next_rank_data']['reccuring_amount_type'] == 'percentage' ):?>
                                                          <?php echo esc_html($data['next_rank_data']['reccuring_amount_value']);?>%
                                                      <?php else :?>
                                                          <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['reccuring_amount_value'] );?>
                                                      <?php endif;?>
                                                  <?php else :?>
                                                      <?php if ( $data['next_rank_data']['amount_type'] == 'percentage' ):?>
                                                          <?php echo esc_html($data['next_rank_data']['amount_value']);?>%
                                                      <?php else :?>
                                                          <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['amount_value'] );?>
                                                      <?php endif;?>
                                                      <?php esc_html_e( '(Rank amount)', 'openaffiliates' );?>
                                                  <?php endif;?>
                                              </li>
                                          <?php endif;?>

                                          <?php if ( $data['pay_per_click'] && !empty( $data['next_rank_data']['pay_per_click'] ) && $data['next_rank_data']['pay_per_click'] > -1.00 ):?>
                                              <li><?php esc_html_e( 'PPC Amount', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['pay_per_click'] );?></li>
                                          <?php endif;?>

                                          <?php if ( $data['cpm_commission'] && !empty( $data['next_rank_data']['cpm_commission'] ) && $data['next_rank_data']['cpm_commission'] > -1.00 ):?>
                                              <li><?php esc_html_e( 'CPM Amount', 'openaffiliates' );?>: <?php echo af_format_price_and_currency( $data['currency'], $data['next_rank_data']['cpm_commission'] );?></li>
                                          <?php endif;?>


                                        </ul>
                                    </div>

                                </div>
                                <?php endif;?>

                            </div>
                           </div>
                         </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-7">
                    	<div class="af-userprofile-profiledetails">
                        	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Profile details', 'openaffiliates' );?></div>
                            <div class="row">
                            <div class="col-xs-4">
                                  <div class="af-userprofile-avatar">
                                  <?php if ( !empty( $data['avatar'] ) ):?>
                                      <img src="<?php echo esc_url($data['avatar']);?>" class="af-avatar" alt="<?php echo esc_attr($data['user_name']);?>" />
                                  <?php endif;?>
                                  </div>
                                  <div class="af-userprofile-buttons">
                                      <div class="af-userprofile-button">
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=openaffiliates&tab=affiliates&subtab=add_edit').'&id=' . $data['uid']);?>" target="_blank" class="button button-primary button-large">
                <?php esc_html_e( 'Edit Affiliate Profile', 'openaffiliates' );?></a>
                                      </div>
                                      <div class="af-userprofile-button">
                                        <a href="<?php echo esc_url($data['public_profile_preview']);?>" target="_blank" class="button button-primary button-large">
                <?php esc_html_e( 'Access Affiliate Portal', 'openaffiliates' );?></a>
                                      </div>
                                  </div>
                            </div>
                            <div class="col-xs-8">
                        	<table class="form-table">
                            	<tbody>
                                	<tr class="form-field">
                                    	<th><?php esc_html_e( 'Username', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['user_name']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'Email', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['user_email']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'First Name', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['user_meta']['first_name']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'Last Name', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['user_meta']['last_name']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'WP Role', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['role']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'Member Since', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['member_since']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'Nickname', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['user_meta']['nickname']);?></td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th><?php esc_html_e( 'Biographical Info', 'openaffiliates' );?>:</th>
                                        <td> <?php echo esc_html($data['description']);?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                    	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Overall Perfromance', 'openaffiliates' );?></div>
                         <div class="af-userprofile-stats">
                         		<table class="form-table">
                            	<tbody>
                                	<tr class="form-field">
                                    	<th>
                                        	<div><?php esc_html_e( 'Referrals', 'openaffiliates' );?></div>
                                          <?php $totalAmount = $data['referrals_stats']['verified_referrals_amount'] + $data['referrals_stats']['unverified_referrals_amount'];?>
                                          <?php $totalReferrals = $data['referrals_stats']['verified_referrals'] + $data['referrals_stats']['unverified_referrals'];?>
                                        	<div> <a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=referrals&affiliate_id=' . $data['affiliate_id'] );?>" target="_blank"><?php echo esc_html($totalReferrals);?> (<?php echo af_format_price_and_currency( $data['currency'], $totalAmount );?>)</a></div>
                                        </th>
                                        <td>
                                        	<div><?php esc_html_e( 'Approved:', 'openaffiliates' );?>: <?php echo esc_html($data['referrals_stats']['verified_referrals']);?> (<?php echo af_format_price_and_currency( $data['currency'], $data['referrals_stats']['verified_referrals_amount'] );?>)</div>
                                        	<div><?php esc_html_e( 'Pending:', 'openaffiliates' );?>: <?php echo esc_html($data['referrals_stats']['unverified_referrals']);?> (<?php echo af_format_price_and_currency( $data['currency'], $data['referrals_stats']['unverified_referrals_amount'] );?>)</div>
                                        </td>
                                    </tr>
                                    <tr class="form-field">
                                        <?php $totalEarnings = $data['stats']['total_paid_referrals']  + $data['stats']['total_unpaid_referrals'];?>
                                        <?php
                                            if ( !isset( $data['stats']['total_paid'] ) ){
                                              $data['stats']['total_paid'] = '';
                                            }
                                            if ( !isset( $data['stats']['total_unpaid_referrals'] ) ){
                                              $data['stats']['total_unpaid_referrals'] = '';
                                            }
                                        ?>
                                        <th>
                                        	<div><?php esc_html_e( 'Earnings', 'openaffiliates' );?></div>
                                        	<div> <?php echo af_format_price_and_currency( $data['currency'], $totalEarnings );?></div>
                                        </th>
                                        <td>
                                        	<div><?php esc_html_e( 'Paid:', 'openaffiliates' );?>: <a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=paid_referrals&affiliate=' . $data['affiliate_id'] );?>" target="_blank"><?php echo af_format_price_and_currency( $data['currency'], $data['stats']['total_paid'] );?></a></div>
                                        	<div><?php esc_html_e( 'Unpaid:', 'openaffiliates' );?>: <a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=unpaid&affiliate=' . $data['affiliate_id'] );?>" target="_blank"><?php echo af_format_price_and_currency( $data['currency'], $data['stats']['total_unpaid_referrals'] );?></a></div>
                                        </td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th>
                                        	<div><?php esc_html_e( 'Clicks', 'openaffiliates' );?></div>
                                        	<div> <a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=visits&affiliate_id=' . $data['affiliate_id'] );?>" target="_blank"><?php echo esc_html($data['stats']['visits']);?></a></div>
                                        </th>
                                        <td>
                                        	<div><?php esc_html_e( 'Conversion:', 'openaffiliates' );?>: <?php echo esc_html($data['stats']['conversions']);?></div>
                                        	<div><?php esc_html_e( 'Success Rate:', 'openaffiliates' );?>: <?php echo esc_html($data['stats']['success_rate']);?>%</div>
                                        </td>
                                    </tr>
                                    <tr class="form-field">
                                    	<th>
                                        	<div><?php esc_html_e( 'Payout', 'openaffiliates' );?></div>
                                        	<div> <?php echo af_format_price_and_currency( $data['currency'], $data['payment_stats']['paid_payments_value'] );?></div>
                                        </th>
                                        <td>
                                        	<div><?php esc_html_e( 'Completed Transactions:', 'openaffiliates' );?>: <?php echo esc_html($data['count_payments_completed']);?></div>
                                        	<div><?php esc_html_e( 'Pending Transactions:', 'openaffiliates' );?>: <?php echo esc_html($data['count_payments_pending']);?></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                         </div>

                         <?php if ( !empty( $data['statsForLast30'] ) ):?>
                            <div class="af-userprofile-chart-wrapper" ><canvas id="chart-1" ></canvas></div>
                         <?php endif;?>
                    </div>
                </div>
                <div class="row">

                	<div class="col-xs-8">
                  	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Payout Details', 'openaffiliates' );?></div>
                  	<table class="form-table">
                      <tbody>
                          <tr class="form-field">
                              <th><?php esc_html_e( 'Payout Method', 'openaffiliates' );?>:</th>
                              <td>
                                  <?php switch( $data['payments_settings']['af_affiliate_payment_type'] ){
                                          case 'bt':?>
                                          <?php esc_html_e( 'Direct Deposit', 'openaffiliates' );?>
                                        <?php break;
                                          case 'paypal':?>
                                          <?php esc_html_e( 'PayPal', 'openaffiliates' );?>
                                        <?php break;
                                          case 'stripe':?>
                                          <?php esc_html_e( 'Stripe', 'openaffiliates' );?>
                                        <?php break;
                                          case 'stripe_v2':?>
                                            <?php esc_html_e( 'Stripe', 'openaffiliates' );?>
                                        <?php break;?>
                                        <?php case 'stripe_v3':?>
                                        <?php esc_html_e( 'Stripe', 'openaffiliates' );?>
                                      <?php break;?>
                                  <?php }?>
                              </td>
                          </tr>
                          <tr class="form-field">
                              <?php switch( $data['payments_settings']['af_affiliate_payment_type'] ){
                                      case 'bt':?>
                                      <th><?php esc_html_e( 'Account:', 'openaffiliates' );?></th>
                                      <td><?php echo esc_html($data['payments_settings']['af_affiliate_bank_transfer_data']);?></td>
                                    <?php break;
                                      case 'paypal':?>
                                      <th><?php esc_html_e( 'E-mail address:', 'openaffiliates' );?></th>
                                      <td><?php echo esc_html($data['payments_settings']['af_affiliate_paypal_email']);?></td>
                                    <?php break;
                                      case 'stripe':?>
                                      <th><?php esc_html_e( 'Stripe Name:', 'openaffiliates' );?></th>
                                      <td><?php echo esc_html($data['payments_settings']['af_affiliate_stripe_name']);?></td>
                                      </tr>
                                      <tr class="form-field">
                                        <th><?php esc_html_e( 'Card number:', 'openaffiliates' );?></th>
                                        <td><?php echo esc_html($data['payments_settings']['af_affiliate_stripe_card_number']);?></td>
                                      </tr>
                                      <tr class="form-field">
                                        <th><?php esc_html_e( 'Expiration month:', 'openaffiliates' );?></th>
                                        <td><?php echo esc_html($data['payments_settings']['af_affiliate_stripe_expiration_month']);?></td>
                                      </tr>
                                      <tr class="form-field">
                                        <th><?php esc_html_e( 'Expiration year:', 'openaffiliates' );?></th>
                                        <td><?php echo esc_html($data['payments_settings']['af_affiliate_stripe_expiration_year']);?></td>
                                      </tr>
                                      <tr class="form-field">
                                        <th><?php esc_html_e( 'Card type:', 'openaffiliates' );?></th>
                                        <td><?php echo esc_html($data['payments_settings']['af_affiliate_stripe_card_type']);?></td>
                                    <?php break;?>
                                    <?php case 'stripe_v2':?>
                                      <th></th>
                                      <td></td>
                                    <?php break;?>
                                    <?php case 'stripe_v3':
                                        ?>
                                        <th><?php esc_html_e( 'Stripe Account:', 'openaffiliates' );?></th>
                                        <td>
                                        <?php
                                        $accountId = get_user_meta( $data['uid'], 'af_stripe_v3_user_account_id', true );
                            						if ( $accountId != false && $accountId != '' ):
                            							$stripe_link = '';
                            							$sandbox = get_option( 'af_stripe_v3_sandbox' );
                            							if ( $sandbox ){
                            									$stripe_link = 'https://dashboard.stripe.com/test/connect/accounts/'.$accountId;
                            							}else{
                            									$stripe_link = 'https://dashboard.stripe.com/connect/accounts/'.$accountId;
                            							}
                            							?>
                            							<div class="af-payment-details-do-payment">
                            									<a href="<?php echo esc_url($stripe_link);?>" target="_blank"><?php
                            									_e( 'View Stripe Affiliate Account', 'openaffiliates');
                            							?></a></div>
                            					<?php else :?>
                            						<div class="af-payment-details-do-payment"><?php esc_html_e('Incomplete Payment Settings', 'openaffiliates');?></div>
                                      <?php endif;?>
                                      </td>
                                    <?php break;?>
                              <?php }?>
                          </tr>
                      </tbody>
                    </table>
                  </div>


                    <?php if ( !empty( $data['campaigns'] ) ):?>
                      <div class="col-xs-4">
                    	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Campaigns', 'openaffiliates' );?></div>
                        <table class="form-table">
                          <tbody>
                              <?php foreach ( $data['campaigns'] as $campaignObject ):?>
                                  <tr class="form-field">
                                      <th width="40%" class="af-text-align-center"><?php echo esc_html($campaignObject->name);?></th>
                                      <td width="20%"><?php esc_html_e('Visists: ', 'openaffiliates');?><?php echo esc_html($campaignObject->visit_count);?></td>
                                      <td width="20%"><?php esc_html_e('Unique visits: ', 'openaffiliates');?><?php echo esc_html($campaignObject->unique_visits_count);?></td>
                                      <td width="20%"><?php esc_html_e('Referrals: ', 'openaffiliates');?><?php echo esc_html($campaignObject->referrals);?></td>
                                  </tr>
                              <?php endforeach;?>
                          </tbody>
                        </table>
                	  </div>
                    <?php endif;?>
                </div>
 				<div class="row af-userprofile-specialrow">

                  <?php if ( $data['coupons'] ):?>
                      <div class="col-xs-4 af-userprofile-box">
                          <div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Assigned Coupons', 'openaffiliates' );?> <span>(<a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=coupons' );?>" target="_blank"><?php esc_html_e( 'check settings', 'openaffiliates' );?></a>)</span></div>
                          <ul class="af-userprofile-list">
                              <?php foreach ( $data['coupons'] as $couponData ):?>
                                  <?php $couponSettings = unserialize( $couponData['settings'] );?>
                                  <li><?php echo esc_html($couponData['code']);?>
                                      <?php if ( isset( $couponSettings['amount_type'] ) && $couponSettings['amount_type'] == 'percentage' ):?>
                                          (<?php echo esc_html($couponSettings['amount_value']);?>%) -
                                      <?php else :?>
                                          (<?php echo af_format_price_and_currency( $data['currency'], $couponSettings['amount_value'] );?>) -
                                      <?php endif;?>
                                  <a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=coupons&add_edit=' . $couponData['code'] );?>" target="_blank"><?php esc_html_e( 'Edit', 'openaffiliates' );?></a> |
                                  <span class='af-js-delete-coupons-link af-delete-span' data-id='<?php echo esc_attr($couponData['id']);?>' ><?php esc_html_e( 'Delete', 'openaffiliates' );?></span>
                                  </li>
                              <?php endforeach;?>
                              <li><a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=coupons&add_edit=0' );?>" target="_blank"><?php esc_html_e( 'Add New', 'openaffiliates' );?></a></li>
                          </ul>
                      </div>
                  <?php endif;?>

                  <?php if ( $data['referrer_links'] ):?>
                      <div class="col-xs-4 af-userprofile-box">
                            	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Referrer Links', 'openaffiliates' );?> <span>(<a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=simple_links' );?>" target="_blank"><?php esc_html_e( 'check settings', 'openaffiliates' );?></a>)</span></div>
                              <ul class="af-userprofile-list">
                                <?php foreach ( $data['referrer_links'] as $referrerLinks ):?>
                                     <li><a href="<?php echo esc_url($referrerLinks['url']);?>" target="_blank"><?php echo esc_url($referrerLinks['url']);?></a> - <span class='af-js-delete-referrals-link af-delete-span' data-id='<?php echo esc_attr($referrerLinks['id']);?>' ><?php esc_html_e( 'Delete', 'openaffiliates' );?></span></li>
                                <?php endforeach;?>
                              </ul>
                      </div>
                  <?php endif;?>

                  <?php if ( $data['landing_pages'] ):?>
                      <div class="col-xs-4 af-userprofile-box">
                          	<div class="af-userprofile-sectiontitle"><?php esc_html_e( 'Landing Page', 'openaffiliates' );?> <span>(<a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=landing_pages' );?>" target="_blank"><?php esc_html_e( 'check settings', 'openaffiliates' );?></a>)</span></div>
                            <ul class="af-userprofile-list">
                              <?php foreach ( $data['landing_pages'] as $landingPage ):?>
                            	     <li><a href="<?php echo get_permalink($landingPage->ID);?>" target="_blank"><?php echo esc_html($landingPage->post_title);?></a> - <a href="<?php echo admin_url('post.php?post='.$landingPage->ID.'&action=edit');?>" target="_blank"><?php esc_html_e( 'Edit', 'openaffiliates' );?></a> |
                                        <span class='af-js-delete-landing-page af-delete-span' data-id='<?php echo esc_attr($landingPage->ID);?>' ><?php esc_html_e( 'Delete', 'openaffiliates' );?></span>
                                   </li>
                              <?php endforeach;?>
                            </ul>
                      </div>
                  <?php endif;?>

          </div>





            <?php endif;?>
        </div>
    </div>

    <?php if ( $data['mlm'] ):?>
        <?php echo esc_af_content($data['mlm']);?>
    <?php endif;?>
</div>

<span class="af-js-user-profile-copy-message" data-value='<?php esc_html_e( 'Copied to clipboard.', 'openaffiliates' );?>'></span>

<?php if ( !empty( $data['statsForLast30'] ) ):?>
<?php wp_enqueue_script( 'af-moment.js', AF_URL . 'assets/js/moment.min.js', ['jquery'], false );?>
<?php wp_enqueue_script( 'af-chart.js', AF_URL . 'assets/js/chart.min.js', ['jquery'], false );?>
<?php wp_enqueue_script( 'af-public-overview', AF_URL . 'assets/js/public-overview.js', ['jquery'], false );?>

<span class="af-js-overview-earnings-received-label" data-value="<?php echo esc_html__( 'Earnings received', 'openaffiliates' ) . ' ('.$data['currency'].')';?>"></span>
<span class="af-js-overview-earnings-label" data-value="<?php esc_html_e('Earnings', 'openaffiliates');?>"></span>

<?php
foreach( $data['statsForLast30'] as $date => $amount ):?>
		<span class="af-js-overview-stats-last-30"
		data-date="<?php echo af_convert_date_to_us_format($date);?>"
		data-amount="<?php echo af_format_price_and_currency($data['currency'], $amount );?>"
		data-base_amount="<?php echo esc_attr($amount);?>"
		<?php
				$temporaryDate = explode( '-', $date);
				$day = isset($temporaryDate[2]) ? $temporaryDate[2] : $date;
				echo esc_attr("data-label='$day' ");
		?>
		></span>
<?php endforeach;?>


<?php endif;?>
