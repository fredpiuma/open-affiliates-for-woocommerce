<?php foreach ($data['feature_types'] as $k=>$v):?>
	<?php if ( !isset( $v['label'] ) )continue;?>
	<div class="af-magic-box-wrap <?php echo ($v['enabled']) ? '' : 'af-disabled-box';?>">
		<a href="<?php echo esc_url($v['link']);?>"
			<?php if($k == 'new_extension' || (isset($v['external_link']) && $v['external_link'] === TRUE)){
				echo esc_af_content(' target="_blank" ');
			}
		?>>
			<div class="af-magic-feature <?php echo esc_attr($k);?> <?php echo esc_attr($v['extra_class']);?>">
				<?php if(isset($v['addon']) && $v['addon'] === TRUE){?>
					<div class="af-adm-ribbon af-adm-ribbon-top-left"><span>PRO</span></div>
				<?php } ?>

				<div class="af-magic-box-icon"><i class="fa-af <?php echo esc_attr($v['icon']);?>"></i></div>
				<div class="af-magic-box-title"><?php echo esc_af_content($v['label']);?></div>
				<div class="af-magic-box-desc"><?php echo esc_af_content($v['description']);?></div>
			</div>
		</a>
	</div>
<?php endforeach;?>
<div class="af-clear"></div>
