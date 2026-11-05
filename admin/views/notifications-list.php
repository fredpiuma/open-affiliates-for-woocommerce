<div class="af-wrapper">
		<div class="af-page-title"><?php esc_html_e('Manage Notifications', 'openaffiliates');?></div>
		<div class="af-page-top-options">
				<a href="<?php echo esc_url($data['url-add_edit']);?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><?php esc_html_e('Activate New Notification', 'openaffiliates');?></a>
				<span class="af-top-message"><?php esc_html_e('...create your notification Templates!', 'openaffiliates');?></span>
		<a href="javascript:void(0)" class="button button-primary button-large af-check-email-button af-special-button" onClick="afCheckEmailServer();"><?php esc_html_e('Check Mail Server', 'openaffiliates');?></a>
		<a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=notification-logs' );?>" class="button button-primary button-large af-first-button af-notifications-logs"><?php esc_html_e('Notifications Logs', 'openaffiliates');?></a>

        <span class="af-admin-need-help af-admin-need-help-notifications"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span>
		<div class="af-clear"></div>
		</div>
		<div>

			<!-- Start DataTable -->
			<?php
			// 1. Datatable - define table name. used in js.
			$tableDataType = 'notifications';

			// 2. Datatable - define columns
			$columns = [
										[
													'data'				=> 'checkbox',
													'title'				=> '<input type=checkbox class=af-js-select-all-checkboxes />',
													'orderable'		=> false,
													'sortable'		=> false,
										],
										[
													'data' 				=> 'subject',
													'title'				=> esc_html__('Subject', 'openaffiliates'),
													'orderable'   => true,
													'sortable'		=> true,
													'className'		=> 'af-max-width-350',
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
													'className'		=> 'af-max-width-100',
										],
										[
													'data' 				=> 'action',
													'title'				=> esc_html__('Action', 'openaffiliates'),
													'orderable'   => false,
													'sortable'		=> false,
									        'render'  		=> [
											                      'display'   => 'display',
											                      'sort'      => 'value',
									        ]
										],
										[
													'data' 				=> 'goes_to',
													'title'				=> esc_html__('Goes to', 'openaffiliates'),
													'orderable'   => false,
													'sortable'		=> false,
										],
										[
													'data' 				=> 'target_ranks',
													'title'				=> esc_html__('Ranks Target', 'openaffiliates'),
													'orderable'   => false,
													'sortable'		=> false,
										],
										[
													'data' 				=> 'options',
													'title'				=> esc_html__('Options', 'openaffiliates'),
													'orderable'   => false,
													'sortable'		=> false,
										],
			];
			// End of 2. Datatable - define columns


			// 3. Datatable - Js and CSS for datatable
			\OpenAffiliates\Admin\DataTable::Scripts( $columns, $tableDataType );

			?>

			<!-- 4. Datatable - Js confirm messages -->
			<div class="af-js-messages-for-datatable"
					data-remove_one_item="<?php esc_html_e('Are You sure You want to remove this notification?', 'openaffiliates');?>"
					data-remove_many_items="<?php esc_html_e('Are You sure You want to remove selected notifications?', 'openaffiliates');?>" ></div>
			<!-- End of 4. Datatable - Js confirm messages -->

					<!-- 5. Datatable - Custom Search + Filter -->
					<div class="af-datatable-filters-wrapper">
									<input type="text" value="" placeholder="<?php esc_html_e("Search Notifications", 'openaffiliates');?>" class="af-js-search-phrase af-max-width-300">
									<div class="af-datatable-multiselect-wrapp">
											<select name="status_types[]" class="af-js-datatable-items-status-types" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
													<option value="1"><?php esc_html_e('Active', 'openaffiliates');?></option>
													<option value="0"><?php esc_html_e('Inactive', 'openaffiliates');?></option>
											</select>
									</div>
									<div class="af-datatable-multiselect-wrapp">
											<select name="target[]" class="af-js-datatable-items-target-types" multiple data-placeholder="<?php esc_html_e("Goes to", 'openaffiliates');?>">
													<option value="admin"><?php esc_html_e('Affiliate Managers', 'openaffiliates');?></option>
													<option value="affiliate"><?php esc_html_e('Affiliates', 'openaffiliates');?></option>
											</select>
									</div>
									<button class="af-datatable-filter-bttn"><?php esc_html_e('Filter', 'openaffiliates');?></button>
					</div>
					<!-- End of 5. Datatable - Custom Search + Filter -->

					<!-- 6. Datatable - the table html -->
					<table id="af-dashboard-table" class="display af-dashboard-table af-notifications-table" >
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
					<?php $pageState = get_option( 'af_datatable_state_for-notifications', false );?>
					<?php if ( $pageState !== false && !empty( $pageState )  ):?>
							<div class="af-js-datatable-state" data-value='<?php echo stripslashes( $pageState );?>' ></div>
					<?php endif;?>
					<!-- End of 8. Page State -->

					<div class="af-js-datatable-listing-delete-nonce" data-value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>"></div>
			<!-- End DataTable -->

		</div>
