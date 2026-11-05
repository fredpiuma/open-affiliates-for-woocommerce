<?php
	$ranks = $af_db->get_rank_list();

	$available_systems = $af_db->getPossibleSources();
	$source_arr = [];
	if ( $available_systems ){
			foreach($available_systems as $k=>$v){
					$label = af_service_type_code_to_title($v['source']);
					if ( $label === '' ){
							continue;
					}
					$source_arr[$v['source']] = $label;
			}
	}

if ( isset( $responseFromImportCSV ) && count( $responseFromImportCSV ) > 0 && isset( $responseFromImportCSV['status'] ) && isset( $responseFromImportCSV['message'] ) ):?>
		<?php
			switch ( $responseFromImportCSV['status'] ){
					case 0:
						$messageClass = 'af-danger-box';
						break;
					case 1:
						$messageClass = 'af-success-box';
						break;
					case -1:
						$messageClass = 'af-warning-box';
						break;
			}
		?>
		<div class="<?php echo $messageClass;?>"><?php echo $responseFromImportCSV['message'];?></div>
<?php endif;?>

<div class="af-wrapper af-export-import-section-wrap">
	<form  method="post">
		<div class="af-stuffbox">
			<h3 class="af-h3"><?php esc_html_e('Export CSV Files', 'openaffiliates');?></h3>
			<div class="inside">
				<div class="af-form-line">
					<h2><?php esc_html_e('Export Affiliates', 'openaffiliates');?></h2>
					<p><?php esc_html_e('Export your affiliates list to a CSV file to access detailed information about your affiliates in a convenient format.', 'openaffiliates');?></p>
				</div>
				<div class="af-form-line af-export-csv-filters-wrap">

					<div class="af-datatable-filters-wrapper"  id="af_js_import_export_wrapp_for_affiliates">

							<input type="text" value="" placeholder="Search" class="af-js-search-phrase">
							<div class="af-datatable-multiselect-wrapp">
									<select name="ranks[]" class="af-js-import-export-affiliates-filter-ranks" multiple data-placeholder="<?php esc_html_e("Ranks", 'openaffiliates');?>">
											<?php if ( $ranks ):?>
													<?php foreach ( $ranks as $rankId => $rankLabel ):?>
															<option value="<?php echo $rankId;?>"><?php echo $rankLabel;?></option>
													<?php endforeach;?>
											<?php endif;?>

									</select>
							</div>
							<div class="af-datatable-filter-bttn js-af-export-csv af-js-affiliates-export-run-bttn" data-filters="" data-export_type="affiliates"><?php esc_html_e( 'Export CSV', 'openaffiliates' );?>

					</div>

				</div>
			</div>
					<div class="af-form-line">
						<h2><?php esc_html_e('Export Referrals', 'openaffiliates');?></h2>
						<p><?php esc_html_e('Export all referrals data to a CSV file for detailed analysis and reporting.', 'openaffiliates');?></p>
					</div>
					<div class="af-form-line af-export-csv-filters-wrap">

						<div class="af-datatable-filters-wrapper" id="af_js_import_export_wrapp_for_referrals" >

										<input type="text" value="" placeholder="Search" class="af-js-search-phrase-referrals">

										<!--label class="af-label"><?php esc_html_e('Start:', 'openaffiliates');?></label-->
										<input type="text" name="udf" value="" class="af-no-margin-right af-js-referrals-start-date" placeholder="From - yyyy-mm-dd"/>
										<!--label class="af-label"><?php esc_html_e('Until:', 'openaffiliates');?></label--><span class="af-date-line">-</span>
										<input type="text" name="udu" value="" class="af-js-referrals-end-date" placeholder="To - yyyy-mm-dd"/>

										<div class="af-datatable-multiselect-wrapp af-filter-status-select">
											<select name="status_in[]" class="af-js-import-export-referrals-filter-status" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
												 	<option value="2"><?php esc_html_e( 'Approved', 'openaffiliates' );?></option>
													<option value="1"><?php esc_html_e( 'Pending', 'openaffiliates' );?></option>
													<option value="0"><?php esc_html_e( 'Rejected', 'openaffiliates' );?></option>
											</select>
										</div>

										<?php if ( $source_arr ):?>
										<div class="af-datatable-multiselect-wrapp">
											<select name="source_in[]" class="af-js-import-export-referrals-filter-source" multiple data-placeholder="<?php esc_html_e("Source", 'openaffiliates');?>">
														<?php foreach ( $source_arr as $sourceSlug => $sourceLabel ):?>
															<option value="<?php echo $sourceSlug;?>" ><?php echo $sourceLabel;?></option>
														<?php endforeach;?>
											</select>
										</div>
										<?php endif;?>

										<div class="af-datatable-filter-bttn js-af-export-csv af-js-referrals-export-run-bttn" data-filters="" data-export_type="referrals"><?php esc_html_e( 'Export CSV', 'openaffiliates' );?>
										</div>
						</div>

					</div>

					<div class="af-form-line">
						<h2><?php esc_html_e('Export Clicks', 'openaffiliates');?></h2>
						<p><?php esc_html_e('Export all click data to a CSV file for comprehensive analysis and reporting.', 'openaffiliates');?></p>
					</div>
					<div class="af-form-line af-export-csv-filters-wrap">
						<div class="af-datatable-filters-wrapper" id="af_js_import_export_wrapp_for_visits" >

										<input type="text" value="" placeholder="Search" class="af-js-search-phrase-visits">

										<!--label class="af-label"><?php esc_html_e('Start:', 'openaffiliates');?></label-->
										<input type="text" name="udf" value="" class="af-no-margin-right af-js-visits-start-date" placeholder="From - yyyy-mm-dd"/>
										<!--label class="af-label"><?php esc_html_e('Until:', 'openaffiliates');?></label--><span class="af-date-line">-</span>
										<input type="text" name="udu" value="" class="af-js-visits-end-date" placeholder="To -yyyy-mm-dd"/>

										<div class="af-datatable-multiselect-wrapp">
											<select name="status_in[]" class="af-js-import-export-visits-filter-status" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
													<option value="0"><?php esc_html_e( 'Just Visit', 'openaffiliates' );?></option>
													<option value="1"><?php esc_html_e( 'Converted', 'openaffiliates' );?></option>
											</select>
										</div>
										<div class="af-datatable-filter-bttn js-af-export-csv af-js-visits-export-run-bttn" data-filters=""  data-export_type="visits"><?php esc_html_e( 'Export CSV', 'openaffiliates' );?>
									</div>

						</div>
					</div>

					<div class="af-form-line">
						<h2><?php esc_html_e('Export Payout Payments', 'openaffiliates');?></h2>
						<p><?php esc_html_e('Export all Payout Payments to a CSV file in a convenient format for furhter management.', 'openaffiliates');?></p>
					</div>
					<div class="af-form-line af-export-csv-filters-wrap">
						<div class="af-datatable-filters-wrapper" id="af_js_import_export_wrapp_for_payouts" >

										<input type="text" value="" placeholder="Search" class="af-js-search-phrase">

										<!--label class="af-label"><?php esc_html_e('Start:', 'openaffiliates');?></label-->
										<input type="text" name="udf" value="" class="af-no-margin-right af-js-payouts-start-date" placeholder="From - yyyy-mm-dd"/>
										<!--label class="af-label"><?php esc_html_e('Until:', 'openaffiliates');?></label--><span class="af-date-line">-</span>
										<input type="text" name="udu" value="" class="af-js-payouts-end-date" placeholder="To -yyyy-mm-dd"/>

										<div class="af-datatable-multiselect-wrapp">
											<select name="status_in[]" class="af-js-import-export-payouts-filter-status" multiple data-placeholder="<?php esc_html_e("Status", 'openaffiliates');?>">
													<option value="0"><?php esc_html_e( 'Failed', 'openaffiliates' );?></option>
													<option value="1"><?php esc_html_e( 'Pending', 'openaffiliates' );?></option>
													<option value="2"><?php esc_html_e( 'Completed', 'openaffiliates' );?></option>
											</select>
										</div>
										<div class="af-datatable-filter-bttn js-af-export-csv af-js-payouts-export-run-bttn" data-filters=""  data-export_type="payouts"><?php esc_html_e( 'Export CSV', 'openaffiliates' );?>
									</div>

						</div>
					</div>
			</div>
		</div>
	</form>
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Export Settings', 'openaffiliates');?></h3>
		<div class="inside">

				<!--div class="af-form-line">
					<h4><?php esc_html_e('Export Affiliates', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Export the Affiliates for this site as a .xml file. This allows you to easily import them into another site.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<input type="checkbox" class="iump-switch" onClick="afCheckAndH(this, '#import_users');" />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="import_users" value=0 id="import_users"/>
				</div -->
				<div class="af-form-line">
					<h4><?php esc_html_e('Export Settings', 'openaffiliates');?></h4>
					<p><?php esc_html_e('Export the Open Affiliates settings for this site as a .xml file. This allows you to easily import the configuration into another site.', 'openaffiliates');?></p>
					<label class="af_label_shiwtch af-switch-button-margin">
						<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#import_settings');" />
						<div class="switch af-display-inline"></div>
					</label>
					<input type="hidden" name="import_settings" value=0 id="import_settings"/>
				</div>

			<div class="af-form-line">
				<div class="af-hidden-download-results">
						<div class="af-hidden-download-link af-display-none">
							<h4><?php esc_html_e('Export File', 'openaffiliates');?></h4>
							<?php esc_html_e('Your Export file is ready to download through this link:', 'openaffiliates');?> <a href="" target="_blank" download>export.xml</a>
						</div>
						<div class="af-display-inline" id="af_loading_gif" ><span class="spinner"></span></div>
				</div>
			</div>

			<div id="af_save_changes" class="af-wrapp-submit-bttn af-submit-form">
				<div class="button button-primary button-large af-display-inline" onClick="afMakeExportFile();"><?php esc_html_e('Generate XML file', 'openaffiliates');?></div>

			</div>

		</div>
	</div>
</form>

<form  method="post" enctype="multipart/form-data">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Import Settings', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h4><?php esc_html_e('Import XML File', 'openaffiliates');?></h4>
				<p><?php esc_html_e('Import the .xml file from another WordPress website that was created using the Open Affiliates plugin.', 'openaffiliates');?></p>

				<input type="file" name="import_file" />
			</div>

			<input type="hidden" name="af_admin_import_nonce" value="<?php echo wp_create_nonce( 'af_admin_import_nonce' );?>" />

			<div id="af_save_changes" class="af-wrapp-submit-bttn af-submit-form">
				<input type="submit" value="<?php esc_html_e('Import XML File', 'openaffiliates');?>" name="import" class="button button-primary button-large">
			</div>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Import Affiliates', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h4><?php esc_html_e('Import CSV File', 'openaffiliates');?></h4>
				<p><?php esc_html_e('Import the .csv file from another WordPress website that was created using the Open Affiliates plugin.', 'openaffiliates');?></p>

				<input type="file" name="import_file_affiliates" />
			</div>

			<input type="hidden" name="af_admin_import_nonce" value="<?php echo wp_create_nonce( 'af_admin_import_nonce' );?>" />

			<div id="af_save_changes" class="af-wrapp-submit-bttn af-submit-form">
				<input type="submit" value="<?php esc_html_e('Import CSV File', 'openaffiliates');?>" name="import_csv_affiliates" class="button button-primary button-large">
			</div>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('Import Referrals', 'openaffiliates');?></h3>
		<div class="inside">
			<div class="af-form-line">
				<h4><?php esc_html_e('Import CSV File', 'openaffiliates');?></h4>
				<p><?php esc_html_e('Import the .csv file from another WordPress website that was created using the Open Affiliates plugin.', 'openaffiliates');?></p>

				<input type="file" name="import_file_referrals" />
			</div>

			<input type="hidden" name="af_admin_import_nonce" value="<?php echo wp_create_nonce( 'af_admin_import_nonce' );?>" />

			<div id="af_save_changes" class="af-wrapp-submit-bttn af-submit-form">
				<input type="submit" value="<?php esc_html_e('Import CSV File', 'openaffiliates');?>" name="import_csv_referrals" class="button button-primary button-large">
			</div>
		</div>
	</div>

</form>

</div>
