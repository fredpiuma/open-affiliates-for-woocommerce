<div class="af-ap-wrap">
  <?php if (!empty($data['title'])):?>
  	<h3><?php echo esc_af_content($data['title']);?></h3>
  <?php endif;?>
  <?php if (!empty($data['content'])):?>
  	<p><?php echo do_shortcode($data['content']);?></p>
  <?php endif;?>
  <div>
    <form method="post" >

      <input type="hidden" name="af_iab_settings_nonce" value="<?php echo wp_create_nonce( 'af_iab_settings_nonce' );?>" />
	<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Show Info Affiliate Bar', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <div><?php esc_html_e('Choose if you want to show and use the Info Affiliate Bar into website pages once you navigate them. This is quickest and easiest way to link to any page. Info Affiliate Bar will show up at the top of every page you visit. To generate an affiliate link just go to the specific page and use the available options from FlashBar.', 'openaffiliates');?></div>
                </div>
            </div>
            <div class="af-row ">
            	<div class="af-col-xs-4">
                   <select name="iab_enable_bar" class="af-public-form-control">
              		<option value="0" <?php echo (!$data['settings']['iab_enable_bar']) ? 'selected' : '';?> >Off</option>
             		 <option value="1" <?php echo ($data['settings']['iab_enable_bar']) ? 'selected' : '';?> >On</option>
          			</select>
          		</div>
             </div>
        </div>
     </div>
	<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Temporary Hide Info Affiliate Bar', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <div><?php esc_html_e('If is necessary you may turn off Info Affiliate Bar for 24hrs and will show up automatically after this period.', 'openaffiliates');?></div>
                </div>
            </div>
            <div class="af-row ">
            	<div class="af-col-xs-4">
                   <?php
              $value = isset( $_POST['af_info_affiliate_bar_hide'] ) ? $_POST['af_info_affiliate_bar_hide'] : false;
              if ( $value===FALSE ){
                  $value = isset( $_COOKIE['af_info_affiliate_bar_hide'] ) ? $_COOKIE['af_info_affiliate_bar_hide'] : 0;
              }
          ?>
          <select name="af_info_affiliate_bar_hide" class="af-public-form-control">
              <option value="0" <?php echo ( empty( $value ) ) ? 'selected' : '';?> >Off</option>
              <option value="1" <?php echo ( !empty( $value ) ) ? 'selected' : '';?> >On</option>
          </select>
          		</div>
             </div>
        </div>
     </div>

      <div>

      </div>

      <div>
        <input type="submit" name="save" value="<?php esc_html_e("Save Changes", 'openaffiliates');?>"  />
      </div>
    </form>

  </div>
</div>
