<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Public Workflow Settings', 'openaffiliates');?></h3>
		<div class="inside">

			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-8">
						<h2><?php esc_html_e('Sources Custom Names', 'openaffiliates');?></h2>
						<p><?php esc_html_e("Customize the Referral sources displayed on the Affiliate Dashboard according to your preferences", 'openaffiliates');?></p>
						<?php
								$types = [
													'ump' => 'Ultimate Membership Pro',
													'ulp' => 'Ultimate Learning Pro',
													'woo' => 'WooCommerce',
													'edd' => 'Easy Download Digital',
													'bonus' => 'Bonus',
													'mlm' => 'MLM',
													'user_signup' => 'User SignUp',
													'landing_commissions' => 'Landing commisions',
													'ppc' => 'Pay per Click',
													'cpm' => 'CPM Commission',
								];
						?>
						<?php foreach ($types as $name=>$label):?>
								<div class="af-form-line">
									<div class="input-group">
									<span class="input-group-addon"><?php echo esc_html($label);?></span>
										<input type="text" class="form-control"  value="<?php echo esc_attr($data['metas']['af_custom_source_name_' . $name]);?>" name="<?php echo esc_attr('af_custom_source_name_' . $name);?>" />
									</div>
								</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>


		</div>
	</div>
</form>
</div>
