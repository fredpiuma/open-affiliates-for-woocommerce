<?php
require_once AF_PATH . 'admin/font-awesome_codes.php';
$font_awesome = af_return_font_awesome();
?>
<?php foreach ($font_awesome as $base_class => $code):?>
	<div class="af-font-awesome-popup-item" data-class="<?php echo esc_attr($base_class);?>" data-code="<?php echo esc_attr($code);?>"><i class="fa-af-preview fa-af <?php echo esc_attr($base_class);?>"></i></div>
<?php endforeach;?>
