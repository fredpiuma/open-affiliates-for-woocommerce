<div>
	<h2>Open Affiliates</h2>
	<p><?php esc_html_e('This section enables administrators to manage affiliate-related settings', 'openaffiliates');?></p>
	<label class="af-edit-wp-user-label"><?php esc_html_e('Affiliate Actions', 'openaffiliates');?></label>
	<div class="af-edit-wp-user-status">
		<?php if ($data['is_affiliate']): ?>

			<div>
				<button type="button" class="button button-secondary" onclick="afMakeAffiliateSimpleUser(<?php echo esc_attr($data['id']);?>);"><?php esc_html_e('Revert from Affiliate Program', 'openaffiliates');?></button>
			</div>
		<?php else:?>
			<button type="button" class="button button-secondary" onclick="afMakeUserAffiliate(<?php echo esc_attr($data['id']);?>);"><?php esc_html_e('Convert to Affiliate', 'openaffiliates');?></button>
		<?php endif?>
	</div>
</div>
