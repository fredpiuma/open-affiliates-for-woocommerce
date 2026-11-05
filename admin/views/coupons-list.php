
<?php if ( isset($data['errors']) ) :?>
		<div class="af-error-message"><?php echo esc_html($data['errors']);?></div>
<?php endif;?>
<div class="af-wrapper">
			<form  method="post" id="form_coupons">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Static Coupons', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-form-line">
						<div class="row">
							<div class="col-xs-7">
								<h2><?php esc_html_e('Activate/Hold Static Coupons option for your Affiliates', 'openaffiliates');?></h2>
								<p><?php esc_html_e('You can activate this option to take place in your affiliate system.', 'openaffiliates');?></p>
								<label class="af_label_shiwtch af-switch-button-margin">
									<?php $checked = ($data['metas']['af_coupons_enable']) ? 'checked' : '';?>
									<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_coupons_enable');" <?php echo esc_attr($checked);?> />
									<div class="switch af-display-inline"></div>
								</label>
								<input type="hidden" name="af_coupons_enable" value="<?php echo esc_attr($data['metas']['af_coupons_enable']);?>" id="af_coupons_enable" />
							</div>
						</div>
						<input type="hidden" name="delete_coupons" value="" id="delete_coupons" />
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="af_save" class="button button-primary button-large" />
						</div>
					</div>
					</div>
				</div>
			</form>
</div>
<div class="af-wrapper">

	<a href="<?php echo esc_url($data['url-add_edit'] . '&add_edit=0');?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><span><?php esc_html_e('Add new Coupon', 'openaffiliates');?></span></a>


	<?php if (!empty($data['listing_items'])):?>
		<table class="wp-list-table widefat fixed tags af-admin-tables af-coupons-table">
			<thead>
				<tr>
					<th><?php esc_html_e('Coupon', 'openaffiliates');?></th>
					<th><?php esc_html_e('Source', 'openaffiliates');?></th>
					<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
					<th><?php esc_html_e('Status', 'openaffiliates');?></th>
				</tr>
			</thead>
			<tbody>
		<?php $i = 0; foreach ($data['listing_items'] as $k=>$array):?>
			<tr onmouseover="afDhSelector('#aff_<?php echo esc_attr($array['id']);?>', 1);" onmouseout="afDhSelector('#aff_<?php echo esc_attr($array['id']);?>', 0);" class="<?php echo ($i%2==0) ? 'alternate' : '';?>">
				<th><?php
					echo esc_html($array['code']);?>
					<div id="<?php echo esc_attr( 'aff_' . $array['id']);?>"  class="af-visibility-hidden">
						<a href="<?php echo esc_url($data['url-add_edit'] . '&add_edit=' . $array['code']);?>"><?php esc_html_e('Edit', 'openaffiliates');?></a> | <a onclick="afDeleteFromTable(<?php echo esc_attr($array['id']);?>, 'Coupon', '#delete_coupons', '#form_coupons');" href="javascript:return false;"  class="af-color-red"><?php esc_html_e('Delete', 'openaffiliates');?></a>
					</div>
				</th>
				<th><?php echo esc_html($array['type']);?></th>
				<th><?php echo esc_html($af_db->get_wp_username_by_affiliate_id($array['affiliate_id']));?></th>
				<th><?php if ($array['status']){
					 esc_html_e('Enabled');
				}
				else esc_html_e('Disabled');?></th>
			</tr>
		<?php $i++; endforeach;?>
	</tbody>

	<tfoot>
		<tr>
			<th><?php esc_html_e('Coupon', 'openaffiliates');?></th>
			<th><?php esc_html_e('Source', 'openaffiliates');?></th>
			<th><?php esc_html_e('Affiliate', 'openaffiliates');?></th>
			<th><?php esc_html_e('Status', 'openaffiliates');?></th>
		</tr>
	</tfoot>
		</table>
	<?php endif;?>
</div>
<?php
