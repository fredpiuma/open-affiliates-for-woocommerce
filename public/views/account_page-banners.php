<div class="af-banners-wrapp">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

	<?php if (!empty($data['listing_items'])) : ?>
		<div class="af-banners-list">
		<?php $marketingBuilder = new \OpenAffiliates\AffiliateMarketingBuilder();?>
		<?php foreach ($data['listing_items'] as $arr) : ?>
			<?php $alt = isset( $arr->alt_text ) && $arr->alt_text !== false ? $arr->alt_text : $arr->name;?>
			<div class="af-banner">
				<div class="af-banner-title"><?php echo esc_af_content($arr->name);?></div>
				<div class="af-banner-content">
						  <?php if ( $arr->content_type === '' || $arr->content_type === false || $arr->content_type === 'image' ):?>
							<div class="af-banner-img">
									<a href="<?php echo esc_url($arr->url);?>" target="_blank" >
										<img src="<?php echo esc_url($arr->image);?>" alt="<?php echo esc_attr( $alt );?>" />
									</a>
							</div>
							<?php else :?>
								<div class="af-creatives-text">
										<a href="<?php echo esc_url($arr->url);?>" target="_blank">
											<?php $arr->text_content;?>
										</a>
								</div>
							<?php endif;?>
					<div class="af-banner-description"><span class="af-special-label"><?php echo esc_html__('Creative Description', 'openaffiliates') . '</span>' . af_correct_text($arr->description);?></div>
					<?php $size = af_get_image_size($arr->image);?>
					<?php if ( isset( $size['width'] ) && isset( $size['height'] ) ):?>
							<div><span class="af-special-label"><?php echo esc_html__('Creative Banner Size', 'openaffiliates');?></span> <?php echo esc_af_content($size['width'] . 'px x ' . $size['height'] . 'px.');?></div>
					<?php endif;?>
					<div><span class="af-special-label"><?php echo esc_html__('Target URL', 'openaffiliates');?></span> <?php echo esc_url($arr->url);?></div>

					<?php if ( !isset( $arr->content_type ) || $arr->content_type === 'image' ):?>
							<div class="af-banner-copypaste">
								<span class="af-special-label"><?php esc_html_e('HTML Embed Code', 'openaffiliates');?></span>
								<textarea><a href="<?php echo esc_url($arr->url);?>" target="_blank" alt="<?php echo $alt;?>"><img src="<?php echo esc_url($arr->image);?>"  alt="<?php echo esc_attr($arr->name);?>" /><?php echo esc_af_content($data['pixel_tracking']);?></a></textarea>
							</div>
					<?php else :?>
						<div class="af-banner-copypaste">
							<span class="af-special-label"><?php esc_html_e('HTML Embed Code', 'openaffiliates');?></span>
							<textarea><a href="<?php echo esc_url($arr->url);?>" target="_blank"><?php echo esc_af_content($arr->text_content);?></a></textarea>
						</div>
					<?php endif;?>

					<?php if ( $data['show_social'] ):?>
							<?php echo esc_af_content($marketingBuilder->getSocialForCreatives( $data['social_shortcode'], af_correct_text($arr->description), $arr->url, $arr->image ));?>
					<?php endif;?>

				</div>
			</div>
		<?php endforeach;?>
	</div>
	<?php else : ?>
		 <div class="af-warning-box af-extra-margin-top"><?php esc_html_e("There aren't any creatives available.", 'openaffiliates');?></div>
	<?php endif;?>
</div>
