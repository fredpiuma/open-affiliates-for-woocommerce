<?php
		global $af_db;
		wp_enqueue_script( 'af_csv_export', AF_URL . 'assets/js/csv_export.js', ['jquery'] );
 		wp_enqueue_script('jquery-ui-datepicker');
		$affiliateId = isset( $_GET['affiliate_id'] ) ? sanitize_text_field( $_GET['affiliate_id'] ) : false;
		if ( $affiliateId !== false ){
				$searchAffiliate = $af_db->get_email_by_affiliate_id( $affiliateId );
		}
?>
<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Manage Clicks', 'openaffiliates');?></div>
	<div class="af-special-buttons-users">
		<div class="af-special-button js-af-export-csv" data-export_type="visits"><i class="fa-af fa-export-csv"></i><?php esc_html_e( 'Export CSV', 'openaffiliates' );?></div>
	</div>

	<!-- Start DataTable -->
	<?php
	// 1. Datatable - define table name. used in js.
	$tableDataType = 'visits';

	// 2. Datatable - define columns
	$columns = [
								[
											'data'				=> 'checkbox',
											'title'				=> '<input type=checkbox class=af-js-select-all-checkboxes />',
											'orderable'		=> false,
											'sortable'		=> false,
								],
								[
											'data' 				=> 'ip',
											'title'				=> esc_html__('IP', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'className'		=> 'af-max-width-100',
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data' 				=> 'affiliate_id',
											'title'				=> esc_html__('Affiliate ID', 'openaffiliates'),
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
											'className'		=> 'af-max-width-300',
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data' 				=> 'referral_id',
											'title'				=> esc_html__('Referral ID', 'openaffiliates'),
											'orderable'   => true,
											'sortable'		=> true,
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data' 				=> 'landing_page',
											'title'				=> esc_html__('Landing Page', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'className'		=> 'af-max-width-200',
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data' 				=> 'referring_url',
											'title'				=> esc_html__('Referring URL', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'className'		=> 'af-max-width-200',
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data'				=> 'browser',
											'title'				=> esc_html__('Browser', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data'				=> 'device',
											'title'				=> esc_html__('Device', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'visible'	  	=> false,
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data'				=> 'created_time',
											'title'				=> esc_html__('Created Time', 'openaffiliates'),
											'orderable'   => true,
											'sortable'		=> true,
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
								[
											'data'				=> 'status',
											'title'				=> esc_html__('Status', 'openaffiliates'),
											'orderable'   => false,
											'sortable'		=> false,
											'render'  		=> [
																				'display'   => 'display',
																				'sort'      => 'value',
											]
								],
	];
	// End of 2. Datatable - define columns


	// 3. Datatable - Js and CSS for datatable
	\OpenAffiliates\Admin\DataTable::Scripts( $columns, $tableDataType );

	?>

	<!-- 4. Datatable - Js confirm messages -->
	<div class="af-js-messages-for-datatable"
			data-remove_one_item="<?php esc_html_e('Are You sure You want to remove this click?', 'openaffiliates');?>"
			data-remove_many_items="<?php esc_html_e('Are You sure You want to remove selected clicks?', 'openaffiliates');?>" ></div>
	<!-- End of 4. Datatable - Js confirm messages -->

			<!-- 5. Datatable - Custom Search + Filter -->
			<div class="af-datatable-filters-wrapper">
							<input type="text" value="<?php if ( isset( $searchAffiliate ) && $searchAffiliate !== '' ){ echo $searchAffiliate;}?>" placeholder="<?php esc_html_e("Search Clicks", 'openaffiliates');?>" class="af-js-search-phrase af-max-width-300">

							<!--label class="af-label"><?php esc_html_e('Start:', 'openaffiliates');?></label-->
							<input type="text" name="udf" value="" class="af-general-date-filter af-no-margin-right" placeholder="From - yyyy-mm-dd"/>
							<!--label class="af-label"><?php esc_html_e('Until:', 'openaffiliates');?></label--><span class="af-date-line">-</span>
							<input type="text" name="udu" value="" class="af-general-date-filter" placeholder="To -yyyy-mm-dd"/>

							<div class="af-datatable-multiselect-wrapp">
								<select name="status_in[]" class="af-js-datatable-items-status-types" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
										<option value="0"><?php esc_html_e( 'Just Visit', 'openaffiliates' );?></option>
										<option value="1"><?php esc_html_e( 'Converted', 'openaffiliates' );?></option>
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
			<?php $pageState = get_option( 'af_datatable_state_for-visits', false );?>
			<?php if ( $pageState !== false && !empty( $pageState )  ):?>
					<div class="af-js-datatable-state" data-value='<?php echo stripslashes( $pageState );?>' ></div>
			<?php endif;?>
			<!-- End of 8. Page State -->

			<div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>"></div>
	<!-- End DataTable -->

</div>
