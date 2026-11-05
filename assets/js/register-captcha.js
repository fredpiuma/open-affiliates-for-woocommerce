/*
 *Open Affiliates - ReCaptcha
 */
"use strict";
//"ready" method name established by Google, NOT jQuery Event and no JjQuery On Method is applicable
jQuery( window ).on( 'load', function(){
    grecaptcha.ready(function() {
        var afCaptchaKey = jQuery( '.af-js-register-captcha-key' ).attr('data-value');
        grecaptcha.execute( afCaptchaKey, { action: 'homepage' } ).then(function(token) {
            // console.log( afCaptchaKey );
            // console.log( token );
            jQuery('.js-af-recaptcha-v3-item').html('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
        });
    });
});
