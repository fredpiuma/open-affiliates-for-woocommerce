<?php
namespace OpenAffiliates\Admin;
/**
 * since version 8.5
 */
class Datatable
{
    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        // datatable data for tables
        // ranks
        add_action( 'wp_ajax_af_ajax_get_ranks', [ $this, 'af_ajax_get_ranks' ] ); // retrieve ranks
        add_action( 'wp_ajax_af_admin_remove_one_rank', [ $this, 'af_admin_remove_one_rank' ] );// remove one ranks
        add_action( 'wp_ajax_af_admin_remove_many_rank', [ $this, 'af_admin_remove_many_rank' ] );// remove many ranks

        // offers
        add_action( 'wp_ajax_af_ajax_get_offers', [ $this, 'af_ajax_get_offers' ] ); // retrieve offers
        add_action( 'wp_ajax_af_ajax_remove_one_offer', [ $this, 'af_ajax_remove_one_offer' ] ); // remove one offer
        add_action( 'wp_ajax_af_ajax_remove_many_offers', [ $this, 'af_ajax_remove_many_offers' ] ); // remove many offers

        // landing commission
        add_action( 'wp_ajax_af_ajax_get_landing_commissions', [ $this, 'af_ajax_get_landing_commissions' ] ); // retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_landing_commission', [ $this, 'af_ajax_remove_one_landing_commission' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_landing_commissions', [ $this, 'af_ajax_remove_many_landing_commissions' ] ); // remove many items

        // banners
        add_action( 'wp_ajax_af_ajax_get_banners', [ $this, 'af_ajax_get_banners' ] ); // retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_banners', [ $this, 'af_ajax_remove_one_banners' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_banners', [ $this, 'af_ajax_remove_many_banners' ] ); // remove many items

        // notifications
        add_action( 'wp_ajax_af_ajax_get_notifications', [ $this, 'af_ajax_get_notifications' ] ); // retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_notifications', [ $this, 'af_ajax_remove_one_notifications' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_notifications', [ $this, 'af_ajax_remove_many_notifications' ] ); // remove many items
        add_action( 'wp_ajax_af_ajax_notification_modify_status', [ $this, 'af_ajax_notification_modify_status' ] ); // modify status

        // affiliates
        add_action( 'wp_ajax_af_ajax_get_affiliates', [ $this, 'af_ajax_get_affiliates' ] ); // retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_affiliate', [ $this, 'af_ajax_remove_one_affiliate' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_affiliates', [ $this, 'af_ajax_remove_many_affiliates' ] ); // remove many items
        add_action( 'wp_ajax_af_ajax_update_ranks_for_affiliates', [ $this, 'af_ajax_update_ranks_for_affiliates' ] ); // update item

        // visits
        add_action( 'wp_ajax_af_ajax_get_visits', [ $this, 'af_ajax_get_visits' ] );// retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_visit', [ $this, 'af_ajax_remove_one_visit' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_visits', [ $this, 'af_ajax_remove_many_visits' ] ); // remove many items

        // referrals
        add_action( 'wp_ajax_af_ajax_get_referrals', [ $this, 'af_ajax_get_referrals' ] );// retrieve items
        add_action( 'wp_ajax_af_ajax_remove_one_referral', [ $this, 'af_ajax_remove_one_referral' ] ); // remove one item
        add_action( 'wp_ajax_af_ajax_remove_many_referrals', [ $this, 'af_ajax_remove_many_referrals' ] ); // remove many items
        add_action( 'wp_ajax_af_ajax_change_status_referral', [ $this, 'af_ajax_change_status_referral' ] );// change status of one referral

        // payouts
        add_action( 'wp_ajax_af_ajax_get_payouts', [ $this, 'af_ajax_get_payouts' ] );// retrieve payouts
        add_action( 'wp_ajax_af_ajax_remove_one_payout', [ $this, 'af_ajax_remove_one_payout' ] ); // remove one payout
        add_action( 'wp_ajax_af_ajax_remove_many_payouts', [ $this, 'af_ajax_remove_many_payouts' ] ); // remove many payout
        add_action( 'wp_ajax_af_ajax_payouts_generate_csv', [ $this, 'af_ajax_payouts_generate_csv' ] ); // generate csv for payouts
        add_action( 'wp_ajax_af_ajax_payout_all_payments_change_status', [ $this, 'af_ajax_payout_all_payments_change_status' ] );// change all payments status for payout

        // payments
        add_action( 'wp_ajax_af_ajax_get_payments', [ $this, 'af_ajax_get_payments' ] );// retrieve payments
        add_action( 'wp_ajax_af_ajax_remove_one_payment', [ $this, 'af_ajax_remove_one_payment' ] ); // remove one payment
        add_action( 'wp_ajax_af_ajax_remove_many_payments', [ $this, 'af_ajax_remove_many_payments' ] ); // remove many payments
        add_action( 'wp_ajax_af_ajax_payments_change_status', [ $this, 'af_ajax_payments_change_status' ] );// change status for one payment


