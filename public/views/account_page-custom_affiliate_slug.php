<div class="af-ap-wrap">

<?php if (!empty($data['title'])):?>
	<h3><?php echo esc_af_content($data['title']);?></h3>
<?php endif;?>
<?php if (!empty($data['message'])):?>
	<p><?php echo do_shortcode($data['message']);?></p>
<?php endif;?>

<div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Manage your Affiliate Slug", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-12">
                <?php esc_html_e("Personalize your personal Affliate slug besides the default username or ID so you can hide your identity or company name behind a custom slug.", 'openaffiliates');?>
                </div>
             </div>
                <div class="af-row ">
            	<div class="af-col-xs-12">
	<form method="post"  id="af_campaign_form">

		<div class="af-row">

			<input type="text" name="af_affiliate_custom_slug" value="<?php echo esc_attr($data['af_affiliate_custom_slug']);?>" class="af-public-form-control "/>
			<div class="af-account-notes"><?php echo esc_html__("Slug must be unique, between ", 'openaffiliates').$data['slug_condition_min'].esc_html__(" and ", 'openaffiliates').$data['slug_condition_max'].esc_html__(" characters", 'openaffiliates').$data['slug_condition_rule'];?></div>
        </div>

        <div class="af-row">
        <?php if (isset($saved)):?>
			<?php if ($saved===FALSE):?>
				<div class="af-warning-box"><?php esc_html_e('An error has occurred. Please try to submit a different slug.', 'openaffiliates');?></div>
			<?php else :?>
				<div class="af-success-box"><?php esc_html_e('You Slug have been saved', 'openaffiliates');?></div>
			<?php endif;?>
		<?php endif;?>
        </div>
		<div class="af-ap-field">
			<input type="submit" name="save" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" class="button button-primary button-large"  <?php echo (isset($data['preview'])) ? 'disabled' : ''; ?> />
		</div>

	</form>
			</div>
         </div>
    </div>
    </div>
</div>
