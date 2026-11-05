<?php
wp_enqueue_script( 'wp-theme-plugin-editor' );
wp_enqueue_style( 'wp-codemirror' );
wp_enqueue_script( 'code-editor' );
wp_enqueue_style( 'code-editor' );
 ?>

		<div class="af-page-title"><span class="second-text"><?php esc_html_e('Additional Settings', 'openaffiliates');?></span>
	</div>
	<div class="af-wrapper">
		<form  method="post">
			<div class="af-stuffbox">
				<h3 class="af-h3"><?php esc_html_e('Responsive Settings', 'openaffiliates');?></h3>
				<div class="inside">
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Screen Max-Width:', 'openaffiliates');?> 479px</span>
						<div class="af-general-options-link-pages"><select name="af_listing_users_responsive_small"><?php
							$arr = array( '1' => 1 . esc_html__(' Columns', 'openaffiliates'),
										  '2' => 2 . esc_html__(' Columns', 'openaffiliates'),
										  '3' => 3 . esc_html__(' Columns', 'openaffiliates'),
										  '4' => 4 . esc_html__(' Columns', 'openaffiliates'),
									 	  '5' => 5 . esc_html__(' Columns', 'openaffiliates'),
									 	  '6' => 6 . esc_html__(' Columns', 'openaffiliates'),
										  '0' => esc_html__('Auto', 'openaffiliates'),
							);
							foreach ($arr as $k=>$v){
								$selected = ($data['metas']['af_listing_users_responsive_small']==$k) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?>
						</select></div>
					</div>
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Screen Min-Width:', 'openaffiliates');?> 480px <?php esc_html_e(" and Screen Max-Width:");?> 767px</span>
						<div class="af-general-options-link-pages"><select name="af_listing_users_responsive_medium"><?php
							foreach ($arr as $k=>$v){
								$selected = ($data['metas']['af_listing_users_responsive_medium']==$k) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?>
						</select></div>
					</div>
					<div class="af-form-line">
						<span class="af-labels-special"><?php esc_html_e('Screen Min-Width:', 'openaffiliates');?> 768px <?php esc_html_e(" and Screen Max-Width:");?> 959px</span>
						<div class="af-general-options-link-pages"><select name="af_listing_users_responsive_large"><?php
							foreach ($arr as $k=>$v){
								$selected = ($data['metas']['af_listing_users_responsive_large']==$k) ? 'selected' : '';
								?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?>
						</select></div>
					</div>
					<div id="af_save_changes" class="af-wrapp-submit-bttn">
		            	<input type="submit" value="<?php esc_html_e('Save changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
		            </div>
				</div>
			</div>

			<div class="af-stuffbox af-custom-css-box-wrapper">
				<h3 class="af-h3"><?php esc_html_e('Custom CSS', 'openaffiliates');?></h3>
					<div class="af-form-line">
						<textarea id="af_listing_users_custom_css" name="af_listing_users_custom_css" class="af-custom-css-box"><?php echo stripslashes($data['metas']['af_listing_users_custom_css']);?></textarea>

					<div id="af_save_changes" class="af-wrapp-submit-bttn">
		            	<input type="submit" value="<?php esc_html_e('Save changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
		            </div>
				</div>
			</div>
		</form>
	</div>
