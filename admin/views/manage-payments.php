<div class="">
  <div class="af-page-title"><?php esc_html_e( 'Manage Payments', 'openaffiliates');?></div>
  <div class="af-page-top-options">
  		<a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=payments&subtab=new_payout' );?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><?php esc_html_e( 'Pay Affiliates', 'openaffiliates');?></a>
  		<span class="af-top-message"><?php esc_html_e('...distribute earnings to your Affiliates', 'openaffiliates');?></span>
  </div>
  <?php if ( !empty($data['messages']) ):?>

  <?php endif;?>

  <div class="">

    <!-- Start DataTable -->
 		<?php
 		// 1. Datatable - define table name. used in js.
 		$tableDataType = 'payments';

 		// 2. Datatable - define columns
 		$columns = [
 									[
 												'data'				=> 'checkbox',
 												'title'				=> '<input type=checkbox class=af-js-select-all-checkboxes />',
 												'orderable'		=> false,
 												'sortable'		=> false,
 									],
 									[
 												'data' 				=> 'id',
 												'title'				=> esc_html__('ID', 'openaffiliates'),
 												'orderable'   => true,
 												'sortable'		=> true,
 												'className'		=> 'af-max-width-100',
 												'render'  		=> [
 																					'display'   => 'display',
 																					'sort'      => 'value',
 												]
 									],
 									[
 												'data' 				=> 'affiliate',
 												'title'				=> esc_html__('Affiliate', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-250',
 												'render'  		=> [
 																					'display'   => 'display',
 																					'sort'      => 'value',
 												]
 									],
 									[
 												'data' 				=> 'payment_method',
 												'title'				=> esc_html__('Payment Method', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-250',
 									],
 									[
 												'data' 				=> 'amount',
 												'title'				=> esc_html__('Amount', 'openaffiliates'),
 												'orderable'   => true,
 												'sortable'		=> true,
 												'className'		=> 'af-max-width-150',
 												'render'  		=> [
 																					'display'   => 'display',
 																					'sort'      => 'value',
 												]
 									],
 									[
 												'data' 				=> 'referrals',
 												'title'				=> esc_html__('Referrals', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-100',
 									],
 									[
 												'data' 				=> 'payout',
 												'title'				=> esc_html__('Payout', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-100',
 												'render'  		=> [
 																					'display'   => 'display',
 																					'sort'      => 'value',
 												]
 									],
 									[
 												'data' 				=> 'create_date',
 												'title'				=> esc_html__('Created Time', 'openaffiliates'),
 												'orderable'   => true,
 												'sortable'		=> true,
 												'className'		=> 'af-max-width-250',
 												'render'  		=> [
 																					'display'   => 'display',
 																					'sort'      => 'value',
 												]
 									],
 									[
 												'data' 				=> 'status',
 												'title'				=> esc_html__('Status', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-150',
 									],
 									[
 												'data' 				=> 'actions',
 												'title'				=> esc_html__('Actions', 'openaffiliates'),
 												'orderable'   => false,
 												'sortable'		=> false,
 												'className'		=> 'af-max-width-150',
 									]
 		];
 		// End of 2. Datatable - define columns


 		// 3. Datatable - Js and CSS for datatable
 		\OpenAffiliates\Admin\DataTable::Scripts( $columns, $tableDataType );

 		?>

 		<!-- 4. Datatable - Js confirm messages -->
 		<div class="af-js-messages-for-datatable"
 				data-remove_one_item="<?php esc_html_e('Are you sure you want to remove this payment?', 'openaffiliates');?>"
 				data-remove_many_items="<?php esc_html_e('Are you sure you want to remove selected payments?', 'openaffiliates');?>" ></div>
 		<!-- End of 4. Datatable - Js confirm messages -->

 				<!-- 5. Datatable - Custom Search + Filter -->
 				<div class="af-datatable-filters-wrapper">
 								<input type="text" value="" placeholder="<?php esc_html_e("Search Payment", 'openaffiliates');?>" class="af-js-search-phrase af-max-width-300">

 								<!--label class="af-label"><?php esc_html_e('Start:', 'openaffiliates');?></label-->
 								<input type="text" name="udf" value="" class="af-general-date-filter af-no-margin-right" placeholder="From - yyyy-mm-dd"/>
 								<!--label class="af-label"><?php esc_html_e('Until:', 'openaffiliates');?></label--><span class="af-date-line">-</span>
 								<input type="text" name="udu" value="" class="af-general-date-filter" placeholder="To - yyyy-mm-dd"/>

 								<div class="af-datatable-multiselect-wrapp af-filter-status-select">
 									<select name="status_in[]" class="af-js-datatable-items-status-types " multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
                      <option value="0"><?php esc_html_e( 'Failed', 'openaffiliates' );?></option>
 											<option value="1"><?php esc_html_e( 'Processing', 'openaffiliates' );?></option>
 											<option value="2"><?php esc_html_e( 'Paid', 'openaffiliates' );?></option>
 									</select>
 								</div>

 								<button class="af-datatable-filter-bttn"><?php esc_html_e('Filter', 'openaffiliates');?></button>
 				</div>
 				<!-- End of 5. Datatable - Custom Search + Filter -->

 				<!-- 6. Datatable - the table html -->
 				<table id="af-dashboard-table" class="display af-dashboard-table" >
 				</table>
 				<!-- End of 6. Datatable - the table html -->

 				<!-- 7. Datatable - Bulk actions -->
 				<div class="af-datatable-actions-wrapp-copy af-display-none">
 						<select name="af-action" class="af-datatable-select-field af-js-bulk-action-select">
 								<option value="" disabled selected ><?php esc_html_e( 'Bulk Actions', 'openaffiliates' );?></option>
 								<option value="remove"><?php esc_html_e('Remove', 'openaffiliates');?></option>
 						</select>
 						<input type="submit" name="af-datatable-submit" value="<?php esc_html_e('Apply', 'openaffiliates');?>" class="button button-primary button-small af-js-items-apply-bttn" />
 				</div>
 				<!-- End of 7. Datatable - Bulk actions -->

 				<!-- 8. Page State -->
 				<?php $pageState = get_option( 'af_datatable_state_for-payments', false );?>
 				<?php if ( $pageState !== false && !empty( $pageState )  ):?>
 						<div class="af-js-datatable-state" data-value='<?php echo stripslashes( $pageState );?>' ></div>
 				<?php endif;?>
 				<!-- End of 8. Page State -->

 				<div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>"></div>
        <?php if ( !empty( $_GET['payout_id'] ) ):?>
            <input type="hidden" name="payout_id" class="af-js-payout-id" value="<?php echo sanitize_text_field( $_GET['payout_id'] );?>" />
        <?php endif;?>
  </div>

</div>
