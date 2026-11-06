<div class="af-settings-box-wrapper">
  <div class="af-settings-tab-wrapper">
    <?php $current_url = af_current_url();?>
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
  <div class="af-settings-container">
