
<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Direct Link Tracking', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-7">
				<h2><?php esc_html_e('Activate/Hold Direct Link Tracking', 'openaffiliates');?></h2>
				<p><?php esc_html_e("An affiliate's name can now be masked by creating custom links. Users will no longer avoid links that could benefit a certain affiliate.", 'openaffiliates');?></p>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_simple_links_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_simple_links_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_simple_links_enabled" value="<?php echo esc_attr($data['metas']['af_simple_links_enabled']);?>" id="af_simple_links_enabled" />
				</div>
			</div>


			<div class="af-inside-item">
				<div class="row">
					<div class="col-xs-4">
						<h4><?php esc_html_e('Referrer Links Limit', 'openaffiliates');?></h4>
						<p><?php esc_html_e('The number of links that can be submitted by an affiliate in his Affiliate Portal', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Links Limit per Affiliate', 'openaffiliates');?></span>
							<input type="number" min="0" step="1" class="af-field-text-with-padding form-control" name="af_simple_links_limit" value="<?php echo esc_attr($data['metas']['af_simple_links_limit']);?>" />
						</div>
					</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Add New Referrer Link', 'openaffiliates');?></h3>
		<div class="inside">
				<div class="row">
					<div class="col-xs-5">
					<p><?php esc_html_e('Attach a referrer link to a specific affiliate user directly from the "Open Affiliates Dashboard".', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Affiliate', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="affiliate_name" id="affiliate_name"/>
							<input type="hidden" class="af-field-text-with-padding form-control" name="affiliate_id" id="affiliate_id"/>
						</div>
					</div>
				</div>
						<div class="row">
							<div class="col-xs-5">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Referrer Link', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="url" />
						</div>
					</div>
				</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>

</form>


<?php if (!empty($data['items'])):?>
	<div class="af-stuffbox">
			<h3 class="af-h3"><?php esc_html_e('Search Links for Affiliate', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="row">
					<div class="col-xs-5">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Affiliate Username', 'openaffiliates');?></span>
						<input type="text" class="af-field-text-with-padding form-control" id="affiliate_name_search" />
						<input type="hidden" id="search_aff_id" name="search_aff_id" />
						</div>
					</div>
				</div>

					<div class="row">
						<div class="col-xs-5">
						<span class="button button-primary button-large" onClick="afDoRedirect('<?php echo admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=simple_links');?>', 'affiliate_id', '#search_aff_id');"><?php esc_html_e('Search', 'openaffiliates');?></span>

					</div>
				</div>
			</div>
		</div>

<div class="af-stuffbox">

	<table class="wp-list-table widefat fixed tags af-admin-tables">
		<thead>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Referrer Link', 'openaffiliates');?></th>
				<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1;
				foreach ($data['items'] as $item):?>
			<tr class="<?php  echo ($i%2==0) ? 'alternate' : '';?>">
				<td class="af-list-affiliates-name-label"><?php echo esc_html($item['username']);?></td>
				<td><a href="<?php echo esc_url($item['url']);?>" target="_blank"><?php echo esc_url($item['url']);?></a></td>
				<td>
					<?php if ($item['status']):?>
						<div class="af-subcr-type-list "><?php esc_html_e('Active', 'openaffiliates');?></div>
					<?php else:?>
						<div class="af-subcr-type-list af-pending"><?php esc_html_e('Pending', 'openaffiliates');?></div>
					<?php endif;?>
				</td>
				<td>
					<?php if (!$item['status']):?>
						<a href="<?php echo admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=simple_links&approve=' . $item['id']);?>"><?php esc_html_e('Approve', 'openaffiliates');?></a> |
					<?php endif;?>
					<a href="<?php echo admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=simple_links&delete=' . $item['id']);?>" class="af-color-red"><?php esc_html_e('Delete', 'openaffiliates');?></a>
				</td>
			</tr>
			<?php $i++;
			endforeach;?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Referrer Link', 'openaffiliates');?></th>
				<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</tfoot>
	</table>
	<?php if (!empty($data['pagination'])):?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
<?php endif;?>


</div>
