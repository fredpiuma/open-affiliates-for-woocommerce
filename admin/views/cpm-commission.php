<div class="af-wrapper">
		<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Cost Per Mile(CPM) Campaign', 'openaffiliates');?></h3>
					<div class="inside">
						<div class="af-form-line">
						<div class="row">
						<div class="col-xs-12">
							<h2><?php esc_html_e('Activate/Hold CPM Campaign', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Affiliates will receive a CPM Referral with flat amount rewarded for 1000 impressions (displaying your banners 1000 times).', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_cpm_commission_enabled']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_cpm_commission_enabled');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_cpm_commission_enabled" value="<?php echo esc_attr($data['metas']['af_cpm_commission_enabled']);?>" id="af_cpm_commission_enabled" />
                            <br/> <br/>
                            <p><?php esc_html_e('Once this module will be enabled Creatives (banners) listed on Affiliate Portal will have an additional code inside which will allow to track the Impressions. Affiliates will have to update their promotional banner codes to get this feature.', 'openaffiliates');?></p>

                        <p><strong><?php esc_html_e('Important: this feature may drain into your server over average traffic. Be sure that your Server Performance is good enough related to your number of affiliates otherwise disable the module to be avoided an overloading issue.', 'openaffiliates');?></strong></p>
						</div>

						</div>

						<div class="row">
							<div class="col-xs-10">
							<?php if (!empty($data['rank_list'])) :?>
							<h2><?php esc_html_e('CPM Amount For Each Rank', 'openaffiliates');?></h2>
								<p><?php esc_html_e('Set a special CPM amount for each rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5">
							<?php foreach ($data['rank_list'] as $id=>$label) :?>
								<div class="row">
									<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><?php echo esc_html($label);?></span>
									 		<input type="number" class="form-control af-input-number" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['rank_value_array'][$id]);?>" name="<?php echo esc_af_content("cpm_commission_value[$id]");?>" />
									 		<div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
										</div>
									</div>
								</div>
								<?php endforeach;?>
							<?php endif;?>
							</div>
						</div>

						<div class="af-line-break"></div>

						<div class="af-inside-item">
							<div class="row">
								<div class="col-xs-5">
									<h2><?php esc_html_e('Default Referral Status', 'openaffiliates');?></h2>
									<select name="af_cpm_commission_default_referral_sts" class="form-control m-bot15"><?php
										foreach (array(1 => esc_html__('Pending', 'openaffiliates'), 2 => esc_html__('Approved', 'openaffiliates')) as $k=>$v){
											$selected = ($data['metas']['af_cpm_commission_default_referral_sts']==$k) ? 'selected' : '';
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
