<?php
namespace OpenAffiliates;

class CPM
{
    private $affiliateId = 0;
    private $limit = 1000;

    public function __construct($affiliateId=0)
    {
        global $af_db;
        if (!$af_db->is_magic_feat_enable('cpm_commission')){
            return;
        }
        $this->affiliateId = $affiliateId;
        $this->trackTheVisit();
    }

    private function trackTheVisit()
    {
        $db = new \OpenAffiliates\Db\CPM($this->affiliateId);
        $theCount = $db->save();
        if (!$theCount){
            return false;
        }
        if ($theCount==$this->limit){
            $this->saveReferral();
            $db->reset();
        }
    }

    private function saveReferral()
    {
        global $af_db;
        $affiliateRank = $af_db->get_affiliate_rank($this->affiliateId);
        $amountValue = $af_db->getCPMValueForRank($affiliateRank);
        $currency = get_option('af_currency');
        $referralStatus = get_option('af_pay_per_click_default_referral_sts');

        $args = [
            'refferal_wp_uid' => 0,
            'campaign' => '',
            'affiliate_id' => $this->affiliateId,
            'visit_id' => '',
            'description' => 'cpm',
            'source' => 'cpm',
            'reference' => 0,
            'reference_details' => 'cpm',
            'amount' => $amountValue,
            'currency' => $currency,
            'date' => current_time( 'Y-m-d H:i:s' ),
            'status' => $referralStatus,
            'payment' => 0,
            'parent_referral_id' => '',
            'child_referral_id' => '',
        ];
        return $af_db->save_referral($args);
    }



}
