<?php
wp_enqueue_script( 'wp-theme-plugin-editor' );
wp_enqueue_style( 'wp-codemirror' );
wp_enqueue_script( 'code-editor' );
wp_enqueue_style( 'code-editor' );
 ?>
		<div class="af-page-title">
			<span class="second-text"><?php esc_html_e('Login Form Showcase', 'openaffiliates');?></span>
		</div>
		<div class="af-wrapper">
			<div class="af-stuffbox">
				<div class="af-shortcode-display">
					[af-login-form]
				</div>
			</div>
			<form method="post" >

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />
				<div class="row">
					<div class="col-xs-12">
					<div class="af-stuffbox">
						<h3 class="af-h3"><?php esc_html_e('Login Form Display', 'openaffiliates');?></h3>
						<div class="inside">
						  <div class="af-register-select-template">
						  <?php esc_html_e('Login Form Template', 'openaffiliates');?>
							<select name="af_login_template" id="af_login_template" onChange="afLoginPreview();">
							<?php
								foreach ($data['login_templates'] as $k=>$value){
									echo esc_af_content('<option value="af-login-template-'.$k.'" '. ($data['metas']['af_login_template']=='af-login-template-'.$k ? 'selected': '') .'>'.$value.'</option>');
								}
							?>
							</select>
						 </div>
						 <div>
							<div id="af-preview-login"></div>
						</div>
							<div id="af_save_changes" class="af-wrapp-submit-bttn">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="af-form-element af-form-element-submit button button-primary button-large" />
							</div>
						</div>
					</div>


				</div>
			   <div class="col-xs-12">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Additional Options', 'openaffiliates');?></h3>
					<div class="inside">
							<div class="af-form-line af-no-border">
								<label class="af-checkbox-wrapp">
									<input type="checkbox" class="af-checkbox" onClick="checkAndH(this, '#af_login_remember_me');afLoginPreview();" <?php echo ($data['metas']['af_login_remember_me']==1) ? 'checked' : '';?>/>
									<input type="hidden" name="af_login_remember_me" value="<?php echo esc_attr($data['metas']['af_login_remember_me']);?>" id="af_login_remember_me"/>
									<span><?php esc_html_e('Display Remember Me Link', 'openaffiliates');?></span>
								<span class="af-checkmark"></span>
							</label>
						</div>
							<div class="af-form-line af-no-border">
								<label class="af-checkbox-wrapp">
									<input type="checkbox" class="af-checkbox" onClick="checkAndH(this, '#af_login_register');afLoginPreview();" <?php echo ($data['metas']['af_login_register']==1) ? 'checked' : '';?>/>
									<input type="hidden" name="af_login_register" value="<?php echo esc_attr($data['metas']['af_login_register']);?>" id="af_login_register"/>
									<span><?php esc_html_e('Display Register Link', 'openaffiliates');?></span>
									<span class="af-checkmark"></span>
								</label>
							</div>
							<div class="af-form-line af-no-border">
								<label class="af-checkbox-wrapp">
									<input type="checkbox" class="af-checkbox" onClick="checkAndH(this, '#af_login_pass_lost');afLoginPreview();" <?php echo ($data['metas']['af_login_pass_lost']==1) ? 'checked' : '';?>/>
									<span><?php esc_html_e('Display Lost your password Link', 'openaffiliates');?></span>
									<input type="hidden" name="af_login_pass_lost" value="<?php echo esc_attr($data['metas']['af_login_pass_lost']);?>" id="af_login_pass_lost"/>
									<span class="af-checkmark"></span>
								</label>
							</div>
							<div class="af-form-line af-no-border">
								<label class="af-checkbox-wrapp">
									<input type="checkbox" class="af-checkbox" onClick="checkAndH(this, '#af_login_show_recaptcha');afLoginPreview();" <?php echo ($data['metas']['af_login_show_recaptcha']==1) ? 'checked' : '';?>/>
									<span><?php esc_html_e('Display ReCaptcha Verification box', 'openaffiliates');?></span>
									<input type="hidden" name="af_login_show_recaptcha" value="<?php echo esc_attr($data['metas']['af_login_show_recaptcha']);?>" id="af_login_show_recaptcha"/>
									<span class="af-checkmark"></span>
								</label>
							</div>
							<div id="af_save_changes" class="af-wrapp-submit-bttn">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="af-form-element af-form-element-submit button button-primary button-large" />
							</div>
						</div>
				  </div>
				  <div class="af-stuffbox af-custom-css-box-wrapper">
						<h3 class="af-h3"><?php esc_html_e('Custom CSS', 'openaffiliates');?></h3>
						<div class="af-form-line">
							<textarea id="af_login_custom_css" name="af_login_custom_css" onBlur="afLoginPreview();" class="af-dashboard-textarea"><?php echo stripslashes($data['metas']['af_login_custom_css']);?></textarea>
							<div id="af_save_changes" class="af-wrapp-submit-bttn">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="af-form-element af-form-element-submit button button-primary button-large" />
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
</div>
