<div class="af-wrapper"><form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Affiliate QR Codes', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
		<div class="inside">
			<div class="af-form-line">
			<div class="row">
				<div class="col-xs-7">
					<h2><?php esc_html_e('Activate/Hold Affiliate QR Codes', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Affiliates may download and share their QR codes anywhere out of the website.', 'openaffiliates');?></p>
					<label class="woo_account_page_enable af-switch-button-margin">
					<?php $checked = ($data['metas']['af_qr_code_enable']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_qr_code_enable');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="af_qr_code_enable" value="<?php echo esc_attr($data['metas']['af_qr_code_enable']);?>" id="af_qr_code_enable" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-10">
					<h2><?php esc_html_e('Additional Settings', 'openaffiliates');?></h2>
					<br/>
					<h4><?php esc_html_e(' QRCode Image Size', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Decides the image size for the QR code. Bigger is much easier to scan, but has an increased load time.', 'openaffiliates');?></p>
					<input type="number" value="<?php echo esc_attr($data['metas']['af_qr_code_size']);?>" name="af_qr_code_size" min="1" max="10" />
				</div>
			</div>

			<div class="row">
				<div class="col-xs-10">
					<h4><?php esc_html_e('ECC Data Level', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Error Code Correction is their ability to sustain "damage" and continue to function even when a part of the QR code image is obscured. Level L or Level M represent the best compromise between density and ruggedness for general marketing use. ', 'openaffiliates');?></p>
					<select name="af_qr_code_ecc_level">
						<?php foreach (array('l' => 'L', 'm' => 'M', 'q' => 'Q', 'h' => 'H') as $k=>$v): ?>
							<?php $selected = ($k==$data['metas']['af_qr_code_ecc_level']) ? 'selected' : '';?>
							<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>


			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
		</div>
		</div>
	</div>
</form>
</div>
