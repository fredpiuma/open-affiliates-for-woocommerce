<div class="af-wrapper">
<div class="af-stuffbox">
  <form action="<?php echo esc_url($data['form_action_url']);?>" method="post">

  <input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<h3 class="af-h3"><?php esc_html_e('Manage Creative', 'openaffiliates');?></h3>
	<div class="inside">
    <div class="af-form-line">
        <div class="row">
          <div class="col-xs-6">
              <h2><?php esc_html_e('Activate/Hold the Creative', 'openaffiliates');?></h2>
              <p><?php esc_html_e('The Creative can be turned on or off without having to be removed', 'openaffiliates');?></p>
              <label class="af_label_shiwtch af-switch-button-margin">
                <?php $checked = ($data['status']) ? 'checked' : '';?>
                <input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#status');" <?php echo esc_attr($checked);?> />
                <div class="switch af-display-inline"></div>
              </label>
              <input type="hidden" name="status" value="<?php echo esc_attr($data['status']);?>" id="status" />
          </div>
        </div>
    </div>

    <div class="af-form-line">
	  <div class="af-inside-item">
		<div class="row">
			<div class="col-xs-6">
			<div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('Name', 'openaffiliates');?></span>
				<input type="text" class="form-control" placeholder="..."  value="<?php echo esc_attr($data['name']);?>" name="name"  />
			</div>
      <p><?php esc_html_e("This creative's name. Give your affiliates a brief overview of the creative using this", 'openaffiliates');?></p>
			</div>
		</div>
	 </div>
 </div>

	 <div class="af-inside-item">
     <div class="af-form-line">
		<div class="row">
			<div class="col-xs-6">
				<h4><?php esc_html_e('Short Description', 'openaffiliates');?></h4>
          <p><?php esc_html_e('An optional description for this creative, which you may use to give your affiliates more details about the creative.', 'openaffiliates');?></p>
				<textarea name="description" class="form-control text-area" cols="30" rows="5" placeholder="<?php esc_html_e('Some details...', 'openaffiliates');?>"><?php echo esc_html($data['description']);?></textarea>
			</div>
		</div>
  </div>
	</div>

  <div class="af-inside-item">
    <div class="af-form-line">
       <div class="row">
           <div class="col-xs-6">
             <h2><?php esc_html_e('Creative Type', 'openaffiliates');?></h2>
             <p><?php esc_html_e('Choose the type of the Creative', 'openaffiliates');?></p>
             <select name="content_type" class="af-js-admin-creatives-select-type form-control m-bot15">
                <option value="image" <?php if ( $data['content_type'] === 'image' ) echo 'selected';?> ><?php esc_html_e( 'Image', 'openaffiliates' );?></option>
                <option value="text" <?php if ( $data['content_type'] === 'text' ) echo 'selected';?> ><?php esc_html_e( 'Text', 'openaffiliates' );?></option>
             </select>
           </div>
       </div>
     </div>
 </div>

	<div class="af-inside-item af-special-line">
    <div class="af-form-line">
		<div class="row">
			<div class="col-xs-6">
			<h2><?php esc_html_e('Creative Options', 'openaffiliates');?></h2>
			<p><?php esc_html_e('Predefined URL And Image for your Custom Creative available for Affiliates', 'openaffiliates');?></p>
    </div>
  </div>
  </div>
  <div class="af-form-line">
  <div class="row">
    <div class="col-xs-6">
      <div class="input-group">
				<span class="input-group-addon"><?php esc_html_e('Link', 'openaffiliates');?></span>
				<input type="text" class="form-control" value="<?php echo esc_attr($data['url']);?>" name="url" />
			</div>
    </div>
  </div>
  </div>

  <div class="af-form-line">
  <div class="row">
    <div class="col-xs-6">
      <?php $extraClass = $data['content_type'] === 'image' ? '' : 'af-display-none';?>
      <div class="<?php echo $extraClass;?>" id="af_js_admin_creatives_image_url">
          <h4><?php esc_html_e('Creative Image', 'openaffiliates');?></h4>
          <p><?php esc_html_e('Select your image hosted on your WordPress site', 'openaffiliates');?></p>
    			<div class="form-group">
    			      <input type="text" class="form-control af-display-inline af-banner-settings-image-input" onClick="openMediaUp(this);" value="<?php echo esc_attr($data['image']);?>" name="image" id="af_the_image" />
    		        <i class="fa-af fa-trash-af" id="af_js_add_edit_banners_trash" title="<?php esc_html_e('Remove Creative Image', 'openaffiliates');?>"></i>
    			</div>
          <div class="input-group">
              <span class="input-group-addon"><?php esc_html_e('Alt Text', 'openaffiliates');?></span>
              <input type="text" class="form-control af-display-inline af-banner-settings-image-input" value="<?php echo esc_attr($data['alt_text']);?>" name="alt_text" id="alt_text" />
          </div>
      </div>

      <?php $extraClass = $data['content_type'] === 'text' ? '' : 'af-display-none';?>
      <div class="<?php echo $extraClass;?>" id="af_js_admin_creatives_text_type">
          <div class="input-group">
                <span class="input-group-addon"><?php esc_html_e('Anchor text', 'openaffiliates');?></span>
                <input type="text" class="form-control" value="<?php echo esc_attr($data['text_content']);?>" name="text_content" id="af_text_content" />
          </div>
      </div>
    </div>
  </div>
  </div>
  <div class="af-form-line">
  <div class="row">
    <div class="col-xs-6">
      <h4><?php esc_html_e('Internal Notes', 'openaffiliates');?></h4>
      <p><?php esc_html_e('Additional Information for internal purpose only.', 'openaffiliates');?></p>
      <div class="form-group">
          <textarea name="notes" class="form-control text-area" cols="30" rows="5"><?php echo esc_attr($data['notes']);?></textarea>
      </div>


			</div>
    </div>
		</div>
	</div>
		<div id="af_save_changes" class="af-submit-form">
			<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large">
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo esc_attr($data['id']);?>" />
  </form>
</div>

</div>
