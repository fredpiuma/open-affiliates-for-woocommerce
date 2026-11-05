<?php
if ( empty( $viaWpAjax ) ){
		require_once '../../../../wp-load.php';
		require_once '../utilities.php';
}


if ( !isset( $_GET['afAdminAjaxNonce'] ) || !wp_verify_nonce( $_GET['afAdminAjaxNonce'], 'afAdminAjaxNonce' ) ) {
		die( "Not allowed" );
}

if (!empty($_GET['term'])){
	global $af_db;

	if (!empty($_GET['source'])){
		/// SEARCH FOR PRODUCTS
		switch ($_GET['source']){
			case 'woo':
				$i = 0;
				$data = $af_db->search_woo_products($_GET['term']);
				if (!empty($data)){
					foreach ($data as $k=>$v){
						$return[] = [
															'id'						=> $k,
															'label'					=> $v,
						];
					}
				}
				$categories = $af_db->wooSearchCategory( $_GET['term'] );
				if ( $categories ){
						foreach ( $categories as $categoryObject ){
								$products = $af_db->wooGetProductsByCategory( $categoryObject->term_id );
								$return[] = [
																	'id'						=> $categoryObject->term_id,
																	'label'					=> $categoryObject->name . esc_html__( '(Category)', 'openaffiliates' ),
																	'is_category'		=> true,
																	'children'			=> $products
								];
						}
				}
				echo json_encode( $return );
				die;
				break;
			case 'ump':
				$data = $af_db->search_ump_levels($_GET['term']);
				break;
			case 'edd':
				$data = $af_db->search_edd_product($_GET['term']);
				break;
			case 'ulp':
				$data = $af_db->search_ulp_product($_GET['term']);
				break;
		}
	} else if (!empty($_GET['users'])){
		/// SEARCH FOR USERS
		$exclude_user = (empty($_GET['exclude_user'])) ? 0 : $_GET['exclude_user'];
		$data = $af_db->search_affiliates_by_char($_GET['term'], $exclude_user);
		if (empty($_GET['without_all'])){
			$data[-1] = 'All Affiliates';
		}
	}

	if (!empty($data)){
		$i = 0;
		foreach ($data as $k=>$v){
			$return[$i]['id'] = $k;
			$return[$i]['label'] = $v;
			$i++;
		}
		echo json_encode($return);
	}
}

die;
