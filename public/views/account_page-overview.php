<div class="af-account-dashboard-tab">
<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['stats'])):?>
<div class="af-row">
		<div class="afcol-md-4 af-account-overview-tab1">
			<div class="af-account-no-box af-account-box-green af-no-padding">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo esc_html($data['stats']['referrals']); ?> </div>
				<div class="af-detail"><?php echo esc_html__('Total Referrals', 'openaffiliates'); ?></div>
                <div class="af-subnote"><?php echo esc_html__('Rewards and commissions received up to this point', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
		<div class="afcol-md-4 af-account-overview-tab2">
			<div class="af-account-no-box af-account-box-lightyellow af-no-padding">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo esc_html($data['stats']['paid_referrals_count']); ?> </div>
				<div class="af-detail"><?php echo esc_html__('Paid Referrals', 'openaffiliates'); ?></div>
                <div class="af-subnote"><?php echo esc_html__('Number of referrals withdrawn up to now', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
		<div class="afcol-md-4 af-account-overview-tab3">
			<div class="af-account-no-box af-account-box-red af-no-padding">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo esc_html($data['stats']['unpaid_referrals_count']); ?> </div>
				<div class="af-detail"><?php echo esc_html__('Unpaid Referrals', 'openaffiliates'); ?></div>
                <div class="af-subnote"><?php echo esc_html__('Referrals that have not yet been withdrawn', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
		<div class="afcol-md-4 af-account-overview-tab4">
			<div class="af-account-no-box af-account-box-lightblue af-no-padding">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo esc_html($data['stats']['payments']); ?> </div>
				<div class="af-detail"><?php echo esc_html__('Total Payout Payments', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
</div>
<div class="af-row">
	<div class="afcol-md-2 af-account-overview-tab5">
			<div class="af-account-no-box af-account-box-lightgray">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo af_format_price_and_currency($data['stats']['currency'], round($data['stats']['paid_payments_value'], 2) );?> </div>
				<div class="af-detail"><?php echo esc_html__('Earnings that have been withdrawn up to this point', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
		<div class="afcol-md-2 af-account-overview-tab6">
			<div class="af-account-no-box af-account-box-blue">
			 <div class="af-account-no-box-inside">
			  	<div class="af-count"> <?php echo af_format_price_and_currency($data['stats']['currency'], round($data['stats']['unpaid_payments_value'], 2));?> </div>
				<div class="af-detail"><?php echo esc_html__('The current balance available in the account', 'openaffiliates'); ?></div>
			 </div>
			</div>
		</div>
</div>
<div class="af-profile-box-wrapper">
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
   						 <div class="af-account-help-link">
			  				<?php esc_html_e('Discover more about our affiliate program and begin earning referrals today ', 'openaffiliates');?>
              					<a href="<?php echo esc_url($data['help_url']);?>">
			  						<?php esc_html_e('here', 'openaffiliates');?>
              					</a>
                    		</div>
        		</div>
        	</div>
        </div>
     </div>
     <div class="af-profile-box-wrapper af-account-summary-wrapper">
        <div class="af-profile-box-content  af-no-padding" >
        	<div class="af-row ">
            	<div class="af-col-xs-8 af-account-summary-graph-col">
   					<div class="af-account-summary-month af-account-summary-graph-warpper">
                    	<div class="af-account-summary-month-header">
                        	<div class="af-account-summary-graph-title">
                            	<?php esc_html_e('Earnings Overview', 'openaffiliates');?> <span><?php esc_html_e('(for Last 30 days)', 'openaffiliates');?></span>

                            </div>
                        </div>
                    	 <div class="af-account-summary-month-content">
                            <div class="af-account-summary-graph-content">
                            		<?php esc_html_e('Earnings over the past 30 days', 'openaffiliates');?>
																<?php if ( !empty( $data['statsForLast30'] ) ):?>
																	 <div class="col-4" ><canvas id="chart-1" class="af-canvas" ></canvas></div>
																<?php endif;?>
                            </div>
                            <div class="af-account-summary-summary-content">
                            	<div class="af-row">
                                	<div class="af-col-xs-6 af-account-summary-summary-content-first-col">
                                    	<div class="af-account-summary-summary-data-title"><?php esc_html_e('Total Earnings', 'openaffiliates');?></div>
                                        <div class="af-account-summary-summary-data-content"><?php echo af_format_price_and_currency($data['stats']['currency'], $data['referralsExtraStats']['total_earnings'] );?></div>
                                    </div>

                                	<div class="af-col-xs-6">
                                    	<div class="af-account-summary-summary-data-title"><?php esc_html_e('Clicks', 'openaffiliates');?></div>
                                        <div class="af-account-summary-summary-data-content"><?php echo esc_html($data['referralsExtraStats']['visits']);?></div>
                                    </div>
                                </div>
                            </div>
                         </div>
                    </div>
        		</div>
                <div class="af-col-xs-4 af-account-summary-month-data">
                	<div class="af-account-summary-month">
                    	<div class="af-account-summary-month-header">
                        	<div class="af-account-summary-month-title">
                            	<?php esc_html_e('Summary for This Month', 'openaffiliates');?>
                            </div>
                        </div>
                        <div class="af-account-summary-month-content">
                        	<div class="af-account-summary-month-data">
                            	<div class="af-account-summary-month-data-row af-row af-account-summary-month-data-row-first">
                                	<div class="af-col-xs-7"><?php esc_html_e('Total Referrals:', 'openaffiliates');?></div><div class="af-col-xs-5"><?php echo esc_html($data['referralsExtraStats']['total_referrals']);?></div>
                                </div>
                                <div class="af-account-summary-month-data-row af-row">
                                    <div class="af-col-xs-7"><?php esc_html_e('Total Earnings:', 'openaffiliates');?></div>
																		<div class="af-col-xs-5">
																			<?php echo af_format_price_and_currency($data['stats']['currency'], $data['referralsExtraStats']['total_earnings']);?>
																		</div>
                                </div>
                                <div class="af-account-summary-month-data-row af-row">
                                    <div class="af-col-xs-7"><?php esc_html_e('Pending Referrals:', 'openaffiliates');?></div><div class="af-col-xs-5"><?php echo esc_html($data['referralsExtraStats']['unverified_referrals']);?></div>
                                </div>
                                <div class="af-account-summary-month-data-row af-row">
                                    <div class="af-col-xs-7"><?php esc_html_e('Clicks:', 'openaffiliates');?></div><div class="af-col-xs-5"><?php echo esc_html($data['referralsExtraStats']['visits']);?></div>
                                </div>
                                <div class="af-account-summary-month-data-row af-row">
                                    <div class="af-col-xs-7"><?php esc_html_e('Conversion:', 'openaffiliates');?></div><div class="af-col-xs-5"><?php echo esc_html($data['referralsStats']['success_rate']);?>%</div>
                                </div>
                        	</div>
                        </div>

                    </div>
                </div>
        	</div>
        </div>
     </div>
	<!--div class="af-public-general-stats">
		<div><?php echo esc_html__('Total number of Referrals:') . $data['stats']['referrals'];?></div>
		<div><?php echo esc_html__('Total number of Payments:') . $data['stats']['payments'];?></div>
		<div><?php echo esc_html__('Total number of Paid Referrals:') . $data['stats']['paid_referrals_count'];?></div>
		<div><?php echo esc_html__('Total number of Unpaid Referrals:') . $data['stats']['unpaid_referrals_count'];?></div>
		<div><?php echo esc_html__('Total value of Paid Payments:') . af_format_price_and_currency($data['stats']['currency'], round($data['stats']['paid_payments_value'], 2));?></div>
		<div><?php echo esc_html__('Total value of Unpaid Payments:') . af_format_price_and_currency($data['stats']['currency'], round($data['stats']['unpaid_payments_value'], 2));?></div>
	</div-->
<?php endif;?>

<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>
</div>
</div>

<?php if ( !empty( $data['statsForLast30'] ) ):?>
<?php wp_enqueue_script( 'af-moment.js', AF_URL . 'assets/js/moment.min.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-chart.js', AF_URL . 'assets/js/chart.min.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-public-overview', AF_URL . 'assets/js/public-overview.js', ['jquery'], '9.4', false );?>

<span class="af-js-overview-earnings-received-label" data-value="<?php echo esc_html__( 'Earnings received', 'openaffiliates' ) . ' ('.$data['stats']['currency'].')';?>"></span>
<span class="af-js-overview-earnings-label" data-value="<?php esc_html_e('Earnings', 'openaffiliates');?>"></span>

<?php
foreach( $data['statsForLast30'] as $date => $amount ):?>
		<span class="af-js-overview-stats-last-30"
		data-date="<?php echo af_convert_date_to_us_format($date);?>"
		data-amount="<?php echo af_format_price_and_currency($data['stats']['currency'], $amount );?>"
		data-base_amount="<?php echo esc_attr($amount);?>"
		<?php
				$temporaryDate = explode( '-', $date);
				$day = isset($temporaryDate[2]) ? $temporaryDate[2] : $date;
				echo esc_af_content("data-label='$day' ");
		?>
		></span>
<?php endforeach;?>


<?php endif;?>
