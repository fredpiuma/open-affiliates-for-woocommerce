<div class="af-wrapper">
<form method="post" action="<?php echo esc_url($data['form_submit']);?>">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('User Custom Fields', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Slug:', 'openaffiliates');?></label>
				<input type="text" name="name" value="<?php echo esc_attr($data['metas']['name']);?>" <?php echo esc_attr( $data['disabled']);?> />
				<?php if ( $data['disabled'] ):?>
						<input type="hidden" name="name" value="<?php echo esc_attr($data['metas']['name']);?>" />
				<?php endif;?>
			</div>
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Field Type:', 'openaffiliates');?></label>
				<select id="field_type" <?php echo ($data['disabled']) ? 'disabled' : 'name="type"';?> onChange="afRegisterFields(this.value);">
					<?php foreach ($data['field_types'] as $k=>$v): ?>
						<?php $selected = ($data['metas']['type']==$k) ? 'selected' : '';?>
						<option value="<?php echo esc_attr($k)?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
					<?php endforeach;?>
				</select>
				<?php if ( $data['disabled'] ):?>
						<input type="hidden" name="type" value="<?php echo esc_attr($data['metas']['type']);?>" />
				<?php endif;?>
			</div>

			<?php
				$display = 'none';
				if (($data['metas']['type']=='select' || $data['metas']['type']=='checkbox' || $data['metas']['type']=='radio'
					|| $data['metas']['type']=='multi_select') && ($data['metas']['name']!='tos')){
						$display = 'block';
				}
			?>
			<div class="af-form-line af-display-<?php echo esc_attr($display);?>" id="af-register-field-values">
				<label class="af-label af-top-vertical-align"><?php esc_html_e('Values', 'openaffiliates');?></label>
					<div class="af-register-the-values af-display-inline">
					<?php
						if (isset($data['metas']['values']) && $data['metas']['values']){
							foreach ($data['metas']['values'] as $value){
							?>
								<div class="af-custom-field-item-wrapp af-fields-values-box">
									<input type="text" name="values[]" value="<?php echo af_correct_text($value);?>" class="af-fields-values-box-input"/>
									<i class="fa-af fa-remove-af af-js-register-fields-add-edit-remove" ></i>
									<i class="fa-af fa-arrows-af"></i>
								</div>
							<?php
							}
						} else {
						?>
							<div class="af-custom-field-item-wrapp af-fields-values-box">
								<input type="text" name="values[]" value=""/>
								<i class="fa-af af-icon-remove-e af-js-register-fields-add-edit-remove" ></i>
								<i class="fa-af fa-arrows-af"></i>
							</div>
						<?php
						}
						?>
					</div>
				<div class="af-clear"></div>
				<div class="af-fields-add-new-value" onclick="afAddNewRegisterFieldValue();"><?php esc_html_e('Add New Value', 'openaffiliates');?></div>
			</div>

			<div id="af-register-field-conditional-text" class=" <?php echo ($data['metas']['type']=='conditional_text') ? 'af-display-block' : 'af-display-none';?>">
				<div class="af-form-line">
					<label class="af-labels af-top-vertical-align"><?php esc_html_e('Right Answer:', 'openaffiliates');?></label>
					<input type="text" value="<?php echo isset($data['metas']['conditional_text']) ? af_correct_text($data['metas']['conditional_text']) : '';?>" name="conditional_text" />
				</div>
				<div class="af-form-line">
					<label class="af-labels af-top-vertical-align"><?php esc_html_e('Error Message:', 'openaffiliates');?></label>
					<textarea name="error_message" class="af-fields-error-mess"><?php echo isset($data['metas']['error_message']) ? af_correct_text($data['metas']['error_message']) : ''; ?></textarea>
				</div>
			</div>

			<div class="af-no-border <?php echo ($data['metas']['type']=='plain_text') ? 'af-display-block' : 'af-display-none';?>" id="af-register-field-plain-text">
				<label class="af-labels af-top-vertical-align"><?php esc_html_e('Content:', 'openaffiliates');?> </label>
				<div class="af-fields-content-box">
				<?php
					$settings = array(
									'media_buttons' => true,
									'textarea_name'=>'plain_text_value',
									'textarea_rows' => 5,
									'tinymce' => true,
									'quicktags' => true,
									'teeny' => true,
					);
					$plain_text = '';
					if(isset($data['metas']['plain_text_value'])){
						$plain_text = $data['metas']['plain_text_value'];
					}
					wp_editor(af_correct_text($plain_text), 'plain_text_value', $settings);
				?>
				</div>
			</div>



			<div class="af-form-line">
				<h2><?php esc_html_e('Labels', 'openaffiliates');?></h2>
				<label class="af-label"><?php esc_html_e('Field Label:', 'openaffiliates');?> </label> <input type="text" name="label" value="<?php echo af_correct_text($data['metas']['label']);?>"/>
			</div>
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('SubLabel:', 'openaffiliates');?></label>
				<input type="text" value="<?php echo isset($data['metas']['sublabel']) ? af_correct_text($data['metas']['sublabel']) : '';?>" name="sublabel" class="af-fields-extra-input" />
			</div>
			<div class="af-form-line">
				<label class="af-label"><?php esc_html_e('Style Class:', 'openaffiliates');?></label>
				<input type="text" value="<?php echo isset($data['metas']['class']) ? af_correct_text($data['metas']['class']) : '';?>" name="class" class="af-fields-extra-input" />
			</div>

			<?php if (!in_array($data['metas']['name'], $data['disabled_items'])):?>
				<div class="af-special-line">
					<h2><?php esc_html_e("Conditional Logic", 'openaffiliates');?></h2>
					<div class="af-form-line">
						<label class="af-label"><?php esc_html_e('Show:', 'openaffiliates');?></label>
						<select name="conditional_logic_show">
							<option <?php echo (isset($data['metas']['conditional_logic_show']) && $data['metas']['conditional_logic_show']=='yes') ? 'selected' : '';?> value="yes"><?php esc_html_e("Yes", 'openaffiliates');?></option>
							<option <?php echo (isset($data['metas']['conditional_logic_show']) && $data['metas']['conditional_logic_show']=='no') ? 'selected' : '';?> value="no"><?php esc_html_e("No", 'openaffiliates');?></option>
						</select>
					</div>
					<div class="af-form-line af-text-align-left">
						<div class="af-display-inline">
							<label class="af-label"><?php esc_html_e('If Field:', 'openaffiliates');?></label>
							<select name="conditional_logic_corresp_field">
							<?php foreach ($data['register_fields'] as $k => $v):?>
								<?php $selected = ($data['metas']['conditional_logic_corresp_field']==$k) ? 'selected' : '';?>
								<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?>><?php echo esc_html($v);?></option>
							<?php endforeach;?>
							</select>
						</div>
						<div class="af-condition-blockone">
							<select name="conditional_logic_cond_type" class="af-fields-select">
								<option <?php echo (isset($data['metas']['conditional_logic_cond_type']) && $data['metas']['conditional_logic_cond_type']=='has') ? 'selected' : '';?> value="has"><?php esc_html_e("Is", 'openaffiliates');?></option>
								<option <?php echo (isset($data['metas']['conditional_logic_cond_type']) && $data['metas']['conditional_logic_cond_type']=='contain') ? 'selected' : '';?> value="contain"><?php esc_html_e("Contains", 'openaffiliates');?></option>
							</select>
						</div>
						<div class="af-condition-blocktwo">
							<label class="af-fields-label"> : </label>
							<input type="text" name="conditional_logic_corresp_field_value" value="<?php echo isset($data['metas']['conditional_logic_corresp_field_value']) ? af_correct_text($data['metas']['conditional_logic_corresp_field_value']) : '';?>" class="af-fields-input" />
						</div>
					</div>
				</div>
			<?php endif; ?>

			<input type="hidden" name="id" value="<?php echo esc_attr($data['id']);?>" />
			<div class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save_field" class="button button-primary button-large">
			</div>
		</div>
	</div>
</form>
</div>
