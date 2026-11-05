<?php
namespace OpenAffiliates;

class ProductLinks
{
    private $moduleSettings = [];
    private $enableService = true;

    public function __construct()
    {
        global $af_db;
        $this->moduleSettings = $af_db->return_settings_from_wp_option( 'product_links' );
        if ( !$this->moduleSettings['af_product_links_enabled'] ){
            $this->enableService = false;
        }
        $uid = af_get_uid();
        if ( !$uid ){
            $this->enableService = false;
        }
        $affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
        if ( !$affiliateId || !$af_db->is_affiliate_active( $affiliateId ) ){
            $this->enableService = false;
        }
        $this->registerScripts();
    }

    public function registerScripts()
    {
        if ( !$this->enableService ){
            return;
        }
        wp_enqueue_script( 'af-public-links-js', AF_URL . 'assets/js/product_links.js', ['jquery'], '9.4', false );
        wp_enqueue_script( 'af-sweet-alert-js', AF_URL . 'assets/js/sweetalert.js', ['jquery'], '9.4', false );
        wp_enqueue_style( 'af-sweet-alert-css', AF_URL . 'assets/css/sweetalert.css', [], false, 'all' );
    }

    public function getOutput()
    {
        global $af_db;
        if ( !$this->enableService ){
            return;
        }
        $typeOfService = get_option( 'af_product_links_source' );
        $data = [
            'categories'        => $af_db->getCategoriesForServiceType( $typeOfService )
        ];
		    $data['showReward'] = get_option( 'af_product_links_reward_calculation' );
        $viewObject = new \OpenAffiliates\AfView();
        return $viewObject->setContentData( $data )->setTemplate( AF_PATH . 'public/views/product_links/product_links.php' )->getOutput();
    }

}
