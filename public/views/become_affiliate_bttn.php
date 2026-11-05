<?php if ( $data['show_button'] ):?>
<div class="af-become-affiliate-wrapp">
	<button class="af-become-affiliate-bttn" onclick="afBecomeAffiliatePublic();"><?php esc_html_e('Become an Affiliate', 'openaffiliates');?></button>
</div>
<?php else :?>
		<?php if ( $data['warning_message'] ):?>
				<p><?php echo esc_af_content($data['warning_message']);?></p>
		<?php endif;?>
<?php endif;?>
