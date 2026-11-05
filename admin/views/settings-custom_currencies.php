<div class="af-wrapper">
			<form  method="post">

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Add new Currency', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-inside-item">
							<div class="row">
								<div class="col-xs-5">
									<div class="input-group">
										<label class="input-group-addon"><?php esc_html_e('Code', 'openaffiliates');?></label>
										<input type="text" class="form-control" name="new_currency_code" value="">
									</div>
									<p><?php esc_html_e('Insert a valid Currency Code, ex: ', 'openaffiliates');?><span><strong><?php esc_html_e('USD, EUR, CAD.', 'openaffiliates');?></strong></span></p>
								</div>
							</div>
						</div>
						<div class="af-inside-item">
							<div class="row">
								<div class="col-xs-5">
									<div class="input-group">
										<label class="input-group-addon"><?php esc_html_e('Name', 'openaffiliates');?></label>
										<input type="text" class="form-control" name="new_currency_name" value="">
									</div>
								</div>
							</div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="af_save" class="button button-primary button-large" />
						</div>
					</div>
				</div>

				<?php if ($currencies!==FALSE && count($currencies)>0): ?>
					<div>
						<table class="wp-list-table widefat fixed tags">
							<thead>
								<tr>
									<th class="manage-column"><?php esc_html_e('Code', 'openaffiliates');?></th>
									<th class="manage-column"><?php esc_html_e('Name', 'openaffiliates');?></th>
									<th class="manage-column af-text-align-center"><?php esc_html_e('Action', 'openaffiliates');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($currencies as $code=>$name):?>
									<tr id="af_div_<?php echo esc_attr($code);?>">
										<td><?php echo esc_html($code);?></td>
										<td><?php echo esc_html($name);?></td>
										<td class="af-text-align-center"><i class="fa-af af-icon-remove-e" onClick="afRemoveCurrency('<?php echo esc_html($code);?>');"></i></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				<?php endif;?>
			</form>
</div>
