<form action="" method="post">

	<div class="af-stuffbox">

  		<h3 class="af-h3"><?php esc_html_e('Weekly Email Summary', 'openaffiliates');?></h3>
  		<div class="inside">
  			<div class="af-form-line">
          <h2><?php  esc_html_e('Activate/Hold ', 'openaffiliates');?> <?php esc_html_e('Weekly Email Summary', 'openaffiliates');?></h2>
          <p><?php esc_html_e('Administrator will receive a weekly report with informations like New registered Affiliates, Total Clicks, Total Earnings, Total Referrals and Conversion Rate.', 'openaffiliates'); ?></p>
  				<label class="af_label_shiwtch af-checkbox">
  					<?php $checked = ($data['af_wes_enabled']) ? 'checked' : '';?>
  					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_wes_enabled');" <?php echo $checked;?> />
  					<div class="switch af_wes"></div>
  				</label>
  				<input type="hidden" name="af_wes_enabled" value="<?php echo $data[ 'af_wes_enabled'];?>" id="af_wes_enabled" />
  			</div>
  	    <div class="af-line-break"></div>

      	<div class="af-form-line">
          	<h2><?php esc_html_e('Day of Notification', 'openaffiliates');?></h2>
						<p><?php esc_html_e('The chosen day will correspond to the day the administrator will receive the report.', 'openaffiliates');?></p>
    				<select name="af_wes_day_of_week"><?php
              foreach ( $data['days_of_week'] as $dayNumber => $dayName ){
                  $selected = $dayNumber === ( (int)$data['af_wes_day_of_week'] ) ? 'selected' : '';
                  ?><option value="<?php echo $dayNumber;?>" <?php echo $selected;?> ><?php echo $dayName;?></option><?php
              }
            ?></select>
         </div>

      	 <div class="af-form-line">
          		<div class="inside">
          				<div id="af_save_changes" class="af-submit-form af-btn">
          						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
          				</div>
          		</div>
      	 </div>

  </div>

</form>
