<?php
wp_enqueue_script( 'af-public-functions', AF_URL . 'assets/js/public-functions.js', array('jquery'), '9.4' );
$meta_arr = array(
							'num_of_entries' => 10,
							'entries_per_page' => 5,
							'order_by' => 'earnings',
							'order_type' => 'desc',
							'user_fields' => 'user_login,user_email,first_name,last_name,af_avatar',
							'include_fields_label' => 0,
							'theme' => 'ihc-theme_1',
							'color_scheme' => '0a9fd8',
							'columns' => 5,
							'inside_page' => 0,
							'align_center' => 1,
							'slider_set' => 0,
							'items_per_slide' => 2,
							'speed' => 5000,
							'pagination_speed' => 500,
							'bullets' => 1,
							'nav_button' => 1,
							'autoplay' => 1,
							'stop_hover' => 0,
							'autoplay' => 1,
							'stop_hover' => 0,
							'responsive' => 0,
							'autoheight' => 0,
							'lazy_load' => 0,
							'loop' => 1,
							'pagination_theme' => 'pag-theme1',
						);
							wp_enqueue_script( 'af-owl-carousel', AF_URL . 'public/listing_users/assets/js/owl.carousel.js', ['jquery'], '9.4' );

?>
<div class="af-js-top-affiliates-plugin-url" data-value='<?php echo AF_URL;?>' ></div>

	<div class="af-user-list-wrap">
			<div class="af-page-title"><span class="second-text"><?php esc_html_e('Top Affiliates Showcase', 'openaffiliates');?></span>
			</div>
			<div class="af-wrapper">
			<div class="af-user-list-settings-wrapper">
				<div class="box-title">
		            <h3><i class="fa-af fa-icon-angle-down-af"></i><?php esc_html_e("ShortCode Generator", 'openaffiliates')?></h3>
		            <div class="actions pointer">
					    <a id="af_js_top_affiliates_the_toggle" onclick="" class="btn btn-mini content-slideUp">
		                    <i class="fa-af fa-icon-cogs-af"></i>
		                </a>
					</div>
				 	<div class="clear"></div>
				</div>
				<div id="the_af_user_list_settings" class="af-list-users-settings">

					<!-- DISPLAY ENTRIES -->
					<div class="af-column column-one">
                   		<h4 class="af-top-affiliates-box1-background"><i class="fa-af fa-icon-dispent-af"></i><?php esc_html_e('Display Entries', 'openaffiliates');?></h4>
						<div class="af-settings-inner">
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Number Of Entries:", 'openaffiliates');?></div>
								<div class="af-field"><input type="number" value="<?php echo esc_attr($meta_arr['num_of_entries']);?>" id="num_of_entries" onKeyUp="afPreviewUList();" onChange="afPreviewUList();" min="0" /></div>
							</div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Entries Per Page:", 'openaffiliates');?></div>
								<div class="af-field"><input type="number" value="<?php echo esc_attr($meta_arr['entries_per_page']);?>" id="entries_per_page" onKeyUp="afPreviewUList();" onChange="afPreviewUList();" min="1" /></div>
							</div>
							<div class="af-spacewp_b_divs"></div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Order By:", 'openaffiliates');?></div>
								<div class="af-field">
									<select id="order_by" onChange="afPreviewUList();">
										<?php
											$arr = array(
														  'referrals' => esc_html__('Referrals', 'openaffiliates'),
														  'earnings' => esc_html__('Earnings', 'openaffiliates'),
														  'visits' => esc_html__('Visits', 'openaffiliates'),
														  'user_registered' => esc_html__('Register Date','openaffiliates'),
														  'user_login' => esc_html__("UserName", 'openaffiliates'),
														  'user_email' => esc_html__("E-mail Address", 'openaffiliates'),
														  'random' => esc_html__("Random", 'openaffiliates'),
											);
											foreach ($arr as $k=>$v){
												$selected = ($meta_arr['order_by']==$k) ? 'selected' : '';
												?>
												<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Order Type:", 'openaffiliates');?></div>
								<div class="af-field">
									<select id="order_type" onChange="afPreviewUList();">
										<?php
											foreach (array('asc'=>'ASC', 'desc'=>'DESC') as $k=>$v){
												$selected = ($meta_arr['order_type']==$k) ? 'selected' : '';
												?>
												<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>

							<div class="af-spacewp_b_divs"></div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Filter By Rank", 'openaffiliates');?></div>
								<div class="af-field">
									<label class="af-checkbox-wrapp">
									<input type="checkbox" id="filter_by_rank" onClick="afCheckboxDivRelation(this, '#ranks_in__wrap_div');afPreviewUList();" />
									<span class="af-checkmark"></span>
								</label>
								</div>
							</div>
							<div class="af-user-list-row af-top-affiliates-half-opacity" id="ranks_in__wrap_div">
								<div class="af-label"><?php esc_html_e("User's Ranks:", 'openaffiliates');?></div>
								<div class="af-field">
									<?php
										$ranks = $af_db->get_ranks();
										if ($ranks){
											?>
											<select class="af-form-select " onchange="afWriteTagValueListUsers(this, '#ranks_in', '#af-select-ranks-view-values', 'af-ranks-select-v-');afPreviewUList();">
												<option value="">...</option>
											<?php
											foreach ($ranks as $object){
												?>
													<option value="<?php echo esc_attr($object->id);?>"><?php echo esc_html($object->label);?>
												<?php
											}
											?>
											</select>
											<?php
										}
									?>

								</div>
								<div id="af-select-ranks-view-values"></div>
									<input type="hidden" value="" id="ranks_in" />
							</div>
						</div>
					</div>
					<!-- /DISPLAY ENTRIES -->



					<!-- TEMPLATE -->
					<div class="af-column column-three">
						<h4 class="af-top-affiliates-box2-background"><i class="fa-af fa-icon-temp-af"></i>Template</h4>
						<div class="af-settings-inner">
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Select Theme", 'openaffiliates');?></div>
								<div class="af-field">
									<select id="theme" onChange="afPreviewUList();"><?php
										$themes = array('af-theme_1' => esc_html__('Theme', 'openaffiliates') . ' 1',
														'af-theme_2' => esc_html__('Theme', 'openaffiliates') . ' 2',
														'af-theme_3' => esc_html__('Theme', 'openaffiliates') . ' 3',
														'af-theme_4' => esc_html__('Theme', 'openaffiliates') . ' 4',
														'af-theme_5' => esc_html__('Theme', 'openaffiliates') . ' 5',
														'af-theme_6' => esc_html__('Theme', 'openaffiliates') . ' 6',
														'af-theme_7' => esc_html__('Theme', 'openaffiliates') . ' 7',
														'af-theme_8' => esc_html__('Theme', 'openaffiliates') . ' 8',
														'af-theme_9' => esc_html__('Theme', 'openaffiliates') . ' 9',
														'af-theme_10' => esc_html__('Theme', 'openaffiliates') . ' 10',
												);
										foreach ($themes as $k=>$v){
											$selected = ($meta_arr['theme']==$k) ? 'selected' : '';
											?>
											<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
											<?php
										}
									?></select>
								</div>
							</div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Color Scheme", 'openaffiliates');?></div>
								<div class="af-field">
		                            <ul id="colors_ul" class="colors_ul">
		                                <?php
		                                    $color_scheme = array('0a9fd8', '38cbcb', '27bebe', '0bb586', '94c523', '6a3da3', 'f1505b', 'ee3733', 'f36510', 'f8ba01');
		                                    $i = 0;
		                                    foreach ($color_scheme as $color){
		                                        if( $i==5 ){
																							 echo esc_af_content("<li class='af-clear'></li>");
																						}
		                                        $class = ($meta_arr['color_scheme']==$color) ? 'color-scheme-item color-scheme-item-selected' : 'color-scheme-item';
		                                        ?>
		                                            <li class="<?php echo esc_attr($class);?>  af-box-background-<?php echo esc_attr($color);?>" onClick="afChangeColorTop(this, '<?php echo esc_attr($color);?>', '#color_scheme');afPreviewUList();" ></li>
		                                        <?php
		                                        $i++;
		                                    }
		                                ?>
										<li class='af-clear'></li>
		                            </ul>
		                            <input type="hidden" id="color_scheme" value="<?php echo esc_attr($meta_arr['color_scheme']);?>" />
								</div>
							</div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Columns", 'openaffiliates');?></div>
								<div class="af-field">
									<select id="columns" onChange="afPreviewUList();"><?php
										for ($i=1; $i<7; $i++){
											$selected = ($i==$meta_arr['columns']) ? 'selected' : '';
											?>
											<option value="<?php echo esc_attr($i);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($i) . esc_html__(" Columns", 'openaffiliates')?></option>
											<?php
										}
									?></select>
								</div>
							</div>
							<div class="af-user-list-row">
								<div class="af-label"><?php esc_html_e("Additional Options", 'openaffiliates');?></div>
							</div>
							<div class="af-user-list-row">
								<label class="af-checkbox-wrapp">
								<?php $checked = (empty($meta_arr['align_center'])) ? '' : 'checked';?>
								<input type="checkbox" id="align_center" <?php echo esc_attr($checked);?> onClick="afPreviewUList();"/> <?php esc_html_e("Align the Items Centered", 'openaffiliates');?>
								<span class="af-checkmark"></span>
							</label>
							</div>

							<div class="af-user-list-row">
								<label class="af-checkbox-wrapp">
								<?php $checked = ($meta_arr['include_fields_label']) ? 'checked' : '';?>
								<input type="checkbox"  id="include_fields_label" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> />
								<?php esc_html_e('Show Fields Label', 'openaffiliates');?>
								<span class="af-checkmark"></span>
							</label>
							</div>
						</div>
					</div>
					<!-- /TEMPLATE -->

					<!-- SLIDER -->
					<div class="af-column column-four af-column-four">
						<h4 class="af-top-affiliates-box3-background"><i class="fa-af fa-icon-slider-af"></i><?php esc_html_e("Slider ShowCase", 'openaffiliates');?></h4>
						<div class="af-settings-inner">
							<div class="af-user-list-row">
								<label class="af-checkbox-wrapp">
								<?php $checked = (empty($meta_arr['slider_set'])) ? '' : 'checked';?>
								<input type="checkbox" <?php echo esc_attr($checked);?> id="slider_set" onClick="afCheckboxDivRelation(this, '#slider_options');afPreviewUList();"/> <b><?php echo esc_html__('Show as Slider', 'openaffiliates');?></b>
	                 		 	<div class="extra-info af-display-block"><?php echo esc_html__('If Slider Showcase is used, Pagination Showcase is disabled.', 'openaffiliates');?></div>
												<span class="af-checkmark"></span>
											</label>
							</div>
							<div class="af-top-affiliates-half-opacity" id="slider_options" >

						     <div class="splt-1">
								<div class="af-user-list-row">
									<div class="af-label"><?php esc_html_e('Items per Slide:', 'openaffiliates');?></div>
									<div class="af-field">
										<input type="number" min="1" id="items_per_slide" onChange="afPreviewUList();" onKeyup="afPreviewUList();" value="<?php echo esc_attr($meta_arr['items_per_slide']);?>" />
									</div>
								</div>
								<div class="af-user-list-row">
									<div class="af-label"><?php esc_html_e('Slider Timeout:', 'openaffiliates');?></div>
									<div class="af-field">
										<input type="number" min="1" id="speed" onChange="afPreviewUList();" onKeyup="afPreviewUList();" value="<?php echo esc_attr($meta_arr['speed']);?>" />
									</div>
								</div>
								<div class="af-user-list-row">
									<div class="af-label"><?php esc_html_e('Pagination Speed:', 'openaffiliates');?></div>
									<div class="af-field">
										<input type="number" min="1" id="pagination_speed" onChange="afPreviewUList();" onKeyup="afPreviewUList();" value="<?php echo esc_attr($meta_arr['pagination_speed']);?>" />
									</div>
								</div>
								 <div class="af-user-list-row">
	                          		<div class="af-label"><?php esc_html_e('Pagination Theme:', 'openaffiliates');?></div>
	                          		<div class="af-field">
		                          		<select id="pagination_theme" onChange="afPreviewUList();"><?php
		                          			$array = array(
		                          								'pag-theme1' => esc_html__('Pagination Theme 1', 'openaffiliates'),
		                          								'pag-theme2' => esc_html__('Pagination Theme 2', 'openaffiliates'),
		                          								'pag-theme3' => esc_html__('Pagination Theme 3', 'openaffiliates'),
		                          							);
		                          			foreach ($array as $k=>$v){
		                          				$selected = ($k==$meta_arr['pagination_theme']) ? 'selected' : '';
		                          				?>
		                          				<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
		                          				<?php
		                          			}
		                          		?>
		                                </select>
	                          		</div>
	                          </div>

	                            <div class="af-user-list-row">
	                          		<div class="af-label"><?php esc_html_e('Animation Slide In', 'openaffiliates');?></div>
	                          		<div class="af-field">
	                                  <select onChange="afPreviewUList();" id="animation_in">
										  <option value="none">None</option>
										  <option value="fadeIn">fadeIn</option>
										  <option value="fadeInDown">fadeInDown</option>
										  <option value="fadeInUp">fadeInUp</option>
										  <option value="slideInDown">slideInDown</option>
										  <option value="slideInUp">slideInUp</option>
										  <option value="flip">flip</option>
										  <option value="flipInX">flipInX</option>
										  <option value="flipInY">flipInY</option>
										  <option value="bounceIn">bounceIn</option>
										  <option value="bounceInDown">bounceInDown</option>
										  <option value="bounceInUp">bounceInUp</option>
										  <option value="rotateIn">rotateIn</option>
										  <option value="rotateInDownLeft">rotateInDownLeft</option>
										  <option value="rotateInDownRight">rotateInDownRight</option>
										  <option value="rollIn">rollIn</option>
										  <option value="zoomIn">zoomIn</option>
										  <option value="zoomInDown">zoomInDown</option>
										  <option value="zoomInUp">zoomInUp</option>
									  </select>
	                          		</div>
	                          	</div>


	                          <div class="af-user-list-row">
	                          		<div class="af-label"><?php esc_html_e('Animation Slide Out', 'openaffiliates');?></div>
	                          		<div class="af-field">
	                                    <select onChange="afPreviewUList();" id="animation_out">
										  <option value="none">None</option>
										  <option value="fadeOut">fadeOut</option>
										  <option value="fadeOutDown">fadeOutDown</option>
										  <option value="fadeOutUp">fadeOutUp</option>
										  <option value="slideOutDown">slideOutDown</option>
										  <option value="slideOutUp">slideOutUp</option>
										  <option value="flip">flip</option>
										  <option value="flipOutX">flipOutX</option>
										  <option value="flipOutY">flipOutY</option>
										  <option value="bounceOut">bounceOut</option>
										  <option value="bounceOutDown">bounceOutDown</option>
										  <option value="bounceOutUp">bounceOutUp</option>
										  <option value="rotateOut">rotateOut</option>
										  <option value="rotateOutUpLeft">rotateOutUpLeft</option>
										  <option value="rotateOutUpRight">rotateOutUpRight</option>
										  <option value="rollOut">rollOut</option>
										  <option value="zoomOut">zoomOut</option>
										  <option value="zoomOutDown">zoomOutDown</option>
										  <option value="zoomOutUp">zoomOutUp</option>
									  </select>
	                          		</div>
	                          </div>
							</div>
							<div class="splt-2">

								<div class="af-user-list-row">
	                          		<div class="af-label"><?php esc_html_e('Additional Options', 'openaffiliates');?></div>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['bullets'])) ? '' : 'checked';?>
									<input type="checkbox" id="bullets" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Bullets", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['nav_button'])) ? '' : 'checked';?>
									<input type="checkbox" id="nav_button" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Nav Button", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['autoplay'])) ? '' : 'checked';?>
									<input type="checkbox" id="autoplay" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("AutoPlay", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['stop_hover'])) ? '' : 'checked';?>
									<input type="checkbox" id="stop_hover" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Stop On Hover", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['responsive'])) ? '' : 'checked';?>
									<input type="checkbox" id="responsive" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Responsive", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['autoheight'])) ? '' : 'checked';?>
									<input type="checkbox" id="autoheight" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Auto Height", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['lazy_load'])) ? '' : 'checked';?>
									<input type="checkbox" id="lazy_load" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Lazy Load", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
								<div class="af-user-list-row">
									<label class="af-checkbox-wrapp">
									<?php $checked = (empty($meta_arr['loop'])) ? '' : 'checked';?>
									<input type="checkbox" id="loop" onClick="afPreviewUList();" <?php echo esc_attr($checked);?> /> <?php esc_html_e("Play in Loop", 'openaffiliates');?>
									<span class="af-checkmark"></span>
								</label>
								</div>
							</div>

		        			<div class="clear"></div>
							</div>
						</div>
					</div>
					<!-- /SLIDER -->
		        <div class="clear"></div>
					<!-- ENTRY INFO -->
					<div class="af-column column-two af-column-two">
                  		<h4 class="af-top-affiliates-box4-background"><i class="fa-af fa-icon-entryinfo-af"></i><?php esc_html_e('Displayed User Fields', 'openaffiliates');?></h4>
				  		<div class="af-settings-inner">
				  			<div class="af-user-list-row">
				  				<?php
				  					$fields = array('user_login' => 'Username',
				  									'af_avatar' => 'Avatar',
				  									'user_email' => 'Email',
				  									'first_name'=>'First Name',
				  									'last_name' => 'Last Name',
				  									'earnings' => esc_html__('Earnings', 'openaffiliates'),
				  									'referrals' => esc_html__('Referrals', 'openaffiliates'),
				  									'visits' => esc_html__('Visits', 'openaffiliates'),
				  									);
									$green_color = array('earnings', 'referrals', 'visits');
				  					$defaults = explode(',', $meta_arr['user_fields']);
									global $af_db;
									$reg_fields = $af_db->register_get_custom_fields();

				  					$exclude = array('pass1', 'pass2', 'tos', 'recaptcha', 'confirm_email');
									foreach ($reg_fields as $k=>$v){
										if (!in_array($v['name'], $exclude)){
											if (isset($v['native_wp']) && $v['native_wp']){
												$extra_fields[$v['name']] = esc_html__($v['label'], 'openaffiliates');
											} else {
												$extra_fields[$v['name']] = $v['label'];
											}
											if (empty($extra_fields[$v['name']])){
												unset($extra_fields[$v['name']]);
											}
										}
									}

				  					$fields_arr = array_merge($fields, $extra_fields);

				  					foreach ($fields_arr as $k=>$v){
				  						$checked = (in_array($k, $defaults)) ? 'checked' : '';
				  						$color = (in_array($v, $fields)) ? '0a9fd8' : '000000';
				  						if (in_array($k, $green_color)){
				  							$color = '0bb586';
				  						}
				  						?>
				  						<div class="af-memberslist-fields af-top-affiliates-fields-color-<?php echo esc_attr($color);?>">
												<label class="af-checkbox-wrapp">
												<input type="checkbox" <?php echo esc_attr($checked);?> value="<?php echo esc_attr($k);?>" onClick="afMakeInputhString(this, '<?php echo esc_attr($k);?>', '#user_fields');afPreviewUList();" /> <?php echo esc_html($v);?>
												<span class="af-checkmark"></span>
											</label>
											</div>
				  						<?php
				  					}
				  				?>
				  				<input type="hidden" value="<?php echo esc_attr($meta_arr['user_fields']);?>" id="user_fields" />
				  			</div>
				  		</div>
				  	</div>
					<!-- /ENTRY INFO -->
				</div>
		        <div class="clear"></div>
			</div>

			<div class="af-user-list-shortcode-wrapp">
		        <div class="content-shortcode">
		            <div>
		                <span class="af-top-affiliates-shortcode-wrapper"><?php echo esc_html__('ShortCode :', 'openaffiliates');?> </span>
		                <span class="the-shortcode"></span>
		            </div>
		            <div class="af-code-warpper">
		                <span  class="af-top-affiliates-shortcode-wrapper"><?php echo esc_html__('PHP Code:', 'openaffiliates');?> </span>
		                <span class="php-code"></span>
		            </div>
		        </div>
		    </div>

	    	<div class="af-user-list-preview">
			    <div class="box-title">
			        <h2><i class="fa-af fa-icon-eyes-af"></i><?php echo esc_html__('Preview', 'openaffiliates');?></h2>
			            <div class="actions-preview pointer">
						    <a id="af_js_toggle_preview" onclick="" class="btn btn-mini content-slideUp">
			                    <i class="fa-af fa-icon-cogs-af"></i>
			                </a>
						</div>
			        <div class="clear"></div>
			    </div>
			    <div id="preview" class="af-preview"></div>
			</div>
		</div>
	</div>

<?php
