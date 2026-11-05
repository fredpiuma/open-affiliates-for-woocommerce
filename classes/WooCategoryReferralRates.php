<?php
namespace OpenAffiliates;

class WooCategoryReferralRates
{
    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        // Admin
        add_action( 'product_cat_add_form_fields', [ $this, 'catReferralRateFormAdd' ], 999, 2 );
        add_action( 'product_cat_edit_form_fields', [ $this, 'catReferralRateFormEdit' ], 999 );
        add_action( 'edited_product_cat', [ $this, 'saveReferralRate' ], 999, 1 );
        add_action( 'create_product_cat', [ $this, 'saveReferralRate' ], 999, 1 );

        // Public
        add_filter( 'af_filter_referral_amount', [ $this, 'filterAmount'], 2, 4 );
    }

    public function catReferralRateFormAdd( $cat=0 )
    {
        $currency = get_option('af_currency');
        $catId = isset( $cat->term_id ) ? $cat->term_id : 0;
        $types = [
                          'flat' 					=> esc_html__( 'Flat ', 'openaffiliates') . '(' . $currency .')',
                          'percentage'		=> esc_html__( 'Percentage ', 'openaffiliates') . '(%)',
                          'default'       => esc_html__( 'Default Affiliate system Settings', 'openaffiliates' ),
        ];
        $data = [
                  'af_referral_type'		    => get_term_meta( $catId, 'af_referral_type', true ),
                  'af_referral_value'		  => get_term_meta( $catId, 'af_referral_value', true ),
                  'types'                   => $types,
                  'cat_id'                  => $catId,
                  'af_excluded'            => get_term_meta( $catId, 'af_excluded', true ),
        ];
        if ( $data['af_excluded'] === '' || $data['af_excluded'] === false || $data['af_excluded'] === null ){
            $data['af_excluded'] = 0;
        }
        
        $view = new \OpenAffiliates\AfView();
        $output = $view->setTemplate( AF_PATH . 'admin/views/woo-cats-referral-rate-add.php' )
                  ->setContentData( $data )
                  ->getOutput();
        echo esc_af_content( $output );
    }


    public function catReferralRateFormEdit( $cat=0 )
    {
        $currency = get_option('af_currency');
        $catId = isset( $cat->term_id ) ? $cat->term_id : 0;
        $types = [
                          'flat' 					=> esc_html__( 'Flat ', 'openaffiliates') . '(' . $currency .')',
                          'percentage'		=> esc_html__( 'Percentage ', 'openaffiliates') . '(%)',
                          'default'       => esc_html__( 'Default Affiliate system Settings', 'openaffiliates' ),
        ];
        $data = [
                  'af_referral_type'		    => get_term_meta( $catId, 'af_referral_type', true ),
                  'af_referral_value'		  => get_term_meta( $catId, 'af_referral_value', true ),
                  'types'                   => $types,
                  'cat_id'                  => $catId,
                  'af_excluded'            => get_term_meta( $catId, 'af_excluded', true ),
        ];
        if ( $data['af_excluded'] === '' || $data['af_excluded'] === false || $data['af_excluded'] === null ){
            $data['af_excluded'] = 0;
        }

        $view = new \OpenAffiliates\AfView();
        $output = $view->setTemplate( AF_PATH . 'admin/views/woo-cats-referral-rate-edit.php' )
                  ->setContentData( $data )
                  ->getOutput();
        echo esc_af_content( $output );
    }


    public function saveReferralRate( $catId=0 )
    {
        if ( empty( $catId ) || !isset( $_POST['af_referral_type'] ) || !isset( $_POST['af_referral_value'] ) ){
            return false;
        }
        update_term_meta( $catId, 'af_referral_type', af_sanitize_array( $_POST['af_referral_type'] ) );
        update_term_meta( $catId, 'af_referral_value', af_sanitize_array( $_POST['af_referral_value'] ) );
        if ( isset( $_POST['af_excluded'] ) ){
            update_term_meta( $catId, 'af_excluded', sanitize_text_field( $_POST['af_excluded'] ) );
        }
    }

    public function filterAmount( $customAmounts=[], $inputAmount=0, $productId=0, $attr=[] )
    {
        $cats = wp_get_post_terms ($productId, 'product_cat', [ 'fields'=>'ids' ] );
        if ( empty( $cats ) ){
            return $customAmounts;
        }
        $array= [];
        foreach ( $cats as $catId ){
          $type = get_term_meta( $catId, 'af_referral_type', true );
          $value = get_term_meta( $catId, 'af_referral_value', true );

          if ( $type == false ){
              continue;
          }
          if ( $type == 'default' ){
              continue;
          }
          if ( $value === false  || $value == '' ){
              continue;
          }
          if ( $type == 'flat' ){
              $customAmounts[] = $value;
          } else if ( $type == 'percentage' ){
              $customAmounts[] = $inputAmount * $value / 100;
          }
        }
        return $customAmounts;
    }

}
