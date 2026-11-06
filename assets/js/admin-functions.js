/*
 *Open Affiliates - Main Backend JS Functions
 */
"use strict";
function afDeleteFromTable(i, t, h, f){
	var m = window.af_messages['general_delete'] + t + "?";
 	var c = confirm(m);
	if (c){
		jQuery(h).val(i);
		jQuery(f).submit();
	}
}

function afSelectAllCheckboxes(c, t){
	if (jQuery(c).is(':checked')){
		jQuery(t).attr('checked', 'checked');
	} else {
		jQuery(t).removeAttr('checked');
	}
}

function afDhSelector(t, v){
	if (v){
		var d = 'visible';
	} else {
		var d = 'hidden';
	}
	jQuery(t).css('visibility', d);
}

function afDeleteBannerConfirm(i){
	var c = confirm("Delete This Banner?");
	if (c){
		jQuery('#delete_banner_id').val(i);
		jQuery('#form_banners').submit();
	}
}

function afDeleteNotificationConfirm(i){
	var c = confirm("Delete This Notification?");
	if (c){
		jQuery('#delete_notification_id').val(i);
		jQuery('#form_notification').submit();
	}
}

function openMediaUp(target){
    //If the uploader object has already been created, reopen the dialog
  var custom_uploader;
  if (custom_uploader) {
      custom_uploader.open();
      return;
  }
  //Extend the wp.media object
  custom_uploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
          text: 'Choose Image'
      },
      multiple: false
  });
  //When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      jQuery(target).val(attachment.url);
  });
  //Open the uploader dialog
  custom_uploader.open();
}

function afRegisterFields(v){
	jQuery('#af-register-field-values').fadeOut(200);
	jQuery('#af-register-field-plain-text').fadeOut(200);
	jQuery('#af-register-field-conditional-text').fadeOut(200);
	if (v=='select' || v=='checkbox' || v=='radio' || v=='multi_select'){
		jQuery('#af-register-field-values').fadeIn(200);
	} else if (v=='plain_text'){
		jQuery('#af-register-field-plain-text').fadeIn(200);
	} else if (v=='conditional_text'){
		jQuery('#af-register-field-conditional-text').fadeIn(200);
	}
}

function afAddNewRegisterFieldValue(){
	var s = '<div class="af-custom-field-item-wrapp af-custom-field-item-wrapp-st">';
	s += '<input type="text" name="values[]" value=""/> ';
	s += '<i class="fa-af fa-remove-af af-js-register-fields-add-edit-remove"></i>';
	s += '<i class="fa-af fa-arrows-af"></i>';
	s += '</div>';
	jQuery('.af-register-the-values').append(s);
}

function afCheckAndH(from, target){
	if ( jQuery(from).is(":checked") ){
			jQuery(target).val(1);
	}	else {
		jQuery(target).val(0);
	}
}

function checkAndH(id, target){
	if(jQuery(id).is(':checked')){
		jQuery(target).val(1);
	}else{
		jQuery(target).val(0);
	}
}

function afRegisterPreview(){
   	jQuery.ajax({
        type : 'post',
        url : window.af_url + '/wp-admin/admin-ajax.php',
        data : {
                   action: 'af_register_preview_ajax',
                   template: jQuery('#af_register_template').val(),
                   custom_css: jQuery('#af_register_custom_css').val(),
               },
        success: function (response) {
        	jQuery('#register_preview').fadeOut(200, function(){
        		jQuery(this).html(response);
        		jQuery(this).fadeIn(400);
        	});
        }
   });
}

function afLoginPreview(){
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "af_login_form_preview",
                   remember: jQuery('#af_login_remember_me').val(),
                   register_link: jQuery('#af_login_register').val(),
                   pass_lost: jQuery('#af_login_pass_lost').val(),
                   css: jQuery('#af_login_custom_css').val(),
                   template: jQuery('#af_login_template').val(),
                   af_login_show_recaptcha: jQuery('#af_login_show_recaptcha').val(),
               },
        success: function (d) {
        	jQuery('#af-preview-login').fadeOut(200, function(){
        		jQuery(this).html(d);
        		jQuery(this).fadeIn(400);
        	});
        }
   });
}

function afAddNewAchieveRule(){

	var t = jQuery('#achieve_type').val();
	var v = jQuery('#achieve_value').val();
	var print = '';

	if (t==-1 || t == null || t == ''){return;}

	if (jQuery('#achieve_relation_div').css('display')=='none'){
		jQuery('#achieve_relation_div').css('display', 'block');
	}

	var str = jQuery('#achieve_type_value').val();
	if (str==''){
		var n = 1;
		var obj = {i: n, type_1: t, value_1: v};
	} else {
		var obj = JSON.parse(str);
		obj.i++;
		var n = obj.i;
		obj["type_"+obj.i] = jQuery('#achieve_type').val();
		obj["value_"+obj.i] = jQuery('#achieve_value').val();
		obj["relation_"+obj.i] = jQuery('#achieve_relation').val();
		print += '<div class="achieve-item-relation">' + obj["relation_"+obj.i] + '</div>';
	}
	var str = JSON.stringify(obj);
	jQuery('#achieve_type_value').val(str);

	var achieve_type = jQuery("#achieve_type option[value='"+t+"']").text();
	print += '<div class="achieve-item" id="achieve_item_' + n + '"><div class="af-achieve-type">'+'' + achieve_type + '</div><div>' + 'From: ' + v + '</div></div>';
	jQuery("#achieve_type option[value='"+t+"']").remove();

	var c = 0;
	jQuery("#achieve_type option").each(function(){
		c++;
	});
	if (c==1){
		jQuery('#achieve_type').attr('disabled', 'disabled');
		jQuery('#add_new_achieve').css('display', 'none');
	}

	var initial = jQuery('#achieve_rules_view').html();
	jQuery('#achieve_rules_view').html(initial + print);

	jQuery('#achieve_type').val('');
	jQuery('#achieve_value').val('');

	if (jQuery('#achieve_reset').css('display')=='none'){
		jQuery('#achieve_reset').css('display', 'inline-block');
	}

}

function afAchieveReset(){
	jQuery('#achieve_type').removeAttr('disabled');
	jQuery('#add_new_achieve').css('display', 'inline-block');
	jQuery("#achieve_type option").each(function(){
		jQuery(this).remove();
	});
	jQuery.each(window.achieve_arr, function(k, v){
		if (typeof v!='undefined'){
			jQuery('#achieve_type').append('<option value="'+v.value+'">'+v.label+'</option>');
		}
	});

	jQuery('#achieve_rules_view').html('');
	jQuery('#achieve_reset').css('display', 'none');
	jQuery('#achieve_type_value').val('');
	jQuery('#achieve_relation_div').css('display', 'none');
}

function afChageColor(id, value, where ){
    jQuery('#af_colors_ul li').each(function(){
				jQuery(this).removeClass('af-color-scheme-item-selected');
    });
    jQuery(id).addClass('af-color-scheme-item-selected');
    jQuery(where).val(value);
}


function afAutocompleteWriteTag(value_id, hiddenId, viewDivId, prevDivPrefix, label){
	/*
	 * viewDivId - parent
	 * prevDivPrefix - prefix of tag
	 * hiddenId - where values are
	 */
	var id = prevDivPrefix + value_id;
	jQuery(viewDivId).append('<div id="'+id+'" class="af-tag-item">'+label+'<div class="af-remove-tag" onclick="afRemoveTag(\''+value_id+'\', \'#'+id+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');
}

function afAutocompleteWriteAndReplaceTag(value_id, hiddenId, viewDivId, prevDivPrefix, label){
	/*
	 * viewDivId - parent
	 * prevDivPrefix - prefix of tag
	 * hiddenId - where values are
	 */
	var id = prevDivPrefix + value_id;
	jQuery(viewDivId).html('<div id="'+id+'" class="af-tag-item">'+label+'<div class="af-remove-tag" onclick="afRemoveTag(\''+value_id+'\', \'#'+id+'\', \''+hiddenId+'\');" title="Removing tag">x</div></div>');
}

function afRemoveTag(removeVal, removeDiv, hiddenId){
	jQuery(removeDiv).fadeOut(200, function(){
		jQuery(this).remove();
	});

    var hidden_i = jQuery(hiddenId).val();
    var show_arr = hidden_i.split(',');

    show_arr = removeArrayElement(removeVal, show_arr);
    var str = show_arr.join(',');
	jQuery(hiddenId).val(str);
}

function removeArrayElement(elem, arr){
	var i;
	for (i=0;i<arr.length;i++) {
	    if(arr[i]==elem){
	    	arr.splice(i, 1);
	    }
	}
	return arr;
}

function afAddZero(i){
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function afRankChangeOrderPreview(r, v){
	jQuery('.af-rank-graphic').css('visibility', 'none');
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "af_make_ranks_reorder",
                   new_order: v,
                   rank_id: r,
                   current_label: jQuery('#rank_label').val(),
               },
        success: function (d) {
        	jQuery('.af-rank-graphic').html(d);
        	jQuery('.af-rank-graphic').css('visibility', 'visible');
        }
   });
}

