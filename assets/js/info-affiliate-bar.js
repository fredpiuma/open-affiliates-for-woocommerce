/*
 *Open Affiliates - Front-end Affiliate Bar
 */
"use strict";
window.addEventListener("DOMContentLoaded", function(){
  if ( jQuery('#af_js_info_affiliate_bar_links_trigger').length ){
      jQuery( '#af_js_info_affiliate_bar_links_trigger' ).popover({
            content       : jQuery('#af_js_iab_linkts_triggers_section_data').html(),
            interface     : 'popover',
            position      : 'top-left',
            trigger       : 'click',
            trigger_off   : 'click',
            theme		      : 'af-links-section',
            title 		    : jQuery('.af-js-iab-simple-affiliate-link-label').attr('data-value'),
      });
      jQuery('#af_js_iab_linkts_triggers_section_data').html('');

      jQuery( document ).on( 'change', '#af_affiliate_bar_friendly_links', function( e ){
          afInfoAffiliateBarUpdateLink();
      });
  }

  jQuery( document ).on( 'change', '#ap_affiliate_bar_ref_type', function( e ){
      afInfoAffiliateBarUpdateLink();
  });

    if ( jQuery('#af_info_affiliate_bar_banner_section').length ){
        jQuery( '#af_info_affiliate_bar_banner_section' ).popover({
              content       : jQuery('#af_js_iab_banner_section_data').html(),
              interface     : 'popover',
              position      : 'top-left',
              trigger       : 'click',
              trigger_off   : 'click',
              theme		      : 'af-banners-section',
              title 		    : jQuery( '.af-js-iab-banner-affiliate-link-label' ).attr('data-value'),
        });
        jQuery('#af_js_iab_banner_section_data').html( '' );
    }

  jQuery( document ).on( 'change', '#af_iab_banner_select_size', function( e ){
        afInfoAffiliateBarChangeBannerSize( jQuery( '#af_iab_banner_select_size' ).val() );
  });
  
  if ( jQuery('#popover_for_iab_menu').length ){
        jQuery( '#popover_for_iab_menu' ).popover({
              content       : jQuery( '#popover_for_iab_menu' ).attr('data-content'),
              interface     : 'popover',
              position      : 'top-right',
              trigger       : 'click',
              trigger_off   : 'click',
              theme		      : 'af-menu-section',
              title 		    : jQuery( '#popover_for_iab_menu' ).attr('data-title'),
        });
        jQuery('#af_js_iab_banner_section_data').html( '' );

    }

  
});
