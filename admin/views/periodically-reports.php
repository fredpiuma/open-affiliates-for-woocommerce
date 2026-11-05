<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Periodic Reports', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
					<h2><?php esc_html_e('Activate/Hold Periodic Reports', 'openaffiliates');?></h2>
					<p><?php esc_html_e('If this module is activated, affiliates will receive periodical reports about their affiliate account and rewards. Each affiliate may decide the frequency of these reports (daily, weekly, monthly) from his Affiliate Portal.', 'openaffiliates');?></p>
					<label class="woo_account_page_enable af-switch-button-margin">
					<?php $checked = ($data['metas']['af_periodically_reports_enable']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_periodically_reports_enable');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_periodically_reports_enable" value="<?php echo esc_attr($data['metas']['af_periodically_reports_enable']);?>" id="af_periodically_reports_enable" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
					<h4><?php esc_html_e('Report Subject', 'openaffiliates');?></h4>
					<input type="text" name="af_periodically_reports_subject" value="<?php echo esc_attr($data['metas']['af_periodically_reports_subject']);?>" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<h4><?php esc_html_e('Report Content', 'openaffiliates');?></h4>
					<div class="af-wp_editor af-wp-editor-box">
					<?php wp_editor(stripslashes($data['metas']['af_periodically_reports_content']), 'af_periodically_reports_content', array('textarea_name'=>'af_periodically_reports_content', 'editor_height'=>500));?>
					</div>
					<div class="af-wp-editor-constants">
						<?php echo esc_af_content("<h4>" . esc_html__('Referral Reports Tags', 'openaffiliates') . "</h4>"); ?>
						<?php foreach ($data['reports_constants'] as $key=>$value) : ?>
							<div><?php echo esc_af_content('<span><strong>'.$value . '</strong></span> : ' . $key);?></div>
						<?php endforeach; ?>
						<?php
						echo esc_af_content("<h4>" . esc_html__('Native Fields Tags', 'openaffiliates') . "</h4>");
							$constants = array(	"{username}",
												"{first_name}",
												"{last_name}",
												"{user_id}",
												"{user_email}",
												"{account_page}",
												"{login_page}",
												"{blogname}",
												"{blogurl}",
												"{siteurl}",
												'{rank_id}',
												'{rank_name}',
							);
							$extra_constants = af_get_custom_constant_fields();
							foreach ($constants as $v){
								?>
								<div><?php echo esc_html($v);?></div>
								<?php
							}
							echo esc_af_content("<h4>" . esc_html__('Custom Fields Tags', 'openaffiliates') . "</h4>");
							foreach ($extra_constants as $k=>$v){
								?>
								<div><?php echo esc_html($k);?></div>
								<?php
							}
						?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-8">
					<h4><?php esc_html_e('Send Notification Time', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Decide when it is the best time of day for your website to start managing email reports. The script runs daily on the back-end and checks the report period for each affiliate and how much time has passed since the last report. Based on this new reports are managed automatically by the system.', 'openaffiliates');?></p>
					<select name="af_periodically_reports_cron_hour"><?php
						for ($i=0; $i<24; $i++){
							$selected = ($data['metas']['af_periodically_reports_cron_hour']==$i) ? 'selected' : '';
							?>
							<option value="<?php echo esc_attr($i);?>" <?php echo esc_attr($selected);?> ><?php
								if ($i<10){
									echo 0;
								}
								echo esc_html($i);
							?></option>
							<?php
						}
					?></select>
					<p><strong><?php esc_html_e('Keep in mind that it may be necessary to send a big number of emails and your hosting provider may restrict this action. Be sure that you are able to manage email reports for all of your affiliates.', 'openaffiliates');?></strong></p>
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
