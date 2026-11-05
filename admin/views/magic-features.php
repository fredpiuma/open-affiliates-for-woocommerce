<?php foreach ($data['feature_types'] as $k=>$v):?>
	<?php if ( !isset( $v['label'] ) )continue;?>
	<div class="uap-magic-box-wrap <?php echo ($v['enabled']) ? '' : 'uap-disabled-box';?>">
		<a href="<?php echo esc_url($v['link']);?>"
			<?php if($k == 'new_extension' || (isset($v['external_link']) && $v['external_link'] === TRUE)){
				echo esc_uap_content(' target="_blank" ');
			}
		?>>
			<div class="uap-magic-feature <?php echo esc_attr($k);?> <?php echo esc_attr($v['extra_class']);?>">
				<?php if(isset($v['addon']) && $v['addon'] === TRUE){?>
					<div class="uap-adm-ribbon uap-adm-ribbon-top-left"><span>PRO</span></div>
				<?php } ?>

				<div class="uap-magic-box-icon"><i class="fa-uap <?php echo esc_attr($v['icon']);?>"></i></div>
				<div class="uap-magic-box-title"><?php echo esc_uap_content($v['label']);?></div>
				<div class="uap-magic-box-desc"><?php echo esc_uap_content($v['description']);?></div>
			</div>
		</a>
	</div>
<?php endforeach;?>
<div class="uap-clear"></div>
