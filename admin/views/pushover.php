<div class="af-wrapper">
	<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Pushover Notifications', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">

<?php af_external_service_notice( 'the text of each notification', 'Pushover (api.pushover.net)' );?>
			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold Pushover Notifications', 'openaffiliates');?></h2>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_pushover_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_pushover_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_pushover_enabled" value="<?php echo esc_attr($data['metas']['af_pushover_enabled']);?>" id="af_pushover_enabled" />
			</div>
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('App Token', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="af_pushover_app_token" value="<?php echo esc_attr($data['metas']['af_pushover_app_token']);?>" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Admin Personal User Token', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="af_pushover_admin_token" value="<?php echo esc_attr($data['metas']['af_pushover_admin_token']);?>" />
						</div>
						<div>
							<?php esc_html_e("Use this to get 'Admin Notifications' on your own device.", 'openaffiliates');?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('URL', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="af_pushover_url" value="<?php echo esc_url($data['metas']['af_pushover_url']);?>" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('URL Title', 'openaffiliates');?></span>
							<input type="text" class="af-field-text-with-padding form-control" name="af_pushover_url_title" value="<?php echo esc_attr($data['metas']['af_pushover_url_title']);?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="af-form-line">
				<div class="row">
					<div>
						<ul class="af-info-list">
							<li><?php echo esc_html__("1. Go to ", 'openaffiliates') . '<a href="https://pushover.net/" target="_blank">https://pushover.net/</a>' . esc_html__(" login with your credentials or sign up for a new account.", 'openaffiliates');?></li>
							<li><?php echo esc_html__("2. After that go to ", 'openaffiliates') . '<a href="https://pushover.net/apps/build" target="_blank">https://pushover.net/apps/build</a>' .  esc_html__(" and create new App.", 'openaffiliates');?></li>
							<li><?php esc_html_e("3. Set the type of App at 'Application'.", 'openaffiliates');?></li>
							<li><?php esc_html_e("4. Copy and paste API Token/Key.", 'openaffiliates');?></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="af_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Notification Sound', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h4><?php esc_html_e('Default Sound for mobile notification', 'openaffiliates');?></h4>
				<select name="af_pushover_sound">
					<?php
						$possible = array(
											'bike' => esc_html__('Bike', 'openaffiliates'),
											'bugle' => esc_html__('Bugle', 'openaffiliates'),
											'cash_register' => esc_html__('Cash Register', 'openaffiliates'),
											'classical' => esc_html__('Classical', 'openaffiliates'),
											'cosmic' => esc_html__('Cosmic', 'openaffiliates'),
											'falling' => esc_html__('Falling', 'openaffiliates'),
											'gamelan' => esc_html__('Gamelan', 'openaffiliates'),
											'incoming' => esc_html__('Incoming', 'openaffiliates'),
											'intermission' => esc_html__('Intermission', 'openaffiliates'),
											'magic' => esc_html__('Magic', 'openaffiliates'),
											'mechanical' => esc_html__('Mechanical', 'openaffiliates'),
											'piano_bar' => esc_html__('Piano Bar', 'openaffiliates'),
											'siren' => esc_html__('Siren', 'openaffiliates'),
											'space_alarm' => esc_html__('Space Alarm', 'openaffiliates'),
											'tug_boat' => esc_html__('Tug Boat', 'openaffiliates'),
						);
					?>
					<?php foreach ($possible as $k=>$v):?>
						<?php $selected = ($data['metas']['af_pushover_sound']==$k) ? 'selected' : '';?>
						<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
					<?php endforeach;?>
 				</select>
			</div>
			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="af_save" class="button button-primary button-large" />
			</div>
		</div>
	</div>

</form>
</div>
