
<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Affiliate Landing Pages', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
        	<div class="af-inside-item">
			<div class="row">
				<div class="col-xs-7">
				<h2><?php esc_html_e('Activate/Hold Landing Pages', 'openaffiliates');?></h2>
				<p><?php esc_html_e('An affiliate can be linked with a specific page from your website. Users will no longer avoid links that could benefit a certain affiliate because no affiliate link will be required on this case.', 'openaffiliates');?></p>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_landing_pages_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_landing_pages_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_landing_pages_enabled" value="<?php echo esc_attr($data['metas']['af_landing_pages_enabled']);?>" id="af_landing_pages_enabled" />
				</div>
			</div>
            </div>
			<div class="af-line-break"></div>

			<div class="af-inside-item">
				<div class="row">
					<div class="col-xs-8">
						<h2><?php esc_html_e('How it Works', 'openaffiliates');?></h2>
						<p><?php esc_html_e('Once this Module is enabled, you will find on your editing page/post section an additional MetaBox dedicated for this purpose. There you can search for a specific ', 'openaffiliates');?> <strong><?php esc_html_e(' Affiliate user ', 'openaffiliates');?></strong> <?php esc_html_e(' and assiging him with current page.', 'openaffiliates');?></p>

					</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
		</div>
	</div>

</form>


<?php if (!empty($data['items'])):?>
	<div class="af-stuffbox">
			<h3 class="af-h3"><?php esc_html_e('Associated Landing pages with Affiliates', 'openaffiliates');?></h3>
			<div class="inside">


	<table class="wp-list-table widefat fixed tags af-admin-tables">
		<thead>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Landing Page', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
				<th><?php esc_html_e('Landing Page', 'openaffiliates');?></th>
				<th><?php esc_html_e('Action', 'openaffiliates');?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php $i = 1;
				foreach ($data['items'] as $item):?>
			<tr class="<?php echo ($i%2==0) ? 'alternate' : '';?>">
				<td >
					<?php echo esc_html($item->user_login);?>
				</td>
				<?php $link = get_permalink( $item->ID );?>
				<td><a href="<?php echo esc_url($link);?>" target="_blank"><?php echo esc_html($item->post_title) . " ( " . esc_url($link) . " )";?></a></td>
				<td>
					<a href="<?php echo admin_url('admin.php?page=openaffiliates&tab=magic_features&subtab=landing_pages&delete=' . $item->post_meta_id);?>"  class="af-color-red"><?php esc_html_e('Delete', 'openaffiliates');?></a>
				</td>
			</tr>
			<?php $i++;
			endforeach;?>
		</tbody>
	</table>
	<?php if (!empty($data['pagination'])):?>
		<?php echo esc_af_content($data['pagination']);?>
	<?php endif;?>
</div>
</div>
<?php endif;?>



</div>
