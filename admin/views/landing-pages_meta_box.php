<?php wp_enqueue_script('af_admin_js', AF_URL . 'assets/js/admin-functions.js', array('jquery'), '9.4' );?>
<div class="af-padding">
  <div><strong><?php esc_html_e('Set this Post for affiliate:', 'openaffiliates');?></strong></div>

    <div class="input-group">
    		<span class="input-group-addon" id="basic-addon1">Username</span>
    		<input type="text" class="form-control ui-autocomplete-input" id="usernames_search" autocomplete="off">

        <input type="hidden" value="<?php echo esc_attr($data['af_landing_page_affiliate_id']);?>" name="af_landing_page_affiliate_id" id="af_landing_page_affiliate_id" />
        <div id="af_username_search_tags"><?php
              if ($data['af_landing_page_affiliate_id']){
              $id = 'af_username_tag_' . $data['af_landing_page_affiliate_id'];
              ?>
              <div id="<?php echo esc_attr($id);?>" class="af-tag-item"><?php echo esc_html($data['affiliate_usename']);?><div class="af-remove-tag" onclick="afRemoveTag('<?php echo esc_attr($data['af_landing_page_affiliate_id']);?>', '#<?php echo esc_attr($id);?>', '#af_landing_page_affiliate_id');" title="<?php esc_html_e('Removing tag', 'openaffiliates');?>">x</div></div>
              <?php
              }
        ?></div>

    </div>

</div>
