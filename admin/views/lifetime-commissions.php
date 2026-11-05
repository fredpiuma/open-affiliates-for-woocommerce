<div class="af-wrapper">
		<form  method="post">
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('LifeTime Commissions', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
						<div class="af-form-line">
						<div class="row">
						<div class="col-xs-5">
							<h2><?php esc_html_e('Activate/Hold LifeTime Commissions', 'openaffiliates');?></h2>
							<p><?php esc_html_e('You can activate this option to take place in your affiliate system.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_lifetime_commissions_enable']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_lifetime_commissions_enable');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_lifetime_commissions_enable" value="<?php echo esc_attr($data['metas']['af_lifetime_commissions_enable']);?>" id="af_lifetime_commissions_enable" />
						</div>
						</div>
					</div>

						<div class="row">
						<div class="col-xs-10">

						<?php if (!empty($data['rank_list'])) :?>
						<div class="af-form-line">
							<h2><?php esc_html_e('LifeTime Amount For Each Rank', 'openaffiliates');?></h2>
							<p><?php esc_html_e('Set a special lifetime amount for each rank that will replace the default amount rank. This option will also become available in the "Rank Settings" page.', 'openaffiliates');?></p>
							</div>
							<div class="af-form-line">
							<table class="af-dashboard-inside-table">
								<tr>
									<th><?php esc_html_e('Rank Name', 'openaffiliates');?></th>
									<th><?php esc_html_e('Default Amount Rank', 'openaffiliates');?></th>
									<th><?php esc_html_e('LifeTime Amount', 'openaffiliates');?></th>
								</tr>
								<?php foreach ($data['rank_list'] as $id=>$label) :?>
									<tr>
										<td><?php echo esc_html($label);?></td>
										<td><?php echo esc_html($data['default_rank_amount_value_array'][$id]) . ' ' . esc_html($data['amount_types'][$data['default_rank_amount_type_array'][$id]]);?></td>
										<td>
											<?php $value = ($data['rank_amount_value_array'][$id]>-1) ? $data['rank_amount_value_array'][$id] : '';?>
											<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="af-input-number" value="<?php echo esc_attr($value);?>" name="<?php echo esc_attr("lifetime_ranks_value[".esc_attr($id)."]");?>" />
											<select name="<?php echo esc_attr("lifetime_ranks_amount_type[$id]");?>"><?php
												foreach ($data['amount_types'] as $k=>$v):
													$selected = ($data['rank_amount_type_array'][$id]==$k) ? 'selected' : '';
													?>
													<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
													<?php
												endforeach;
											?></select>
										</td>
									</tr>
							<?php endforeach;?>
							</table>
							<p>
								<?php
								$offerType = get_option( 'af_referral_offer_type' );
								if ( $offerType == 'biggest' ){
										$offerType = esc_html__( 'Biggest', 'openaffiliates' );
								} else {
										$offerType = esc_html__( 'Lowest', 'openaffiliates' );
								}
								echo esc_html__( 'If there are multiple Amounts set for the same action, like Ranks, Offers, Product or Category rate the ', 'openaffiliates' ) . '<strong>' . $offerType . '</strong> ' . esc_html__( 'will be taken in consideration. You may change that from', 'openaffiliates' ) . ' <a href="' . admin_url( 'admin.php?page=openaffiliates&tab=settings' ) . '" target="_blank">' . esc_html__( 'here.', 'openaffiliates' ) . '</a>';
								?>
							</p>
						<?php endif;?>
					</div>
						</div>
					</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</form>


				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Search Lifetime User-Affiliates', 'openaffiliates');?></h3>
					<div class="inside">
						<form  method="post">
							<div>
								<?php esc_html_e('Affiliate Username', 'openaffiliates');?> <input type="text" name="affiliate_username" value="<?php echo isset($_POST['affiliate_username']) ? $_POST['affiliate_username'] : '';?>"/>
								<?php esc_html_e('Referrer Username', 'openaffiliates');?> <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '';?>" />
								<input type="submit" value="<?php esc_html_e('Search', 'openaffiliates');?>" name="search" class="button button-primary button-large" />
							</div>
						</form>
						<?php if (!empty($data['affiliate_referrals_table_data'])):?>
							<table class="af-dashboard-inside-table">
								<tr>
									<th><?php esc_html_e('Affiliate Username', 'openaffiliates');?></th>
									<th><?php esc_html_e('Referral Username', 'openaffiliates');?></th>
									<th><?php esc_html_e('Actions', 'openaffiliates');?></th>
								</tr>
								<?php foreach ($data['affiliate_referrals_table_data'] as $id=>$item) : ?>
									<tr>
										<td><?php echo esc_html($item['affiliate_username']);?></td>
										<td><?php echo esc_html($item['referral_username']);?></td>
										<td><a href="<?php echo esc_url($data['edit_relation'] . '&id=' . $id);?>"><?php esc_html_e('Edit', 'openaffiliates');?></a> | <a href="<?php echo esc_url($data['current_url'] . '&delete=' . $id);?>"><?php esc_html_e('Delete', 'openaffiliates');?></a></td>
									</tr>
								<?php endforeach;?>
							</table>
						<?php endif;?>
					</div>
				</div>


				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('LifeTime Commissions - Relations', 'openaffiliates');?></h3>
						<div class="inside">
							<p><?php esc_html_e('You may assign a potential client as a referrer with an affiliate such that, affiliate will receive a lifetime commission based on referrer actions.', 'openaffiliates'); ?></p>
							<div><a href="<?php echo admin_url( 'admin.php?page=openaffiliates&tab=magic_features&subtab=add_new_affiliate_referral_relation' );?>" class="af-add-new-like-wp"><i class="fa-af fa-add-af"></i><span><?php esc_html_e( 'Add New Relation', 'openaffiliates' );?></span></a></div>
						</div>

				</div>
</div>
