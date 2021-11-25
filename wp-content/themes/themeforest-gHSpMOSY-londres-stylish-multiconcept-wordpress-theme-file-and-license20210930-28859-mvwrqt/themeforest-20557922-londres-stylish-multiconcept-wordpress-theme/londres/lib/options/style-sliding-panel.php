<?php
	
	$colors = array('26ade4', '7dc771', 'F15A23', 'd63b33', 'EDB44D', 'FF005A', '9e4d9e', '5a7c96', '10b9b9', '50CCB3', '91683d', '3691ad');
	
	$londres_style_general_options= array( array(
		"name" => "Sliding Panel",
		"type" => "title"
	),
	
	array(
		"type" => "open",
		"subtitles"=>array(array("id"=>"slidingpanel", "name"=>"Sliding Panel"))
	),
	
	/* ------------------------------------------------------------------------*
	 * GENERAL
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id" => 'slidingpanel'
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Sliding Panel</h3>'
	),
	
	array(
		"name" => "Background Color",
		"id" => "londres_sliding_panel_background_color",
		"type" => "color",
		"std" => "ffffff"
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Titles</h3>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_sliding_panel_titles_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_sliding_panel_titles_color",
		"type" => "color",
		"std" => "595959"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_sliding_panel_titles_font_size",
		"type" => "slider",
		"std" => "14px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Links</h3>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_sliding_panel_links_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_sliding_panel_links_color",
		"type" => "color",
		"std" => "595959"
	),
	
	array(
		"name" => "Font Color Hover",
		"id" => "londres_sliding_panel_links_color_hover",
		"type" => "color",
		"std" => get_option('londres_style_color')
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_sliding_panel_links_font_size",
		"type" => "slider",
		"std" => "14px",
		"desc" => "Change the size of your menu font."
	),
	
	array(
		"type" => "documentation",
		"text" => '<h3>Paragraphs</h3>'
	),
	
	array(
		"name" => "Font",
		"id" => "londres_sliding_panel_p_font",
		"type" => "select",
		"options" => $londres_fonts_array,
		"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
		"std" => "Helvetica Neue"
	),
	
	array(
		"name" => "Font Color",
		"id" => "londres_sliding_panel_p_color",
		"type" => "color",
		"std" => "595959"
	),
	
	array(
		"name" => "Font Size",
		"id" => "londres_sliding_panel_p_font_size",
		"type" => "slider",
		"std" => "14px",
		"desc" => "Change the size of your menu font."
	),
	
	
	array(
		"type" => "close"
	),
	
	/*close array*/
	
	array(
		"type" => "close"
	));
	
	londres_add_style_options($londres_style_general_options);
	
?>