<?php
namespace OpenAffiliates;

class AfGDPR
{
  private $pluginName = 'Open Affiliates';
  private $uid = 0;
  private $affiliateId = 0;

  public function __construct()
  {
      add_action('admin_init', array($this, 'privacyPolicy'));
      add_filter('wp_privacy_personal_data_exporters', array($this, 'registerExport') );
      add_filter('wp_privacy_personal_data_erasers', array($this, 'registerErase') );
  }

  public function privacyPolicy()
  {
      if (!function_exists('wp_add_privacy_policy_content')){
         return;
      }
      $policyText = '';
      wp_add_privacy_policy_content($this->pluginName, $policyText);
  }

  public function registerExport($exporters=array())
  {
      $exporters['af-exporter'] = array(
          'exporter_friendly_name'	=> $this->pluginName,
          'callback'		          	=> array($this, 'doExport'),
      );
      return $exporters;
  }

  public function registerErase($erasers=array())
  {
      $erasers['af-eraser'] = array(
          'eraser_friendly_name'    => $this->pluginName,
          'callback'                => array($this, 'doErase'),
      );

      return $erasers;
  }

    /*
      Export data from the following tables:
          af_affiliates
          af_offers_affiliates_reference
          af_campaigns
          af_payments
          af_ranks_history
          af_coupons_code_affiliates
          af_reports
          af_ref_links
    */
    public function doExport($emailAddress='', $page=1)
    {
      global $af_db;
      $user = get_user_by( 'email', $emailAddress );
      $this->uid = isset($user->ID) ? $user->ID : 0;
      $this->affiliateId = $af_db->get_affiliate_id_by_wpuid($this->uid);
      $done = false;

      if (empty($this->uid) || empty($this->affiliateId)){
          return array(
            'data' => array(),
            'done' => 0
          );
      }

      $userMetas = $this->getUserMetas();
      if ($userMetas && count($userMetas)){
          $done = true;
      }
      $affiliateTableData = $this->getAffiliateTableData();
      if ($affiliateTableData && count($affiliateTableData)){
          $done = true;
      }
      $offers = $this->getOffers();
      if ($offers && count($offers)){
          $done = true;
      }
      $campaigns = $this->getCampaigns();
      if ($campaigns && count($campaigns)){
          $done = true;
      }
      $payments = $this->getPayments();
      if ($payments && count($payments)){
          $done = true;
      }
      $rankHistory = $this->getRanksHistory();
      if ($rankHistory && count($rankHistory)){
          $done = true;
      }
      $coupons = $this->getCouponsCode();
      if ($coupons && count($coupons)){
          $done = true;
      }
      $reports = $this->getReports();
      if ($reports && count($reports)){
          $done = true;
      }
      $refLinks = $this->getRefLinks();
      if ($refLinks && count($refLinks)){
          $done = true;
      }

      $exportData = array(
          $userMetas,
          $affiliateTableData,
          $offers,
          $campaigns,
          $payments,
          $rankHistory,
          $coupons,
          $refLinks,
      );

      return array(
        'data' => $exportData,
        'done' => 1
      );
    }

