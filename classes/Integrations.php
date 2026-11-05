<?php
// Since version8.9
/*
How to use:
\OpenAffiliates\Integrations::isWooActive()
\OpenAffiliates\Integrations::isUmpActive()
\OpenAffiliates\Integrations::isEddActive()
\OpenAffiliates\Integrations::isUlpActive()
\OpenAffiliates\Integrations::isWpFormsActive()
\OpenAffiliates\Integrations::isNinjaActive()
\OpenAffiliates\Integrations::isCf7Active()
*/
namespace OpenAffiliates;
class Integrations
{
    /**
     * @param none
     * @return none
     */
    public function __construct(){}

    /**
      * @param none
      * @return array
      */
    public static function getSystems()
    {
        $systems = array(
             			 	'woo' => array(
             			 			'label' => esc_html__('WooCommerce', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('This integration ensures accurate tracking and seamless commission management for all your WooCommerce transactions', 'openaffiliates'),
             			 			'status' => self::isWooActive() && af_is_woo_active() ? 1 : 0,
             			 			'extra-details-link' => AF_DOCS_URL,
             			 			'extra-settings-link' => '',
             						'installed' => af_is_woo_active() ? 1 : 0,
             			 	),
             			 	'ump' => array(
             			 			'label' => esc_html__('Ultimate Membership Pro', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Reward affiliates for referring new members and selling memberships via your membership site', 'openaffiliates'),
             			 			'status' => self::isUmpActive() && af_is_ump_active() ? 1 : 0,
             			 			'extra-details-link' => '',
             			 			'extra-settings-link' => '',
             						'installed' => af_is_ump_active() ? 1 : 0,
             			 	),
             			 	'edd' => array(
             			 			'label' => esc_html__('Easy Digital Downloads', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Enhance your affiliate program with precise tracking and efficient commission management for your EDD store', 'openaffiliates'),
             			 			'status' => self::isEddActive() && af_is_edd_active() ? 1 : 0,
             			 			'extra-details-link' => AF_DOCS_URL,
             			 			'extra-settings-link' => '',
             						'installed' => af_is_edd_active() ? 1 : 0,
             			 	),
             			 	'ulp' => array(
             			 			'label' => esc_html__('Ultimate Learning Pro', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Easily integrate Ultimate Learning Pro to seamlessly track and reward your affiliates for promoting and selling your online courses', 'openaffiliates'),
             			 			'status' => self::isUlpActive() && af_is_ulp_active() ? 1 : 0,
             			 			'extra-details-link' => '',
             			 			'extra-settings-link' => '',
             						'installed' => af_is_ulp_active() ? 1 : 0,
             			 	),
             				'cf7' => array(
             			 			'label' => esc_html__('Contact Form 7', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Effectively reward your affiliates for every Contact Form 7 submitted by referred users', 'openaffiliates'),
             			 			'status' => self::isCf7Active() && (af_is_cf7_active() && self::cf7AddonActive() ) ? 1 : 0,
             			 			'extra-details-link' => '',
             			 			'extra-settings-link' => admin_url('admin.php?page=openaffiliates&tab=af_cf7t'),
             						'installed' => (af_is_cf7_active() && self::cf7AddonActive() ) ? 1 : 0,
             			 	),
             				'wpforms' => array(
             			 			'label' => esc_html__('WPForms', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Allocate commissions to your affiliates for each WPForms submission', 'openaffiliates'),
             			 			'status' => self::isWpFormsActive() && (af_is_wpforms_active() && self::wpformsAddonActive()) ? 1 : 0,
             			 			'extra-details-link' => AF_DOCS_URL,
             			 			'extra-settings-link' => admin_url('admin.php?page=openaffiliates&tab=af_wp_forms'),
             						'installed' => (af_is_wpforms_active() && self::wpformsAddonActive()) ? 1 : 0,
             			 	),
             				'ninjaforms' => array(
             			 			'label' => esc_html__('Ninja Forms', 'openaffiliates'),
             			 			'author' => 'Open Affiliates',
             			 			'author-link' => AF_REPO_URL,
             			 			'description' => esc_html__('Pay off affiliates for every Ninja Form submission', 'openaffiliates'),
             			 			'status' => self::isNinjaActive() && ( ( af_is_ninjaforms_active() || af_is_ninjaformsdemo_active() ) && self::ninjaAddonActive()) ? 1 : 0,
             			 			'extra-details-link' => AF_DOCS_URL,
             			 			'extra-settings-link' => admin_url('admin.php?page=openaffiliates&tab=af_nft'),
             						'installed' => ( ( af_is_ninjaforms_active() || af_is_ninjaformsdemo_active() ) && self::ninjaAddonActive()) ? 1 : 0,
             			 	),
 			 );
       $systems = apply_filters( 'af_filter_integrations_systems', $systems );
       return $systems;
    }

    /**
      * @param none
      * @return int
      */
    public static function isWooActive()
    {
        $option = get_option( 'af-integrations-woo', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isUmpActive()
    {
        $option = get_option( 'af-integrations-ump', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isUlpActive()
    {
        $option = get_option( 'af-integrations-ulp', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isEddActive()
    {
        $option = get_option( 'af-integrations-edd', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isNinjaActive()
    {
        $option = get_option( 'af-integrations-ninjaforms', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isCf7Active()
    {
        $option = get_option( 'af-integrations-cf7', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function isWpFormsActive()
    {
        $option = get_option( 'af-integrations-wpforms', 1 );
        if ( $option === null || $option === '' || $option === false ){
            return 1;
        }
        return (int)$option;
    }

    /**
      * @param none
      * @return int
      */
    public static function ninjaAddonActive()
    {
        if ( !function_exists( 'is_plugin_active' ) ){
      			include_once ABSPATH . 'wp-admin/includes/plugin.php';
      	}
      	if ( is_plugin_active( 'af-ninja-forms-tracking/af-ninja-forms-tracking.php' ) ){
      			return true;
      	}
      	return false;
    }

    /**
      * @param none
      * @return int
      */
    public static function cf7AddonActive()
    {
        if ( !function_exists( 'is_plugin_active' ) ){
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if ( is_plugin_active( 'af-cf7-tracking/af-cf7-tracking.php' ) ){
            return true;
        }
        return false;
    }

    /**
      * @param none
      * @return int
      */
    public static function wpformsAddonActive()
    {
        if ( !function_exists( 'is_plugin_active' ) ){
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if ( is_plugin_active( 'af-wp-forms/af-wp-forms.php' ) ){
            return true;
        }
        return false;
    }

    public static function update( $type='', $value='' )
    {
        update_option( 'af-integrations-' . $type, $value );
    }

}
