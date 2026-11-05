
<div class="af-dashboard-wrapper-section">
 <div class="af-dashboard-top-section">
	 <div class="af-hs__left">
		 <img src="<?php echo esc_url(AF_URL . 'assets/images/affiliate-dashboard.svg');?>" alt="Open Affiliates">
	 </div>
	 <div class="af-hs__right">
					<h2><?php esc_html_e('Welcome &', 'openaffiliates');?> <strong><?php esc_html_e('Thank You', 'openaffiliates');?></strong> <?php esc_html_e('for Choosing Us!', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Build & manage an affiliate program with one easy-to-use & most-favored affiliate plugin for WordPress and WooCommerce', 'openaffiliates');?></p>
					<?php if((int)get_option( 'af_wizard_complete', -1 ) !== 1){ ?>
						<a class="af-first-button af-big-button af-text-center"  href="<?php echo esc_url($data['base_url'] . '&tab=wizard');?>"><?php esc_html_e('Getting Started With Setup', 'openaffiliates');?>
						<img src="<?php echo esc_url(AF_URL . 'assets/images/right-arrow-icon.png');?>" alt="Open Affiliates"/></a>
					<?php } ?>
				</div>
 </div>
 <div class="af-dashboard-links-section">
	 <h2><?php esc_html_e('What to do', 'openaffiliates');?> <strong><?php esc_html_e('Next', 'openaffiliates');?></strong>?</h2>
            <a href="<?php echo esc_url($data['base_url'] . '&tab=affiliates');?>"  target="_blank" class="af-dashboard-page-link"><i class="fa-af fa-affiliates-af" aria-hidden="true"></i><?php esc_html_e('Manage Affiliates', 'openaffiliates');?></a>
            <a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank" class="af-dashboard-page-link"><i class="fa-af fa-book" aria-hidden="true"></i><?php esc_html_e('Check our Documentation', 'openaffiliates');?></a>
  </div>
	<div class="af-dashboard-features-section">
		<h2><?php esc_html_e('At last, an effortless yet robust', 'openaffiliates');?> <strong><?php esc_html_e('WordPress Affiliate Plugin', 'openaffiliates');?></strong></h2>
		<p><?php esc_html_e('Explore the remarkable features that make Open Affiliates the unparalleled choice for powerful and user-friendly affiliate tracking software in the market', 'openaffiliates');?></p>
		<div class="af-features-row">
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-mlm-account-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Affiliate MLM Network', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-simple_links-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Smart Sales Tracking', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-reports-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Detailed Affiliate Reports', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-payments-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Integrated Online Payouts', 'openaffiliates');?></div>
			</div>
		</div>
		<div class="af-features-row">
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-offers-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Powerful Commission Rules', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-showcases-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Affiliate Portal', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-custom_affiliate_slug-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Fraud Detection And Prevention', 'openaffiliates');?></div>
			</div>
			<div class="af-features-col">
				<div class="af-features-icon"><i class="fa-af fa-source_details-af"></i></div>
				<div class="af-features-title"><?php esc_html_e('Commission Management', 'openaffiliates');?></div>
			</div>
		</div>
	</div>
