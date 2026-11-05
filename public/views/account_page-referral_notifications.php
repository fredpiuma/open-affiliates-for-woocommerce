<div class="af-ap-wrap">

	<?php if (!empty($data['title'])):?>
		<h3><?php echo esc_af_content($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['message'])):?>
		<p><?php echo do_shortcode($data['message']);?></p>
	<?php endif;?>

<form  method="post" class="af-change-password-form">
	<?php if (!empty($data['module_settings_notf']['af_referral_notifications_enable'])) : ?>

	<div class="af-single-notf-row-wrapper">

			<div class="af-single-notf-row-top">
				<div class="af-single-notf-col af-single-notf-label"><?php esc_html_e("Referral Notification", 'openaffiliates');?></div>
				<div class="af-single-notf-col af-single-notf-checkbox af-text-align-center"><?php esc_html_e("Activation", 'openaffiliates');?></div>
			</div>
			<?php
				$posible_types = af_get_possible_referral_types();
				$landing_commissions = $af_db->get_all_landing_commision_source_type();
				$posible_types = array_merge($posible_types, $landing_commissions);
				$items = array();
				if ($data['metas'] && isset($data['metas']['af_notifications_on_every_referral_types'])){
					$items = explode(',', $data['metas']['af_notifications_on_every_referral_types']);
				}
				foreach ($posible_types as $k=>$v):
					$checked = (in_array($k, $items)) ? 'checked' : '';
					?>
					<div class="af-single-notf-row">
						<div class="af-single-notf-col af-single-notf-label"><?php echo esc_html($v['label']);?><span><?php echo (isset($v['sub_label']) ? $v['sub_label'] : '' );?></span></div>
						<div class="af-single-notf-col af-single-notf-checkbox"><input type="checkbox" onClick="afMakeInputhString(this, '<?php echo esc_attr($k);?>', '#af_types_in')" <?php echo esc_attr($checked);?> /></div>
					</div>
					<?php
				endforeach;
			?>
			<input type="hidden" value="<?php echo esc_attr($data['metas']['af_notifications_on_every_referral_types']);?>" id="af_types_in" name="af_notifications_on_every_referral_types" />
	</div>
	<?php endif;?>
	<?php if (!empty($data['module_settings_reports']['af_periodically_reports_enable'])) : ?>
    <div class="af-profile-box-wrapper">
    	<div class="af-profile-box-title"><span><?php esc_html_e("Periodic Reports Interval", 'openaffiliates');?></span></div>
        <div class="af-profile-box-content">
        	<div class="af-row ">
            	<div class="af-col-xs-10">
                        <div><?php esc_html_e("You can decide if and when you want to receive reports via Email.", 'openaffiliates');?></div>
                        <div>
                            <select name="period"  class="af-public-form-control "><?php
                                foreach (array(0 => esc_html__('Never send Reports', 'openaffiliates'), 1 => esc_html__('Daily Reports', 'openaffiliates'), 7 => esc_html__('Weekly Reports', 'openaffiliates'), 30 => esc_html__('Monthly Reports', 'openaffiliates')) as $k=>$v):
                                    $selected = ($k==$data['report_settings']['period']) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
                                    <?php
                                endforeach;
                            ?></select>
                        </div>
          		</div>
             </div>
        </div>
     </div>


	<?php endif;?>
	<div class="af-change-password-field-wrap">
		<input type="submit" value="<?php esc_html_e("Save Changes", 'openaffiliates');?>" name="save_settings" class="button button-primary button-large" />
	</div>
</form>

</div>
