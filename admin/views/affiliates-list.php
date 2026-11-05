<?php
wp_enqueue_script('afAdminSendEmail', AF_URL . 'assets/js/afAdminSendEmail.js', array('jquery'), null);
wp_enqueue_script('af_csv_export', AF_URL . 'assets/js/csv_export.js', array('jquery'), null);
$ranks = $af_db->get_rank_list();
$defaultRank = isset($_GET['rank_id']) ? sanitize_text_field($_GET['rank_id']) : false;
?>
<div class="af-wrapper af-affiliate-list-wrapper">
	<div class="af-page-title"><?php esc_html_e('Manage Affiliates', 'openaffiliates'); ?></div>
	<div class="af-page-top-options">
		<a href="<?php echo esc_url($data['url-add_edit']); ?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><span><?php esc_html_e('Add new Affiliate', 'openaffiliates'); ?></span></a>
		<a href="<?php echo admin_url('admin.php?page=openaffiliates&tab=payments&subtab=new_payout'); ?>" target="_blank" class="af-add-new-like-wp af-second-main-button"><span><?php esc_html_e('Pay Affiliates', 'openaffiliates'); ?></span></a>
	</div>
	<?php echo esc_af_content($data['errors']); ?>
	<div class="af-special-buttons-users">
		<?php
		$filters = [
			'rank' 									=> empty($_REQUEST['ordertype_rank']) ? '' : $_REQUEST['ordertype_rank'],
		];
		?>
		<div class="af-special-button js-af-export-csv" data-filters='<?php echo (isset($_REQUEST['ordertype_rank'])) ? json_encode($filters) : ''; ?>' data-export_type="affiliates">
			<i class="fa-af fa-export-csv"></i><?php esc_html_e('Export CSV', 'openaffiliates'); ?>
		</div>
	</div>
	<!-- Start DataTable -->
	<?php
	// 1. Datatable - define table name. used in js.
	$tableDataType = 'affiliates';
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
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data' 				=> 'top',
			'title'				=> esc_html__('Top', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data' 				=> 'name',
			'title'				=> esc_html__('Name', 'openaffiliates'),
			'orderable'   => true,
			'sortable'		=> true,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			],
			'className'		=> 'af-max-width-200',
		],
		[
			'data' 				=> 'email',
			'title'				=> esc_html__('Email Address', 'openaffiliates'),
			'orderable'   => true,
			'sortable'		=> true,
			'className'		=> 'af-max-width-150',
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data' 				=> 'rank',
			'title'				=> esc_html__('Rank', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'className'		=> 'af-max-width-100',
		],
		[
			'data'				=> 'rate',
			'title'				=> esc_html__('Rate', 'openaffiliates'),
			'orderable'		=> false,
			'sortable'		=> false,
		],
		[
			'data'				=> 'clicks',
			'title'				=> esc_html__('Clicks', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data'				=> 'referrals',
			'title'				=> esc_html__('Referrals', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data'				=> 'paid_earnings',
			'title'				=> esc_html__('Paid Earnings', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data'				=> 'unpaid_earnings',
			'title'				=> esc_html__('Unpaid Earnings', 'openaffiliates'),
			'orderable'   => false,
			'sortable'		=> false,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data'				=> 'metrics',
			'title'				=> esc_html__('Metrics', 'openaffiliates'),
			'orderable'		=> false,
			'sortable'		=> false,
			'visible'	  	=> false,
		],
		[
			'data'				=> 'role',
			'title'				=> esc_html__('Role', 'openaffiliates'),
			'orderable'		=> false,
			'sortable'		=> false,
			'visible'	  	=> false,
		],
		[
			'data'				=> 'email_verification',
			'title'				=> esc_html__('Email Status', 'openaffiliates'),
			'orderable'		=> false,
			'sortable'		=> false,
			'visible'	  	=> false,
		],
		[
			'data'				=> 'register_date',
			'title'				=> esc_html__('Affiliate Since', 'openaffiliates'),
			'orderable'   => true,
			'sortable'		=> true,
			'render'  		=> [
				'display'   => 'display',
				'sort'      => 'value',
			]
		],
		[
			'data'				=> 'details',
			'title'				=> esc_html__('Details', 'openaffiliates'),
			'orderable'		=> false,
			'sortable'		=> false,
		],
	];
	// End of 2. Datatable - define columns
	$email_verification = $af_db->is_magic_feat_enable('email_verification');
	if (!$email_verification) {
		unset($columns[13]);
		$columns = array_values($columns);
	}
	// 3. Datatable - Js and CSS for datatable
	\OpenAffiliates\Admin\DataTable::Scripts($columns, $tableDataType);
	?>
	<!-- 4. Datatable - Js confirm messages -->
	<div class="af-js-messages-for-datatable"
		data-remove_one_item="<?php esc_html_e('Are You sure You want to remove this affiliate?', 'openaffiliates'); ?>"
		data-remove_many_items="<?php esc_html_e('Are You sure You want to remove selected affiliates?', 'openaffiliates'); ?>"></div>
	<!-- End of 4. Datatable - Js confirm messages -->
	<!-- 5. Datatable - Custom Search + Filter -->
	<div class="af-datatable-filters-wrapper">
		<input type="text" value="" placeholder="<?php esc_html_e("Search Affiliates", 'openaffiliates'); ?>" class="af-js-search-phrase af-max-width-300">
		<div class="af-datatable-multiselect-wrapp">
			<select name="ranks[]" class="af-js-datatable-filter-ranks" multiple data-placeholder="<?php esc_html_e("Ranks", 'openaffiliates'); ?>">
				<?php if ($ranks): ?>
					<?php foreach ($ranks as $rankId => $rankLabel): ?>
						<?php $selected = $defaultRank && (int)$defaultRank === $rankId ? 'selected' : ''; ?>
						<option <?php echo $selected; ?> value="<?php echo $rankId; ?>"><?php echo $rankLabel; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		<button class="af-datatable-filter-bttn"><?php esc_html_e('Filter', 'openaffiliates'); ?></button>
	</div>
	<!-- End of 5. Datatable - Custom Search + Filter -->
	<!-- 6. Datatable - the table html -->
	<table id="af-dashboard-table" class="display af-dashboard-table">
	</table>
	<!-- End of 6. Datatable - the table html -->
	<!-- 7. Datatable - Bulk actions -->
	<div class="af-datatable-actions-wrapp-copy af-display-none">
		<select name="af-action" class="af-datatable-select-field af-js-bulk-action-select">
			<option value="" disabled selected><?php esc_html_e('Bulk Actions', 'openaffiliates'); ?></option>
			<option value="remove"><?php esc_html_e('Remove', 'openaffiliates'); ?></option>
			<option value="update_rank"><?php esc_html_e('Update Rank', 'openaffiliates'); ?></option>
		</select>
		<input type="submit" name="af-datatable-submit" value="<?php esc_html_e('Apply', 'openaffiliates'); ?>" class="button button-primary button-small af-js-items-apply-bttn" />
	</div>
	<!-- End of 7. Datatable - Bulk actions -->
	<!-- 8. Page State -->
	<?php $pageState = get_option('af_datatable_state_for-affiliates', false); ?>
	<?php if ($pageState !== false && !empty($pageState)): ?>
		<div class="af-js-datatable-state" data-value='<?php echo stripslashes($pageState); ?>'></div>
	<?php endif; ?>
	<!-- End of 8. Page State -->
	<div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce('af_admin_forms_nonce'); ?>"></div>
	<!-- End DataTable -->
</div>