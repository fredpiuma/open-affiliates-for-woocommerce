<div class="af-wrapper">
<form  method="post">

	<input type="hidden" name="af_admin_forms_nonce" value="<?php echo wp_create_nonce( 'af_admin_forms_nonce' );?>" />

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Payout Settings', 'openaffiliates');?></h3>
		<div class="inside">

	<div class="af-form-line">
		<div class="row">
				<div class="col-xs-12">
					<h4><?php esc_html_e('Default Payment System', 'openaffiliates');?></h4>
					<p><?php esc_html_e('When a new Affiliate SignUp this will be his payment system for Payout.', 'openaffiliates');?></p>
				</div>
				<div class="col-xs-8">
						<select name="af_default_payment_system" class="form-control m-bot15"><?php
							if ($data['payment_types']){
								foreach ($data['payment_types'] as $k=>$v):
									$selected = ($k==$data['metas']['af_default_payment_system']) ? 'selected' : '';
									?>
									<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
									<?php
								endforeach;
							}
						?></select>
					</div>
			</div>
		</div>
		<div class="af-form-line">
			<div class="row">
					<div class="col-xs-12">
						<h4><?php esc_html_e('Referral Grace Period Days', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Choose the Grace Period number of days for Verified Referrals. This one is used during Payout process to minimize the chances of paying Affiliates for Referrals while you are still liable to issue a refund. Choose the value related to your store refund policy.', 'openaffiliates');?></p>
					</div>
					<div class="col-xs-8">
								<input type="number" min="0" name="af_payments_grace_period" value="<?php echo stripslashes( $data['metas']['af_payments_grace_period'] );?>" id="af_payments_grace_period"  class="form-control"/>
						</div>
				</div>
			</div>
			<div class="af-form-line">
				<div class="row">
						<div class="col-xs-12">
							<h4><?php esc_html_e('Minimum Payout Amount', 'openaffiliates');?></h4>
							<p><?php esc_html_e("Establish the minimum payout threshold. This figure is employed to avoid disbursing negligible sums to affiliates. Affiliates won't appear in Payments section until their unpaid referrals, meeting the selected criteria, reach or exceed this set amount.", 'openaffiliates');?></p>
						</div>
						<div class="col-xs-8">
							<div class="input-group">
									<input type="number" min="0" name="af_payments_minimum_amount" value="<?php echo stripslashes( $data['metas']['af_payments_minimum_amount'] );?>" id="af_payments_minimum_amount"  class="form-control"/>
									<div class="input-group-addon"><?php echo $currency ; ?></div>
							</div>
							</div>
					</div>
				</div>
		<div class="af-form-line">
				<div class="row">
					<div class="col-xs-12">
						<h4><?php esc_html_e('Hide Payment Warnings', 'openaffiliates');?></h4>
						<p><?php esc_html_e("A notification will appear if an affiliate user hasn't finalized the payment settings for Payout", 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_hide_payments_warnings']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_hide_payments_warnings');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_hide_payments_warnings" value="<?php echo esc_attr($data['metas']['af_hide_payments_warnings']);?>" id="af_hide_payments_warnings" />
					</div>
				</div>
					<div class="row">
						<div class="col-xs-12">
							<h5><?php esc_html_e('Custom Warning Message when Payout Service is missing', 'openaffiliates');?></h5>
						</div>
						<div class="col-xs-8">
							<div class="form-group">
								<input type="text" name="af_payments_warnings_message" value="<?php echo stripslashes( $data['metas']['af_payments_warnings_message'] );?>" id="af_payments_warnings_message"  class="form-control"/>
							</div>
						</div>
						</div>
					</div>

			<div class="af-form-line">
				<div class="row">
					<div class="col-xs-12">
						<h4><?php esc_html_e('Disable Direct Deposit', 'openaffiliates');?></h4>
						<p><?php esc_html_e('Affiliates will not be able to choose Direct Deposit anymore as Payment option for Payout.', 'openaffiliates');?></p>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_disable_bt_payment_system']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_disable_bt_payment_system');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_disable_bt_payment_system" value="<?php echo esc_attr($data['metas']['af_disable_bt_payment_system']);?>" id="af_disable_bt_payment_system" />
						</div>
				</div>
			</div>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>


		</div>
	</div>
</form>
</div>
