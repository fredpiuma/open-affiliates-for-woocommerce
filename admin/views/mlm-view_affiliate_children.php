<?php
global $af_db;
if ( !isset( $affiliate_id ) ){
		$affiliate_id = $data['affiliate_id'];
}
if ( !isset( $affiliate_avatar ) ){
	  $affiliateuid = $af_db->get_uid_by_affiliate_id($affiliate_id);
		$affiliate_avatar = af_get_avatar_for_uid( $affiliateuid );
}
if ( !isset( $affiliate_full_name ) ){
		$affiliate_full_name = $af_db->get_full_name_of_user($affiliate_id);
}
?>
<div class="af-stuffbox">
	<h3 class="af-h3"><?php echo esc_html__('Display MLM Matrix');?></h3>
	<div class="inside">

	<?php if (!empty($data['items']) || !empty($data['parent'])):?>
		<?php
				if ( !isset( $data['parent_id'] ) ){
						$data['parent_id'] = '';
				}
				if ( !isset( $data['parent_avatar'] ) ){
						$data['parent_avatar'] = '';
				}
				if ( !isset( $data['parent_full_name'] ) ){
						$data['parent_full_name'] = '';
				}
				wp_enqueue_style( 'af-mlm-tree', AF_URL . 'assets/css/mlm-tree.css', [], '9.4' );
				wp_enqueue_script( 'af-mlm-tree', AF_URL . 'assets/js/mlm-tree.js', [], '9.4', true );
		?>

				<span class="af-js-mlm-view-affiliate-children-parent-data"
							data-parent_id='<?php echo esc_attr($data['parent_id']);?>'
							data-parent_avatar="<?php echo esc_af_content($data['parent_avatar']);?>"
							data-parent_full_name="<?php echo esc_attr($data['parent_full_name']);?>"
							data-parent="<?php echo esc_attr($data['parent']);?>"
				></span>

				<span class="af-js-mlm-view-affiliate-data"
							data-affiliate_id='<?php echo esc_attr($affiliate_id);?>'
							data-affiliate_avatar="<?php echo esc_attr($affiliate_avatar);?>"
							data-parent_full_name="<?php echo esc_attr($affiliate_full_name);?>"
				></span>


		<?php if ( !empty( $data['items'] ) ):?>
			<?php foreach ( $data['items'] as $item ):?>
					<span class="af-js-mlm-view-affiliate-children-data"
								data-avatar="<?php echo esc_af_content($item['avatar']);?>"
								data-full_name="<?php echo esc_attr($item['full_name']);?>"
								data-amount="<?php echo esc_attr($item['amount_value']) . esc_html__(' rewards', 'openaffiliates');?>"
								data-id="<?php echo esc_attr($item['id']);?>"
								data-parent_id="<?php echo esc_attr($item['parent_id']);?>"
					></span>
			<?php endforeach;?>
		<?php endif;?>

   <div id="af_mlm_chart"></div>

			<table class="af-dashboard-inside-table">
				<tbody>
					<tr>
						<th><?php esc_html_e('Subaffiliate', 'openaffiliates');?></th>
						<th><?php esc_html_e('Level', 'openaffiliates');?></th>
						<th><?php esc_html_e('Amount', 'openaffiliates');?></th>
					</tr>
					<?php foreach ($data['items'] as $item):?>
					<tr>
						<td><?php echo esc_html($item['username']);?></td>
						<td><?php echo esc_html($item['level']);?></td>
						<td><?php echo esc_html($item['amount_value']);?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php else : ?>
			<?php esc_html_e('Current Affiliate user has no other sub-affiliates into his MLM Matrix on this moment', 'openaffiliates');?>
		<?php endif;?>

	</div>
</div>
