/*
 *Open Affiliates - WP Editor buttons
 */
(function (){
	"use strict";
	tinymce.PluginManager.add('af_button_forms', function(ed, url) {
        // Add a button that opens a window
        ed.addButton('af_button_forms', {
            icon: 'af_btn_forms',
						title : 'Affiliates ShortCodes',
            type: "button",
            text : "",
            cmd : "af_forms_popup"
        });

        ///LOAD POPUP
        ed.addCommand('af_forms_popup', function() {
		         url = url.replace('assets/js', '');
			    	 jQuery.ajax({
			    	     type : "post",
			    	     url : decodeURI(window.af_url)+'/wp-admin/admin-ajax.php',
			    	     data : {
			    	                action: "af_ajax_admin_popup_the_shortcodes",
			    	     },
			    	     success: function (data) {
			    	    	 jQuery(data).hide().appendTo('body').fadeIn('normal');
			    	     }
			    	 });
        });

        ed.addCommand('af_return_text', function(text){
	        	ed.execCommand('mceInsertContent', 0, text);
	        	afClosePopup();
        });

				// constants for notifications
				if ( jQuery('.af-tag-code').length > 0 ){
						jQuery('.af-tag-code').on('click', function(){
								ed.execCommand('mceInsertContent', 0, jQuery(this).html() );
						});
				}
				// end of constants 

    });
})();
