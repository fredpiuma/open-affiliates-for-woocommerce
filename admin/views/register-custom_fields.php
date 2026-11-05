			<form  method="post" id="custom_fields_form">

				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

				<span class="af-add-new-like-wp">
					<i class="fa-af fa-add-af"></i>
					<a href="<?php echo esc_url($data['url_edit_custom_fields']);?>" class="af-add-new-like-wp"><?php  esc_html_e('Add New Form Field', 'openaffiliates');?></a>
				</span>
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php  esc_html_e('Form Fields', 'openaffiliates');?></h3>
					<div class="inside">
						<div class="af-submit-form">
							<input id="af-submit-reg" type="submit" value="<?php  esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
								<div class="af-sortable-table-wrapp">

									<table class="wp-list-table widefat fixed tags af-alternate" id='af-register-fields-table'>
										    <thead>
												<tr>
													<th class="manage-column"><?php  esc_html_e('Slug', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('Label', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('Field Type', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('On Admin', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('On Register Page', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('On Affiliate Portal', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('Required', 'openaffiliates');?></th>
													<th class="manage-column"><?php  esc_html_e('WP Native', 'openaffiliates');?></th>
													<th class="manage-column af-table-check-col"></th>
													<th class="manage-column af-table-check-col"></th>
												</tr>
											</thead>
											<tbody>
									<?php
									$no_edit = array(
														'af_social_media',
														'user_email',
														'first_name',
														'last_name',
														'user_url',
														'pass1',
														'pass2',
														'description',
														'user_login',
									);

									$no_delete_fields = array(
														'user_login',
														'af_avatar',
														'recaptcha',
														'tos',
														'af_country',
														'af_social_media',
														'af_optin_accept',
														'user_email',
														'first_name',
														'last_name',
														'user_url',
														'pass1',
														'pass2',
														'description',
														'af_affiliate_paypal_email',
														'af_affiliate_bank_transfer_data'
									);
									foreach ($data['register_fields'] as $k=>$v){

										switch ($v['name']){
											case 'af_avatar':
												$tr_extra_class = "af-avatar-tr-dashboard";
												break;
											default:
												$tr_extra_class = '';
												break;
										}
										?>
										<tr class="<?php echo esc_attr($tr_extra_class);?>" id="tr_<?php echo esc_attr($k);?>">
											<td>
												<?php echo esc_html($v['name']);?>
												<input type="hidden" value="<?php echo esc_attr($k);?>" name="af-order-<?php echo esc_attr($k);?>" class="af-order" />
											</td>
											<td><?php
													if ($v['native_wp']){
														 esc_html_e($v['label'], 'openaffiliates');
													} else {
														echo esc_html($v['label']);
													}
												?>
											</td>
											<td><?php echo esc_html($v['type']);?></td>
											<td>
												<?php
													$notAvailableForAdminSection = [ 'af_social_media', 'payment_select', 'confirm_email', 'pass2' ];
													if( in_array( $v['name'], $notAvailableForAdminSection ) ){
														echo esc_html('-');
													} else if ($v['display_admin']==2){
														 esc_html_e('Always', 'openaffiliates');
													} else {
														?><label class="af-checkbox-wrapp">
														<input type="checkbox" onClick="checkAndH(this, '#af-field-display-admin<?php echo esc_attr($k);?>');" <?php echo ($v['display_admin']) ?  'checked' : '';?> />
														<input type="hidden" value="<?php echo esc_attr($v['display_admin']);?>" name="af-field-display-admin<?php echo esc_attr($k);?>" id="af-field-display-admin<?php echo esc_attr($k);?>" />
														<?php
													}
												?>
												<span class="af-checkmark"></span>
											</label></td>
											<td>
												<?php
													if ($v['display_public_reg']==2){
														 esc_html_e('Always', 'openaffiliates');
													} else {
														?><label class="af-checkbox-wrapp">
														<input type="checkbox" onClick="checkAndH(this, '#af-field-display-public-reg<?php echo esc_attr($k);?>');" <?php echo ($v['display_public_reg']) ?  'checked' : '';?> />
														<input type="hidden" value="<?php echo esc_attr($v['display_public_reg']);?>" name="af-field-display-public-reg<?php echo esc_attr($k);?>" id="af-field-display-public-reg<?php echo esc_attr($k);?>" />
														<?php
													}
												?>
												<span class="af-checkmark"></span>
											</label>
											</td>
											<td>
												<?php
													if ($v['display_public_ap']==2){
														 esc_html_e('Always', 'openaffiliates');
													} else if (in_array($v['name'], array('af_social_media', 'pass2', 'pass1'))){
														echo esc_html('-');
													} else {
														?><label class="af-checkbox-wrapp">
														<input type="checkbox" onClick="checkAndH(this, '#af-field-display-public-ap<?php echo esc_attr($k);?>');" <?php echo ($v['display_public_ap']) ?  'checked' : '';?> />
														<input type="hidden" value="<?php echo esc_attr($v['display_public_ap']);?>" name="af-field-display-public-ap<?php echo esc_attr($k);?>" id="af-field-display-public-ap<?php echo esc_attr($k);?>" />
														<?php
													}
												?>
												<span class="af-checkmark"></span>
											</label>
											</td>
											<td>
												<?php
													if ($v['display_public_reg']==2){
														 esc_html_e('Always', 'openaffiliates');
													} else if ($v['req']==2){
														 esc_html_e('Required When Selected', 'openaffiliates');
													} else if ($v['name']=='af_social_media'){
														echo esc_html('-');
													} else {
														?><label class="af-checkbox-wrapp">
														<input type="checkbox" onClick="checkAndH(this, '#af-require-<?php echo esc_attr($k);?>');" <?php echo ($v['req']) ?  'checked' : '';?> id="req-check-<?php echo esc_attr($k);?>" />
														<input type="hidden" value="<?php echo esc_attr($v['req']);?>" name="af-require-<?php echo esc_attr($k);?>" id="af-require-<?php echo esc_attr($k);?>" />
														<?php
													}
												?>
												<span class="af-checkmark"></span>
											</label>
											</td>
											<td>
												<?php
													if ($v['native_wp']){
														 esc_html_e('Yes', 'openaffiliates');
													} else {
														 esc_html_e('No', 'openaffiliates');
													}
												?>
											</td>
											<td>
												<?php
													if(in_array($v['name'], $no_edit) ){
														echo esc_html('-');
													} else {
														?>
														<a href="<?php echo esc_url($data['url_edit_custom_fields'] . '&id='.$k);?>">
															<i class="fa-af fa-edit-af"></i>
														</a>
														<?php
													}
												?>
											</td>
											<td>
												<?php
													if ( in_array($v['name'], $no_delete_fields)){
														echo esc_html('-');
													} else {
														?>
															<a href="javascript: return false;" onClick="afDeleteFromTable(<?php echo esc_attr($k);?>, 'custom_field', '#delete_custom_field', '#custom_fields_form');">
																<i class="fa-af fa-remove-af"></i>
															</a>
														<?php
													}
												?>
											</td>
										</tr>
										<?php
										}
									?>
										</tbody>

										<tfoot>
											<tr>
												<th class="manage-column"><?php  esc_html_e('Slug', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('Label', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('Field Type', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('On Admin', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('On Register Page', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('On Affiliate Portal', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('Required', 'openaffiliates');?></th>
												<th class="manage-column"><?php  esc_html_e('WP Native', 'openaffiliates');?></th>
												<th class="manage-column"></th>
												<th class="manage-column"></th>
											</tr>
										</tfoot>
									</table>
								</div>
						<input type="hidden" value="" name="delete_custom_field" id="delete_custom_field" />
						<div class="af-submit-form">
							<input id="af-submit-reg" type="submit" value="<?php  esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</form>
