<?php
$i = 0;
if ( $data['settings']['af_info_affiliate_bar_logo'] ){
   $i++;
}
if ( $data['settings']['af_info_affiliate_bar_links_section_enabled'] ){
   $i++;
}
if ( $data['settings']['af_info_affiliate_bar_banner_section_enabled'] && $data['banner'] ){
   $i++;
}
if ( $data['settings']['af_info_affiliate_bar_social_section_enabled'] ){
   $i++;
}
if ( $data['settings']['af_info_affiliate_bar_stats_general_section_enabled']  ||  $data['settings']['af_info_affiliate_bar_stats_personal_section_enabled'] ){
   $i++;
}
if ( $data['settings']['af_info_affiliate_bar_menu_section_enabled'] ){
   $i++;
}
$width = 99 / $i;
$custom_css = '';
$custom_css .= "
.af-info-affiliate-bar-item {
    width: calc(".$width."%-1px);
}
";
wp_register_style( 'dummy-handle', false );
wp_enqueue_style( 'dummy-handle' );
wp_add_inline_style( 'dummy-handle', $custom_css );
?>

<div id="af_info_affiliate_bar" class="af-info-affiliate-bar-wrapper">

    <span class="af-js-iab-simple-affiliate-link-label" data-value="<?php echo esc_html__('Simple Affiliate Link', 'openaffiliates'); ?>"></span>
    <span class="af-js-iab-banner-affiliate-link-label" data-value="<?php echo esc_html__('Banner Affiliate Link', 'openaffiliates'); ?>"></span>


        <div class="af-info-affiliate-bar-item af-info-affiliate-bar-logo">
        <?php if ( $data['settings']['af_info_affiliate_bar_logo'] ):?>
       	 	<img src="<?php echo esc_url($data['settings']['af_info_affiliate_bar_logo']);?>" class="af-iab-logo" />

    	<?php endif;?>
    	</div>

		<div class="af-info-affiliate-bar-item af-info-affiliate-bar-links">
        	<div class="af-info-affiliate-bar-extralabel">
				<?php echo stripslashes($data['settings']['af_info_affiliate_bar_links_get_label']); ?>
        	</div>
            <ul class="af-info-affiliate-bar-getlinks">
    <?php if ( $data['settings']['af_info_affiliate_bar_links_section_enabled'] ): ?>
            <li class="af-info-affiliate-bar-btn af-info-affiliate-bar-btn-default" id="af_js_info_affiliate_bar_links_trigger"><i class="fa-af fa-info_affiliate_bar-link"></i><span class="af-info-affiliate-sublabel"><?php echo stripslashes($data['settings']['af_info_affiliate_bar_links_label']);?></span></li>
            <span class="af-display-none" id="af_js_iab_linkts_triggers_section_data"><?php echo esc_af_content($data['links_section']);?></span>
    <?php endif;?>


    <?php if ( $data['settings']['af_info_affiliate_bar_banner_section_enabled'] && $data['banner'] ): ?>
            <li class="af-info-affiliate-bar-btn af-info-affiliate-bar-btn-default" id="af_info_affiliate_bar_banner_section"><i class="fa-af fa-info_affiliate_bar-banner"></i><span class="af-info-affiliate-sublabel"><?php echo stripslashes($data['settings']['af_info_affiliate_bar_banner_label']);?></span></li>
            <div id="af_info_affiliate_bar_banner_extra_info" data-affiliate_id="<?php echo esc_attr($data['affiliate_id']);?>" data-uid="<?php echo esc_attr($data['uid']);?>" ></div>
