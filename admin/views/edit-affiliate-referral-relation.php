<form  method="post">
	<div class="af-stuffbox">
		<h3><?php esc_html_e('LifeTime Commissions', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Referral Username:', 'openaffiliates');?></label>
				<div class="af-display-inline"><strong><?php echo esc_html($data['edit_data']['referral_username']);?></strong></div>
			</div>
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Affiliate Username:', 'openaffiliates');?></label>
				<select name="affiliate"><?php
					foreach ($data['affiliates'] as $id=>$username){
						$selected = ($id==$data['edit_data']['affiliate_id']) ? 'selected' : '';
						?>
						<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($id);?>"><?php echo esc_html($username);?></option>
						<?php
					}
				?></select>
			</div>
			<input type="hidden" name="id" value="<?php echo esc_attr($data['edit_data']['relation']);?>" />
			<div class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</form>
