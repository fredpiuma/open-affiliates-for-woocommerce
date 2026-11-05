<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

 	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('WordPress Roles Management', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line af-no-border">
						<h2><?php esc_html_e('Enable access for specific WordPress Roles', 'openaffiliates');?></h2>
						<p><?php esc_html_e('By Default Only Administrator WP Role will have access into WordPress Dashboard. All other logged users will be kept on FrontEnd Side. You can enable access to certain Users by on their WP Role using below On/Off buttons', 'openaffiliates');?></p>
						<p><?php esc_html_e('Warning: This option will manage access to WordPress Dashboard only. Open Affiliates Dashboard will continue to be accessible ONLY by users with Administrator WP Role', 'openaffiliates');?></p>
					</div>
			<div class="af-half-block">
				<div class="af-form-line af-access-opacity">
					<span class="af-access-label"><?php esc_html_e('Administrator', 'openaffiliates');?></span>
					<label class="af_label_shiwtch af-access-switch">
						<input type="checkbox" class="af-switch" checked disabled/>
						<div class="switch af-inline-block"></div>
					</label>
				</div>
				<?php
					$roles = get_editable_roles();
					if (!empty($roles['administrator'])){
						unset($roles['administrator']);
					}
					if (!empty($roles['pending_user'])){
						unset($roles['pending_user']);
					}
					$count = count($roles) + 1;
					$break = ceil($count/2);
					$i = 1;
					foreach ($roles as $role=>$arr){
					?>
						<div class="af-form-line">
							<span class="af-access-label"><?php echo esc_html($arr['name']);?></span>
							<label class="af_label_shiwtch af-access-switch">
								<?php $checked = (in_array($role, $meta_values)) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afMakeInputhString(this, '<?php echo esc_attr($role);?>', '#af_dashboard_allowed_roles');" <?php echo esc_attr($checked);?>/>
								<div class="switch af-inline-block"></div>
							</label>
						</div>
					<?php
					$i++;
						if ($count>7 && $i==$break){
						?>
						</div>
						<div class="af-half-block">
						<?php
						}
					}///end of foreach
				?>
			</div>
			<input type="hidden" name="af_dashboard_allowed_roles" id="af_dashboard_allowed_roles" value="<?php echo esc_attr($meta_value);?>" />
			<div id="af_save_changes" class="af-wrapp-submit-bttn iump-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>

</form>
