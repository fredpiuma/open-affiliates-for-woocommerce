<?php
namespace OpenAffiliates;

class InfoAffiliateBar
{
    private $currentPermalink         = '';
    private $uid                      = 0;
    private $affiliateId              = 0;
    private $postId                   = 0;
    private $settings                 = [];
    private $userSettings             = null;

    public function __construct()
    {
        global $af_db;
        $this->settings = $af_db->return_settings_from_wp_option( 'info_affiliate_bar' );
        if ( !$this->settings['af_info_affiliate_bar_enabled'] ){
            return;
        }
        $this->processCookie();
        if ( !empty($_COOKIE['af_info_affiliate_bar_hide']) ){
            return;
        }
        $this->currentPermalink = AF_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        add_action( 'init', [$this, 'run'], 999);
    }

    public function processCookie()
    {
        if ( !isset($_POST['af_info_affiliate_bar_hide']) ){
            return false;
        }
        if ( sanitize_text_field($_POST['af_info_affiliate_bar_hide']) ){
            setcookie( 'af_info_affiliate_bar_hide', 1, time() + 60 * 60 * 24, '/', $_SERVER['HTTP_HOST'] );
        } else {
            setcookie( 'af_info_affiliate_bar_hide', 0, time() - 10, '/', $_SERVER['HTTP_HOST'] );
        }
    }

    public function run()
    {
        global $af_db;
        $this->postId = $af_db->getPostIdByUrl( $this->currentPermalink );
        if ( $this->postId && $this->postId==get_option( 'af_general_user_page' ) ){
            return;
        }
        $this->uid = af_get_uid();
        if ( !$this->uid ){
            return;
        }
        $this->userSettings = $af_db->getIabUserSettings( $this->uid );
        $show = $this->userSettings['iab_enable_bar'];
        if ( isset($_POST['iab_enable_bar']) && sanitize_text_field($_POST['iab_enable_bar'])==0 ){
            $show = 0;
        } else if ( isset($_POST['iab_enable_bar']) && sanitize_text_field($_POST['iab_enable_bar'])==1 ){
            $show = 1;
        }
        if ( !$show ){
            return;
        }
        $this->affiliateId = $af_db->get_affiliate_id_by_wpuid( $this->uid );
        if ( !$this->affiliateId ){
            return;
        }
        add_action( 'wp_footer', [ $this, 'output' ], 9999, 0 );
        add_action( 'wp_head', [ $this, 'style'], 9999 );
        add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
    }


    public function scripts()
    {
        wp_enqueue_script( 'af_iml_popover_js', AF_URL . 'assets/js/iml.min.js', ['jquery'], '9.4', false );
        wp_enqueue_style( 'af_iml_popover_css', AF_URL . 'assets/css/iml-styles.css', [], false, 'all' );
        wp_enqueue_script( 'af-info-affiliate-bar', AF_URL . 'assets/js/info-affiliate-bar.js', ['jquery'], '9.4' );

        if ( af_is_social_share_intalled_and_active() && get_option('af_info_affiliate_bar_social_shortcode') ){
            // since 9.2
            if (!defined('ISM_BASE_PATH_JS')){
              global $wp_version;
              if ( version_compare ( $wp_version , '5.7', '>=' ) ){
                  wp_add_inline_script( 'ism_front_end_f', "var ism_base_path='" . get_site_url() . "';" );
              } else {
                  wp_localize_script( 'ism_front_end_f', 'ism_base_path', get_site_url() );
              }
              define('ISM_BASE_PATH_JS', 1);//include variable just one time
            }
            // end of 9.2
            wp_enqueue_script( 'ism_front_end_f' );
        }

    }