        add_action( 'wp_ajax_af_ajax_datatable_save_state', [ $this, 'saveState'] );
    }

    /**
     * @param none
     * @return array
     */
    public static function Labels()
    {
        return [
            'search'				=> esc_html__( "Search&nbsp;:", 'openaffiliates'),
            'lengthMenu'		=> esc_html__( "Show _MENU_ entries", 'openaffiliates'),
            'info'					=> esc_html__( "Showing _START_ to _END_ of _TOTAL_ entries", 'openaffiliates'),
            'infoEmpty'			=> esc_html__( "No Entries Available", 'openaffiliates'),
            'infoFiltered'	=> '',
            'loadingRecords'=> esc_html__( "Loading", 'openaffiliates'),
            'zeroRecords'		=> esc_html__( "No Results Found", 'openaffiliates'),
            'emptyTable'		=> esc_html__( "No Results Found", 'openaffiliates'),
            'paginate'			=> [
                  'first'					=> esc_html__( "First", 'openaffiliates'),
                  'previous'			=> esc_html__( "Previous", 'openaffiliates'),
                  'next'					=> esc_html__( "Next", 'openaffiliates'),
                  'last'					=> esc_html__( "Last", 'openaffiliates'),
            ],
            'aria'					=> [
                  'sortAscending'		=> esc_html__( "Ascending", 'openaffiliates'),
                  'sortDescending'	=> esc_html__( "Descending", 'openaffiliates'),
            ],
            'searchPlaceholder'			=> esc_html__( "Search", 'openaffiliates'),
            'show_hide_cols_label'	=> esc_html__( "Show / Hide columns", 'openaffiliates'),
            'checkbox_label'        => esc_html__( 'Checkbox', 'openaffiliates' ),
        ];
    }

    /**
     * @param string
     * @param string
     * @return none
     */
    public static function Scripts( $columns='', $tableDataType='' )
    {
        global $wp_version;
        $labels= self::Labels();
        wp_enqueue_style( 'afdatatable', AF_URL . 'assets/css/datatable.css');
        wp_enqueue_style( 'afdatabse', AF_URL . 'assets/css/datatables/datatables.min.css');
        wp_enqueue_style( 'afdatabse-buttons', AF_URL . 'assets/css/datatables/buttons.dataTables.min.css');

        // maybe tipso
        if ( isset( $_GET['tab'] ) && sanitize_text_field( $_GET['tab'] ) === 'affiliates' ){
          wp_enqueue_style( 'af-tipso-css', AF_URL . 'assets/css/tipso.min.css' );
          wp_enqueue_script( 'af-tipso-js', AF_URL . 'assets/js/tipso.min.js', ['jquery'], '9.4');
        }

        wp_enqueue_script( 'afdatabse', AF_URL . 'assets/js/datatables/datatables.min.js', ['jquery'], '9.4' );
        wp_enqueue_script( 'afdatabse-buttons', AF_URL . 'assets/js/datatables/dataTables.buttons.min.js', ['jquery'], '9.4' );
        wp_enqueue_script( 'afdatabse-colvis', AF_URL . 'assets/js/datatables/buttons.colVis.min.js', ['jquery'], '9.4' );
        wp_enqueue_script( 'afdatabsescrolltop', AF_URL . 'assets/js/datatables/dataTables.scrollToTop.min.js', ['jquery'], '9.4' );
        wp_enqueue_style( 'afmultiselect', AF_URL . 'assets/css/jquery.multiselect.css', '9.4' );
        wp_enqueue_script( 'afmultiselectfunctions', AF_URL . 'assets/js/jquery.multiselect.js', ['jquery'], '9.4' );
        // af datatable functions
        wp_register_script( 'af-table', AF_URL . 'assets/js/table.js', ['jquery'], '9.4' );
        // setting up the variables
        if ( version_compare ( $wp_version , '5.7', '>=' ) ){
            wp_add_inline_script( 'af-table', "var af_datatable_cols='" . json_encode( $columns ) . "';" );
            wp_add_inline_script( 'af-table', "var af_datatable_labels='" . json_encode( $labels ) . "';" );
            wp_add_inline_script( 'af-table', "var af_datatable_type='$tableDataType';" );
        } else {
            wp_localize_script( 'af-table', 'af_datatable_cols', json_encode( $columns ) );
            wp_localize_script( 'af-table', 'af_datatable_labels', json_encode( $labels ) );
            wp_add_inline_script( 'af-table', "var af_datatable_type='$tableDataType';" );
        }
        wp_enqueue_script( 'af-table' );
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_get_ranks()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;

        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        update_option( 'af_datatable_ranks_entries_length', $limit );

        // status
        $statusIn = isset( $_POST['status'] ) ? af_sanitize_array( $_POST['status'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
        ];


        $ranks = $af_db->getRanksWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $total = $af_db->getRanksWithFilters( $paramsForCounting );
        $currency = afCurrency();
        $amountTypes = [ 'flat' => $currency, 'percentage'=> '%' ];
        $achieveTypes = [-1=>'...', 'referrals_number'=>'Number of Referrals', 'total_amount'=>'Total Amount'];
        $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=ranks&subtab=add_edit' );

        foreach ( $ranks as $rankObject ){
            // rank amount
            $amountDisplay = '';
            if ($rankObject->amount_type){
                if (!empty($amountTypes[$rankObject->amount_type])){
                    if ('%'==$amountTypes[$rankObject->amount_type]){
                        $amountDisplay = esc_html($rankObject->amount_value . '' . $amountTypes[$rankObject->amount_type]);
                    } else {
                        $amountDisplay = af_format_price_and_currency( $amountTypes[$rankObject->amount_type], $rankObject->amount_value );
                    }
                } else {
                    $amountDisplay = esc_html($rankObject->amount_value);
                }
            }

            // achivement
            $achieve = json_decode($rankObject->achieve, TRUE);
            $achivement = '';
            if ($achieve){
                for ($i=1; $i<=$achieve['i']; $i++){
                    $achivement .= '<div class="af-admin-listing-ranks-achieve">';
                    $achivement .= '<div><strong>' . esc_html($achieveTypes[$achieve['type_' . $i]]) . '</strong></div>';
                    $achivement .= '<div>' . esc_html__('From: ', 'openaffiliates');
                    if ($achieve['type_' . $i]=='total_amount'){
                        $achivement .= af_format_price_and_currency( $amountTypes['flat'], $achieve['value_' . $i] );
                    } else {
                        $achivement .= esc_html( $achieve['value_' . $i] );
                    }
                    $achivement .= '</div>';
                    $achivement .= '</div>';
                }
            } else {
                $achivement = '<div class="af-admin-listing-ranks-achieve">' . esc_html__('None', 'openaffiliates') . '</div>';
            }
            // label
            $labelDisplay = esc_af_content("<b>" . esc_attr( $rankObject->label ) . "</b>")
                    . '<div id="rank_' . esc_attr($rankObject->id) . '" class="af-visibility-hidden">'
                    . '<a href="' . esc_url( $urlAddEdit . '&id=' . $rankObject->id ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>'
                    . ' | '
                    . '<span class="af-js-remove-one-rank af-delete-span" data-id="' . esc_attr($rankObject->id) . '" >' . esc_html__('Remove', 'openaffiliates') . '</span>';
            // checkbox
            $checkbox = '<input type="checkbox" name="ranks[]" value="' . $rankObject->id . '" class="af-js-table-select-item" />';

            $data[] = [
                          'id'            => $rankObject->id,
                          'checkbox'      => $checkbox,
                          'label'         => [
                                          'display' =>  $labelDisplay,
                                          'value' 	=>  $rankObject->label,
                          ],
                          'amount_value'  => [
                                          'display' =>  $amountDisplay,
                                          'value' 	=>  $rankObject->amount_value,
                          ],
                          'achieve'       => [
                                          'display' => $achivement,
                                          'value' 	=> $rankObject->achieve,
                          ],
                          'number_of_affiliates'       => [
                                          'display' => '<a href="'.admin_url('admin.php?page=openaffiliates&tab=affiliates&rank_id='.$rankObject->id) . '">'.$rankObject->number_of_affiliates.'</a>',
                                          'value' 	=> $rankObject->number_of_affiliates,
                          ],
                          'status'        => [
                                          'display' => empty( $rankObject->status ) ? '<span class="af-status af-status-inactive">'.esc_html__( 'Inactive', 'openaffiliates' ).'</span>' : '<span class="af-status af-status-active">'.esc_html__( 'Active', 'openaffiliates' ).'</span>',
                                          'value' 	=> $rankObject->status,
                          ],
            ];

        }
        if ( !isset( $data ) ){
            $data = [];
        }
        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $data, 'recordsTotal' => $total, 'recordsFiltered' => $total ] );
        die;
    }

    /**
     * Remove one rank
     * @param none
     * @return none
     */
    public function af_admin_remove_one_rank()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        if ($af_db->ranks_get_count()>1){
            $af_db->delete_rank( sanitize_text_field( $_POST['id'] ) );
            echo esc_html('success');
            die;
        } else {
           esc_html_e('You cannot have less than one rank.', 'openaffiliates');
          die;
        }
    }

    /**
     * Remove multiple ranks
     * @param none
     * @return none
     */
    public function af_admin_remove_many_rank()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        foreach ( $items as $item ){
            $af_db->delete_rank( sanitize_text_field( $item ) );
            echo esc_html('success');
        }
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_get_offers()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;

        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        update_option( 'af_datatable_offers_entries_length', $limit );

        // status
        $statusIn = isset( $_POST['status'] ) ? af_sanitize_array( $_POST['status'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
        ];

        $data = $af_db->getOffersWithFilter( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $total = $af_db->getOffersWithFilter( $paramsForCounting );
        $response = [];

        $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=offers&subtab=add_edit' );
        $currency = afCurrency();
        $amountTypes = [ 'flat' => $currency, 'percentage'=> '%' ];

        $services = af_get_active_services();

        foreach ( $data as $dataArray ){
            $amountDisplay = '';
            if ($dataArray['amount_type']){
                if (!empty($amountTypes[$dataArray['amount_type']])){
                    if ('%'==$amountTypes[$dataArray['amount_type']]){
                        $amountDisplay = esc_html($dataArray['amount_value'] . '' . $amountTypes[$dataArray['amount_type']]);
                    } else {
                        $amountDisplay = af_format_price_and_currency( $amountTypes[$dataArray['amount_type']], $dataArray['amount_value'] );
                    }
                } else {
                    $amountDisplay = esc_html($dataArray['amount_value']);
                }
            }
            $checkbox = '<input type="checkbox" name="offers[]" value="' . $dataArray['id'] . '" class="af-js-table-select-item" />';
            // label
            $labelDisplay = esc_af_content("<b>" . esc_attr( $dataArray['name'] ) . "</b>")
                    . '<div id="offer_' . esc_attr( $dataArray['id'] ) . '" class="af-visibility-hidden">'
                    . '<a href="' . esc_url( $urlAddEdit . '&id=' . $dataArray['id'] ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>'
                    . ' | '
                    . '<span class="af-js-remove-one-item af-delete-span" data-id="' . esc_attr( $dataArray['id'] ) . '" >' . esc_html__('Remove', 'openaffiliates') . '</span>';

            $products = '';
            if ( isset( $dataArray['products']['label'] ) && is_array( $dataArray['products']['label'] ) && count( $dataArray['products']['label'] ) > 0 ){

                foreach ( $dataArray['products']['label'] as $product ){
                    $products .= $product ;
                }
            }
            $allProductsLabel = esc_html__( 'All products', 'openaffiliates');
            $source = (isset( $dataArray['source'] ) && is_string( $dataArray['source'] ) && isset( $services[$dataArray['source'] ] )) ? $services[$dataArray['source'] ] : '';
            if ( $products === '' && $source !== '' ){
                $allProductsLabel = esc_html__( 'All products from ', 'openaffiliates') . $source;
            }
            $response[] = [
                      'id'            => $dataArray['id'],
                      'checkbox'      => $checkbox,
                      'name'         => [
                                      'display' =>  $labelDisplay,
                                      'value' 	=>  $dataArray['name'],
                      ],
                      'amount_value'  => [
                                      'display' =>  $amountDisplay,
                                      'value' 	=>  $dataArray['amount_value'],
                      ],
                      'target'        => $dataArray['affiliates'],
                      'products'      => $products === '' ? $allProductsLabel : $products,
                      'start_date'      => [
                                      'display' =>  $dataArray['start_date'] === '0000-00-00 00:00:00' ? '-' : af_convert_date_to_us_format($dataArray['start_date']),
                                      'value' 	=>  $dataArray['start_date'],
                      ],
                      'end_date'        => [
                                      'display' =>  $dataArray['end_date'] === '0000-00-00 00:00:00' ? '-' : af_convert_date_to_us_format($dataArray['end_date']),
                                      'value' 	=>  $dataArray['end_date'],
                      ],
                      'status'        => [
                                      'display' => empty( $dataArray['status'] ) ? '<span class="af-status af-status-inactive">'.esc_html__( 'Inactive', 'openaffiliates' ).'</span>' : '<span class="af-status af-status-active">'.esc_html__( 'Active', 'openaffiliates' ).'</span>',
                                      'value' 	=> $dataArray['status'],
                      ],
            ];
        }

        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total ] );
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_one_offer()
    {
          if ( !afIsAdmin() ){
              die;
          }
          if ( !afAdminVerifyNonce() ){
              die;
          }
          global $af_db;
          if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
              echo esc_html('error');
              die;
          }
          $ids = [ sanitize_text_field( $_POST['id'] ) ];
          $af_db->delete_offers($ids);
          die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_many_offers()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        $af_db->delete_offers( $items );
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_get_landing_commissions()
    {
      if ( !afIsAdmin() ){
          die;
      }
      if ( !afAdminVerifyNonce() ){
          die;
      }
      // input : start, length, search[value], order[i][column], columns[i][orderable]
      global $af_db, $wpdb;

      // order by
      $ascOrDesc = '';
      $orderBy = '';
      if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
          $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
          $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
          $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
      }

      // search value
      $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
      if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
          $searchValue = sanitize_text_field( $_POST['search_phrase'] );
      }

      // offset and limit
      $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
      $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

      update_option( 'af_datatable_landing_commissions_entries_length', $limit );

      // status
      $statusIn = isset( $_POST['status'] ) ? af_sanitize_array( $_POST['status'] ) : false;
      if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
          $statusIn = false;
      }

      $params = [
                  'search_phrase'       => $searchValue,
                  'offset'              => $offset,
                  'limit'               => $limit,
                  'order_by'            => $orderBy,
                  'asc_or_desc'         => $ascOrDesc,
                  'status_in'           => $statusIn,
      ];

      $data = $af_db->getLandingCommissionsWithFilter( $params );
      $paramsForCounting = $params;
      $paramsForCounting['count'] = true;
      $paramsForCounting['limit'] = false;
      $paramsForCounting['offset'] = false;

      $total = $af_db->getLandingCommissionsWithFilter( $paramsForCounting );
      $response = [];

      $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=landing_commissions&subtab=add_edit' );
      $currency = afCurrency();
      $amountTypes = [ 'flat' => $currency, 'percentage'=> '%' ];

      foreach ( $data as $dataArray ){
          $amountDisplay = '';
          if ( isset( $dataArray['settings']['amount_value'] ) ){
              $amountDisplay = af_format_price_and_currency( $currency, $dataArray['settings']['amount_value'] );
          }

          $checkbox = '<input type="checkbox" name="landing_commissions[]" value="' . $dataArray['id'] . '" class="af-js-table-select-item" />';
          // label
          $labelDisplay = esc_af_content("<b>" . esc_attr( $dataArray['slug'] ) . "</b>")
                  . '<div id="landing_commission_' . esc_attr( $dataArray['id'] ) . '" class="af-visibility-hidden">'
                  . '<a href="' . esc_url( $urlAddEdit . '&slug=' . $dataArray['slug'] ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>'
                  . ' | '
                  . '<span class="af-js-remove-one-item af-delete-span" data-id="' . esc_attr( $dataArray['id'] ) . '" >' . esc_html__('Remove', 'openaffiliates') . '</span>';

          $response[] = [
                    'id'            => $dataArray['id'],
                    'checkbox'      => $checkbox,
                    'slug'          => [
                                    'display' =>  $labelDisplay,
                                    'value' 	=>  $dataArray['slug'],
                    ],
                    'description'   => $dataArray['settings']['description'],
                    'shortcode'     => "[af-landing-commission slug='" . $dataArray['slug'] . "']",
                    'amount'        => [
                                    'display' =>  $amountDisplay,
                                    'value' 	=>  $dataArray['settings']['amount_value'],
                    ],
                    'status'        => [
                                    'display' => empty( $dataArray['status'] ) ? '<span class="af-status af-status-inactive">'.esc_html__( 'Inactive', 'openaffiliates' ).'</span>' : '<span class="af-status af-status-active">'.esc_html__( 'Active', 'openaffiliates' ).'</span>',
                                    'value' 	=> $dataArray['status'],
                    ],
          ];
      }

      // output data, recordsTotal, recordsFiltered
      echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total ] );
      die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_one_landing_commission()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->delete_landing_commission_by_id($id);
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_many_landing_commissions()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        foreach ( $items as $id ){
            $af_db->delete_landing_commission_by_id( $id );
        }
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_get_banners()
    {
      if ( !afIsAdmin() ){
          die;
      }
      if ( !afAdminVerifyNonce() ){
          die;
      }
      // input : start, length, search[value], order[i][column], columns[i][orderable]
      global $af_db, $wpdb;

      // order by
      $ascOrDesc = '';
      $orderBy = '';
      if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
          $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
          $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
          $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
      }

      // search value
      $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
      if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
          $searchValue = sanitize_text_field( $_POST['search_phrase'] );
      }

      // offset and limit
      $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
      $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

      update_option( 'af_datatable_banners_entries_length', $limit );

      $params = [
                  'search_phrase'       => $searchValue,
                  'offset'              => $offset,
                  'limit'               => $limit,
                  'order_by'            => $orderBy,
                  'asc_or_desc'         => $ascOrDesc,
      ];

      $data = $af_db->getBannersWithFilter( $params );
      $paramsForCounting = $params;
      $paramsForCounting['count'] = true;
      $paramsForCounting['limit'] = false;
      $paramsForCounting['offset'] = false;

      $total = $af_db->getBannersWithFilter( $paramsForCounting );
      $response = [];

      $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=banners&subtab=add_edit&id=' );
      $BannersMeta = new \OpenAffiliates\Db\BannersMeta();

      foreach ( $data as $dataObject ){

          $checkbox = '<input type="checkbox" name="banner[]" value="' . $dataObject->id . '" class="af-js-table-select-item" />';
          // label
          $type = $BannersMeta->getOne( $dataObject->id, 'content_type' );
          $labelDisplay = esc_af_content("<b>" . esc_attr( $dataObject->name ) . "</b>")
                  . '<div id="banner_' . esc_attr( $dataObject->id ) . '" class="af-visibility-hidden">'
                  . '<a href="' . esc_url( $urlAddEdit . $dataObject->id ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>'
                  . ' | '
                  . '<span class="af-js-remove-one-item af-delete-span" data-id="' . esc_attr( $dataObject->id ) . '" >' . esc_html__('Remove', 'openaffiliates') . '</span>';
          if ( $type === '' || $type === false || $type === 'image' ){
              $content = '<img src="' . $dataObject->image . '" class="af-list-banner-img" alt="' . $dataObject->name . '" />';
          } else {
              $content = $BannersMeta->getOne( $dataObject->id, 'text_content' );
          }
          $response[] = [
                    'id'            => $dataObject->id,
                    'checkbox'      => $checkbox,
                    'name'          => [
                                    'display' =>  $labelDisplay,
                                    'value' 	=>  $dataObject->name,
                    ],
                    'content'       => $content,
                    'type'          => $type === false || $type === '' || $type === 'image' ? esc_html__( 'Image', 'openaffiliates' ) : esc_html__( 'Text Link', 'openaffiliates' ),
                    'url'           => '<a href="' . $dataObject->url . '" target="_blank">' . $dataObject->url . '</a>',
                    'status'        => (int)$dataObject->status === 1 ? '<span class="af-status af-status-active">'.esc_html__( 'Active', 'openaffiliates' ).'</span>' : '<span class="af-status af-status-inactive">'.esc_html__( 'Inactive', 'openaffiliates' ).'</span>' ,
                    'created_date'  => [
                                    'display' =>  af_convert_date_to_us_format( $dataObject->created_date ),
                                    'value' 	=>  $dataObject->created_date,
                    ]
          ];
      }

      // output data, recordsTotal, recordsFiltered
      echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total ] );
      die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_one_banners()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->deleteOneBanner($id);
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_many_banners()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        foreach ( $items as $id ){
            $af_db->deleteOneBanner( $id );
        }
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_get_notifications()
    {
      if ( !afIsAdmin() ){
          die;
      }
      if ( !afAdminVerifyNonce() ){
          die;
      }
      // input : start, length, search[value], order[i][column], columns[i][orderable]
      global $af_db, $wpdb;

      // order by
      $ascOrDesc = '';
      $orderBy = '';
      if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
          $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
          $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
          $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
      }

      if ( $orderBy === '' ){
          $orderBy = 'id';
          $ascOrDesc = 'DESC';
      }

      // search value
      $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
      if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
          $searchValue = sanitize_text_field( $_POST['search_phrase'] );
      }

      // types
      $typesIn = false;
      $typesNotIn = false;
      $typesIn = isset( $_POST['target_types'] ) ? af_sanitize_array( $_POST['target_types'] ) : false;
      if ( $typesIn && count( $typesIn ) == 1 && in_array( 'admin', $typesIn ) ){
          $typesIn = [
            'admin_user_register',
            'admin_on_aff_change_rank',
            'admin_affiliate_update_profile',
          ];
      } else if (  $typesIn && count( $typesIn ) == 1 && in_array( 'affiliate', $typesIn ) ){
          $typesNotIn = [
            'admin_user_register',
            'admin_on_aff_change_rank',
            'admin_affiliate_update_profile',
          ];
          $typesIn = false;
      } else {
          $typesIn = false;
          $typesNotIn = false;
      }

      // offset and limit
      $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
      $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

      update_option( 'af_datatable_notifications_entries_length', $limit );

      // status
      $statusIn = isset( $_POST['status'] ) ? af_sanitize_array( $_POST['status'] ) : false;
      if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
          $statusIn = false;
      }

      $params = [
                  'search_phrase'       => $searchValue,
                  'offset'              => $offset,
                  'limit'               => $limit,
                  'order_by'            => $orderBy,
                  'asc_or_desc'         => $ascOrDesc,
                  'status_in'           => $statusIn,
                  'types_in'            => $typesIn,
                  'types_not_in'        => $typesNotIn,
      ];

      $data = $af_db->getNotificationsWithFilter( $params );
      $paramsForCounting = $params;
      $paramsForCounting['count'] = true;
      $paramsForCounting['limit'] = false;
      $paramsForCounting['offset'] = false;

      $total = $af_db->getNotificationsWithFilter( $paramsForCounting );
      $response = [];

      $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=notifications&subtab=add_edit&id=' );
      $actions_available = array(
												'admin_user_register' => esc_html__('Affiliate Register - Admin Notification', 'openaffiliates'),
												'register' => esc_html__('Affiliate Register - User Notification', 'openaffiliates'),
												'register_lite_send_pass_to_user' => esc_html__('Affiliate Register - Register Lite: Send Generated Password', 'openaffiliates'),
												'affiliate_account_approve' => esc_html__('Affiliate - Approve Account', 'openaffiliates'),
												'mlm_new_assignation'				=> esc_html__('Affiliate - New MLM Assignation', 'openaffiliates'),
												'affiliate_profile_delete' => esc_html__('Affiliate - Delete Account', 'openaffiliates'),
												'user_update' => esc_html__('User Profile Updates', 'openaffiliates'),
												'rank_change' => esc_html__('Affiliate get new Rank', 'openaffiliates'),
												'reset_password_process' => esc_html__('Reset Password - Step 1: Confirmation Request', 'openaffiliates'),
												'reset_password' => esc_html__('Reset Password - Step 2: Send Generated Password', 'openaffiliates'),
												'change_password' => esc_html__('Reset Password - Step 3: Password Changed Notification', 'openaffiliates'),
												'admin_on_aff_change_rank' => esc_html__('Admin - Affiliate get new Rank', 'openaffiliates'),
												'admin_affiliate_update_profile' => esc_html__('Admin - Affiliate update profile', 'openaffiliates'),
												'affiliate_payment_fail' => esc_html__('Affiliate - Payment Inform - Failed', 'openaffiliates'),
												'affiliate_payment_pending' => esc_html__('Affiliate - Payment Inform - Pending', 'openaffiliates'),
												'affiliate_payment_complete' => esc_html__('Affiliate - Payment Inform - Completed', 'openaffiliates'),
												'email_check' => esc_html__('Affiliate - Double E-mail Verification Request', 'openaffiliates'),
												'email_check_success' => esc_html__('Affiliate - Double E-mail Verification Validated', 'openaffiliates'),
			);
			$email_verification = $af_db->is_magic_feat_enable('email_verification');
			if (empty($data['email_verification'])){
				unset($actions_available['email_check']);
				unset($actions_available['email_check_success']);
			}
			$ranks = $af_db->get_rank_list();
      $admin_notifications = [
        'admin_user_register',
        'admin_on_aff_change_rank',
        'admin_affiliate_update_profile',
      ];
      $adminEmail = get_option( 'admin_email' );

      foreach ( $data as $dataObject ){

          $checkbox = '<input type="checkbox" name="notification[]" value="' . $dataObject->id . '" class="af-js-table-select-item" />';
          // label
          $labelDisplay = esc_af_content("<b>" . esc_attr( $dataObject->subject ) . "</b>")
                  . '<div id="notification_' . esc_attr( $dataObject->id ) . '" class="af-visibility-hidden">'
                  . '<a href="' . esc_url( $urlAddEdit . $dataObject->id ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>'
                  . ' | '
                  . '<span class="af-js-remove-one-item af-delete-span" data-id="' . esc_attr( $dataObject->id ) . '" >' . esc_html__('Remove', 'openaffiliates') . '</span>';
          $target = '';
          if ($dataObject->rank_id==-1){
             $target = esc_html__("All", 'openaffiliates');
          }elseif (!empty($ranks[$dataObject->rank_id])){
             $target = esc_html($ranks[$dataObject->rank_id]);
          }
          // send test email bttn
          $options = '<div class="af-js-notifications-fire-notification-test af-notifications-list-send af-special-button"
                          data-notification_id="' . $dataObject->id . '"
                          data-email="' . $adminEmail . '"
                    >' . esc_html__('Send Test Email', 'openaffiliates') . '</div>';

          // status
          $checked = ((int)$dataObject->status) === 1 ? 'checked' : '';
          $status = '<label class="af_label_shiwtch af-switch-button-margin">
	<input type="checkbox" class="af-switch af-js-admin-notification-list-on-off" '.$checked.' data-id="' . $dataObject->id . '">
	<div class="switch af-display-inline"></div>
</label>';

          $response[] = [
                    'id'             => $dataObject->id,
                    'checkbox'       => $checkbox,
                    'subject'        => [
                                    'display' => $labelDisplay,
                                    'value' 	=> $dataObject->subject,
                    ],
                    'action'         => [
                                    'display' => isset( $actions_available[$dataObject->type] ) ? $actions_available[$dataObject->type] : $dataObject->type,
                                    'value' 	=>  $dataObject->type,
                    ],
                    'goes_to'        => in_array($dataObject->type, $admin_notifications) ? esc_html__('Manager', 'openaffiliates') : esc_html__('Affiliate', 'openaffiliates'),
                    'target_ranks'   => $target,
                    'status'         => $status,
                    'options'        => $options,
          ];
      }

      // output data, recordsTotal, recordsFiltered
      echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total ] );
      die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_one_notifications()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->delete_notification($id);
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_many_notifications()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        foreach ( $items as $id ){
            $af_db->delete_notification( $id );
        }
        die;
    }

    public function af_ajax_notification_modify_status()
    {
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $af_db->notificationUpdateStatus( sanitize_text_field( $_POST['id'] ), sanitize_text_field( $_POST['status'] ) );
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_get_affiliates()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;
        require_once AF_PATH . 'admin/utilities.php';

        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        if ( $orderBy !== '' ){
            switch ( $orderBy ){
                case 'id':
                  $orderBy = 'a.id';
                  break;
                case 'name':
                  $orderBy = 'u.display_name';
                  break;
                case 'email':
                  $orderBy = 'u.user_email';
                  break;
                case 'register_date':
                  $orderBy = 'a.start_data';//'u.user_registered';
                  break;
            }
        } else {
            $orderBy = 'a.start_data';
            $ascOrDesc = 'DESC';
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        update_option( 'af_datatable_affiliate_entries_length', $limit );

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
        ];

        // ranks_in
        $ranks = isset( $_POST['ranks'] ) ? af_sanitize_array( $_POST['ranks'] ) : false;
        if ( $ranks && count( $ranks ) > 0 && in_array( 'all', $ranks ) ){
            $ranks = false;
        }
        if ( $ranks !== false ){
            $params['ranks_in'] = $ranks;
        }


        $manyAffiliates = $af_db->getAffiliatesWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;
        $total = $af_db->getAffiliatesWithFilters( $paramsForCounting );

        $currency = afCurrency();
        $amountTypes = [ 'flat' => $currency, 'percentage'=> '%' ];
        $achieveTypes = [-1=>'...', 'referrals_number'=>'Number of Referrals', 'total_amount'=>'Total Amount'];
        $urlAddEdit = admin_url( 'admin.php?page=openaffiliates&tab=affiliates&subtab=add_edit' );
        $data = [];
        $rankLabel = [];
        $rankRate = [];
        $rankings = $af_db->affiliatesGetRanking();
        if ( $rankings ){
            end( $rankings );
            $key = current( $rankings );
            if ( $key ){
                $rankings_last_place = $key + 1;
            }
            reset( $rankings );
        }

        $affiliateProfile = admin_url('admin.php?page=openaffiliates&tab=user_profile&affiliate_id=');
        $mlm_on = $af_db->is_magic_feat_enable('mlm'); // make it dynamic
        $base_transations_url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=transactions');
        $mlm_matrix_link = admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=mlm_view_affiliate_children&affiliate_name=');
        $base_reports_url = admin_url('admin.php?page=openaffiliates&tab=reports');
        $base_visits_url = admin_url('admin.php?page=openaffiliates&tab=visits');
        $base_unpaid_url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=unpaid');
				$base_referrals_url = admin_url('admin.php?page=openaffiliates&tab=referrals');
        $show_cpm = $af_db->is_magic_feat_enable('cpm_commission') ? true : false;
        $show_ppc = $af_db->is_magic_feat_enable('pay_per_click') ? true : false;
        $addEditURL = admin_url('admin.php?page=openaffiliates&tab=affiliates&subtab=add_edit');
        $base_paid_url = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=paid_referrals');
        $base_pay_now = admin_url('admin.php?page=openaffiliates&tab=payments&subtab=payment_form');
        $rolesWithLabels = af_get_wp_roles_list();
  			$email_verification = $af_db->is_magic_feat_enable('email_verification');

        // public profile
        $publicProfilePageID = get_option('af_general_user_page');
        $affiliatePublicProfile = get_permalink($publicProfilePageID);
        $affiliateBaseLink = get_option('af_referral_custom_base_link');
    		if (empty($affiliateBaseLink)){
    				$affiliateBaseLink = get_home_url();
    		}
        $affiliateBaseLinkSettings = $af_db->return_settings_from_wp_option('general-settings');
        $affiliateLinkParam = 'ref';

    	  if (!empty($affiliateBaseLinkSettings['af_referral_variable'])){
    		  $affiliateLinkParam = $affiliateBaseLinkSettings['af_referral_variable'];
    	  }

        foreach ( $manyAffiliates as $affiliateObject ){

            // rank rate
            if ( !isset( $rankRate[ $affiliateObject->rank_id ] ) ){
                $rankRate[ $affiliateObject->rank_id ] = $af_db->getRankRate($affiliateObject->rank_id);
            }
            // rank label
            if ( !isset( $rankLabel[ $affiliateObject->rank_id ] ) ){
              $rank_data = empty( $affiliateObject->rank_id ) ? false : $af_db->get_rank($affiliateObject->rank_id);
              if ( $rank_data ){
                $rankLabel[ $affiliateObject->rank_id ] = isset( $rank_data['label'] ) ? $rank_data['label'] : '';

                $rankLabel[ $affiliateObject->rank_id ] = '<span class="af-js-tipso-item" data-tipso="'
                                                              . esc_html__('Default Rate: ', 'openaffiliates') . $rankRate[ $affiliateObject->rank_id ].'">'
                                                              . $rankLabel[ $affiliateObject->rank_id ]  . '</span>';
                //$rankColor[] = isset( $rank_data['rank_color'] ) ? $rank_data['rank_color'] : '';
                //$rankStyle[ $affiliateObject->rank_id ] = isset( $rank_data['rank_color'] ) ? 'af-box-background-' . $rank_data['rank_color'] : 'af-box-background-c9c9c9;';
              }
            }

            // role
            $role = $af_db->get_user_first_role($affiliateObject->uid);
            $pending = ($role === 'pending_user') ? 'af-pending' : '';
            if ( isset( $rolesWithLabels[$role] ) ){
                $role = $rolesWithLabels[$role];
            }
						$roleDisplay = '<div class="af-subcr-type-list ' . esc_attr($pending) . '">' . $role . '</div>';

            //stats
            $stats = $af_db->get_stats_for_payments($affiliateObject->id);

            // full name
            $fullName = $af_db->get_full_name_of_user( $affiliateObject->id );

            // user details
            $userDetails = '<img src="' . af_get_avatar_for_uid( $affiliateObject->uid ) . '" class="af-admin-affiliate-list-avatar" alt="' . esc_attr( $affiliateObject->user_login ) . '"/>';

            // create preview public profile url
            $affiliatePublicProfile = add_query_arg('aid', $affiliateObject->id, $affiliatePublicProfile );

            $userProfile = new \OpenAffiliates\Admin\UserProfile();

            $affiliateLinkValue = $affiliateObject->id;

            if (!empty($affiliateBaseLinkSettings['af_default_ref_format']) && $affiliateBaseLinkSettings['af_default_ref_format']=='username'){
              $user_info = get_userdata($affiliateObject->uid);
              if (!empty($user_info->user_login)){

                  $affiliateLinkValue = urlencode($user_info->user_login);
              }
            }
            $affiliateLink = af_create_affiliate_link($affiliateBaseLink, $affiliateLinkParam, $affiliateLinkValue);

            $userDetails .= '<span class="af-admin-affiliate-list-details">';
            $userDetails .= '<span class="af-list-affiliates-name-label">' . esc_html($fullName) . '</span>';
            $userDetails .= '<span class="af-admin-affiliate-list-details-unserame">' . esc_af_content( af_flag_for_affiliate( $affiliateObject->uid ) . $affiliateObject->user_login ) . '</span>';
            $userDetails .= af_admin_get_payment_gateway_label_for_affiliate( $affiliateObject->id, $affiliateObject->uid );
            $userDetails .= '</span>';
            $userDetails .= '<div class="af-visibility-hidden" id="affiliate_' . $affiliateObject->id . '" >';
            $userDetails .= '<a href="' . esc_url( $addEditURL . '&id=' . $affiliateObject->uid ) . '">' . esc_html__('Edit', 'openaffiliates') . '</a>';
            $userDetails .= ' | <span class="af-js-remove-one-item af-delete-span" data-id="' . $affiliateObject->id . '" >'.esc_html__('Remove', 'openaffiliates').'</span>';
            $userDetails .= ' | <a href="'.esc_url( $affiliateProfile . $affiliateObject->id ).'" target="_blank">'.esc_html__('Affiliate Profile', 'openaffiliates').'</a>';
            $userDetails .= ' | <a href="' . esc_url( $affiliatePublicProfile ) . '" target="_blank">' . esc_html__('Access Affiliate Portal', 'openaffiliates') . '</a>';


            if ( !empty($pending)  ){
                $userDetails .= ' | <span class="af-special-action-link af-js-datatable-affiliates-approve-user" data-uid="'.$affiliateObject->uid.'" >' . esc_html__('Approve Affiliate', 'openaffiliates') . '</span>';
            }
            if ( get_user_meta( $affiliateObject->uid, 'af_verification_status', true ) == -1 ){
              $userDetails .= '<span id="' . esc_attr('approve_email_' . $affiliateObject->uid ) . '"  >| <span class="af-special-action-link af-js-datatable-affiliate-approve-email" data-uid="'.$affiliateObject->uid.'" >' . esc_html__('Approve Email', 'openaffiliates') . '</span></span>';
            }
            $userDetails .= ' | <span data-link="' . esc_url( $affiliateLink ) . '" data-message="' . esc_html__('Copy to Clipboard', 'openaffiliates') . '" class="af-js-admin-affiliate-table-copy-clipboard af-special-action-link af-link-span">' . esc_html__('Affiliate Link', 'openaffiliates') . '</span>';
            $userDetails .= '</div>';



            // visits
            $visits = isset($stats['visits']) ? '<a href="' . esc_url($base_visits_url . '&affiliate_id=' . $affiliateObject->id ) . '">' . esc_html( $stats['visits'] ) . '</a>' : '';

            // buttons
            $bttns = '<div class="referral-status-verified af-affiliate-profile-button">';
            $bttns .= '<a href="' . esc_url( $affiliateProfile . $affiliateObject->id ) . '"  target="_blank">' . esc_html__('Affiliate Profile', 'openaffiliates') . '</a>';
            $bttns .= '</div>';

            //deprecated starting with v.8.6
              //$bttns .= '<div class="referral-status-verified af-affiliate-transactions-button">';
              //$bttns .= '<a href="' . esc_url( $base_transations_url . '&affiliate=' . $affiliateObject->id) . '">' . esc_html__('Transactions', 'openaffiliates') . '</a>';
              //$bttns .= '</div>';
            if ( $mlm_on && $af_db->affiliate_has_childrens($affiliateObject->id) ){
                $bttns .= '<div class="referral-status-unverified af-mlm-button">';
                $bttns .= '<a href="' . $mlm_matrix_link . $affiliateObject->user_login . '">' . esc_html__('MLM Matrix', 'openaffiliates') . '</a>';
                $bttns .= '</div>';
            }
            $bttns .= '<div class="referral-status-unverified af-reports-button" >';
            $bttns .= '<a href="' . esc_url( $base_reports_url . '&affiliate_id=' . $affiliateObject->id ) . '">' . esc_html__('Reports', 'openaffiliates') . '</a>';
            $bttns .= '</div>';
            $bttns .= '<div class="af_frw_button af_small_grey_button af-admin-do-send-email-via-af" data-uid="' . esc_attr($affiliateObject->uid) . '">' . esc_html__('Direct Email', 'openaffiliates') . '</div>';

            // referrals
            $referralsString = isset( $stats['referrals'] ) ? '<a href="' . esc_url( $base_referrals_url . '&affiliate_id=' . $affiliateObject->id ).'">'.esc_html( $stats['referrals'] ).'</a>' : '';
            // paid referrals
            $paidReferrals = isset($stats['paid_payments_value']) ? '<a href="'.esc_url($base_paid_url . '&affiliate=' . $affiliateObject->id ) . '">'.af_format_price_and_currency( $currency, $stats['paid_payments_value']).'</a>' : '';
            // unpaid referrals
            $unpaidReferrals = '';
            $unpaidReferrals .= '<strong class="af-price-color">';
            $unpaidReferrals .= isset($stats['unpaid_payments_value']) ? af_format_price_and_currency($currency, $stats['unpaid_payments_value']) : '';
            $unpaidReferrals .= '</strong>';
            if (!empty($stats['unpaid_payments_value']) && (float)$stats['unpaid_payments_value'] > 0 ){
                //deprecated starting with 8.6
                //$unpaidReferrals .= '<div><a href="' . esc_url($base_unpaid_url . '&affiliate=' . $affiliateObject->id ) . '">' . esc_html__('Proceed', 'openaffiliates') . '</a> | <a href="'.esc_url($base_pay_now . '&affiliate=' . $affiliateObject->id ).'">' . esc_html__('Pay All', 'openaffiliates') . '</a></div>';
            }

            // metrics
            $metricsOutput = '<div class="af-metris-leftside">';
            if ( !empty( $show_ppc ) ){
              $ppc = $af_db->getReferralsBySourceAndAffiliate('ppc', $affiliateObject->id);
              $metricsOutput .= '<div>' . esc_html__('CPC: ', 'openaffiliates') . esc_af_content( $ppc ) . '</div>';
            }
            if (!empty( $show_cpm ) ){
              $metricsOutput .= '<div>';
              $cpm = $af_db->getReferralsBySourceAndAffiliate('cpm', $affiliateObject->id);
              $number = $af_db->getCPMForAffiliate($affiliateObject->id);
              if ($number){
                  $number = $number / 10;
              }
              $metricsOutput .= esc_html__('CPM: ', 'openaffiliates') . $cpm ;
              $metricsOutput .= '<div class="af-progress-bar"><div class="af-progress-completed" style = " width:' . $number . '%;"></div></div>';
              $metricsOutput .= '</div>';
            }
            $metricsOutput .= '</div><div class="af-metris-rightside"><div>';
            $epc3 = $af_db->getEPCdata('3months', $affiliateObject->id );
            $metricsOutput .= esc_html__('3 months EPC: ', 'openaffiliates');
            $metricsOutput .= af_format_price_and_currency($currency, $epc3);
            $metricsOutput .= '</div><div>';
            $epc7 = $af_db->getEPCdata('7days', $affiliateObject->id );
            $metricsOutput .= esc_html__('7 days EPC: ', 'openaffiliates');
            $metricsOutput .= af_format_price_and_currency($currency, $epc7);
            $metricsOutput .= '</div></div><div class="af-clear"></div>';
            // end of metrics

            // top
            $top = '';
            if ( !empty( $rankings ) ){
                if ( empty( $rankings[$affiliateObject->id] ) ){
                  $top = '<!--img src="' . esc_url(AF_URL) . 'assets/images/af_trophy.png' . '"/><div class="af-userprofile-top-position-table">#';
                  $top .= ( isset( $rankings_last_place ) ) ? esc_html($rankings_last_place) : esc_html('N/A');
                  $top .= '</div-->';
                } else {
                  $top .= '<img src="' . AF_URL . 'assets/images/af_trophy.png' . '" alt="' . esc_attr($rankings[$affiliateObject->id]) . '"/>
                  <div class="af-userprofile-top-position-table">#' . esc_html( $rankings[$affiliateObject->id] ) . '</div>';
                }
            }
            if ( isset( $affiliateObject->rank_id ) && $affiliateObject->rank_id !== '' && $affiliateObject->rank_id !== false
            && isset( $rankLabel[ $affiliateObject->rank_id ] ) && $rankLabel[ $affiliateObject->rank_id ] !== ''){
                if ( !isset( $rankStyle[ $affiliateObject->rank_id ] ) ){
                    $rankStyle[ $affiliateObject->rank_id ] = '';
                }
                $rankHtml =  '<div class="rank-type-list ' . $rankStyle[ $affiliateObject->rank_id ] . '">' . $rankLabel[ $affiliateObject->rank_id ] . '</div>';
            } else {
                $rankHtml = '';
            }

            $checkbox = '<input type="checkbox" name="affiliates[]" value="' . $affiliateObject->id . '" class="af-js-table-select-item" />';
            $oneAffiliate = [
                          'checkbox'            => $checkbox,
                          'id'                  => [
                                          'display' => $affiliateObject->id,
                                          'value' 	=> $affiliateObject->id,
                          ],
                          'top'                 => [
                                          'display' => '<div class="af-cel-top-psition">' . $top . '</div>',
                                          'value' 	=> isset( $rankings[$affiliateObject->id] ) ? $rankings[$affiliateObject->id] : 0,
                          ],
                          'name'                => [
                                          'display' => $userDetails,
                                          'value' 	=> $fullName,
                          ],
                          'email'               => [
                                          'display' => '<a href="mailto:' . $affiliateObject->user_email . '" target="_blank">' . esc_html($affiliateObject->user_email) . '</a>',
                                          'value' 	=> $affiliateObject->user_email,
                          ],
                          'rank'                => $rankHtml,
                          'rate'                => $rankRate[ $affiliateObject->rank_id ],
                          'clicks'              => [
                                          'display' => $visits,
                                          'value' 	=> $stats['visits'],
                          ],
                          'referrals'           => [
                                          'display' => $referralsString,
                                          'value' 	=> $stats['referrals'],
                          ],
                          'paid_earnings'       => [
                                          'display' => $paidReferrals,
                                          'value' 	=> $stats['paid_payments_value'],
                          ],
                          'unpaid_earnings'     => [
                                          'display' => $unpaidReferrals,
                                          'value' 	=> $stats['unpaid_payments_value'],
                          ],
                          'metrics'             => '<div class="af-metrics-cell">' . $metricsOutput . '</div>',
                          'role'                => $roleDisplay,
                          'register_date'       => [
                                          'display' => '<div class="af-date-color">' . af_convert_date_to_us_format($affiliateObject->user_registered) . '</div>',
                                          'value' 	=> $affiliateObject->user_registered,
                          ],
                          'details'             => '<div class="af-buttons-wrapper">' . $bttns . '</div>',
            ];

            if ( $email_verification ){
                $emailStatus = get_user_meta( $affiliateObject->uid, 'af_verification_status', true );
                $div_id = "user_email_" . $affiliateObject->uid . "_status";
                $class = 'af-subcr-type-list';
                $label = '';
                if ( $emailStatus == 1 ){
                		$label = esc_html__('Verified', 'openaffiliates');
                } else if ( $emailStatus == -1 ){
                		$label = esc_html__('Unapproved', 'openaffiliates');
                		$class .= ' af-pending';
                } else {
                   	$label = '-';
                }
                $oneAffiliate['email_verification'] = '<div id="' . esc_attr($div_id) . '">
                  <span class="' . esc_attr($class) . '">' . esc_html($label) . '</span>
                </div>';
            }

            $data[] = $oneAffiliate;

        }
        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $data, 'recordsTotal' => $total, 'recordsFiltered' => $total, 'params' => json_encode( $params ) ] );
        die;
    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_one_affiliate()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->delete_affiliates( [ $id ] );
        die;

    }

    /**
     * @param none
     * @return array
     */
    public function af_ajax_remove_many_affiliates()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        $af_db->delete_affiliates( $items );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_update_ranks_for_affiliates()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        require_once AF_PATH . 'public/ChangeRanks.class.php';
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        $update_rank_object = new \ChangeRanks( $items );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_get_visits()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;


        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        if ( $orderBy === '' ){
            $orderBy = 'v.visit_date';
            $ascOrDesc = 'DESC';
        } else if ( $orderBy === 'created_time' ){
            $orderBy = 'v.visit_date';
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        update_option( 'af_datatable_visits_entries_length', $limit );

        // status
        $statusIn = isset( $_POST['status_in'] ) ? af_sanitize_array( $_POST['status_in'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }


        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
        ];

        // start time
        if ( isset( $_POST['start_time'] ) && $_POST['start_time'] !== '' ){
            $params['start_time'] = sanitize_text_field( $_POST['start_time'] );
        }
        // end time
        if ( isset( $_POST['end_time'] ) && $_POST['end_time'] !== '' ){
            $params['end_time'] = sanitize_text_field( $_POST['end_time'] );
        }

        $data = $af_db->getVisitsWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $total = $af_db->getVisitsWithFilters( $paramsForCounting );
        $response = [];

        foreach ( $data as $dataObject ){

            $checkbox = '<input type="checkbox" name="visits[]" value="' . $dataObject->id . '" class="af-js-table-select-item" />';
            // ip
            $ip = $dataObject->ip;
            $ip .= '<div id="visit_' . $dataObject->id . '" class="af-visibility-hidden">';
            $ip .= '<span class="af-js-remove-one-item af-delete-span" data-id="' . $dataObject->id . '">' . esc_html__( 'Remove', 'openaffiliates') . '</span>';
            $ip .= '</div>';

            // affiliate
            $uid = $af_db->get_uid_by_affiliate_id($dataObject->affiliate_id);
            $affiliate_id = '<a href="'.admin_url('admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $dataObject->affiliate_id).'" target="_blank">'.esc_html($dataObject->affiliate_id).'</a>';
            $affiliate = '<span><a href="' . admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $dataObject->affiliate_id ) . '" target="_blank">' . $dataObject->display_name . '</a></span><div>'.$dataObject->user_email.'</div>';

            // referral
            if ( $dataObject->referral_id > 0 ){
                $referral = '<a href="' . admin_url( 'admin.php?page=openaffiliates&tab=referrals&subtab=add_edit&id=' . $dataObject->referral_id ) . '" target="_blank">' . $dataObject->referral_id . '</a>';
            } else {
                $referral = '-';
            }

            // converted
            if (!empty($dataObject->referral_id)){
               $converted = esc_af_content('<div class="referral-status-verified af-status af-status-active">' . esc_html__('Converted', 'openaffiliates') . '</div>');
            } else {
               $converted = esc_af_content('<div class="referral-status-refuse af-status af-status-inactive">' . esc_html__('Just Visit', 'openaffiliates') . '</div>');
            }

            // device
            $device = '<i class="' . esc_af_content("fa-af fa-" . $dataObject->device . "-af") . '"></i>';

            $ref_url = '';
            if ( $dataObject->ref_url ){
              $ref_url = '<a href="' . $dataObject->ref_url . '" target="_blank" >' . $dataObject->ref_url . '</a>';
            }

            $response[] = [
                      'id'            => $dataObject->id,
                      'checkbox'      => $checkbox,
                      'ip'            => [
                                      'display' => $ip,
                                      'value' 	=> $dataObject->ip,
                      ],
                      'affiliate_id'  => [
                                      'display' => $affiliate_id,
                                      'value' 	=> $dataObject->affiliate_id,
                      ],
                      'affiliate'     => [
                                      'display' => $affiliate,
                                      'value' 	=> $dataObject->username,
                      ],
                      'referral_id'   => [
                                      'display' => $referral,
                                      'value' 	=> $dataObject->referral_id,
                      ],
                      'landing_page'       => [
                                      'display' => '<a href="' . $dataObject->url . '" target="_blank" >' . $dataObject->url . '</a>',
                                      'value' 	=> $dataObject->url,
                      ],
                      'referring_url'  => [
                                      'display' => $ref_url,
                                      'value' 	=> $dataObject->ref_url,
                      ],
                      'browser' => [
                                      'display' => $dataObject->browser,
                                      'value' 	=> $dataObject->browser,
                      ],
                      'device'        => [
                                      'display' => $device,
                                      'value' 	=> $dataObject->device,
                      ],
                      'created_time'  => [
                                      'display' => af_convert_date_to_us_format($dataObject->visit_date),
                                      'value' 	=> $dataObject->visit_date,
                      ],
                      'status'        => [
                                      'display' => $converted,
                                      'value' 	=> $dataObject->status,
                      ],
            ];
        }

        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total, 'params' => json_encode( $params ) ] );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_one_visit()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->delete_visits( [ $id ] );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_many_visits()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            die;
        }
        $items = explode( ',', $ids );
        $af_db->delete_visits( $items );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_get_referrals()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;


        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        update_option( 'af_datatable_referrals_entries_length', sanitize_text_field( $_POST['start'] ) );

        // status
        $statusIn = isset( $_POST['status_in'] ) ? af_sanitize_array( $_POST['status_in'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }

        // sources in
        $sourceIn = isset( $_POST['source'] ) ? af_sanitize_array( $_POST['source'] ) : false;
        if ( $sourceIn && count( $sourceIn ) > 0 && in_array( 'all', $sourceIn ) ){
            $sourceIn = false;
        }

        switch ( $orderBy ){
            case 'id':
              $orderBy = 'r.id';
              break;
            case 'affiliate_id':
              $orderBy = 'r.affiliate_id';
              break;
            case 'created_time':
              $orderBy = 'r.date';
              break;
            case 'affiliate_username':
              $orderBy = 'u.user_login';
              break;
        }

        if ( $orderBy === '' ){
            $orderBy = 'r.date';
            $ascOrDesc = 'DESC';
        }

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
                    'sources_in'          => $sourceIn,
        ];
        // start time
        if ( isset( $_POST['start_time'] ) && $_POST['start_time'] !== '' ){
            $params['start_time'] = sanitize_text_field( $_POST['start_time'] );
        }
        // end time
        if ( isset( $_POST['end_time'] ) && $_POST['end_time'] !== '' ){
            $params['end_time'] = sanitize_text_field( $_POST['end_time'] );
        }

        $data = $af_db->getReferralsWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $total = $af_db->getReferralsWithFilters( $paramsForCounting );
        $currency = afCurrency();
        $response = [];
        $available_systems = af_get_active_services();
        if (!empty($available_systems['woo'])){
					$woo_order_base_link = admin_url('post.php?post=');// must add &action=edit after id
				}
				if (!empty($available_systems['ulp'])){
					$ulp_order_base_link = admin_url('post.php?post=');// must add &action=edit after id
				}
				if (!empty($available_systems['edd'])){
					$edd_order_base_link = admin_url('edit.php?post_type=download&page=edd-payment-history&view=view-order-details&id=');
				}
				if (!empty($available_systems['ump'])){
					$ump_order_base_link = admin_url('admin.php?page=ihc_manage&tab=order-edit&order_id=');
				}
				$mlm_order_base_link = admin_url('admin.php?page=openaffiliates&tab=referral_list_details&id=');
				$user_sign_up_link = admin_url('user-edit.php?user_id=');
        $urlAddEdit = admin_url('admin.php?page=openaffiliates&tab=referrals&subtab=add_edit');


        foreach ( $data as $dataObject ){
            // reference
            $reference = '';
            if(!empty($dataObject->reference)){
              $reference = esc_html($dataObject->reference);
            }

            $link = '';

              if (!empty($dataObject->reference)){
                switch ($dataObject->source){
                  case 'woo':
                    if (!empty($woo_order_base_link)){
                      $link = $woo_order_base_link . $dataObject->reference . '&action=edit';
                    }
                    $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $dataObject->reference . '</a>');
                    break;
                  case 'ulp':
                    if (!empty($ulp_order_base_link)){
                      $link = $ulp_order_base_link . $dataObject->reference . '&action=edit';
                    }
                    $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $dataObject->reference . '</a>');
                    break;
                  case 'edd':
                    if (!empty($edd_order_base_link)){
                      $link = $edd_order_base_link . $dataObject->reference;
                    }
                    $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $dataObject->reference . '</a>');
                    break;
                  case 'ump':
                    $link = $ump_order_base_link . $dataObject->reference;
                    $reference = esc_html__('Sale', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $dataObject->reference . '</a>');
                    break;
                  case 'mlm':
                    $the_ref = $dataObject->reference;
                    $the_ref = str_replace('mlm_', '', $the_ref);
                    $link = $mlm_order_base_link . $the_ref;
                    $reference = esc_html__('Referral', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $the_ref . '</a>');
                    break;
                  case 'User SignUp':
                    if (!empty($dataObject->reference) && strpos($dataObject->reference, 'user_id_')!==FALSE){
                      $uid_sign_up = str_replace('user_id_', '', $dataObject->reference );
                      $link = $user_sign_up_link . $uid_sign_up;
                      $reference = esc_html__('User ID', 'openaffiliates').' '.esc_af_content('<a href="' . $link . '" target="_blank">#' . $uid_sign_up . '</a>');
                    }
                    break;
                  default:
                    $link = apply_filters( 'af_admin_dashboard_custom_referrence_link', '', (array)$dataObject );
                    if(!empty($link)){
                      $reference = esc_af_content('<a href="' . $link . '" target="_blank">' . $dataObject->reference . '</a>');
                    }

                    break;
                }
              }
            if(isset($dataObject->refferal_wp_uid)){
              if( $dataObject->refferal_wp_uid == "0"){
                $dataObject->refferal_wp_uid = "-";
              }else{
                $link = $user_sign_up_link . $dataObject->refferal_wp_uid;
                $dataObject->refferal_wp_uid = esc_af_content('<a href="' . $link . '" target="_blank">' . $dataObject->refferal_wp_uid . '</a>');
              }
            }

            if(isset($dataObject->visit_id) && $dataObject->visit_id == "0"){
              $dataObject->visit_id = "-";
            }
            $affiliate = '<a href="'.admin_url('admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $dataObject->affiliate_id).'" target="_blank">'.esc_html($dataObject->affiliate_id).'</a>';
            $affiliate_name = '<span><a href="' . admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $dataObject->affiliate_id ) . '" target="_blank">' . $dataObject->display_name . '</a></span><div>'.$dataObject->user_email.'</div>';

            $checkbox = '<input type="checkbox" name="referrals[]" value="' . $dataObject->id . '" class="af-js-table-select-item" />';

            // referral id display
            $referralDisplay = $dataObject->id;
            $referralDisplay .= '<div id="referral_'.esc_attr($dataObject->id).'" class="af-visibility-hidden">';
						$referralDisplay .= '<a href="' . esc_url($urlAddEdit . '&id=' . $dataObject->id) . '">' . esc_html__('Edit', 'openaffiliates') . '</a> | ';
						$referralDisplay .= '<span class="af-js-remove-one-item af-delete-span" data-id="' . $dataObject->id . '">' . esc_html__( 'Remove', 'openaffiliates') . '</span>';
						$referralDisplay .= '</div>';

            // status
								/*
								 * 1 - Pending
								 * 2 - Approved
								 * 0 - Rejected
								 */
              $statusDisplay = '';
							if (!$dataObject->status){
								   $statusDisplay .= '<div class="referral-status-refuse af-status af-status-failed">' . esc_html__('Rejected', 'openaffiliates') . '</div>';
							} else if ($dataObject->status==1){
									 $statusDisplay .= '<div class="referral-status-unverified af-status af-status-inactive">' . esc_html__('Pending', 'openaffiliates') . '</div>';
							} else if ($dataObject->status==2){
								    $statusDisplay .= '<div class="referral-status-verified af-status af-status-active">' . esc_html__('Approved', 'openaffiliates') . '</div>';
							}
              $statusDisplay .= '<div>';
							$status_arr = [0 => esc_html__('Rejected', 'openaffiliates'), 1 => esc_html__('Pending', 'openaffiliates'), 2 => esc_html__('Approved', 'openaffiliates')];
							$i = 1;
							foreach ($status_arr as $k=>$v){
										if ($k!=$dataObject->status){
											 if ($i != 1){
												  $statusDisplay .= esc_af_content(" | ");
											 }
										  $i++;
                      $statusDisplay .= '<span class="refferal-chang-status af-js-referral-list-change-status" data-value="' . esc_attr($dataObject->id . '-' . $k) . '" >'. esc_html__('Mark as ', 'openaffiliates') .  esc_html($v) . '</span>';
										}
									}
							 $statusDisplay .= '</div>';

               // payout status
   								/*
   								 * 1 - Pending
   								 * 2 - Paid
   								 * 0 - UnPaid
   								 */
                   $paymentStatusDisplay = '';
     							if (!$dataObject->payment){
     								   $paymentStatusDisplay .= '<div class="referral-status-refuse af-status af-status-inactive">' . esc_html__('UnPaid', 'openaffiliates') . '</div>';
     							} else if ($dataObject->payment==1){
     									 $paymentStatusDisplay .= '<div class="referral-status-unverified af-status af-status-pending">' . esc_html__('Pending', 'openaffiliates') . '</div>';
     							} else if ($dataObject->payment==2){
     								    $paymentStatusDisplay .= '<div class="referral-status-verified af-status af-status-paid">' . esc_html__('Paid', 'openaffiliates') . '</div>';
     							}

            $response[] = [
                      //'id'            => $dataObject->id,
                      'checkbox'      => $checkbox,
                      'id'         => [
                                      'display' => $referralDisplay,
                                      'value' 	=> $dataObject->id,
                      ],
                      'affiliate_id'  => [
                                      'display' => $affiliate,
                                      'value' 	=> $dataObject->affiliate_id,
                      ],
                      'affiliate_username'  => [
                                      'display' => $affiliate_name,
                                      'value' 	=> $dataObject->user_login,
                      ],
                      'source'         => [
                                      'display' => af_service_type_code_to_title($dataObject->source),
                                      'value' 	=> $dataObject->source,
                      ],
                      'reference'         => [
                                      'display' => $reference,
                                      'value' 	=> $dataObject->reference,
                      ],
                      'description'       => [
                                      'display' => $dataObject->description,
                                      'value' 	=> $dataObject->description,
                      ],
                      'amount'       => [
                                      'display' => af_format_price_and_currency( $currency, $dataObject->amount ),
                                      'value' 	=> $dataObject->amount,
                      ],
                      'customer_id'       => [
                                      'display' => $dataObject->refferal_wp_uid,
                                      'value' 	=> $dataObject->refferal_wp_uid,
                      ],
                      'click_id'       => [
                                      'display' => $dataObject->visit_id,
                                      'value' 	=> $dataObject->visit_id,
                      ],
                      'created_time'  =>  [
                                      'display' => af_convert_date_to_us_format($dataObject->date),
                                      'value' 	=> $dataObject->date,
                      ],
                      'status'  =>  [
                                      'display' => $statusDisplay,
                                      'value' 	=> $dataObject->status,
                      ],
                      'payment_status'  =>  [
                                      'display' => $paymentStatusDisplay,
                                      'value' 	=> $dataObject->payment,
                      ],
            ];
        }

        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $response, 'recordsTotal' => $total, 'recordsFiltered' => $total, 'params' => json_encode( $params ) ] );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_one_referral()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('Something went wrong. Please try again later. If the issue persists, contact support for assistance');
            die;
        }
        $id = sanitize_text_field( $_POST['id'] );
        $af_db->delete_referrals( $id );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_many_referrals()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('Something went wrong. Please try again later. If the issue persists, contact support for assistance');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            echo esc_html(' error, ids are not set.');
            die;
        }
        if ( strpos( $ids, ',') !== false ){
            $items = explode( ',', $ids );
            foreach ( $items as $id ){
                $af_db->delete_referrals( $id );
            }
        } else {
            $af_db->delete_referrals( $ids );
        }

        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_change_status_referral()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['change_status'] ) ){
            echo esc_html('error');
            die;
        }
        $change_status = isset( $_POST['change_status'] ) ? sanitize_text_field( $_POST['change_status'] ) : false;
        $status_data = explode('-', $change_status );
        if (isset($status_data[0]) && isset($status_data[1])){
          $af_db->change_referral_status($status_data[0], $status_data[1]);
        }
    }


    /**
     * @param none
     * @return none
     */
    public function saveState()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        if ( !isset( $_POST['state'] ) || $_POST['state'] === '' || !isset( $_POST['type'] ) || $_POST['type'] === '' ){
            die;
        }

        $state = af_sanitize_textarea_array( $_POST['state'] );
        $state = stripslashes( $state );
        $type = sanitize_text_field( $_POST['type'] );
        update_option( $type, $state );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_get_payouts()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]
        global $af_db, $wpdb;

        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        // status
        $statusIn = isset( $_POST['status_in'] ) ? af_sanitize_array( $_POST['status_in'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
        ];

        // start time
        if ( isset( $_POST['start_time'] ) && $_POST['start_time'] !== '' ){
            $params['start_time'] = sanitize_text_field( $_POST['start_time'] );
        }
        // end time
        if ( isset( $_POST['end_time'] ) && $_POST['end_time'] !== '' ){
            $params['end_time'] = sanitize_text_field( $_POST['end_time'] );
        }

        $payoutsModel = new \OpenAffiliates\Db\Payouts();
        $manyPayouts = $payoutsModel->getManyWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $count = $payoutsModel->getManyWithFilters( $paramsForCounting );

        $data = [];
        $methodTypes = [
                          'inherited' => esc_html__( 'Inherited payout method', 'openaffiliates'),
                          'bt'        => esc_html__( 'Direct Deposit', 'openaffiliates' ),
                          'paypal'    => esc_html__( 'PayPal', 'openaffiliates' ),
                          'stripe'    => esc_html__( 'Stripe', 'openaffiliates' ),
        ];
        foreach ( $manyPayouts as $payout ){
            if ( empty( $payout['id'] ) ){
                continue;
            }
            $completePercentage = $payoutsModel->getCompletedPercentage( $payout['id'] );
            $checkbox = '<input type="checkbox" name="payouts[]" value="' . $payout['id'] . '" class="af-js-table-select-item" />';
            $actions = '<div class="refferal-chang-status" ><a href="' . admin_url('admin.php?page=openaffiliates&tab=payments&subtab=view_payout&id=' . $payout['id'] ) . '" class="">' . esc_html__( 'View', 'openaffiliates' ) . '</a></div>'.
                       '<div class="af-js-remove-one-item refferal-chang-status" data-id="' . $payout['id'] . '" >' . esc_html__( 'Remove', 'openaffiliates' ) . '</div>'.
                       '<div class="af-js-payouts-generate-csv-for-payout refferal-chang-status" data-id="' . $payout['id'] . '" >' . esc_html__( 'Generate CSV', 'openaffiliates' ) . '</div>'
                       .'<a href="" class="af-js-payouts-csv-file refferal-chang-status af-display-none af-js-payouts-csv-file-for-payout-' . $payout['id'] . '">'.esc_html__('Download File', 'openaffiliates').'</a>';
            $data[] = [
                              'checkbox'            => $checkbox,
                              'id'                  => [
                                              'display' => $payout['id'],
                                              'value' 	=> $payout['id'],
                              ],
                              'date_range'          => af_convert_date_to_us_format( $payout['start_time'] ) . ' - ' . af_convert_date_to_us_format( $payout['end_time'] ),
                              'method'              => isset( $methodTypes[$payout['method']] ) ? $methodTypes[$payout['method']] : $payout['method'],
                              'amount'              => [
                                              'display' => af_format_price_and_currency( afCurrency($payout['currency']), $payout['amount'] ),
                                              'value' 	=> $payout['amount'],
                              ],
                              'payment'             => [
                                              'display' => '<a href="' . admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=manage_payments&payout_id=' . $payout['id'] ) . '" target="_blank">' . $payout['number_of_payments'] . '</a>',
                                              'value' 	=> $payout['number_of_payments'],
                              ],
                              'progress'              => [
                                              'display'     => '<div class="af-payout-progress-bar"><div class="af-payout-progress-bar-filled" title="'.$completePercentage.'% ' . esc_html__( 'Completed', 'openaffiliates' ) . '" style="width:'.$completePercentage.'%;"></div></div>',
                                              'value'       => $completePercentage,
                              ],
                              'created_time'          => [
                                              'display' => af_convert_date_to_us_format($payout['created_time']),
                                              'value' 	=> $payout['created_time'],
                              ],
                              'status'                => [
                                              'display' => ((int)$completePercentage < 100 ) ? '<div class="af-status af-status-inactive">' . esc_html__( 'Processing', 'openaffiliates' ) . '</div>'
                                                                                      : '<div class="af-status af-status-active">' . esc_html__( 'Completed', 'openaffiliates' ) . '</div>' ,
                                              'value' 	=> $payout['status'],
                              ],
                              'actions'                => $actions,
            ];
        }

        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => count( $data ), 'params' => json_encode( $params ) ] );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_one_payout()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }

        $id = sanitize_text_field( $_POST['id'] );
        $PayoutsModel = new \OpenAffiliates\Db\Payouts();
        $PayoutsModel->deleteOne( $id );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_many_payouts()
    {
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            echo esc_html(' error, ids are not set.');
            die;
        }

        $PayoutsModel = new \OpenAffiliates\Db\Payouts();
        if ( strpos( $ids, ',') !== false ){
            $items = explode( ',', $ids );
            foreach ( $items as $id ){
                $PayoutsModel->deleteOne( $id );
            }
        } else {
            $PayoutsModel->deleteOne( $ids );
        }
        die;
    }

    /**
      * @param none
      * @return none
      */
    public function af_ajax_payouts_generate_csv()
    {
        if ( !afIsAdmin() ){
            echo 0;
            die;
        }
        if ( !afAdminVerifyNonce() ){
            echo 0;
            die;
        }
        $payoutId = isset( $_POST['payout_id'] ) ? sanitize_text_field( $_POST['payout_id'] ) : 0;
        $paymentMetaModel = new \OpenAffiliates\Db\PaymentMeta();
        $allPayments = $paymentMetaModel->getAllPaymentIdsForMetaNameMetaValue( 'payout_id', $payoutId );
        if ( $allPayments === false || !is_array( $allPayments ) || count( $allPayments ) === 0 ){
            echo 0;
            die;
        }
        $exportAsCSV = new \OpenAffiliates\ExportDataAsCsv();
        $link = $exportAsCSV->setTypeOfData( 'payouts' ) // acctualy its payments, but we change the names after version 8.6
                            ->setFilters( [ 'ids_in' => $allPayments ] )
                            ->run()
                            ->getDownloadLink();
				if ( !$link ){
						echo 0;
						die;
				}
				echo esc_af_content($link);
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_get_payments()
    {
        global $af_db, $wpdb;
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        // input : start, length, search[value], order[i][column], columns[i][orderable]

        // order by
        $ascOrDesc = '';
        $orderBy = '';
        if ( isset( $_POST['order'][0]['column'] ) && $_POST['order'][0]['column'] !== '' ){
            $columnId = sanitize_text_field( $_POST['order'][0]['column'] );
            $ascOrDesc = sanitize_text_field( $_POST['order'][0]['dir'] );
            $orderBy = isset(	$_POST['columns'][$columnId]['data'] ) ? sanitize_text_field($_POST['columns'][$columnId]['data']) : false;
        }

        // search value
        $searchValue = isset( $_POST['search']['value'] ) ? sanitize_text_field( $_POST['search']['value'] ) : false;
        if ( isset( $_POST['search_phrase'] ) && $_POST['search_phrase'] !== '' ){
            $searchValue = sanitize_text_field( $_POST['search_phrase'] );
        }

        // offset and limit
        $offset = isset( $_POST['start'] ) && $_POST['start'] !== '' && $_POST['start'] !== false ? sanitize_text_field( $_POST['start'] ) : 0;
        $limit = isset( $_POST['length'] ) ? sanitize_text_field( $_POST['length'] ) : 30;

        // status
        $statusIn = isset( $_POST['status_in'] ) ? af_sanitize_array( $_POST['status_in'] ) : false;
        if ( $statusIn && count( $statusIn ) > 0 && in_array( 'all', $statusIn ) ){
            $statusIn = false;
        }

        $payoutId = isset( $_POST['payout_id'] ) ? sanitize_text_field( $_POST['payout_id'] ) : false;

        $params = [
                    'search_phrase'       => $searchValue,
                    'offset'              => $offset,
                    'limit'               => $limit,
                    'order_by'            => $orderBy,
                    'asc_or_desc'         => $ascOrDesc,
                    'status_in'           => $statusIn,
                    'payout_id'           => $payoutId,
        ];

        // start time
        if ( isset( $_POST['start_time'] ) && $_POST['start_time'] !== '' ){
            $params['start_time'] = sanitize_text_field( $_POST['start_time'] );
        }
        // end time
        if ( isset( $_POST['end_time'] ) && $_POST['end_time'] !== '' ){
            $params['end_time'] = sanitize_text_field( $_POST['end_time'] );
        }

        $manyPayments = $af_db->getPaymentsWithFilters( $params );
        $paramsForCounting = $params;
        $paramsForCounting['count'] = true;
        $paramsForCounting['limit'] = false;
        $paramsForCounting['offset'] = false;

        $count = $af_db->getPaymentsWithFilters( $paramsForCounting );

        $data = [];
        $methodTypes = [
                          'inherited' => esc_html__( 'Inherited payout method', 'openaffiliates'),
                          'bt'        => esc_html__( 'Direct Deposit', 'openaffiliates' ),
                          'bank_transfer'        => esc_html__( 'Direct Deposit', 'openaffiliates' ),
                          'wallet'        => esc_html__( 'Wallet', 'openaffiliates' ),
                          'paypal'    => esc_html__( 'PayPal', 'openaffiliates' ),
                          'stripe'    => esc_html__( 'Stripe', 'openaffiliates' ),
        ];
        $statusArr = [
            0 => esc_html__('Failed', 'openaffiliates'),
            1 => esc_html__('Processing', 'openaffiliates'),
            2 => esc_html__('Paid', 'openaffiliates'),
        ];
        foreach ( $manyPayments as $payment ){
            if ( empty( $payment['id'] ) ){
                continue;
            }
            $checkbox = '<input type="checkbox" name="payments[]" value="' . $payment['id'] . '" class="af-js-table-select-item" />';
            $actions = '<div class="refferal-chang-status" ><a href="' . admin_url('admin.php?page=openaffiliates&tab=payments&subtab=view_payment&id=' . $payment['id'] ) . '" class="">' . esc_html__( 'View', 'openaffiliates' ) . '</a></div>'.
                       '<div class="af-js-remove-one-item refferal-chang-status" data-id="' . $payment['id'] . '" >' . esc_html__( 'Remove', 'openaffiliates' ) . '</div>';

            $statusDisplay = '';

            if( $payment['status'] == 2 || $payment['status'] == 'Paid'){
              $statusDisplay = '<div class="af-status af-status-active">' . esc_html__( 'Paid', 'openaffiliates' ) . '</div>';
            }
            if( $payment['status'] == 1 || $payment['status'] == 'Processing'){
              $statusDisplay = '<div class="af-status af-status-inactive">' . esc_html__( 'Processing', 'openaffiliates' ) . '</div>';
            }
            if( $payment['status'] == 0 || $payment['status'] == 'Failed'){
              $statusDisplay = '<div class="af-status af-status-failed">' . esc_html__( 'Failed', 'openaffiliates' ) . '</div>';
            }

            $referralsAsArray = explode( ',', $payment['referral_ids'] );
            $referralsCount = count( $referralsAsArray );
            $data[] = [
                              'checkbox'            => $checkbox,
                              'id'                  => [
                                              'display' => $payment['id'],
                                              'value' 	=> $payment['id'],
                              ],
                              'affiliate'           => [
                                                          'display' => '<span><a href="' . admin_url( 'admin.php?page=openaffiliates&tab=user_profile&affiliate_id=' . $payment['affiliate_id'] ) . '" target="_blank">'
                                                                          . $payment['user_email'] . '</a></span>'
                                                                        . '<div>' . $af_db->get_full_name_of_user( $payment['affiliate_id'] ) . '</div>',
                                                          'value'   => $payment['user_email'],
                              ],
                              'payment_method'      => isset( $methodTypes[ $payment['payment_type'] ] ) ? $methodTypes[ $payment['payment_type'] ] : $payment['payment_type'],
                              'amount'              => [
                                              'display' => af_format_price_and_currency( afCurrency($payment['currency']), $payment['amount'] ),
                                              'value' 	=> $payment['amount'],
                              ],
                              'referrals'           => $referralsCount,
                              'payout'              => [
                                              'display' => empty($payment['payout_id'] ) ? '-' : '<a href="'.admin_url( 'admin.php?page=openaffiliates&tab=view_payout&id=' . $payment['payout_id'] ).'" target="_blank">' . $payment['payout_id'] . '</a>',
                                              'value' 	=> $payment['payout_id'],
                              ],
                              'create_date'         => [
                                              'display' => af_convert_date_to_us_format($payment['create_date']),
                                              'value' 	=> $payment['create_date'],
                              ],
                              'status'              => $statusDisplay,
                              'actions'             => $actions
            ];
        }

        // output data, recordsTotal, recordsFiltered
        echo json_encode( [ 'data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => $count, 'params' => json_encode( $params ) ] );
        die;

    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_one_payment()
    {
        global $af_db;

        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['id'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }

        $id = sanitize_text_field( $_POST['id'] );
        //$af_db->deleteOnePayment( $id );
        $af_db->cancel_transaction( $id );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_remove_many_payments()
    {
        global $af_db;

        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        global $af_db;
        if ( empty( $_POST['ids'] ) || empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $ids = isset( $_POST['ids'] ) ? sanitize_text_field( $_POST['ids'] ) : false;
        if ( !$ids ){
            echo esc_html(' error, ids are not set.');
            die;
        }

        if ( strpos( $ids, ',') !== false ){
            $items = explode( ',', $ids );
            foreach ( $items as $id ){
                //$af_db->deleteOnePayment( $id );
                $af_db->cancel_transaction( $id );
            }
        } else {
            //$af_db->deleteOnePayment( $ids );
            $af_db->cancel_transaction( $ids );
        }
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_payments_change_status()
    {
        global $af_db;
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        if ( empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : false;
        $id = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : false;
        if ( $status === false || $id === false ){
            die;
        }
        $af_db->change_transaction_status($id, $status);
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function af_ajax_payout_all_payments_change_status()
    {
        global $af_db;
        if ( !afIsAdmin() ){
            die;
        }
        if ( !afAdminVerifyNonce() ){
            die;
        }
        if ( empty($_POST['af_admin_forms_nonce']) || !wp_verify_nonce( sanitize_text_field($_POST['af_admin_forms_nonce']), 'af_admin_forms_nonce' ) ){
            echo esc_html('error');
            die;
        }
        $status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : false;
        $id = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : false;

        if ( $status === false || $id === false ){
            die;
        }
        $paymentMetaModel = new \OpenAffiliates\Db\PaymentMeta();
        $manyPayments = $paymentMetaModel->getAllPaymentIdsForMetaNameMetaValue( 'payout_id', $id );
        if ( $manyPayments === false || !is_array( $manyPayments ) || !count( $manyPayments ) ){
            die;
        }
        foreach ( $manyPayments as $paymentId ){
            // change status to all payout payments
            $af_db->change_transaction_status( $paymentId, $status );
        }

        die;
    }

}
