<div class="af-wrapper">

	<div class="col-right">

			<div class="af-page-title"><?php esc_html_e('Open Affiliates - Filters & Hooks', 'openaffiliates');?></div>

		        <?php if ( $data ):?>
		            <table class="wp-list-table widefat fixed tags af-admin-tables" >
										<thead>
				                <tr>
				                    <th class="manage-column"><?php esc_html_e('Name', 'openaffiliates');?></th>
						                <th class="manage-column" s width"10%"><?php esc_html_e('Type', 'openaffiliates');?></th>
				                    <th class="manage-column"><?php esc_html_e('Description', 'openaffiliates');?></th>
				                    <th class="manage-column"><?php esc_html_e('File', 'openaffiliates');?></th>
				                </tr>
										</thead>
										<tbody>
				            <?php foreach ( $data as $hookName => $hookData ):?>
				                <tr>
				                    <td class="manage-column"><?php echo esc_html($hookName);?></td>
						                <td class="manage-column"><?php echo esc_html($hookData['type']);?></td>
				                    <td class="manage-column"><?php echo esc_af_content($hookData['description']);?></td>
				                    <td class="manage-column af-hooks-files">
																<?php if ( $hookData['file'] && is_array( $hookData['file'] ) ):?>
																		<?php foreach ( $hookData['file'] as $file ):?>
																				<div><?php echo esc_af_content($file);?></div>
																		<?php endforeach;?>
																<?php endif;?>
														</td>
				                </tr>
				            <?php endforeach;?>
										</tbody>
										<tfoot>
												<tr>
														<th class="manage-column"><?php esc_html_e('Name', 'openaffiliates');?></th>
														<th class="manage-column" width"10%"><?php esc_html_e('Type', 'openaffiliates');?></th>
														<th class="manage-column"><?php esc_html_e('Description', 'openaffiliates');?></th>
														<th class="manage-column"><?php esc_html_e('File', 'openaffiliates');?></th>
												</tr>
										</tfoot>
								</table>
		        <?php endif;?>

	</div>

</div>