    /*
      Delete data from the following tables:
			    usermeta (all af usermetas)
          af_affiliates
          af_offers_affiliates_reference
          af_campaigns
          af_payments
          af_ranks_history
          af_coupons_code_affiliates
          af_reports
          af_ref_links
    */
  public function doErase($emailAddress='', $page=1)
  {
      global $af_db, $wpdb;
      $user = get_user_by( 'email', $emailAddress );
      $this->uid = isset($user->ID) ? $user->ID : 0;
      $this->affiliateId = $af_db->get_affiliate_id_by_wpuid($this->uid);
      $done = false;

      if (empty($this->uid) || empty($this->affiliateId)){
          return array(
            'data' => array(),
            'done' => 0
          );
      }

      /// usermeta
      $query = "DELETE FROM {$wpdb->usermeta}
                          WHERE
                          user_id={$this->uid}
                          AND
                          meta_key LIKE '%af_%' ";
      $wpdb->query( $query );
      /// af_affiliates
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_affiliates WHERE uid=%d;", $this->uid );
      $wpdb->query( $query );
      /// af_offers_affiliates_reference
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_offers_affiliates_reference WHERE affiliate_id=%d;", $this->affiliateId );
      $wpdb->query( $query );
      /// af_campaigns
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_campaigns WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );
      /// af_payments
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_payments WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );
      /// af_ranks_history
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_ranks_history WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );
      /// af_coupons_code_affiliates
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_coupons_code_affiliates WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );
      /// af_reports
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_reports WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );
      /// af_ref_links
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}af_ref_links WHERE affiliate_id=%d ", $this->affiliateId );
      $wpdb->query( $query );

      return array(
          				'items_removed' => true,
          				'items_retained' => false,
           				'messages' => array( '' ),
           				'done' => 1,
  		);
  }

  private function getUserMetas()
  {
      global $wpdb;
      $query = $wpdb->prepare( "SELECT meta_key, meta_value
                                    FROM {$wpdb->usermeta}
                                    WHERE
                                    meta_key LIKE '%af_%'
                                    AND
                                    user_id=%d ", $this->uid );
      $dataDb = $wpdb->get_results( $query );
      if (!$dataDb){
          return false;
      }
      $data = array();
      foreach ($dataDb as $object){
        $data[] = array(
              'name'  => $object->meta_key,
              'value' => $object->meta_value,
        );
      }

      return array(
            'group_id'    => 'af_usermetas',
            'group_label' => esc_html__('Open Affiliates user metas'),
            'item_id'     => 'af_usermetas' . $this->uid,
            'data'        => $data,
      );
  }

  private function getAffiliateTableData()
  {
      global $wpdb;
      $query = $wpdb->prepare( "
                                SELECT 	rank_id, start_data, status
                                    FROM {$wpdb->prefix}af_affiliates
                                    WHERE uid=%d
      ", $this->uid );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
      $data[] = array(
            'name'  => 'Entry',
            'value' => 'Rank Id' . $object->rank_id
                        . ', start time: ' . $object->start_data
                        . ', status: ' . $object->status,
      );
      }
      return array(
          'group_id'    => 'af_affiliates',
          'group_label' => esc_html__('Open Affiliates affiliate data'),
          'item_id'     => 'af_affiliates' . $this->uid,
          'data'        => $data,
      );
  }

  private function getOffers()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT source, products
            FROM {$wpdb->prefix}af_offers_affiliates_reference
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
      $data[] = array(
            'name'  => 'Entry',
            'value' => ' source: ' . $object->source
                       . ', products: ' . $object->products,
      );
      }
      return array(
          'group_id'    => 'af_offers_affiliates_reference',
          'group_label' => esc_html__('Open Affiliates offers data'),
          'item_id'     => 'af_offers_affiliates_reference' . $this->uid,
          'data'        => $data,
      );
  }

  private function getCampaigns()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT name, referrals, visit_count, unique_visits_count
            FROM {$wpdb->prefix}af_campaigns
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
        $data[] = array(
              'name'  => 'Entry',
              'value' => 'Name: ' . $object->name
                         . ', referrals: ' . $object->referrals
                         . ', visit count: ' . $object->visit_count
                         . ', unique visits count: ' . $object->unique_visits_count
        );
      }
      return array(
          'group_id'    => 'af_campaigns',
          'group_label' => esc_html__('Open Affiliates campaigns data'),
          'item_id'     => 'af_campaigns' . $this->uid,
          'data'        => $data,
      );
  }

  private function getPayments()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT 	payment_type,	transaction_id,	amount,
        				currency,	payment_details, create_date,	update_date,
        				status
            FROM {$wpdb->prefix}af_payments
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
      $data[] = array(
            'name'  => 'Entry',
            'value' => 'Payment type: ' . $object->payment_type
                       . ', transaction id: ' . $object->transaction_id
                       . ', amount: ' . $object->amount
                       . ', currency: ' . $object->currency
                       . ', payment details: ' . $object->payment_details
                       . ', create date: ' . $object->create_date
                       . ', update: ' . $object->update_date
                       . ', status: ' . $object->status
      );
      }
      return array(
          'group_id'    => 'af_payments',
          'group_label' => esc_html__('Open Affiliates payments data'),
          'item_id'     => 'af_payments' . $this->uid,
          'data'        => $data,
      );
  }

  private function getRanksHistory()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT prev_rank_id, rank_id,	add_date
            FROM {$wpdb->prefix}af_ranks_history
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
          $data[] = array(
                'name'  => 'Entry',
                'value' => 'Previous rank id: ' . $object->prev_rank_id
                           . ', rank id: ' . $object->rank_id
                           . ', date: ' . $object->add_date
          );
      }
      return array(
          'group_id'    => 'af_ranks_history',
          'group_label' => esc_html__('Open Affiliates rank history'),
          'item_id'     => 'af_ranks_history' . $this->uid,
          'data'        => $data,
      );
  }

  private function getCouponsCode()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT code, status
            FROM {$wpdb->prefix}af_coupons_code_affiliates
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
          $data[] = array(
                'name'  => 'Entry',
                'value' => 'Code: ' . $object->prev_rank_id
                           . ', status: ' . $object->status
          );
      }
      return array(
          'group_id'    => 'af_coupons_code_affiliates',
          'group_label' => esc_html__('Open Affiliates coupons code', 'openaffiliates'),
          'item_id'     => 'af_coupons_code_affiliates' . $this->uid,
          'data'        => $data,
      );
  }

  private function getReports()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT email,	period,	last_sent
            FROM {$wpdb->prefix}af_reports
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
          $data[] = array(
                'name'  => 'Entry',
                'value' => 'E-mail: ' . $object->email
                           . ', period: ' . $object->period
                           . ', last seen: ' . $object->last_sent
          );
      }
      return array(
          'group_id'    => 'af_reports',
          'group_label' => esc_html__('Open Affiliates reports', 'openaffiliates'),
          'item_id'     => 'af_reports' . $this->uid,
          'data'        => $data,
      );
  }

  private function getRefLinks()
  {
      global $wpdb;
      $query = $wpdb->prepare("
        SELECT url,	status
            FROM {$wpdb->prefix}af_ref_links
            WHERE affiliate_id=%d
      ", $this->affiliateId );
      $dataDb = $wpdb->get_results($query);
      if (!$dataDb){
        return false;
      }
      foreach ($dataDb as $object){
          $data[] = array(
                'name'  => 'Entry',
                'value' => 'URL: ' . $object->url
                           . ', status: ' . $object->status
          );
      }
      return array(
          'group_id'    => 'af_reports',
          'group_label' => esc_html__('Open Affiliates reports', 'openaffiliates'),
          'item_id'     => 'af_reports' . $this->uid,
          'data'        => $data,
      );
  }


}
