
<div class="af-product-links-wrapper">
    <div class="af-product-links-search-bar-wrapper">
		<?php if ( $data['categories'] ):?>
            <div class="af-product-links-category">
                <select class="af-js-product-links-category">
                    <option value=""><?php esc_html_e( 'Choose category', 'openaffiliates' );?></option>
                    <?php foreach ( $data['categories'] as $categoryId => $categoryLabel ):?>
                        <option value="<?php echo esc_attr($categoryId);?>" ><?php echo esc_html($categoryLabel);?></option>
                    <?php endforeach;?>
                </select>
            </div>
        <?php endif;?>
        <div class="af-product-links-search-wrapper">
        <input type="text" placeholder="<?php esc_html_e( 'Search Products', 'openaffiliates' );?>" id="af_product_links_search_bar" class="af-product-links-search-bar" />
        </div>
        <div class="af-clear"></div>
    </div>
    <div class="af-product-links-extrasearch-wrapper">
    <div class="af-product-links-count-wrapper af-special-label">
    	<span class="af-product-links-count af-js-product-links-count">0</span><span><?php esc_html_e( ' Results', 'openaffiliates' );?></span>
    </div>
    <div class="af-product-links-order-wrapper">
    			<select class="af-js-product-links-order-type" >
                    <option value=""><?php esc_html_e( 'Default Sorting', 'openaffiliates' );?></option>
                    <option value="popularity"><?php esc_html_e( 'Sort by popularity', 'openaffiliates' );?></option>
                    <option value="date"><?php esc_html_e( 'Sort by newness', 'openaffiliates' );?></option>
                    <option value="price"><?php esc_html_e( 'Sort by price: low to high', 'openaffiliates' );?></option>
                    <option value="price-desc"><?php esc_html_e( 'Sort by price: high to low', 'openaffiliates' );?></option>
                </select>
    </div>
    <div class="af-clear"></div>
    </div>
    <div class="af-product-links-items-header">
    	<div class="af-single-product-image-wrapp">&nbsp;</div>
        <div class="af-single-product-name"><?php esc_html_e( 'Product', 'openaffiliates' );?></div>
        <div class="af-single-product-price"><?php esc_html_e( 'Price', 'openaffiliates' );?></div>
        <div class="af-single-product-rewards">
		 <?php if ( $data['showReward'] ):?>
				<?php esc_html_e( 'Rewards', 'openaffiliates' );?>
        <?php endif; ?>
        </div>
        <div class="af-single-product-link-wrapper">&nbsp;</div>
        <div class="af-clear"></div>
    </div>
    <div class="af-product-links-items-wrapper" data-load_more_label="<?php esc_html_e( 'Load More', 'openaffiliates' );?>" data-loading_more="<?php echo AF_URL . 'assets/images/loading.gif';?>">

    </div>
</div>
<?php if ( isset( $_GET['aid'] ) && (int)sanitize_text_field($_GET['aid']) > 0):?>
<div class="af-js-product-links-include-label" data-enabled="<?php echo base64_encode( json_encode( [ 0 => wp_create_nonce( 'afAdminPreviewPortal' ), 1 => sanitize_text_field($_GET['aid']) ] ) );?>"></div>
<?php endif;?>
