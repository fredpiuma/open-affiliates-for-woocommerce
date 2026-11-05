			<form action="<?php echo esc_url($data['url-manage']);?>" method="post">
				<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

		<div class="af-wrapper">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Manage Rank', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
							<div class="af-form-line">
							<div class="row">
							<div class="col-xs-6">
							<h2><?php esc_html_e('Activate/Hold Rank', 'openaffiliates');?></h2>
								<p><?php esc_html_e('The Rank can be turned on or off without having to be removed', 'openaffiliates');?></p>
								<label class="af_label_shiwtch af-switch-button-margin">
									<?php $checked = ($data['metas']['status']) ? 'checked' : '';?>
									<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#rank_status');" <?php echo esc_attr($checked);?> />
									<div class="switch af-display-inline"></div>
								</label>
								<input type="hidden" name="status" value="<?php echo esc_attr($data['metas']['status']);?>" id="rank_status" />
							</div>
						</div>
					</div>
						<div class="af-form-line">
							<div class="row">
						<div class="col-xs-8">
							<h2><?php esc_html_e('Rank Settings', 'openaffiliates');?></h2>
							<p><?php esc_html_e('The slug must be distinct and limited to lowercase letters.', 'openaffiliates');?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><?php esc_html_e('Slug', 'openaffiliates');?></span>
								<input type="text" class="form-control" placeholder="<?php esc_html_e('unique rank name', 'openaffiliates');?>" value="<?php echo esc_attr($data['metas']['slug']);?>" name="slug" />
							</div>
						</div>
					</div>
				</div>
				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><?php esc_html_e('Name', 'openaffiliates')?></span>
								<input type="text" class="form-control"  value="<?php echo esc_attr($data['metas']['label']);?>" name="label" id="rank_label" />
							</div>
						</div>
					</div>
				</div>
				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<h5><?php esc_html_e('Short Description', 'openaffiliates')?></h5>
								<textarea name="description" class="form-control text-area" cols="30" rows="3" placeholder="<?php esc_html_e('Some details...', 'openaffiliates');?>"><?php echo esc_af_content($data['metas']['description']);?></textarea>
							</div>
						</div>
					</div>
				</div>

			<div class="af-form-line">
					<div class="row">
							<div class="col-xs-12">
							<h2><?php esc_html_e('Set the Rank as the default for Affiliates', 'openaffiliates');?></h2>
							<p><?php esc_html_e('This ensures that new affiliates are automatically assigned to this default Rank upon registration, streamlining the onboarding process', 'openaffiliates');?></p>
								<label class="af_label_shiwtch af-switch-button-margin">
									<?php
									if ( $data['metas']['af_register_new_user_rank'] && (int)$data['metas']['af_register_new_user_rank'] === (int)$data['metas']['id'] ){
											$checked = 'checked';
									} else {
											$checked = '';
									}
									?>
									<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#set_as_default_rank');" <?php echo esc_attr($checked);?> />
									<div class="switch af-display-inline"></div>
								</label>
								<input type="hidden" name="set_as_default_rank" value="<?php if ( $checked === 'checked' ){echo 1;}else {echo 0;}?>" id="set_as_default_rank" />
							</div>
						</div>
			</div>

				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-12">
							<h2><?php esc_html_e('Rank Position', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Based on rank position, an affiliate may go to the next level if the achievement conditions are met', 'openaffiliates');?></p>
							<div class="af-rank-graphic"><?php echo esc_af_content($data['graphic']); ?></div>
						</div>
					</div>
					<div class="row">
							<div class="col-xs-3">
								<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Position', 'openaffiliates');?></span>
									<input type="number" min="1" class="form-control af-rank-settings-position" onChange="afRankChangeOrderPreview(<?php echo esc_attr($data['metas']['id']);?>, this.value);" onKeyUp="afRankChangeOrderPreview(<?php echo esc_attr($data['metas']['id']);?>, this.value);" max="<?php echo esc_attr($data['maximum_ranks']);?>" value="<?php echo esc_attr($data['metas']['rank_order']);?>" name="rank_order" />
								</div>
							 </div>
				</div>
			</div>
				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-12">
							<h2><?php esc_html_e('Rank rate', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Certain Product Rates or other variable settings may take precedence over the default Rank Rate.', 'openaffiliates');?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
						<div>
								<select name="amount_type" class="form-control m-bot15"><?php
									foreach ($data['amount_types'] as $k=>$v):
										$selected = ($data['metas']['amount_type']==$k) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
										<?php
									endforeach;
								?></select>

						 </div>
					 </div>
				 </div>
				 <div class="row">
					 <div class="col-xs-12">
						 <p><?php esc_html_e('Choose a referral rate type. Referrals can be based on either a percentage or a flat rate amount.', 'openaffiliates');?></p>
					 </div>
				 </div>
 					<div class="row">
 						<div class="col-xs-4">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1"><?php esc_html_e('Rate', 'openaffiliates');?></span>
							<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="form-control" value="<?php echo esc_attr($data['metas']['amount_value']);?>" name="amount_value" aria-describedby="basic-addon1">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div>
							<p>
<?php
$offerType = get_option( 'af_referral_offer_type' );
if ( $offerType == 'biggest' ){
	$offerType = esc_html__( 'Biggest', 'openaffiliates' );
} else {
	$offerType = esc_html__( 'Lowest', 'openaffiliates' );
}
echo esc_html__( 'You can choose which rate is used if more than one is set for the same activity (e.g., Ranks, Custom Product Rates, Product or Category rate), the  ', 'openaffiliates' ) . '<strong>' . $offerType . '</strong> ' . esc_html__( 'rate being used. You can adjust this from', 'openaffiliates' ) . ' <a href="' . admin_url( 'admin.php?page=openaffiliates&tab=settings' ) . '" target="_blank">' . esc_html__( 'here.', 'openaffiliates' ) . '</a>';
?>
</p>
						</div>

					</div>
				</div>
			</div>


				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-12">
							<h2><?php esc_html_e('Achievements Rules', 'openaffiliates');?></h2>
							<p><?php esc_html_e('To jump into current rank, affiliates need to accomplish the required achievements.', 'openaffiliates');?></p>

					</div>
				</div>
							<div id="achieve_rules">

								<?php
								$is_edit = FALSE;
								$excluded_achieve_type = array();
								if (!empty($data['metas']['achieve'])){
									$is_edit = TRUE;
									$arr = json_decode($data['metas']['achieve'], true);
								}
								if (!empty($arr) && !empty($arr['i'])){
									for ($i=1; $i<=$arr['i']; $i++){
										$excluded_achieve_type[] = $arr['type_' . $i];
									}
								}
								?>
								<div class="row">
									<div class="col-xs-4">
								<div id="achieve_type_div">
									<select id="achieve_type" class="form-control m-bot15">
										<?php foreach ($data['achieve_types'] as $k=>$v):
												if (in_array($k, $excluded_achieve_type)){
													continue;
												}
											?>
											<option value="<?php echo esc_attr($k);?>"><?php echo esc_html($v);?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								<div class="input-group" id="achieve_value_div">
									<span class="input-group-addon"><?php esc_html_e('Value', 'openaffiliates');?></span>
									<input  id="achieve_value" type="number" min="1" class="form-control" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								<div id="achieve_relation_div" class="<?php echo ($is_edit) ? 'af-display-block' : 'af-display-none';?>">
									<select id="achieve_relation" class="form-control m-bot15">
										<option value="and">AND</option>
										<option value="or">OR</option>
									</select>
								</div>

								<div onClick="afAddNewAchieveRule();" id="add_new_achieve" class="af-add-new-like-wp" ><i class="fa-af fa-add-new-item-af"></i><?php esc_html_e('Add New Rule', 'openaffiliates');?> </div>

								<div id="achieve_rules_view"><?php
										if (!empty($arr) && is_array($arr)){
											$display_reset = 'inline-block';
											if ($arr['i']>1){
												for ($i=1; $i<=$arr['i']; $i++){
													if (isset($arr['relation_' . $i])){
														?>
														<div class="achieve-item-relation"><?php echo esc_html($arr['relation_' . $i]);?></div>
														<?php
													}
													?>
													<div class="achieve-item" id="achieve_item_<?php echo esc_attr($i);?>"><div class="af-rank-settings-achievement-label"><?php echo esc_html($data['achieve_types'][$arr['type_' . $i]]);?></div><div>From: <?php echo esc_html($arr['value_' . $i]);?></div></div>
													<?php
												}
											} else {
												?>
												<div class="achieve-item" id="achieve_item_1"><div class="af-rank-settings-achievement-label"> <?php echo esc_html($arr['type_1']);?></div><div>From: <?php echo esc_html($arr['value_1']);?></div></div>
												<?php
											}
										}
								?></div>
								<div id="achieve_reset" onClick="afAchieveReset();" class="af-special-button af-special-button-singular <?php echo ($is_edit) ? 'af-display-inline' : 'af-display-none';?>"><i class="fa-af fa-remove-af"></i><?php esc_html_e('Reset Achievement Rules', 'openaffiliates');?></div>
							</div>
						</div>
							</div>
							<input type="hidden" value='<?php echo esc_attr($data['metas']['achieve']);?>' name="achieve" id="achieve_type_value"/>
			</div>


			<!--Deprecated starting with v.8.5 -->
				<!--div class="af-inside-item">
					<div class="row">
						<div class="af-form-line">
						<div class="col-xs-4">
							<h2><?php esc_html_e('Rank Color', 'openaffiliates');?></h2>
							<div>
								<ul id="af_colors_ul" class="af-colors-ul">
                                <?php
                                    $color_scheme = array('0a9fd8', '38cbcb', '27bebe', '0bb586', '94c523', '6a3da3', 'f1505b', 'ee3733', 'f36510', 'f8ba01');
                                    $i = 0;
                                    if (empty($data['metas']['color'])){
                                 		$data['metas']['color'] = $color_scheme[rand(0,9)];
                                 	}
                                    foreach ($color_scheme as $color){
                                        if ($i==5){
																					 echo esc_af_content("<li class='af-clear'></li>");
																				}
                                        $class = ($color==$data['metas']['color']) ? 'af-color-scheme-item-selected' : '';
                                        ?>
                                            <li class="af-color-scheme-item <?php echo esc_attr($class);?>  af-box-background-<?php echo esc_attr($color);?>" onClick="afChageColor(this, '<?php echo esc_attr($color);?>', '#af_color');"></li>
                                        <?php
                                        $i++;
                                    }
                                ?>
                            </ul>
                            <input type="hidden" name="color" id="af_color" value="<?php echo esc_attr($data['metas']['color']);?>" />
							</div>

						</div>
					</div>
				</div>
			</div-->
				<div class="af-form-line">
				<input type="hidden" name="id"	value="<?php echo esc_attr($data['metas']['id']);?>" />
				<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
		</div>
		</div>


		<div class="af-stuffbox af-magic-stuffbox <?php echo  (empty($data['bonus_enabled'])) ? 'af-display-none' : 'af-display-block'; ?>">
			<h3 class="af-h3"><?php esc_html_e('Bonus', 'openaffiliates');?></h3>
			<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('Achievement Bonus', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Every time an affiliate advances to a higher rank, they will receive a bonus of a fixed amount.', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon">Amount</span>
								 <input type="number" class="form-control" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['metas']['bonus']);?>" name="bonus" aria-describedby="basic-addon1">
								 <div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
			</div>
		</div>
			</div>
		</div>

		<div class="af-stuffbox af-magic-stuffbox <?php echo ($data['display-signup_referrals']) ? 'af-display-block' : 'af-display-none'; ?>">
			<h3 class="af-h3"><?php esc_html_e('SignUp Referrals', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('SignUp Referrals', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Reward affiliates with referrals generated through user sign-ups.', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon">Amount</span>
								<?php $value = ($data['metas']['sign_up_amount_value']>-1) ? $data['metas']['sign_up_amount_value'] : '';?>
								 <input type="number" class="form-control" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($value);?>" name="sign_up_amount_value" aria-describedby="basic-addon1">
								 <div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
			</div>
		</div>
			</div>
		</div>

		<div class="af-stuffbox af-magic-stuffbox <?php echo ($data['display-lifetime_commissions']) ? 'af-display-block' : 'af-display-none'; ?>">
			<h3 class="af-h3"><?php esc_html_e('LifeTime', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('LifeTime Comission', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Permit your affiliates to get compensated for all lifetime referrals.', 'openaffiliates');?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4">
					<div>
										<select name="lifetime_amount_type" class="form-control m-bot15"><?php
										foreach ($data['amount_types'] as $k=>$v):
											$selected = ($data['metas']['lifetime_amount_type']==$k) ? 'selected' : '';
											?>
											<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
											<?php
										endforeach;
									?></select>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
								<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Rate', 'openaffiliates');?></span>
									<?php $value = ($data['metas']['lifetime_amount_value']>-1) ? $data['metas']['lifetime_amount_value'] : '';?>
									<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="form-control" value="<?php echo esc_attr($value);?>" name="lifetime_amount_value" aria-describedby="basic-addon1">
								</div>


						<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
			</div>
		</div>
			</div>
		</div>

		<div class="af-stuffbox af-magic-stuffbox <?php echo ($data['display-reccuring_referrals']) ? 'af-display-block' : 'af-display-none'; ?>">
			<h3 class="af-h3"><?php esc_html_e('Reccurring Referrals', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('Reccurring Referrals', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Commissions should be given to membership systems for recurrent subscriptions.', 'openaffiliates');?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-4">
					<div>
										<select name="reccuring_amount_type" class="form-control m-bot15"><?php
									foreach ($data['amount_types'] as $k=>$v):
										$selected = ($data['metas']['reccuring_amount_type']==$k) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
										<?php
									endforeach;
								?></select>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-4">
								<div class="input-group">
									<span class="input-group-addon"><?php esc_html_e('Rate', 'openaffiliates');?></span>
									<?php $value = ($data['metas']['reccuring_amount_value']>-1) ? $data['metas']['reccuring_amount_value'] : '';?>
									<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="form-control" value="<?php echo esc_attr($value);?>" name="reccuring_amount_value" aria-describedby="basic-addon1">
								</div>

					<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
		</div>
			</div>
		</div>

		<div class="af-stuffbox af-magic-stuffbox <?php echo ($data['display-mlm']) ? 'af-display-block' : 'af-display-none'; ?>">
			<h3 class="af-h3"><?php esc_html_e("MLM Referrals For Each MLM Level", 'openaffiliates')?></h3>
			<div class="inside">

			<div class="row">
				<div class="col-xs-8">
						<div class="af-form-line">
					<h2><?php esc_html_e('MLM Referrals For Each MLM Level', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Set a multi-level marketing system for your affiliates.', 'openaffiliates');?></p>
					</div>
					<table class="af-dashboard-inside-table af-rank-mlm-table" id="mlm-amount-for-each-level">
								<thead>
									<tr>
									<th class="af-mlm-levels-table-header-col"><?php esc_html_e('MLM Depth (Level)', 'openaffiliates');?></th>
									<th><?php esc_html_e('Rate', 'openaffiliates');?></th>
								</tr>
								</thead>
								<?php
									for ($i=1; $i<=$data['mlm_matrix_depth']; $i++):
										?>
										<tr data-tr="<?php echo esc_attr($i);?>" id="af_mlm_level_<?php echo esc_attr( $i);?>">
											<td><?php echo esc_html__('Level', 'openaffiliates') . ' ' . $i;?></td>
											<td>
												<input type="number" step='<?php echo afInputNumerStep();?>' min="0" class="af-input-number" value="<?php echo isset($data['metas']['mlm_amount_value'][$i]) ? $data['metas']['mlm_amount_value'][$i] : '';?>" name="<?php echo esc_attr("mlm_amount_value[$i]");?>" />
												<select name="<?php echo esc_attr("mlm_amount_type[$i]");?>"><?php
													foreach ($data['amount_types'] as $k=>$v):
														$selected = (!empty($data['metas']['mlm_amount_type'][$i]) && $data['metas']['mlm_amount_type'][$i]==$k) ? 'selected' : '';
														?>
														<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
														<?php
													endforeach;
												?></select>
											</td>
										</tr>
										<?php
									endfor;
								?>
						</table>
					</div>

				</div>
				<div id="af_save_changes" class="af-submit-form">
					<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
				</div>
			</div>
			</div>

        <div class="af-stuffbox af-magic-stuffbox <?php echo  (empty($data['pay_per_click_enabled'])) ? 'af-display-none' : 'af-display-block'; ?>">
			<h3 class="af-h3"><?php esc_html_e('PayPerClick (CPC) Campaign', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="af-form-line">
			<div class="row">
				<div class="col-xs-6">
					<h2><?php esc_html_e('PPC Amount', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Affiliates will receive a PPC Referral with flat amount each time a new referred user visit your website.', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Rate', 'openaffiliates');?></span>
								 <input type="number" class="form-control" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['metas']['pay_per_click']);?>" name="pay_per_click" aria-describedby="basic-addon1">
								 <div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
			</div>
		</div>
			</div>
		</div>
        <div class="af-stuffbox af-magic-stuffbox <?php echo  (empty($data['cpm_commission_enabled'])) ? 'af-display-none' : 'af-display-block'; ?>">
			<h3 class="af-h3"><?php esc_html_e('Cost Per Mile (CPM) Campaign', 'openaffiliates');?></h3>
			<div class="inside">
			<div class="row">
				<div class="col-xs-4">
					<h2><?php esc_html_e('CPM Amount', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Affiliates will receive a CPM Referral with flat amount rewarded for 1000 impressions (displaying your banners 1000 times)', 'openaffiliates');?></p>
						<div class="input-group">
							<span class="input-group-addon"><?php esc_html_e('Rate', 'openaffiliates');?></span>
								 <input type="number" class="form-control" min="0" step='<?php echo afInputNumerStep();?>' value="<?php echo esc_attr($data['metas']['cpm_commission']);?>" name="cpm_commission" aria-describedby="basic-addon1">
								 <div class="input-group-addon"><?php echo esc_html($data['amount_types']['flat']);?></div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
								<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	</form>

<?php if ( $data['achieve_types'] ):?>
		<?php foreach ( $data['achieve_types'] as $value => $label ):?>
				<span class="af-js-achieve-types-values" data-value="<?php echo esc_attr($value);?>" data-label="<?php echo esc_attr($label);?>"></span>
		<?php endforeach;?>
<?php endif;?>
