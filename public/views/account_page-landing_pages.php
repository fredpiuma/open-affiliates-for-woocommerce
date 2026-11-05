<div class="af-ap-wrap">
<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['content'])):?>
	<p><?php echo do_shortcode($data['content']);?></p>
<?php endif;?>


<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Your Landing Page", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("Redirect traffic and leads to your Landing Page without being necessary to use your Tracking Code in order to track visitors. Users will no longer avoid links that could benefit a certain affiliate because no affiliate link will be required on this case.", 'openaffiliates');?>
                </div>
             </div>
                <?php if (empty($data['pages'])):?>
                  <div class="af-warning-box af-extra-margin-top"><?php esc_html_e('No Landing Page have been assigned to your account yet.', 'openaffiliates');?></div>
                <?php else :?>
                <table class="af-account-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Page Title', 'openaffiliates');?></th>
                            <th><?php esc_html_e('Link', 'openaffiliates');?></th>
                        </tr>
                    </thead>
										<tbody class="af-alternate">
                    <?php foreach ($data['pages'] as $object):?>
                      <tr>
                          <td><?php echo esc_af_content($object->post_title);?></td>
                          <td><a href="<?php echo get_permalink($object->ID);?>" target="_blank"><?php echo get_permalink($object->ID);?></a></td>
                      </tr>
                    <?php endforeach;?>
									</tbody>
                </table>

                <?php endif;?>

    </div>
</div>
</div>