    public function output()
    {
        global $af_db;
        $AffiliateMarketingBuilder = new \OpenAffiliates\AffiliateMarketingBuilder();
        $AffiliateMarketingBuilder->setUid( $this->uid )->setAffiliateId( $this->affiliateId )->setCurrentPermalink( $this->currentPermalink );
        $statistics = new \OpenAffiliates\AffiliateStatistics();
        $profilePageId = get_option( 'af_general_user_page' );
        $profilePermalink = '#';
        if ( $profilePageId ){
            $profilePermalink = get_permalink( $profilePageId );
            $profilePermalink = add_query_arg( 'af_aff_subtab', 'edit_account', $profilePermalink );
            $settingsPermalink = add_query_arg( 'af_aff_subtab', 'iab_settings', $profilePermalink );
            $tipsPermalink = add_query_arg( 'af_aff_subtab', 'iab_tips', $profilePermalink );
        }
        $data = [
                  'affiliateCurrentLink'    => $AffiliateMarketingBuilder->getPermalinkForAffiliate(),
                  'socialLinks'             => $AffiliateMarketingBuilder->getSocial(),
                  'generalVisits'           => $statistics->getGeneralVisitsForPermalink($this->currentPermalink),
                  'generalReferrals'        => $statistics->getGeneralReferralsForPermalink($this->currentPermalink),
                  'personalVisits'          => $statistics->getPersonalVisitsForPermalink($this->currentPermalink, $this->affiliateId),
                  'personalReferrals'       => $statistics->getPersonalReferralsForPermalink($this->currentPermalink, $this->affiliateId),
                  'settings'                => $this->settings,
                  'profile_permalink'       => $profilePermalink,
                  'settings_permalink'      => $settingsPermalink,
                  'tips_permalink'          => $tipsPermalink,
                  'uid'                     => $this->uid,
                  'affiliate_id'            => $this->affiliateId,
                  'banner'                  => $AffiliateMarketingBuilder->getBannerForPermalink(),
        ];

        /// default banner
        if ( !$data['banner'] && $this->settings['af_info_affiliate_bar_banner_default_value'] ){
            $data['banner'] = $AffiliateMarketingBuilder->getDefaultBAnnerForPermalink();
        }
        $data['bannerSection'] = $this->bannerSection( $data['banner'] );
        $data['links_section'] = $this->linksSection( $data['affiliateCurrentLink'] );

        $viewObject = new \OpenAffiliates\AfView();
        $output = $viewObject->setTemplate( AF_PATH . 'public/views/info_affiliate_bar.php' )->setContentData( $data )->getOutput();
        echo esc_af_content($output);
    }

    private function linksSection( $affiliateLink='' )
    {
        global $af_db;
        $data = [
                  'affiliate_id'            => $this->affiliateId,
                  'print_username'          => '',
                  'url'                     => $affiliateLink,
                  'friendly_links'          => $af_db->is_magic_feat_enable('friendly_links'),
                  'custom_affiliate_slug'   => $af_db->is_magic_feat_enable('custom_affiliate_slug'),
                  'the_slug'                => $af_db->get_custom_slug_for_uid($this->uid),
                  'af_default_ref_format'  => get_option('af_default_ref_format'),
                  'ref_type'                => (get_option('af_default_ref_format')=='username') ? esc_html__('Username', 'openaffiliates') : 'Id',
        ];

        if ($data['custom_affiliate_slug'] && !empty($the_slug) ){
            $data['url'] = $this->create_link_for_aff($data['url'], $data['the_slug']);
        }
        if ( $data['af_default_ref_format']=='username' && $this->uid ){
          $user_info = get_userdata($this->uid);
          $data['print_username'] = (empty($user_info->user_login)) ? '' : $user_info->user_login;
        }
        $viewObject = new \OpenAffiliates\AfView();
        return $viewObject->setTemplate( AF_PATH . 'public/views/info_affiliate_bar-links.php' )->setContentData( $data )->getOutput();
    }

    private function bannerSection( $banner='' )
    {
        global $af_db;
        $data = [
                  'banner'                  => $banner,
                  'affiliate_id'            => $this->affiliateId,
                  'uid'                     => $this->uid,
        ];
        $viewObject = new \OpenAffiliates\AfView();
        return $viewObject->setTemplate( AF_PATH . 'public/views/info_affiliate_bar-banner.php' )->setContentData( $data )->getOutput();
    }

    public function style()
    {
        $viewObject = new \OpenAffiliates\AfView();
        $output = $viewObject->setTemplate( AF_PATH . 'public/views/info_affiliate_bar-style.php' )->setContentData( [] )->getOutput();
        echo esc_af_content($output);
    }


}
