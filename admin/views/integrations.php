
<div class="af-all-integrations">
	<?php foreach ($data['integrations'] as $k=>$v):?>
		<?php if ( !isset( $v['label'] ) )continue;?>
			<?php $disabled = ''; if ( empty( $v['installed'] ) ): $disabled = 'af-integration-box-disabled'; endif; ?>
		<div class="af-integration-box <?php echo esc_attr($disabled); ?>">
				<?php if ( !empty( $disabled ) ): echo '<div class="af-integration-not-found"></div>'; endif; ?>
			<div class="af-integration-box-content">
				<h2><?php echo esc_af_content($v['label']);?></h2>
				<div class="af-integration-author"><?php echo esc_html__('By','openaffiliates').' '.'<a href="'.esc_url($v['author-link']).'" target="_blank">'.esc_af_content($v['author']).'</a>';?></div>
				<p><?php echo esc_af_content($v['description']);?></p>
			</div>
			<div class="af-integration-box-actions">
				<div class="af-integration-box-actions-content">
					<label class="af_label_shiwtch af-switch-button-margin">
						<?php $checked = ($v['status']) ? 'checked' : '';?>
						<input type="checkbox" class="af-switch af-js-do-switch-value" data-type="<?php echo esc_attr($k);?>" data-target="af-integration-<?php echo esc_attr($k);?>" <?php echo esc_attr($checked);?> />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af-integration-<?php echo esc_attr($k);?>" value="<?php echo esc_attr($v['status']);?>" id="af-integration-<?php echo esc_attr($k);?>" />
					<span class="af-integration-status af-js-integration-status-for-<?php echo esc_attr( $k );?>" data-enabled="<?php echo esc_html__('Enabled', 'openaffiliates');?>" data-disabled="<?php echo esc_html__('Disabled', 'openaffiliates');?>" >
						<?php echo ($v['status'] == 1) ? esc_html__('Enabled','openaffiliates') : esc_html__('Disabled','openaffiliates');?>
					</span>
					<?php if ( !empty($v['extra-details-link'])): ?>
						<a href="<?php echo esc_url($v['extra-details-link']); ?>" target="_blank" class="af-extra-button"><?php echo esc_html__('More Info','openaffiliates');?></a>
					<?php endif;?>
					<?php if ( !empty($v['extra-settings-link'])): ?>
						<a href="<?php echo esc_url($v['extra-settings-link']); ?>" target="_blank" class="af-extra-button af-extra-settings-button"><?php echo esc_html__('Settings','openaffiliates');?></a>
					<?php endif;?>
				</div>
			</div>
		</div>
	<?php endforeach;?>
</div>
