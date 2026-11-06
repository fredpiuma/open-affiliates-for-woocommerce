<?php
namespace OpenAffiliates;

class UploadFilesSecurity
{
    public function __construct()
    {
        if ( is_admin() ){
            return;
        }
        add_action( 'init', array( $this, 'process' ), 999 );
        add_action( 'af_on_register_action', array( $this, 'removeCookieAndMediaHash'), 999 );
    }

    public function process()
    {
        global $af_db;
        $currentUri = af_current_url();
        if ( !afIsRegisterPage($currentUri) ){
            return;
        }
        $registerFields = $af_db->register_get_custom_fields();
        $key = af_array_value_exists( $registerFields, 'file', 'type' );
        do {
            $hash = af_random_string( 18 );
        } while ( $af_db->doesMediaHashExists( $hash ) );
        $af_db->saveMediaHash( $hash );
        setcookie( 'afMedia', $hash, time() + 3600, COOKIEPATH, COOKIE_DOMAIN, false );
    }

    public function removeCookieAndMediaHash()
    {
        global $af_db;
        if ( !isset( $_COOKIE['afMedia'] ) ){
            return;
        }
        $hash = $_COOKIE['afMedia'];
        if ( $af_db->doesMediaHashExists( $hash ) ){
            $af_db->deleteMediaHash( $hash );
        }
        unset( $_COOKIE['afMedia'] );
    }
}
