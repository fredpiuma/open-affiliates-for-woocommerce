/*
 *Open Affiliates - Guntengerg Block
 */
"use strict";
var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    blockStyle = {};

registerBlockType( 'open-affiliates-for-woocommerce/register-form', {
    title                 : 'Open Affiliates - Register Form',
    icon                  : 'universal-access-alt',
    category              : 'af-shortcodes',

    edit: function() {
        return el( 'p', '', '[af-register]' );
    },
    save: function() {
        return el( 'p', '', '[af-register]' );
    },
});

registerBlockType( 'open-affiliates-for-woocommerce/login-form', {
    title                 : 'Open Affiliates - Login Form',
    icon                  : 'universal-access-alt',
    category              : 'af-shortcodes',

    edit: function() {
        return el( 'p', '', '[af-login-form]' );
    },
    save: function() {
        return el( 'p', '', '[af-login-form]' );
    },
});

registerBlockType( 'open-affiliates-for-woocommerce/logout', {
    title                 : 'Open Affiliates - Logout',
    icon                  : 'universal-access-alt',
    category              : 'af-shortcodes',

    edit: function() {
        return el( 'p', '', '[af-logout]' );
    },
    save: function() {
        return el( 'p', '', '[af-logout]' );
    },
});

registerBlockType( 'open-affiliates-for-woocommerce/reset-password', {
    title                 : 'Open Affiliates - Reset Password',
    icon                  : 'universal-access-alt',
    category              : 'af-shortcodes',

    edit: function() {
        return el( 'p', '', '[af-reset-password]' );
    },
    save: function() {
        return el( 'p', '', '[af-reset-password]' );
    },
});

registerBlockType( 'open-affiliates-for-woocommerce/account-page', {
    title                 : 'Open Affiliates - Account Page',
    icon                  : 'universal-access-alt',
    category              : 'af-shortcodes',

    edit: function() {
        return el( 'p', '', '[af-account-page]' );
    },
    save: function() {
        return el( 'p', '', '[af-account-page]' );
    },
});