function afMakeInputhString(divCheck, showValue, hidden_input_id){
    var str = jQuery(hidden_input_id).val();
    if(str==-1) str = '';
    if (str!=''){
			 var show_arr = str.split(',');
		} else {
			 var show_arr = new Array();
		}
    if (jQuery(divCheck).is(':checked')){
        show_arr.push(showValue);
    } else {
        var index = show_arr.indexOf(showValue);
        show_arr.splice(index, 1);
    }
    str = show_arr.join(',');
    if(str=='') str = -1;
    jQuery(hidden_input_id).val(str);
}

//OPT IN
function afConnectAweber(t){
    jQuery.ajax({
        type : "post",
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                action: "af_update_aweber",
                auth_code: jQuery(t).val()
            },
        success: function (data) {
            alert( (window.afI18n && afI18n.connected) || 'Connected' );
        }
	});
}


function afGetCcList(af_cc_user, af_cc_pass){
    jQuery("#af_cc_list").find('option').remove();
	jQuery.ajax({
            type : "post",
						dataType: 'JSON',
            url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
            data : {
                    action: "af_get_cc_list",
                    af_cc_user: jQuery( af_cc_user ).val(),
                    af_cc_pass: jQuery( af_cc_pass ).val()
            },
            success: function (data) {
								jQuery.each(data, function(i, option){
										jQuery("<option/>").val(i).text(option.name).appendTo("#af_cc_list");
								});
						}
    });
}

function afReturnNotification(){
    jQuery.ajax({
        type : "post",
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                action: "af_get_notification_default_by_type",
                type: jQuery('#notf_type').val(),
            },
        success: function (r) {
					if ( typeof r === 'undefined' || r === '' ){
							jQuery('.af-js-notification-description').html( '' );
							jQuery('#notf_message').val( '' );
		        	jQuery('#notf_subject').val( '' );
							return;
					}
        	var o = jQuery.parseJSON(r);
        	jQuery('#notf_subject').val(o.subject);
        	jQuery('#notf_message').val(o.content);
					if ( typeof o.description !== 'undefined' && o.description !== '' ){
        			jQuery('.af-js-notification-description').html(o.description);
					} else {
							jQuery('.af-js-notification-description').html('');
					}
        	jQuery("#notf_message_ifr" ).contents().find( '#tinymce' ).html(o.content);
        }
	});
}

function afMatrixTypeCondition(v){
	if (v=='unilevel'){
		jQuery('#children_limit_div').css('display', 'none');
		jQuery('#af_mlm_child_limit').removeAttr('max');
	}
	else {
		jQuery('#children_limit_div').css('display', 'table');
		if (v=='binary'){
			jQuery('#af_mlm_child_limit').attr('max', 2);
			jQuery('#af_mlm_child_limit').val(2);
		} else {
			jQuery('#af_mlm_child_limit').removeAttr('max');
		}
	}
}

function afMlmUpdateTbl(v){
	var last = parseInt(jQuery('#mlm-amount-for-each-level tr').last().attr('data-tr'));
	if (v<last){
		for (var i=last; i>v; i--){
			jQuery('#af_mlm_level_' + i).remove();
		}
	} else {
		var str_model = jQuery('#af_mlm_model tbody').html();
		var default_type = jQuery('#af_mlm_default_amount_type').val();
		var default_value = jQuery('#af_mlm_default_amount_value').val();
		for (var i=last+1; i<=v; i++){
			var str = str_model;
			str = str.replace(/{{i}}/g, i);
			jQuery('#mlm-amount-for-each-level tbody').append(str);
			jQuery('#af_mlm_level_' + i + ' td select').val(default_type);
			jQuery('#af_mlm_level_' + i + ' td input').val(default_value);
		}
	}
}

function afClosePopup(){
	jQuery('#popup_box').fadeOut(300, function(){
		jQuery(this).remove();
	});
}

function afApproveAffiliate(i){
   	jQuery.ajax({
        type: 'post',
        url: decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data: {
               action: 'af_approve_affiliate',
               uid: i,
        },
        success: function () {
        	location.reload();
        }
   	});
}

function afPaymentFormPaymentStatus(v){
	if (v=='bank_transfer'){
		jQuery('#payment_status_div').css('display', 'block');
	} else {
		jQuery('#payment_status_div').css('display', 'none');
	}
}

function afDoDelete(t, f){
	var m = window.af_messages[t];
	var c = confirm(m);
	if (c){
		jQuery(f).submit();
	} else {
		return false;
	}
}

function afApMakeVisible(t, m){
	jQuery('.af-ap-tabs-list-item').removeClass('af-ap-tabs-selected-item');
	jQuery(m).addClass('af-ap-tabs-selected-item');
	jQuery('.af-ap-tabs-settings-item').fadeOut(200, function(){
		jQuery('#af_tab_item_' + t).css('display', 'block');
	});
}

function checkSubmitAffiliateAction(){
	if (jQuery('[name=do_action]').val()=='delete'){
		var m = window.af_messages['affiliates'] +  "?";
		var c = confirm(m);
		if (c){
			jQuery('#form_affiliates').submit();
		}
	} else {
		jQuery('#form_affiliates').submit();
	}
}

function afMakeUserAffiliate(i){
   	jQuery.ajax({
        type: 'post',
        url: decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data: {
               action: 'af_make_wp_user_affiliate',
               uid: i,
        },
        success: function (data){
        	if (data==2){
        		alert( (window.afI18n && afI18n.adminCannotBecomeAffiliate) || 'Admin cannot become Affiliate!' );
        	} else {
   	        	location.reload();
        	}
        }
   	});
}

function afMakeAffiliateSimpleUser(i){
	jQuery.ajax({
        type: 'post',
        url: decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data: {
               action: 'af_affiliate_simple_user',
               uid: i,
        },
        success: function () {
        	location.reload();
        }
   	});
}

function afRemoveCurrency(c){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'af_delete_currency_code_ajax',
                   code: c
        },
        success: function (r) {
        	if (r){
        		jQuery("#af_div_"+c).fadeOut(300);
        	}
        }
   });
}

function afRemoveSlug(i){
	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: 'af_remove_slug_from_aff',
                   uid: i
        },
        success: function (r) {
        	window.location = window.custom_aff_base_url;
        }
   });
}

function afChangeColorScheme(id, value, where ){
    jQuery('#colors_ul li').each(function(){
        jQuery(this).attr('class', 'color-scheme-item');
    });
    jQuery(id).attr('class', 'color-scheme-item-selected');
    jQuery(where).val(value);
}
function afChangeColorTop(id, value, where ){
	jQuery('#colors_ul li').each(function(){
			jQuery(this).removeClass('color-scheme-item-selected');
	});
	jQuery(id).addClass('color-scheme-item-selected');
	jQuery(where).val(value);
}

function afPreviewUList(){
	jQuery('#preview').html('');
	jQuery("#preview").html('<div class="af-loading-img-wrapper"><img src="'+window.afPluginUrl+'/assets/images/loading.gif" /></div>');
	var meta = [];
	meta.num_of_entries = jQuery('#num_of_entries').val();
	meta.entries_per_page = jQuery('#entries_per_page').val();
	meta.order_by = jQuery('#order_by').val();
	meta.order_type = jQuery('#order_type').val();
	if (jQuery('#filter_by_rank').is(":checked")){
		meta.filter_by_rank = 1;
		meta.ranks_in = jQuery('#ranks_in').val();
	}
	meta.user_fields = jQuery('#user_fields').val();


	if (jQuery('#include_fields_label').is(':checked')){
		meta.include_fields_label = 1;
	}
	meta.theme = jQuery('#theme').val();
	meta.color_scheme = jQuery('#color_scheme').val();
	meta.columns = jQuery('#columns').val();
	if (jQuery('#align_center').is(":checked")){
		meta.align_center = 1;
	}
	if (jQuery('#inside_page').is(":checked")){
		meta.inside_page = 1;
	}
	if (jQuery('#slider_set').is(":checked")){
		meta.slider_set = 1;
		meta.items_per_slide = jQuery('#items_per_slide').val();
		meta.speed = jQuery("#speed").val();
		meta.pagination_speed = jQuery('#pagination_speed').val();
		meta.pagination_theme = jQuery('#pagination_theme').val();
		meta.animation_in = jQuery('#animation_in').val();
		meta.animation_out = jQuery('#animation_out').val();
		var slider_special_metas = ['bullets', 'nav_button', 'autoplay', 'stop_hover', 'responsive', 'autoheight', 'lazy_load', 'loop'];
		for (var i=0; i<slider_special_metas.length; i++){
			if (jQuery('#'+slider_special_metas[i]).is(":checked")){
				meta[slider_special_metas[i]] = 1;
			}
		}
	}

	///SHORTCODE
	var str = "[af-listing-affiliates ";
	for (var key in meta) {
		str += key + " ='" + meta[key] +"' ";
	}
	str += ']';
    jQuery('.the-shortcode').html(str);
    jQuery(".php-code").html('&lt;?php echo do_shortcode("'+str+'");?&gt;');

    //AJAX CALL
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(window.af_url) + '/wp-admin/admin-ajax.php',
        data : {
                   action: 'af_preview_user_listing',
                   shortcode: str
               },
        success: function (r) {
        	jQuery('#preview').html(r);
					if ( jQuery( '.af-js-owl-settings-data' ).length ){
							jQuery('.af-js-owl-settings-data').each(function( e, html ){
									afInitiateOwl(html);
							});
					}
        }
   	});
}

