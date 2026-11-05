<div class="af-product-links-single-item">
    <div class="af-single-product-image-wrapp"><img src="<?php echo esc_url($data['featureImage']);?>" class="af-single-product-img" /></div>
    <div class="af-single-product-name">
    <a href="<?php echo esc_url($data['permalink']);?>" target="_blank" class="af-special-label"><?php echo esc_html($data['label']);?></a>
    <?php if ( $data['categories'] ):?>
        <?php foreach ( $data['categories'] as $object ):?>
            <div class="af-single-product-category-name"> <?php esc_html_e( 'Category: ', 'openaffiliates');?><strong><?php echo esc_html($object->name);?></strong></div>
        <?php endforeach;?>
    <?php endif;?>
    </div>
    <div class="af-single-product-price">
	<?php
		if(isset($data['numeric_price']) && isset($data['numeric_regular_price']) && $data['numeric_regular_price'] > $data['numeric_price']){
			echo esc_af_content('<div class="af-single-product-regular-price">'.$data['regular_price'].'</div> <div class="af-single-product-sale-price">'.$data['price'].'</div>') ;
		}else{
			echo esc_af_content($data['price']);
		}
	?></div>
    <div class="af-single-product-rewards">
    <?php if ( $data['showReward'] ):?>
    	<div class="af-single-product-reward-label"><?php esc_html_e( 'Rewards', 'openaffiliates' );?></div>
        <?php echo esc_af_content($data['referral_amount']);?>
    <?php endif;?>
    </div>
    <div class="af-single-product-link-wrapper">
    <div class="af-single-product-link js-af-affiliate-product-affiliate-link" data-post_id="<?php echo esc_attr($data['id']);?>" ><?php esc_html_e('Get Affiliate Link', 'openaffiliates');?></div>
    </div>
    <div class="af-clear"></div>

</div>
