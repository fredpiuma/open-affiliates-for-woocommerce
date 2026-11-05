
<?php wp_enqueue_style( 'af-croppic_css', AF_URL . 'assets/css/croppic.css', array(), '9.4' );?>
<?php wp_enqueue_script( 'af-jquery_mousewheel', AF_URL . 'assets/js/jquery.mousewheel.min.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-croppic', AF_URL . 'assets/js/croppic.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-image_croppic', AF_URL . 'assets/js/image_croppic.js', ['jquery'], '9.4' );?>
<?php wp_enqueue_script( 'af-public-upload-image', AF_URL . 'assets/js/public-upload-image.js', ['jquery'], '9.4' );?>
<?php
//$ajaxURL = AF_URL . 'public/ajax-upload.php?publicn=' . wp_create_nonce( 'publicn' );
$ajaxURL = get_site_url() . '/wp-admin/admin-ajax.php?action=af_ajax_public_upload&publicn=' . wp_create_nonce( 'publicn' );
?>
<span class="af-js-public-upload-image-data"
data-trigger_id="<?php echo esc_attr('js_af_trigger_avatar' . $data['rand']);?>"
data-name="<?php echo esc_attr($data['name']);?>"
data-button_label="<?php echo esc_html__('Upload', 'openaffiliates');?>"
data-save_image_target="<?php echo esc_url($ajaxURL);?>"
data-crop_image_target="<?php echo esc_url($ajaxURL);?>"
data-remove_selector="<?php echo esc_attr('#af_upload_image_remove_bttn_' . $data['rand']);?>"
></span>


<div class="af-upload-image-wrapper">

    <div class="af-upload-image-wrapp" >
        <?php if ( !empty($data['imageUrl']) ):?>
            <img src="<?php echo esc_url($data['imageUrl']);?>" class="<?php echo esc_attr($data['imageClass']);?>" />
        <?php else:?>
            <?php if ( $data['name']=='af_avatar' ):?>
                <div class="af-no-avatar af-member-photo"></div>
            <?php endif;?>
        <?php endif;?>
        <div class="af-clear"></div>
    </div>
    <div class="af-content-left">
    	<div class="af-avatar-trigger" id="<?php echo esc_attr('js_af_trigger_avatar' . $data['rand']);?>" >
        	<div id="af-avatar-button" class="af-upload-avatar"><?php esc_html_e('Upload', 'openaffiliates');?></div>
        </div>
        <span  class="af-upload-image-remove-bttn af-visibility-hidden" id="<?php echo esc_attr('af_upload_image_remove_bttn_' . $data['rand']);?>"><?php esc_html_e('Remove', 'openaffiliates');?></span>
    </div>
    <input type="hidden" value="<?php echo esc_attr($data['value']);?>" name="<?php echo esc_attr($data['name']);?>" id="<?php echo esc_attr('af_upload_hidden_' . $data['rand'] );?>" data-new_user="<?php echo ( $data['user_id'] == -1 ) ? 1 : 0;?>" />

    <?php if (!empty($data['sublabel'])):?>
        <label class="af-form-sublabel"><?php echo af_correct_text($data['sublabel']);?></label>
    <?php endif;?>
</div>
