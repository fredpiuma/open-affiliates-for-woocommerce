<div class="af-js-general-messages"
data-referrals="<?php esc_html_e('Are you sure you want to delete this Referral?', 'openaffiliates');?>"
data-general_delete="<?php esc_html_e('Delete This ', 'openaffiliates');?>"
data-affiliates="<?php esc_html_e('Delete selected Affiliates', 'openaffiliates');?>"
data-email_server_check="<?php esc_html_e('An E-mail was sent to your Admin address. Check your inbox or Spam/Junk Folder!', 'openaffiliates');?>"
></div>

<div class="af-dashboard-wrap">
	<div class="af-admin-header">
		<div class="af-top-menu-section">
			<div class="af-dashboard-logo">
			<a href="<?php echo esc_url($data['base_url'] . '&tab=dashboard');?>">
				<img src="<?php echo esc_url(AF_URL . 'assets/images/open-affiliates-logo.svg');?>" alt="Open Affiliates"/>
				<div class="af-plugin-version"><?php echo esc_html($plugin_vs); ?></div>
			</a>
			</div>
			<div class="af-dashboard-menu">
				<div class="af-admin-mobile-bttn-wrapp"><i class="af-admin-mobile-bttn"></i></div>
				<ul class="af-dashboard-menu-items">
					<?php foreach ($data['menu_items'] as $k=>$v) :?>
						<?php $selected = ($data['tab']==$k) ? 'selected' : '';?>
								<li class="<?php echo esc_attr($selected);?>">
									<?php
										$dezactivated_class ='';
										$url = $data['base_url'] . '&tab=' . $k;
										if ($k=='affiliates' && !empty($data['affiliates_notification_count'])){
											echo esc_af_content('<div class="af-dashboard-notification-top">' . esc_html($data['affiliates_notification_count']) . '</div>');
										} else if ($k=='referrals' && !empty($data['referrals_notification_count'])){
											echo esc_af_content('<div class="af-dashboard-notification-top">' . esc_html($data['referrals_notification_count']) . '</div>');
										}
									?>
									<a href="<?php echo esc_url($url);?>" title="<?php echo esc_attr($v);?>">
										<div class="af-page-title link-<?php echo esc_attr($k); ?>  <?php echo esc_attr($dezactivated_class);?>">
											<i class="fa-af fa-af-menu fa-<?php echo esc_attr($k);?>-af"></i>
											<div><?php echo esc_html($v);?></div>
										</div>
									</a>
								</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	</div>


<div class="af-right-menu">
	<?php
		foreach ($data['right_tabs'] as $k=>$v){
		?>
		<div class="af-right-menu-item">
			<a href="<?php echo esc_url($data['base_url']  . '&tab=' . $k);?>" title="<?php echo esc_attr($v);?>">
				<div class="af-page-title-right-menu">
					<i class="fa-af fa-af-menu fa-<?php echo esc_attr($k);?>-af"></i>
					<div class="af-right-menu-title"><?php echo esc_html($v);?></div>
				</div>
			</a>
		</div>
		<?php
		}
	?>
</div>
<?php do_action('af_admin_action_dashboard_after_header');?>