</div>
<!--div class="af-dashboard-wrapper">
	<div class="af-dashboard-title">
		Open Affiliates -
		<span class="second-text">
			<?php //esc_html_e('Dashboard Overall', 'openaffiliates');?>
		</span>
	</div>
	<div class="row">
	<div class="col-xs-3">
		<div class="af-dashboard-top-box">
			<i class="fa-af fa-dashboard-visits-af"></i>
			<div class="stats">
				<h4><?php //echo esc_html($data['stats']['affiliates']);?></h4>
				<?php //esc_html_e('Total Registered Affiliates', 'openaffiliates');?>
			</div>
		</div>
	</div>

	<div class="col-xs-3">
		<div class="af-dashboard-top-box">
			<i class="fa-af fa-dashboard-referrals-af"></i>
			<div class="stats">
				<h4><?php //echo esc_html($data['stats']['referrals']);?></h4>
				<?php //esc_html_e('Total Generated Referrals', 'openaffiliates');?>
			</div>
		</div>
	</div>

	<div class="col-xs-3">
		<div class="af-dashboard-top-box">
			<i class="fa-af fa-dashboard-payments-unpaid-af"></i>
			<div class="stats">
				<h4><?php //echo af_format_price_and_currency($data['currency'], round($data['stats']['unpaid_payments_value'], 2));?></h4>
				<?php //esc_html_e('Total Unpaid Referrals', 'openaffiliates');?>
			</div>
		</div>
	</div>

	<div class="col-xs-3">
		<div class="af-dashboard-top-box">
			<i class="fa-af fa-dashboard-rank-af"></i>
			<div class="stats">
				<h4><?php //echo esc_html($data['stats']['top_rank']);?></h4>
				<?php //esc_html_e('Most Assigned Rank', 'openaffiliates');?>
			</div>
		</div>
 	</div>
  </div>



<div class="row">
   <div class="col-xs-8">
	<div class="af-box-content-dashboard" >
	 <div class="af-dashboard-box-padded">
		<h4><?php //esc_html_e('Total Affiliates per Rank', 'openaffiliates');?></h4>
		<?php //if (!empty($data['rank_arr'])):?>
			<div id="af_chart_1" class='af-flot'></div>
		<?php //endif;?>
	 </div>
	</div>

	<?php //if (!empty($data['last_referrals'])):?>
	<div class="af-box-content-dashboard af-last-five af-dashboard-box-padded">
		<div class="info-title"><i class="fa-af fa-list-af"></i><?php //esc_html_e('Last Five Referrals received', 'openaffiliates');?></div>
		<?php //foreach ($data['last_referrals'] as $array):?>
			<div class="af-dashboard-las-reff">
				<i class="fa-af fa-icon-pop-list-af"></i>
				<span><?php //echo esc_html('  ') . af_format_price_and_currency($array['currency'], $array['amount']) . esc_html__(' for ', 'openaffiliates') .  '<strong>'.$array['affiliate_username'] .'</strong><br/>'. esc_html__(' on ', 'openaffiliates') . af_convert_date_to_us_format($array['date']); ?></span>
			</div>
		<?php //endforeach;?>
	</div>
	<?php //endif;?>
   </div>

   <div class="col-xs-4">
		<?php //if (!empty($data['top_affiliates'])) : ?>
			<div class="af-box-right-dashboard">
			<div class="af-dashboard-top-affiliate">
					<span class="af-big-cunt">10</span>
					<span><?php //esc_html_e('Top', 'openaffiliates');?><br/><?php //esc_html_e('Affiliates', 'openaffiliates');?></span>
				</div>
				<?php //$i = 1;?>
				<?php //foreach ($data['top_affiliates'] as $key=>$value): ?>
					<div class="af-dashboard-top-affiliate-single">
					 <div class="af-top-name"><?php //echo esc_af_content('<span>' . $i . '</span> ' . $value['name'] . ' (' . $key . ')');?> </div>
					 <div class="af-top-count"><?php //esc_html_e('Referrals', 'openaffiliates');?> <?php //echo esc_html($value['referrals']);?> | <?php //esc_html_e('Total Amount', 'openaffiliates');?> <?php //echo af_format_price_and_currency($data['currency'], $value['sum']);?> </div>
					</div>
					<?php //$i++;?>
				<?php //endforeach;?>
			</div>
		<?php //endif;?>
   </div>
</div>
</div-->
<?php /* if ( $data['rank_arr'] ):?>
		<?php foreach ( $data['rank_arr'] as $key => $value ):?>
				<span class="af-js-dashboard-rank-data" data-label="<?php echo esc_attr($key);?>" data-value="<?php echo esc_attr($value);?>"></span>
		<?php endforeach;?>
<?php endif;  */?>

<?php
