<div class="af-js-custom-aff-base-url" data-value="<?php echo esc_attr($url);?>"></div>
<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Custom Affiliate Slug', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
					<h2><?php esc_html_e('Activate/Hold Custom Affiliate Slug', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Provides personal slugs besides the default username or ID so affiliates can hide their identity or company name behind a custom slug.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($data['metas']['af_custom_affiliate_slug_on']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_custom_affiliate_slug_on');" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_custom_affiliate_slug_on" value="<?php echo esc_attr($data['metas']['af_custom_affiliate_slug_on']);?>" id="af_custom_affiliate_slug_on" />
				</div>
			</div>
		</div>
		<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
					<p><?php esc_html_e('Establish conditional requirements when affiliates want to set their personal custom slug. Hint: The custom slug is unique and future users may not register it as their username or custom slug.', 'openaffiliates');?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="input-group">
						<label class="input-group-addon"><?php esc_html_e('Minimum number of characters', 'openaffiliates');?></label>
						<input type="number" class="form-control" value="<?php echo esc_attr($data['metas']['af_custom_affiliate_slug_min_ch']);?>" min="3" name="af_custom_affiliate_slug_min_ch" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="input-group">
						<label class="input-group-addon"><?php esc_html_e('Maximum number of characters', 'openaffiliates');?></label>
						<input type="number" class="form-control" value="<?php echo esc_attr($data['metas']['af_custom_affiliate_slug_max_ch']);?>" min="3" name="af_custom_affiliate_slug_max_ch" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div class="input-group">
						<label class="input-group-addon"><?php esc_html_e('Slug characters rule', 'openaffiliates');?></label>
						<select name="af_custom_affiliate_slug_rule">
							<?php foreach (array(0=> esc_html__('Standard', 'openaffiliates'), 1=> esc_html__('Characters and digits'), 2=> esc_html__('Characters, digits, minimum one uppercase letter', 'openaffiliates')) as $k=>$v):?>
								<?php $selected = ($k==$data['metas']['af_custom_affiliate_slug_rule']) ? 'selected' : '';?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
							<?php endforeach;?>
						</select>
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

<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Add/Edit Slug', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="row">
				<div class="col-xs-7">
				<p><?php esc_html_e('You can add or edit a custom slug for a specific affiliate from your side.', 'openaffiliates');?></p>
					<div class="input-group">
						<span class="input-group-addon"><?php esc_html_e('Affiliate', 'openaffiliates');?></span>
						<input type="text"  class="form-control" value=""  id="affiliate_name" />
						<input type="hidden" id="affiliate_id_hidden" name="affiliate_id" value="<?php echo isset( $data['metas']['affiliate_id'] ) ? $data['metas']['affiliate_id'] : '';?>]"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-7">
					<div class="input-group">
						<span class="input-group-addon"><?php esc_html_e('Slug', 'openaffiliates');?></span>
						<input type="text"  class="form-control" value="" name="slug" />
					</div>
				</div>
			</div>
			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save_slug" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>

<?php if ($data['items']):?>
	<div class="af-stuffbox">
		<table class="wp-list-table widefat fixed tags af-admin-tables">
			<thead>
				<tr>
					<th><?php esc_html_e('Username', 'openaffiliates');?></th>
					<th><?php esc_html_e('Slug', 'openaffiliates');?></th>
					<th><?php esc_html_e('Action', 'openaffiliates');?></th>
				</tr>
			</thead>
			<tbody>
				<?php  $i = 1;
				foreach ($data['items'] as $item):?>
					<tr class="<?php echo ($i%2==0) ? 'alternate' : '';?>">
						<td><?php echo esc_html($item['username']);?></td>
						<td><?php echo esc_html($item['meta_value']);?></td>
						<td><i class="fa-af fa-trash-af" onClick="afRemoveSlug(<?php echo esc_attr($item['user_id']);?>);"></i></td>
					</tr>
				<?php $i++;
				endforeach;?>
			</tbody>

			<tfoot>
				<tr>
					<th><?php esc_html_e('Username', 'openaffiliates');?></th>
					<th><?php esc_html_e('Slug', 'openaffiliates');?></th>
					<th><?php esc_html_e('Action', 'openaffiliates');?></th>
				</tr>
			</tfoot>
		</table>
	</div>
<?php endif;?>

<?php if ($data['pagination']):?>
<?php echo esc_af_content($data['pagination']);?>
<?php endif?>


</div>