function afCheckboxDivRelation(c, t){
	/*
	 * c = checkbox id to check
	 * t = target div
	 */
	var o = 0.5;
	if (jQuery(c).is(":checked")){
		o = 1;
	}
	jQuery(t).css("opacity", o);
}

function afWriteTagValueListUsers(id, hiddenId, viewDivId, prevDivPrefix){
    if( id.value == -1 || id.value == '' ) return;
    var hidden_i = jQuery(hiddenId).val();

    if ( hidden_i != '' ){
			 var show_arr = hidden_i.split(',');
		} else {
			 var show_arr = new Array();
		}

    if ( show_arr.indexOf(id.value) == -1 ){
        show_arr.push(id.value);

	    var str = show_arr.join(',');
	    jQuery(hiddenId).val(str);

			var label = jQuery(id).find("option:selected").text();
			jQuery(viewDivId).append('<div id="'+prevDivPrefix+id.value+'" class="af-tag-item">'+label+'<div class="af-remove-tag" onclick="afremoveTag(\''+id.value+'\', \'#'+prevDivPrefix+'\', \''+hiddenId+'\');afPreviewUList();" title="Removing tag">x</div></div>');
    }

    jQuery(id).val(-1);
}

function afShowHideDrip(){
	if (jQuery('#ihc_mb_type').val()=='show'){
		jQuery('#ihc_drip_content_empty_meta_box').css('display', 'none');
		jQuery('#ihc_drip_content_meta_box').css('display', 'block');
	} else {
		jQuery('#ihc_drip_content_empty_meta_box').css('display', 'block');
		jQuery('#ihc_drip_content_meta_box').css('display', 'none');
	}
}

function afremoveTag(removeVal, prevDivPrefix, hiddenId){
	jQuery(prevDivPrefix+removeVal).fadeOut(200, function(){
		jQuery(this).remove();
	});

    var hidden_i = jQuery(hiddenId).val();
    var show_arr = hidden_i.split(',');

    show_arr = removeArrayElement(removeVal, show_arr);
    var str = show_arr.join(',');
	jQuery(hiddenId).val(str);
}

function removeArrayElement(elem, arr){
	for ( var i=0; i<arr.length; i++ ) {
	    if ( arr[i] == elem ){
	    	arr.splice(i, 1);
	    }
	}
	return arr;
}

function afDeleteFileViaAjax(id, u_id, parent, name, hidden_id){
   	jQuery.ajax({
        type : "post",
        url : decodeURI(ajax_url),
        data : {
                   action: "af_delete_attachment_ajax_action",
                   attachemnt_id: id,
                   user_id: u_id,
                   field_name: name,
               },
        success: function (data) {
        	jQuery(hidden_id).val('');
        	jQuery(parent + ' .ajax-file-upload-filename').remove();
        	jQuery(parent + ' .af-delete-attachment-bttn').remove();
        	if (jQuery(parent + ' .af-member-photo').length){
        		jQuery(parent + ' .af-member-photo').remove();
        		if (name=='af_avatar'){
        			jQuery(parent).prepend("<div class='af-no-avatar af-member-photo'></div>");
        			jQuery(parent + " .af-file-upload").css("display", 'block');
        		}
        	}

        	if (jQuery(parent + " .af-file-name-uploaded").length){
        		jQuery(parent + " .af-file-name-uploaded").remove();
        	}

        	if (jQuery(parent + ' .ajax-file-upload-progress').length){
        		jQuery(parent + ' .ajax-file-upload-progress').remove();
        	}
        	if (jQuery(parent + ' .af-icon-file-type').length){
        		jQuery(parent + ' .af-icon-file-type').remove();
        	}
        }
   });
}


function afApproveEmail(id, new_label){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(ajax_url),
        data : {
                   action: 'af_approve_user_email',
                   uid: id,
               },
        success: function (response) {
        	jQuery('#user_email_'+id+'_status').fadeOut(200, function(){
        		var the_span_styl = 'af-user-email-st';
        		jQuery(this).html('<span class="'+the_span_styl+'">'+new_label+'</span>');
        		jQuery(this).fadeIn(200);

        		jQuery('#approve_email_'+id).fadeOut(200, function(){
        			jQuery(this).html('');
        		});
        	});
        }
   });
}

function afCheckEmailServer(){
	jQuery.ajax({
			type : 'post',
	        url : decodeURI(ajax_url),
	        data : {
	                   action: 'af_check_mail_server',
	               },
	        success: function (r){
	        	alert(window.af_messages.email_server_check);
	        }
	});
}

function afCheckLoginField(t, e){
	var n = jQuery('#notice_' + t);
	n.fadeOut(500, function(){
		n.remove();
	});
	var target = jQuery('#af_login_form [name='+t+']').parent();
	var v = jQuery('#af_login_form [name='+t+']').val();
	if (v==''){
		jQuery(target).append('<div class="af-login-notice" id="notice_' + t + '">' + e + '</div>');
	}
}

function afCheckFieldLimit(limit, d){
	var val = jQuery(d).val().length;
	if (val>limit){
		jQuery(d).val('');
		alert(limit + ' is the maximum number of characters for this field!');
	}
}

function afGeneratePaymentsCsv(){
   	jQuery.ajax({
        type : 'post',
        url : decodeURI(ajax_url),
        data : {
                   action: 'af_do_generate_payments_csv',
                   min_date: jQuery('#csv_min_date').val(),
                   max_date: jQuery('#csv_max_date').val(),
                   payment_type: jQuery('#csv_payment_type').val(),
                   switch_status: jQuery('#csv_switch_status').val(),
        },
        success: function (response) {
        	if (response){
        		jQuery('.af-hidden-download-link a').attr('href', response);
        		jQuery('.af-hidden-download-link').fadeIn(200);
        		window.open(response, '_blank');
        	}
        }
   });

}


function afDoRedirect(base_url, param, value_input){
	var the_url = base_url + '&' + param + '=' + jQuery(value_input).val();
	window.location = the_url;
}



///// SHINY SELECT

function afShinySelect(params){
	/*
	 * params selector, item_selector, option_name_code, option_name_icon, default_icon, default_code
	 */
	var current_object = {};
	current_object.selector = params.selector; ///got # in front of it
	current_object.popup_id = 'af_select_' + params.option_name_code;
	current_object.popup_visible = false;
	current_object.option_name_code = params.option_name_code;
	current_object.option_name_icon = params.option_name_icon;
	current_object.item_selector = params.item_selector; /// got . in front of it
	current_object.init_default = params.init_default;
	current_object.second_selector = params.second_selector;
	current_object.default_code = params.default_code;

	jQuery(current_object.selector).after('<input type="hidden" name="' + current_object.option_name_code + '" value="' + params.default_code + '" />');
	jQuery(current_object.selector).after('<input type="hidden" name="' + current_object.option_name_icon + '" value="' + params.default_icon + '" />');
	jQuery(current_object.selector).after('<div class="af_select_popup af-display-none" id="' + current_object.popup_id + '"></div>');

	///run init
	if (current_object.init_default){
		jQuery(current_object.selector).html('<i class="fa-af-preview fa-af ' + params.default_icon + '"></i>');
	}

	function getDataAndClose(){
		var code = jQuery(this).attr('data-code');
		var i_class = jQuery(this).attr('data-class');
		var the_html = jQuery(this).html();
		jQuery('[name=' + current_object.option_name_code + ']').val(code);
		jQuery('[name=' + current_object.option_name_icon + ']').val(i_class);
		jQuery(current_object.selector).html(the_html);
		removePopup();
	}

	function loadDataViaAjax(){
		var img = "<img src='" + decodeURI(window.af_gif_loading) + "' class='af-loading-img'/>";
		jQuery('#'+current_object.popup_id).html(img);
		jQuery('#'+current_object.popup_id).css('display', 'block');
		jQuery.ajax({
		    type : 'post',
		    dataType: "text",
		    url : decodeURI(window.af_url) + '/wp-admin/admin-ajax.php',
		    data : {
		             action: 'af_get_font_awesome_popup'
		    },
		    success: function (r){
		       	jQuery('#'+current_object.popup_id).html(r);
		       	jQuery(current_object.item_selector).on('click', getDataAndClose);
			}
		});
	}

	jQuery(current_object.selector).on('click', function(){
		if (!current_object.popup_visible){
			current_object.popup_visible = true;
			loadDataViaAjax();
		} else {
			removePopup();
		}
	});

	jQuery(current_object.second_selector).on('click', function(){
		//// arrow
		if (!current_object.popup_visible){
			current_object.popup_visible = true;
			loadDataViaAjax();
		} else {
			removePopup();
		}
	});

	function removePopup(){
		jQuery('#'+current_object.popup_id).html('');
		jQuery('#'+current_object.popup_id).css('display', 'none');
		current_object.popup_visible = false;
	}

}

