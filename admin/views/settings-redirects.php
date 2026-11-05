<?php
$pages = af_get_all_pages();
//getting pages
?>
<div class="af-wrapper">
			<form  method="post">

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Redirects Setup', 'openaffiliates');?></h3>
					<div class="inside">
						<div class="af-form-line">
							<h2><?php esc_html_e('Default Redirects', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Customize where affiliates are redirected in different scenarios by selecting specific pages for various actions such as login, registration, or password reset', 'openaffiliates');?></p>
						</div>
						<div class="af-form-line">
							<h4><?php esc_html_e('After LogOut', 'openaffiliates');?></h4>
							<p><?php esc_html_e('When Affiliates logs out from their Account may be redirected to a specific page, such Login Page', 'openaffiliates');?></p>
							<select name="af_general_logout_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_logout_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_logout_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_logout_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('After Registration', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If no other redirect is triggered after registration, new affiliates may be redirected to a specific page', 'openaffiliates');?></p>
							<select name="af_general_register_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_register_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_register_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_register_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('After Login', 'openaffiliates');?></h4>
							<p><?php esc_html_e('It may redirect logged affiliates to Affiliate Portal', 'openaffiliates');?></p>
							<select name="af_general_login_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_login_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_login_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_login_redirect']);?></div>
						</div>

            <div class="af-form-line">
							<h4><?php esc_html_e('After Reset Password', 'openaffiliates');?></h4>
							<p><?php esc_html_e('A custom page where unlogged affiliates may be redirected after the Reset Password submission', 'openaffiliates');?></p>
							<select name="af_general_after_reset_password_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_lost_pass_page_logged_users_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_after_reset_password_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_after_reset_password_redirect']);?></div>
						</div>

					<div class="af-form-line">
					<h2><?php esc_html_e('Extra Redirects', 'openaffiliates');?></h2>
					</div>
						<div class="af-form-line">
							<h4><?php esc_html_e('Affiliate Portal - Restricted', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If the affiliate is not logged in and tries to access the Affiliate Portal, the redirect should apply', 'openaffiliates');?></p>
							<select name="af_general_account_page_no_logged_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_account_page_no_logged_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_account_page_no_logged_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_account_page_no_logged_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('Login Page - Restricted', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If the affiliate is logged in and tries to access the Login Page, the redirect should apply', 'openaffiliates');?></p>
							<select name="af_general_login_page_logged_users_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_login_page_logged_users_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_login_page_logged_users_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_login_page_logged_users_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('Registration Page - Restricted', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If the affiliate is logged in and tries to access the Registration Page, the redirect should apply', 'openaffiliates');?></p>
							<select name="af_general_register_page_logged_users_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_register_page_logged_users_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_register_page_logged_users_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_register_page_logged_users_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('LogOut Page - Restricted', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If the affiliate is not logged in and tries to access the LogOut Page, the redirect should apply', 'openaffiliates');?></p>
							<select name="af_general_logout_page_non_logged_users_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_logout_page_non_logged_users_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_logout_page_non_logged_users_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_logout_page_non_logged_users_redirect']);?></div>
						</div>

						<div class="af-form-line">
							<h4><?php esc_html_e('Lost Password Page - Restricted', 'openaffiliates');?></h4>
							<p><?php esc_html_e('If the affiliate is logged in and tries to access the Lost Password Page, the redirect should apply', 'openaffiliates');?></p>
							<select name="af_general_lost_pass_page_logged_users_redirect">
								<option value="-1" <?php echo ($data['metas']['af_general_lost_pass_page_logged_users_redirect']==-1) ? 'selected' : '';?> ><?php esc_html_e('Do Not Redirect', 'openaffiliates');?></option>
								<?php
									$pages_arr = $pages + af_get_redirect_links_as_arr_for_select();
									if ($pages_arr){
										foreach ($pages_arr as $k=>$v){
											?>
												<option value="<?php echo esc_attr($k);?>" <?php echo ($data['metas']['af_general_lost_pass_page_logged_users_redirect']==$k) ? 'selected' : '';?> ><?php echo esc_html($v);?></option>
											<?php
										}
									}
								?>
							</select>
							<div class="af-general-options-link-pages"><?php echo af_general_options_print_page_links($data['metas']['af_general_lost_pass_page_logged_users_redirect']);?></div>
						</div>



						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>

			</form>
</div>
