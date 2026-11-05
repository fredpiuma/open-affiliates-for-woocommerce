<?php
namespace OpenAffiliates;

class WPMLActions
{
    public function __construct()
    {
        /// register notifications
        add_action( 'af_save_notification_action', array( $this, 'registerNotifications'), 99, 1 );

        /// save user language
        add_action( 'af_on_register_action', array( $this, 'saveUserLanguage' ), 999, 1 );
        add_action( 'af_on_update_action', array( $this, 'saveUserLanguage' ), 999, 1 );

        /// banners
        add_action( 'af_banners_save', array( $this, 'saveBanner' ), 999, 1 );
        add_action( 'af_banners_update', array( $this, 'saveBanner' ), 999, 1 );

        /// ranks
        add_action( 'af_ranks_save', array( $this, 'saveRank' ), 999, 1 );
        add_action( 'af_ranks_update', array( $this, 'saveRank' ), 999, 1 );

    }

    /// use af_save_notification_action just for trigger, we'll ignore the param
    public function registerNotifications( $notificationData=null )
    {
        global $wpdb;
        $query = "SELECT type, rank_id, subject, message, pushover_message FROM {$wpdb->prefix}af_notifications;";
        $data = $wpdb->get_results( $query );
        if ( !$data ){
            return;
        }
        $domain = 'openaffiliates';
        foreach ( $data as $object ){
                $name = $object->type . '_subject_' . $object->rank_id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->subject );
                $name = $object->type . '_message_' . $object->rank_id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->message );
                $name = $object->type . '_pushover_message_' . $object->rank_id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->pushover_message );
        }
    }

    public function saveUserLanguage( $uid=0 )
    {
        if ( !$uid ){
            return false;
        }
        $language = af_get_current_language_code();
        return update_user_meta( $uid, 'af_locale_code', $language );
    }

    public function saveBanner( $bannerData=array() )
    {
        global $wpdb;
        $query = "SELECT id, name, description FROM {$wpdb->prefix}af_banners;";
        $data = $wpdb->get_results( $query );
        if ( !$data ){
            return;
        }
        $domain = 'openaffiliates';
        foreach ( $data as $object ){
                $name = 'banner_name_'. $object->id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->name );
                $name = 'banner_name_' . $object->id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->description );
        }
    }

    public function saveRank( $rankData=array() )
    {
        global $wpdb;
        $query = "SELECT id, label FROM {$wpdb->prefix}af_ranks;";
        $data = $wpdb->get_results( $query );
        if ( !$data ){
            return;
        }
        $domain = 'openaffiliates';
        foreach ( $data as $object ){
                $name = 'rank_name_' . $object->id;
            do_action( 'wpml_register_single_string', $domain, $name, $object->label );
        }
    }

}