</div>






<?php
return;?>

<?php if (!empty($data['listing_items'])) : ?>

	<form method="post" id="form_notification" class="af-notifications-list">

			<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

			<table class="wp-list-table widefat fixed tags af-admin-tables">
				<thead>
					<tr>
						<th><?php esc_html_e('Subject', 'openaffiliates');?></th>
						<th><?php esc_html_e('Action', 'openaffiliates');?></th>
						<th><?php esc_html_e('Goes to', 'openaffiliates');?></th>
						<th><?php esc_html_e('Ranks Target', 'openaffiliates');?></th>
						<?php if ($af_db->is_magic_feat_enable('pushover')):?>
						<th class="manage-column af-text-center"><?php esc_html_e('Mobile Notifications', 'openaffiliates');?></th>
						<?php endif;?>
						<th><?php esc_html_e('Options', 'openaffiliates');?></th>
					</tr>
				</thead>

				<tbody class="ui-sortable af-alternate">
					<?php
						$admin_notifications = array(
													'admin_user_register',
													'admin_on_aff_change_rank',
													'admin_affiliate_update_profile',
						);
					?>
					<?php foreach ($data['listing_items'] as $arr) : ?>
						<?php
							if (empty($data['email_verification']) && ($arr->type=='email_check' || $arr->type=='email_check_success')){
								continue;
							}
						?>
						<tr onmouseover="afDhSelector('#notification_<?php echo esc_attr($arr->id);?>', 1);" onmouseout="afDhSelector('#notification_<?php echo esc_attr($arr->id);?>', 0);">
							<td>
								<?php echo esc_html($arr->subject);?>
								<div id="notification_<?php echo esc_attr($arr->id);?>" class="af-visibility-hidden">
									<a href="<?php echo esc_url($data['url-add_edit'] . '&id=' . $arr->id);?>"><?php esc_html_e('Edit', 'openaffiliates');?></a>
									|
									<a onclick="afDeleteFromTable(<?php echo esc_attr($arr->id);?>, 'Notification', '#delete_notification_id', '#form_notification');" href="javascript:return false;" class="af-color-red"><?php esc_html_e('Delete', 'openaffiliates');?></a>
								</div>
							</td>
							<td><div class="af-list-affiliates-name-label"><?php if (!empty($data['actions_available'][$arr->type])){
								echo esc_html($data['actions_available'][$arr->type]);
							}?></div></td>
							<td><?php
								if (in_array($arr->type, $admin_notifications)){
									echo esc_html__('Affiliate Managers', 'openaffiliates');
								} else {
									echo esc_html__('Affiliate', 'openaffiliates');
								}
							?></td>
							<td><?php
								if ($arr->rank_id==-1){
									 esc_html_e("All", 'openaffiliates');
								}elseif (!empty($data['ranks'][$arr->rank_id])){
									 echo esc_html($data['ranks'][$arr->rank_id]);
								}?>
							</td>
							<?php if ($af_db->is_magic_feat_enable('pushover')):?>
								<td class="af-text-center">
									<?php if (!empty($arr->pushover_status)):?>
										<i class="fa-af fa-pushover-on-af"></i>
									<?php endif;?>
								</td>
							<?php endif;?>
							<td>
									<div class="af-js-notifications-fire-notification-test af-notifications-list-send af-special-button"
												data-notification_id="<?php echo esc_attr($arr->id);?>"
												data-email="<?php echo get_option( 'admin_email' );?>"
									><?php esc_html_e('Send Test Email', 'openaffiliates');?></div>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<th><?php esc_html_e('Subject', 'openaffiliates');?></th>
						<th><?php esc_html_e('Action', 'openaffiliates');?></th>
						<th><?php esc_html_e('Goes to', 'openaffiliates');?></th>
						<th><?php esc_html_e('Ranks Target', 'openaffiliates');?></th>
						<?php if ($af_db->is_magic_feat_enable('pushover')):?>
						<th class="manage-column af-text-center"><?php esc_html_e('Mobile Notifications', 'openaffiliates');?></th>
						<?php endif;?>
						<th><?php esc_html_e('Options', 'openaffiliates');?></th>
					</tr>
				</tfoot>
			</table>

		<input type="hidden" name="delete_notification" value="" id="delete_notification_id" />
	</form>

<?php else :?>

	<h5><?php esc_html_e('No Notification Available!', 'openaffiliates');?></h5>

<?php endif;?>
