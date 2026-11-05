<?php $custom_css = '';

foreach ($data['menu'] as $slug => $item):
		if ( !isset($item['af_tab_' . $slug . '_icon_code']) || ($item['af_tab_' . $slug . '_icon_code'] === false || $item['af_tab_' . $slug . '_icon_code'] === '') )continue;
		$custom_css .= ".fa-" . $slug . "-account-af:before{".
			"content: '\\".$item['af_tab_' . $slug . '_icon_code']."';".
			"font-size: 20px;".
		"}";
endforeach;
	?>


<div class="af-wrapper af-account-page-menu-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Affiliate Area Tabs', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">

			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold Affiliate Area Tabs', 'openaffiliates');?></h2>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_account_page_menu_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_account_page_menu_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_account_page_menu_enabled" value="<?php echo esc_attr($data['metas']['af_account_page_menu_enabled']);?>" id="af_account_page_menu_enabled" />
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>


	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Add new Tab', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-6">
				   		<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Slug', 'openaffiliates');?></span>
									<input type="text" name="slug" class="form-control" value="">
				   		</div>
				   		<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Label', 'openaffiliates');?></span>
									<input type="text" name="label" class="form-control" value="">
				   		</div>
							<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Link', 'openaffiliates');?></span>
									<input type="text" name="url" class="form-control" value="" />
							</div>
							<div><?php esc_html_e( 'Optional', 'openaffiliates' );?></div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
				   		<div class="input-group">
							<label><?php esc_html_e('Icon', 'openaffiliates');?></label>
							<div class="af-icon-select-wrapper">
								<div class="af-icon-input">
									<div id="af_shiny_select_af" class="af-shiny-select-html"></div>
								</div>
				   				<div class="af-icon-arrow"><i class="fa-af fa-arrow-af"></i></div>
								<div class="af-clear"></div>
							</div>
						</div>
					</div>
				</div>
			 </div>


			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Reorder Menu Tabs', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-sortable-table-wrapp">
				<table class="wp-list-table widefat fixed tags af-admin-tables" id="af_reorder_menu_items">
					<thead>
						<tr>
							<th class="manage-column"><?php esc_html_e('Slug', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Label', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Icon', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Link', 'openaffiliates');?></th>
							<th class="manage-column af-table-small-col"><?php esc_html_e('Delete', 'openaffiliates');?></th>
						</tr>
					</thead>
					<tbody>
						<?php $k = 0;?>
						<?php $data['menu'] = af_reorder_menu_items($data['metas']['af_account_page_menu_order'], $data['menu']);?>
						<?php foreach ($data['menu'] as $slug=>$item):?>
							<?php $value = isset($data['metas']['af_account_page_menu_order'][$slug]) ? $data['metas']['af_account_page_menu_order'][$slug] : $k;?>
							<tr class="<?php echo ($k%2==0) ? 'alternate' : '';?>" id="tr_<?php echo esc_attr($slug);?>">
								<td class="af-slug-col"><input type="hidden" value="<?php echo esc_attr($value);?>" name="af_account_page_menu_order[<?php echo esc_attr($slug);?>]" class="af_account_page_menu_order" />
								<?php echo esc_html($slug);?></td>
								<td class="af-label-col"><?php
									if (isset($item['af_tab_' . $slug . '_menu_label'])){
										echo esc_html($item['af_tab_' . $slug . '_menu_label']);
									} else {
										echo esc_html($item['label']);
									}
								?></td>
								<td class="af-icon-col">
									<?php if (!empty($item['af_tab_' . $slug . '_icon_code'])):?>
										<i class="<?php echo esc_attr('fa-af fa-' . $slug . '-account-af');?>"></i></td>
									<?php else:?>
										-
									<?php endif;?>
								<td class="af-link-col">
										<?php if ( empty( $item['url'] ) ):?>
												-
										<?php else:?>
												<?php echo esc_url($item['url']);?>
										<?php endif;?>
								</td>
								<td class="af-link-col">
									<?php
										if (isset($data['standard_tabs'][$slug])){
											echo esc_html('-');
										} else {
											?>
											<a href="<?php echo admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=account_page_menu&delete=' . $slug);?>">
											<i class="fa-af af-icon-remove-e"></i></a>
											<?php
										}
									?>
								</td>
							</tr>
							<?php $k++;?>
						<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<th class="manage-column"><?php esc_html_e('Slug', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Label', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Icon', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Link', 'openaffiliates');?></th>
							<th class="manage-column"><?php esc_html_e('Delete', 'openaffiliates');?></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>

<?php
require_once AF_PATH . 'admin/font-awesome_codes.php';
$font_awesome = af_return_font_awesome();
foreach ($font_awesome as $base_class => $code):
	if ( $code === '' )continue;
 $custom_css .= "." . $base_class . ":before{".
	 "content: '\\".$code."';".
 "}";
endforeach;

wp_register_style( 'dummy-handle', false );
wp_enqueue_style( 'dummy-handle' );
wp_add_inline_style( 'dummy-handle', $custom_css );
?>

</div>
