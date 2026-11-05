
<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Ranks PRO Options', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
        	<div class="af-inside-item">
			<div class="row">
				<div class="col-xs-7">
				<h2><?php esc_html_e('Activate/Hold Ranks PRO', 'openaffiliates');?></h2>
				<p><?php esc_html_e('A dynamic way to update Ranks periodically based on affiliate performance for a more interactive workflow. Despite the default Rank achievement process, where an affiliate will keep the rank forever once is assigned, with Ranks Pro module, affiliates may be downgraded if their performances where slowed down.', 'openaffiliates');?></p>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_ranks_pro_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ranks_pro_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_ranks_pro_enabled" value="<?php echo esc_attr($data['metas']['af_ranks_pro_enabled']);?>" id="af_ranks_pro_enabled" />
				</div>
			</div>
    </div>

			<div class="af-inside-item">
			<div class="row">
				<div class="col-xs-8">
				<h4><?php esc_html_e('Achievements Calculation', 'openaffiliates');?></h4>
                <p><?php esc_html_e('Ranks are calculated and assigned 2 times per day via Cron jobs or it can be manually triggered from Affiliates section.', 'openaffiliates');?></p>
                <p><?php esc_html_e('If is set an ','openaffiliates');?> <strong>Unlimited</strong> <?php  esc_html_e(' period affiliates can receive a ', 'openaffiliates');?> <strong><?php esc_html_e('higher rank', 'openaffiliates');?></strong> <?php esc_html_e(' only if the achievements are accomplished. ', 'openaffiliates');?></p>
				 <p><?php esc_html_e('For ', 'openaffiliates');?><strong>Limited</strong> <?php esc_html_e(' calculation time, will be taken in consideration for achievement verification only Referrals from a specific period. Affiliates who did not achieved at least the current rank requirements may receive a ', 'openaffiliates');?>  <strong><?php esc_html_e(' lower rank', 'openaffiliates');?>.</strong></p>
            	</div>
            </div>
            </div>
            <div class="af-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<select name="af_default_achieve_calculation" class="form-control m-bot15" onChange="afHideDivIfValue( this.value, 'unlimited', '#af_achieve_period_div_wrapp');"><?php
				$referral_format = array('unlimited' => 'Unlimited (default)', 'limited'=>'Limited back in Time');
				foreach ($referral_format as $k=>$v){
					$selected = ($data['metas']['af_default_achieve_calculation']==$k) ? 'selected' : '';
					?>
					<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
					<?php
				}
				?></select>

				</div>
			</div>
			</div>

      <div class="af-inside-item">
					<div class="row" id="af_achieve_period_div_wrapp  <?php echo ($data['metas']['af_default_achieve_calculation']=='unlimited') ? "af-display-none" : '';?>" >
						<div class="col-xs-4">
							<div class="input-group">
								<span class="input-group-addon"><?php esc_html_e('Period of :', 'openaffiliates');?></span>
								<input type="number" min="1" id="af_achieve_period" class="form-control" value="<?php echo esc_attr($data['metas']['af_achieve_period']);?>" name="af_achieve_period"/>
								<div class="input-group-addon"> <?php esc_html_e("days", 'openaffiliates');?></div>
							</div>
						</div>
					</div>
			</div>
			<div class="af-inside-item">
				<div class="row">
				<div class="col-xs-7">
				<h4><?php esc_html_e('Reset Ranks', 'openaffiliates');?></h4>
				<p><?php esc_html_e('Reset all affiliates ranks to the Basic one monthly. Choose the desired date of the month', 'openaffiliates');?></p>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_ranks_pro_reset']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_ranks_pro_reset');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_ranks_pro_reset" value="<?php echo esc_attr($data['metas']['af_ranks_pro_reset']);?>" id="af_ranks_pro_reset" />
				</div>
			</div>
			</div>
			<div class="af-inside-item">
			<div class="row">
				<div class="col-xs-4">
				<div class="input-group">
					<span class="input-group-addon"><?php esc_html_e('Reset on day', 'openaffiliates');?></span>
					<input type="number" min="1" max="30" class="form-control" value="<?php echo esc_attr($data['metas']['af_ranks_pro_reset_day']);?>" name="af_ranks_pro_reset_day"/>
					<div class="input-group-addon"> <?php esc_html_e("of every month", 'openaffiliates');?></div>
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
</form>
</div>
