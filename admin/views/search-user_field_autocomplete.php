<div class="af-autocomplete-field">
	<div class="col-xs-6">
		<?php if (!empty($attr['title'])):?>
		<h2><?php echo esc_af_content($attr['title']);?></h2>
		<?php endif;?>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1"><?php echo esc_html($attr['label']);?></span>
			<?php
				global $af_db;
				if ( !empty( $attr['value'] ) ){
						$mlmParentUsername =  $af_db->get_username_by_wpuid( $af_db->get_uid_by_affiliate_id( $attr['value'] ) );
				}
				$textName = isset( $attr['text_name'] ) ? "name='{$attr['text_name']}'" : '';
			?>
			<input type="text"  class="form-control" <?php echo esc_attr($textName);?> value="<?php echo ( isset( $mlmParentUsername ) ) ? $mlmParentUsername : '';?>" <?php echo esc_attr($attr['field_style']);?> id="usernames_search" />
			<input type="hidden" name="<?php echo esc_attr($attr['hidden_name']);?>" value="<?php echo ( isset( $attr['value'] ) ) ? $attr['value'] : '';?>" id="<?php echo esc_attr($attr['hidden_name']);?>" />
		</div>
	</div>
	<div class="af-clear"></div>
</div>
<?php
	//$url = AF_URL . 'admin/af-offers-ajax-autocomplete.php?users=true&without_all=true&afAdminAjaxNonce=' . wp_create_nonce( 'afAdminAjaxNonce' );
	$url = get_site_url() . '/wp-admin/admin-ajax.php?action=af_ajax_offers_autocomplete&users=true&without_all=true&afAdminAjaxNonce=' . wp_create_nonce( 'afAdminAjaxNonce' );
	if (!empty($attr['exclude_user_id'])){
		$url .= '&exclude_user=' . $attr['exclude_user_id'];
	}
?>
<span class="af-js-search-user-field-autocomplete" data-id="<?php echo esc_attr($attr['hidden_name']);?>" data-url="<?php echo esc_attr($url);?>" ></spam>
<?php
wp_enqueue_script( 'af-search-user-field-autocomplete', AF_URL . 'assets/js/search-user-field-autocomplete.js', ['jquery'], '9.4' );
?>
