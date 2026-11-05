<div class="af-wrapper">
			<form  method="post">

				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Opt-In Integrations Settings', 'openaffiliates');?><span class="af-admin-need-help"><i class="fa-af fa-help-af"></i><a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank"><?php esc_html_e('Need Help?', 'openaffiliates');?></a></span></h3>
					<div class="inside">
<?php af_external_service_notice( 'the name, e-mail address and IP address of each new affiliate', 'the e-mail marketing service you select below' );?>
						<div class="af-form-line">
							<h2><?php esc_html_e('Enable Opt-In Integrations', 'openaffiliates');?></h2>
							<label class="af_label_shiwtch af-switch-button-margin">
								<?php $checked = ($data['metas']['af_register_opt-in']) ? 'checked' : '';?>
								<input type="checkbox" class="af-switch" onClick="afCheckAndH(this, '#af_register_opt-in');" <?php echo esc_attr($checked);?> />
								<div class="switch af-display-inline"></div>
							</label>
							<input type="hidden" name="af_register_opt-in" value="<?php echo esc_attr($data['metas']['af_register_opt-in']);?>" id="af_register_opt-in" />
						</div>
						<div class="af-form-line">
								<h2><?php esc_html_e('Opt-In Destination', 'openaffiliates');?></h2>
			                	<select name="af_register_opt-in-type">
			                    	    <?php
			                        	    $subscribe_types = array(
			                                                                    'aweber' => 'AWeber',
																																					'active_campaign' => 'Active Campaign',
			                                                                    'campaign_monitor' => 'CampaignMonitor',
			                                                                    'constant_contact' => 'Constant Contact',
			                                                                    'email_list' => esc_html__('E-mail List', 'openaffiliates'),
			                                                                    'get_response' => 'GetResponse',
			                                                                    'icontact' => 'IContact',
			                                                                    'mailchimp' => 'MailChimp',
			                                                                    'mymail' => 'Mailster (MyMail)',
			                                                                    'wysija' => 'Wysija',
			                                                                 );
			                                foreach ($subscribe_types as $k=>$v){
			                                    $selected = ($data['metas']['af_register_opt-in-type']==$k) ? 'selected' : '';
			                                    ?>
			                                    <option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php
			                            	     	echo esc_html($v);
			                                    ?></option>
			                                    <?php
			                                }
			                                ?>
			                    </select>
						<p><?php esc_html_e('During the registration process, the affiliate email address is sent to your OptIn destination.', 'openaffiliates');?></p>
						</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>

				<div class="af-stuffbox">
					<h3 class="af-h3">Active Campaign</h3>
					<div class="af-form-line">
					<div class="inside">
						<div class="row">
							<div class="col-xs-6">
					   		<div class="input-group">
					           <span class="input-group-addon"> <?php esc_html_e('Api URL', 'openaffiliates');?></span>

					            <input type="text" value="<?php echo esc_attr($data['metas']['af_active_campaign_apiurl']);?>" name="af_active_campaign_apiurl" class="form-control">
									</div>
									<div class="af-form-line"></div>
								<div class="input-group">
					           <span class="input-group-addon"> <?php esc_html_e('Api Key:', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_active_campaign_apikey']);?>" name="af_active_campaign_apikey" class="form-control">
								</div>
								<div class="af-form-line"></div>
								<div class="input-group">
					           <span class="input-group-addon"> <?php esc_html_e('List ID:', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_active_campaign_listId']);?>" name="af_active_campaign_listId" class="form-control">
								</div>
							</div>
						</div>
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
				<div class="af-stuffbox">
					<h3 class="af-h3"><?php esc_html_e('Additional Main E-Mail', 'openaffiliates');?></h3>
					<div class="inside">
						<input type="text" name="af_main_email" value="<?php echo esc_attr($data['metas']['af_main_email']);?>"  class="af-optin-input" />
						<div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>


				<div class="af-stuffbox">
					<h3 class="af-h3">Aweber</h3>
					<div class="inside">
						<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
									 <div class="af-labels-special"><?php esc_html_e('Auth Code', 'openaffiliates');?></div>
					            <textarea id="af_aweber_auth_code" name="af_aweber_auth_code" class="af-dashboard-textarea"><?php
					            	echo esc_af_content($data['metas']['af_aweber_auth_code']);
					            ?></textarea>

								</div>
								<a href="https://auth.aweber.com/1.0/oauth/authorize_app/751d27ee" target="_blank" class="af-info-link">
									<?php esc_html_e('Get Your Auth Code From Here', 'openaffiliates');?>
								</a>
								<div class="af-form-line"></div>
								<div class="input-group">
  									 <span class="input-group-addon"><?php esc_html_e('Unique List ID:', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_aweber_list']);?>" name="af_aweber_list" class="form-control">
											</div>
					            <a href="https://www.aweber.com/users/settings/" target="_blank" class="af-info-link">
					              <?php esc_html_e('Get Unique List ID', 'openaffiliates');?><br>
					            </a>
									<div class="af-form-line"></div>
					            <div onclick="afConnectAweber( '#af_aweber_auth_code' );" class="button button-primary button-large">
					              <?php esc_html_e('Connect', 'openaffiliates');?>
					            </div>


					    <div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
		</div>

				<div class="af-stuffbox">
					<h3 class="af-h3">Mailchimp</h3>
					<div class="inside">
						<div class="row">
						  <div class="col-xs-6">
						    <div class="input-group">
						         <span class="input-group-addon"><?php esc_html_e('API Key', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_mailchimp_api']);?>" name="af_mailchimp_api" class="form-control">
								</div>
					            <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find my API Key?', 'openaffiliates');?>
					            </a>
									<div class="af-form-line"></div>
								<div class="input-group">
					            <span class="input-group-addon"><?php esc_html_e('ID List', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_mailchimp_id_list']);?>" name="af_mailchimp_id_list" class="form-control">
								</div>
					            <a href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id/" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find List ID?', 'openaffiliates');?>
					            </a>
					    <div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
		</div>

				<div class="af-stuffbox">
					<h3 class="af-h3">Get Response</h3>
					<div class="inside">
						<div class="row">
							<div class="col-xs-6">
								<div class="input-group">
										 <span class="input-group-addon">GetResponse <?php esc_html_e('API Key', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_getResponse_api_key']);?>" name="af_getResponse_api_key" class="form-control">
					        </div>
					            <a href="http://www.getresponse.com/learning-center/glossary/api-key.html" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find my API Key?', 'openaffiliates');?></a>

										<div class="af-form-line"></div>

									<div class="input-group">
											<span class="input-group-addon">GetResponse <?php esc_html_e('List Token', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_getResponse_token']);?>" name="af_getResponse_token" class="form-control">
									</div>
					            <a href="https://app.getresponse.com/campaign_list.html " target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find List Token?', 'openaffiliates');?>
					            </a>

					    <div id="af_save_changes" class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
		</div>


				<div class="af-stuffbox">
					<h3 class="af-h3">Campaign Monitor</h3>
					<div class="inside">
						<div class="row">
							<div class="col-xs-6">
								<div class="input-group">
										 <span class="input-group-addon">CampaignMonitor <?php esc_html_e('API Key', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_cm_api_key']);?>" name="af_cm_api_key" class="form-control">
					        </div>
					            <a href="https://www.campaignmonitor.com/api/getting-started/#apikey" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find API Key ?', 'openaffiliates');?>
					            </a>
					          <div class="af-form-line"></div>
								<div class="input-group">
					         		<span class="input-group-addon">CampaignMonitor <?php esc_html_e('List ID', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_cm_list_id']);?>" name="af_cm_list_id" class="form-control">
					       </div>
					            <a href="https://www.campaignmonitor.com/api/clients/#subscriber_lists" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I find List ID?', 'openaffiliates');?>
					            </a>

					    <div id="af_save_changes"  class="af-submit-form">
							<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
						</div>
					</div>
				</div>
			</div>
		</div>

				<div class="af-stuffbox">
					<h3 class="af-h3">IContact</h3>
					<div class="inside">
						<div class="row">
							<div class="col-xs-6">
								<div class="input-group">
										 <span class="input-group-addon">iContact <?php esc_html_e('Username', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_icontact_user']);?>" name="af_icontact_user" class="form-control">
								</div>
								<div class="af-form-line"></div>
								<div class="input-group">
					           <span class="input-group-addon"> iContact <?php esc_html_e('App ID', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_icontact_appid']);?>" name="af_icontact_appid" class="form-control">
								</div>
					            <a href="http://www.icontact.com/developerportal/documentation/register-your-app/" target="_blank" class="af-info-link">
					              <?php esc_html_e('Where can I get my App ID?', 'openaffiliates');?>
					            </a>
								<div class="af-form-line"></div>
					       <div class="input-group">
					            <span class="input-group-addon">iContact <?php esc_html_e('App Password', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_icontact_pass']);?>" name="af_icontact_pass" class="form-control">
								 </div>
								 <div class="af-form-line"></div>
					     	 <div class="input-group">
					           <span class="input-group-addon"> iContact <?php esc_html_e('List ID', 'openaffiliates');?></span>
					            <input type="text" value="<?php echo esc_attr($data['metas']['af_icontact_list_id']);?>" name="af_icontact_list_id" class="form-control">
					      	</div>
					              <a href="https://app.icontact.com/icp/core/mycontacts/lists" target="_blank" class="af-info-link">
					                <?php esc_html_e('Click on the list name:', 'openaffiliates');?>
					              </a>

					</div>
				</div>
				<div><?php esc_html_e('Click on the list name and get the ID from the URL', 'openaffiliates');?> (ex:  https://app.icontact.com/icp/core/mycontacts/lists/edit/
				<b>
					ID_LIST
				</b>
				/?token=f155cba025333b071d49974c96ae0894 )</div>
				<div id="af_save_changes" class="af-submit-form">
				<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
			</div>
				</div>
			</div>

			<div class="af-stuffbox">
				<h3 class="af-h3">Constant Contact</h3>
				<div class="inside">
					<div class="row">
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon">Constant Contact <?php esc_html_e('Username', 'openaffiliates');?></span>
				            <input type="text" value="<?php echo esc_attr($data['metas']['af_cc_user']);?>" id="af_cc_user" name="af_cc_user" class="form-control">
							</div>

							<div class="af-form-line"></div>

							<div class="input-group">
									<span class="input-group-addon">Constant Contact <?php esc_html_e('Password', 'openaffiliates');?></span>
				            <input type="password" value="<?php echo esc_attr($data['metas']['af_cc_pass']);?>" id="af_cc_pass" name="af_cc_pass" class="form-control">
							</div>
							<div class="af-form-line"></div>
				            <div onclick="afGetCcList( '#af_cc_user', '#af_cc_pass' );" class="button button-primary button-large">
				              <?php esc_html_e('Get Lists', 'openaffiliates');?>
				            </div>
							<div class="af-form-line"></div>

								<div class="input-group">
										 <span class="af-labels-special">Constant Contact <?php esc_html_e('List', 'openaffiliates');?></span>
				            <select id="af_cc_list" name="af_cc_list" class="af-optin-input">
				            	<?php
				            		$list_name = '';
				            		if (isset($data['metas']['af_cc_list']) && $data['metas']['af_cc_list']){
				            			//getting list name by id
				            			include_once AF_PATH . 'classes/services/email_services/constantcontact/class.cc.php';
				            			$cc = new cc($data['metas']['af_cc_user'], $data['metas']['af_cc_pass']);
				            			$list_arr= $cc->get_list($data['metas']['af_cc_list']);
				            			if(isset($list_arr['Name'])){
														 $list_name = $list_arr['Name'];
													}
				            		}
				            	?>
				            	<option value="<?php echo esc_attr($data['metas']['af_cc_list']);?>"><?php echo esc_html($list_name);?></option>
				            </select>
									</div>
					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
					</div>
				</div>
			</div>
		</div>


			<div class="af-stuffbox">
				<h3 class="af-h3">Wysija Contact</h3>
				<div class="inside">
				    <table>
				      <tbody>
				        <tr>
				          <td>
				            <?php esc_html_e('Select Wysija List:', 'openaffiliates');?>
				          </td>
				          <td>
		                  	<?php
		                        $wysija_list = $obj->af_returnWysijaList();
		                        if ($wysija_list && count($wysija_list)>0){
		                        	?>
		                            <select name="af_wysija_list_id">
		                            	<?php
		                                	foreach ($wysija_list as $k=>$v){
		                                		$selected = '';
		                                		if($data['metas']['af_wysija_list_id']==$k){
																					 $selected = 'selected="selected"';
																				}
		                                        ?>
		                                        	<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
		                                        <?php
		                                    }
		                                ?>
		                            </select>
		                     <?php
		                     	}else echo esc_html__("No List available ", 'openaffiliates') . "<input type='hidden' name='af_wysija_list_id' value=''/> ";
		                     ?>
				          </td>
				        </tr>
				      </tbody>
				    </table>
					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
				</div>
			</div>

			<div class="af-stuffbox">
				<h3 class="af-h3">Mailster (MyMail)</h3>
				<div class="inside">
				            <div class="af-labels-special"><?php esc_html_e('Select MyMail List:', 'openaffiliates');?></div>
							<?php
		                    	$mymailList = $obj->af_getMyMailLists();
		                        if ($mymailList){
		                        	?>
		                            <select name="af_mymail_list_id">
		                            	<?php
		                                foreach ($mymailList as $k=>$v){
		                                	$selected = '';
		                                	if ($data['metas']['af_mymail_list_id']==$k){
																				 $selected = 'selected="selected"';
																			}
		                                    ?>
		                                    	<option value="<?php echo esc_attr($k);?>" <?php echo esc_attr($selected);?> ><?php echo esc_html($v);?></option>
		                                <?php
		                                }
		                                ?>
		                            </select>
		                    <?php
		                    	}else echo esc_html__('No List available', 'openaffiliates') . " <input type='hidden' name='af_mymail_list_id' value=''/> ";
				          	?>

					<div id="af_save_changes" class="af-submit-form">
						<input type="submit" value="<?php esc_html_e('Save Changes', 'openaffiliates');?>" name="save" class="button button-primary button-large" />
					</div>
				</div>
			</div>

			<div class="af-stuffbox">
				<h3 class="af-h3"><?php esc_html_e('Saved E-mail List', 'openaffiliates');?></h3>
				<div class="inside">
				    <textarea disabled  class="af-custom-css-box"><?php
				    	echo esc_af_content($data['metas']['af_email_list']);
				    ?></textarea>
				</div>
			</div>
		</form>
</div>
