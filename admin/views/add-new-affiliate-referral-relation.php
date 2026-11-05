<form action="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=lifetime_commissions' );?>" method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('LifeTime Commissions - Add New Relation', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Referral Username:', 'openaffiliates');?></label>
        <select name="referral_uid"><?php
					foreach ($data['users'] as $userObject ){
						?>
						<option value="<?php echo esc_attr($userObject->ID);?>"><?php echo esc_html($userObject->user_login);?></option>
						<?php
					}
				?></select>
			</div>
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Affiliate Username:', 'openaffiliates');?></label>
				<select name="affiliate"><?php
					foreach ($data['affiliates'] as $id=>$username){
						$selected = ( isset( $data['edit_data']['affiliate_id']) ) && $id==$data['edit_data']['affiliate_id'] ? 'selected' : '';
						?>
						<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($id);?>"><?php echo esc_html($username);?></option>
						<?php
					}
				?></select>
			</div>
			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save-new-relation" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>
