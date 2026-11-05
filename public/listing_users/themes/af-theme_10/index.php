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
 <div class="member-name-wrapper">
  <div class="member-name">
 	AF_FIRST_NAME AF_LAST_NAME
	<span>AF_USERNAME</span>
  </div>
 </div>
 </a>
<div class="member-content-wrapper">
<div class="member-content">
<div class="af-top-counts-wrapper">EARNINGSREFERRALSVISITS</div>
<div class="member-email">
AF_EMAIL
</div>
<div class="member-extra-fields">
AF_EXTRA_FIELDS
</div>
<div class="af-extra-box"></div>
</div>
</div>
<div class="clear"></div>
</div>
';
