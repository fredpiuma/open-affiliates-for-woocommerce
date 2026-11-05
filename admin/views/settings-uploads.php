<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Uploads Settings', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h2><?php esc_html_e("Accepted Files Extensions", 'openaffiliates');?></h2>
				<p><?php esc_html_e('When Upload File field is required into Registration/Profile form you may restrict the extensions of files that may be uploaded', 'openaffiliates');?></p>

					<div class="row">
						<div class="col-xs-8">
					<textarea name="af_upload_extensions" class="af-custom-css-box"><?php echo esc_af_content($data['metas']['af_upload_extensions']);?></textarea>
					<div><?php esc_html_e("Write the extensions with comma between values! ex: pdf,jpg,mp3", 'openaffiliates');?></div>
				</div>
			</div>
			</div>

			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e("Upload File Maximum File Size", 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<div class="input-group">
							<input type="number" class="form-control" value="<?php echo esc_attr($data['metas']['af_upload_max_size']);?>" name="af_upload_max_size" min="0.1" step="0.1" />
							<div class="input-group-addon">MB</div>
						</div>
					</span>
					<p class="af-form-setting-description"></p>
				</div>
			</div>
			<div class="af-form-line">
				<div class="af-form-setting-wrapper">
					<label class="af-form-setting-label"><?php esc_html_e("Avatar Maximum File Size", 'openaffiliates');?></label>
					<span class="af-form-setting-item">
						<div class="input-group">
						 <input type="number" class="form-control" value="<?php echo esc_attr($data['metas']['af_avatar_max_size']);?>" name="af_avatar_max_size" min="0.1" step="0.1" />
						 <div class="input-group-addon">MB</div>
					 </div>
					</span>
					<p class="af-form-setting-description"></p>
				</div>
			</div>


			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>
</div>