function afMakeExportFile(){
	var u = jQuery('#import_users').val();
	var s = jQuery('#import_settings').val();
	var pm = jQuery('#import_postmeta').val();
	jQuery('#af_loading_gif .spinner').css('visibility', 'visible');
	jQuery.ajax({
		type : 'post',
	    url : decodeURI(window.af_url) + '/wp-admin/admin-ajax.php',
	    data : {
	            action: 'af_make_export_file',
	            import_users: u,
	            import_settings: s,
	            import_postmeta: pm
	           },
	    success: function (response) {
	        if (response!=0){
	        	jQuery('.af-hidden-download-link a').attr('href', response);
	        	jQuery('.af-hidden-download-link').fadeIn(200);
						jQuery('#af_loading_gif .spinner').css('visibility', 'hidden');
	        }
	    }
	});
}

function afCheckBaseReferralLink(v, u){
		if (v.indexOf(u)==-1){
				alert(jQuery('#base_referral_link_alert').html());
		}
}

function afHideDivIfValue( checkValue, desiredValue, targetToHide )
{
		if ( checkValue==desiredValue ){
				jQuery(targetToHide).css('display', 'none');
		} else {
				jQuery(targetToHide).css('display', 'block');
		}
}

jQuery(document).ajaxSend(function (event, jqXHR, ajaxOptions) {
    if ( typeof ajaxOptions.data !== 'string' || ajaxOptions.data.includes( 'action=af' ) === false ){
        return;
    }
    if ( typeof ajaxOptions.url === 'string' && ajaxOptions.url.includes('/admin-ajax.php')) {
       var token = jQuery('meta[name="af-admin-token"]').attr("content");
       jqXHR.setRequestHeader('X-CSRF-AF-ADMIN-TOKEN', token );
    }
});



function af_split(v){
	if (v.indexOf(',')!=-1){
	    return v.split( /,\s*/ );
	} else if (v!=''){
		return [v];
	}
	return [];
}

function afContains(a, obj) {
    return a.some(function(element){return element == obj;})
}

function af_reset_autocomplete_fields()
{
		jQuery('#af_pay_to_become_affiliate_target_products').val('')
		jQuery('#af_reference_search_tags').html('')
}

function af_make_disable_if_checked( checkSelector, target )
{
		if (jQuery(checkSelector).is(':checked')){
				jQuery(target).attr('disabled', 'disabled')
		} else {
				jQuery(target).removeAttr('disabled')
		}
}


function af_extract(t) {
    return af_split(t).pop();
}

