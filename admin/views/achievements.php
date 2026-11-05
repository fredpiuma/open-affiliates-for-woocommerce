<div class="af-wrapper">
<div class="af-page-title">Open Affiliates - <span class="second-text"><?php esc_html_e('Achievements', 'openaffiliates');?></span></div>
<div class="af-special-box">
	<form  method="post">

		<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

		<?php esc_html_e('Affiliate Username: ', 'openaffiliates');?> <input type="text" name="affiliate_username" value="<?php echo isset($_POST['affiliate_username']) ? $_POST['affiliate_username'] : '';?>" class="af-achievement-aff"/>
		<input type="submit" value="<?php esc_html_e('Search', 'openaffiliates');?>" name="search" class="button button-primary button-large" />
	</form>
</div>


<div class="af-stuffbox">
	<h3 class="af-h3"><?php esc_html_e('Last 50 Achievements', 'openaffiliates');?></h3>
	<div class="inside">
	<?php
		if (!empty($data['history'])):
			foreach ($data['history'] as $item):
				$current = (empty($item['current_rank'])) ? esc_html__('None', 'openaffiliates') : $item['current_rank'];
				$prev = (empty($item['prev_rank'])) ? esc_html__('None', 'openaffiliates') : $item['prev_rank'];
				?>
				<div class="af-achievement"><?php echo esc_html__('On', 'openaffiliates') . ' ' . $item['add_date'] . ' <b>' . $item['username'] . '</b> ' . esc_html__('has moved from ', 'openaffiliates') . $prev . ' ' . esc_html__('to', 'openaffiliates') . ' ' . $current;?>.</div>
				<?php
			endforeach;
		endif;
	?>
	</div>
</div>
</div>
