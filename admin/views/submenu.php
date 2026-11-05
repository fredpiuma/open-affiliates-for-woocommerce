<?php $current_url = AF_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>
<div class="af-subtab-menu">
	<?php
		foreach ($data['submenu'] as $url=>$name){
			$selected = ($current_url==$url) ? 'af-subtab-selected' : '';
			?>
			<a href="<?php echo esc_url($url);?>" class="af-subtab-menu-item <?php echo esc_attr($selected);?>"><?php echo esc_html($name);?></a>
			<?php
		}
	?>
	<div class="clear"></div>
</div>
