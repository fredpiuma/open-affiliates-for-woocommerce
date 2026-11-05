<?php
namespace OpenAffiliates\Admin;

class UserProfile
{
    public $affiliate_id      = null;
    public $uid               = null;
    public $general_settings  = null;
    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        add_action( 'af_print_admin_page', [ $this, 'page' ], 10, 1 );
    }

    /**
     * @param string
     * @return string
     */
    public function page( $tab='' )
    {
        global $af_db, $wp_roles;
        if ( $tab != 'user_profile' ){
            return;
        }
        $this->affiliate_id = empty( $_GET['affiliate_id'] ) ? 0 : sanitize_text_field( $_GET['affiliate_id'] );
        $uid = $af_db->get_uid_by_affiliate_id( $this->affiliate_id );
		    $this->uid = $uid;
        require_once AF_PATH . 'classes/MLMGetChildren.class.php';
        $mlm = new \MLMGetChildren( $this->affiliate_id);
        $mlmParent = $af_db->mlm_get_parent( $this->affiliate_id );
        if ( empty( $mlmParent ) ){
            $mlmParent = '';
        } else {
            $parentUid = $af_db->get_uid_by_affiliate_id( $mlmParent );
            $mlmParent = $af_db->get_username_by_wpuid( $parentUid );
        }
		    $this->general_settings = $af_db->return_settings_from_wp_option('general-settings');
        $currentRank = $af_db->get_affiliate_rank(0, $uid);
        $allRanks = $af_db->get_ranks( true );
        $allRanks = af_reorder_ranks( (array)$allRanks );
        if ( $allRanks ){
            foreach ( $allRanks as $rankArrayId => $rankData ){
                if ( $rankData->id == $currentRank ){
                    $nextRankId = $rankArrayId + 1;
                    break;
                }
            }
        }
        if ( isset($nextRankId) && isset( $allRanks[$nextRankId] ) ){
            $nextRankData = (array)$allRanks[$nextRankId];
        } else {
            $nextRankData = false;
        }

        $publicProfilePageID = get_option('af_general_user_page');
        $affiliatePublicProfile = get_permalink($publicProfilePageID);
        $affiliatePublicProfile = add_query_arg('aid', $this->affiliate_id, $affiliatePublicProfile );
        $previewPublicProfile = $affiliatePublicProfile;

        $data = [
                  'uid'                 => $uid,
				          'affiliate_id'        => $this->affiliate_id,
                  'user_name'           => $af_db->get_username_by_wpuid( $uid ),
                  'user_email'          => $af_db->get_email_by_uid( $uid ),
                  'custom_slug'         => ($af_db->is_magic_feat_enable('custom_affiliate_slug')) ? $af_db->get_custom_slug_for_uid( $uid ) : false,
                  'full_name'           => $af_db->get_wp_full_name( $uid ),
                  'member_since'        => af_convert_date_to_us_format( $af_db->getRegisterDate( $uid ) ),
                  'description'         => get_user_meta( $uid, 'description', true ),
				          'role'				        => isset( $wp_roles->roles[$af_db->get_user_first_role( $uid )]['name'] ) ? $wp_roles->roles[$af_db->get_user_first_role( $uid )]['name'] : '',
                  'avatar'              => af_get_avatar_for_uid( $uid ),
                  'current_rank_data'   => $af_db->get_rank( $currentRank ),
                  'next_rank_data'      => $nextRankData,
                  'stats'               => $af_db->get_stats_for_reports( '', $this->affiliate_id ),
                  'user_meta'           => $af_db->getAllUserMeta( $uid ),
                  'mlm'                 => $this->printMlm( $this->affiliate_id, $af_db->get_username_by_wpuid( $uid ) ),
                  'coupons'             => ($af_db->is_magic_feat_enable('coupons')) ? $af_db->get_coupons_for_affiliate( $this->affiliate_id ) : false,
                  'last_ten_referrals'  => $af_db->get_referrals( $limit=10, 0, false, 'r.date', 'DESC', [ 'r.affiliate_id = ' . $this->affiliate_id]),
                  'cpm'                 => $af_db->getCPMForAffiliate( $this->affiliate_id ),
				          'genera_settings'     => $this->general_settings,
				          'affiliate_link'		  => $this->getAffiliateLink(),
                  'currency'            => afCurrency(),
                  'bonus_enabled'       => $af_db->is_magic_feat_enable('bonus_on_rank'),
                  'sign_up_enabled'     => $af_db->is_magic_feat_enable('sign_up_referrals'),
                  'default_sign_up_referrals'  => get_option( 'af_sign_up_amount_default' ),
                  'lifetime_commission' => $af_db->is_magic_feat_enable('lifetime_commissions'),
                  'reccuring_referrals' => $af_db->is_magic_feat_enable('reccuring_referrals'),
                  'pay_per_click'       => $af_db->is_magic_feat_enable('pay_per_click'),
                  'cpm_commission'      => $af_db->is_magic_feat_enable('cpm_commission'),
                  'referrals_stats'     => $af_db->get_stats_for_referrals('', $this->affiliate_id) + $af_db->getReferralsReports( $this->affiliate_id ),
                  'payment_stats'       => $af_db->get_stats_for_payments($this->affiliate_id),
                  'count_payments_pending'    => $af_db->getCountPendingPaymentsForAffiliate( $this->affiliate_id ),
                  'count_payments_completed'  => $af_db->getCountCompletePaymentsForAffiliate( $this->affiliate_id ),
                  'payments_settings'   => $af_db->get_affiliate_payment_settings( $uid ),
                  'landing_pages'       => $af_db->is_magic_feat_enable( 'landing_pages' ) ? $af_db->getLandingPagesForAffiliate( $this->affiliate_id ) : false,
                  'referrer_links'      => $af_db->is_magic_feat_enable( 'simple_links' ) ? $af_db->simple_links_get_items_for_affiliate( $this->affiliate_id ) : false,
                  'ranking_possition'   => $af_db->affiliateGetRanking( $this->affiliate_id),
                  'number_of_affiliates' => $af_db->countAffiliates(),
                  'campaigns'             => $af_db->get_campaigns_reports_for_affiliate_id( $this->affiliate_id, 10, -1, false, 'id', 'DESC' ),
                  'statsForLast30'      => $af_db->getReferralsCountsForLastDays( $this->affiliate_id, 30 ),
                  'public_profile_preview'      => $previewPublicProfile,
        ];

        $view = new \OpenAffiliates\AfView();
        $output = $view->setTemplate( AF_PATH . 'admin/views/user-profile.php' )
                  ->setContentData( $data )
                  ->getOutput();
        echo esc_af_content( $output );
    }

    /**
     * @param int
     * @param string
     * @return string
     */
    private function printMlm( $affiliateId=0, $affiliateUsername='' )
    {
        global $af_db;
        require_once AF_PATH . 'classes/MLMGetChildren.class.php';
        $children_object = new \MLMGetChildren($affiliateId);
        $data = [
                  'items'         => $children_object->get_results(),
                  'parent'        => $af_db->mlm_get_parent($affiliateId),
                  'affiliate_id'  => $affiliateId,
        ];
        if (empty($data['parent'])){
            $data['parent'] = '';
        } else {
            $parentUid = $af_db->get_uid_by_affiliate_id($data['parent']);
            $data['parent'] = $af_db->get_username_by_wpuid($parentUid);
        }
        $view = new \OpenAffiliates\AfView();
        return $view->setTemplate( AF_PATH . 'admin/views/mlm-view_affiliate_children.php' )
                  ->setContentData( [ 'data' => $data, 'affiliate_name' => $affiliateUsername ], true )
                  ->getOutput();
    }

    /**
     * @param none
     * @return string
     */
  	private function getAffiliateLink()
    {
    		$link_for_aff = get_option('af_referral_custom_base_link');
    		if (empty($link_for_aff)){
    				$link_for_aff = get_home_url();
    		}

    	  $link = '';
    	  $value = $this->affiliate_id;
    	  $param = 'ref';

    	  if (!empty($this->general_settings['af_referral_variable'])){
    		  $param = $this->general_settings['af_referral_variable'];
    	  }
    	  if (!empty($this->general_settings['af_default_ref_format']) && $this->general_settings['af_default_ref_format']=='username'){
    		    $user_info = get_userdata($this->uid);
    		    if (!empty($user_info->user_login)){

    			      $value = urlencode($user_info->user_login);
    		    }
    	  }
    	  $link = af_create_affiliate_link($link_for_aff, $param, $value);
    		return $link;
  	}

}
