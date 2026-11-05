<?php
namespace OpenAffiliates;

class WooSpecificReferralRates
{
    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        // Admin
        add_filter('woocommerce_product_data_tabs', [ $this, 'addTab' ] );
        add_action('woocommerce_product_data_panels', [ $this, 'tab' ] );
        add_action('woocommerce_process_product_meta_simple', [ $this, 'adminWpSaveCustomSettings' ], 999, 1 );
        add_action('woocommerce_process_product_meta_grouped', [ $this, 'adminWpSaveCustomSettings' ], 999, 1 );
        add_action('woocommerce_process_product_meta_external', [ $this, 'adminWpSaveCustomSettings' ], 999, 1 );
        add_action('woocommerce_process_product_meta_variable', [ $this, 'adminWpSaveCustomSettings' ], 999, 1 );
        // variantions product
        add_action( 'woocommerce_product_after_variable_attributes', [ $this, 'variableProductSettings'], 99, 3 );
        add_action( 'woocommerce_ajax_save_product_variations', [ $this, 'saveVariationProductSettings' ] );

        // Public
        add_filter( 'af_filter_referral_amount', [ $this, 'filterAmount'], 1, 4 );
    }

    /**
     * @param int
     * @param int
     * @param int
     * @param array
     * @return int
     */
    public function filterAmount( $customAmounts=[], $inputAmount=0, $productId=0, $attr=[] )
    {
        if ( !empty( $attr['variableProductId'] ) ){
            // variable product
            $type = get_post_meta( $attr['variableProductId'], 'af-woo-wsr-type', true );
            $value = get_post_meta( $attr['variableProductId'], 'af-woo-wsr-value', true );
        }
        if ( !isset($type) || $type == false ){
            // base product
            $type = get_post_meta( $productId, 'af-woo-wsr-type', true );
            $value = get_post_meta( $productId, 'af-woo-wsr-value', true );
        }

        if ( $type == false ){
            return $customAmounts;
        }
        if ( $type == 'default' ){
            return $customAmounts;
        }
        if ( $value === false  || $value == '' ){
            return $customAmounts;
        }
        if ( $type == 'flat' ){
            $customAmounts[] = $value;
        } else if ( $type == 'percentage' ){
            $customAmounts[] = $inputAmount * $value / 100;
        }
        return $customAmounts;
    }


    /**
     * @param array
     * @return array
     */
    public function addTab( $tabs=[] )
    {
        $tabs['af_woo_wsr'] = array(
                      'label'  => esc_html__( 'Open Affiliates - Custom Referral Rate', 'openaffiliates' ),
                      'target' => 'af_woo_wsr',
                      'class'  => [], // 'hide_if_grouped'
        );
        return $tabs;
    }

    /**
     * @param none
     * @return none
     */
    public function tab()
    {
        global $post;
        $currency = get_option('af_currency');
        $types = [
                          'flat' 					=> esc_html__( 'Flat ', 'openaffiliates') . '(' . $currency .')',
                          'percentage'		=> esc_html__( 'Percentage ', 'openaffiliates') . '(%)',
                          'default'       => esc_html__( 'Default Affiliate system Settings', 'openaffiliates' ),
        ];
        $data = [
                  'af-woo-wsr-type'		    => get_post_meta( $post->ID, 'af-woo-wsr-type', true ),
                  'af-woo-wsr-value'		    => get_post_meta( $post->ID, 'af-woo-wsr-value', true ),
                  'af-woo-excluded-prod'   => get_post_meta( $post->ID, 'af-woo-excluded-prod', true ),
                  'types'                    => $types
        ];
        if ( $data['af-woo-wsr-type'] == '' ){
            $data['af-woo-wsr-type'] = 'default';
        }
        if ( $data['af-woo-excluded-prod'] === '' || $data['af-woo-excluded-prod'] === false || $data['af-woo-excluded-prod'] === null ){
            $data['af-woo-excluded-prod'] = 0;
        }
        $view = new \OpenAffiliates\AfView();
        $output = $view->setTemplate( AF_PATH . 'admin/views/af-woo-specific-referral-rate.php' )
                  ->setContentData( $data )
                  ->getOutput();
        echo esc_af_content( $output );
    }



    public function variableProductSettings( $loop=null, $variationData=null, $variation=null )
    {
        $currency = get_option('af_currency');
        $types = [
                          'flat' 					=> $currency,
                          'percentage'		=> '%',
                          'default'       => esc_html__( 'Default', 'openaffiliates' ),
        ];
        $data = [
                  'af-woo-wsr-type'		    => get_post_meta( $variation->ID, 'af-woo-wsr-type', true ),
                  'af-woo-wsr-value'		    => get_post_meta( $variation->ID, 'af-woo-wsr-value', true ),
                  'af-woo-excluded-variable_prod'   => get_post_meta( $variation->ID, 'af-woo-excluded-variable_prod', true ),
                  'types'                   => $types,
                  'variantion_id'           => $variation->ID,
        ];
        if ( $data['af-woo-excluded-variable_prod'] === '' || $data['af-woo-excluded-variable_prod'] === false || $data['af-woo-excluded-variable_prod'] === null ){
            $data['af-woo-excluded-variable_prod'] = 0;
        }
        $view = new \OpenAffiliates\AfView();
        $output = $view->setTemplate( AF_PATH . 'admin/views/af-woo-specific-referral-rate-variable-products.php' )
                  ->setContentData( $data )
                  ->getOutput();
        echo esc_af_content( $output );
    }


    /**
     * @param int
     * @return none
     */
    public function adminWpSaveCustomSettings( $postId=0 )
    {
        if ( !$postId || !isset($_POST['af-woo-wsr-type']) ){
            return false;
        }
        update_post_meta( $postId, 'af-woo-wsr-type', af_sanitize_array($_POST['af-woo-wsr-type']) );
        update_post_meta( $postId, 'af-woo-wsr-value', af_sanitize_array($_POST['af-woo-wsr-value']) );
        if ( isset( $_POST['af-woo-excluded-prod'] ) ){
            update_post_meta( $postId, 'af-woo-excluded-prod', sanitize_text_field( $_POST['af-woo-excluded-prod'] ) );
        }
        $this->saveVariationProductSettings(); //if it's case let's save the values for variable product
    }

    public function saveVariationProductSettings()
    {
        if ( empty( $_POST['variable_post_id'] ) ) {
            return;
        }
        if ( !is_array( $_POST['variable_post_id'] ) ){
            return;
        }
        foreach ( $_POST['variable_post_id'] as $variableProductId ) {
            if ( isset( $_POST['af-woo-wsr-variable-product-type'][$variableProductId] ) ){
                update_post_meta( $variableProductId, 'af-woo-wsr-type', af_sanitize_array($_POST['af-woo-wsr-variable-product-type'][$variableProductId]) );
            }
            if ( isset( $_POST['af-woo-wsr-variable-product-value'][$variableProductId] ) ){
                update_post_meta( $variableProductId, 'af-woo-wsr-value', af_sanitize_array($_POST['af-woo-wsr-variable-product-value'][$variableProductId]) );
            }
            if ( isset( $_POST['af-woo-excluded-variable_prod'] ) ){
                update_post_meta( $variableProductId, 'af-woo-excluded-variable_prod', sanitize_text_field( $_POST['af-woo-excluded-variable_prod'] ) );
            }
        }
    }
}
