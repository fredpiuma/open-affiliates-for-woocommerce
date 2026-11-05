<?php
namespace OpenAffiliates\Migration;

class AffiliateWp extends \OpenAffiliates\Migration\AbstractMigrationService
{
    protected $entitiesList = array('affiliates', 'referrals');

    public function run()
    {
        switch ($this->entityType){
            case 'affiliates':
              $this->proceedAffiliates();
              break;
            case 'referrals':
              $this->proceedReferrals();
              break;
        }
        return $this;
    }

    private function proceedAffiliates()
    {
        global $wpdb, $af_db;
        $query = $wpdb->prepare("
                  SELECT user_id FROM {$wpdb->prefix}affiliate_wp_affiliates
                          LIMIT %d, %d
        ", $this->offset, $this->limit );
        $data = $wpdb->get_results($query);
        if (!$data){
            return;
        }
        $default_rank = empty($this->assignRank) ? get_option('af_register_new_user_rank') : $this->assignRank;
        foreach ($data as $object){
            $inserted = $af_db->save_affiliate($object->user_id);
            if ($inserted){
              $af_db->update_affiliate_rank_by_uid($object->user_id, $default_rank);
            }
        }
    }

    protected function proceedReferrals()
    {
        global $wpdb, $af_db;
        $query = $wpdb->prepare("SELECT a.referral_id, a.affiliate_id, a.visit_id, a.customer_id, a.description, a.status, a.amount, a.currency,
                                    a.custom, a.context, a.campaign, a.type, a.reference, a.products, a.payout_id, a.date, c.id as new_affiliate_id
                                        FROM {$wpdb->prefix}affiliate_wp_referrals a
                                        INNER JOIN {$wpdb->prefix}affiliate_wp_affiliates b
                                        ON a.affiliate_id=b.affiliate_id
                                        INNER JOIN {$wpdb->prefix}af_affiliates  c
                                        ON b.user_id=c.uid
                                        LIMIT %d, %d ;", $this->offset, $this->limit );
        $data = $wpdb->get_results($query);
        if (!$data){
            return;
        }
        foreach ($data as $object){
          $status = ($object->status=='paid') ? 2 : 0;
          $insertData = array(
              'refferal_wp_uid'     => $object->customer_id,
              'campaign'            => '',
              'affiliate_id'        => $object->new_affiliate_id,
              'visit_id'            => '',
              'description'         => $object->description,
              'source'              => $object->source,
              'reference'           => $object->reference,
              'parent_referral_id'  => '',
              'child_referral_id'   => '',
              'amount'              => $object->amount,
              'currency'            => $object->currency,
              'date'                => $object->date,
              'status'              => $status,
              'payment'             => '',
          );
          $af_db->save_referral($insertData);
        }
    }

    protected function countAffiliates()
    {
        global $wpdb;
        $query = "SELECT IFNULL(COUNT(user_id), 0) FROM {$wpdb->prefix}affiliate_wp_affiliates";
        return $wpdb->get_var($query);
    }

    protected function countReferrals()
    {
      global $wpdb;
      $query = "SELECT IFNULL(COUNT(referral_id), 0) FROM {$wpdb->prefix}affiliate_wp_referrals";
      return $wpdb->get_var($query);
    }
}
