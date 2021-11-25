<?php
	
/*-----------------------------------------------------------------------------------*/
/*  Londres Theme Styles
/*-----------------------------------------------------------------------------------*/

function londres_custom_style() {
	
	global $londres_custom, $londres_styleColor, $post, $londres_import_fonts, $londres_header_bgstyle_pre, $londres_header_bgstyle_after;
	$londres_theid = get_the_ID();
	$londres_styleColor = "#".get_option("londres_style_color");
	if ("#".get_option("londres_style_color") != $londres_styleColor) $londres_styleColor = "#".get_option("londres_style_color");
	$londres_color_code = substr($londres_styleColor,1);
	$londres_styleColor_rgb = londres_hex2rgb($londres_styleColor);

	$londres_headerType = get_option("londres_header_type");
	
	$londres_header_bgstyle_pre = get_option('londres_header_style_light_dark', 'light') == 'light' ? 'light' : 'dark';
	$londres_header_bgstyle_after = get_option('londres_header_after_scroll_style_light_dark', 'light') == 'light' ? 'light' : 'dark';
	
	if (is_singular() && get_post_meta($londres_theid, 'londres_enable_custom_header_options_value', true) == 'yes'){
		$londres_header_bgstyle_pre = get_post_meta($londres_theid, 'londres_custom_header_pre_value', true);
		$londres_header_bgstyle_after = get_post_meta($londres_theid, 'londres_custom_header_after_value', true);
	}
	
	$londres_header_style_pre = $londres_header_bgstyle_pre == 'dark' ? 'light' : 'dark';
	$londres_header_style_after = $londres_header_bgstyle_after == 'dark' ? 'light' : 'dark';
	
	global $londres_import_fonts;
	
	$londres_style_data = "";
	
	$londres_style_data .= ".widget li a:after, .widget_nav_menu li a:after, .custom-widget.widget_recent_entries li a:after{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_p_color"))).";
	}
	body, p, .lovepost a, .widget ul li a, .widget p, .widget span, .widget ul li, .the_content ul li, .the_content ol li, #recentcomments li, .custom-widget h4, .widget.des_cubeportfolio_widget h4, .widget.des_recent_posts_widget h4, .custom-widget ul li a, .aio-icon-description, li, .smile_icon_list li .icon_description p{
		";
		$font = get_option('londres_p_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "" ;
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."' ,sans-serif;
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_p_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_p_color"))).";
	}
	
	.map_info_text{
		";
		$font = get_option('londres_p_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."' ,sans-serif;
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_p_size')), 10)."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_p_color")))." !important;
	}
	
	a.pageXofY .pageX, .pricing .bestprice .name, .filter li a:hover, .widget_links ul li a:hover, #contacts a:hover, .title-color, .ms-staff-carousel .ms-staff-info h4, .filter li a:hover, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, a.go-about:hover, .text_color, .navbar-nav .dropdown-menu a:hover, .profile .profile-name, #elements h4, #contact li a:hover, #agency-slider h5, .ms-showcase1 .product-tt h3, .filter li a.active, .contacts li i, .big-icon i, .navbar-default.dark .navbar-brand:hover,.navbar-default.dark .navbar-brand:focus, a.p-button.border:hover, .navbar-default.light-menu .navbar-nav > li > a.selected, .navbar-default.light-menu .navbar-nav > li > a.hover_selected, .navbar-default.light-menu .navbar-nav > li > a.selected:hover, .navbar-default.light-menu .navbar-nav > li > a.hover_selected:hover, .navbar-default.light-menu .navbar-nav > li > a.selected, .navbar-default.light-menu .navbar-nav > li > a.hover_selected, .navbar-default.light-menu .navbar-nav > .open > a,.navbar-default.light-menu .navbar-nav > .open > a:hover, .navbar-default.light-menu .navbar-nav > .open > a:focus, .light-menu .dropdown-menu > li > a:focus, a.social:hover:before, .symbol.colored i, .icon-nofill, .slidecontent-bi .project-title-bi p a:hover, .grid .figcaption a.thumb-link:hover, .tp-caption a:hover, .btn-1d:hover, .btn-1d:active, #contacts .tweet_text a, #contacts .tweet_time a, .social-font-awesome li a:hover, h2.post-title a:hover, .tags a:hover, .londres-button-color span, #contacts .form-success p, .nav-container .social-icons-fa a i:hover, .the_title h2 a:hover, .widget ul li a:hover, .des-pages .postpagelinks, .widget_nav_menu .current-menu-item > a, .team-position, .nav-container .londres_minicart li a:hover, .metas-container i, .header_style2_contact_info .telephone-contact .email, .special_tabs.icontext .label.current i, .special_tabs.icontext .label.current a, .special_tabs.text .label.current a, .widget-contact-content i{
	  color: ".esc_html($londres_styleColor).";
	}
	.testimonials.style1 .testimonial span a{
		color: ".esc_html($londres_styleColor)." !important;
	}
	.testimonials .cover-test-img{background:rgba(".$londres_styleColor_rgb[0].",".$londres_styleColor_rgb[1].",".$londres_styleColor_rgb[2].",.8);}
	.aio-icon-read, .tp-caption a.text_color{color: ".esc_html($londres_styleColor)." !important;}
	
	#big_footer .social-icons-fa a i{color:#".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sec_footer_social_icons_color"))).";}
	#big_footer .social-icons-fa a i:hover{color:#".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sec_footer_social_icons_hover_color"))).";}
	
	.homepage_parallax .home-logo-text a.light:hover, .homepage_parallax .home-logo-text a.dark:hover, .widget li a:hover:before, .widget_nav_menu li a:hover:before, .footer_sidebar ul li a:hover:before, .custom-widget li a:hover:before, .single-portfolio .social-shares ul li a:hover i,
	.special_tabs.icontext:not(.vertical) .label.current i{
		color: ".esc_html($londres_styleColor)." !important;
	}
	
	
	a.sf-button.hide-icon, .tabs li.current, .readmore:hover, .navbar-default .navbar-nav > .open > a,.navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, a.p-button:hover, a.p-button.colored, .light #contacts a.p-button, .tagcloud a:hover, .rounded.fill, .colored-section, .pricing .bestprice .price, .pricing .bestprice .signup, .signup:hover, .divider.colored, .services-graph li span, .no-touch .hi-icon-effect-1a .hi-icon:hover, .hi-icon-effect-1b .hi-icon:hover, .no-touch .hi-icon-effect-1b .hi-icon:hover, .symbol.colored .line-left, .symbol.colored .line-right, .projects-overlay #projects-loader, .panel-group .panel.active .panel-heading, .double-bounce1, .double-bounce2, .londres-button-color-1d:after, .container1 > div, .container2 > div, .container3 > div, .cbp-l-caption-buttonLeft:hover, .cbp-l-caption-buttonRight:hover, .post-content a:hover .post-quote, .post-listing .post a:hover .post-quote, .londres-button-color-1d:after, .woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider-horizontal .ui-slider-range, .btn-contact-left input, .single #commentform .form-submit #submit, a#send-comment, .errorbutton, .modal-popup-link .tooltip-content, .woocommerce span.onsale, .woocommerce-page span.onsale, .des-button-dark, .bt-contact a span input{
		background-color:".esc_html($londres_styleColor).";
	}
	.aio-icon-tooltip .aio-icon:hover:after{box-shadow:0 0 0 2px ".esc_html($londres_styleColor)." !important;}
	.just-icon-align-left .aio-icon:hover, .aio-icon-tooltip .aio-icon:hover, .btn-contact-left.inversecolor input:hover{
		background-color:".esc_html($londres_styleColor)." !important;
	}
	.aio-icon-tooltip .aio-icon.none:hover{background-color: transparent !important;}
	
	.widget .slick-dots li.slick-active i{color: ".esc_html($londres_styleColor)." !important;opacity: 1;}
	
	
	.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce #content div.product form.cart .button, .woocommerce div.product form.cart .button, .woocommerce-page #content div.product form.cart .button, .woocommerce-page div.product form.cart .button, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale, .top-bar .phone-mail li.text_field{
		background-color:".esc_html($londres_styleColor).";
		color: #fff !important;
	}
	#primary_footer input[type='submit']{
		background-color:".esc_html($londres_styleColor)." !important;
		color: #fff !important;
	}
	.nav-container a.button.londres_minicart_checkout_but:hover, .nav-container a.button.londres_minicart_cart_but:hover{
		color: #fff !important;
		opacity: 1;
	}
	.nav-container a.button.londres_minicart_checkout_but:hover, .nav-container a.button.londres_minicart_cart_but:hover{
		    background: #101010 !important;
		    border: 1px solid #101010 !important;
	}
	.londres-button-color-1d:hover, .londres-button-color-1d:active{
		border: 1px double ".esc_html($londres_styleColor).";
	}
	
	.londres-button-color{
		background-color:".esc_html($londres_styleColor).";
		color: ".esc_html($londres_styleColor).";
	}
	.cbp-l-caption-alignCenter .cbp-l-caption-buttonLeft:hover, .cbp-l-caption-alignCenter .cbp-l-caption-buttonRight:hover {
	    background-color:".esc_html($londres_styleColor)." !important;
	    border:1px solid ".esc_html($londres_styleColor)." !important;
	    color: #fff !important;
	}
	.widget_posts .tabs li.current{border: 1px solid ".esc_html($londres_styleColor).";}
	.hi-icon-effect-1 .hi-icon:after{box-shadow: 0 0 0 3px ".esc_html($londres_styleColor).";}
	.colored-section:after {border: 20px solid ".esc_html($londres_styleColor).";}
	.filter li a.active, .filter li a:hover, .panel-group .panel.active .panel-heading{border:1px solid ".esc_html($londres_styleColor).";}
	.navbar-default.light-menu.border .navbar-nav > li > a.selected:before, .navbar-default.light-menu.border .navbar-nav > li > a.hover_selected:before, .navbar-default.light-menu.border .navbar-nav > li > a.selected:hover, .navbar-default.light-menu.border .navbar-nav > li > a.hover_selected:hover, .navbar-default.light-menu.border .navbar-nav > li > a.selected, .navbar-default.light-menu.border .navbar-nav > li > a.hover_selected{
		border-bottom: 1px solid ".esc_html($londres_styleColor).";
	}
	
	
	
	.doubleborder{
		border: 6px double ".esc_html($londres_styleColor).";
	}
	
	
	.special_tabs.icon .current .londres_icon_special_tabs{
		border: 1px solid transparent;
	}
	.londres-button-color, .des-pages .postpagelinks, .tagcloud a:hover{
		border: 1px solid ".esc_html($londres_styleColor).";
	}
	
	.navbar-collapse ul.menu-depth-1 li:not(.londres_mega_hide_link) a, .dl-menuwrapper li:not(.londres_mega_hide_link) a, .gosubmenu, .nav-container .londres_minicart ul li {";
		$font = get_option('londres_sub_menu_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."', sans-serif;
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_sub_menu_font_size'),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color'))).";";
		if (get_option('londres_sub_menu_uppercase') === 'on') $londres_style_data .= "text-transform: uppercase;\n";
		$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_sub_menu_letter_spacing'),10))."px;
	}
	.dl-back{color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color')).";}
	
	.navbar-collapse ul.menu-depth-1 li:not(.londres_mega_hide_link):hover > a, .dl-menuwrapper li:not(.londres_mega_hide_link):hover > a, .dl-menuwrapper li:not(.londres_mega_hide_link):hover > a, .dl-menuwrapper li:not(.londres_mega_hide_link):hover > .gosubmenu, .dl-menuwrapper li.dl-back:hover, .navbar-nav .dropdown-menu a:hover i, .dropdown-menu li.menu-item-has-children:not(.londres_mega_hide_link):hover > a:before{
		color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color_hover')).";
	}
		
	
	
	.menu-simple ul.menu-depth-1, .menu-simple ul.menu-depth-1 ul, .menu-simple ul.menu-depth-1, .menu-simple #dl-menu ul{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}
	
	
	
	.navbar-collapse .londres_mega_menu ul.menu-depth-2, .navbar-collapse .londres_mega_menu ul.menu-depth-2 ul {background-color: transparent !important;} 
	
	.dl-menuwrapper li:not(.londres_mega_hide_link):hover > a{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color_hover")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}
	

	
	.menu-square li:not(.londres_mega_menu) li.menu-item-depth-1:hover > a, .menu-square li.menu-item-depth-2:hover > a, .menu-square li.menu-item-depth-3:hover > a{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color_hover")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}
	
	
	
	.navbar-collapse li:not(.londres_mega_menu) ul.menu-depth-1 li:not(:first-child){
		border-top: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
	}
	
	
	
	.navbar-collapse li.londres_mega_menu ul.menu-depth-2{
		border-right: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
	}
	.rtl .navbar-collapse li.londres_mega_menu ul.menu-depth-2{
		border-left: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
	}
		
	#dl-menu ul li:not(:last-child) a, .londres_sub_menu_border_color{
		border-bottom: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
	}
	
	.navbar-collapse ul.navbar-nav > li > a, .navbar-collapse > .header_style2_menu > ul > li > a{";
		$font = get_option('londres_menu_font_pre_'.$londres_header_style_pre); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."', sans-serif;
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_menu_font_size_pre_'.$londres_header_style_pre),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_pre_'.$londres_header_style_pre))).";";
		if (get_option('londres_menu_uppercase_pre_'.$londres_header_style_pre) === 'on') $londres_style_data .= "text-transform: uppercase;\n"; else $londres_style_data .= "text-transform:none;\n";
		$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_menu_letter_spacing_pre_'.$londres_header_style_pre),10))."px;
	}
	
	.navbar-collapse > .header_style2_menu > ul > li > a:hover, 
	.navbar-collapse > .header_style2_menu > ul > li.current-menu-ancestor > a, 
	.navbar-collapse > .header_style2_menu > ul > li.current-menu-item > a, 
	.navbar-collapse > .header_style2_menu > ul > li > a.selected,
	.navbar-collapse > .header_style2_menu > ul > li > a.hover_selected,
	.navbar-collapse ul.navbar-nav > li > a:hover, 
	.navbar-collapse ul.navbar-nav > li.current-menu-ancestor > a, 
	.navbar-collapse ul.navbar-nav > li.current-menu-item > a, 
	.navbar-collapse ul.navbar-nav > li > a.selected,
	.navbar-collapse ul.navbar-nav > li > a.hover_selected{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre)))." !important;
	}
	
	
	
	.menu-square .navbar-collapse ul.navbar-nav > li.current-menu-item > a{
		background-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre)))." !important;
		color: #fff !important;
	}
	
	.header.navbar .navbar-collapse ul li:hover a 
	{
		background: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre))).";
		color: #fff !important;
	}
	
	";	
	if (get_option('londres_menu_add_border_pre_'.$londres_header_style_pre) == "on"){
		$londres_style_data .= ".navbar-collapse ul.menu-depth-1, .nav-container .londres_minicart{border-top:1px solid #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_border_color_pre_'.$londres_header_style_pre))." !important;}";
	}
	
	$londres_style_data .= "
	
	
	header.style2 .navbar-nav > li, .navbar-default.menu-square.style2 .navbar-nav > li {padding-top:0px;}
	header.style2{
		padding-bottom:".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_pre),10))."px;
	}
	
	
	.navbar-default .navbar-nav > li > a{
		padding-right:".esc_html(intval(get_option('londres_menu_side_margin_pre_'.$londres_header_style_pre),10))."px;
		padding-left:".esc_html(intval(get_option('londres_menu_side_margin_pre_'.$londres_header_style_pre),10))."px;
		padding-top:".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_pre),10))."px;
		padding-bottom:".esc_html(intval(get_option('londres_menu_padding_bottom_pre_'.$londres_header_style_pre),10))."px;
	}
	
	
	header .search_trigger, header .menu-controls, header .londres_dynamic_shopping_bag, header .header_social_icons.with-social-icons{
		padding-top:".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_pre),10))."px;
		padding-bottom:".esc_html(intval(get_option('londres_menu_padding_bottom_pre_'.$londres_header_style_pre),10))."px;
	}
	
	header.style2 .header_style2_menu{
		border-top: 1px solid #".esc_html(get_option('londres_sub_menu_bg_color')).";
		border-bottom: 1px solid #".esc_html(get_option('londres_sub_menu_bg_color')).";

	}
	
	header:not(.header_after_scroll) .navbar-nav > li > ul{
		margin-top:".esc_html(intval(get_option('londres_menu_padding_bottom_pre_'.$londres_header_style_pre),10))."px;
	}

	header:not(.header_after_scroll) .dl-menuwrapper button:after{
		background: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre))).";
		box-shadow: 0 6px 0 #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre))).", 0 12px 0 #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre))).";
	}

	.londres_minicart_wrapper{
		padding-top: ".esc_html(intval(get_option('londres_menu_padding_bottom_pre_'.$londres_header_style_pre),10))."px;
	}
	
	li.londres_mega_hide_link > a, li.londres_mega_hide_link > a:hover{";
		$font = get_option('londres_label_menu_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."' !important;
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_label_menu_font_size'),10))."px !important;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_label_menu_color')))." !important;";
		if (get_option('londres_label_menu_uppercase') === 'on') $londres_style_data .= "text-transform: uppercase !important;\n";
		$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_label_menu_letter_spacing'),10))."px !important;
	}
	
