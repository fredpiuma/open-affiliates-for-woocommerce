<div class="af-wrapper">
		<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('PayPerClick Campaign', 'openaffiliates');?></h3>
					<div class="inside">
						<div class="af-form-line">
						<div class="row">
						<div class="col-xs-10">
							<h2><?php esc_html_e('Activate/Hold PayPerClick Campaign', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Affiliates will receive a PPC Referral with flat amount each time a new referred user visit your website.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_pay_per_click_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_pay_per_click_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_pay_per_click_enabled" value="<?php echo esc_attr($data['metas']['af_pay_per_click_enabled']);?>" id="af_pay_per_click_enabled" />
						</div>
						</div>

						<div class="row">
							<div class="col-xs-10">
							<?php if (!empty($data['rank_list'])) :?>
							<h2><?php esc_html_e('PPC Amount For Each Rank', 'openaffiliates');?></h2>
								<p><?php esc_html_e('Set a special PPC amount for each rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5">
							<?php foreach ($data['rank_list'] as $id=>$label) :?>
								<div class="row">
									<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><?php echo esc_html($label);?></span>
									 		<input type="number" class="form-control af-input-number" min="0" step='<?php echo afInputNumerStep();?>'  value="<?php echo esc_attr($data['rank_value_array'][$id]);?>" name="<?php echo esc_attr("pay_per_click_value[$id]");?>" />
									 		<div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
										</div>
									</div>
								</div>
								<?php endforeach;?>
							<?php endif;?>
							</div>
						</div>
						<div class="af-inside-item">
							<div class="row">
								<div class="col-xs-5">
									<h2><?php esc_html_e('Default Referral Status', 'openaffiliates');?></h2>
									<select name="af_pay_per_click_default_referral_sts" class="form-control m-bot15"><?php
										foreach (array(1 => esc_html__('Pending', 'openaffiliates'), 2 => esc_html__('Approved', 'openaffiliates')) as $k=>$v){
											$selected = ($data['metas']['af_pay_per_click_default_referral_sts']==$k) ? 'selected' : '';
											?>
											<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
											<?php
										}
									?></select>
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
</div>
<?php
