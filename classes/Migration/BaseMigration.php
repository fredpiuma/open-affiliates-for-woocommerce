<?php
namespace OpenAffiliates\Migration;

class BaseMigration
{
    public function __construct(){}

    public function run($params=array())
    {
        if (empty($params['serviceType'])){
            return false;
        }

        switch ($params['serviceType']){
            case 'affiliate-wp':
              $object = new \OpenAffiliates\Migration\AffiliateWp($params);
              break;
            case 'wp-affiliate':
              $object = new \OpenAffiliates\Migration\WpAffiliates($params);
              break;
            case 'affiliates-pro':
              $object = new \OpenAffiliates\Migration\AffiliatesPro($params);
              break;
        }
        if (empty($object)){
            return false;
        }

        $object->initJobs()
               ->run()
               ->updateOffset()
               ->updateEntity()
               ->updateLog()
               ->redirect();
    }

}
