<?php if ($this->error_messages):?>
	<?php foreach ($this->error_messages as $err):?>
		<div class="af-error-message"><?php echo esc_af_content($err);?></div>
	<?php endforeach;?>
<?php endif;?>
