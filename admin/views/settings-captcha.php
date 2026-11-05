<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('ReCaptcha Setup', 'openaffiliates');?></h3>
		<div class="inside">
<?php af_external_service_notice( "the reCAPTCHA response token and the visitor's IP address (the visitor's browser also loads Google's reCAPTCHA script)", 'Google reCAPTCHA (www.google.com/recaptcha)' );?>
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-8">
				<h4><?php esc_html_e( 'Recaptcha Integration', 'openaffiliates' );?></h4>
				<select name="af_recaptcha_version" class="js-af-change-recaptcha-version form-control" >
							<?php
									if ( empty( $data['metas']['af_recaptcha_version'] ) ){
											$data['metas']['af_recaptcha_version'] = 'v2';
									}
							?>
							<option value="v2" <?php echo ( $data['metas']['af_recaptcha_version'] == 'v2' ) ? 'selected' : '';?> ><?php esc_html_e( 'reCAPTCHA v2', 'openaffiliates');?></option>
							<option value="v3" <?php echo ( $data['metas']['af_recaptcha_version'] == 'v3' ) ? 'selected' : '';?> ><?php esc_html_e( 'reCAPTCHA v3', 'openaffiliates');?></option>
				</select>
					</div>
				</div>
			</div>
			<div class="js-af-recaptcha-v2-wrapp <?php echo ( $data['metas']['af_recaptcha_version'] == 'v3' ) ? 'af-display-none' : '';?>" >

			<div class="af-form-line">
				<h4><?php esc_html_e( 'reCAPTCHA V2', 'openaffiliates');?></h4>
				<div class="row">
					<div class="col-xs-8">
            	<div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('SITE KEY:', 'openaffiliates');?></span>
                <input type="text" name="af_recaptcha_public" value="<?php echo esc_attr($data['metas']['af_recaptcha_public']);?>" class="form-control af-deashboard-middle-text-input" />
               </div>
				 		</div>
				 	</div>
				 	<div class="row">
				 		<div class="col-xs-8">
				<div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('SECRET KEY:', 'openaffiliates');?></span>
                <input type="text" name="af_recaptcha_private" value="<?php echo esc_attr($data['metas']['af_recaptcha_private']);?>" class="form-control af-deashboard-middle-text-input" />
                </div>
				</div>
			</div>
		</div>
		<div class="af-form-line">
											<p><strong><?php esc_html_e('How to setup', 'openaffiliates');?></strong></p>
                                            <p>	<?php esc_html_e('1. Get Public and Private Keys from', 'openaffiliates');?> <a href="https://www.google.com/recaptcha/admin#list" target="_blank"><?php esc_html_e('here', 'openaffiliates');?></a>.</p>
                                            <p>	<?php esc_html_e('2. Click on "Create" button.', 'openaffiliates');?></p>
                                            <p>	<?php esc_html_e('3. Choose "reCAPTCHA v2" with "Im not a robot" Checkbox.', 'openaffiliates');?></p>
                                            <p>	<?php esc_html_e('4. Add curent WP website main domain', 'openaffiliates');?></p>
                                            <p> <?php esc_html_e('5. Accept terms and conditions and Submit', 'openaffiliates');?></p>
		</div>
	 </div>

            <div class="js-af-recaptcha-v3-wrapp <?php echo ( $data['metas']['af_recaptcha_version'] == 'v2' ) ? 'af-display-none' : '';?>" >



			<div class="af-form-line">
				            <h4><?php esc_html_e( 'reCAPTCHA V3', 'openaffiliates');?></h4>
				<div class="row">
					<div class="col-xs-6">
            <div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('SITE KEY:', 'openaffiliates');?></span>
                <input type="text" name="af_recaptcha_public_v3" value="<?php echo esc_attr($data['metas']['af_recaptcha_public_v3']);?>" class="form-control af-deashboard-middle-text-input" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('SECRET KEY:', 'openaffiliates');?></span>
                <input type="text" name="af_recaptcha_private_v3" value="<?php echo esc_attr($data['metas']['af_recaptcha_private_v3']);?>" class="form-control af-deashboard-middle-text-input" />
			</div>
		</div>
	</div>
		</div>
		<div class="af-form-line">
                                        	<p><strong><?php esc_html_e('How to setup', 'openaffiliates');?></strong></p>
											<p> <?php esc_html_e('1. Get Public and Private Keys from', 'openaffiliates');?> <a href="https://www.google.com/recaptcha/admin#list" target="_blank"><?php esc_html_e('here', 'openaffiliates');?></a>.</p>
                                            <p>	<?php esc_html_e('2. Click on "Create" button.', 'openaffiliates');?></p>
                                            <p>	<?php esc_html_e('3. Choose "reCAPTCHA v3".', 'openaffiliates');?></p>
                                            <p>	<?php esc_html_e('4. Add curent WP website main domain', 'openaffiliates');?></p>
                                            <p> <?php esc_html_e('5. Accept terms and conditions and Submit', 'openaffiliates');?></p>
		</div>
  </div>
			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" onClick="" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>

</div>
