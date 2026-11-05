<div class="af-ap-wrap">
	<?php if (!empty($data['title'])):?>
		<h3><?php echo do_shortcode($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['content'])):?>
		<p><?php echo do_shortcode($data['content']);?></p>
	<?php endif;?>

    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Setup PushOver Notification", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("You can get real-time notifications directly on your smartphone via PushOver application.", 'openaffiliates');?>
                </div>
             </div>
                <div class="af-row ">
            	<div class="af-col-xs-8">
	<form method="post" >
		<div class="af-form-line-register af-form-text">
        	<div class="af-account-title-label"><?php esc_html_e('Personal User Token', 'openaffiliates');?></div>
			<input type="text" name="af_pushover_token" value="<?php echo esc_af_content($data['af_pushover_token']);?>"  class="af-public-form-control "/>
            <div class="af-account-notes"><?php echo esc_html__("Sign up on pushover.net for a new account in order to get your Token.", 'openaffiliates');?></div>
		</div>
		<div class="af-submit-form">
			<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="af_submit" class="button button-primary button-large"  <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?> />
		</div>
	</form>
    			</div>
         </div>
    </div>
    </div>
</div>