window.addEventListener( 'DOMContentLoaded', function(){

	if( jQuery('#af_login_custom_css').length ) {
			 jQuery.extend(wp.codeEditor.defaultSettings, {
					 "codemirror": {
							 "theme"             : "cobalt",
							 "direction"         : "ltr",
							 "mode"              : "text/css",
							 "indentUnit"        : 4,
							 "styleActiveLine"   : true,
							 "indentWithTabs"    : true,
							 "lineWrapping"      : true,
							 "lineNumbers"       : true,
							 "continueComments"  : true,
							 "matchBrackets"     : true,
							 "autoCloseBrackets" : true,
							 "lint"              : false,
							 "inputStyle"        : "contenteditable",
							 "gutters"           : ["CodeMirror-lint-markers"],
							 "extraKeys"         : {
										 "Alt-F"   : "findPersistent",
										 "Cmd-F"   : "findPersistent",
										 "Ctrl-F"  : "findPersistent",
							 },
					 },
			 });
			var afCSSEditor = wp.codeEditor.initialize( jQuery('#af_login_custom_css') );
	}

	if( jQuery('#af_register_custom_css').length ) {
			 jQuery.extend(wp.codeEditor.defaultSettings, {
					 "codemirror": {
							 "theme"             : "cobalt",
							 "direction"         : "ltr",
							 "mode"              : "text/css",
							 "indentUnit"        : 4,
							 "styleActiveLine"   : true,
							 "indentWithTabs"    : true,
							 "lineWrapping"      : true,
							 "lineNumbers"       : true,
							 "continueComments"  : true,
							 "matchBrackets"     : true,
							 "autoCloseBrackets" : true,
							 "lint"              : false,
							 "inputStyle"        : "contenteditable",
							 "gutters"           : ["CodeMirror-lint-markers"],
							 "extraKeys"         : {
										 "Alt-F"   : "findPersistent",
										 "Cmd-F"   : "findPersistent",
										 "Ctrl-F"  : "findPersistent",
							 },
					 },
			 });
			var afCSSEditor = wp.codeEditor.initialize( jQuery('#af_register_custom_css') );
	}

	if( jQuery('#af_listing_users_custom_css').length ) {
			 jQuery.extend(wp.codeEditor.defaultSettings, {
					 "codemirror": {
							 "theme"             : "cobalt",
							 "direction"         : "ltr",
							 "mode"              : "text/css",
							 "indentUnit"        : 4,
							 "styleActiveLine"   : true,
							 "indentWithTabs"    : true,
							 "lineWrapping"      : true,
							 "lineNumbers"       : true,
							 "continueComments"  : true,
							 "matchBrackets"     : true,
							 "autoCloseBrackets" : true,
							 "lint"              : false,
							 "inputStyle"        : "contenteditable",
							 "gutters"           : ["CodeMirror-lint-markers"],
							 "extraKeys"         : {
										 "Alt-F"   : "findPersistent",
										 "Cmd-F"   : "findPersistent",
										 "Ctrl-F"  : "findPersistent",
							 },
					 },
			 });
			var afCSSEditor = wp.codeEditor.initialize( jQuery('#af_listing_users_custom_css') );
	}

	if( jQuery('#af_account_page_custom_css').length ) {
			 jQuery.extend(wp.codeEditor.defaultSettings, {
					 "codemirror": {
							 "theme"             : "cobalt",
							 "direction"         : "ltr",
							 "mode"              : "text/css",
							 "indentUnit"        : 4,
							 "styleActiveLine"   : true,
							 "indentWithTabs"    : true,
							 "lineWrapping"      : true,
							 "lineNumbers"       : true,
							 "continueComments"  : true,
							 "matchBrackets"     : true,
							 "autoCloseBrackets" : true,
							 "lint"              : false,
							 "inputStyle"        : "contenteditable",
							 "gutters"           : ["CodeMirror-lint-markers"],
							 "extraKeys"         : {
										 "Alt-F"   : "findPersistent",
										 "Cmd-F"   : "findPersistent",
										 "Ctrl-F"  : "findPersistent",
							 },
					 },
			 });
			var afCSSEditor = wp.codeEditor.initialize( jQuery('#af_account_page_custom_css') );
	}

		var i, j;
		window.af_messages = {
							referrals: jQuery( '.af-js-general-messages' ).attr( 'data-referrals' ),
							general_delete: jQuery( '.af-js-general-messages' ).attr( 'data-general_delete' ),
							affiliates: jQuery( '.af-js-general-messages' ).attr( 'data-affiliates' ),
							email_server_check: jQuery( '.af-js-general-messages' ).attr( 'data-email_server_check' ),
		};

		var afCurrentUrl = window.location.href;

		afShinySelect({
					selector: '#af_shiny_select_af',
					item_selector: '.af-font-awesome-popup-item',
					option_name_code: 'icon_code',
					option_name_icon: 'icon_class',
					default_icon: '',
					default_code: '',
					init_default: false,
					second_selector: '.af-icon-arrow'
		});

		afApMakeVisible('overview', '#af_tab-overview');

		if ( jQuery('#referrals_date').length ){
				jQuery('#referrals_date').datepicker({
							dateFormat : 'yy-mm-dd ',
							onSelect: function(datetext){
									var d = new Date();
									datetext = datetext+d.getHours()+":"+afAddZero(d.getMinutes())+":"+afAddZero(d.getSeconds());
									jQuery(this).val(datetext);
							}
				});
		}

		jQuery( '.deactivate' ).on( 'click', function(evt){
				if ( jQuery( evt.target ).attr('href').indexOf( 'open-affiliates-for-woocommerce' ) > -1 ){
						if ( window.afKeepData == 1 ){
								var theMessage = 'Plugin data will be kept in database after you delete the plugin.';
						} else {
								var theMessage = 'Plugin data will be lost after you delete the plugin.';
						}
						var target = jQuery( evt.target ).attr('href');
						afSwal({
							title: theMessage,
							text: "In order to change that, go to General Settings -> Admin Workflow.",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "OK",
							closeOnConfirm: true
						},	function(){
								window.location.href = target;
						});
						return false;
				}
		});

		jQuery( '.af-js-paypal-sandbox-on-off' ).on( 'click', function(){
				if ( jQuery('.af-js-paypal-sandbox-on-off').is(':checked') ){
						/// sandbox
						jQuery('.af-js-paypal-sandbox-credentials').css( 'display', 'block' );
						jQuery('.af-js-paypal-live-credentials').css( 'display', 'none' );
				} else {
						/// live
						jQuery('.af-js-paypal-sandbox-credentials').css( 'display', 'none' );
						jQuery('.af-js-paypal-live-credentials').css( 'display', 'block' );
				}
		});

		jQuery( '.js-af-change-recaptcha-version' ).on( 'change', function( evt ){
				if ( this.value == 'v2' ){
						jQuery( '.js-af-recaptcha-v2-wrapp' ).css( 'display', 'block' );
						jQuery( '.js-af-recaptcha-v3-wrapp' ).css( 'display', 'none' );
				} else {
						jQuery( '.js-af-recaptcha-v2-wrapp' ).css( 'display', 'none' );
						jQuery( '.js-af-recaptcha-v3-wrapp' ).css( 'display', 'block' );
				}
		});

		jQuery('#af-register-fields-table tbody').sortable({
			 update: function(e, ui) {
			        jQuery('#af-register-fields-table tbody tr').each(function (i, row) {
			        	var id = jQuery(this).attr('id');
			        	var newindex = jQuery("#af-register-fields-table tbody tr").index(jQuery('#'+id));
			        	jQuery('#'+id+' .af-order').val(newindex);
			        });
			    }
		});

		jQuery('#af_reorder_menu_items tbody').sortable({
			 update: function(e, ui) {
			        jQuery('#af_reorder_menu_items tbody tr').each(function (i, row) {
			        	var id = jQuery(this).attr('id');
			        	jQuery('#'+id+' .af_account_page_menu_order').val(i);
			        });
			 }
		});

		jQuery('.af-admin-mobile-bttn').on('click', function(){
			jQuery('.af-dashboard-menu-items').toggle();
		});
		/// events
		jQuery( '#af_js_add_edit_banners_trash' ).on( 'click', function( e, html ){
				jQuery('#af_the_image').val('');
		});
		jQuery( '#af_js_affiliate_list_add_filter' ).on( 'click', function( e, html ){
				jQuery('.af-filters-wrapper').toggle();
		});
		jQuery( '#af_js_edit_background_image_trash' ).on( 'click', function( e, html ){
				jQuery('#af_ap_edit_background_image').val('');
		});
		jQuery( '#af_js_flashbar_trash_img' ).on( 'click', function( e, html ){
				jQuery('[name=af_info_affiliate_bar_logo]').val('');
		});
		jQuery( '#af_js_iab_trash_banner' ).on( 'click', function( e, html ){
				jQuery('[name=af_info_affiliate_bar_banner_default_value]').val('');
		});
		jQuery( '#af_js_top_affiliates_the_toggle' ).on( 'click', function( e, html ){
				jQuery('#the_af_user_list_settings').slideToggle();
		});
		jQuery( '#af_js_toggle_preview' ).on( 'click', function( e, html ){
				jQuery('#preview').slideToggle();
		});
		jQuery( '.af-js-location-reload' ).on( 'click', function( e, html ){
				var url = jQuery( this ).attr('data-url');
				window.location.href = url;
		});
		jQuery( '.af-js-pay-to-become-aff-select-target' ).on( 'click', function( e, html ){
				var url = jQuery( this ).attr( 'data-url' );
				var value = jQuery( this ).val();
				af_reset_autocomplete_fields();
				jQuery('#reference_search').autocomplete( 'option', { source: url + value } );
		});

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=dashboard' ) !== -1 ){
				// dashboard
				if (jQuery("#af_chart_1").length > 0) {
						var af_ticks = [];
						var af_chart_stats = [];
						var i = 0;
						var j;
						jQuery( '.af-js-dashboard-rank-data' ).each( function( e, html ){
								var label = jQuery( html ).attr('data-label');
								var value = jQuery( html ).attr('data-value');
								af_ticks[ i ]=[ i, label ];
								af_chart_stats[ i ]={ 0: i, 1:value};
								i++;
						});
						if ( i < 10 ) {
							for ( j=i; j<11; j++){
								af_ticks[ i ]=[ i, '' ];
								af_chart_stats[ i ]={ 0: j, 1:0 };
							}
						}

						var options = {
						    bars: { show: true, barWidth: 0.75, fillColor: '#7ebffc', lineWidth: 0 },
								grid: { hoverable: false, backgroundColor: "#fff", minBorderMargin: 0,  borderWidth: {top: 0, right: 0, bottom: 1, left: 1}, borderColor: "#aaa" },
								xaxis: { ticks: af_ticks, tickLength:0 },
								yaxis: { tickDecimals: 0, tickColor: '#eee'},
								legend: {show: true, position: "ne"}
						};

						jQuery.plot(jQuery("#af_chart_1"), [ {
												color: "#669ccf",
												data: af_chart_stats,
											} ], options
						);
				}
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=login' ) !== -1 ){
				// login
				afLoginPreview();
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=banners&subtab=add_edit' ) !== -1 ){
				// creatives
				if ( jQuery( '.af-js-admin-creatives-select-type').length > 0 ){
						jQuery( '.af-js-admin-creatives-select-type').on('change', function(){
								if ( this.value === 'text' ){
										jQuery( '#af_js_admin_creatives_image_url' ).addClass( 'af-display-none' );
										jQuery( '#af_js_admin_creatives_text_type' ).removeClass( 'af-display-none' );
								} else {
									jQuery( '#af_js_admin_creatives_image_url' ).removeClass( 'af-display-none' );
									jQuery( '#af_js_admin_creatives_text_type' ).addClass( 'af-display-none' );
								}
						});
				}
		}


		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=register&subtab=custom_fields-add_edit' ) !== -1 ){
						// register fields - add edit
						jQuery( document ).on( 'click', '.af-js-register-fields-add-edit-remove', function( e, html ){
								jQuery(this).parent().remove();
						});
						return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=register&subtab=custom_fields' ) !== -1 ){
				// custom fields
				jQuery('.af-register-the-values').sortable({
					cursor: 'move'
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=affiliates&subtab=add_edit&id=' ) !== -1 ){
				// affiliates add/edit
				jQuery( '#usernames_search' ).on( 'blur', function(){
						var value = jQuery( '#usernames_search' ).val();
						if ( value === '' ){
								jQuery( '#af_affiliate_mlm_parent' ).val( 0 );
						}
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=affiliates' ) !== -1 ){
				// affiliates list
				jQuery( '.af-js-affiliate-list-limit' ).on( 'change', function(){
						var baseUrl = jQuery( this ).attr('data-url');
						var value = jQuery( this ).val();
						window.location = baseUrl + value;
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=register' ) !== -1 ){
				// register
				afRegisterPreview();
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=migrate_affiliate_wp' ) !== -1 ){
				// Migrate - affiliate wp
				AfMigrate.init({
						trigger: '.af-trigger-event-migrate',
						rankSelector: '.af-migrate-assign-rank',
						progressBarWrapp: '.af-progress-bar-wrapp',
						completeDiv: '.af-progress-bar-warning',
						completeMessage: window.afMigrationCompleteMessage,
						progressBarDiv: '.progress-bar',
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=migrate_affiliates_pro' ) !== -1 ){
				// Migrate - affiliates pro
				AfMigrate.init({
				    trigger: '.af-trigger-event-migrate',
				    rankSelector: '.af-migrate-assign-rank',
				    progressBarWrapp: '.af-progress-bar-wrapp',
						completeDiv: '.af-progress-bar-warning',
						completeMessage: window.afMigrationCompleteMessage,
						progressBarDiv: '.progress-bar',
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=migrate_wp_affiliates' ) !== -1 ){
				// Migrate - wp affiliates
				AfMigrate.init({
						trigger: '.af-trigger-event-migrate',
						rankSelector: '.af-migrate-assign-rank',
						progressBarWrapp: '.af-progress-bar-wrapp',
						completeDiv: '.af-progress-bar-warning',
						completeMessage: window.afMigrationCompleteMessage,
						progressBarDiv: '.progress-bar',
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=mlm' ) !== -1 ){
				/// mlm - username search
				jQuery( "#affiliate_name" ).on( "keydown", function( event ) {
					if ( event.keyCode === jQuery.ui.keyCode.TAB &&
						jQuery( this ).autocomplete( "instance" ).menu.active ) {
						event.preventDefault();
					}
				}).autocomplete({
					minLength: 0,
					source: decodeURI( window.af_url ) + '/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce=' + window.afAdminAjaxNonce + '&users=true',
					focus: function() {},
					select: function( event, ui ) {
						var l = ui.item.label;
						jQuery('#affiliate_name').val(l);
						return false;
					}
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=checkout_select_referral' ) !== -1 ){
				/// checkout select referral
				jQuery(function() {
					/// USERNAME SEARCH
					jQuery( "#usernames_search" ).on( "keydown", function( event ) {
						if ( event.keyCode === jQuery.ui.keyCode.TAB &&
							jQuery( this ).autocomplete( "instance" ).menu.active ) {
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

				});
				return;
		}


		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=coupons&add_edit' ) !== -1 ){
				/// coupons - add/edit
				var af_source = jQuery('#the_source').val();

				jQuery('#the_source').on('change', function(){
						af_source = jQuery(this).val();
						jQuery('#coupon_code').val('');
				});

				jQuery(function() {
					jQuery( "#coupon_code" ).on( "keydown", function( event ) {
						if ( event.keyCode === jQuery.ui.keyCode.TAB &&
							jQuery( this ).autocomplete( "instance" ).menu.active ) {
						 	event.preventDefault();
						}
					}).autocomplete({
						focus: function( event, ui ){},
						minLength: 0,
						source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce='  + window.afAdminAjaxNonce + '&source='+af_source,
						select: function( event, ui ) {
							var v = ui.item.label;
							jQuery('#coupon_code').val(v);
						 	return false;

						}
					});

					/// USERNAME SEARCH
					jQuery( "#affiliate_name" ).on( "keydown", function( event ) {
						if ( event.keyCode === jQuery.ui.keyCode.TAB &&
							jQuery( this ).autocomplete( "instance" ).menu.active ) {
						 	event.preventDefault();
						}
					}).autocomplete({
						minLength: 0,
						source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce='  + window.afAdminAjaxNonce + '&users=true',
						focus: function() {},
						select: function( event, ui ) {
							var v = ui.item.id;
							var l = ui.item.label;
							jQuery('#affiliate_name').val(l);
						 	jQuery('#affiliate_id_hidden').val(v);//send to input hidden
						 	return false;
						}
					});

					jQuery( '.af-js-coupons-add-edit-autocomplete' ).on( 'change', function( target ){
							var url = jQuery( '.af-js-coupons-add-edit-autocomplete' ).attr( 'data-url_target' );
							var value =  jQuery( '.af-js-coupons-add-edit-autocomplete' ).val();
							jQuery('#coupon_code').autocomplete( 'option', { source: url + value } );
					});

				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=custom_affiliate_slug' ) !== -1 ){
				// custom affiliate slug

				jQuery(function() {
					/// USERNAME SEARCH
					jQuery( "#affiliate_name" ).on( "keydown", function( event ) {
						if ( event.keyCode === jQuery.ui.keyCode.TAB &&
							jQuery( this ).autocomplete( "instance" ).menu.active ) {
						 	event.preventDefault();
						}
					}).autocomplete({
						minLength: 0,
						source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce='  + window.afAdminAjaxNonce + '&users=true',
						focus: function() {},
						select: function( event, ui ) {
							var v = ui.item.id;
							var l = ui.item.label;
							jQuery('#affiliate_name').val(l);
						 	jQuery('#affiliate_id_hidden').val(v);//send to input hidden
						 	return false;
						}
					});

					window.custom_aff_base_url = jQuery( '.af-js-custom-aff-base-url' ).attr( 'data-value' );
				});
				return;
		}

		if ( ( afCurrentUrl.indexOf( 'wp-admin/post.php') !== -1 && jQuery.fn.autocomplete ) ||
				( afCurrentUrl.indexOf( 'wp-admin/post-new.php' ) !== -1 && jQuery.fn.autocomplete )
		){
				// posts and pages
				// set the landing page
				jQuery( "#usernames_search" ).on( "keydown", function( event ) {
					if ( event.keyCode === jQuery.ui.keyCode.TAB &&
						jQuery( this ).autocomplete( "instance" ).menu.active ) {

						event.preventDefault();
					}
				}).autocomplete({
					minLength: 0,
					source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&users=true&without_all=true&afAdminAjaxNonce=' + window.afAdminAjaxNonce,
					focus: function() {},
					select: function( event, ui ) {
						var input_id = '#af_landing_page_affiliate_id';
						var v = ui.item.id;
						var l = ui.item.label;
						afAutocompleteWriteAndReplaceTag(v, input_id, '#af_username_search_tags', 'af_username_tag_', l);
						jQuery(input_id).val(v);//send to input hidden
						this.value = '';//reset search input
						return false;
					}
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=pay_to_become_affiliate' ) !== -1 ){
				// pay to become affiliate
					var af_offer_source = jQuery('#the_source').val();
					jQuery('#the_source').on('change', function(){
						af_offer_source = jQuery(this).val();
						jQuery('#af_reference_search_tags').empty();
						jQuery('#reference_search_hidden').val('');
					});

					/// REFERENCE SEARCH
					jQuery( "#reference_search" ).on( "keydown", function( event ) {
						if ( event.keyCode === jQuery.ui.keyCode.TAB &&
							jQuery( this ).autocomplete( "instance" ).menu.active ) {
						 	event.preventDefault();
						}
					}).autocomplete({
					focus: function( event, ui ){},
					minLength: 0,
					source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&afAdminAjaxNonce=' + window.afAdminAjaxNonce + '&source=' + af_offer_source,
					select: function( event, ui ) {
						var input_id = '#af_pay_to_become_affiliate_target_products';
					 	var terms = af_split(jQuery(input_id).val());//get items from input hidden
						var v = ui.item.id;
						var l = ui.item.label;
					 	if (!afContains(terms, v)){
							terms.push(v);
						 	afAutocompleteWriteTag(v, input_id, '#af_reference_search_tags', 'af_reference_tag_', l);// print the new shiny box
						 }
						var str_value = terms.join( "," );
					 	jQuery(input_id).val(str_value);//send to input hidden
						this.value = '';//reset search input
					 	return false;
					}
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=notifications&subtab=add_edit' ) !== -1 ){
				// constants for wp editor
				if ( jQuery( '.af-tag-code' ).length ){
						jQuery( '.af-tag-code' ).on('click', function(){
								var text  =jQuery(this).html();
								var textarea = document.getElementById('notf_message');
								var position = textarea.selectionStart;
								var before = textarea.value.substring(0, position);
								var after = textarea.value.substring(position, textarea.value.length);
								textarea.value = before + text + after;
								textarea.selectionStart = textarea.selectionEnd = position + text.length;
						});
				}

				// Notifications - Add/Edit
				var notificationId = jQuery( '.af-js-add-edit-notification-id' ).val();
				if ( parseInt( notificationId ) > 0 ){
						return;
				} else {
						afReturnNotification();
						return;
				}
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=offers&subtab=add_edit' ) !== -1 ){
				// Offers - Add/Edit

				var af_offer_source = jQuery('#the_source').val();

				jQuery('#the_source').on('change', function(){
						af_offer_source = jQuery(this).val();
						if ( af_offer_source == 'woo' ){
								jQuery( '.js-af-product-label').html( jQuery( '.af-js-offers-add-edit-labels' ).attr('data-products_and_cats') );
						} else {
								jQuery( '.js-af-product-label').html( jQuery( '.af-js-offers-add-edit-labels' ).attr('data-products') );
						}
						jQuery('#af_reference_search_tags').empty();
						jQuery('#reference_search_hidden').val('');
				});


				/// REFERENCE SEARCH
				jQuery( "#reference_search" ).on( "keydown", function( event ) {
					if ( event.keyCode === jQuery.ui.keyCode.TAB &&
						jQuery( this ).autocomplete( "instance" ).menu.active ) {
					 	event.preventDefault();
					}
				}).autocomplete({
					focus: function( event, ui ){},
					minLength: 0,
					source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&source='+af_offer_source+'&afAdminAjaxNonce=' + window.afAdminAjaxNonce,
					select: function( event, ui ) {
						var input_id = '#reference_search_hidden';
					 	var terms = af_split(jQuery(input_id).val());//get items from input hidden
						var v = ui.item.id;
						var l = ui.item.label;
						if ( typeof ui.item.is_category != 'undefined' ){

								for ( var i = 0; i < ui.item.children.length; i++ ){
										if (!afContains(terms, ui.item.children[i].id )){
											terms.push(ui.item.children[i].id);
											afAutocompleteWriteTag(ui.item.children[i].id, input_id, '#af_reference_search_tags', 'af_reference_tag_', ui.item.children[i].label);// print the new shiny box
										 }
										var str_value = terms.join( "," );
										jQuery(input_id).val(str_value);//send to input hidden
								}
								this.value = '';//reset search input
								return false;
						}
					 	if (!afContains(terms, v)){
							terms.push(v);
						 	afAutocompleteWriteTag(v, input_id, '#af_reference_search_tags', 'af_reference_tag_', l);// print the new shiny box
						 }
						var str_value = terms.join( "," );
					 	jQuery(input_id).val(str_value);//send to input hidden
						this.value = '';//reset search input
					 	return false;

					}
				});

			/// USERNAME SEARCH
			jQuery( "#usernames_search" ).on( "keydown", function( event ) {
				if ( event.keyCode === jQuery.ui.keyCode.TAB &&
					jQuery( this ).autocomplete( "instance" ).menu.active ) {
					event.preventDefault();
				}
			}).autocomplete({
				minLength: 0,
				source: decodeURI( window.af_url ) + '/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&users=true&afAdminAjaxNonce=' + window.afAdminAjaxNonce,
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

			jQuery('.af-datepick').each(function(){
				jQuery(this).datepicker({
								dateFormat : 'yy-mm-dd ',
								onSelect: function(datetext){
										var d = new Date();
										datetext = datetext+d.getHours()+":"+afAddZero(d.getMinutes())+":"+afAddZero(d.getSeconds());
										jQuery(this).val(datetext);
								}
						});
				});

				jQuery( '.af-js-offers-add-edit-select-source' ).on( 'change', function(){
						var targetUrl = jQuery( '.af-js-offers-add-edit-select-source' ).attr( 'data-target_url' );
						var value = jQuery( '.af-js-offers-add-edit-select-source' ).val();
						jQuery('#reference_search').autocomplete( 'option', { source: targetUrl + value } );
				});

				return;
		}


		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=payments&subtab=list_all_unpaid' ) !== -1 ){
				// Payments - list all unpaid
				jQuery(".do-the-payment").on('click', function(e){
						e.preventDefault();
			    	jQuery('.af-referral').each(function(i){
						if (jQuery(this).is(':checked')){
							jQuery("#form_payments").submit();
						}
					});
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=ranks' ) !== -1 ){
				// Ranks - Listing
				jQuery( '.af-js-delete-ranks' ).on( 'click', function(){
						var rankId = jQuery( this ).attr( 'data-id' );
						afSwal({
							title: jQuery( '.af-js-ranks-listing-delete-item-label' ).attr( 'data-value'),
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
										url : decodeURI( window.af_url )+'/wp-admin/admin-ajax.php',
										data : {
															 action									: 'af_admin_delete_ranks',
															 id											:	rankId,
															 af_admin_forms_nonce	:	jQuery( '.af-js-ranks-listing-delete-nonce' ).attr( 'data-value'),
													 },
										success: function (response) {
												if ( response == 'success' ){
														location.reload();
												} else {
													afSwal({
														title: response,
														text: "",
														type: "warning",
														showCancelButton: false,
														confirmButtonClass: "btn-danger",
														confirmButtonText: "OK",
														closeOnConfirm: true
													});
												}
										}
							 });
					 });
				});
		}


		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=magic_features&subtab=simple_links' ) !== -1 ){
				/// USERNAME SEARCH
				jQuery("#affiliate_name").on("keydown", function(event){
					if (event.keyCode===jQuery.ui.keyCode.TAB &&
						jQuery(this).autocomplete("instance").menu.active) {
						event.preventDefault();
					}
				}).autocomplete({
					minLength: 0,
					source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce=' + window.afAdminAjaxNonce + '&users=true',
					focus: function() {},
					select: function( event, ui ) {
						jQuery('#affiliate_name').val(ui.item.label);
						jQuery('#affiliate_id').val(ui.item.id);
						return false;
					}
				});

				/// USERNAME SEARCH
				jQuery("#affiliate_name_search").on("keydown", function(event){
					if (event.keyCode===jQuery.ui.keyCode.TAB &&
						jQuery(this).autocomplete("instance").menu.active) {
						event.preventDefault();
					}
				}).autocomplete({
					minLength: 0,
					source: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php?action=af_ajax_coupons_autocomplete&afAdminAjaxNonce=' + window.afAdminAjaxNonce + '&users=true',
					focus: function() {},
					select: function( event, ui ) {
						jQuery('#affiliate_name_search').val(ui.item.label);
						jQuery('#search_aff_id').val(ui.item.id);
						return false;
					}
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=top_affiliates') !== -1 ){
				// top affiliates
				afPreviewUList();
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=account_page' ) !== -1 ){
				// account page
				var i = 0;
				var af_shiny_object = [];
				jQuery( '.af-js-account-page-icon-details' ).each( function( e, html ){
					var iconCode = jQuery( this ).attr('data-icon_code');
					var slug = jQuery( this ).attr('data-slug');

					af_shiny_object[i] = new afShinySelect({
								selector: '#af_shiny_select_' + slug,
								item_selector: '.af-font-awesome-popup-item',
								option_name_code: 'af_tab_' + slug + '_icon_code',
								option_name_icon: 'af_tab_' + slug + '_icon_class',
								default_icon: 'fa-af fa-' + slug + '-account-af',
								default_code: iconCode,
								init_default: true,
								second_selector: '#af_icon_arrow_' + slug
					});
					i++;
				});
				return;
		}

		if ( afCurrentUrl.indexOf('page=openaffiliates&tab=ranks&subtab=add_edit') !== -1 ){
				// Ranks - Add/Edit
				var i = 1;
				window.achieve_arr = [];
				jQuery( '.af-js-achieve-types-values' ).each( function( e, html ){
						var theLabel = jQuery( html ).attr('data-label');
						var theValue = jQuery( html ).attr('data-value');
						window.achieve_arr[i] = {label: theLabel, value: theValue};
						i++;
				});
				return;
		}


		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=user_profile&affiliate_id' ) !== -1 ){
				// User Profile
				    jQuery('.af-js-delete-referrals-link').on( 'click', function(){
				        jQuery.ajax({
				            type : 'post',
				            url : window.af_url + '/wp-admin/admin-ajax.php',
				            data : {
				                       action: 'af_delete_referrer_link_for_affiliate',
				                       id: jQuery(this).attr('data-id'),
				                   },
				            success: function (response) {
				                location.reload();
				            }
				       });
				    });
				    jQuery('.af-js-delete-landing-page').on( 'click', function(){
				        jQuery.ajax({
				            type : 'post',
				            url : window.af_url + '/wp-admin/admin-ajax.php',
				            data : {
				                       action: 'af_delete_landing_page_for_affiliate',
				                       id: jQuery(this).attr('data-id'),
				                   },
				            success: function (response) {
				                location.reload();
				            }
				       });
				    });
				    jQuery('.af-js-delete-coupons-link').on( 'click', function(){
				        jQuery.ajax({
				            type : 'post',
				            url : window.af_url + '/wp-admin/admin-ajax.php',
				            data : {
				                       action: 'af_delete_coupons_for_affiliate',
				                       id: jQuery(this).attr('data-id'),
				                   },
				            success: function (response) {
				                location.reload();
				            }
				       });
				    });

				    jQuery('.js-af-copy').on( 'click', function(){
				        var url = jQuery( '.af-userprofile-links a' ).attr( 'href' );
				        const el = document.createElement('textarea');
				        el.value = url;
				        document.body.appendChild(el);
				        el.select();
				        document.execCommand('copy');
				        document.body.removeChild(el);
				        afSwal({
				          title: jQuery( '.af-js-user-profile-copy-message' ).attr( 'data-value' ),
				          text: "",
				          type: "success",
				          showConfirmButton: false,
				          confirmButtonClass: "btn-success",
				          confirmButtonText: "OK",
				          timer: 1000
				        });
				    });
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=reports' ) !== -1 ){
				// Reports

				/// select time to search into
				if( jQuery( '.af-js-reports-search-period-select' ).length ){
						jQuery( '.af-js-reports-search-period-select' ).on('change', function(){
								if ( this.value === 'custom' ){
										jQuery( '#af_admin_reports_search_start_date' ).removeClass( 'af-display-none' );
										jQuery( '#af_admin_reports_search_end_date' ).removeClass( 'af-display-none' );
								} else {
										if ( !jQuery('#af_admin_reports_search_start_date').hasClass( 'af-display-none' ) ){
												jQuery( '#af_admin_reports_search_start_date' ).addClass( 'af-display-none' );
										}
										if ( !jQuery('#af_admin_reports_search_end_date').hasClass( 'af-display-none' ) ){
												jQuery( '#af_admin_reports_search_end_date' ).addClass( 'af-display-none' );
										}
								}
						});
				}

				/// datepicker
				if ( jQuery('#af_admin_reports_search_start_date').length ){
						jQuery('#af_admin_reports_search_start_date').datepicker({
									dateFormat : 'yy-mm-dd ',
									onSelect: function(datetext){
									}
						});
				}
				if ( jQuery('#af_admin_reports_search_end_date').length ){
						jQuery('#af_admin_reports_search_end_date').datepicker({
									dateFormat : 'yy-mm-dd ',
									onSelect: function(datetext){
									}
						});
				}

				var tick_Type = jQuery( '.af-js-visits-tick-type' ).attr('data-value');
				var tick_Size = jQuery( '.af-js-visits-tick-size' ).attr('data-value');
				var minTime = jQuery( '.af-js-visits-min-time' ).attr('data-value');
				var maxTime = jQuery( '.af-js-visits-max-time' ).attr('data-value');

				// visits
				var af_visits = [];
				jQuery('.af-js-visit-graph-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_visits.push( temporary );
				});

				// visits success
				var af_visits_success = [];
				jQuery('.af-js-visit-graph-success-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_visits_success.push( temporary );
				});

				if ( af_visits.length > 0 ){
					jQuery.plot(
							jQuery("#af-plot-1"), [{
								label : jQuery('.af-js-reports-labels').attr('data-all_clicks'),
								data : af_visits,
								color : "#625afa",
								shadowSize: 0,
								hoverable: true
							},{
								label : jQuery('.af-js-reports-labels').attr('data-converted_clicks'),
								data : af_visits_success,
								color : "#a3acba",
								shadowSize: 0,
								hoverable: true
							}
							], {
								grid: {
									hoverable: true,
									backgroundColor: "#fff",
									minBorderMargin: 0,
									borderWidth: {top: 0, right: 0, bottom: 1, left: 0},
									borderColor: "#ebeef1",
									autoHighlight: true
								},
								xaxis : {
									min : minTime,
									max : maxTime,
									mode : "time",
									color: "#ebeef1",
									//tickColor:'#c0c8d2',
									tickColor:'#ebeef1',
									tickSize: [tick_Size, tick_Type],
								},
								yaxis : {
									min:0,
									tickLength:0,
									tickDecimals:0,
									//color: "#a3acba",
									color: "#ebeef1",
								},
								series: {
									lines: { show: true, steps: 0, lineWidth: 2, zero: true, fill: false, fillColor: "rgba(255, 255, 255, 0.8)" }
								},
								legend: {
									labelBoxBorderColor: "#fff"
								}
								}
					);
				}


				var tick_Type = jQuery( '.af-js-referrals-tick-type' ).attr('data-value');
				var tick_Size = jQuery( '.af-js-referrals-tick-size' ).attr('data-value');
				var minTime = jQuery( '.af-js-referrals-min-time' ).attr('data-value');
				var maxTime = jQuery( '.af-js-referrals-max-time' ).attr('data-value');

				var af_all_referrals = [];
				jQuery('.af-js-referral-graph-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_all_referrals.push( temporary );
				});

				var af_all_referrals_refuse = [];
				jQuery('.af-js-referral-graph-refuse-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_all_referrals_refuse.push( temporary );
				});

				var af_all_referrals_unverified = [];
				jQuery('.af-js-referral-graph-unverified-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_all_referrals_unverified.push( temporary );
				});

				var af_all_referrals_verified = [];
				jQuery('.af-js-referral-graph-verified-data').each(function(e,html){
						var value = jQuery( html ).attr('data-value');
						var date = jQuery( html ).attr('data-date');
						var temporary = [ date, value ];
						af_all_referrals_verified.push( temporary );
				});

				if ( af_all_referrals.length > 0 ){
						jQuery.plot(
								jQuery("#af-plot-2"), [{
									label : jQuery('.af-js-reports-labels').attr('data-all_referrals'),
									data : af_all_referrals,
									color : "#625afa",
									shadowSize: 0,
									hoverable: true
								}

								], {
									grid: {
										hoverable: true,
										backgroundColor: "#fff",
										minBorderMargin: 0,
										borderWidth: {top: 0, right: 0, bottom: 1, left: 0},
										borderColor: "#ebeef1",
										autoHighlight: true
									},
									xaxis : {
										min : minTime,
										max : maxTime,
										mode : "time",
										color: "#ebeef1",
										//tickColor:'#c0c8d2',
										tickColor:'#ebeef1',
										tickSize: [tick_Size, tick_Type],

									},
									yaxis : {
										tickLength:0,
										tickDecimals:0,
										//color: "#a3acba",
										color: "#ebeef1",
									},
									series: {
        						lines: { show: true, steps: 0, lineWidth: 2, zero: true, fill: false, fillColor: "rgba(255, 255, 255, 0.8)" }
									},
									legend: {
										labelBoxBorderColor: "#fff"
									}
									}
						);
				}

				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=referrals' ) !== -1 ){
				// referrals - list
				jQuery( '.af-js-referral-list-change-status' ).on( 'click', function( e, html ){
						var value = jQuery(this).attr('data-value');
						jQuery('#change_status').val( value );
						jQuery('#form_referrals').submit();
				});

				jQuery( '.af-js-referral-list-limit-number' ).on( 'click', function( e, html ){
						var url = jQuery( this ).attr('data-url');
						var value = jQuery( this ).val();
						window.location = url + value;
				});
				return;
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=visits' ) !== -1 ){
			jQuery( '.af-js-visits-list-limit-number' ).on( 'click', function( e, html ){
					var url = jQuery( this ).attr('data-url');
					var value = jQuery( this ).val();
					window.location = url + value;
			});
		}

		if ( afCurrentUrl.indexOf( 'page=openaffiliates&tab=payments' ) !== -1 ){
				// transactions
				jQuery( '.af-js-transactions-change-status' ).on( 'click', function( e, html ){
						var status = jQuery(this).attr('data-status');
						var id = jQuery(this).attr('data-id');
						jQuery('#transaction_id').val( id );
						jQuery('#new_status').val(status);
						jQuery('#form_payments').submit();
				});

				jQuery( '.af-js-transactions-delete-transaction' ).on( 'click', function( e, html ){
						var id = jQuery(this).attr( 'data-id' );
						jQuery('#delete_transaction').val( id );
						jQuery('#form_payments').submit();
				});
		}

		if ( afCurrentUrl.indexOf( 'admin.php?page=openaffiliates&tab=notifications' ) !== -1 ){
					if ( jQuery( '.af-js-notifications-fire-notification-test' ).length > 0 ){
							jQuery( '.af-js-notifications-fire-notification-test' ).on( 'click', function(){
									var notificationId = jQuery( this ).attr( 'data-notification_id' );
									jQuery.ajax({
											type 			: 'post',
											url 			: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php',
											data 			: {
																 action : 'af_ajax_notification_send_test_email',
																 id			: notificationId
											},
											success		: function (data) {
													jQuery(data).hide().appendTo('body').fadeIn('normal');
											}
								 });
							});
					}
		}

		if ( afCurrentUrl.indexOf( 'admin.php?page=openaffiliates&tab=banners&subtab=add_edit' ) !== -1 ){
				if ( jQuery( '.af-js-banners-add-edit-multiple-cats').length > 0){
						jQuery( '.af-js-banners-add-edit-multiple-cats').multiselect({
                selectAll: true,
                placeholder: jQuery('.af-js-banners-add-edit-multiple-cats').attr( 'data-placeholder' ),
            });
				}
		}

		if ( afCurrentUrl.indexOf( 'admin.php?page=openaffiliates&tab=integrations' ) !== -1 ){
				jQuery('.af-js-do-switch-value').on('change', function(){
						var type = jQuery(this).attr('data-type');
						var status = jQuery(this).is(':checked') ? 1 : 0;
						var inputHidden = jQuery(this).attr('data-target');
						jQuery.ajax({
									type 			: 'post',
									url 			: decodeURI( window.af_url )+'/wp-admin/admin-ajax.php',
									data 			: {
														 action : 'af_ajax_update_integrations_status',
														 type 	: type,
														 value	: status,
									},
									success		: function (data) {
											var statusAsLabel = (status === 1) ? jQuery( '.af-js-integration-status-for-' + type ).attr('data-enabled') : jQuery( '.af-js-integration-status-for-' + type ).attr('data-disabled');
											jQuery( '#' + inputHidden ).val( status );
											jQuery( '.af-js-integration-status-for-' + type ).html( statusAsLabel );
									}
						});

				});
		}


});

function afSendNotificationTest()
{
		jQuery.ajax({
					type : "post",
					url : decodeURI( window.af_url ) + '/wp-admin/admin-ajax.php',
					data : {
									 action						: "af_ajax_do_send_notification_test",
									 id								: jQuery('.af-js-notification-test-id').val(),
									 email						:jQuery( '.af-js-notification-test-email' ).val()
					},
					success: function (data) {
							afClosePopup();
					}
		});
}
jQuery( function() {
    jQuery('.af-addons-link-wrapp a').attr('target','_blank');
		jQuery('.af-ihc-link-wrapp a').attr('target','_blank');
});

function afDoCleanUpLogs()
{
		var olderThen = jQuery( '#af_older_then_select' ).val();
		jQuery.ajax({
					type : "post",
					url : decodeURI( window.af_url ) + '/wp-admin/admin-ajax.php',
					data : {
									 action						: "af_ajax_clean_notifications_logs",
									 older_then								: olderThen
					},
					success: function (data) {
							location.reload();
					}
		});
}

/* Reset de fábrica (Admin Workflow > Danger Zone) */
jQuery(document).ready(function(){
    var $input = jQuery('#af_reset_confirm');
    if ( !$input.length ){
        return;
    }
    var $buttons = jQuery('.af-reset-button');
    $input.on('input keyup change', function(){
        $buttons.prop('disabled', jQuery(this).val() !== 'RESET');
    });
    $buttons.on('click', function(e){
        e.preventDefault();
        if ( $input.val() !== 'RESET' ){
            return;
        }
        var $button = jQuery(this);
        var label = $button.text();
        $buttons.prop('disabled', true);
        $button.text(afI18n.resetWorking);
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'af_ajax_factory_reset',
                mode: $button.data('mode'),
                confirm: $input.val()
            },
            success: function(response){
                if ( response && response.success && response.data && response.data.redirect ){
                    window.location.href = response.data.redirect;
                    return;
                }
                alert( ( response && response.data && response.data.message ) ? response.data.message : afI18n.resetError );
                $button.text(label);
                $buttons.prop('disabled', $input.val() !== 'RESET');
            },
            error: function(){
                alert(afI18n.resetError);
                $button.text(label);
                $buttons.prop('disabled', $input.val() !== 'RESET');
            }
        });
    });
});
