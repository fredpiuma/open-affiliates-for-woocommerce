<div class="af-wrapper">
			<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Recurring Referrals', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-form-line">
					<div class="row">
						<div class="col-xs-10">
							<h2><?php esc_html_e('Activate/Hold Recurring Referrals', 'openaffiliates');?></h2>
							<p><?php esc_html_e('You can activate this option to take place in your affiliate system.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_reccuring_referrals_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_reccuring_referrals_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_reccuring_referrals_enable" value="<?php echo esc_attr($data['metas']['af_reccuring_referrals_enable']);?>" id="af_reccuring_referrals_enable" />
						</div>
						</div>
					</div>
						<div class="row">

						<div class="col-xs-10">
						<div class="af-form-line">
						<?php if (!empty($data['rank_list'])) :?>
							<h2><?php esc_html_e('Recurring Amount For Each Rank', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Set a special recurring amount for each rank that will replace the default amount rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>
						</div>
						<div class="af-form-line">
							<table class="af-dashboard-inside-table">
								<tr>
									<th><?php esc_html_e('Rank Name', 'openaffiliates');?></th>
									<th><?php esc_html_e('Default Amount Rank', 'openaffiliates');?></th>
									<th><?php esc_html_e('Recurring Amount', 'openaffiliates');?></th>
								</tr>
							<?php foreach ($data['rank_list'] as $id=>$label) :?>
								<tr>
									<td><?php echo esc_html($label);?></td>

									<td>
											<?php if ( isset( $data['default_rank_amount_value_array'][$id] ) && isset( $data['amount_types'][$data['default_rank_amount_type_array'][$id]] ) ):?>
													<?php echo esc_af_content($data['default_rank_amount_value_array'][$id] . ' ' . $data['amount_types'][$data['default_rank_amount_type_array'][$id]]);?></td>
											<?php endif;?>
									<td>
										<?php $value = ($data['rank_amount_value_array'][$id]>-1) ? $data['rank_amount_value_array'][$id] : '';?>
										<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="af-input-number" value="<?php echo esc_attr($value);?>" name="<?php echo esc_attr("reccuring_ranks_value[$id]");?>" />
										<select name="<?php echo esc_attr("reccuring_ranks_amount_type[$id]");?>"><?php
											foreach ($data['amount_types'] as $k=>$v):
												$selected = ($data['rank_amount_type_array'][$id]==$k) ? 'selected' : '';
												?>
												<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
												<?php
											endforeach;
										?></select>
									</td>
								</tr>
							<?php endforeach;?>
						</table>
					</div>
						<?php endif;?>
						</div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</form>
		</div>
