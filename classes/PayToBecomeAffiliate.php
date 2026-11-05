<?php
namespace OpenAffiliates;

class PayToBecomeAffiliate
{
    private static $showBttn      = false;
    public function __construct()
    {
        global $af_db;
        if ( !get_option('af_pay_to_become_affiliate_enabled') ){
            return;
        }

        if ( \OpenAffiliates\Integrations::isUmpActive() === 1 ){
            add_action('ump_payment_check', array($this, 'checkUmpOrder'), 1, 2);
        }
        if ( \OpenAffiliates\Integrations::isWooActive() === 1 ){
            add_action('woocommerce_order_status_completed', array($this, 'checkWooOrder'), 1, 1);
        }

        add_filter( 'af_become_affiliate_bttn', array( $this, 'displayBecomeAffiliateBttn'), 10, 1 );
        add_filter( 'af_become_affiliate_warning_message', array( $this, 'returnWarningMessage' ), 10, 1 );
        add_filter( 'af_save_as_affiliate_filter', array( $this, 'saveAsAffiliateFilter'), 1, 1 );
    }


    public function checkUmpOrder($orderId=0, $type='')
    {
        global $af_db;
        if ( !$orderId ){
            return;
        }
        $type = get_option( 'af_pay_to_become_affiliate_target_product_group' );
        if ( $type != 'ump' ){
            return;
        }
        require_once IHC_PATH . 'classes/Orders.class.php';
        $object = new \Ump\Orders();
        $data = $object->get_data($orderId);
        if ( !$data ){
            return;
        }
        if ( !isset($data['status']) || $data['status']=='pending'){
            return;
        }
        /// check lid
        if ( !$af_db->doesProductPayForAffiliate( $data['lid'] ) ){
            return;
        }

        if ($data['status']=='Completed'){
            /// approve user
            return $this->doApproveAffiliate( $data['uid'] );
        }
    }

    public function checkWooOrder( $orderId=0 )
    {
        global $af_db;
        if ( !$orderId ){
            return;
        }
        $type = get_option( 'af_pay_to_become_affiliate_target_product_group' );
        if ( $type != 'woo' ){
            return;
        }
        $order = new \WC_Order( $orderId );
        if ( !$order ){
            return;
        }
        $items = $order->get_items();
        if ( !count($items) ){
            return;
        }
        foreach ($items as $item){ /// foreach in lines
            if ( $af_db->doesProductPayForAffiliate( $item['product_id'] ) ){
                return $this->doApproveAffiliate( (int)$order->user_id );
            }
        }
    }

    private function doApproveAffiliate( $uid=0 )
    {
        global $af_db;
        $affiliateId = $af_db->get_affiliate_id_by_wpuid( $uid );
        if ( !$affiliateId ){
            $affiliateId = $af_db->save_affiliate( $uid );
        }

        // deprecated since 9.2
        //$af_db->doApproveAffiliate( $affiliateId );
        //$af_db->setDefaultRoleForUser( $uid );
        // end of deprecated since 9.2
        $this->approveUserAsAffiliate( $affiliateId, $uid );


        /// mlm
        $MlmParent = get_user_meta( $uid, 'af_mlm_parrent_id_pending', true );
        if ( !$MlmParent || !$affiliateId ){
            return;
        }
        $af_db->set_mlm_relation_on_new_affiliate( $affiliateId, $MlmParent );
    }

    public function displayBecomeAffiliateBttn( $show=true )
    {
        global $current_user, $af_db;
        $uid = isset($current_user->ID) ? $current_user->ID : 0;
        if ( !$uid ){
            $show = false;
        }
        if ( !$af_db->canUserBecomeAffiliateUmpWooCheck( $uid ) ){
            $show = false;
        }
        self::$showBttn = $show;
        return $show;
    }

    public function returnWarningMessage( $message='' )
    {
        if ( !self::$showBttn ){
            $message = esc_html__('You are not allowed to become affiliate for the moment!', 'openaffiliates');
        }
        return $message;
    }

    public function saveAsAffiliateFilter( $save=true )
    {
        $allProducts = get_option( 'af_pay_to_become_affiliate_target_all_products' );
        if ( $allProducts ){
            return false;
        }
        $someProducts = get_option( 'af_pay_to_become_affiliate_target_products' );
        if ( $someProducts ){
            return false;
        }
        return $save;
    }

    /**
     * @param int
     * @param int
     * @return none
     */
    public function approveUserAsAffiliate( $affiliateId=0, $uid=0 )
    {
        global $af_db;

        $userRoles = $af_db->get_user_roles( $uid );
        if ( empty( $userRoles ) ){
            return $af_db->doApproveAffiliate( $affiliateId );
        } else if ( count( $userRoles ) === 1 && isset( $userRoles['pending_user'] ) && $userRoles['pending_user'] === 1 ){
            return $af_db->doApproveAffiliate( $affiliateId );
        }

        return af_send_user_notifications($uid, 'affiliate_account_approve');
    }


}
