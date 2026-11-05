<div class="af-wrapper">
	<div class="af-stuffbox">
	<form action="<?php echo esc_url($data['url-manage']);?>" method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />
	<h3 class="af-h3"><?php esc_html_e('Manage Product Rates', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>

	<div class="inside">
			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-6">
					<h2><?php esc_html_e('Activate/Hold current Product Rate', 'openaffiliates');?></h2>
						<p><?php esc_html_e('The product rate can be turned on or off without having to be removed', 'openaffiliates');?></p>
						<label class="af_label_shiwtch af-switch-button-margin">
							<?php $checked = ($data['metas']['status']) ? 'checked' : '';?>
							<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#offer_status');" <?php echo esc_attr($checked);?> />
							<div class="switch af-display-inline"></div>
						</label>
						<input type="hidden" name="status" value="<?php echo esc_attr($data['metas']['status']);?>" id="offer_status" />
					</div>
					</div>
				</div>

				 <div class="af-form-line">
					<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon" ><?php esc_html_e('Name', 'openaffiliates');?></span>
								<input type="text" class="form-control" placeholder="special offer"  value="<?php echo esc_attr($data['metas']['name']);?>" name="name" />
							</div>
						</div>
					</div>
				</div>


			<div class="af-form-line">
					<h2><?php esc_html_e('Custom Rate', 'openaffiliates');?></h2>
						<p><?php esc_html_e('To replace the usual Rate Rank, a unique amount rate must be established for this Custom Product Rate.', 'openaffiliates');?></p>
							<div class="row">
								<div class="col-xs-4">

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
					 <div class="row">
					 		<div class="col-xs-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1"><?php esc_html_e('Rate', 'openaffiliates');?></span>
								<input type="number" min="0" step='<?php echo afInputNumerStep();?>' class="form-control" name="amount_value" value="<?php echo esc_attr($data['metas']['amount_value']);?>" aria-describedby="basic-addon1">
							</div>
						</div>
							</div>
							<?php
							$offerType = get_option( 'af_referral_offer_type' );
							if ( $offerType == 'biggest' ){
									$offerType = esc_html__( 'Biggest', 'openaffiliates' );
							} else {
									$offerType = esc_html__( 'Lowest', 'openaffiliates' );
							}
							echo esc_html__( 'You can choose which rate is used if more than one is set for the same activity (e.g., Ranks, Custom Product Rates, Product or Category rate), the ', 'openaffiliates' ) . '<strong>' . $offerType . '</strong> ' . esc_html__( 'rate being used. You can adjust this from', 'openaffiliates' ) . ' <a href="' . admin_url( 'admin.php?page=openaffiliates&tab=settings' ) . '" target="_blank">' . esc_html__( 'here.', 'openaffiliates' ) . '</a>';
							?>
				</div>

				<div class="af-form-line">
					<h4><?php esc_html_e('Date Range', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Depending on your selling strategy, the Product Rate will be active for a specific amount of time.', 'openaffiliates');?></p>
					<div class="row">
						<div class="col-xs-6">
							<input type="text" placeholder="From - yyyy-mm-dd" id="start_date" name="start_date" value="<?php echo esc_attr($data['metas']['start_date']);?>" class="af-datepick" />
							 -
							<input type="text" placeholder="To - yyyy-mm-dd" id="end_date" name="end_date" value="<?php echo esc_attr($data['metas']['end_date']);?>" class="af-datepick" />
					</div>
				</div>
			</div>
				<div class="af-form-line">
					<div class="row">
						<div class="col-xs-6">
							<h2><?php esc_html_e('Targeting Settings', 'openaffiliates');?></h2>
							<p><?php esc_html_e('The Product Rate will be accessible exclusively to specified affiliates and based on particular Products.', 'openaffiliates');?></p>
						</div>
					</div>
				</div>
					<div class="af-form-line">
							<div class="row">
								<div class="col-xs-6">
								<h4><?php esc_html_e('Particular Products', 'openaffiliates');?></h4>
									<p><?php esc_html_e('Choose the source and certain products to assign this custom Rates to all Products.', 'openaffiliates');?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
							<?php
									//$ajaxURL = AF_URL . 'admin/af-offers-ajax-autocomplete.php?&afAdminAjaxNonce=' . wp_create_nonce( 'afAdminAjaxNonce' ) . '&source=';
									$ajaxURL = get_site_url() . '/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&afAdminAjaxNonce=' . wp_create_nonce( 'afAdminAjaxNonce' ) . '&source=';
							?>
							<select name="source" id="the_source"  class="form-control m-bot15 af-js-offers-add-edit-select-source"
								data-target_url="<?php echo esc_url($ajaxURL);?>"
								><?php
								$values = af_get_active_services();
								if ($values):
									foreach ($values as $k=>$v){
										$selected = ($data['metas']['source']==$k) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
										<?php
									}
								endif;
							?></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon js-af-product-label" >
											<?php if ( $data['metas']['source'] == 'woo' ):?>
													<?php esc_html_e( 'Products/Categories', 'openaffiliates' );?>
											<?php else :?>
													<?php esc_html_e('Products', 'openaffiliates');?>
											<?php endif;?>
											</span>
								<input type="text"  class="form-control" value="" name="reference_search" id="reference_search" />
							</div>
								<?php $value = (is_array($data['metas']['products'])) ? implode(',', $data['metas']['products']) : $data['metas']['products'];?>
								<input type="hidden" value="<?php echo esc_attr($value);?>" name="products" id="reference_search_hidden" />
								<div id="af_reference_search_tags"><?php
									if (!empty($data['metas']['products'])){
										foreach ($data['metas']['products'] as $value){
											if ($value){
											$id = 'af_reference_tag_' . $value;
											?>
											<div id="<?php echo esc_attr($id);?>" class="af-tag-item"><?php echo esc_html($data['products']['label'][$value]);?><div class="af-remove-tag" onclick="afRemoveTag('<?php echo esc_attr($value);?>', '#<?php echo esc_attr($id);?>', '#reference_search_hidden');" title="<?php esc_html_e( 'Removing tag', 'openaffiliates' );?>">x</div></div>
											<?php
											}
										}
									}
								?></div>

								<p><?php esc_html_e('If You do not specify any product, it will consider all of them from that source.', 'openaffiliates');?></p>
						</div>
						</div>
					</div>
					<div class="af-form-line">
					<div class="row">
						<div class="col-xs-6">
							<h4 ><?php esc_html_e('Specific Affiliates', 'openaffiliates');?></h4>
							<p><?php esc_html_e('Choose certain affiliates or type "All" to provide this Custom Rate for all of your affiliate users.', 'openaffiliates');?></p>
							<div class="input-group">
								<span class="input-group-addon" ><?php esc_html_e('Username', 'openaffiliates');?></span>
								<input type="text"  class="form-control" id="usernames_search" />
							</div>
								<?php $value = (is_array($data['metas']['affiliates'])) ? implode(',', $data['metas']['affiliates']) : $data['metas']['affiliates'];?>
								<input type="hidden" value="<?php echo esc_attr($value);?>" name="affiliates" id="usernames_search_hidden" />
								<div id="af_username_search_tags"><?php
									if (!empty($data['metas']['affiliates'])){
										foreach ($data['metas']['affiliates'] as $value){
											if ($value){
											$id = 'af_username_tag_' . $value;
											?>
											<div id="<?php echo esc_attr($id);?>" class="af-tag-item"><?php echo esc_html($data['affiliates']['username'][$value]);?><div class="af-remove-tag" onclick="afRemoveTag('<?php echo esc_attr($value);?>', '#<?php echo esc_attr($id);?>', '#usernames_search_hidden');" title="<?php esc_html_e('Removing tag', 'openaffiliates');?>">x</div></div>
											<?php
											}
										}
									}
								?></div>

					</div>
					</div>
			</div>
			 <!--Deprecated starting with v.8.5 -->
				<!--div class="af-inside-item">
					<div class="row">
						<div class="col-xs-4">
							<div class="af-form-line">
							<h4><?php esc_html_e('Offer Color', 'openaffiliates');?></h4>
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
                                            <li class="af-color-scheme-item <?php echo esc_attr($class);?> af-box-background-<?php echo esc_attr($color);?>" onClick="afChageColor(this, '<?php echo esc_attr($color);?>', '#af_color');"></li>
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
					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
					</div>
			</div>
		</div>

				<input type="hidden" name="id" value="<?php echo esc_attr($data['metas']['id']);?>" />

			</form>

			</div>
		</div>

<div class="af-js-offers-add-edit-labels" data-products_and_cats="<?php esc_html_e( 'Products/Categories', 'openaffiliates' );?>" data-products="<?php esc_html_e( 'Products', 'openaffiliates' );?>"></div>
