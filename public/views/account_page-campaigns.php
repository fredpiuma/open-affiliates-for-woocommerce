<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

	<form method="post"  id="af_campaign_form">

		<input type="hidden" name="af_campaign_nonce" value="<?php echo wp_create_nonce( 'af_campaign_nonce' );?>" />

        <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Add New Campaign', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("Campaigns will help you to better promote your marketing strategy. Those are private and individual for each affiliate account.", 'openaffiliates');?>
                </div>
            </div>
        </div>
        <div class="af-profile-box-content">
            <div class="af-row ">
            	<div class="af-col-xs-8">
                        <div class="af-account-title-label"><?php esc_html_e('Campaign unique Slug', 'openaffiliates');?></div>
                        <input type="text" name="campaign_name" value="" class="af-public-form-control "/>
                        <div class="af-account-notes"><?php echo esc_html__("Slug must be unique and based on only lowercase characters without extra symbols or spaces.", 'openaffiliates');?></div>

                    <div class="af-submit-field-wrap">
                        <input type="submit" name="save" value="<?php esc_html_e('Add New Campaign', 'openaffiliates');?>" class="button button-primary button-large af-js-submit-campaign"  <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?> />
                    </div>
               </div>
            </div>
         </div>
         </div>

		<?php if (!empty($data['campaigns'])) : ?>
		<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e('Your own Campaigns', 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
								<table class="af-account-table">
										<thead>
												<tr>
														<th><?php esc_html_e('Campaign Slug', 'openaffiliates');?></th>
														<th><?php esc_html_e('Action', 'openaffiliates');?></th>
												</tr>
										</thead>
										<tbody class="af-alternate">
												<?php foreach ($data['campaigns'] as $campaignId => $value):?>
												<tr>
														<td><?php echo esc_html($value);?></td>
														<td>
																<span class="af-js-account-page-campaigns-delete-item" data-id="<?php echo esc_attr($campaignId);?>"><?php esc_html_e('Remove', 'openaffiliates');?></span>
																													</td>
												</tr>
												<?php endforeach;?>
										</tbody>
								</table>

									<input type="hidden" value="" name="af_delete_campaign" id="af_delete_campaign"/>

               </div>
            </div>
         </div>
         </div>
		<?php endif;?>
		<br/>

	</form>
</div>
