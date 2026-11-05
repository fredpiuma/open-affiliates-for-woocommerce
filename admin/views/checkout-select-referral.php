<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Checkout Referrals', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-8">
					<h2><?php esc_html_e('Activate/Hold  Checkout Referrals Field', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Once activated the customer will have the option to select an affiliate for commission during the checkout process.', 'openaffiliates');?></p>


						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_checkout_select_referral_enable']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_checkout_select_referral_enable');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_checkout_select_referral_enable" value="<?php echo esc_attr($data['metas']['af_checkout_select_referral_enable']);?>" id="af_checkout_select_referral_enable" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-10">
					<h4><?php esc_html_e('Form Label field', 'openaffiliates');?></h4>
					<p><?php esc_html_e('The label name for the additional field available inside the checkout form.', 'openaffiliates');?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-5">
					<div class="input-group">
					<label class="input-group-addon"><?php esc_html_e('Label', 'openaffiliates');?></label>
						<input type="text" class="form-control" name="af_checkout_select_referral_label" value="<?php echo esc_attr($data['metas']['af_checkout_select_referral_label']);?>" />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-4">
					<h2><?php esc_html_e('Field Settings', 'openaffiliates');?></h2>
					<div class="af-form-line">
						<h4><?php esc_html_e('Selection Type', 'openaffiliates');?></h4>
						<select name="af_checkout_select_referral_s_type" class="form-control m-bot15"><?php
							foreach (array(1 => esc_html__('Client select Affiliate from list', 'openaffiliates'), 2 => esc_html__('Client write the Username of Affiliate', 'openaffiliates')) as $k=>$v):
								$selected = ($data['metas']['af_checkout_select_referral_s_type']==$k) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							endforeach;
						?></select>
					</div>
					<div class="af-form-line">
						<h4><?php esc_html_e('Affiliate Name Display', 'openaffiliates');?></h4>
						<p><?php esc_html_e('How affiliates will be displayed.', 'openaffiliates');?></p>
						<select name="af_checkout_select_referral_name" class="form-control m-bot15"><?php
							foreach (array('user_login' => esc_html__('Username', 'openaffiliates'), 'display_name' => esc_html__('Display Name', 'openaffiliates'), 'user_nicename' => esc_html__('User Nicename', 'openaffiliates') ) as $k=>$v):
								$selected = ($data['metas']['af_checkout_select_referral_name']==$k) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
								<?php
							endforeach;
						?></select>
					</div>
				</div>
			</div>
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-10">
						<h4><?php esc_html_e('Affiliate List', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Choose specific affiliates to show up in checkout selection if you do not want to display all of them.', 'openaffiliates');?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" id="usernames_search" class="form-control"/>
						<?php $value = (is_array($data['metas']['af_checkout_select_affiliate_list'])) ? implode(',', $data['metas']['af_checkout_select_affiliate_list']) : $data['metas']['af_checkout_select_affiliate_list'];?>
						<input type="hidden" value="<?php echo esc_attr($value);?>" name="af_checkout_select_affiliate_list" id="usernames_search_hidden" />
						<div id="af_username_search_tags"><?php
							if (!empty($aff_list)){
								foreach ($aff_list as $value){
									if ($value){
										$id = 'af_username_tag_' . $value;
										?>
										<div id="<?php echo esc_attr($id);?>" class="af-tag-item"><?php echo esc_html($usernames[$value]);?><div class="af-remove-tag" onclick="afRemoveTag('<?php echo esc_attr($value);?>', '#<?php echo esc_attr($id);?>', '#usernames_search_hidden');" title="<?php esc_html_e('Removing tag', 'openaffiliates');?>">x</div></div>
										<?php
										}
									}
								}
							?></div>
					</div>

				</div>
			</div>



			<div class="row">
				<div class="col-xs-10">
				<h2><?php esc_html_e('Additional Settings', 'openaffiliates');?></h2>
					<div class="af-form-line">
						<h4><?php esc_html_e('Rewrite current Affiliate', 'openaffiliates');?></h4>
						<p><?php esc_html_e('If there is an affiliate already assigned for the current visitor/customer this one can be ignored. If not, the checkout option will not show up.', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_checkout_select_referral_rewrite']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_checkout_select_referral_rewrite');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_checkout_select_referral_rewrite" value="<?php echo esc_attr($data['metas']['af_checkout_select_referral_rewrite']);?>" id="af_checkout_select_referral_rewrite" />
					</div>


					<div class="af-form-line">
						<h4><?php esc_html_e('Require select Affiliate', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Force the customer to select an affiliate to continue the checkout process. The additional field will be set as required.', 'openaffiliates');?></p>

						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['af_checkout_select_referral_require']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_checkout_select_referral_require');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="af_checkout_select_referral_require" value="<?php echo esc_attr($data['metas']['af_checkout_select_referral_require']);?>" id="af_checkout_select_referral_require" />
					</div>
					</div>
				</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
	</div>
</div>
</form>
</div>