/*
	.nav-container .londres_minicart li a:hover {";
		$font = get_option('londres_label_menu_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_label_menu_color')))." !important;
		text-decoration: none;
	}
*/
	.nav-container .londres_minicart li a{";
		$font = get_option('londres_sub_menu_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_sub_menu_font_size'),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color'))).";";
		if (get_option('londres_sub_menu_uppercase') === 'on') $londres_style_data .= "text-transform: uppercase;\n";
		$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_sub_menu_letter_spacing')),10)."px;
	}
	
	.dl-trigger{";
		$font = get_option('londres_menu_font_pre_'.$londres_header_style_pre); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."' !important;
		font-weight: ".esc_html($font[1])." !important;
		font-size: ".esc_html(intval(get_option('londres_menu_font_size_pre_'.$londres_header_style_pre),10))."px;";
		if (get_option('londres_menu_uppercase_pre_'.$londres_header_style_pre) === 'on') $londres_style_data .= "text-transform: uppercase;\n";
		$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_menu_letter_spacing_pre_'.$londres_header_style_pre),10))."px;
	}
	
	.londres_minicart{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}
	
	.page_content a, header a, #big_footer a{";
		$font = get_option('londres_links_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_links_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_color")))."
	}
	
	
	.archive .the_title h2 a, .page-template-blog-template .the_title h2 a, .home.blog .blog-default.wideblog .container .the_title h2 a{";
		$font = get_option('londres_blog_normal_title_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1])." !important;
		font-size: ".esc_html(intval(get_option('londres_blog_normal_title_size'), 10))."px !important;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_blog_normal_title_color")))."
	}
	
	
	.blog-default-bg-masonry .the_title h2 a{";
		$font = get_option('londres_blog_masonry_title_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1])." !important;
		font-size: ".esc_html(intval(get_option('londres_blog_masonry_title_size'), 10))."px !important;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_blog_masonry_title_color")))."
	}
	
	.page_content a:hover, header a:hover, #big_footer a:hover, .page-template-blog-masonry-template .posts_category_filter li:active,.page-template-blog-masonry-template .posts_category_filter li:focus,.metas-container a:hover{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_color_hover"))).";
		background-color: #".esc_html( is_array(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_bg_color_hover"))) ? "" : str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_links_bg_color_hover")) ).";
	}
	
	h1{";
		$font = get_option('londres_h1_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h1_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h1_color"))).";
	}
	
	h2{";
		$font = get_option('londres_h2_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h2_size'), 10))."px;
		color: #".esc_html(get_option('londres_h2_color')).";
	}
	
	h3{";
		$font = get_option('londres_h3_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h3_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h3_color"))).";
	}
	
	h4{";
		$font = get_option('londres_h4_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h4_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h4_color"))).";
	}
	
	.ult-item-wrap .title h4{font-size: 16px !important;}
	.wpb_content_element .wpb_accordion_header.ui-accordion-header-active a{color: ".esc_html($londres_styleColor).";}
	h5{";
		$font = get_option('londres_h5_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h5_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h5_color"))).";
	}
	
	h6{";
		$font = get_option('londres_h6_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option('londres_h6_size'), 10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_h6_color"))).";
	}
		
	header.navbar{";
		switch (get_option('londres_headerbg_type_'.$londres_header_bgstyle_pre)){
			case "color":
				$color = londres_hex2rgb( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_headerbg_color_".$londres_header_bgstyle_pre) ));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_headerbg_opacity_".$londres_header_bgstyle_pre)))/100).");";
			break;
			case "image":
				$londres_style_data .= "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				$londres_style_data .= "background: url(" . esc_url(get_option("londres_headerbg_image_".$londres_header_bgstyle_pre)) . ") no-repeat fixed !important; background-size: cover !important;";  
			break;
			case "pattern":
				$londres_style_data .= "background: url('" . esc_url(get_template_directory_uri()) . "/images/londres_patterns/" . get_option("londres_headerbg_pattern_".$londres_header_bgstyle_pre) . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				$londres_style_data .= "background: url('" . esc_url(get_option("londres_headerbg_custom_pattern_".$londres_header_bgstyle_pre)) . "') 0 0 repeat !important;";
			break;
		}
	$londres_style_data .= "
	}
	
	body#boxed_layout{";
		switch (get_option("londres_bodybg_type")){
			case "image":
				$londres_style_data .= "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;width: 100%;height: 100%;
	background-attachment: fixed !important;";
				$londres_style_data .= "background: url(" . esc_url(get_option("londres_bodybg_type_image")) . ") no-repeat;";  
			break;
			case "color":
	 			$londres_style_data .= "background-color: #" . esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_bodybg_type_color"))) . ";";
			break;
		}
	$londres_style_data .= "
	}
	
	header .header_style2_contact_info{";
		if (get_option("londres_logo_margin_top")) 
			$londres_style_data .= "margin-top: " . str_replace(" ", "", get_option("londres_logo_margin_top")) . " !important;margin-bottom: " . str_replace(" ", "", get_option("londres_logo_margin_top")) . " !important;
	}
	
	header .navbar-header, header.style4 .nav-container .navbar-header .navbar-brand{";
		if (get_option("londres_logo_margin_top")) 
			$londres_style_data .= "margin-top: " . str_replace(" ", "", get_option("londres_logo_margin_top")) . ";margin-bottom: " . str_replace(" ", "", get_option("londres_logo_margin_top")) . ";"; 
		if (get_option("londres_logo_margin_left")) $londres_style_data .= "margin-left: " . str_replace(" ", "", get_option("londres_logo_margin_left")) . ";"; 
		if (get_option("londres_logo_height")) $londres_style_data .= "height:" . get_option("londres_logo_height") . ";";
	$londres_style_data .= "
	}
	header a.navbar-brand img{max-height: ".esc_html(intval(get_option('londres_logo_height'),10))."px;}";
			
	$header_after_scroll = false;
	if (get_option('londres_fixed_menu') == 'on'){
		if (get_option('londres_header_after_scroll') == 'on'){
			$header_after_scroll = true;
			$londres_style_data .= "
			header.navbar.header_after_scroll, header.header_after_scroll .navbar-nav > li.londres_mega_menu > .dropdown-menu, header.header_after_scroll .navbar-nav > li:not(.londres_mega_menu) .dropdown-menu{";
				switch (get_option('londres_headerbg_after_scroll_type_'.$londres_header_bgstyle_after)){
					case "color":
						$color = londres_hex2rgb( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_headerbg_after_scroll_color_".$londres_header_bgstyle_after) ));
						$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_headerbg_after_scroll_opacity_".$londres_header_bgstyle_after)))/100).")";
					break;
					case "image":
						$londres_style_data .= "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
						$londres_style_data .= "background: url(" . esc_url(get_option("londres_headerbg_after_scroll_image_".$londres_header_bgstyle_after)) . ") no-repeat fixed !important; background-size: cover !important;";  
					break;
					case "pattern":
						$londres_style_data .= "background: url('" . esc_url(get_template_directory_uri()) . "/images/londres_patterns/" . get_option("londres_headerbg_after_scroll_pattern_".$londres_header_bgstyle_after) . "') 0 0 repeat !important;";
					break;
					case "custom_pattern":
						$londres_style_data .= "background: url('" . esc_url(get_option("londres_headerbg_after_scroll_custom_pattern_".$londres_header_bgstyle_after)) . "') 0 0 repeat !important;";
					break;
				}
			$londres_style_data .= "
			}
			";
			$header_shrink = false;
			if (get_option('londres_fixed_menu') == 'on'){
				if (get_option('londres_header_after_scroll') == 'on'){
					if (get_option('londres_header_shrink_effect') == 'on'){
						$header_shrink = true;
						$londres_style_data .= "header.header_after_scroll a.navbar-brand img.logo_after_scroll{max-height: ". esc_html(intval(get_option('londres_logo_reduced_height'),10))."px;}";
					}
				}
			}
			
			$londres_style_data .= "
			header.header_after_scroll .navbar-collapse ul.menu-depth-1 li:not(.londres_mega_hide_link) a, header.header_after_scroll .dl-menuwrapper li:not(.londres_mega_hide_link) a, header.header_after_scroll .gosubmenu {
				color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color'))).";
			}
			header.header_after_scroll .dl-back{color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color'))).";}
			
			header.header_after_scroll .navbar-collapse ul.menu-depth-1 li:not(.londres_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.londres_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.londres_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.londres_mega_hide_link):hover > header.header_after_scroll .gosubmenu, header.header_after_scroll .dl-menuwrapper li.dl-back:hover, header.header_after_scroll.navbar .nav-container .dropdown-menu li:hover{
				color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_color_hover'))).";
			}
			
			header ul.menu-depth-1,
			header ul.menu-depth-1 ul,
			header ul.menu-depth-1 ul li,
			header #dl-menu ul,
			header.header_after_scroll ul.menu-depth-1,
			header.header_after_scroll ul.menu-depth-1 ul,
			header.header_after_scroll ul.menu-depth-1 ul li,
			header.header_after_scroll #dl-menu ul{";
				$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color")));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
			}
			
			header.header_after_scroll .navbar-collapse .londres_mega_menu ul.menu-depth-2, header.header_after_scroll .navbar-collapse .londres_mega_menu ul.menu-depth-2 ul {background-color: transparent !important;} 
			

			header li:not(.londres_mega_menu) ul.menu-depth-1 li:hover, header li.londres_mega_menu li.menu-item-depth-1 li:hover, header #dl-menu ul li:hover
			,header.header_after_scroll li:not(.londres_mega_menu) ul.menu-depth-1 li:hover, header.header_after_scroll li.londres_mega_menu li.menu-item-depth-1 li:hover, header.header_after_scroll #dl-menu ul li:hover{";
				$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color_hover")));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
			}
			header.header_after_scroll.menu-simple li:not(.londres_mega_menu) ul.menu-depth-1 li:hover, header li:not(.londres_mega_menu) ul.menu-depth-1 li:hover{
				background-color: transparent !important;
			}
			
			header.header_after_scroll .navbar-collapse li:not(.londres_mega_menu) ul.menu-depth-1 li:not(:first-child){
				border-top: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
			}
			header.header_after_scroll .navbar-collapse li.londres_mega_menu ul.menu-depth-2{
				border-right: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
			}
			header.header_after_scroll #dl-menu li:not(:last-child) a, header.header_after_scroll #dl-menu ul li:not(:last-child) a{
				border-bottom: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_sub_menu_border_color'))).";
			}
			
			.header_after_scroll .navbar-collapse ul.navbar-nav > li > a, .header_after_scroll .navbar-collapse > .header_style2_menu > ul > li > a{";
				$font = get_option('londres_menu_font_after_'.$londres_header_style_after); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
				$londres_style_data .= "
				font-family: '".wp_kses_post($font[0])."';
				font-weight: ".esc_html($font[1]).";
				font-size: ".esc_html(intval(get_option('londres_menu_font_size_after_'.$londres_header_style_after),10))."px;
				color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_after_'.$londres_header_style_after))).";";
				if (get_option('londres_menu_uppercase_after_'.$londres_header_style_after) === 'on') $londres_style_data .= "text-transform: uppercase;\n"; else $londres_style_data .= "text-transform:none;\n";
				$londres_style_data .= "letter-spacing: ".esc_html(intval(get_option('londres_menu_letter_spacing_after_'.$londres_header_style_after),10))."px;
			}
			
			.header_after_scroll .navbar-collapse > .header_style2_menu > ul > li > a:hover,
			.header_after_scroll .navbar-collapse > .header_style2_menu > ul > li.current-menu-ancestor > a,
			.header_after_scroll .navbar-collapse > .header_style2_menu > ul > li.current-menu-item > a,
			.header_after_scroll .navbar-collapse > .header_style2_menu > ul > li > a.selected,
			.header_after_scroll .navbar-collapse > .header_style2_menu > ul > li > a.hover_selected,
			.header_after_scroll .navbar-collapse ul.navbar-nav > li > a:hover,
			.header_after_scroll .navbar-collapse ul.navbar-nav > li.current-menu-ancestor > a,
			.header_after_scroll .navbar-collapse ul.navbar-nav > li.current-menu-item > a,
			.header_after_scroll .navbar-collapse ul.navbar-nav > li > a.selected, .header_after_scroll .navbar-collapse ul.navbar-nav > li > a.hover_selected{
				color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_after_'.$londres_header_style_after)))." !important;
			}
			
			.header_after_scroll .dl-menuwrapper button:after{
				background: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_after_'.$londres_header_style_after))).";
				box-shadow: 0 6px 0 #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_after_'.$londres_header_style_after))).", 0 12px 0 #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_after_'.$londres_header_style_after))).";
			}";
			
			if (get_option('londres_menu_add_border_after_'.$londres_header_style_after) == "on"){
				$londres_style_data .= ".header_after_scroll .navbar-collapse ul.menu-depth-1, .header_after_scroll .nav-container .londres_minicart{border-top:3px solid #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_border_color_after_'.$londres_header_style_after))." !important;}";
			}
			$londres_style_data .= "
			header.header_after_scroll li.londres_mega_hide_link > a, header.header_after_scroll li.londres_mega_hide_link > a:hover{
				color: #".esc_html(get_option('londres_label_menu_after_scroll_color'))." !important;
			}";
			
			$header_shrink = false;
			if (get_option('londres_fixed_menu') == 'on'){
				if (get_option('londres_header_after_scroll') == 'on'){
					if (get_option('londres_header_shrink_effect') == 'on'){
						$header_shrink = true;
						$londres_style_data .= "
						header.header_after_scroll.navbar-default .navbar-nav > li > a {
							padding-right:".esc_html(intval(get_option('londres_menu_side_margin_after_'.$londres_header_style_after),10))."px;
							padding-left:".esc_html(intval(get_option('londres_menu_side_margin_after_'.$londres_header_style_after),10))."px;
							padding-top:".esc_html(intval(get_option('londres_menu_margin_top_after_'.$londres_header_style_after),10))."px;
							padding-bottom:".esc_html(intval(get_option('londres_menu_padding_bottom_after_'.$londres_header_style_after),10))."px;
						}
						
						
						
						header.header_after_scroll.style2 .navbar-nav > li, .navbar-default.menu-square.style2 .navbar-nav > li {padding-top:0px;}
						header.header_after_scroll.style2{
							padding-bottom:".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_after),10))."px;
						}
						header.header_after_scroll.style2 .header_style2_menu{
							margin-top:".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_after),10))."px !important;
						}
						
						header.header_after_scroll .search_trigger, header.header_after_scroll .menu-controls, header.header_after_scroll .londres_dynamic_shopping_bag, header.header_after_scroll .header_social_icons.with-social-icons{
							padding-top:".esc_html(intval(get_option('londres_menu_margin_top_after_'.$londres_header_style_after),10))."px;
							padding-bottom:".esc_html(intval(get_option('londres_menu_padding_bottom_after_'.$londres_header_style_after),10))."px;
						}
						
						header.header_after_scroll .navbar-nav > li > ul{
							margin-top:".esc_html(intval(get_option('londres_menu_padding_bottom_after_'.$londres_header_style_after),10))."px;
						}
					
						header.header_after_scroll .londres_minicart_wrapper{
							padding-top:".esc_html(intval(get_option('londres_menu_padding_bottom_after_'.$londres_header_style_after),10))."px;
						}
						";
					}
				}
			}
		}
	}
		
		
	$header_shrink = false;
	if (get_option('londres_fixed_menu') == 'on'){
		if (get_option('londres_header_after_scroll') == 'on'){
			if (get_option('londres_header_shrink_effect') == 'on'){
				$header_shrink = true;
				$londres_style_data .= "
				header.header_after_scroll .header_style2_contact_info{";
					if (get_option("londres_logo_after_scroll_margin_top")) $londres_style_data .= "margin-top: " . str_replace(" ", "", get_option("londres_logo_after_scroll_margin_top")) . " !important;margin-bottom: " . str_replace(" ", "", get_option("londres_logo_after_scroll_margin_top")) . " !important;
				}
				header.header_after_scroll .navbar-header, header.style4.header_after_scroll .nav-container .navbar-header .navbar-brand{";
					if (get_option("londres_logo_after_scroll_margin_top")) $londres_style_data .= "margin-top: " . str_replace(" ", "", get_option("londres_logo_after_scroll_margin_top")) . ";margin-bottom: " . str_replace(" ", "", get_option("londres_logo_after_scroll_margin_top")) . ";"; 
					if (get_option("londres_logo_after_scroll_margin_left")) $londres_style_data .= "margin-left: " . str_replace(" ", "", get_option("londres_logo_after_scroll_margin_left")) . ";"; 
					if (get_option("londres_logo_reduced_height")) $londres_style_data .= "height:" . get_option("londres_logo_reduced_height") . ";"; 
					else {
						if (get_option("londres_logo_height")) $londres_style_data .= "height:" . get_option("londres_logo_height") . ";";
					}
				$londres_style_data .= "
				}
				header.header_after_scroll a.navbar-brand h1{
					font-size: " . str_replace(" ", "", get_option("londres_logo_after_scroll_size")) . " !important;
				}
				";
			}
		}
	}
	
	if (get_option("londres_info_above_menu") == "on"){
		$color = londres_hex2rgb( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_bg_color") ));
		$londres_style_data .= "
		header .top-bar .top-bar-bg, header .top-bar #lang_sel a.lang_sel_sel, header .top-bar #lang_sel > ul > li > ul > li > a{
			background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_topbar_bg_opacity")))/100).");
		}
		header .top-bar ul.phone-mail li, header .top-bar ul.phone-mail li i{
			color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_text_color") )).";
		}
		header .top-bar a, header .top-bar ul.phone-mail li a{
			color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_links_color") ))." !important;
		}
		header .top-bar a:hover, header .top-bar ul.phone-mail li a:hover{
			color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_links_hover_color") ))." !important;
		}
		header .top-bar .social-icons-fa li a{
			color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_social_color") ))." !important;
		}
		header .top-bar .social-icons-fa li a:hover{
			color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_social_hover_color") ))." !important;
		}
		header .top-bar *{
			border-color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_borders_color") ))." !important;
		}
		header .top-bar .down-button{
			border-color: transparent rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_topbar_bg_opacity")))/100).") transparent transparent !important;
		}
		header .top-bar.opened .down-button{
			border-color: transparent #fff transparent transparent !important;
		}
		";
	}
	$londres_style_data .= "
	#primary_footer > .container, #primary_footer > .no-fcontainer{
		padding-top:".esc_html(intval(get_option('londres_primary_footer_padding_top'),10))."px;
		padding-bottom:".esc_html(intval(get_option('londres_primary_footer_padding_bottom'),10))."px;
	}
	#primary_footer{";
		switch (get_option("londres_footerbg_type")){
			case "image":
				$londres_style_data .= "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				$londres_style_data .= "background: url(" . esc_url(get_option("londres_footerbg_image")) . ") no-repeat; background-size: cover !important;";  
			break;
			case "color":
				$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_color")));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_footerbg_color_opacity")))/100).");";
			break;
			case "pattern":
				$londres_style_data .= "background: url('" . esc_url(get_template_directory_uri()) . "/images/londres_patterns/" . esc_html(get_option("londres_footerbg_pattern")) . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				$londres_style_data .= "background: url('" . esc_url(get_option("londres_footerbg_custom_pattern")) . "') 0 0 repeat !important;";
			break;
		}
	$londres_style_data .= "
	}
	
	.menu-square .navbar-collapse ul.navbar-nav > li.current-menu-item > a,
	.menu-square .navbar-collapse ul.navbar-nav > li.current-menu-ancestor > a,
	.menu-square .navbar-collapse ul.navbar-nav > li > a:hover,
	.menu-square .navbar-collapse ul.navbar-nav > li.menu-item-has-children:hover > a{
		background-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option('londres_menu_color_hover_pre_'.$londres_header_style_pre)))." !important;
		color: #fff !important;
	}
	
	
	
	#primary_footer input, #primary_footer textarea{";
		switch (get_option("londres_footerbg_type")){
			case "image": case "pattern": case "custom_pattern":
				$londres_style_data .= "background: transparent;";  
			break;
			case "color":
				$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_color")));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_footerbg_color_opacity")))/100).");";
			break;
		}
	$londres_style_data .= "
	}
	header.header_not_fixed ul.menu-depth-1,
	header.header_not_fixed ul.menu-depth-1 ul,
	header.header_not_fixed ul.menu-depth-1 ul li,
	header.header_not_fixed #dl-menu ul{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}

	header.header_not_fixed li:not(.londres_mega_menu) ul.menu-depth-1 li:hover, header.header_not_fixed li.londres_mega_menu li.menu-item-depth-1 li:hover, header.header_not_fixed #dl-menu ul li:hover{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sub_menu_bg_color_hover")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sub_menu_bg_opacity")))/100).") !important;
	}

	#primary_footer input, #primary_footer textarea{
		border: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_borderscolor")))." !important;
	}
	.footer_sidebar .menu li{
		border-top: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_borderscolor")))." !important;
	}
	
	.footer_sidebar .menu li:last-child{
		border-bottom: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_borderscolor")))." !important;
	}
	
	.footer_sidebar table td, .footer_sidebar table th, .footer_sidebar .wp-caption{
		border: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_borderscolor"))).";
	}
	#primary_footer a, .widget-contact-info-content{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_linkscolor"))).";
	}
	
	#primary_footer, #primary_footer p, #big_footer input, #big_footer textarea{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_paragraphscolor"))).";
	}
	
	#primary_footer .footer_sidebar > h4, #primary_footer .footer_sidebar > .widget > h4, #primary_footer .widget .widget-contact-content h4 {
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_footerbg_headingscolor"))).";
	}
	
	#secondary_footer{";
		switch (get_option("londres_sec_footerbg_type")){
			case "image":
				$londres_style_data .= "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				$londres_style_data .= "background: url(" . esc_url(get_option("londres_sec_footerbg_image")) . ") no-repeat fixed !important; background-size: cover !important;";  
			break;
			case "color":
				$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sec_footerbg_color")));
				$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_sec_footerbg_color_opacity")))/100).");";
			break;
			case "pattern":
				$londres_style_data .= "background: url('" . esc_url(get_template_directory_uri()) . "/images/londres_patterns/" . esc_html(get_option("londres_sec_footerbg_pattern")) . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				$londres_style_data .= "background: url('" . esc_url(get_option("londres_sec_footerbg_custom_pattern")) . "') 0 0 repeat !important;";
			break;
		}
		$londres_style_data .= "
		padding-top:".esc_html(intval(get_option('londres_secondary_footer_padding_top'),10))."px;
		padding-bottom:".esc_html(intval(get_option('londres_secondary_footer_padding_bottom'),10))."px;
	}";
	
	if (get_option("londres_show_sec_footer") == "on"){
		if (get_option("londres_footer_display_logo") == "on"){
			if (get_option('londres_footer_logo_type') == "text"){
				$londres_style_data .= "
				#secondary_footer .footer_logo .logo{";
					$font = get_option('londres_sec_footer_logo_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
					$londres_style_data .= "
					font-family: '".wp_kses_post($font[0])."';
					font-weight: ".esc_html($font[1]).";
					font-size: ".esc_html(intval(get_option('londres_sec_footer_logo_font_size'), 10))."px;
					color: #".esc_html(get_option('londres_sec_footer_logo_font_color')).";
				}
				#secondary_footer .footer_logo .logo:hover{
					color: #".esc_html(get_option('londres_sec_footer_logo_font_hover_color')).";
				}";
			}
		}
	}
	$londres_style_data .= "
	
	#secondary_footer .social-icons-fa a i{
		font-size: ".esc_html(intval(get_option('londres_sec_footer_social_icons_size'),10))."px;
		line-height: ".esc_html(intval(get_option('londres_sec_footer_social_icons_size'),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sec_footer_social_icons_color"))).";
	}
	#secondary_footer .social-icons-fa a i:before{
		font-size: ".esc_html(intval(get_option('londres_sec_footer_social_icons_size'),10))."px;
	}
	#secondary_footer .social-icons-fa a:hover i{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sec_footer_social_icons_hover_color"))).";
	}
	
	header.style2 .search_input{
		height: calc(100% + ".esc_html(intval(get_option('londres_menu_margin_top_pre_'.$londres_header_style_pre),10))."px);
	}
	
	header .search_input{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_input_background_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_search_input_background_opacity")))/100).");
	}
	header .search_input input.search_input_value{";
		$font = get_option("londres_search_input_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; 	if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
	}
	header .search_input input.search_input_value, header .search_close{
		font-size: ".esc_html(intval(get_option("londres_search_input_font_size"),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_input_font_color"))).";
	}
	
	header .search_input input.search_input_value::placeholder{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_input_font_color"))).";
	}
	
	
	header .search_input input.search_input_value::-webkit-input-placeholder, header .search_input input.search_input_value::-moz-placeholder, header .search_input input.search_input_value:-ms-input-placeholder, header .search_input input.search_input_value:-moz-placeholder, header .search_input input.search_input_value::placeholder{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_input_font_color"))).";
	}
	
	
	header .search_input .ajax_search_results ul{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_result_background_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_search_result_background_opacity")))/100).");
	}
	header .search_input .ajax_search_results ul li.selected{";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_selected_result_background_color")));
		$londres_style_data .= "background-color: rgba(".esc_html($color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("londres_search_result_background_opacity")))/100).");
	}
	header .search_input .ajax_search_results ul li{
		border-bottom: 1px solid #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_result_borders"))).";
	}
	header .search_input .ajax_search_results ul li a{";
		$font = get_option("londres_search_input_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; 	if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option("londres_search_result_font_size"),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_result_font_color")))."
	}
	header .search_input .ajax_search_results ul li.selected a{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_selected_result_font_color")))."
	}
	header .search_input .ajax_search_results ul li a span, header .search_input .ajax_search_results ul li a span i{";
		$font = get_option("londres_search_result_details_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		font-size: ".esc_html(intval(get_option("londres_search_result_details_font_size"),10))."px;
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_result_details_font_color")))."
	}
	header .search_input .ajax_search_results ul li.selected a span{
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_search_selected_result_details_font_color")))."
	}";
	
	if (is_user_logged_in() && get_option("londres_fixed_menu") == "on"){
		global $wpdb;
		$res = $wpdb->get_results( $wpdb->prepare("SELECT meta_value FROM $wpdb->usermeta WHERE user_id=%d AND meta_key=%s", get_current_user_id(), 'show_admin_bar_front'), OBJECT );
		
		if ($res && $res[0]->meta_value == "true"){
			$londres_style_data .= "
			body:not(.vc_editor) header:not(.headerclone) { top:32px !important; }
			@media screen and (max-width:782px) {
				body:not(.vc_editor) header:not(.headerclone), body:not(.vc_editor) header:not(.headerclone) .down-button {
					top:45px !important;
				}
				#wpadminbar{position: fixed;}
			}
			";
		}
	}
	
	$loader = (is_page_template() && get_post_meta(get_the_ID(), 'londres_enable_custom_header_options_value', true) == "yes") ? get_post_meta(get_the_ID(), 'londres_enable_website_loading_value', true) : get_option("londres_enable_website_loader");
	if ($loader == "on"){
		$londres_style_data .= "
		body #londres_website_load, #londres_website_load .load2 .loader:before, #londres_website_load .load2 .loader:after, #londres_website_load .load3 .loader:after{background: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_background"))).";}
		
		.ball-pulse>div, .ball-pulse-sync>div, .ball-scale>div, .ball-rotate>div, .ball-rotate>div:before, .ball-clip-rotate>div, .ball-clip-rotate-pulse>div:first-child, .ball-beat>div, .ball-scale-multiple>div, .ball-triangle-path>div, .ball-pulse-rise>div, .ball-grid-beat>div, .ball-grid-pulse>div, .ball-spin-fade-loader>div, .ball-zig-zag>div, .ball-zig-zag-deflect>div, .line-scale>div, .line-scale-party>div, .line-scale-pulse-out>div, .line-scale-pulse-out-rapid>div, .line-spin-fade-loader>div, .square-spin>div, .pacman>div:nth-child(3),.pacman>div:nth-child(4),.pacman>div:nth-child(5),.pacman>div:nth-child(6), .cube-transition>div, .ball-rotate>div:after, .ball-rotate>div:before, #londres_website_load .load3 .loader:before, #londres_website_load .load3 .loader:before{background-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}

		.ball-clip-rotate>div{border-top-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-left-color: #". esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-right-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}

		.ball-clip-rotate-pulse>div:last-child, .ball-clip-rotate-multiple>div:last-child{border-top-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-bottom-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}
		
		.ball-clip-rotate-multiple>div{border-right-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-left-color:#". esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}

		.ball-triangle-path>div, .ball-scale-ripple>div, .ball-scale-ripple-multiple>div{border-color:#".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}
		
		.pacman>div:first-of-type, .pacman>div:nth-child(2){border-top-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-left-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";border-bottom-color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}
		
		.load2 .loader{box-shadow:inset 0 0 0 1em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}";
		$color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")));
		$londres_style_data .= "
		.load3 .loader{background:#".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";background:-moz-linear-gradient(left, #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")))." 10%, rgba(".esc_html($color[0].",".$color[1].",".$color[2]).", 0) 42%);background:-webkit-linear-gradient(left, #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")))." 10%, rgba(".esc_html($color[0].",".$color[1].",".$color[2]).", 0) 42%);background:-o-linear-gradient(left, #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")))." 10%, rgba(".esc_html($color[0].",".$color[1].",".$color[2]).", 0) 42%);background:-ms-linear-gradient(left, #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")))." 10%, rgba(".esc_html($color[0].",".$color[1].",".$color[2]).", 0) 42%);background:linear-gradient(to right, #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color")))." 10%, rgba(".esc_html($color[0].",".$color[1].",".$color[2]).", 0) 42%);}
			
		.load6 .loader{font-size:50px;text-indent:-9999em;overflow:hidden;width:1em;height:1em;border-radius:50%;position:relative;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0);-webkit-animation:load6 1.7s infinite ease;animation:load6 1.7s infinite ease}@-webkit-keyframes 'load6'{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg);box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}5%,95%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}10%,59%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.087em -0.825em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.173em -0.812em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.256em -0.789em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.297em -0.775em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}20%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.338em -0.758em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.555em -0.617em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.671em -0.488em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.749em -0.34em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}38%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.377em -0.74em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.645em -0.522em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.775em -0.297em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.82em -0.09em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}}@keyframes 'load6'{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg);box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}5%,95%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}10%,59%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.087em -0.825em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.173em -0.812em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.256em -0.789em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.297em -0.775em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}20%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.338em -0.758em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.555em -0.617em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.671em -0.488em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.749em -0.34em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}38%{box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.377em -0.74em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.645em -0.522em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.775em -0.297em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", -0.82em -0.09em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -0.83em 0 -0.4em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.42em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.44em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.46em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).", 0 -0.83em 0 -0.477em #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_color"))).";}}";
		
		if (get_option("londres_enable_website_loader_percentage") == "on"){
			$londres_style_data .= "
			body #londres_website_load .percentage{";
				$font = get_option("londres_loader_percentage_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
				$londres_style_data .= "
				font-family: '".wp_kses_post($font[0])."', sans-serif;
				font-weight: ".esc_html($font[1]).";
				font-size: ".esc_html(intval(get_option("londres_loader_percentage_font_size"),10))."px;
				color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_loader_percentage_font_color"))).";
			}
			";
		}
	}
	
	$londres_style_data .= "
	.londres_breadcrumbs, .londres_breadcrumbs a, .londres_breadcrumbs span{";
		$font = get_option("londres_breadcrumbs_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; 		if (!isset($font[1])) $font[1] = "";
		$londres_style_data .= "
		font-family: '".wp_kses_post($font[0])."';
		font-weight: ".esc_html($font[1]).";
		color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_breadcrumbs_color"))).";
		font-size: ".esc_html(intval(get_option("londres_breadcrumbs_size"),10))."px;
	}

	#menu_top_bar > li ul{background: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_submenu_bg_color")).";}
	#menu_top_bar > li ul li:hover{background: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_submenu_bg_hover_color")).";}
	#menu_top_bar > li ul a{color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_submenu_text_color"))." !important;}
	#menu_top_bar > li ul a:hover, #menu_top_bar > li ul li:hover > a{color: #".esc_html(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_topbar_submenu_text_hover_color")))." !important;}
	
	
	
	header.navbar .nav-container .londres_right_header_icons  i, header .menu-controls i{color: #". str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_icons_color_".$londres_header_bgstyle_pre) )." !important;}
	
	header.navbar .nav-container .londres_right_header_icons i:hover, header .menu-controls .londres_right_header_icons i:hover{color: #". str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_icons_hover_color_".$londres_header_bgstyle_pre) )." !important;}
	
	header.header_after_scroll.navbar .nav-container .londres_right_header_icons i, header .menu-controls .londres_right_header_icons i{color: #". str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_after_scroll_icons_color_".$londres_header_bgstyle_after) )." !important;}
	
	header.header_after_scroll.navbar .nav-container .londres_right_header_icons i:hover, header .menu-controls .londres_right_header_icons i:hover{color: #".esc_html( str_replace( "__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_after_scroll_icons_hover_color_".$londres_header_bgstyle_after) ))." !important;}";
	
	
	
	//sliding panel
	$londres_style_data .= "
		.londres-push-sidebar.londres-push-sidebar-right{background-color:#".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sliding_panel_background_color"))." !important;}
		
		.londres-push-sidebar .widget h2 > .widget_title_span, .londres-push-sidebar .wpb_content_element .wpb_accordion_header a, .londres-push-sidebar .custom-widget h4, .londres-push-sidebar .widget.des_cubeportfolio_widget h4, .londres-push-sidebar .widget.des_recent_posts_widget h4, .londres-push-sidebar, .londres-push-sidebar .widget h4{
			";
			$font = get_option("londres_sliding_panel_titles_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data .= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sliding_panel_titles_color"))." !important;
			font-size: ".esc_html(intval(get_option("londres_sliding_panel_titles_font_size"),10))."px;
		}
		
		.londres-push-sidebar a:not(.vc_btn3 a){
			";
			$font = get_option("londres_sliding_panel_links_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data .= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sliding_panel_links_color"))." !important;
			font-size: ".esc_html(intval(get_option("londres_sliding_panel_links_font_size"),10))."px;
		}
		
		.londres-push-sidebar a:not(.vc_btn3):hover{
			color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sliding_panel_links_color_hover"))." !important;
		}
		
		.londres-push-sidebar p, .londres-push-sidebar a:not(.vc_btn3), .londres-push-sidebar .widget ul li, .londres-push-sidebar .widget span{
			";
			$font = get_option("londres_sliding_panel_p_font"); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data .= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_sliding_panel_p_color"))." !important;
			font-size: ".esc_html(intval(get_option("londres_sliding_panel_p_font_size"),10))."px;
		}
	";
	
	/* new typography stuffs */
	$londres_style_data .= "
		.widget h2 > .widget_title_span, .custom-widget h4, .widget.des_cubeportfolio_widget h4, .widget.des_recent_posts_widget h4{
			";
			$font = get_option('londres_widgets_sidebars_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data.= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			color: #".str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_widgets_sidebars_color")).";
			font-size: ".esc_html(intval(get_option("londres_widgets_sidebars_size"),10))."px;
			letter-spacing: -0.5px;
			text-transform: capitalize;
		}
		
		#big_footer .widget h2 > .widget_title_span, #big_footer .custom-widget h4, #big_footer .widget.des_cubeportfolio_widget h4, #big_footer .widget.des_recent_posts_widget h4, #primary_footer .footer_sidebar > h4, #primary_footer .widget h4, #primary_footer .widget .widget-contact-content h4{
			";
			$font = get_option('londres_widgets_footer_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data.= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			font-size: ".esc_html(intval(get_option("londres_widgets_footer_size"),10))."px !important;
			letter-spacing: 1px !important;
		}
		
		#londres-push-sidebar-content .widget h2 > .widget_title_span, #londres-push-sidebar-content .custom-widget h4, #londres-push-sidebar-content .widget.des_cubeportfolio_widget h4, #londres-push-sidebar-content .widget.des_recent_posts_widget h4{
			";
			$font = get_option('londres_widgets_sliding_panel_font'); $londres_import_fonts[] = $font; $font = explode("|",$font); $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
			$londres_style_data.= "
			font-family: '".wp_kses_post($font[0])."';
			font-weight: ".esc_html($font[1]).";
			font-size: ".esc_html(intval(get_option("londres_widgets_sliding_panel_size"),10))."px;
		}
	";
	
	if (get_option("enable_custom_css") == "on"){
		$londres_customcss = get_option("londres_custom_css");
		if (gettype($londres_customcss) === "string" && $londres_customcss != "") {
			$londres_style_data .= stripslashes($londres_customcss);
		}
	}

	wp_add_inline_style('londres-style', $londres_style_data);
	
}
add_action( 'wp_enqueue_scripts', 'londres_custom_style', 2 );

?>