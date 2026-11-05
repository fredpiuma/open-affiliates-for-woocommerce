<div class="af-wrapper">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Add/Update Affiliate Member', 'openaffiliates');?></h3>
		<div class="inside af-admin-edit">
        	<div class="af-edit-profile-section-title">

        		<h2><?php echo esc_html__('Affiliate Profile details', 'openaffiliates'); ?></h2>
            	<p><?php echo esc_html__('Control which fields are available in the "Showcases->Register Form->Custom Fields" section', 'openaffiliates'); ?></p>

					</div>
			<?php echo esc_af_content($data['output']);?>
		</div>
	</div>
</div>
