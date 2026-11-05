<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['content'])):?>
	<p><?php echo do_shortcode($data['content']);?></p>
<?php endif;?>

<form  method="post">
<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Add New Direct Link', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("Users will no longer avoid links that could benefit a certain affiliate, because they will not be able to know to which affiliate the link belongs to.", 'openaffiliates');?>
                </div>
            </div>
        </div>
        <div class="af-profile-box-content">
            <div class="af-row ">
            	<div class="af-col-xs-10">
                            <div class="af-account-title-label"><?php esc_html_e('Your Direct Link', 'openaffiliates');?></div>
                            <input type="text" name="url" class="af-public-form-control" />
                            <div class="af-account-notes"><?php echo esc_html__("Submit one of your website page from where traffic should be tracked and recorded as coming from you.", 'openaffiliates') . esc_html__(" You can submit up to ", "openaffiliates");?> <strong> <?php echo esc_af_content($data['max_limit']) . esc_html__(" links ", 'openaffiliates');?></strong></div>


                        <?php if (!empty($data['err'])):?>
                            <div class="af-warning-box">
                                <div><?php echo esc_af_content($data['err']);?></div>
                            </div>
                        <?php endif;?>

                        <div class="af-submit-field-wrap">
                            <input type="submit" value="<?php esc_html_e('Add New Link', 'openaffiliates');?>" name="save" class="button button-primary button-large af-js-submit-simple-link" <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?> />
                        </div>

          </div>
       </div>
 </div>
</form>

<?php if (!empty($data['items'])):?>
<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Your own Direct Links for Tracking', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                  <div class="af-stuffbox">
                      <table class="af-account-table">
                          <thead>
                              <tr>
                                  <th><?php esc_html_e('Direct Link', 'openaffiliates');?></th>
                                  <th><?php esc_html_e('Status', 'openaffiliates');?></th>
                                  <th><?php esc_html_e('Action', 'openaffiliates');?></th>
                              </tr>
                          </thead>
                          <tbody class="af-alternate">
                              <?php foreach ($data['items'] as $item):?>
                              <tr>
                                  <td><a href="<?php echo esc_url($item['url']);?>" target="_blank"><?php echo esc_url($item['url']);?></a></td>
                                  <td>
                                      <?php if ($item['status']):?>
                                          <div class="af-status af-status-active"><?php esc_html_e('Approved', 'openaffiliates');?></div>
                                      <?php else:?>
                                          <div class="af-status af-status-inactive"><?php esc_html_e('Pending', 'openaffiliates');?></div>
                                      <?php endif;?>
                                  </td>
                                  <td>
                                      <a href="<?php echo add_query_arg('del', $item['id'], $data['url']);?>" class="af-color-red"><?php esc_html_e('Remove', 'openaffiliates');?></a>
                                  </td>
                              </tr>
                              <?php endforeach;?>
                          </tbody>
                      </table>
                  </div>
              </div>
           </div>
        </div>
      </div>
<?php endif;?>
</div>

<span class="af-js-simple-links-section" data-current_url="<?php echo esc_url($data['url']);?>"></span>
