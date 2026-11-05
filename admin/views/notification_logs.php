<?php
global $af_db;
$uid = isset( $_GET['uid'] ) ? sanitize_text_field($_GET['uid']) : 0;
$notification_arr = $af_db->notificationsActions();
//


$totalItems = \OpenAffiliates\Db\NotificationLogs::getCount( $uid );


  $url = admin_url( 'admin.php?page=openaffiliates&tab=notification-logs' );
  $limit = 25;
  $currentPage = (empty($_GET['p'])) ? 1 : sanitize_text_field($_GET['p']);
  if ($currentPage>1){
    $offset = ( $currentPage - 1 ) * $limit;
  } else {
    $offset = 0;
  }
  require_once AF_PATH . 'classes/AfPagination.class.php';
  $pagination = new AfPagination(array(
                      'base_url'          => $url,
                      'param_name'        => 'p',
                      'total_items'       => $totalItems,
                      'items_per_page'    => $limit,
                      'current_page'      => $currentPage,
  ));
  if ($offset + $limit>$totalItems){
    $limit = $totalItems - $offset;
  }
  $pagination = $pagination->output();

$data = \OpenAffiliates\Db\NotificationLogs::getMany( $uid, $limit, $offset );

?>
<div class="af-notification-logs-wrapper">
    <?php if ( $data ){?>
        <table class="wp-list-table widefat fixed tags af-admin-tables" id="af-levels-table">
          <thead>
                <tr class="wp-list-table widefat fixed tags af-admin-tables af-noaitications-logs">
                    <th  class="af-id-col"><?php esc_html_e('ID','openaffiliates');?></th>
                    <th  class="af-notification-col"><?php esc_html_e('Notification Type','openaffiliates');?></th>
                    <th  class="af-sentto-col"><?php esc_html_e('Sent to','openaffiliates');?></th>
                    <th><?php esc_html_e('Email','openaffiliates');?></th>
                    <th class="af-senton-col"><?php esc_html_e('Sent on:','openaffiliates');?></th>
                </tr>
          </thead>
          <tbody>
            <?php foreach ( $data as $object ):?>
                <tr>
                    <td><?php echo esc_html($object->id);?></td>
                    <td><?php echo isset( $notification_arr[$object->notification_type] ) ? esc_html($notification_arr[$object->notification_type]) : esc_html($object->notification_type);?></td>
                    <td>
                      <div><a href="mailto:<?php echo esc_url($object->email_address);?>" target="_blank"><?php echo esc_html($object->email_address);?></a></div>
                      <?php if(isset($object->uid) && $object->uid != 0){ ?>
                        <div>User ID: <?php echo esc_html($object->uid);?></div>
                      <?php } ?>
                      <?php if(isset($object->rank_id) && $object->rank_id != 0){ ?>
                        <div>Rank ID: <?php echo esc_html($object->rank_id);?></div>
                      <?php } ?>
                    </td>
                    <td>
                      <div><strong><?php echo esc_html($object->subject);?><strong></div>
                      <div class="af-notification-logs-message"><?php echo esc_af_content($object->message);?></div>
                    </td>
                    <td><?php echo esc_html(af_convert_date_to_us_format($object->create_date));?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
        </table>
    <?php }else{ ?>
        <h4><?php esc_html_e('No Notification Logs Recorded','openaffiliates');?></h4>
    <?php }?>
</div>

<div>
<?php if ( $pagination ): ?>
    <?php echo esc_af_content($pagination);?>
<?php endif;?>
</div>
