<div class="af-wrapper">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('WP Affiliates Migration', 'openaffiliates');?></h3>
		<div class="inside">
		<div class="row">
		  <div class="col-xs-12">
			<div class="af-form-line">
            <h2><?php esc_html_e('Migrate from WP Affiliates script', 'openaffiliates');?></h2>
            <p><?php esc_html_e('Copy the Affiliate users from WP Affiliates script. You can assign a specific Open Affiliates Rank to new copied affiliate users during this process.', 'openaffiliates'); ?></p>

            <p><strong><?php esc_html_e('Note: Affiliates will not be removed after migration for safety reasons. You will have to manually remove them.', 'openaffiliates'); ?></strong></p>
          </div>
            <div class="af-line-break"></div>
            <div class="af-form-line">
            <h4><?php esc_html_e('Assign rank:', 'openaffiliates');?></h4>
            <select class="af-migrate-assign-rank">
              <?php foreach ($data['ranks_available'] as $k=>$v):?>
                <?php $selected = ( isset( $data['rank_id'] ) && $k==$data['rank_id']) ? 'selected' : '';?>
                <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
              <?php endforeach;?>
            </select>
         </div>
          <div class="af-line-break"></div>
            <div class="af-form-line">
        <div>
            <div class="af-progress-bar-wrapp"></div>
        </div>
        <span class="af-trigger-event-migrate button button-primary button-large" data-type="wp-affiliates"><?php esc_html_e('Trigger', 'openaffiliates');?></span>
			</div>

		</div>

	</div>
	</div>
    </div>
</div>

<?php wp_enqueue_script('af-migration-ajax', AF_URL . 'assets/js/migration-ajax.js', array('jquery'), null);?>
