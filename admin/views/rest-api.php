<div class="af-wrapper">
<form  method="post">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e('REST API', 'openaffiliates');?></h3>
		<div class="inside">

			<div class="af-form-line">
				<h2><?php esc_html_e('Activate/Hold Customize Menu', 'openaffiliates');?></h2>
				<label class="af_label_shiwtch af-switch-button-margin">
					<?php $checked = ($data['metas']['af_rest_api_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_rest_api_enabled');" <?php echo esc_attr($checked);?> />
					<div class="switch af-display-inline"></div>
				</label>
				<input type="hidden" name="af_rest_api_enabled" value="<?php echo esc_attr($data['metas']['af_rest_api_enabled']);?>" id="af_rest_api_enabled" />
			</div>


			<p><?php esc_html_e( 'In order to use this REST API, you must do a basic authentication with your username and password.', 'openaffiliates' );?></p>
			<p>
					ex:
					<code>
						$wp_request_headers = array(
						  'Authorization' => 'Basic ' . base64_encode( 'username:password' )
						);
						$wp_request_url = '{endpoint}';
						$response = wp_remote_request(
						  $wp_request_url,
						  array(
						      'method'    => 'POST',
						      'headers'   => $wp_request_headers
						  )
						);
					</code>
			</p>

			<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>

		</div>
	</div>


</form>

<?php
$endpoints = [
		'getAffiliates'						=> [
						'title' 	=> esc_html__('List Affiliates', 'openaffiliates'),
						'link'		=> 'affiliates',
						'method'	=> 'GET',
						'args'		=> 'page, limit',
						'extra'		=> '',
		],
		'approveAffiliate'				=> [
						'title' 	=> esc_html__('Approve affiliate', 'openaffiliates'),
						'link'		=> 'approve-affiliate/{affiliateId}',
						'method'	=> 'POST',
						'args'		=> 'affiliateId',
						'extra'		=> '',
		],
		'updateAffiliateRank'			=> [
						'title' 	=> esc_html__('Update affiliate rank', 'openaffiliates'),
						'link'		=> 'update-affiliate-rank/{affiliateId}/{newRankId}',
						'method'	=> 'POST',
						'args'		=> 'affiliateId, rankId',
						'extra'		=> '',
		],
		'getAllUserData'					=> [
						'title' 	=> esc_html__('Get user data', 'openaffiliates'),
						'link'		=> 'get-user-data/{affiliateId}',
						'method'	=> 'GET',
						'args'		=> 'affiliateId',
						'extra'		=> '',
		],
		'getUserFieldValue'				=> [
						'title' 	=> esc_html__('Get user field value', 'openaffiliates'),
						'link'		=> 'get-user-field-value/{affiliateId}/{fieldName}',
						'method'	=> 'GET',
						'args'		=> 'affiliateId, fieldName',
						'extra'		=> '',
		],
		'getAffiliateRank'				=> [
						'title' 	=> esc_html__('Get affiliate rank', 'openaffiliates'),
						'link'		=> 'get-affiliate-rank/{affiliateId}',
						'method'	=> 'GET',
						'args'		=> 'affiliateId',
						'extra'		=> '',
		],
		'getAffiliateRankDetails' => [
						'title' 	=> esc_html__('Get affiliate rank details', 'openaffiliates'),
						'link'		=> 'get-affiliate-rank-details/{affiliateId}',
						'method'	=> 'GET',
						'args'		=> 'affiliateId',
						'extra'		=> '',
		],
		'searchAffiliate'					=> [
						'title' 	=> esc_html__('Search Affiliate', 'openaffiliates'),
						'link'		=> 'search-affiliate/{search}',
						'method'	=> 'GET',
						'args'		=> 'search',
						'extra'		=> '',
		],
		'listRanks'								=> [
						'title' 	=> esc_html__('List Ranks', 'openaffiliates'),
						'link'		=> 'list-ranks',
						'method'	=> 'GET',
						'args'		=> '',
						'extra'		=> '',
		],
		'getAffiliatesByRank'			=> [
						'title' 	=> esc_html__('Get affiliates by rank', 'openaffiliates'),
						'link'		=> 'list-affiliates-by-rank/{rankId}',
						'method'	=> 'GET',
						'args'		=> 'rankId',
						'extra'		=> '',
		],
		'makeUserAffiliate'				=> [
						'title' 	=> esc_html__('Make user affiliate', 'openaffiliates'),
						'link'		=> 'make-user-affiliate/{userId}',
						'method'	=> 'PUT',
						'args'		=> 'userId',
						'extra'		=> '',
		],
		'listReferrals'						=> [
						'title' 	=> esc_html__('List Referrals', 'openaffiliates'),
						'link'		=> 'list-referrals',
						'method'	=> 'GET',
						'args'		=> '',
						'extra'		=> '',
		],
		'createReferral'							=> [
						'title' 	=> esc_html__('Add Referral', 'openaffiliates'),
						'link'		=> 'add-referral',
						'method'	=> 'PUT',
						'args'		=> 'json with all referral details',
						'extra'		=> 'Example: {
														"refferal_wp_uid": 2,
														"campaign": "",
														"affiliate_id": "",
														"visit_id": "",
														"description": "test",
														"source": "restapi",
														"reference": "q",
														"reference_details": "test",
														"parent_referral_id": "test",
														"child_referral_id": "",
														"amount": 10,
														"currency": "usd",
														"date": "12-02-2018",
														"status": 1,
														"payment": 0
					}'
		],

];
?>
			<?php foreach ($endpoints as $array):?>
					<div class="af-stuffbox">
						<h3 class="af-h3"><?php echo esc_af_content($array['title']);?></h3>
						<div class="inside">
							<div class="af-form-line">
								<p class="af-api-link"><?php echo esc_url($data['base_url'] . '/wp-json/openaffiliates/v1/' . $array['link']);?></p>
								<p><?php echo esc_af_content('<strong>' . esc_html__('Method: ', 'openaffiliates') . '</strong>' . $array['method']);?></p>
								<p><?php echo esc_af_content('<strong>' . esc_html__('Arguments: ', 'openaffiliates') . '</strong>' . $array['args']);?></p>
								<p><?php echo esc_af_content($array['extra']);?></p>
							</div>
						</div>
					</div>
			<?php endforeach;?>

</div>
