<?php if (!empty($data['warning_messages'])):?>
	<div class="af-warning-box">
		<?php foreach ($data['warning_messages'] as $message):?>
			<?php echo esc_af_content($message);?>
		<?php endforeach;?>
	</div>
<?php endif;?>
