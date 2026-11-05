/*
 * Open Affiliates - Payout Setup
 */
"use strict";
var AfPayoutSetup = {

  init: function(args){
      var obj = this;

      // affiliate search
      if ( jQuery( ".af-js-payout-setup-search-for-affiliates" ).length > 0 ){
          jQuery( ".af-js-payout-setup-search-for-affiliates" ).on( "keydown", function( event ) {
              if ( event.keyCode === jQuery.ui.keyCode.TAB && jQuery( this ).autocomplete( "instance" ).menu.active ) {
                  event.preventDefault();
              }
          }).autocomplete({
              minLength: 0,
              source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&users=true&afAdminAjaxNonce=' + window.afAdminAjaxNonce,
              focus: function() {},
              select: function( event, ui ) {
                  var input_id = '#usernames_search_hidden';
                  var terms = af_split(jQuery(input_id).val());//get items from input hidden
                  var v = ui.item.id;
                  var l = ui.item.label;
                  if (!afContains(terms, v)){
                      terms.push(v);
                      // print the new shiny box
                      afAutocompleteWriteTag(v, input_id, '#af_username_search_tags', 'af_username_tag_', l);
                   }
                  var str_value = terms.join( "," );
                  jQuery(input_id).val(str_value);//send to input hidden
                  this.value = '';//reset search input
                  return false;
              }
          });
      }

      // select target referrals - all / older than/ custom range
      if ( jQuery( '[name=select_referrals]' ).length > 0 ){
          jQuery( '[name=select_referrals]' ).on('change', function(){
              if ( jQuery( this ).val() === 'custom_range' ){
                  jQuery( '.af-js-payout-setup-updaid-referrals-custom-range' ).removeClass('af-display-none').addClass( 'af-display-block' );
              } else {
                  jQuery( '.af-js-payout-setup-updaid-referrals-custom-range' ).removeClass('af-display-block').addClass( 'af-display-none' );
              }
          });
      }
      // end of - select target referrals - all / older than/ custom range

      // custom range - datepicker
      if ( jQuery( '.af-js-payout-setup-select-custom-range-value' ).length > 0 ){
          jQuery( '.af-js-payout-setup-select-custom-range-value' ).on( 'change', function(){
              if ( jQuery( this ).val() === 'custom' ){
                  jQuery( '.af-js-payout-setup-date-pickers' ).removeClass('af-display-none').addClass( 'af-display-block' );
              } else {
                  jQuery( '.af-js-payout-setup-date-pickers' ).removeClass('af-display-block').addClass( 'af-display-none' );
              }
          });
      }
      // end of custom range - datepicker

      // select target affiliates - all or just some
      if ( jQuery( '[name=select_affiliates]' ).length > 0 ){
          jQuery( '[name=select_affiliates]' ).on('change', function(){
              if ( jQuery( this ).val() === 'selected_affiliates' ){
                  // specific affiliates
                  jQuery( '.af-js-select-specific-affiliates' ).removeClass( 'af-display-none' ).addClass( 'af-display-block' );
              } else {
                  // all affiliates
                  jQuery( '.af-js-select-specific-affiliates' ).removeClass( 'af-display-block' ).addClass( 'af-display-none' );
              }
          });
      }
      // end of select target affiliates - all or just some

      // referrals - custom range - date picker
      // start
      if ( jQuery( '.af-js-payout-setup-referrals-custom-range-start' ).length > 0 ){
          jQuery( '.af-js-payout-setup-referrals-custom-range-start' ).datepicker({
                dateFormat : 'yy-mm-dd ',
                onSelect: function( datetext ){
                    var d = new Date();
                    datetext = datetext+d.getHours()+":"+afAddZero(d.getMinutes())+":"+afAddZero(d.getSeconds());
                    jQuery(this).val(datetext);
                }
          });
      }
      if ( jQuery( '.af-js-payout-setup-referrals-custom-range-end' ).length > 0 ){
          jQuery( '.af-js-payout-setup-referrals-custom-range-end' ).datepicker({
                dateFormat : 'yy-mm-dd ',
                onSelect: function( datetext ){
                    var d = new Date();
                    datetext = datetext+d.getHours()+":"+afAddZero(d.getMinutes())+":"+afAddZero(d.getSeconds());
                    jQuery(this).val(datetext);
                }
          });
      }
      // end of referrals - custom range - date picker

      // generate CSV file on single payout
      if ( jQuery( '.af-js-single-payout-generate-csv' ).length ){

          jQuery( '.af-js-single-payout-generate-csv' ).on('click', function(){
              jQuery( '.af-js-payouts-csv-file').removeClass('af-display-block').addClass('af-display-none');
              var payoutID = jQuery(this).attr('data-id');
              jQuery.ajax({
                      type 			: 'post',
                      url 			: decodeURI(ajax_url),
                      data 			: {
                                 action		            : 'af_ajax_payouts_generate_csv',// custom
                                 af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                 payout_id   			    : payoutID,
                      },
                      success		: function (response) {
                         if ( response == 0 ){
                             return;
                         }
                         jQuery( '.af-js-payouts-csv-file-for-payout-' + payoutID).removeClass('af-display-none').addClass('af-display-inline')
                         jQuery( '.af-js-payouts-csv-file-for-payout-' + payoutID).attr( 'href', response );
                      }
              });
          });
      }
      // end of generate CSV file on single payout

      // change status for payment
      if ( jQuery( '.af-js-payment-change-status').length ){
          jQuery( '.af-js-payment-change-status').on( 'click', function(){
              var status = jQuery( '.af-js-single-payment-new-status' ).val();
              var paymentId = jQuery( this ).attr('data-id');
              jQuery.ajax({
                      type 			: 'post',
                      url 			: decodeURI(ajax_url),
                      data 			: {
                                 action		              : 'af_ajax_payments_change_status',// custom
                                 af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                 id			                : paymentId,
                                 status                 : status
                      },
                      success		: function (response) {
                          location.reload();
                      }
              });
          });
      }
      // end of - change status for payment

  },

}

jQuery( window ).on('load', function(){
    AfPayoutSetup.init([]);
});
