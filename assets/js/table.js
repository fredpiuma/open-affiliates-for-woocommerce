/*
 * Open Affiliates - Table functionality
 */
"use strict";
var AfDataTable = {
    tableId               : '#af-dashboard-table',
    translatedLabels      : null,
    tableButtons          : null,
    tableObject           : null,
    columns               : null,

    // start init
    init                        : function(){
        var object = this;
        var labels = JSON.parse( window.af_datatable_labels );
        object.columns = JSON.parse( window.af_datatable_cols );

        // default settings for datatable
        object.translatedLabels = {
                      processing    : "<div class='af-table-custom-loading'></div>",
                      search				: '',
                      lengthMenu		: labels.lengthMenu,
                      info					: labels.info,
                      infoEmpty			: labels.infoEmpty,
                      infoFiltered	: labels.infoFiltered,
                      loadingRecords: labels.loadingRecords,
                      zeroRecords		: labels.zeroRecords,
                      emptyTable		: labels.emptyTable,
                      paginate			: {
                                    first					: labels.paginate.first,
                                    previous			: labels.paginate.previous,
                                    next					: labels.paginate.next,
                                    last					: labels.paginate.last,
                      },
                      aria					: {
                                    sortAscending		: labels.sortAscending,
                                    sortDescending	: labels.sortDescending,
                      },
                      searchPlaceholder			: labels.searchPlaceholder,
                      search								: "",
                      scroller              : {
                                    loadingIndicator : true
                      }
        };

        // default buttons
        object.tableButtons = [
            {
                extend      : 'colvis',// show/hide columns button
                text        : labels.show_hide_cols_label,// action buttons
                className   : 'af-show-hide-cols af-dashboard-table-show-hide-cols',
                columnText: function ( dt, idx, title ) {
                    if ( title === '' ){
                        return labels.checkbox_label;
                    }
                    return title;
                }
            },
        ];

        // select items checkbox
        jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
            object.selectUnselectAll( object );
        });

        // create the table
        if ( typeof window.af_datatable_type == 'undefined' || window.af_datatable_type === '' ){
            return;
        }

        // multiselect - status
        if ( jQuery('.af-js-datatable-items-status-types').length ){
            jQuery('.af-js-datatable-items-status-types').multiselect({
                selectAll: true,
                placeholder: jQuery('.af-js-datatable-items-status-types').attr( 'data-placeholder' ),
            });
        }

        // multiselect - target ( for notifications )
        if ( jQuery('.af-js-datatable-items-target-types').length ){
            jQuery('.af-js-datatable-items-target-types').multiselect({
                selectAll: true,
                placeholder: jQuery('.af-js-datatable-items-target-types').attr( 'data-placeholder' ),
            });
        }

        // multiselect - ranks ( affiliates page )
        if ( jQuery( '.af-js-datatable-filter-ranks' ).length ){
            jQuery( '.af-js-datatable-filter-ranks' ).multiselect({
                selectAll: true,
                placeholder: jQuery('.af-js-datatable-filter-ranks').attr( 'data-placeholder' ),
            });
        }

        // multiselect - sources
        if ( jQuery( '.af-js-datatable-items-source-types-referrals' ).length ){
            jQuery( '.af-js-datatable-items-source-types-referrals' ).multiselect({
                selectAll: true,
                placeholder: jQuery('.af-js-datatable-items-source-types-referrals').attr( 'data-placeholder' ),
            });
        }

        switch ( window.af_datatable_type ){
            case 'ranks':
              object.loadTableForRanks( object );
              /// event on custom filter - do reload
              jQuery( '.af-js-datatable-items-status-types' ).on('change', function () {
                   object.tableObject.destroy();
                   object.loadTableForRanks( object );
              });
              // event on custom search - do reload
              jQuery( '.af-js-search-phrase' ).on('keyup', function () {
                   object.tableObject.destroy();
                   object.loadTableForRanks( object );
              });
              break;
            case 'offers':
              object.loadTableForOffers( object );
              /// event on custom filter - do reload
              jQuery( '.af-js-datatable-items-status-types' ).on('change', function () {
                   object.tableObject.destroy();
                   object.loadTableForOffers( object );
              });
              // event on custom search - do reload
              jQuery( '.af-js-search-phrase' ).on('keyup', function () {
                   object.tableObject.destroy();
                   object.loadTableForOffers( object );
              });
              break;
            case 'landing_commissions':
              object.loadTableForLandingCommissions( object );
              /// event on custom filter - do reload
              jQuery( '.af-js-datatable-items-status-types' ).on('change', function () {
                   object.tableObject.destroy();
                   object.loadTableForLandingCommissions( object );
              });
              // event on custom search - do reload
              jQuery( '.af-js-search-phrase' ).on('keyup', function () {
                   object.tableObject.destroy();
                   object.loadTableForLandingCommissions( object );
              });
              break;
            case 'banners':
                object.loadTableForBanners( object );
                // event on custom search - do reload
                jQuery( '.af-js-search-phrase' ).on('keyup', function () {
                     object.tableObject.destroy();
                     object.loadTableForBanners( object );
                });
                break;
            case 'notifications':
                // filter and search bar with button
                object.loadTableForNotifications( object );
                jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                    object.tableObject.destroy();
                    object.loadTableForNotifications( object );
                });
                break;
            case 'affiliates':
                // filter and search bar with button
                object.loadTableForAffiliates( object );
                jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                    object.tableObject.destroy();
                    object.loadTableForAffiliates( object );
                });
                break;
            case 'visits':
                // filter and search bar with button
                object.loadTableForVisits( object );
                jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                    object.tableObject.destroy();
                    object.loadTableForVisits( object );
                });
                break;
            case 'referrals':
                // filter and search bar with button
                object.loadTableForReferrals( object );
                jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                    object.tableObject.destroy();
                    object.loadTableForReferrals( object );
                });
                break;
            case 'payout_setup':
              object.loadTableForPayoutSetup( object );
              break;
            case 'payouts':
                // filter and search bar with button
                object.loadTableForPayouts( object );
                jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                    object.tableObject.destroy();
                    object.loadTableForPayouts( object );
                });
              break;
            case 'payments':
              // filter and search bar with button
              object.loadTableForPayments( object );
              jQuery( '.af-datatable-filter-bttn' ).on( 'click', function(){
                  object.tableObject.destroy();
                  object.loadTableForPayments( object );
              });
              break;
            case 'referrals_for_payment':
              object.loadTableForReferralsForPayment( object );
              break;
            case 'payout_payments':
              object.loadTableForPayoutPayments( object );
              break;
        }
    },
    // end of init

    // loadTableForRanks
    loadTableForRanks: function( object ){
          object.tableObject = new DataTable( object.tableId, {
            ajax           : {
                    type      : "post",
                    url       : decodeURI(ajax_url),
                    data      : {
                               action             : "af_ajax_get_ranks", // ajax method
                               search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                               status             : jQuery('.af-js-datatable-items-status-types').val(),
                    },
                    dataSrc   : 'data'
            },
            //retrieve       : true,
            serverSide     : true,
            dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            drawCallback   : function(){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                  jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                  jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                  // select items checkbox
                  jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                      object.selectUnselectAll( object );
                  });

                  // remove one rank
                  jQuery( '.af-js-remove-one-rank' ).on( 'click', function(){
                      var rankId = jQuery( this ).attr( 'data-id' );
                      afSwal({
                        title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_rank' ),
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                      },
                      function(){
                          jQuery.ajax({
                              type : 'post',
                              url : decodeURI(ajax_url),
                              data : {
                                         action                 : 'af_admin_remove_one_rank',
          															 af_admin_forms_nonce	:	jQuery( '.af-js-ranks-listing-delete-nonce' ).attr( 'data-value'),
                                         id                     :	rankId,
                                     },
                              success: function (response) {
                                  object.tableObject.destroy();
                                  object.loadTableForRanks( object );
                              }
                         });
                     });
                  });
                  // end of remove one rank

                  // remove many ranks
                  if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                    jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                          evt.preventDefault();
                          var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                              return this.value;
                          }).get();
                          if ( checkedVals.length === 0 ){
                              return;
                          }

                          if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                              afSwal({
                                title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_ranks'),
                                text: "",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "OK",
                                closeOnConfirm: true
                              },
                              function(){
                                  var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                      return this.value;
                                  }).get();
                                  var valsToSend = checkedVals.join(",");
                                  jQuery.ajax({
                                          type 			: 'post',
                                          url 			: decodeURI(ajax_url),
                                          data 			: {
                                                     action		              : 'af_admin_remove_many_rank',
                      															 af_admin_forms_nonce	:	jQuery( '.af-js-ranks-listing-delete-nonce' ).attr( 'data-value' ),
                                                     ids			              : valsToSend,
                                          },
                                          success		: function (response) {
                                              object.tableObject.destroy();
                                              object.loadTableForRanks( object );
                                          }
                                  });
                             });
                          }

                    });
                }
                // end of remove many ranks

            },
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            columns        : object.columns,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],//[ 1, "asc" ]
            scrollToTop    : true,
            createdRow: function( row, data, dataIndex ) {
                jQuery( row ).attr( 'onmouseover', "afDhSelector('#rank_"+ data.id +"', 1);" );
                jQuery( row ).attr( 'onmouseout', "afDhSelector('#rank_"+ data.id +"', 0);" );
            },
            stateSave      : true,
            stateSaveCallback: function( settings, data ) {
              jQuery.ajax({
                      type 			: 'post',
                      url 			: decodeURI(ajax_url),
                      data 			: {
                            action     : "af_ajax_datatable_save_state", // ajax method
                            state      : JSON.stringify(data),
                            type       : 'af_datatable_state_for-ranks',
                      },
                      success		: function (response) {
                          return;
                      }
              });
            },
            stateLoadCallback: function(settings) {
                if ( jQuery( '.af-js-datatable-state' ).length ){
                    return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
                }
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
        });
    },
    // end of loadTableForRanks

    // loadTableForOffers
    loadTableForOffers: function( object ){
          object.tableObject = new DataTable( object.tableId, {
            ajax           : {
                    type      : "post",
                    url       : decodeURI(ajax_url),
                    data      : {
                               action             : "af_ajax_get_offers", // ajax method
                               search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                               status             : jQuery('.af-js-datatable-items-status-types').val(),
                    },
                    dataSrc   : 'data'
            },
            //retrieve       : true,
            serverSide     : true,
            dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            drawCallback   : function(){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                  jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                  jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                  // select items checkbox
                  jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                      object.selectUnselectAll( object );
                  });

                  // remove one item
                  jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                      var itemId = jQuery( this ).attr( 'data-id' );
                      afSwal({
                        title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                      },
                      function(){
                          jQuery.ajax({
                              type : 'post',
                              url : decodeURI(ajax_url),
                              data : {
                                         action                 : 'af_ajax_remove_one_offer',// custom
                                         af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                         id                     :	itemId,
                                     },
                              success: function (response) {
                                  object.tableObject.destroy();
                                  object.loadTableForOffers( object );// custom
                              }
                         });
                     });
                  });
                  // end of remove one item

                  // remove many items
                  if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                    jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                          evt.preventDefault();
                          var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                              return this.value;
                          }).get();
                          if ( checkedVals.length === 0 ){
                              return;
                          }
                          if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                              afSwal({
                                title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                                text: "",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "OK",
                                closeOnConfirm: true
                              },
                              function(){
                                  var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                      return this.value;
                                  }).get();
                                  var valsToSend = checkedVals.join(",");
                                  jQuery.ajax({
                                          type 			: 'post',
                                          url 			: decodeURI(ajax_url),
                                          data 			: {
                                                     action		              : 'af_ajax_remove_many_offers',// custom
                                                     af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                     ids			              : valsToSend,
                                          },
                                          success		: function (response) {
                                              object.tableObject.destroy();
                                              object.loadTableForOffers( object );// custom
                                          }
                                  });
                             });
                          }

                    });
                }
                // end of remove many items

            },
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            columns        : object.columns,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],//[ 1, "asc" ]
            scrollToTop    : true,
            createdRow: function( row, data, dataIndex ) {
                jQuery( row ).attr( 'onmouseover', "afDhSelector('#offer_"+ data.id +"', 1);" );// custom
                jQuery( row ).attr( 'onmouseout', "afDhSelector('#offer_"+ data.id +"', 0);" );// custom
            },
            stateSave      : true,
            stateSaveCallback: function( settings, data ) {
              jQuery.ajax({
                      type 			: 'post',
                      url 			: decodeURI(ajax_url),
                      data 			: {
                            action     : "af_ajax_datatable_save_state", // ajax method
                            state      : JSON.stringify(data),
                            type       : 'af_datatable_state_for-offers',
                      },
                      success		: function (response) {
                          return;
                      }
              });
            },
            stateLoadCallback: function(settings) {
                if ( jQuery( '.af-js-datatable-state' ).length ){
                    return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
                }
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
        });
    },
    // end of loadTableForOffers

    // landing commissions
    loadTableForLandingCommissions:  function( object ){
          object.tableObject = new DataTable( object.tableId, {
            ajax           : {
                    type      : "post",
                    url       : decodeURI(ajax_url),
                    data      : {
                               action             : "af_ajax_get_landing_commissions", // ajax method
                               search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                               status             : jQuery('.af-js-datatable-items-status-types').val(),
                    },
                    dataSrc   : 'data'
            },
            //retrieve       : true,
            serverSide     : true,
            dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            drawCallback   : function(){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                  jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                  jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                  // select items checkbox
                  jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                      object.selectUnselectAll( object );
                  });

                  // remove one item
                  jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                      var itemId = jQuery( this ).attr( 'data-id' );
                      afSwal({
                        title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                      },
                      function(){
                          jQuery.ajax({
                              type : 'post',
                              url : decodeURI(ajax_url),
                              data : {
                                         action                 : 'af_ajax_remove_one_landing_commission',// custom
                                         af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                         id                     :	itemId,
                                     },
                              success: function (response) {
                                  object.tableObject.destroy();
                                  object.loadTableForLandingCommissions( object );// custom
                              }
                         });
                     });
                  });
                  // end of remove one item

                  // remove many items
                  if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                    jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                          evt.preventDefault();
                          var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                              return this.value;
                          }).get();
                          if ( checkedVals.length === 0 ){
                              return;
                          }
                          if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                              afSwal({
                                title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                                text: "",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "OK",
                                closeOnConfirm: true
                              },
                              function(){
                                  var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                      return this.value;
                                  }).get();
                                  var valsToSend = checkedVals.join(",");
                                  jQuery.ajax({
                                          type 			: 'post',
                                          url 			: decodeURI(ajax_url),
                                          data 			: {
                                                     action		              : 'af_ajax_remove_many_landing_commissions',// custom
                                                     af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                     ids			              : valsToSend,
                                          },
                                          success		: function (response) {
                                              object.tableObject.destroy();
                                              object.loadTableForLandingCommissions( object );// custom
                                          }
                                  });
                             });
                          }

                    });
                }
                // end of remove many items

            },
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            columns        : object.columns,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],//[ 1, "asc" ]
            scrollToTop    : true,
            createdRow: function( row, data, dataIndex ) {
                jQuery( row ).attr( 'onmouseover', "afDhSelector('#landing_commission_"+ data.id +"', 1);" );// custom
                jQuery( row ).attr( 'onmouseout', "afDhSelector('#landing_commission_"+ data.id +"', 0);" );// custom
            },
            stateSave      : true,
            stateSaveCallback: function( settings, data ) {
              jQuery.ajax({
                      type 			: 'post',
                      url 			: decodeURI(ajax_url),
                      data 			: {
                            action     : "af_ajax_datatable_save_state", // ajax method
                            state      : JSON.stringify(data),
                            type       : 'af_datatable_state_for-landing_commissions',
                      },
                      success		: function (response) {
                          return;
                      }
              });
            },
            stateLoadCallback: function(settings) {
                if ( jQuery( '.af-js-datatable-state' ).length ){
                    return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
                }
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
        });
    },
    // end of landing commissions

    // banners
    loadTableForBanners : function( object ){
        object.tableObject = new DataTable( object.tableId, {
          ajax           : {
                  type      : "post",
                  url       : decodeURI(ajax_url),
                  data      : {
                             action             : "af_ajax_get_banners", // ajax method
                             search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                  },
                  dataSrc   : 'data'
          },
          //retrieve       : true,
          serverSide     : true,
          dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
          lengthChange   : true,
          pageLength     : 25,
          drawCallback   : function(){
                jQuery("body").removeClass("loading"); // remove loading
                jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                // select items checkbox
                jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                    object.selectUnselectAll( object );
                });

                // remove one item
                jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                    var itemId = jQuery( this ).attr( 'data-id' );
                    afSwal({
                      title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(){
                        jQuery.ajax({
                            type : 'post',
                            url : decodeURI(ajax_url),
                            data : {
                                       action                 : 'af_ajax_remove_one_banners',// custom
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                       id                     :	itemId,
                                   },
                            success: function (response) {
                                object.tableObject.destroy();
                                object.loadTableForBanners( object );// custom
                            }
                       });
                   });
                });
                // end of remove one item

                // remove many items
                if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                  jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                        evt.preventDefault();
                        var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        if ( checkedVals.length === 0 ){
                            return;
                        }
                        if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                            afSwal({
                              title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "OK",
                              closeOnConfirm: true
                            },
                            function(){
                                var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                    return this.value;
                                }).get();
                                var valsToSend = checkedVals.join(",");
                                jQuery.ajax({
                                        type 			: 'post',
                                        url 			: decodeURI(ajax_url),
                                        data 			: {
                                                   action		              : 'af_ajax_remove_many_banners',// custom
                                                   af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                   ids			              : valsToSend,
                                        },
                                        success		: function (response) {
                                            object.tableObject.destroy();
                                            object.loadTableForBanners( object );// custom
                                        }
                                });
                           });
                        }

                  });
              }
              // end of remove many items

          },
          buttons        : object.tableButtons,
          language       : object.translatedLabels,
          columns        : object.columns,
          processing     : true,
          orderCellsTop  : true,
          fixedHeader    : false,
          order          : [],//[ 1, "asc" ]
          scrollToTop    : true,
          createdRow: function( row, data, dataIndex ) {
              jQuery( row ).attr( 'onmouseover', "afDhSelector('#banner_"+ data.id +"', 1);" );// custom
              jQuery( row ).attr( 'onmouseout', "afDhSelector('#banner_"+ data.id +"', 0);" );// custom
          },
          stateSave      : true,
          stateSaveCallback: function( settings, data ) {
            jQuery.ajax({
                    type 			: 'post',
                    url 			: decodeURI(ajax_url),
                    data 			: {
                          action     : "af_ajax_datatable_save_state", // ajax method
                          state      : JSON.stringify(data),
                          type       : 'af_datatable_state_for-banners',
                    },
                    success		: function (response) {
                        return;
                    }
            });
          },
          stateLoadCallback: function(settings) {
              if ( jQuery( '.af-js-datatable-state' ).length ){
                  return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
              }
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          },
      });
    },
    // end of banners

    // notifications
    loadTableForNotifications : function( object ){
        object.tableObject = new DataTable( object.tableId, {
          ajax           : {
                  type      : "post",
                  url       : decodeURI(ajax_url),
                  data      : {
                             action             : "af_ajax_get_notifications", // ajax method
                             search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                             target_types       : jQuery( '.af-js-datatable-items-target-types' ).val(),
                  },
                  dataSrc   : 'data'
          },
          //retrieve       : true,
          serverSide     : true,
          dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
          lengthChange   : true,
          pageLength     : 25,
          drawCallback   : function(){
                jQuery("body").removeClass("loading"); // remove loading
                jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                // select items checkbox
                jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                    object.selectUnselectAll( object );
                });

                // remove one item
                jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                    var itemId = jQuery( this ).attr( 'data-id' );
                    afSwal({
                      title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(){
                        jQuery.ajax({
                            type : 'post',
                            url : decodeURI(ajax_url),
                            data : {
                                       action                 : 'af_ajax_remove_one_notifications',// custom
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                       id                     :	itemId,
                                   },
                            success: function (response) {
                                object.tableObject.destroy();
                                object.loadTableForNotifications( object );// custom
                            }
                       });
                   });
                });
                // end of remove one item

                // remove many items
                if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                  jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                        evt.preventDefault();
                        var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        if ( checkedVals.length === 0 ){
                            return;
                        }

                        if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                            afSwal({
                              title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "OK",
                              closeOnConfirm: true
                            },
                            function(){
                                var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                    return this.value;
                                }).get();
                                var valsToSend = checkedVals.join(",");
                                jQuery.ajax({
                                        type 			: 'post',
                                        url 			: decodeURI(ajax_url),
                                        data 			: {
                                                   action		              : 'af_ajax_remove_many_notifications',// custom
                                                   af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                   ids			              : valsToSend,
                                        },
                                        success		: function (response) {
                                            object.tableObject.destroy();
                                            object.loadTableForNotifications( object );// custom
                                        }
                                });
                           });
                        }

                  });
              }
              // end of remove many items

              // send test notification
              if ( jQuery( '.af-js-notifications-fire-notification-test' ).length > 0 ){
                  jQuery( '.af-js-notifications-fire-notification-test' ).on( 'click', function(){
                      var notificationId = jQuery( this ).attr( 'data-notification_id' );
                      jQuery.ajax({
                          type 			: 'post',
                          url 			: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php',
                          data 			: {
                                     action : 'af_ajax_notification_send_test_email',
                                     af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                     id			: notificationId
                          },
                          success		: function (data) {
                              jQuery(data).hide().appendTo('body').fadeIn('normal');
                          }
                     });
                  });
              }
              //end of send test notifications

              // modify status
              if ( jQuery( '.af-js-admin-notification-list-on-off' ).length > 0 ){
                  jQuery( '.af-js-admin-notification-list-on-off' ).on( 'change', function(){
                        var notificationId = jQuery( this ).attr( 'data-id' );
                        jQuery.ajax({
                            type 			: 'post',
                            url 			: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php',
                            data 			: {
                                       action : 'af_ajax_notification_modify_status',
                                       id			: notificationId,
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                       status : jQuery( this ).is(':checked') ? 1 : 0,
                            },
                            success		: function (data) {
                                object.tableObject.destroy();
                                object.loadTableForNotifications( object );// custom
                            }
                       });

                  });
              }
              // end of modify status

          },
          buttons        : object.tableButtons,
          language       : object.translatedLabels,
          columns        : object.columns,
          processing     : true,
          orderCellsTop  : true,
          fixedHeader    : false,
          order          : [],//[ 1, "asc" ]
          scrollToTop    : true,
          createdRow: function( row, data, dataIndex ) {
              jQuery( row ).attr( 'onmouseover', "afDhSelector('#notification_"+ data.id +"', 1);" );// custom
              jQuery( row ).attr( 'onmouseout', "afDhSelector('#notification_"+ data.id +"', 0);" );// custom
          },
          stateSave      : true,
          stateSaveCallback: function( settings, data ) {
            jQuery.ajax({
                    type 			: 'post',
                    url 			: decodeURI(ajax_url),
                    data 			: {
                          action     : "af_ajax_datatable_save_state", // ajax method
                          state      : JSON.stringify(data),
                          type       : 'af_datatable_state_for-notifications',
                    },
                    success		: function (response) {
                        return;
                    }
            });
          },
          stateLoadCallback: function(settings) {
              if ( jQuery( '.af-js-datatable-state' ).length ){
                  return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
              }
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          },
      });
    },
    // end of notifications

    // affiliates
    loadTableForAffiliates : function( object ){
        object.tableObject = new DataTable( object.tableId, {
          ajax           : {
                  type      : "post",
                  url       : decodeURI(ajax_url),
                  data      : {
                             action             : "af_ajax_get_affiliates", // ajax method
                             search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                             ranks              : jQuery( '.af-js-datatable-filter-ranks' ).val(),
                  },
                  dataSrc   : 'data'
          },
          //retrieve       : true,
          serverSide     : true,
          dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
          lengthChange   : true,
          pageLength     : 25,
          drawCallback   : function( response ){
                // ready for export
                jQuery( '.js-af-export-csv' ).attr( 'data-filters', response.json.params );

                jQuery("body").removeClass("loading"); // remove loading
                jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                // select items checkbox
                jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                    object.selectUnselectAll( object );
                });

                // copy to clipboard
                if ( jQuery( '.af-js-admin-affiliate-table-copy-clipboard' ).length > 0 ){
                    jQuery( '.af-js-admin-affiliate-table-copy-clipboard' ).on('click', function(){
                        var cpTxt = jQuery( this ).attr('data-link');
                        navigator.clipboard.writeText(cpTxt);
                        afSwal({
                          title: jQuery( this ).attr( 'data-message' ),
                          text: "",
                          type: "success",
                          showConfirmButton: false,
                          confirmButtonClass: "btn-success",
                          confirmButtonText: "OK",
                          timer: 1000
                        });
                    });
                }

                // remove one item
                jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                    var itemId = jQuery( this ).attr( 'data-id' );
                    afSwal({
                      title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(){
                        jQuery.ajax({
                            type : 'post',
                            url : decodeURI(ajax_url),
                            data : {
                                       action                 : 'af_ajax_remove_one_affiliate',// custom
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                       id                     :	itemId,
                                   },
                            success: function (response) {
                                object.tableObject.destroy();
                                object.loadTableForAffiliates( object );// custom
                            }
                       });
                   });
                });
                // end of remove one item

                // remove many items
                if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                  jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                        evt.preventDefault();
                        var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        if ( checkedVals.length === 0 ){
                            return;
                        }

                        if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                            afSwal({
                              title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "OK",
                              closeOnConfirm: true
                            },
                            function(){
                                var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                    return this.value;
                                }).get();
                                var valsToSend = checkedVals.join(",");
                                jQuery.ajax({
                                        type 			: 'post',
                                        url 			: decodeURI(ajax_url),
                                        data 			: {
                                                   action		              : 'af_ajax_remove_many_affiliates',// custom
                                                   af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                   ids			              : valsToSend,
                                        },
                                        success		: function (response) {
                                            object.tableObject.destroy();
                                            object.loadTableForAffiliates( object );// custom
                                        }
                                });
                           });
                        } else if ( jQuery('.af-js-bulk-action-select').val() === 'update_rank' ){
                            var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                return this.value;
                            }).get();
                            var valsToSend = checkedVals.join(",");
                            jQuery.ajax({
                                    type 			: 'post',
                                    url 			: decodeURI(ajax_url),
                                    data 			: {
                                               action		              : 'af_ajax_update_ranks_for_affiliates',// custom
                                               af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                               ids			              : valsToSend,
                                    },
                                    success		: function (response) {
                                        object.tableObject.destroy();
                                        object.loadTableForAffiliates( object );// custom
                                    }
                            });
                        }

                  });
              }
              // end of remove many items

              // approve email
              if ( jQuery('.af-js-datatable-affiliate-approve-email').length ){
                  jQuery( '.af-js-datatable-affiliate-approve-email' ).on( 'click', function(evt){
                        jQuery.ajax({
                              type : 'post',
                              url : decodeURI(ajax_url),
                              data : {
                                         action: 'af_approve_user_email',
                                         uid: jQuery(this).attr('data-uid'),
                                     },
                              success: function (response) {
                                  object.tableObject.destroy();
                                  object.loadTableForAffiliates( object );// custom
                              }
                         });
                  });
              }
              // end of approve email

              // approve affiliate
              if ( jQuery('.af-js-datatable-affiliates-approve-user').length ){
                  jQuery( '.af-js-datatable-affiliates-approve-user' ).on( 'click', function(evt){
                      jQuery.ajax({
                          type: 'post',
                          url: decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
                          data: {
                                 action: 'af_approve_affiliate',
                                 uid: jQuery(this).attr('data-uid'),
                          },
                          success: function () {
                              object.tableObject.destroy();
                              object.loadTableForAffiliates( object );// custom
                          }
                      });
                  });
                }
                // end of approve affiliate

                // direct email
                afAdminSendEmail.init({
                    popupAjax		       : 'af_admin_send_email_popup',
                  	sendEmailAjax	     : 'af_admin_do_send_email',
                  	ajaxPath           : decodeURI(window.ajax_url),
                    openPopupSelector  : '.af-admin-do-send-email-via-af',
                    sendEmailSelector  : '#af_admin_send_mail_submit_bttn',
                    fromSelector       : '#af_admin_send_mail_from',
                    toSelector         : '#af_admin_send_mail_to',
                    subjectSelector    : '#af_admin_send_mail_subject',
                    messageSelector    : '#af_admin_send_mail_content',
                    closePopupBttn     : '#af_send_email_via_admin_close_popup_bttn',
                    popupWrapp         : '#af_admin_popup_box',
                });
                // end of direct email

              // tipso
              if( jQuery('.af-js-tipso-item').length ){
                  jQuery('.af-js-tipso-item').tipso({
                      position: 'top',
                      background: '#555',
                      color: '#fff',
                      useTitle: false,
                  });
              }
              // tipso

          },
          buttons        : object.tableButtons,
          language       : object.translatedLabels,
          columns        : object.columns,
          processing     : true,
          orderCellsTop  : true,
          fixedHeader    : false,
          order          : [],//[ 1, "asc" ]
          scrollToTop    : true,
          stateSave      : true,
          stateSaveCallback: function( settings, data ) {
            jQuery.ajax({
                    type 			: 'post',
                    url 			: decodeURI(ajax_url),
                    data 			: {
                          action     : "af_ajax_datatable_save_state", // ajax method
                          state      : JSON.stringify(data),
                          type       : 'af_datatable_state_for-affiliates',
                    },
                    success		: function (response) {
                        return;
                    }
            });
          },
          stateLoadCallback: function(settings) {
              if ( jQuery( '.af-js-datatable-state' ).length ){
                  return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
              }
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          },

          createdRow: function( row, data, dataIndex ) {
              jQuery( row ).attr( 'onmouseover', "afDhSelector('#affiliate_"+ data.id.value +"', 1);" );// custom
              jQuery( row ).attr( 'onmouseout', "afDhSelector('#affiliate_"+ data.id.value +"', 0);" );// custom
          }
      });
    },
    // end of affiliates

    // visits
    loadTableForVisits : function( object ){
        object.tableObject = new DataTable( object.tableId, {
          ajax           : {
                  type      : "post",
                  url       : decodeURI(ajax_url),
                  data      : {
                             action             : "af_ajax_get_visits", // ajax method
                             search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                             status_in          : jQuery( '.af-js-datatable-items-status-types' ).val(),
                             start_time         : jQuery('[name=udf]').val(),
                             end_time           : jQuery('[name=udu]').val(),
                  },
                  dataSrc   : 'data'
          },
          //retrieve       : true,
          serverSide     : true,
          dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', //
          lengthChange   : true,
          pageLength     : 25,
          drawCallback   : function( response ){
                // ready for export
                jQuery( '.js-af-export-csv' ).attr( 'data-filters', response.json.params );

                jQuery("body").removeClass("loading"); // remove loading
                jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                // select items checkbox
                jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                    object.selectUnselectAll( object );
                });

                // remove one item
                jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                    var itemId = jQuery( this ).attr( 'data-id' );
                    afSwal({
                      title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(){
                        jQuery.ajax({
                            type : 'post',
                            url : decodeURI(ajax_url),
                            data : {
                                       action                 : 'af_ajax_remove_one_visit',// custom
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                       id                     :	itemId,
                                   },
                            success: function (response) {
                                object.tableObject.destroy();
                                object.loadTableForVisits( object );// custom
                            }
                       });
                   });
                });
                // end of remove one item

                // remove many items
                if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                  jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                        evt.preventDefault();
                        var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        if ( checkedVals.length === 0 ){
                            return;
                        }
                        if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                            afSwal({
                              title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "OK",
                              closeOnConfirm: true
                            },
                            function(){
                                var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                    return this.value;
                                }).get();
                                var valsToSend = checkedVals.join(",");
                                jQuery.ajax({
                                        type 			: 'post',
                                        url 			: decodeURI(ajax_url),
                                        data 			: {
                                                   action		              : 'af_ajax_remove_many_visits',// custom
                                                   af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                   ids			              : valsToSend,
                                        },
                                        success		: function (response) {
                                            object.tableObject.destroy();
                                            object.loadTableForVisits( object );// custom
                                        }
                                });
                           });
                        }
                  });
              }
              // end of remove many items

          },
          buttons        : object.tableButtons,
          language       : object.translatedLabels,
          columns        : object.columns,
          processing     : true,
          orderCellsTop  : true,
          fixedHeader    : false,
          order          : [],
          scrollToTop    : true,
          createdRow: function( row, data, dataIndex ) {
              jQuery( row ).attr( 'onmouseover', "afDhSelector('#visit_"+ data.id +"', 1);" );// custom
              jQuery( row ).attr( 'onmouseout', "afDhSelector('#visit_"+ data.id +"', 0);" );// custom
          },
          stateSave      : true,
          stateSaveCallback: function( settings, data ) {
            jQuery.ajax({
                    type 			: 'post',
                    url 			: decodeURI(ajax_url),
                    data 			: {
                          action     : "af_ajax_datatable_save_state", // ajax method
                          state      : JSON.stringify(data),
                          type       : 'af_datatable_state_for-visits',
                    },
                    success		: function (response) {
                        return;
                    }
            });
          },
          stateLoadCallback: function(settings) {
              if ( jQuery( '.af-js-datatable-state' ).length ){
                  return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
              }
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          },
      });
    },
    // end of visits

    // referrals
    loadTableForReferrals : function( object ){
        object.tableObject = new DataTable( object.tableId, {
          ajax           : {
                  type      : "post",
                  url       : decodeURI(ajax_url),
                  data      : {
                             action             : "af_ajax_get_referrals", // ajax method
                             search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                             status_in          : jQuery( '.af-js-datatable-items-status-types' ).val(),
                             source             : jQuery('.af-js-datatable-items-source-types-referrals').val(),
                             start_time         : jQuery('[name=udf]').val(),
                             end_time           : jQuery('[name=udu]').val(),
                  },
                  dataSrc   : 'data'
          },
          //retrieve       : true,
          serverSide     : true,
          dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', //
          lengthChange   : true,
          pageLength     : 25,
          drawCallback   : function( response ){
                // ready for export
                jQuery( '.js-af-export-csv' ).attr( 'data-filters', response.json.params );

                jQuery("body").removeClass("loading"); // remove loading
                jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                // select items checkbox
                jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                    object.selectUnselectAll( object );
                });

                // remove one item
                jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                    var itemId = jQuery( this ).attr( 'data-id' );
                    afSwal({
                      title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                      text: "",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "OK",
                      closeOnConfirm: true
                    },
                    function(){
                        jQuery.ajax({
                            type : 'post',
                            url : decodeURI(ajax_url),
                            data : {
                                       action                 : 'af_ajax_remove_one_referral',// custom
                                       af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                       id                     :	itemId,
                                   },
                            success: function (response) {
                                object.tableObject.destroy();
                                object.loadTableForReferrals( object );// custom
                            }
                       });
                   });
                });
                // end of remove one item

                // remove many items
                if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                  jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                        evt.preventDefault();
                        var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        if ( checkedVals.length === 0 ){
                            return;
                        }
                        if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                            afSwal({
                              title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                              text: "",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "OK",
                              closeOnConfirm: true
                            },
                            function(){
                                var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                    return this.value;
                                }).get();
                                var valsToSend = checkedVals.join(",");
                                jQuery.ajax({
                                        type 			: 'post',
                                        url 			: decodeURI(ajax_url),
                                        data 			: {
                                                   action		              : 'af_ajax_remove_many_referrals',// custom
                                                   af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                   ids			              : valsToSend,
                                        },
                                        success		: function (response) {
                                            object.tableObject.destroy();
                                            object.loadTableForReferrals( object );// custom
                                        }
                                });
                           });
                        }
                  });
              }
              // end of remove many items

              // mark as bttns
              if ( jQuery( '.af-js-referral-list-change-status' ).length ){
                  jQuery( '.af-js-referral-list-change-status' ).on('click', function(){
                      var newValue = jQuery(this).attr('data-value');
                      jQuery.ajax({
                              type 			: 'post',
                              url 			: decodeURI(ajax_url),
                              data 			: {
                                         action		              : 'af_ajax_change_status_referral',// custom
                                         af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                         change_status			    : newValue,
                              },
                              success		: function (response) {
                                  object.tableObject.destroy();
                                  object.loadTableForReferrals( object );// custom
                              }
                      });
                  });
              }
          },
          buttons        : object.tableButtons,
          language       : object.translatedLabels,
          columns        : object.columns,
          processing     : true,
          orderCellsTop  : true,
          fixedHeader    : false,
          order          : [],
          scrollToTop    : true,
          createdRow: function( row, data, dataIndex ) {
              jQuery( row ).attr( 'onmouseover', "afDhSelector('#referral_"+ data.id.value +"', 1);" );// custom
              jQuery( row ).attr( 'onmouseout', "afDhSelector('#referral_"+ data.id.value +"', 0);" );// custom
          },
          stateSave      : true,
          stateSaveCallback: function( settings, data ) {
            jQuery.ajax({
                    type 			: 'post',
                    url 			: decodeURI(ajax_url),
                    data 			: {
                          action     : "af_ajax_datatable_save_state", // ajax method
                          state      : JSON.stringify(data),
                          type       : 'af_datatable_state_for-referrals',
                    },
                    success		: function (response) {
                        return;
                    }
            });
          },
          stateLoadCallback: function(settings) {
              if ( jQuery( '.af-js-datatable-state' ).length ){
                  return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
              }
              return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
          },
      });
    },
    // end of referrals

    loadTableForPayoutSetup         : function( object ){
        object.tableObject = new DataTable('.af-js-list-payments-for-payouts', {
            retrieve       : true,
            serverSide     : false,
            dom            : 'PBfrtipl',//'<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],
            scrollToTop    : true,
            drawCallback   : function( response ){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' ).addClass( 'display af-dashboard-table');
            }
        });
    },

    loadTableForPayouts               : function( object ){
      object.tableObject = new DataTable( object.tableId, {
           ajax           : {
                   type      : "post",
                   url       : decodeURI(ajax_url),
                   data      : {
                              action             : "af_ajax_get_payouts", // ajax method
                              search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                              status_in          : jQuery( '.af-js-datatable-items-status-types' ).val(),
                              start_time         : jQuery('[name=udf]').val(),
                              end_time           : jQuery('[name=udu]').val(),
                   },
                   dataSrc   : 'data'
           },
           //retrieve       : true,
           serverSide     : true,
           dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', //
           lengthChange   : true,
           pageLength     : 25,
           drawCallback   : function( response ){

                 jQuery("body").removeClass("loading"); // remove loading
                 jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                 jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                 jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                 // select items checkbox
                 jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                     object.selectUnselectAll( object );
                 });

                 // remove one item
                 jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                     var itemId = jQuery( this ).attr( 'data-id' );
                     afSwal({
                       title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                       text: "",
                       type: "warning",
                       showCancelButton: true,
                       confirmButtonClass: "btn-danger",
                       confirmButtonText: "OK",
                       closeOnConfirm: true
                     },
                     function(){
                         jQuery.ajax({
                             type : 'post',
                             url : decodeURI(ajax_url),
                             data : {
                                        action                 : 'af_ajax_remove_one_payout',// custom
                                        af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                        id                     :	itemId,
                                    },
                             success: function (response) {
                                 object.tableObject.destroy();
                                 object.loadTableForPayouts( object );// custom
                             }
                        });
                    });
                 });
                 // end of remove one item

                 // remove many items
                 if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                   jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                         evt.preventDefault();
                         var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                             return this.value;
                         }).get();
                         if ( checkedVals.length === 0 ){
                             return;
                         }
                         if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                             afSwal({
                               title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                               text: "",
                               type: "warning",
                               showCancelButton: true,
                               confirmButtonClass: "btn-danger",
                               confirmButtonText: "OK",
                               closeOnConfirm: true
                             },
                             function(){
                                 var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                     return this.value;
                                 }).get();
                                 var valsToSend = checkedVals.join(",");
                                 jQuery.ajax({
                                         type 			: 'post',
                                         url 			: decodeURI(ajax_url),
                                         data 			: {
                                                    action		              : 'af_ajax_remove_many_payouts',// custom
                                                    af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                    ids			              : valsToSend,
                                         },
                                         success		: function (response) {
                                             object.tableObject.destroy();
                                             object.loadTableForPayouts( object );// custom
                                         }
                                 });
                            });
                         }
                   });
               }
               // end of remove many items

               // generate CSV file
               if ( jQuery( '.af-js-payouts-generate-csv-for-payout' ).length ){

                   jQuery( '.af-js-payouts-generate-csv-for-payout' ).on('click', function(){
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
                                  jQuery( '.af-js-payouts-csv-file-for-payout-' + payoutID).removeClass('af-display-none').addClass('af-display-block')
                                  jQuery( '.af-js-payouts-csv-file-for-payout-' + payoutID).attr( 'href', response );
                               }
                       });
                   });
               }
               // end of generate CSV file
           },
           buttons        : object.tableButtons,
           language       : object.translatedLabels,
           columns        : object.columns,
           processing     : true,
           orderCellsTop  : true,
           fixedHeader    : false,
           order          : [],
           scrollToTop    : true,
           createdRow: function( row, data, dataIndex ) {},
           stateSave      : true,
           stateSaveCallback: function( settings, data ) {
             jQuery.ajax({
                     type 			: 'post',
                     url 			: decodeURI(ajax_url),
                     data 			: {
                           action     : "af_ajax_datatable_save_state", // ajax method
                           state      : JSON.stringify(data),
                           type       : 'af_datatable_state_for-payouts',
                     },
                     success		: function (response) {
                         return;
                     }
             });
           },
           stateLoadCallback: function(settings) {
               if ( jQuery( '.af-js-datatable-state' ).length ){
                   return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
               }
               return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
           },
       });
    },

    loadTableForPayments         : function( object ){
      object.tableObject = new DataTable( object.tableId, {
           ajax           : {
                   type      : "post",
                   url       : decodeURI(ajax_url),
                   data      : {
                              action             : "af_ajax_get_payments", // ajax method
                              search_phrase      : jQuery('.af-js-search-phrase' ).val(), // extra param for search
                              status_in          : jQuery( '.af-js-datatable-items-status-types' ).val(),
                              start_time         : jQuery('[name=udf]').val(),
                              end_time           : jQuery('[name=udu]').val(),
                              payout_id          : jQuery('.af-js-payout-id').val()
                   },
                   dataSrc   : 'data'
           },
           //retrieve       : true,
           serverSide     : true,
           dom            : '<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', //
           lengthChange   : true,
           pageLength     : 300,
           drawCallback   : function( response ){

                 jQuery("body").removeClass("loading"); // remove loading
                 jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' );
                 jQuery( '.af-js-select-all-checkboxes' ).attr( 'checked', false );
                 jQuery( '.af-datatable-actions-wrapp' ).html( jQuery('.af-datatable-actions-wrapp-copy').html() );

                 // select items checkbox
                 jQuery( '.af-js-select-all-checkboxes' ).on('click', function(){
                     object.selectUnselectAll( object );
                 });

                 // remove one item
                 jQuery( '.af-js-remove-one-item' ).on( 'click', function(){
                     var itemId = jQuery( this ).attr( 'data-id' );
                     afSwal({
                       title: jQuery( '.af-js-messages-for-datatable' ).attr( 'data-remove_one_item' ),
                       text: "",
                       type: "warning",
                       showCancelButton: true,
                       confirmButtonClass: "btn-danger",
                       confirmButtonText: "OK",
                       closeOnConfirm: true
                     },
                     function(){
                         jQuery.ajax({
                             type : 'post',
                             url : decodeURI(ajax_url),
                             data : {
                                        action                 : 'af_ajax_remove_one_payment',// custom
                                        af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value'),
                                        id                     :	itemId,
                                    },
                             success: function (response) {
                                 object.tableObject.destroy();
                                 object.loadTableForPayments( object );// custom
                             }
                        });
                    });
                 });
                 // end of remove one item

                 // remove many items
                 if ( jQuery( '.af-js-items-apply-bttn' ).length ){
                   jQuery( '.af-js-items-apply-bttn' ).on( 'click', function(evt){
                         evt.preventDefault();
                         var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                             return this.value;
                         }).get();
                         if ( checkedVals.length === 0 ){
                             return;
                         }
                         if ( jQuery('.af-js-bulk-action-select').val() === 'remove' ){
                             afSwal({
                               title: jQuery('.af-js-messages-for-datatable').attr('data-remove_many_items'),
                               text: "",
                               type: "warning",
                               showCancelButton: true,
                               confirmButtonClass: "btn-danger",
                               confirmButtonText: "OK",
                               closeOnConfirm: true
                             },
                             function(){
                                 var checkedVals = jQuery('.af-js-table-select-item:checkbox:checked').map(function() {
                                     return this.value;
                                 }).get();
                                 var valsToSend = checkedVals.join(",");
                                 jQuery.ajax({
                                         type 			: 'post',
                                         url 			: decodeURI(ajax_url),
                                         data 			: {
                                                    action		              : 'af_ajax_remove_many_payments',// custom
                                                    af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                    ids			              : valsToSend,
                                         },
                                         success		: function (response) {
                                             object.tableObject.destroy();
                                             object.loadTableForPayments( object );// custom
                                         }
                                 });
                            });
                         }
                   });
               }
               // end of remove many items

           },
           buttons        : object.tableButtons,
           language       : object.translatedLabels,
           columns        : object.columns,
           processing     : true,
           orderCellsTop  : true,
           fixedHeader    : false,
           order          : [],
           scrollToTop    : true,
           createdRow: function( row, data, dataIndex ) {},
           stateSave      : true,
           stateSaveCallback: function( settings, data ) {
             jQuery.ajax({
                     type 			: 'post',
                     url 			: decodeURI(ajax_url),
                     data 			: {
                           action     : "af_ajax_datatable_save_state", // ajax method
                           state      : JSON.stringify(data),
                           type       : 'af_datatable_state_for-payments',
                     },
                     success		: function (response) {
                         return;
                     }
             });
           },
           stateLoadCallback: function(settings) {
               if ( jQuery( '.af-js-datatable-state' ).length ){
                   return JSON.parse( jQuery( '.af-js-datatable-state' ).attr( 'data-value' ) );
               }
               return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
           },
       });
    },

    loadTableForReferralsForPayment         : function( object ){
        object.tableObject = new DataTable('.af-js-list-payments-for-payouts', {
            retrieve       : true,
            serverSide     : false,
            dom            : 'PBfrtipl',//'<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],
            scrollToTop    : true,
            drawCallback   : function( response ){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' ).addClass( 'display af-dashboard-table');
            }
        });
    },

    loadTableForPayoutPayments         : function( object ){
        object.tableObject = new DataTable('.af-js-list-payments-for-payouts', {
            retrieve       : true,
            serverSide     : false,
            dom            : 'PBfrtipl',//'<"af-datatable-top"<"af-datatable-actions-wrapp">BP><"af-datatable-wrapp"rt>ipl', // '<"af-datatable-top"<"af-datatable-actions-wrapp">BPf>r<"af-datatable-wrapp"t>ipl'
            lengthChange   : true,
            pageLength     : 25,
            buttons        : object.tableButtons,
            language       : object.translatedLabels,
            processing     : true,
            orderCellsTop  : true,
            fixedHeader    : false,
            order          : [],
            scrollToTop    : true,
            drawCallback   : function( response ){
                  jQuery("body").removeClass("loading"); // remove loading
                  jQuery( '#af-dashboard-table' ).removeClass( 'af-display-none' ).addClass( 'display af-dashboard-table');

                  // change one status
                  if ( jQuery( '.af-js-payout-change-status-for-payment').length ){
                      jQuery( '.af-js-payout-change-status-for-payment').on( 'click', function(){
                          var status = jQuery( this ).attr('data-status');
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
                  // end of change one status

                  // change all statuses for payout payments
                  if ( jQuery( '.af-js-payout-change-status-all-payments').length ){
                      jQuery( '.af-js-payout-change-status-all-payments').on( 'click', function(){
                          var status = jQuery( this ).attr('data-status');
                          var payoutId = jQuery( this ).attr('data-id');
                          jQuery.ajax({
                                  type 			: 'post',
                                  url 			: decodeURI(ajax_url),
                                  data 			: {
                                             action		              : 'af_ajax_payout_all_payments_change_status',// custom
                                             af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                             id			                : payoutId,
                                             status                 : status
                                  },
                                  success		: function (response) {
                                      location.reload();
                                  }
                          });
                      });
                  }
                  // end of change all statuses for payout payments

                  // delete one payment
                  if ( jQuery( '.af-js-payout-delete-payment' ).length ){
                      jQuery( '.af-js-payout-delete-payment' ).on( 'click', function(){
                          afSwal({
                            title: jQuery('.af-js-messages-for-datatable').attr('data-remove_one_item'),
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                          },
                          function(){
                              var paymentId = jQuery( this ).attr('data-id');
                              jQuery.ajax({
                                      type 			: 'post',
                                      url 			: decodeURI(ajax_url),
                                      data 			: {
                                                 action		              : 'af_ajax_remove_one_payment',// custom
                                                 af_admin_forms_nonce	:	jQuery( '.af-js-datatable-listing-delete-nonce' ).attr( 'data-value' ),
                                                 id			                : paymentId,
                                      },
                                      success		: function (response) {
                                          location.reload();
                                      }
                              });
                         });
                      });
                  }
                  // delete one payment

            }
        });
    },

    selectUnselectAll     : function(){
        let doSelect = jQuery( '.af-js-select-all-checkboxes' ).is(':checked');
        if ( doSelect ){
            jQuery( '.af-js-table-select-item' ).each( function(){
                jQuery( this ).attr( 'checked', true );
            });
        } else {
            jQuery( '.af-js-table-select-item' ).each( function(){
                jQuery( this ).attr( 'checked', false );
            });
        }
    }
};

jQuery( window ).on('load', function(){

    AfDataTable.init([]);

});
