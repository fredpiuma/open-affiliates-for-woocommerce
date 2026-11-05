	<div class="af-stuffbox">
		<h3 class="af-h3">
			<?php esc_html_e('Main ShortCodes', 'openaffiliates');?>
		</h3>
		<div class="inside">
			<div class="af-popup-content help-shortcodes af-text-align-center">
        	<div class="af-showcases-wrapper">
	            <div class="af-popup-shortcodevalue"><i class="fa-af fa-user-plus-af"></i><?php esc_html_e('Register Form', 'openaffiliates');?><span>[af-register]</span></div>
	            <div class="af-popup-shortcodevalue"><i class="fa-af fa-sign-in-af"></i><?php esc_html_e('Login Form', 'openaffiliates');?><span>[af-login-form]</span></div>
	            <div class="af-popup-shortcodevalue"><i class="fa-af fa-sign-out-af"></i><?php esc_html_e('Logout Button', 'openaffiliates');?><span>[af-logout]</span></div>
	            <div class="af-popup-shortcodevalue"><i class="fa-af fa-unlock-af"></i><?php esc_html_e('Password Recovery', 'openaffiliates');?><span>[af-reset-password]</span></div>
	            <div class="af-popup-shortcodevalue"><i class="fa-af fa-user-af"></i><?php esc_html_e('Affiliate Portal', 'openaffiliates');?><span>[af-account-page]</span></div>
				<div class="af-clear"></div>
        	</div>
    	</div>
			<div class="clear"></div>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3">
			<?php esc_html_e('Affiliate Data ShortCodes', 'openaffiliates');?>
		</h3>
		<div class="inside">
			<div class="af-popup-content help-shortcodes">
				<table class="wp-list-table widefat fixed tags af-manage-user-expire af-shortcodes-table">
				<thead>
					<tr>
						<th><?php esc_html_e('Affiliate Field', 'openaffiliates');?></th>
						<th><?php esc_html_e('Current Logged Affiliate Shortcode', 'openaffiliates');?></th>
						<th><?php esc_html_e('Based on Affiliate Link Shortcode', 'openaffiliates');?></th>
					</tr>
				</thead>
				<tbody>
		       	<?php
				$constants = array(	"username",
									"first_name",
									"last_name",
									"user_id",
									"affiliate_id",
									"user_email",
									"account_page",
									"login_page",
									"blogname",
									"blogurl",
									"siteurl",
									'rank_id',
									'rank_name',
									'user_url,',
									'af_avatar',
				);
		       	foreach ($constants as $k=>$v){
		       		?>
					<tr>
						<td><?php echo esc_html($v);?></td>
						<td>[af-affiliate field="<?php echo esc_html($v);?>"]</td>
		       			<td>[af-public-affiliate-info field="<?php echo esc_html($v);?>"]</td>
					</tr>
		       		<?php
		       	}
		       	$custom_fields = af_get_custom_constant_fields();
		       	foreach ($custom_fields as $k=>$v){
		       		$k = str_replace('{', '', $k);
		       		$k = str_replace('}', '', $k);
		       		?>
		       			<tr>
		       				<td><?php echo esc_html($v);?></td>
		       				<td>[af-affiliate field="<?php echo esc_html($k);?>"]</td>
		       				<td>[af-public-affiliate-info field="<?php echo esc_html($k);?>"]</td>
		       			</tr>
		       		<?php
		       	}
		       	?>
		       	</tbody></table>
	    	</div>
			<div class="af-clear"></div>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3">
			<?php esc_html_e('Additional ShortCodes', 'openaffiliates');?>
		</h3>
		<div class="inside">
			<div class="af-popup-content help-shortcodes">
            <table class="wp-list-table widefat fixed tags af-manage-user-expire af-shortcodes-table">
				<thead>
					<tr>
						<th><?php esc_html_e('ShortCode', 'openaffiliates');?></th>
						<th><?php esc_html_e('What it does', 'openaffiliates');?></th>
						<th><?php esc_html_e('Arguments available', 'openaffiliates');?></th>
					</tr>
				</thead>
				<tbody>
                		<tr>
		       				<td><strong>[af-user-become-affiliate]</strong></td>
		       				<td><?php esc_html_e('User Become Affiliate Button', 'openaffiliates');?></td>
		       				<td>-</td>
		       			</tr>
                        <tr>
		       				<td><strong>[af-if-affiliate]<i><?php esc_html_e('Your content here!', 'openaffiliates');?> </i>[/af-if-affiliate]</strong></td>
		       				<td><?php esc_html_e('Show content only for affiliate users.', 'openaffiliates');?></td>
		       				<td>-</td>
		       			</tr>
                        <tr>
		       				<td><strong>[af-if-not-affiliate]<i><?php esc_html_e('Your content here!', 'openaffiliates');?> </i>[/af-if-not-affiliate]</strong></td>
		       				<td><?php esc_html_e('Show content only for non-affiliate users.', 'openaffiliates');?></td>
		       				<td>-</td>
		       			</tr>
                         <tr>
		       				<td><strong>[af-visitor-referred]<i><?php esc_html_e('Your content here!', 'openaffiliates');?> </i>[/af-visitor-referred]</strong></td>
		       				<td><?php esc_html_e('Show content only for referred users.', 'openaffiliates');?></td>
		       				<td>-</td>
		       			</tr>
                        <tr>
		       				<td><strong>[af-visitor-not-referred]<i><?php esc_html_e('Your content here!', 'openaffiliates');?> </i>[/af-visitor-not-referred]</strong></td>
		       				<td><?php esc_html_e('Show content only for non-referred users.', 'openaffiliates');?></td>
		       				<td>-</td>
		       			</tr>
                </tbody>
            </table>

    	</div>
			<div class="clear"></div>
		</div>
	</div>
