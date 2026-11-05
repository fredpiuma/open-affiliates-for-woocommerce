<?php
if (!function_exists('af_return_font_awesome')):
	
function af_return_font_awesome(){
	/*
	 * @param none
	 * @return array
	 */
			return array(
							 "fa-af-glass" => "f000",
							 "fa-af-music" => "f001",
							 "fa-af-search" => "f002",
							 "fa-af-envelope-o" => "f003",
							 "fa-af-heart" => "f004",
							 "fa-af-star" => "f005",
							 "fa-af-star-o" => "f006",
							 "fa-af-user" => "f007",
							 "fa-af-film" => "f008",
							 "fa-af-th-large" => "f009",
							 "fa-af-th" => "f00a",
							 "fa-af-th-list" => "f00b",
							 "fa-af-check" => "f00c",
							 "fa-af-times" => "f00d",
							 "fa-af-search-plus" => "f00e",
							 "fa-af-search-minus" => "f010",
							 "fa-af-power-off" => "f011",
							 "fa-af-signal" => "f012",
							 "fa-af-cog" => "f013",
							 "fa-af-trash-o" => "f014",
							 "fa-af-home" => "f015",
							 "fa-af-file-o" => "f016",
							 "fa-af-clock-o" => "f017",
							 "fa-af-road" => "f018",
							 "fa-af-download" => "f019",
							 "fa-af-arrow-circle-o-down" => "f01a",
							 "fa-af-arrow-circle-o-up" => "f01b",
							 "fa-af-inbox" => "f01c",
							 "fa-af-play-circle-o" => "f01d",
							 "fa-af-repeat" => "f01e",
							 "fa-af-refresh" => "f021",
							 "fa-af-list-alt" => "f022",
							 "fa-af-lock" => "f023",
							 "fa-af-flag" => "f024",
							 "fa-af-headphones" => "f025",
							 "fa-af-volume-off" => "f026",
							 "fa-af-volume-down" => "f027",
							 "fa-af-volume-up" => "f028",
							 "fa-af-qrcode" => "f029",
							 "fa-af-barcode" => "f02a",
							 "fa-af-tag" => "f02b",
							 "fa-af-tags" => "f02c",
							 "fa-af-book" => "f02d",
							 "fa-af-bookmark" => "f02e",
							 "fa-af-print" => "f02f",
							 "fa-af-camera" => "f030",
							 "fa-af-font" => "f031",
							 "fa-af-bold" => "f032",
							 "fa-af-italic" => "f033",
							 "fa-af-text-height" => "f034",
							 "fa-af-text-width" => "f035",
							 "fa-af-align-left" => "f036",
							 "fa-af-align-center" => "f037",
							 "fa-af-align-right" => "f038",
							 "fa-af-align-justify" => "f039",
							 "fa-af-list" => "f03a",
							 "fa-af-outdent" => "f03b",
							 "fa-af-indent" => "f03c",
							 "fa-af-video-camera" => "f03d",
							 "fa-af-picture-o" => "f03e",
							 "fa-af-pencil" => "f040",
							 "fa-af-map-marker" => "f041",
							 "fa-af-adjust" => "f042",
							 "fa-af-tint" => "f043",
							 "fa-af-pencil-square-o" => "f044",
							 "fa-af-share-square-o" => "f045",
							 "fa-af-check-square-o" => "f046",
							 "fa-af-arrows" => "f047",
							 "fa-af-step-backward" => "f048",
							 "fa-af-fast-backward" => "f049",
							 "fa-af-backward" => "f04a",
							 "fa-af-play" => "f04b",
							 "fa-af-pause" => "f04c",
							 "fa-af-stop" => "f04d",
							 "fa-af-forward" => "f04e",
							 "fa-af-fast-forward" => "f050",
							 "fa-af-step-forward" => "f051",
							 "fa-af-eject" => "f052",
							 "fa-af-chevron-left" => "f053",
							 "fa-af-chevron-right" => "f054",
							 "fa-af-plus-circle" => "f055",
							 "fa-af-minus-circle" => "f056",
							 "fa-af-times-circle" => "f057",
							 "fa-af-check-circle" => "f058",
							 "fa-af-question-circle" => "f059",
							 "fa-af-info-circle" => "f05a",
							 "fa-af-crosshairs" => "f05b",
							 "fa-af-times-circle-o" => "f05c",
							 "fa-af-check-circle-o" => "f05d",
							 "fa-af-ban" => "f05e",
							 "fa-af-arrow-left" => "f060",
							 "fa-af-arrow-right" => "f061",
							 "fa-af-arrow-up" => "f062",
							 "fa-af-arrow-down" => "f063",
							 "fa-af-share" => "f064",
							 "fa-af-expand" => "f065",
							 "fa-af-compress" => "f066",
							 "fa-af-plus" => "f067",
							 "fa-af-minus" => "f068",
							 "fa-af-asterisk" => "f069",
							 "fa-af-exclamation-circle" => "f06a",
							 "fa-af-gift" => "f06b",
							 "fa-af-leaf" => "f06c",
							 "fa-af-fire" => "f06d",
							 "fa-af-eye" => "f06e",
							 "fa-af-eye-slash" => "f070",
							 "fa-af-exclamation-triangle" => "f071",
							 "fa-af-plane" => "f072",
							 "fa-af-calendar" => "f073",
							 "fa-af-random" => "f074",
							 "fa-af-comment" => "f075",
							 "fa-af-magnet" => "f076",
							 "fa-af-chevron-up" => "f077",
							 "fa-af-chevron-down" => "f078",
							 "fa-af-retweet" => "f079",
							 "fa-af-shopping-cart" => "f07a",
							 "fa-af-folder" => "f07b",
							 "fa-af-folder-open" => "f07c",
							 "fa-af-arrows-v" => "f07d",
							 "fa-af-arrows-h" => "f07e",
							 "fa-af-bar-chart" => "f080",
							 "fa-af-twitter-square" => "f081",
							 "fa-af-facebook-square" => "f082",
							 "fa-af-camera-retro" => "f083",
							 "fa-af-key" => "f084",
							 "fa-af-cogs" => "f085",
							 "fa-af-comments" => "f086",
							 "fa-af-thumbs-o-up" => "f087",
							 "fa-af-thumbs-o-down" => "f088",
							 "fa-af-star-half" => "f089",
							 "fa-af-heart-o" => "f08a",
							 "fa-af-sign-out" => "f08b",
							 "fa-af-linkedin-square" => "f08c",
							 "fa-af-thumb-tack" => "f08d",
							 "fa-af-external-link" => "f08e",
							 "fa-af-sign-in" => "f090",
							 "fa-af-trophy" => "f091",
							 "fa-af-github-square" => "f092",
							 "fa-af-upload" => "f093",
							 "fa-af-lemon-o" => "f094",
							 "fa-af-phone" => "f095",
							 "fa-af-square-o" => "f096",
							 "fa-af-bookmark-o" => "f097",
							 "fa-af-phone-square" => "f098",
							 "fa-af-twitter" => "f099",
							 "fa-af-facebook" => "f09a",
							 "fa-af-github" => "f09b",
							 "fa-af-unlock" => "f09c",
							 "fa-af-credit-card" => "f09d",
							 "fa-af-rss" => "f09e",
							 "fa-af-hdd-o" => "f0a0",
							 "fa-af-bullhorn" => "f0a1",
							 "fa-af-bell" => "f0f3",
							 "fa-af-certificate" => "f0a3",
							 "fa-af-hand-o-right" => "f0a4",
							 "fa-af-hand-o-left" => "f0a5",
							 "fa-af-hand-o-up" => "f0a6",
							 "fa-af-hand-o-down" => "f0a7",
							 "fa-af-arrow-circle-left" => "f0a8",
							 "fa-af-arrow-circle-right" => "f0a9",
							 "fa-af-arrow-circle-up" => "f0aa",
							 "fa-af-arrow-circle-down" => "f0ab",
							 "fa-af-globe" => "f0ac",
							 "fa-af-wrench" => "f0ad",
							 "fa-af-tasks" => "f0ae",
							 "fa-af-filter" => "f0b0",
							 "fa-af-briefcase" => "f0b1",
							 "fa-af-arrows-alt" => "f0b2",
							 "fa-af-users" => "f0c0",
							 "fa-af-link" => "f0c1",
							 "fa-af-cloud" => "f0c2",
							 "fa-af-flask" => "f0c3",
							 "fa-af-scissors" => "f0c4",
							 "fa-af-files-o" => "f0c5",
							 "fa-af-paperclip" => "f0c6",
							 "fa-af-floppy-o" => "f0c7",
							 "fa-af-square" => "f0c8",
							 "fa-af-bars" => "f0c9",
							 "fa-af-list-ul" => "f0ca",
							 "fa-af-list-ol" => "f0cb",
							 "fa-af-strikethrough" => "f0cc",
							 "fa-af-underline" => "f0cd",
							 "fa-af-table" => "f0ce",
							 "fa-af-magic" => "f0d0",
							 "fa-af-truck" => "f0d1",
							 "fa-af-pinterest" => "f0d2",
							 "fa-af-pinterest-square" => "f0d3",
							 "fa-af-google-plus-square" => "f0d4",
							 "fa-af-google-plus" => "f0d5",
							 "fa-af-money" => "f0d6",
							 "fa-af-caret-down" => "f0d7",
							 "fa-af-caret-up" => "f0d8",
							 "fa-af-caret-left" => "f0d9",
							 "fa-af-caret-right" => "f0da",
							 "fa-af-columns" => "f0db",
							 "fa-af-sort" => "f0dc",
							 "fa-af-sort-desc" => "f0dd",
							 "fa-af-sort-asc" => "f0de",
							 "fa-af-envelope" => "f0e0",
							 "fa-af-linkedin" => "f0e1",
							 "fa-af-undo" => "f0e2",
							 "fa-af-gavel" => "f0e3",
							 "fa-af-tachometer" => "f0e4",
							 "fa-af-comment-o" => "f0e5",
							 "fa-af-comments-o" => "f0e6",
							 "fa-af-bolt" => "f0e7",
							 "fa-af-sitemap" => "f0e8",
							 "fa-af-umbrella" => "f0e9",
							 "fa-af-clipboard" => "f0ea",
							 "fa-af-lightbulb-o" => "f0eb",
							 "fa-af-exchange" => "f0ec",
							 "fa-af-cloud-download" => "f0ed",
							 "fa-af-cloud-upload" => "f0ee",
							 "fa-af-user-md" => "f0f0",
							 "fa-af-stethoscope" => "f0f1",
							 "fa-af-suitcase" => "f0f2",
							 "fa-af-bell-o" => "f0a2",
							 "fa-af-coffee" => "f0f4",
							 "fa-af-cutlery" => "f0f5",
							 "fa-af-file-text-o" => "f0f6",
							 "fa-af-building-o" => "f0f7",
							 "fa-af-hospital-o" => "f0f8",
							 "fa-af-ambulance" => "f0f9",
							 "fa-af-medkit" => "f0fa",
							 "fa-af-fighter-jet" => "f0fb",
							 "fa-af-beer" => "f0fc",
							 "fa-af-h-square" => "f0fd",
							 "fa-af-plus-square" => "f0fe",
							 "fa-af-angle-double-left" => "f100",
							 "fa-af-angle-double-right" => "f101",
							 "fa-af-angle-double-up" => "f102",
							 "fa-af-angle-double-down" => "f103",
							 "fa-af-angle-left" => "f104",
							 "fa-af-angle-right" => "f105",
							 "fa-af-angle-up" => "f106",
							 "fa-af-angle-down" => "f107",
							 "fa-af-desktop" => "f108",
							 "fa-af-laptop" => "f109",
							 "fa-af-tablet" => "f10a",
							 "fa-af-mobile" => "f10b",
							 "fa-af-circle-o" => "f10c",
							 "fa-af-quote-left" => "f10d",
							 "fa-af-quote-right" => "f10e",
							 "fa-af-spinner" => "f110",
							 "fa-af-circle" => "f111",
							 "fa-af-reply" => "f112",
							 "fa-af-github-alt" => "f113",
							 "fa-af-folder-o" => "f114",
							 "fa-af-folder-open-o" => "f115",
							 "fa-af-smile-o" => "f118",
							 "fa-af-frown-o" => "f119",
							 "fa-af-meh-o" => "f11a",
							 "fa-af-gamepad" => "f11b",
							 "fa-af-keyboard-o" => "f11c",
							 "fa-af-flag-o" => "f11d",
							 "fa-af-flag-checkered" => "f11e",
							 "fa-af-terminal" => "f120",
							 "fa-af-code" => "f121",
							 "fa-af-reply-all" => "f122",
							 "fa-af-star-half-o" => "f123",
							 "fa-af-location-arrow" => "f124",
							 "fa-af-crop" => "f125",
							 "fa-af-code-fork" => "f126",
							 "fa-af-chain-broken" => "f127",
							 "fa-af-question" => "f128",
							 "fa-af-info" => "f129",
							 "fa-af-exclamation" => "f12a",
							 "fa-af-superscript" => "f12b",
							 "fa-af-subscript" => "f12c",
							 "fa-af-eraser" => "f12d",
							 "fa-af-puzzle-piece" => "f12e",
							 "fa-af-microphone" => "f130",
							 "fa-af-microphone-slash" => "f131",
							 "fa-af-shield" => "f132",
							 "fa-af-calendar-o" => "f133",
							 "fa-af-fire-extinguisher" => "f134",
							 "fa-af-rocket" => "f135",
							 "fa-af-maxcdn" => "f136",
							 "fa-af-chevron-circle-left" => "f137",
							 "fa-af-chevron-circle-right" => "f138",
							 "fa-af-chevron-circle-up" => "f139",
							 "fa-af-chevron-circle-down" => "f13a",
							 "fa-af-html5" => "f13b",
							 "fa-af-css3" => "f13c",
							 "fa-af-anchor" => "f13d",
							 "fa-af-unlock-alt" => "f13e",
							 "fa-af-bullseye" => "f140",
							 "fa-af-ellipsis-h" => "f141",
							 "fa-af-ellipsis-v" => "f142",
							 "fa-af-rss-square" => "f143",
							 "fa-af-play-circle" => "f144",
							 "fa-af-ticket" => "f145",
							 "fa-af-minus-square" => "f146",
							 "fa-af-minus-square-o" => "f147",
							 "fa-af-level-up" => "f148",
							 "fa-af-level-down" => "f149",
							 "fa-af-check-square" => "f14a",
							 "fa-af-pencil-square" => "f14b",
							 "fa-af-external-link-square" => "f14c",
							 "fa-af-share-square" => "f14d",
							 "fa-af-compass" => "f14e",
							 "fa-af-caret-square-o-down" => "f150",
							 "fa-af-caret-square-o-up" => "f151",
							 "fa-af-caret-square-o-right" => "f152",
							 "fa-af-eur" => "f153",
							 "fa-af-gbp" => "f154",
							 "fa-af-usd" => "f155",
							 "fa-af-inr" => "f156",
							 "fa-af-jpy" => "f157",
							 "fa-af-rub" => "f158",
							 "fa-af-krw" => "f159",
							 "fa-af-btc" => "f15a",
							 "fa-af-file" => "f15b",
							 "fa-af-file-text" => "f15c",
							 "fa-af-sort-alpha-asc" => "f15d",
							 "fa-af-sort-alpha-desc" => "f15e",
							 "fa-af-sort-amount-asc" => "f160",
							 "fa-af-sort-amount-desc" => "f161",
							 "fa-af-sort-numeric-asc" => "f162",
							 "fa-af-sort-numeric-desc" => "f163",
							 "fa-af-thumbs-up" => "f164",
							 "fa-af-thumbs-down" => "f165",
							 "fa-af-youtube-square" => "f166",
							 "fa-af-youtube" => "f167",
							 "fa-af-xing" => "f168",
							 "fa-af-xing-square" => "f169",
							 "fa-af-youtube-play" => "f16a",
							 "fa-af-dropbox" => "f16b",
							 "fa-af-stack-overflow" => "f16c",
							 "fa-af-instagram" => "f16d",
							 "fa-af-flickr" => "f16e",
							 "fa-af-adn" => "f170",
							 "fa-af-bitbucket" => "f171",
							 "fa-af-bitbucket-square" => "f172",
							 "fa-af-tumblr" => "f173",
							 "fa-af-tumblr-square" => "f174",
							 "fa-af-long-arrow-down" => "f175",
							 "fa-af-long-arrow-up" => "f176",
							 "fa-af-long-arrow-left" => "f177",
							 "fa-af-long-arrow-right" => "f178",
							 "fa-af-apple" => "f179",
							 "fa-af-windows" => "f17a",
							 "fa-af-android" => "f17b",
							 "fa-af-linux" => "f17c",
							 "fa-af-dribbble" => "f17d",
							 "fa-af-skype" => "f17e",
							 "fa-af-foursquare" => "f180",
							 "fa-af-trello" => "f181",
							 "fa-af-female" => "f182",
							 "fa-af-male" => "f183",
							 "fa-af-gittip" => "f184",
							 "fa-af-sun-o" => "f185",
							 "fa-af-moon-o" => "f186",
							 "fa-af-archive" => "f187",
							 "fa-af-bug" => "f188",
							 "fa-af-vk" => "f189",
							 "fa-af-weibo" => "f18a",
							 "fa-af-renren" => "f18b",
							 "fa-af-pagelines" => "f18c",
							 "fa-af-stack-exchange" => "f18d",
							 "fa-af-arrow-circle-o-right" => "f18e",
							 "fa-af-arrow-circle-o-left" => "f190",
							 "fa-af-caret-square-o-left" => "f191",
							 "fa-af-dot-circle-o" => "f192",
							 "fa-af-wheelchair" => "f193",
							 "fa-af-vimeo-square" => "f194",
							 "fa-af-try" => "f195",
							 "fa-af-plus-square-o" => "f196",
							 "fa-af-space-shuttle" => "f197",
							 "fa-af-slack" => "f198",
							 "fa-af-envelope-square" => "f199",
							 "fa-af-wordpress" => "f19a",
							 "fa-af-openid" => "f19b",
							 "fa-af-university" => "f19c",
							 "fa-af-graduation-cap" => "f19d",
							 "fa-af-yahoo" => "f19e",
							 "fa-af-google" => "f1a0",
							 "fa-af-reddit" => "f1a1",
							 "fa-af-reddit-square" => "f1a2",
							 "fa-af-stumbleupon-circle" => "f1a3",
							 "fa-af-stumbleupon" => "f1a4",
							 "fa-af-delicious" => "f1a5",
							 "fa-af-digg" => "f1a6",
							 "fa-af-pied-piper" => "f1a7",
							 "fa-af-pied-piper-alt" => "f1a8",
							 "fa-af-drupal" => "f1a9",
							 "fa-af-joomla" => "f1aa",
							 "fa-af-language" => "f1ab",
							 "fa-af-fax" => "f1ac",
							 "fa-af-building" => "f1ad",
							 "fa-af-child" => "f1ae",
							 "fa-af-paw" => "f1b0",
							 "fa-af-spoon" => "f1b1",
							 "fa-af-cube" => "f1b2",
							 "fa-af-cubes" => "f1b3",
							 "fa-af-behance" => "f1b4",
							 "fa-af-behance-square" => "f1b5",
							 "fa-af-steam" => "f1b6",
							 "fa-af-steam-square" => "f1b7",
							 "fa-af-recycle" => "f1b8",
							 "fa-af-car" => "f1b9",
							 "fa-af-taxi" => "f1ba",
							 "fa-af-tree" => "f1bb",
							 "fa-af-spotify" => "f1bc",
							 "fa-af-deviantart" => "f1bd",
							 "fa-af-soundcloud" => "f1be",
							 "fa-af-database" => "f1c0",
							 "fa-af-file-pdf-o" => "f1c1",
							 "fa-af-file-word-o" => "f1c2",
							 "fa-af-file-excel-o" => "f1c3",
							 "fa-af-file-powerpoint-o" => "f1c4",
							 "fa-af-file-image-o" => "f1c5",
							 "fa-af-file-archive-o" => "f1c6",
							 "fa-af-file-audio-o" => "f1c7",
							 "fa-af-file-video-o" => "f1c8",
							 "fa-af-file-code-o" => "f1c9",
							 "fa-af-vine" => "f1ca",
							 "fa-af-codepen" => "f1cb",
							 "fa-af-jsfiddle" => "f1cc",
							 "fa-af-life-ring" => "f1cd",
							 "fa-af-circle-o-notch" => "f1ce",
							 "fa-af-rebel" => "f1d0",
							 "fa-af-empire" => "f1d1",
							 "fa-af-git-square" => "f1d2",
							 "fa-af-git" => "f1d3",
							 "fa-af-hacker-news" => "f1d4",
							 "fa-af-tencent-weibo" => "f1d5",
							 "fa-af-qq" => "f1d6",
							 "fa-af-weixin" => "f1d7",
							 "fa-af-paper-plane" => "f1d8",
							 "fa-af-paper-plane-o" => "f1d9",
							 "fa-af-history" => "f1da",
							 "fa-af-circle-thin" => "f1db",
							 "fa-af-header" => "f1dc",
							 "fa-af-paragraph" => "f1dd",
							 "fa-af-sliders" => "f1de",
							 "fa-af-share-alt" => "f1e0",
							 "fa-af-share-alt-square" => "f1e1",
							 "fa-af-bomb" => "f1e2",
							 "fa-af-futbol-o" => "f1e3",
							 "fa-af-tty" => "f1e4",
							 "fa-af-binoculars" => "f1e5",
							 "fa-af-plug" => "f1e6",
							 "fa-af-slideshare" => "f1e7",
							 "fa-af-twitch" => "f1e8",
							 "fa-af-yelp" => "f1e9",
							 "fa-af-newspaper-o" => "f1ea",
							 "fa-af-wifi" => "f1eb",
							 "fa-af-calculator" => "f1ec",
							 "fa-af-paypal" => "f1ed",
							 "fa-af-google-wallet" => "f1ee",
							 "fa-af-cc-visa" => "f1f0",
							 "fa-af-cc-mastercard" => "f1f1",
							 "fa-af-cc-discover" => "f1f2",
							 "fa-af-cc-amex" => "f1f3",
							 "fa-af-cc-paypal" => "f1f4",
							 "fa-af-cc-stripe" => "f1f5",
							 "fa-af-bell-slash" => "f1f6",
							 "fa-af-bell-slash-o" => "f1f7",
							 "fa-af-trash" => "f1f8",
							 "fa-af-copyright" => "f1f9",
							 "fa-af-at" => "f1fa",
							 "fa-af-eyedropper" => "f1fb",
							 "fa-af-paint-brush" => "f1fc",
							 "fa-af-birthday-cake" => "f1fd",
							 "fa-af-area-chart" => "f1fe",
							 "fa-af-pie-chart" => "f200",
							 "fa-af-line-chart" => "f201",
							 "fa-af-lastfm" => "f202",
							 "fa-af-lastfm-square" => "f203",
							 "fa-af-toggle-off" => "f204",
							 "fa-af-toggle-on" => "f205",
							 "fa-af-bicycle" => "f206",
							 "fa-af-bus" => "f207",
							 "fa-af-ioxhost" => "f208",
							 "fa-af-angellist" => "f209",
							 "fa-af-cc" => "f20a",
							 "fa-af-ils" => "f20b",
							 "fa-af-meanpath" => "f20c",
			);		 
}
	
endif;
