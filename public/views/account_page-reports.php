<div class="af-account-reports-tab">
<div class="af-ap-wrap">

	<?php if (!empty($data['title'])):?>
		<h3><?php echo esc_af_content($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['message'])):?>
		<p><?php echo do_shortcode($data['message']);?></p>
	<?php endif;?>

<div class="af-row">
<?php if (!empty($data['referrals'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box af-account-box-green">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo esc_af_content($data['referrals']);?></div><div class="af-detail"><?php echo esc_html__('Total Approved Referrals', 'openaffiliates'); ?></div>
                <div class="af-subnote"><?php echo esc_html__('rewards and commissions received by now', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
<?php if (isset($data['total_paid'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box af-account-box-lightyellow">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo af_format_price_and_currency($data['currency'], round($data['total_paid'], 2));?></div><div class="af-detail"><?php echo esc_html__('Total Withdrawn Earnings (paid Referrals)', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
<?php if (!empty($data['total_unpaid_referrals'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box af-account-box-red">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo af_format_price_and_currency($data['currency'], round($data['total_unpaid_referrals'], 2));?></div><div class="af-detail"><?php echo esc_html__('Your current Balance', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
</div>
<div class="af-row">
<?php if (!empty($data['visits'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box af-account-box-lightgray">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo  $data['visits'];?></div><div class="af-detail"><?php echo esc_html__('Total Clicks', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
<?php if (!empty($data['conversions'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box af-account-box-lightblue">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo esc_af_content($data['conversions']);?></div><div class="af-detail"><?php echo esc_html__('Converted Clicks', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
<?php if (!empty($data['success_rate'])): ?>
		<div class="afcol-md-3">
			<div class="af-account-no-box">
			  <div class="af-account-no-box-inside">
				<div class="af-count"><?php echo esc_af_content($data['success_rate']);?>%</div><div class="af-detail"><?php echo esc_html__('Success Rate', 'openaffiliates'); ?></div>
			  </div>
			</div>
		</div>
<?php endif;?>
</div>



<?php
if (!empty($data['achivements'])): ?>
<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php echo esc_html__('Your Achievements', 'openaffiliates'); ?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-rows ">
            	<div class="af-col-xs-10">
                    <?php
						$k = 1;
                        foreach ($data['achivements'] as $item):
                        $current = (empty($item['current_rank'])) ? esc_html__('None', 'openaffiliates') : $item['current_rank'];
                        $prev = (empty($item['prev_rank'])) ? esc_html__('None', 'openaffiliates') : $item['prev_rank'];
                        ?>
                    	<div class="af-achievements">
                    		<div class="af-achievements-content">
                            <div class="af-achievements-content-line">
							<span class=" af-special-label">#<?php echo esc_af_content($k);?>.</span>
							<?php echo esc_html__('On', 'openaffiliates') . ' ' . af_convert_date_to_us_format($item['add_date']) . ' ' . esc_html__('You moved from ', 'openaffiliates') . $prev . ' ' . esc_html__('to', 'openaffiliates') . ' ' . $current;?>.</div>
                            </div>
                     	</div>
                        <?php
						$k++;
                        endforeach;?>

              </div>
          </div>
      </div>
</div>
<?php endif;?>

</div>
</div>
