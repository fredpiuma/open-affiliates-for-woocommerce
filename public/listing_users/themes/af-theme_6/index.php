<?php
if (empty($total_items)){
	die("Direct access not permitted");
}
$dir_path = plugin_dir_path (__FILE__);

$list_item_template = '
<div class="team-member">
<div class="member-img">
 <a #POST_LINK#>
 <img title="AF_FIRST_NAME AF_LAST_NAME" src="AF_AVATAR" alt=""/>
 </a>
</div>
<div class="member-content">
<div class="member-name">
<a #POST_LINK#>
AF_FIRST_NAME AF_LAST_NAME
</a>
</div>
<div class="member-username">
AF_USERNAME
 </div>
<div class="show-details">
<div class="af-top-counts-wrapper">EARNINGSREFERRALSVISITS</div>
<div class="member-email">
AF_EMAIL
</div>
<div class="member-extra-fields">
AF_EXTRA_FIELDS
</div>
</div>
</div>
';
