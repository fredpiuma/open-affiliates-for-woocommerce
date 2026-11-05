<div class="af-popup-wrapp" id="popup_box">
	<div class="af-the-popup af-notification-send-popup">
        <div class="af-popup-top">
        	<div class="title"><?php esc_html_e('Send a Test Email', 'openaffiliates');?></div>
            <div class="close-bttn" onClick="afClosePopup();"></div>
            <div class="clear"></div>
        </div>
        <div class="af-popup-content af-notification-send-wrapper">
        	<div class="af-popup-content-wrapp">

              <h3><?php esc_html_e('Sent a test to', 'openaffiliates');?></h3>
              <input type="text" value="<?php echo get_option('admin_email');?>" class="af-js-notification-test-email" />
							<input type="hidden" class="af-js-notification-test-id" value="<?php echo sanitize_text_field($_POST['id']);?>" />
          		<div class="af-send-additional-message">
								<p><?php esc_html_e('Dynamic {constants} will not be replaced with real data inside Test Email.', 'openaffiliates');?></p>
							</div>
              <div class="af-notification-send-buttons">
              		<div class="button button-primary button-large af-send-button" onClick="afSendNotificationTest();" ><?php esc_html_e('Send Email', 'openaffiliates');?></div>
									<div class="button button-primary button-large af-cancel-button" onClick="afClosePopup();"><?php esc_html_e('Cancel', 'openaffiliates');?></div>
							</div>
        	</div>
    	</div>
    </div>
</div>
