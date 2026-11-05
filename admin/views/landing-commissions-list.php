<div class="af-wrapper">
	<div class="af-page-title"><?php esc_html_e('Manage Landing Commissions (CPA)', 'openaffiliates');?></div>
		<div class="af-page-top-options">
		<a href="<?php echo esc_url($data['url-add_edit']);?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><span><?php esc_html_e('Add New Landing Commission (CPA)', 'openaffiliates');?></span></a>
		<span class="af-top-message"><?php esc_html_e('...create your Landing Commission (CPA -CostPerAction) Shortcode', 'openaffiliates');?></span>
		</div>
		<div class="af-info-box"><?php esc_html_e('Just copy the landing commission (CPA) shortcode into any successful page (ex: Thank You Register page) and the affiliate will receive a certain commission based on generated referral.', 'openaffiliates');?></div>
		<?php if (!empty($data['errors'])) : ?>
			<div class="af-wrapp-the-errors"><?php echo esc_html($data['errors']);?></div>
		<?php endif;?>
		<!-- messages -->
		<?php if (!empty($data['alert_message'])):?>
			<div class="af-error-message"><?php echo esc_af_content($data['alert_message']);?></div>
		<?php endif;?>
		<!-- end of messages -->


		<div class="af-wrapper">

		<!-- Start DataTable -->
		<?php
		// 1. Datatable - define table name. used in js.
		$tableDataType = 'landing_commissions';

		// 2. Datatable - define columns
		$columns = [
									[
												'data'				=> 'checkbox',
												'title'				=> '<input type=checkbox class=af-js-select-all-checkboxes />',
												'orderable'		=> false,
												'sortable'		=> false,
									],
									[
												'data' 				=> 'slug',
												'title'				=> esc_html__('Name', 'openaffiliates'),
												'orderable'   => true,
												'sortable'		=> true,
								        'render'  		=> [
										                      'display'   => 'display',
										                      'sort'      => 'value',
								        ]
									],
									[
												'data' 				=> 'description',
												'title'				=> esc_html__('Description', 'openaffiliates'),
												'orderable'		=> false,
												'sortable'		=> false,
									],
									[
												'data' 				=> 'amount',
												'title'				=> esc_html__('Rate', 'openaffiliates'),
												'orderable'   => false,
												'sortable'		=> false,
								        'render'  		=> [
										                      'display'   => 'display',
										                      'sort'      => 'value',
								        ]
									],
									[
												'data' 				=> 'shortcode',
												'title'				=> esc_html__('Shortcode', 'openaffiliates'),
												'orderable'		=> false,
												'sortable'		=> false,
									],
									[
												'data' 				=> 'status',
												'title'				=> esc_html__('Status', 'openaffiliates'),
												'orderable'   => true,
												'sortable'		=> true,
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
				data-remove_one_item="<?php esc_html_e('Are you sure you want to remove this Landing Commission?', 'openaffiliates');?>"
				data-remove_many_items="<?php esc_html_e('Are you sure you want to remove selected Landing Commissions?', 'openaffiliates');?>" ></div>
		<!-- End of 4. Datatable - Js confirm messages -->

				<!-- 5. Datatable - Custom Search + Filter -->
				<div class="af-datatable-filters-wrapper">
								<input type="text" value="" placeholder="<?php esc_html_e("Search Commissions", 'openaffiliates');?>" class="af-js-search-phrase af-max-width-300">
								<div class="af-datatable-multiselect-wrapp">
										<select name="status_types[]" class="af-js-datatable-items-status-types" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
												<option value="1"><?php esc_html_e('Active', 'openaffiliates');?></option>
												<option value="0"><?php esc_html_e('Inactive', 'openaffiliates');?></option>
										</select>
								</div>
								<!--button class="af-datatable-filter-bttn"><?php esc_html_e('Filter', 'openaffiliates');?></button-->
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
				<?php $pageState = get_option( 'af_datatable_state_for-landing_commissions', false );?>
				<?php if ( $pageState !== false  && !empty( $pageState ) ):?>
						<div class="af-js-datatable-state" data-value='<?php echo stripslashes( $pageState );?>' ></div>
				<?php endif;?>
				<!-- End of 8. Page State -->

				<div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>"></div>
		<!-- End DataTable -->

		</div>

	</div>
