/*
 *Open Affiliates - Upload Image
 */
"use strict";
window.addEventListener( 'DOMContentLoaded', function(){
      jQuery( '.af-js-public-upload-image-data' ).each(function(e,html){
      AfAvatarCroppic.init({
          triggerId					           : jQuery( html ).attr( 'data-trigger_id' ),
          saveImageTarget		           : jQuery( html ).attr( 'data-save_image_target' ),
          cropImageTarget              : jQuery( html ).attr( 'data-crop_image_target' ),
          imageSelectorWrapper         : '.af-upload-image-wrapp',
          hiddenInputSelector          : '[name=' + jQuery( html ).attr( 'data-name' ) + ']',
          imageClass                   : 'af-member-photo',
          removeImageSelector          : jQuery( html ).attr( 'data-remove_selector' ),
          buttonId 					           : 'af-avatar-button',
          buttonLabel 			           : jQuery( html ).attr( 'data-button_label' ),
      });
    });
});
