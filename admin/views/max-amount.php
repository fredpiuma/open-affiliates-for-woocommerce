<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Maximum Amount Rate', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
		<div class="row">
		  <div class="col-xs-5">
			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold Maximum Amount Rate', 'openaffiliates');?></h2>
				<p><?php esc_html_e('Set a maximum amount that can not be passed for a referral. It is a safety limit decided by the Admin for avoiding big referrals that have to be paid.', 'openaffiliates'); ?></p>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_maximum_amount_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_maximum_amount_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_maximum_amount_enabled" value="<?php echo esc_attr($data['metas']['af_maximum_amount_enabled']);?>" id="af_maximum_amount_enabled" />
			</div>
		 </div>
		</div>


			<div class="af-inside-item">
				<div class="af-form-line">
				<div class="row">
					<div class="col-xs-5">
						<h4><?php esc_html_e('Default Amount Limit', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Set the default flat amount limit that will be used when no special limit is set for a certain rank.', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Max Amount Limit', 'openaffiliates');?></span>
							<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="af-field-text-with-padding form-control" name="af_maximum_amount_value" value="<?php echo esc_attr($data['metas']['af_maximum_amount_value']);?>" />
							<div class="input-group-addon"><?php echo esc_af_content($data['amount_types']['flat']);?></div>
						</div>
					</div>
				</div>
			</div>
			</div>

			<?php if (!empty($data['ranks'])):?>
				<div class="af-inside-item">
					<div class="af-form-line">
				<div class="row">
					<div class="col-xs-4">
						<h4><?php esc_html_e('Max Amount Limit for Each Rank', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Set a special max amount limit for each rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>

				<?php foreach ($data['ranks'] as $rank_data):?>
								<div class="input-group">
									<span class="input-group-addon"><?php echo esc_af_content($rank_data->label);?></span>
									<input type="number" min="0" step='<?php echo afInputNumerStep();?>'
										class="af-field-text-with-padding form-control" name="af_maximum_amount_value_per_rank[<?php echo isset( $rank_data->id ) ? $rank_data->id : '';?>]"
										value="<?php echo isset( $data['metas']['af_maximum_amount_value_per_rank'][$rank_data->id] ) ? $data['metas']['af_maximum_amount_value_per_rank'][$rank_data->id] : '';?>" />
									<div class="input-group-addon"><?php echo isset($data['amount_types']['flat']) ? $data['amount_types']['flat'] : '';?></div>
								</div>
								<div class="af-space"></div>
				<?php endforeach;?>

					</div>
				</div>
			</div>
			</div>
			<?php endif;?>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>
</div>
