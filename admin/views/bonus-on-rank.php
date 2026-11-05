<div class="af-wrapper">
			<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Ranks Bonus', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-form-line">
						<div class="row">
						<div class="col-xs-10">
							<h2><?php esc_html_e('Activate/Hold Ranks Bonus', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Affiliates will receive a bonus flat amount each time they will reach a specific rank.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_bonus_on_rank_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_bonus_on_rank_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_bonus_on_rank_enable" value="<?php echo esc_attr($data['metas']['af_bonus_on_rank_enable']);?>" id="af_bonus_on_rank_enable" />
						</div>
						</div>
						<div class="row">
							<div class="col-xs-10">
							<?php if (!empty($data['rank_list'])) :?>
							<h4><?php esc_html_e('Amount For Each Rank', 'openaffiliates');?></h4>
								<p><?php esc_html_e('Set a special bonus amount for each rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>
							</div>
							</div>
							<div class="row">
								<div class="col-xs-5">
							<?php foreach ($data['rank_list'] as $id=>$label) :?>
								<div class="row">
									<div class="col-xs-12">
									<div class="input-group">
										<span class="input-group-addon"><?php echo esc_html($label);?></span>
									 		<input type="number" class="form-control af-input-number" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['rank_value_array'][$id]);?>" name="<?php echo esc_attr("bonus_ranks_value[$id]");?>" />
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
									<h4><?php esc_html_e('Default Referral Status', 'openaffiliates');?></h4>
									<select name="af_bonus_on_rank_default_referral_sts" class="form-control m-bot15"><?php
										foreach (array(1 => esc_html__('Pending', 'openaffiliates'), 2 => esc_html__('Approved', 'openaffiliates')) as $k=>$v){
											$selected = ($data['metas']['af_bonus_on_rank_default_referral_sts']==$k) ? 'selected' : '';
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
