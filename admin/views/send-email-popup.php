<div class="af-popup-wrapp" id="af_admin_popup_box">
	<div class="af-the-popup">
        <div class="af-popup-top">
        	  <div class="title"><?php esc_html_e('Open Affiliates - Send Direct Email', 'openaffiliates');?></div>
            <div class="close-bttn" id="af_send_email_via_admin_close_popup_bttn"></div>
            <div class="clear"></div>
        </div>
        <div class="af-popup-content af-send-email">
         <div class="af-inside-item">
           <div class="row">
             <div class="col-xs-6">
            	<div class="input-group">
             		 <span class="input-group-addon"><?php esc_html_e('From', 'openaffiliates');?></span>
	           		 <input type="text" class="form-control" id="af_admin_send_mail_from" value="<?php echo esc_attr($fromEmail);?>"/>
        		</div>
            </div>
           </div>
           <div class="row">
             <div class="col-xs-6">
            	<div class="input-group">
              <span class="input-group-addon"><?php esc_html_e('To', 'openaffiliates');?></span>
	            <input type="text"  class="form-control" id="af_admin_send_mail_to" value="<?php echo esc_attr($toEmail);?>" disabled />
        		</div>
            </div>
           </div>
           <div class="row">
             <div class="col-xs-8">
            	<div class="input-group">
              <span class="input-group-addon"><?php esc_html_e('Subject', 'openaffiliates');?></span>
	            <input type="text" class="form-control" id="af_admin_send_mail_subject" value="<?php echo esc_html($website) . esc_html__(' Notification', 'openaffiliates');?>" />
        		</div>
            </div>
           </div>
           <div class="row">
             <div class="col-xs-12">
              <h4><?php esc_html_e('Message:', 'openaffiliates');?></h4>
              <textarea id="af_admin_send_mail_content"><?php echo esc_html__('Hi ', 'openaffiliates') . $fullName . ", ";?></textarea>
            </div>
           </div>
           <div class="row">
             <div class="col-xs-8">
            	<div class="input-group">
          			<div class="input-group-btn">
              			<button class="btn btn-primary pointer" type="button" id="af_admin_send_mail_submit_bttn"><?php esc_html_e('Send Email', 'openaffiliates');?></button>
          			</div>
        		</div>
            </div>
           </div>
         </div>
    	</div>
    </div>
</div>
