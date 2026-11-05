<?php
namespace OpenAffiliates;

class LoadTemplates
{
    public function __construct()
    {
      add_filter('af_filter_on_load_template', array($this, 'loadTemplate'), 1, 2 );
    }

    public function loadTemplate($currentLocation='', $searchFile='')
    {
        /// search into open-affiliates-for-woocommerce theme folder
        $pluginDirName = str_replace( WP_PLUGIN_DIR . '/', '', AF_PATH );
        if ($location=$this->searchTemplateIntoCurrentTheme( $pluginDirName . $searchFile)){
            return $location;
        }
        /// search into theme root
        if ($location=$this->searchTemplateIntoCurrentTheme($searchFile)){
            return $location;
        }
        /// default (plugin template file)
        return $currentLocation;
    }


    private function searchTemplateIntoCurrentTheme($search=''){
        if ($location=locate_template($search)){
            return $location;
        }
        return '';
    }


}
