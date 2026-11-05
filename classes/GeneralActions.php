<?php

namespace OpenAffiliates;

class GeneralActions
{

    public function __construct()
    {
        add_action( 'af_before_user_save_custom_field', array( $this, 'changeAvatar' ), 999, 3 );
    }

    public function changeAvatar( $uid='', $metaKey='', $metaValue='' )
    {
        if ( $metaKey != 'af_avatar' || $metaValue == '' ){
            return;
        }
        $oldValue = get_user_meta( $uid, 'af_avatar', true );
        if ( !$oldValue || $oldValue == $metaValue ){
            return;
        }
        if ( strpos( $oldValue, "http" ) === 0 ){
            return;
        }
        /// delete old avatar
        wp_delete_attachment( $oldValue, true );

    }


}