<span class="af-display-none" id="af_js_iab_banner_section_data"><?php echo esc_af_content($data['bannerSection']);?></span>

    <?php endif;?>
    </ul>
    <div class="af-clear"></div>
  </div>
    <?php if ( $data['settings']['af_info_affiliate_bar_social_section_enabled'] ): ?>
        <div class="af-info-affiliate-bar-item af-info-affiliate-bar-social">
        	<span class="af-info-affiliate-bar-extralabel af-info-affiliate-bar-full-line">
				<?php echo stripslashes($data['settings']['af_info_affiliate_bar_social_label']); ?>
        	</span>
            <?php echo esc_af_content($data['socialLinks']);?>
        </div>
    <?php endif;?>

    <div class="af-info-affiliate-bar-item af-info-affiliate-bar-menu">
    <?php if ( $data['settings']['af_info_affiliate_bar_menu_section_enabled'] ):?>
          <div class="af-info-affiliate-bar-btn af-info-affiliate-bar-btn-default"
                      id="popover_for_iab_menu"
                      data-title = "<?php echo stripslashes($data['settings']['af_info_affiliate_bar_menu_label']);?>"
                      data-content="
                        <ul>
                          <li><a href='<?php echo esc_url($data['profile_permalink']);?>' target='_blank'><?php echo esc_html__('Your Profile', 'openaffiliates'); ?></a></li>
                          <li><a href='<?php echo esc_url($data['settings_permalink']);?>' target='_blank'><?php echo esc_html__('Extra Settings', 'openaffiliates'); ?></a></li>
                          <li><a href='<?php echo esc_url($data['tips_permalink']);?>'  target='_blank'><?php echo esc_html__('Learn more', 'openaffiliates'); ?></a></li>
                        </ul>
                        <div class='af-pointer af-affiliate-bar-temporary' onClick='afDoHideInfoAffiliateBar( this );' ><?php echo esc_html__('Temporary Hide FlashBar', 'openaffiliates'); ?></div>
                        <div class='af-affiliate-bar-info'><?php  esc_html_e('FlashBar will be disabled for 24hrs', 'openaffiliates'); ?></div>
                    "
                      data-shift = "-2"
                      data-defineClass = "bord"
          ><i class="fa-af fa-info_affiliate_bar-menu"></i></div>
    <?php endif;?>
	 </div>


    <?php if ( $data['settings']['af_info_affiliate_bar_stats_general_section_enabled']  ||  $data['settings']['af_info_affiliate_bar_stats_personal_section_enabled'] ):?>
        <div class="af-info-affiliate-bar-item af-info-affiliate-bar-stats">
        	<span class="af-info-affiliate-bar-extralabel af-info-affiliate-bar-full-line">
				<?php echo stripslashes($data['settings']['af_info_affiliate_bar_stats_label']);?>
        	</span>
            <?php if ( $data['settings']['af_info_affiliate_bar_stats_general_section_enabled'] ):?>
            <div class="af-info-affiliate-bar-stats-content">
            	<div class="af-info-affiliate-bar-extralabel">
					<?php echo stripslashes($data['settings']['af_info_affiliate_bar_insigts_label']); ?>
        		</div>
                <ul class="af-info-affiliate-bar-stats-list">
                	<li><?php echo esc_html($data['personalVisits']);?> <?php echo stripslashes($data['settings']['af_info_affiliate_bar_visits_label']); ?></li>
                    <li><?php echo esc_html($data['personalReferrals']);?> <?php echo stripslashes($data['settings']['af_info_affiliate_bar_referrals_label']); ?></li>
                </ul>
    			<div class="af-clear"></div>
            </div>
            <?php endif;?>
            <?php if ( $data['settings']['af_info_affiliate_bar_stats_personal_section_enabled'] ):?>
            <div class="af-info-affiliate-bar-stats-content">
            	<div class="af-info-affiliate-bar-extralabel">
					<?php echo stripslashes($data['settings']['af_info_affiliate_bar_overall_performance_label']); ?>
        		</div>
                <?php
                    if ( $data['generalReferrals'] == 0 || $data['generalVisits'] == 0 ){
                        $conversion = 0;
                    } else {
                        $conversion = $data['generalReferrals'] * 100 / $data['generalVisits'];
                    }
                ?>
                <ul class="af-info-affiliate-bar-stats-list">
                	<li><?php echo esc_html($conversion.'%');?> <?php echo stripslashes($data['settings']['af_info_affiliate_bar_conversion_rate_label']); ?></li>
                </ul>
    			<div class="af-clear"></div>
            </div>
            <?php endif;?>
        </div>
    <?php endif;?>


    <div class="af-clear"></div>
</div>
