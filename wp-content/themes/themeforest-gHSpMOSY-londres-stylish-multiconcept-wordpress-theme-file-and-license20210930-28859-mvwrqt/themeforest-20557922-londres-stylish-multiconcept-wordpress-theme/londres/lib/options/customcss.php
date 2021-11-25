<?php
	
	$londres_general_options= array( array(
		"name" => "Custom CSS",
		"type" => "title",
		"img" => LONDRES_IMAGES_URL."icon_general.png"
	),
	
	array(
		"type" => "open",
		"subtitles"=>array(array("id"=>"customcss", "name"=>"Custom CSS"))
	),
	
	
	
	/* ------------------------------------------------------------------------*
	 * CUSTOM CSS
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id"=>'customcss'
	),
	
	array(
		"type" => "documentation",
		"text" => "You can use this textarea to add your custom CSS. This will be loaded last so it will override the other CSS from the theme. Tags will be striped."
	),
	
	array(
		"name" => "Apply Custom CSS",
		"id" => "enable_custom_css",
		"type" => "checkbox",
		"std" => "on"
	),
	
	array(
		"id" => "londres_custom_css",
		"type" => "textarea",
		"params" => "londres_rich_editor"
	),
			
	array(
		"type" => "close"
	));
	
	londres_add_options($londres_general_options);
	
?>