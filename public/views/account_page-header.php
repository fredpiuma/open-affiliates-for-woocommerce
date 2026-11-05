<?php
	$custom_css = ''
 ?>

<?php foreach ($data['available_tabs'] as $k=>$v):
        if ( !isset( $v['af_tab_' . $k . '_icon_code'] ) || $v['af_tab_' . $k . '_icon_code'] === ''|| $v['af_tab_' . $k . '_icon_code'] === false ){ continue;}
	$custom_css .= ".fa-" . $k . "-account-af:before{".
		"content:'\\".$v['af_tab_' . $k . '_icon_code']."';".
	"}";
endforeach;?>

<?php   if (!empty($data['af_account_page_custom_css'])){
	 $custom_css .= $data['af_account_page_custom_css'];
}?>
<?php wp_enqueue_style( 'af-croppic_css', AF_URL . 'assets/css/croppic.css', array(), '9.4' );?>
<?php wp_enqueue_script( 'af-jquery_mousewheel', AF_URL . 'assets/js/jquery.mousewheel.min.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-croppic', AF_URL . 'assets/js/croppic.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-account_page-banner', AF_URL . 'assets/js/account_page-banner.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_style('af_font_awesome', AF_URL . 'assets/css/font-awesome.min.css');?>

<div class="af-js-account-page-header-details" data-af_url="<?php echo AF_URL;?>" data-nonce="<?php echo wp_create_nonce( 'publicn' );?>"></div>


<?php if(isset($data['rank']['color'])){
	$custom_css .= "
	.af-user-page-top-wrapper .af-top-rank-box{
		background-color:#".$data['rank']['color'].";
	}";
 }
if(isset($data['achieved'])){
	$custom_css .= "
	.af-user-page-top-wrapper .af-top-achievement .af-achieved{
		width:".$data['achieved']."%;
	}";
}
?>
<?php
wp_register_style( 'dummy-handle', false );
wp_enqueue_style( 'dummy-handle' );
wp_add_inline_style( 'dummy-handle', $custom_css );
 ?>

<div class="af-user-page-wrapper">
<?php
if(isset($data['preview'])){?>
	<div class="af-warning-box">
		<?php echo esc_html__('This is a Preview of the Affiliate Portal, as if the affiliate themselves were viewing their own portal. As an administrator, you cannot submit or change data through preview.', 'openaffiliates'); ?>
	</div>
<?php }
	$top_class='';
	if (!empty($data['avatar']) && ($data['af_ap_top_theme'] == 'af-ap-top-theme-2')){
		 $top_class .=' af-ap-top-theme-2-avatar-extra-padding';
	}
	if (!empty($data['top-background']) && ($data['af_ap_top_theme'] == 'af-ap-top-theme-2')){
		 $top_class .=' af-ap-top-theme-2-banner-extra-padding';
	}
	if (!empty($data['avatar']) && ($data['af_ap_top_theme'] == 'af-ap-top-theme-3' )){
		 $top_class .=' af-ap-top-theme-3-avatar-extra-padding';
	}
	if (!empty($data['top-background']) && ($data['af_ap_top_theme'] == 'af-ap-top-theme-3' )){
		 $top_class .=' af-ap-top-theme-3-banner-extra-padding';
	}
	 ?>
<div class="af-user-page-top-wrapper  <?php echo (!empty($data['af_ap_top_theme']) ? $data['af_ap_top_theme'] : '');?> <?php echo esc_attr($top_class);?> ">

  <div class="af-left-side">
	<div class="af-user-page-details">
		<?php if (!empty($data['avatar'])):?>
			<div class="af-user-page-avatar"><img src="<?php echo esc_attr($data['avatar']);?>" alt="Avatar" class="af-member-photo"/></div>
		<?php endif;?>
	 </div>
	</div>
	<?php
	$top_class ='';
	if (empty($data['top-background']) &&!empty($data['avatar'])){
		$top_class =' af-ap-top-theme-3-middle-padding';
	}
		?>
	<div class="af-middle-side <?php echo esc_attr($top_class);?>">
		<div class="af-account-page-top-mess"><?php echo do_shortcode($data['message']);?></div>
		<?php if (!empty($data['top-rank']) && !empty($data['rank'])):?>
		<div class="af-top-rank">
			<?php
					$data['rank']['label'] = apply_filters(
													'wpml_translate_single_string',
													$current_rank['label'],
													'openaffiliates',
													'rank_name_' . $data['rank']['id'],
													apply_filters( 'wpml_current_language', NULL )
					);
					$atype = '%';
					if($data['rank']['amount_type'] == 'flat'):
						$atype = afCurrency($data['stats']['currency']);
					endif;
			?>
			<div class="af-top-rank-box" title="<?php echo esc_attr($data['rank']['amount_value'].$atype).' '.esc_html__('reward', 'openaffiliates');?>"><?php echo esc_html($data['rank']['label']);?></div>
		</div>
		<?php endif;?>
	</div>
	<?php
	if (!empty($data['af_ap_top_theme']) && ($data['af_ap_top_theme'] == 'af-ap-top-theme-3' )){
		 echo '<div class="af-clear af-special-clear"></div>';
	}
	 ?>
		<?php if (!empty($data['top-earning']) || !empty($data['top-referrals']) || !empty($data['top-achievement']) || !empty($data['top-rank']) || !empty($data['af_ap_edit_show_metrics'])):?>
	<div class="af-right-side">
		<?php if (!empty($data['top-earning'])):?>
			<div class="af-top-earnings">
				<div class="af-stats-label"><?php echo esc_html__('Earnings', 'openaffiliates'); ?></div>
				<div class="af-stats-content"> <?php echo af_format_price_and_currency(afCurrency($data['stats']['currency']), round($data['stats']['paid_payments_value']+$data['stats']['unpaid_payments_value'], 2)); ?></div>
			</div>
		<?php endif;?>
		<?php if (!empty($data['top-referrals'])):?>
			<div class="af-top-referrals">
				<div class="af-stats-label"><?php echo esc_html__('Referrals', 'openaffiliates'); ?></div>
				<div class="af-stats-content"> <?php echo esc_html($data['stats']['referrals']); ?></div>
			</div>
		<?php endif;?>


		<?php if (!empty($data['top-achievement']) && $data['achieved']>-1 && isset($data['next_rank'])):?>
			<div class="af-clear af-special-clear"></div>
            <?php if(!empty($data['next_rank'])){ ?>
                <div class="af-top-achievement">
                <?php
                    $atype = '%';
                        if($data['next_rank']->amount_type == 'flat'):
                            $atype = afCurrency($data['stats']['currency']);
                        endif;
                ?>
                    <div class="af-stats-label"><?php echo esc_html__('Until', 'openaffiliates'); ?> <strong title="<?php echo esc_attr($data['next_rank']->amount_value.$atype).' '.esc_html__('reward', 'openaffiliates');?>"> <?php echo esc_attr($data['next_rank']->label); ?></strong> <?php echo esc_html__('Rank...', 'openaffiliates'); ?></div>
                    <div class="af-achievement-line" title="<?php echo esc_attr($data['achieved'].'% ').esc_html__('achieved', 'openaffiliates'); ?>">
                        <div class="af-achieved"></div>
                    </div>
                </div>
            <?php } ?>
            <div class="af-clear af-special-clear"></div>
		<?php endif;?>
        <?php if (!empty($data['af_ap_edit_show_metrics'])):?>
			<div class="af-top-metrics">
				<div class="af-stats-content">
					<div class="af-metris-rightside">
						<div>
								<?php echo esc_html__('3 months EPC: ', 'openaffiliates');
								echo af_format_price_and_currency(afCurrency($data['stats']['currency']), $data['metrics'][3]); ?>
						</div>
						<div>
								<?php echo esc_html__('7 days EPC: ', 'openaffiliates');
								echo af_format_price_and_currency(afCurrency($data['stats']['currency']), $data['metrics'][7]); ;?>
						</div>
					</div>
				</div>
			</div>
            <div class="af-clear af-special-clear"></div>
		<?php endif;?>

		<div class="af-clear"></div>
	</div>
<?php endif;?>

	<div class="af-clear"></div>
	<?php if (!empty($data['top-background'])):

		///
		$bkStyl = '';
		$banner = '';
		if (!empty($data['af_account_page_personal_header'])):
				$banner = $data ['af_account_page_personal_header'];
		endif;

		if (empty($banner) && !empty($data ['top_banner'])):
			$banner = $data ['top_banner'];
		elseif (empty($banner) && !empty($data ['top-background-image'])):
			$banner = $data ['top-background-image'];
		endif;

		if (!empty($banner)){
			wp_add_inline_style( 'dummy-handle', ".af-user-page-top-background{
						background-image:url('" . esc_url($banner) . "') !important;
			}" );
		}



		///
	?>
  <div class="af-user-page-top-background" data-banner="<?php echo esc_attr($banner);?>">
			<div class="af-edit-top-ap-banner" id="js_af_edit_top_ap_banner"></div>
	</div>
  <?php endif;?>
</div>
<div class="af-user-page-content-wrapper <?php echo esc_attr($data['af_ap_theme']);?>">


<?php //=================================== TABS ====================================//?>

<?php
$tabs = array(
					'overview' => array(
						'type' => 'tab',
						'label' => esc_html__('Dashboard', 'openaffiliates'),
						'slug' => 'overview',
						'print_link' => TRUE,
						'icon_code' => '',
					),
					'profile' => array(
						'type' => 'tab',
						'label' => esc_html__('Profile', 'openaffiliates'),
						'slug' => 'profile',
						'icon_code' => '',
						'print_link' => FALSE,
						'children' => array(
											'edit_account' => array(
												'type' => 'subtab',
												'label' => esc_html__('Edit Account', 'openaffiliates'),
												'slug' => 'edit_account',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'profile',
											),
											'change_pass' => array(
												'type' => 'subtab',
												'label' => esc_html__('Change Password', 'openaffiliates'),
												'slug' => 'change_pass',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'profile',
											),
											'payments_settings' => array(
												'type' => 'subtab',
												'label' => esc_html__('Payment Settings', 'openaffiliates'),
												'slug' => 'payments_settings',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'profile',
											),
											'custom_affiliate_slug' => array(
												'type' => 'subtab',
												'label' => esc_html__('Custom Affiliate Slug', 'openaffiliates'),
												'slug' => 'custom_affiliate_slug',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'profile',
											),
											'pushover_notifications' => array(
												'type' => 'subtab',
												'label' => esc_html__('Pushover Notifications', 'openaffiliates'),
												'slug' => 'pushover_notifications',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'profile',
											),
						),
					),
					'marketing' => array(
						'type' => 'tab',
						'label' => esc_html__('Marketing', 'openaffiliates'),
						'slug' => 'marketing',
						'print_link' => FALSE,
						'icon_code' => '',
						'children' =>	array(
											'affiliate_link' => array(
												'type' => 'subtab',
												'label' => esc_html__('Affiliate Links', 'openaffiliates'),
												'slug' => 'affiliate_link',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'marketing',
											),
					  						'simple_links' => array(
												'type' => 'subtab',
												'label' => esc_html__('Referrer Links', 'openaffiliates'),
												'slug' => 'simple_links',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'marketing',
											),
					  						'campaigns' => array(
												'type' => 'subtab',
												'label' => esc_html__('Campaigns', 'openaffiliates'),
												'slug' => 'campaigns',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'marketing',
											),
											'banners' => array(
												'type' => 'subtab',
												'label' => esc_html__('Banners', 'openaffiliates'),
												'slug' => 'banners',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'marketing',
											),
											'landing_pages' => array(
												'type' => 'subtab',
												'label' => esc_html__('Your Landing Pages', 'openaffiliates'),
												'slug' => 'landing_pages',
												'print_link' => true,
												'icon_code' => '',
												'parent' => 'marketing',
											),
											'coupons' => array(
												'type' => 'subtab',
												'label' => esc_html__('Coupons', 'openaffiliates'),
												'slug' => 'coupons',
												'icon_code' => '',
												'print_link' => TRUE,
												'parent' => 'marketing',
											),
											'product_links'	=> array(
												'type' 				=> 'subtab',
												'label' 			=> esc_html__('Product Links', 'openaffiliates'),
												'slug' 				=> 'product_links',
												'icon_code' 	=> '',
												'print_link' 	=> TRUE,
												'parent' 			=> 'marketing',
											),
						)
					),
					'referrals' => array(
						'type' => 'tab',
						'label' => esc_html__('Statements', 'openaffiliates'),
						'slug' => 'referrals',
						'print_link' => TRUE,
						'icon_code' => '',
					),
					'payments' => array(
						'type' => 'tab',
						'label' => esc_html__('Earnings', 'openaffiliates'),
						'slug' => 'payments',
						'print_link' => TRUE,
						'icon_code' => '',
					),
					'wallet' => array(
						'type' => 'tab',
						'label' => esc_html__('Wallet', 'openaffiliates'),
						'slug' => 'wallet',
						'print_link' => TRUE,
						'icon_code' => '',
					),
					'main_reports' => array(
						'type' => 'tab',
						'label' => esc_html__('Reports', 'openaffiliates'),
						'slug' => 'main_reports',
						'icon_code' => '',
						'print_link' => FALSE,
						'children' => array(
					  						'reports' => array(
												'type' => 'subtab',
												'label' => esc_html__('Reports', 'openaffiliates'),
												'slug' => 'reports',
												'print_link' => TRUE,
												'icon_code' => '',
												'parent' => 'reports',
											),
					  					  	'visits' => array(
												'type' => 'subtab',
												'label' => esc_html__('Traffic Log', 'openaffiliates'),
												'slug' => 'visits',
												'print_link' => TRUE,
												'icon_code' => '',
												'parent' => 'reports',
											),
										  	'campaign_reports' => array(
												'type' => 'subtab',
												'label' => esc_html__('Campaign Reports', 'openaffiliates'),
												'slug' => 'campaign_reports',
												'print_link' => TRUE,
												'icon_code' => '',
												'parent' => 'reports',
											),
										  	'referrals_history' => array(
												'type' => 'subtab',
												'label' => esc_html__('Referrals History', 'openaffiliates'),
												'slug' => 'referrals_history',
												'print_link' => TRUE,
												'icon_code' => '',
												'parent' => 'reports',
											),
										  	'mlm' => array(
												'type' => 'subtab',
												'label' => esc_html__('Multi-Level Marketing', 'openaffiliates'),
												'slug' => 'mlm',
												'print_link' => TRUE,
												'icon_code' => '',
												'parent' => 'reports',
											),
						)
					),
					'info_affiliate_bar' => array(
								'type' => 'tab',
								'label' => get_option('af_tab_info_affiliate_bar_menu_label') ? get_option('af_tab_info_affiliate_bar_menu_label') : esc_html__('Affiliate FlashBar', 'openaffiliates'),
								'slug' => 'info_affiliate_bar',
								'icon_code' => '',
								'print_link' => FALSE,
								'children' => array(
										'iab_settings'     => array(
														'type'        => 'subtab',
														'label'       => esc_html__('Settings', 'openaffiliates'),
														'slug'        => 'iab_settings',
														'print_link'  => true,
														'icon_code'   => '',
														'parent'      => 'info_affiliate_bar',
										),
										'iab_tips'     => array(
														'type'        => 'tips',
														'label'       => esc_html__('Tips', 'openaffiliates'),
														'slug'        => 'iab_tips',
														'print_link'  => true,
														'icon_code'   => '',
														'parent'      => 'info_affiliate_bar',
										),
								),
					),
				    'referral_notifications' => array(
								'type' => 'tab',
								'label' => esc_html__('Notifications', 'openaffiliates'),
								'slug' => 'referral_notifications',
								'print_link' => TRUE,
								'icon_code' => '',
					),
					'help' => array(
						'type' => 'tab',
						'label' => esc_html__('Help', 'openaffiliates'),
						'slug' => 'help',
						'print_link' => TRUE,
						'icon_code' => '',
					),
					'logout' => array(
						'type' => 'tab',
						'label' => esc_html__('LogOut', 'openaffiliates'),
						'slug' => 'logout',
						'print_link' => TRUE,
						'icon_code' => '',
					),
);

foreach ($custom_menu as $temp_k=>$temp_arr){
	if (emptY($temp_arr['type'])){
		$custom_menu[$temp_k]['type'] = 'tab';
	}
}
$tabs = array_merge($tabs, $custom_menu);
$tabs = af_reorder_menu_items($order, $tabs);


$selected_parent = '';
foreach ($tabs as $first_slug => $array){
	/// exclude item

	if (in_array($first_slug, $exclude_tabs)){
		unset($tabs[$first_slug]);
		continue;
	} else if (isset($array['children'])){
		/// parent check
		foreach ($array['children'] as $children_slug => $children_array){
			if (in_array($children_slug, $exclude_tabs)){
				unset($tabs[$first_slug]['children'][$children_slug]);
			} else if (!in_array($children_slug, $data['show_tab_list'])){
				unset($tabs[$first_slug]['children'][$children_slug]);
			}
		}
		if (count($tabs[$first_slug]['children'])==0){
			unset($tabs[$first_slug]);
			continue;
		}
	} else if (!in_array($first_slug, $data['show_tab_list'])){
		unset($tabs[$first_slug]);
		continue;
	}

	///// UPDATE MENU LABEL
	if (!empty($this->account_page_settings['af_tab_' . $first_slug . '_menu_label'])){
		$tabs[$first_slug]['label'] = $this->account_page_settings['af_tab_' . $first_slug . '_menu_label'];
	}

	if (!empty($tabs[$first_slug]['children'])){
		foreach ($tabs[$first_slug]['children'] as $second_slug => $second_array){

			/// exclude item
			if (in_array($second_slug, $exclude_tabs)){
				unset($tabs[$first_slug]['children'][$second_slug]);
				continue;
			} else if (!in_array($second_slug, $data['show_tab_list'])){
				unset($tabs[$first_slug]['children'][$second_slug]);
			}

			//// SET THE SELECTED PARENT
			if ($second_slug==$data['selected_tab']){
				$selected_parent = $second_array['parent'];
			}

			///// UPDATE MENU LABEL
			if (!empty($this->account_page_settings['af_tab_' . $second_slug . '_menu_label'])){
				$tabs[$first_slug]['children'][$second_slug]['label'] = $this->account_page_settings['af_tab_' . $second_slug . '_menu_label'];
			}
		}
	}
}

//// DO REORDER MENU ITEMS
?>
		<div class="af-ap-menu">
			<ul>
				<?php foreach ($tabs as $slug => $array) : ?>
			        <?php if ($array['type'] == 'tab'):
							if (!empty($array['children'])){
			        			if ($selected_parent==$slug){
			        				$extra_styl = 'af-display-block';
			        				$i_class = 'fa-account-down-af';
									$tab_selected = ' af-ap-menu-tab-item-selected';
			        			} else {
			        				$extra_styl = '';
									$tab_selected = '';
			        				$i_class = 'fa-account-right-af';
			        			}
								if ($data['af_ap_theme']=='af-ap-theme-1'){
									$action = "onClick=afShowSubtabs('" . $slug . "');";
								} else {
									$action = "";
								}
			        ?>
								<li class="af-ap-submenu-item<?php echo esc_attr($tab_selected);?>"><div class="af-ap-menu-tab-item" <?php echo esc_attr($action);?> ><a href="javascript:void(0);"><i class="af-ap-menu-sign fa-af <?php echo esc_attr($i_class);?>" id="<?php echo esc_attr('af_fa_sign-' . $slug);?>"></i><?php echo esc_html($array['label']);?></a></div>
									<ul class="af-public-ap-menu-subtabs <?php echo esc_attr($extra_styl);?>" id="<?php echo esc_attr('af_public_ap_' . $slug);?>">
										<?php foreach ($array['children'] as $second_slug => $second_array): ?>
											<?php $extra_class = ($data['selected_tab']==$second_slug) ? 'af-ap-menu-item-selected' : '';?>
											<li class="af-ap-menu-item <?php echo esc_attr($extra_class);?>"><a href="<?php echo esc_url($data['urls'][$second_slug]);?>"><i class="<?php echo esc_attr('fa-af fa-' . $second_slug . '-account-af');?>"></i><?php
			        						  	echo esc_html($second_array['label']);
											?></a></li>
										<?php endforeach;?>
									</ul>
								</li>
						<?php } else { ?>

					  		<?php $extra_class = ($data['selected_tab']==$slug) ? 'af-ap-menu-tab-item-selected' : '';?>
						  	<li class="af-ap-menu-tab-item <?php echo esc_attr($extra_class);?>"><a href="<?php
										if ( empty( $array['af_tab_' . $slug . '_url'] ) ){
												echo esc_url($data['urls'][$slug]);
										} else {
												echo esc_url($array['af_tab_' . $slug . '_url']);
										}
								?>"><i class="<?php echo esc_attr('fa-af fa-' . $slug . '-account-af');?>"></i><?php
						  		echo esc_html($array['label']);
						  	?></a></li>
						<?php }?>

					<?php endif; ?>

				<?php endforeach;?>
			</ul>
		</div>

<?php //=================================== TABS ====================================//?>



<div class="af-user-page-content">
