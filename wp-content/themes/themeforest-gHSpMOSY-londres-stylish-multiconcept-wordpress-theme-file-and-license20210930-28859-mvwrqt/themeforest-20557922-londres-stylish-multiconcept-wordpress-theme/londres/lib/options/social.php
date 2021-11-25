<?php
	
	$londres_general_options= array( array(
		"name" => "Social Networks",
		"type" => "title",
		"img" => LONDRES_IMAGES_URL."icon_general.png"
	),
	
	( defined('LONDRES_PLG_ACTIVE') === true ? 
		array(
			"type" => "open",
			"subtitles"=>array(array("id"=>"social", "name"=>"Social Icons"), array("id"=>"twitter", "name" => "Twitter"), array("id"=>"instagram", "name" => "Instagram"))
		)
		:
		array(
			"type" => "open",
			"subtitles"=>array(array("id"=>"social", "name"=>"Social Icons"))
		)
	),
	
	/* ------------------------------------------------------------------------*
	 * Top Panel
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id"=>'social'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Social Icons</h3>"
	),
	
	array(
		"name" => "Facebook Icon",
		"id" => "londres_icon-facebook",
		"type" => "text",
		"desc" => "Enter full url   ex: http://facebook.com/UpperThemes",
		"std" => ""
	),
	array(
		"name" => "Twitter Icon",
		"id" => "londres_icon-twitter",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Tumblr Icon",
		"id" => "londres_icon-tumblr",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Stumble Upon Icon",
		"id" => "londres_icon-stumbleupon",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Flickr Icon",
		"id" => "londres_icon-flickr",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "LinkedIn Icon",
		"id" => "londres_icon-linkedin",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Delicious Icon",
		"id" => "londres_icon-delicious",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Skype Icon",
		"id" => "londres_icon-skype",
		"type" => "text",
		"desc" => "For a directly call to your Skype, add the following code.  skype:username?call",
		"std" => ""
	),
	array(
		"name" => "Digg Icon",
		"id" => "londres_icon-digg",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Google Icon",
		"id" => "londres_icon-google-plus",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Vimeo Icon",
		"id" => "londres_icon-vimeo-square",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "DeviantArt Icon",
		"id" => "londres_icon-deviantart",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Behance Icon",
		"id" => "londres_icon-behance",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Instagram Icon",
		"id" => "londres_icon-instagram",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Blogger Icon",
		"id" => "londres_icon-blogger",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "WordPress Icon",
		"id" => "londres_icon-wordpress",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Youtube Icon",
		"id" => "londres_icon-youtube",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Reddit Icon",
		"id" => "londres_icon-reddit",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "RSS Icon",
		"id" => "londres_icon-rss",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "SoundCloud Icon",
		"id" => "londres_icon-soundcloud",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Pinterest Icon",
		"id" => "londres_icon-pinterest",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Dribbble Icon",
		"id" => "londres_icon-dribbble",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "VK Icon",
		"id" => "londres_icon-vk",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Yelp Icon",
		"id" => "londres_icon-yelp",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Twitch Icon",
		"id" => "londres_icon-twitch",
		"type" => "text",
		"std" => ""
	),
	array(
		"name" => "Houzz Icon",
		"id" => "londres_icon-houzz",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Foursquare Icon",
		"id" => "londres_icon-foursquare",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Slack Icon",
		"id" => "londres_icon-slack",
		"type" => "text",
		"std" => ""
	),
	
	array(
		"name" => "Whatsapp Icon",
		"id" => "londres_icon-whatsapp",
		"type" => "text",
		"std" => ""
	),

	array(
		"type" => "close"
	),
	
	
	array(
		"type" => "subtitle",
		"id"=>'instagram'
	),
	
	array(
		"name" => "Display Instagram on Footer?",
		"id" => "londres_display_instagram_footer",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "Displays your latest Instagram photos on the footer."
	),
	
	array(
		"Authorize Instagram",
		"id" => "londres_authorize_instagram",
		"type" => "londres_insta_authorize",
	),
	
	array(
		"name" => "Title",
		"id" => "londres_instagram_title",
		"type" => "text",
		"std" => "INSTAGRAM @UPPER"
	),
	
	array(
		"name" => "Number of photos",
		"id" => "londres_instagram_limit",
		"type" => "text",
		"std" => "12"
	),
	
	array(
		"name" => "Open Links in:",
		"id" => "londres_instagram_target",
		"type" => "select",
		"options" => array(array('id'=>'_self', 'name'=>'Current Window (self)'), array('id'=>'_blank','name'=>'New Window (blank)')),
		"std" => '_self'
	),

	array(
		"name" => "Link text",
		"id" => "londres_instagram_link",
		"type" => "text",
		"std" => "Follow me!"
	),
	
	array(
		"type" => "close"
	),
	
	
	/* twitter options */ 
	array(
		"type" => "subtitle",
		"id"=>'twitter'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Twitter Scroller</h3>"
	),
	
	array(
		"name" => "Twitter Username",
		"id" => "londres_twitter_username",
		"type" => "text",
		"std" => ''
	),
	
	array(
		"name" => "Twitter App Consumer Key",
		"id" => "twitter_consumer_key",
		"type" => "text"
	),
	
	array(
		"name" => "Twitter App Consumer Secret",
		"id" => "twitter_consumer_secret",
		"type" => "text"
	),
	
	array(
		"name" => "Twitter App Access Token",
		"id" => "twitter_user_token",
		"type" => "text"
	),
	
	array(
		"name" => "Twitter App Access Token Secret",
		"id" => "twitter_user_secret",
		"type" => "text"
	),
	
	array(
		"name" => "Number Tweets",
		"id" => "londres_twitter_number_tweets",
		"type" => "text",
		"std" => '5'
	),
	
	array( "type" => "close" ),
	
		
	/*close array*/
	
	array(
		"type" => "close"
	));
	
	londres_add_options($londres_general_options);
	
?>