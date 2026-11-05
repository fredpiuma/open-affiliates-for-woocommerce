<div class="af-wrapper">
		<div class="af-stuffbox">
			<form action="<?php echo esc_url($data['url-manage']);?>" method="post">

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

				<h3 class="af-h3"><?php esc_html_e('Add/Edit Referral', 'openaffiliates');?></h3>

				<div class="inside af-referral-add">
					<div class="af-form-line af-referral-add-title">
						<h4><?php esc_html_e('Affiliate Details', 'openaffiliates');?></h4>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label "><?php esc_html_e('Affiliate User', 'openaffiliates');?><span class="af-color-red">*</span></label>
						<div class="af-referral-add-field-wrap">
						<select name="affiliate_id"><?php
							foreach ($data['affiliates'] as $k=>$v):
								$selected = ($data['metas']['affiliate_id']==$k) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v['username']);?></option>
								<?php
							endforeach;
						?></select>
						<span class="af-sublabel"><?php esc_html_e("The affiliate's username", 'openaffiliates');?></span>
						</div>
					</div>

					<div class="af-form-line af-referral-add-title">
						<h4><?php esc_html_e('Referral Amount', 'openaffiliates');?></h4>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Amount', 'openaffiliates');?><span class="af-color-red">*</span></label>
						<div class="af-referral-add-field-wrap">
							<input type="number" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['metas']['amount']);?>" name="amount" />
							<span class="af-sublabel"><?php esc_html_e('The Referral Amount earned by the Affiliate for this Referral', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Currency', 'openaffiliates');?><span class="af-color-red">*</span></label>
						<div class="af-referral-add-field-wrap">
						<select name="currency"><?php
							$currency = af_get_currencies_list();
							foreach ($currency as $k=>$v){
								$selected = ($k==$data['metas']['currency']) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							}
						?></select>
						</div>
					</div>

					<div class="af-form-line af-referral-add-title">
						<h4><?php esc_html_e('Created Time', 'openaffiliates');?></h4>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Date', 'openaffiliates');?><span class="af-color-red">*</span></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['date']);?>" name="date" id="referrals_date"/>
							<span class="af-sublabel"><?php esc_html_e('Date and Time when current Referral have been created', 'openaffiliates');?></span>
						</div>
					</div>

					<div class="af-form-line af-referral-add-title">
						<h4><?php esc_html_e('Referral Identificator', 'openaffiliates');?></h4>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Source', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_html($data['metas']['source']);?>" name="source" />
							<span class="af-sublabel"><?php esc_html_e('Where this Referral came from. Source slug, predefined (ex: woo, ump, edd, ulp, bonus, User SignUp, from landing commissions)  or custom one', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Reference', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['reference']);?>" name="reference" />
							<span class="af-sublabel"><?php esc_html_e('A reference for this referral. Usually this would be the order ID of the associated purchase or User ID for User SignUp', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Reference Details', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<textarea name="reference_details"><?php echo esc_html($data['metas']['reference_details']);?></textarea>
							<span class="af-sublabel"><?php esc_html_e('Additional details for current Reference', 'openaffiliates');?></span>
						</div>
					</div>

					<div class="af-form-line af-referral-add-title">
						<h4><?php esc_html_e('Additional Details', 'openaffiliates');?></h4>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Click ID', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['visit_id']);?>" name="visit_id" />
							<span class="af-sublabel"><?php esc_html_e('The ID of the Click which resulted to this Referral, if applicable. Click entry is accessible in the ', 'openaffiliates');?><a href="<?php echo admin_url('admin.php?page=openaffiliates').'&tab=visits';?>" target="_blank"><?php esc_html_e('Clicks', 'openaffiliates');?></a><?php esc_html_e(' section', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Customer User ID', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['refferal_wp_uid']);?>" name="refferal_wp_uid" />
							<span class="af-sublabel"><?php esc_html_e('The ID of the Customer associated with this Referral', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Affiliate Campaign', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['campaign']);?>" name="campaign" />
							<span class="af-sublabel"><?php esc_html_e('The campaign slug that the affiliate user created using the Affiliate Portal page', 'openaffiliates');?></span>
						</div>
					</div>

					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Description', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<textarea name="description"><?php echo esc_html($data['metas']['description']);?></textarea>
							<span class="af-sublabel"><?php esc_html_e('An expanded explanation for the present referral', 'openaffiliates');?></span>
						</div>
					</div>

					<div class="af-display-none <?php echo (!empty($data['metas']['parent_referral_id']) || !empty($data['metas']['child_referral_id']) || $af_db->is_magic_feat_enable('mlm')) ? 'af-display-block' : ''; ?> " >

						<div class="af-form-line af-referral-add-title">
							<h4><?php esc_html_e('MLM Linked Referrals', 'openaffiliates');?></h4>
							<p><?php esc_html_e('Exclusively designed for MLM workflows.', 'openaffiliates');?></p>
						</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Upline Referral ID', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['parent_referral_id']);?>" name="parent_referral_id" />
							<span class="af-sublabel"><?php esc_html_e('The Referral ID that the Upline Affiliate user has received', 'openaffiliates');?></span>
						</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Downline Referral ID', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
							<input type="text" value="<?php echo esc_attr($data['metas']['child_referral_id']);?>" name="child_referral_id" />
							<span class="af-sublabel"><?php esc_html_e('The Referral ID that the Downline Affiliate user has received', 'openaffiliates');?></span>
						</div>
					</div>
				</div>

				<div class="af-form-line af-referral-add-title">
					<h4><?php esc_html_e('Statuses', 'openaffiliates');?></h4>
				</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Status', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
						<select name="status"><?php
							foreach ($data['status_posible'] as $k=>$v):
								$selected = ($data['metas']['status']==$k) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
								<?php
							endforeach;
						?></select>
					</div>
					</div>
					<div class="af-form-line af-referral-add-element">
						<label class="af-label"><?php esc_html_e('Payment', 'openaffiliates');?></label>
						<div class="af-referral-add-field-wrap">
						<select name="payment"><?php
							foreach ($data['payment_posible'] as $k=>$v):
								$selected = ($data['metas']['payment']==$k) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
								<?php
							endforeach;
						?></select>
						<span class="af-sublabel"><?php esc_html_e('Choose Paid if current Referral have been withdrawn by Affiliate user', 'openaffiliates');?></span>
					</div>
					</div>

					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
					</div>
				</div>

				<input type="hidden" name="id" value="<?php echo esc_attr($data['metas']['id']);?>" />

			</form>
		</div>

</div>
