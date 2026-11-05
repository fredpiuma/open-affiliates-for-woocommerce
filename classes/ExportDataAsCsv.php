<?php

namespace OpenAffiliates;

class ExportDataAsCsv
{
    private $typeOfData             = '';
    private $linkToDownload         = '';
    private $filters                = [];
    public function __construct() {}
    public function setTypeOfData($typeOfData = '')
    {
        $this->typeOfData = $typeOfData;
        return $this;
    }
    public function setFilters($filters = [])
    {
        $this->filters = $filters;
        return $this;
    }
    public function run()
    {
        switch ($this->typeOfData) {
            case 'affiliates':
                $this->affiliates();
                break;
            case 'visits':
                $this->visits();
                break;
            case 'referrals':
                $this->referrals();
                break;
            case 'payouts':
                $this->payouts();
                break;
        }
        return $this;
    }
    private function affiliates()
    {
        global $af_db;
        //
        $params = maybe_unserialize($this->filters);
        if (isset($params['limit'])) {
            $params['limit'] = false;
        }
        if (isset($params['offset'])) {
            $params['offset'] = false;
        }
        $params['order_by'] = 'a.id';
        $params['asc_or_desc'] = 'DESC';
        $manyAffiliates = $af_db->getAffiliatesWithFilters($params);
        if (empty($manyAffiliates)) {
            return;
        }
        $this->removeOldFiles();
        $hash = bin2hex(random_bytes(5));
        $plugin_name = "af";
        $export_type = "affiliates";
        $filename = $plugin_name . '-' . $export_type . '-' . $hash . '-' . date("m-d-Y") . '.csv';
        $targetFile = AF_PATH . 'temporary/' . $filename;
        $fileResource = fopen($targetFile, 'w');
        $data = [
            esc_html__('Affiliate ID', 'openaffiliates'),
            esc_html__('Email', 'openaffiliates'),
            esc_html__('Username', 'openaffiliates'),
            esc_html__('Name', 'openaffiliates'),
            esc_html__('Rank', 'openaffiliates'),
            esc_html__('Clicks', 'openaffiliates'),
            esc_html__('Referrals', 'openaffiliates'),
            esc_html__('Paid Earnings', 'openaffiliates'),
            esc_html__('Unpaid Earnings', 'openaffiliates'),
            esc_html__('WP Role', 'openaffiliates'),
            esc_html__('Affiliate Since', 'openaffiliates'),
        ];
        /// top of CSV file
        fputcsv($fileResource, $data, ',');
        unset($data);
        $currency = get_option('af_currency');
        $ranksList = af_get_wp_roles_list();
        foreach ($manyAffiliates as $affiliateObject) {
            // full name
            $name = $af_db->get_full_name_of_user($affiliateObject->id);
            // rank
            if (!isset($rankLabel[$affiliateObject->rank_id])) {
                $rank_data = $af_db->get_rank($affiliateObject->rank_id);
                $rankLabel[$affiliateObject->rank_id] = isset($rank_data['label']) ? $rank_data['label'] : '';
                $rankColor[] = isset($rank_data['rank_color']) ? $rank_data['rank_color'] : '';
                $rankStyle[$affiliateObject->rank_id] = isset($rank_data['rank_color']) ? 'af-box-background-' . $rank_data['rank_color'] : 'af-box-background-c9c9c9;';
            }
            $rank_label = $rankLabel[$affiliateObject->rank_id];
            // stats
            $stats = $af_db->get_stats_for_payments($affiliateObject->id);
            // wp role
            $role = $af_db->get_user_first_role($affiliateObject->uid);
            $data = [
                $affiliateObject->id,
                $affiliateObject->user_email,
                $affiliateObject->user_login,
                $name,
                $rank_label,
                $stats['visits'],
                $stats['referrals'],
                af_format_price_and_currency($currency, $stats['paid_payments_value']),
                af_format_price_and_currency($currency, $stats['unpaid_payments_value']),
                $role,
                af_convert_date_to_us_format($affiliateObject->user_registered),
            ];
            fputcsv($fileResource, $data, ",");
            unset($data);
        }
        fclose($fileResource);
        $this->linkToDownload = AF_URL . 'temporary/' . $filename;
    }
    private function visits()
    {
        global $af_db;
        $params = maybe_unserialize($this->filters);
        if (isset($params['limit'])) {
            $params['limit'] = false;
        }
        if (isset($params['offset'])) {
            $params['offset'] = false;
        }
        $params['order_by'] = 'v.id';
        $params['asc_or_desc'] = 'DESC';
        $visits = $af_db->getVisitsWithFilters($params);
        if (empty($visits)) {
            return;
        }
        $this->removeOldFiles();
        $hash = bin2hex(random_bytes(5));
        $plugin_name = "af";
        $export_type = "clicks";
        $filename = $plugin_name . '-' . $export_type . '-' . $hash . '-' . date("m-d-Y") . '.csv';
        $targetFile = AF_PATH . 'temporary/' . $filename;
        $fileResource = fopen($targetFile, 'w');
        $data = [
            esc_html__('ID', 'openaffiliates'),
            esc_html__('Affiliate ID', 'openaffiliates'),
            esc_html__('Affiliate Email', 'openaffiliates'),
            esc_html__('Referral ID', 'openaffiliates'),
            esc_html__('URL', 'openaffiliates'),
            esc_html__('From Page', 'openaffiliates'),
            esc_html__('IP Address', 'openaffiliates'),
            esc_html__('Browser', 'openaffiliates'),
            esc_html__('Device', 'openaffiliates'),
            esc_html__('Date', 'openaffiliates'),
            esc_html__('Status', 'openaffiliates'),
        ];
        /// top of CSV file
        fputcsv($fileResource, $data, ',');
        unset($data);
        foreach ($visits as $visit) {
            $data = [
                $visit->id,
                empty($visit->affiliate_id) ? esc_html__('-', 'openaffiliates') : $visit->affiliate_id,
                empty($visit->user_email) ? esc_html__('-', 'openaffiliates') : $visit->user_email,
                $visit->referral_id,
                $visit->url,
                empty($visit->ref_url) ? esc_html__('-', 'openaffiliates') : $visit->ref_url,
                $visit->ip,
                $visit->browser,
                $visit->device,
                af_convert_date_to_us_format($visit->visit_date),
                empty($visit->referral_id) ? esc_html__('Just Visit', 'openaffiliates') : esc_html__('Converted', 'openaffiliates'),
            ];
            fputcsv($fileResource, $data, ",");
            unset($data);
        }
        fclose($fileResource);
        $this->linkToDownload = AF_URL . 'temporary/' . $filename;
    }
    private function referrals()
    {
        global $af_db;
        $params = maybe_unserialize($this->filters);
        if (isset($params['limit'])) {
            $params['limit'] = false;
        }
        if (isset($params['offset'])) {
            $params['offset'] = false;
        }
        $params['order_by'] = 'r.id';
        $params['asc_or_desc'] = 'DESC';
        $referrals = $af_db->getReferralsWithFilters($params);
        if (empty($referrals)) {
            return;
        }
        $this->removeOldFiles();
        $hash = bin2hex(random_bytes(5));
        $plugin_name = "af";
        $export_type = "referrals";
        $filename = $plugin_name . '-' . $export_type . '-' . $hash . '-' . date("m-d-Y") . '.csv';
        $targetFile = AF_PATH . 'temporary/' . $filename;
        $fileResource = fopen($targetFile, 'w');
        $data = [
            esc_html__('ID', 'openaffiliates'),
            esc_html__('Affiliate ID', 'openaffiliates'),
            esc_html__('Affiliate Email', 'openaffiliates'),
            esc_html__('From', 'openaffiliates'),
            esc_html__('Reference', 'openaffiliates'),
            esc_html__('Description', 'openaffiliates'),
            esc_html__('Amount', 'openaffiliates'),
            esc_html__('Date', 'openaffiliates'),
            esc_html__('Status', 'openaffiliates'),
            esc_html__('Payout Status', 'openaffiliates'),
            //
            esc_html__('Campaign', 'openaffiliates'),
            esc_html__('Visit Id', 'openaffiliates'),
            esc_html__('Reference Details', 'openaffiliates'),
            esc_html__('Parent Referral Id', 'openaffiliates'),
            esc_html__('Child Referral Id', 'openaffiliates'),
        ];
        /// top of CSV file
        fputcsv($fileResource, $data, ',');
        unset($data);
        $currency = get_option('af_currency');
        foreach ($referrals as $referral) {
            $status = esc_html__('Rejected', 'openaffiliates');
            if ($referral->status == 1) {
                $status = esc_html__('Pending', 'openaffiliates');
            } else if ($referral->status == 2) {
                $status = esc_html__('Approved', 'openaffiliates');
            }
            $payment_status = esc_html__('Unpaid', 'openaffiliates');
            if ($referral->payment == 1) {
                $payment_status = esc_html__('Pending', 'openaffiliates');
            } else if ($referral->payment == 2) {
                $payment_status = esc_html__('Paid', 'openaffiliates');
            }
            $data = [
                $referral->id,
                $referral->affiliate_id,
                empty($referral->user_email) ? esc_html__('-', 'openaffiliates') : $referral->user_email,
                af_service_type_code_to_title($referral->source),
                $referral->reference,
                $referral->description,
                af_format_price_and_currency($referral->currency, $referral->amount),
                af_convert_date_to_us_format($referral->date),
                $status,
                $payment_status,
                //
                $referral->campaign,
                $referral->visit_id,
                $referral->reference_details,
                $referral->parent_referral_id,
                $referral->child_referral_id
            ];
            fputcsv($fileResource, $data, ",");
            unset($data);
        }
        fclose($fileResource);
        $this->linkToDownload = AF_URL . 'temporary/' . $filename;
    }
    private function payouts()
    {
        global $af_db;
        $params = maybe_unserialize($this->filters);
        if (isset($params['limit'])) {
            $params['limit'] = false;
        }
        if (isset($params['offset'])) {
            $params['offset'] = false;
        }
        $params['order_by'] = 'p.id';
        $params['asc_or_desc'] = 'DESC';
        $payouts = $af_db->getPayoutsWithFilters($params);
        if (empty($payouts)) {
            return;
        }
        $this->removeOldFiles();
        $hash = bin2hex(random_bytes(5));
        $plugin_name = "af";
        $export_type = "payouts";
        $filename = $plugin_name . '-' . $export_type . '-' . $hash . '-' . date("m-d-Y") . '.csv';
        $targetFile = AF_PATH . 'temporary/' . $filename;
        $fileResource = fopen($targetFile, 'w');
        $data = [
            esc_html__('ID', 'openaffiliates'),
            esc_html__('Affiliate ID', 'openaffiliates'),
            esc_html__('Affiliate Email', 'openaffiliates'),
            esc_html__('Amount', 'openaffiliates'),
            esc_html__('Payout Method', 'openaffiliates'),
            esc_html__('Transaction ID', 'openaffiliates'),
            esc_html__('Payment Details', 'openaffiliates'),
            esc_html__('Date', 'openaffiliates'),
            esc_html__('Status', 'openaffiliates'),
        ];
        /// top of CSV file
        fputcsv($fileResource, $data, ',');
        unset($data);
        $currency = get_option('af_currency');
        foreach ($payouts as $payout) {
            $status = esc_html__('Failed', 'openaffiliates');
            if ($payout->status == 1) {
                $status = esc_html__('Pending', 'openaffiliates');
            } else if ($payout->status == 2) {
                $status = esc_html__('Completed', 'openaffiliates');
            }
            $paymentDetails = $payout->payment_details;
            $paymentDetailsArray = maybe_unserialize($payout->payment_details);
            if (
                $paymentDetailsArray && isset($paymentDetailsArray['af_affiliate_bank_transfer_data']) && isset($paymentDetailsArray['af_affiliate_bank_transfer_data']['label'])
                && isset($paymentDetailsArray['af_affiliate_bank_transfer_data']['value'])
            ) {
                $paymentDetails = $paymentDetailsArray['af_affiliate_bank_transfer_data']['label'] . ' : ' . $paymentDetailsArray['af_affiliate_bank_transfer_data']['value'];
            } else if (
                $paymentDetailsArray && isset($paymentDetailsArray['af_affiliate_paypal_email']) && isset($paymentDetailsArray['af_affiliate_paypal_email']['label'])
                && isset($paymentDetailsArray['af_affiliate_paypal_email']['value'])
            ) {
                $paymentDetails = $paymentDetailsArray['af_affiliate_paypal_email']['label'] . ' : ' . $paymentDetailsArray['af_affiliate_paypal_email']['value'];
            }
            $data = [
                $payout->id,
                $payout->affiliate_id,
                empty($payout->user_email) ? esc_html__('-', 'openaffiliates') : $payout->user_email,
                af_format_price_and_currency($payout->currency, $payout->amount),
                $payout->payment_type,
                $payout->transaction_id,
                $paymentDetails,
                af_convert_date_to_us_format($payout->create_date),
                $status
            ];
            fputcsv($fileResource, $data, ",");
            unset($data);
        }
        fclose($fileResource);
        $this->linkToDownload = AF_URL . 'temporary/' . $filename;
    }
    public function getDownloadLink()
    {
        return $this->linkToDownload;
    }
    private function removeOldFiles()
    {
        $directory = AF_PATH . 'temporary/';
        $files = scandir($directory);
        foreach ($files as $file) {
            $fileFullPath = $directory . $file;
            if (file_exists($fileFullPath) && filetype($fileFullPath) == 'file') {
                $extension = pathinfo($fileFullPath, PATHINFO_EXTENSION);
                if ($extension == 'csv') {
                    unlink($fileFullPath);
                }
            }
        }
    }
}
