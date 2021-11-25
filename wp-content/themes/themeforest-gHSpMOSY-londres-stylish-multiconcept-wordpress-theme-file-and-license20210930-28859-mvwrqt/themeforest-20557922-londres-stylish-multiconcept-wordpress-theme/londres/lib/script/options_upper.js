jQuery(document).ready(function($){ 
	"use strict";
	/* custom css */
	var _default_custom_css = jQuery('#enable_custom_css').val();
	jQuery('#enable_custom_css').on("change", function(){
		if (jQuery('#enable_custom_css').val() == "on"){
			jQuery('#enable_custom_css').closest('.option').next().next().fadeIn(500);
		} else {
			jQuery('#enable_custom_css').closest('.option').next().next().fadeOut(500);
		} 
	}).trigger('change');
	
	/* website loader options */
	var _default_website_loader = jQuery('#londres_enable_website_loader').val();
	jQuery('#londres_enable_website_loader').on("change", function(){
		if (jQuery('#londres_enable_website_loader').val() == "on"){
			jQuery('.loaders-styles-holder').removeAttr('hidden');
			jQuery('#londres_website_loader').closest('.option').add(jQuery('#londres_enable_website_loader_percentage').closest('.option')).fadeIn(500);
		} else {
			jQuery('#londres_website_loader').closest('.option').add(jQuery('#londres_enable_website_loader_percentage').closest('.option')).fadeOut(500);
		}
	}).trigger('change');
	
	
	/* body boxed layout options */
	jQuery('#londres_bodybg_type').on("change", function(){
		if (jQuery(this).val() == 'image') {
			jQuery('#upload-londres_bodybg_type_image').closest('.option').fadeIn(500);
			jQuery('#londres_bodybg_type_color').closest('.option').fadeOut(500);
		} else {
			jQuery('#upload-londres_bodybg_type_image').closest('.option').fadeOut(500);
			jQuery('#londres_bodybg_type_color').closest('.option').fadeIn(500);
		}
	}).trigger('change');
	
	jQuery('#londres_body_type').on("change", function(){
		if (jQuery(this).val() == 'body_boxed'){
			jQuery('#londres_bodybg_type').trigger('change').closest('.option').fadeIn(500);
		} else {
			jQuery(this).closest('.option').nextAll().fadeOut(500);
		}
	}).trigger('change');
	
	/* footer custom text editor */
	var submiter = jQuery('.textarea_wysiwyg_container input#submit');
		submiter.css('display','none');
	jQuery('input.save-button').on("click",function(){ submiter.trigger("click"); });
		
	/* headers and menus */
	if (jQuery('.londres_fixed_menu').html() == 'on' && jQuery('.londres_header_shrink_effect').html() == 'on' && jQuery('.londres_header_after_scroll').html() == 'on'){
		jQuery('#londres_logo_after_scroll_size').closest('.option').prev().nextAll().addBack().css('display','block');
		jQuery('#londres_logo_font').closest('.option').nextUntil(jQuery('#londres_logo_margin_top').closest('.option')).addBack()
			.add(jQuery('#londres_logo_after_scroll_size').closest('.option').nextUntil(jQuery('#londres_logo_after_scroll_margin_top').closest('.option')).addBack())
			.css('display','none');
	} else {
		jQuery('#londres_logo_after_scroll_size').closest('.option').prev().nextAll().addBack().css('display','none');
		if (jQuery('.londres_header_after_scroll').html() == 'on'){

		} else {
			jQuery('#londres_headerbg_after_scroll_type_light').closest('.option').prev().nextAll().addBack().css('display','none');
			jQuery('#londres_headerbg_after_scroll_type_dark').closest('.option').prev().nextAll().addBack().css('display','none');

		}
	}
	
	/* logo type */
/* 	if (jQuery('.londres_logo_type.hidden').html() != 'text') */ jQuery('#londres_logo_font').closest('.option').nextUntil(jQuery('#londres_logo_margin_top').closest('.option')).addBack()
		.add(jQuery('#londres_logo_after_scroll_size').closest('.option').nextUntil(jQuery('#londres_logo_after_scroll_margin_top').closest('.option')).addBack())
		.css('display','none');
	
	if (jQuery('.londres_header_after_scroll').html() == 'on'){
		//menu
		if (jQuery('.londres_header_shrink_effect').html() == 'off'){
			jQuery('#londres_menu_after_scroll_font_size').closest('.option')
				.add(jQuery('#londres_menu_after_scroll_margin_top').closest('.option'))
				.add(jQuery('#londres_menu_after_scroll_padding_bottom').closest('.option'))
			.css('display','none');
		}
		//background afterscroll options
		jQuery('#londres_headerbg_after_scroll_type').on("change", function(){
			switch (jQuery('#londres_headerbg_after_scroll_type').val()){
				case "color":
					jQuery('#londres_headerbg_after_scroll_color').closest('.option')
						.add(jQuery('#londres_headerbg_after_scroll_opacity').closest('.option'))
					.css('display','block');
					jQuery('#londres_headerbg_after_scroll_image').closest('.option')
						.add(jQuery('#londres_headerbg_after_scroll_pattern').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_custom_pattern').closest('.option'))
					.css('display','none');
				break;
				case "image":
					jQuery('#londres_headerbg_after_scroll_image').closest('.option').css('display','block');
					jQuery('#londres_headerbg_after_scroll_color').closest('.option')
						.add(jQuery('#londres_headerbg_after_scroll_pattern').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_custom_pattern').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_opacity').closest('.option'))
					.css('display','none');
				break;
				case "pattern":
					jQuery('#londres_headerbg_after_scroll_pattern').closest('.option').css('display','block');
					jQuery('#londres_headerbg_after_scroll_color').closest('.option')
						.add(jQuery('#londres_headerbg_after_scroll_image').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_custom_pattern').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_opacity').closest('.option'))
					.css('display','none');
				break;
				case "custom_pattern":
					jQuery('#londres_headerbg_after_scroll_pattern').closest('.option').css('display','block');
					jQuery('#londres_headerbg_after_scroll_color').closest('.option')
						.add(jQuery('#londres_headerbg_after_scroll_image').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_custom_pattern').closest('.option'))
						.add(jQuery('#londres_headerbg_after_scroll_opacity').closest('.option'))
					.css('display','none');
				break;
			}	
		});
		jQuery('#londres_headerbg_after_scroll_type').trigger('change');	
	} else {
		// no after scroll neither shrink 
		jQuery('#londres_menu_after_scroll_font_size').closest('.option').prev().nextAll().addBack().css('display','none');
	}

	jQuery('#londres_social_icons_style_four').closest('.option').next().find('p').appendTo(jQuery('#londres_social_icons_style_four').closest('.option'));
	jQuery('#londres_social_icons_style_four').closest('.option').next().remove();
	jQuery('#londres_social_icons_style_four').siblings('p').css({'clear':'both','float':'left'});

	/*limit portfolio custom permalink*/
	jQuery('#londres_portfolio_permalink').attr('maxlength',20);
	jQuery('#londres_portfolio_permalink').closest('.option').next().css({
		'margin-top': '-15px',
		'z-index': 81,
		'background': 'white',
		'border-bottom': '1px solid #EDEDED',
		'color':'#999'
	});

	/* header style type */
	jQuery('#londres_header_style_type').closest('.option').css('display','none');
	jQuery('#londres_header_style_type option').each(function(e){
		var alt = "";
		switch(e){
			case 0:
				alt = "ESQ: logo ---- DIR: menu + socials";
			break;
			case 1:
				alt = "ESQ: logo + icons ---- DIR: socials";
			break;
			case 2:
				alt = "CENTER: logo + menu + socials possivelmente (tudo centrado)";
			break;
			case 3:
				alt = "CENTER: metade menu + logo + metade menu";
			break;
		}
		if (jQuery(this).is(':selected')){
			jQuery(this).parents('.sub-navigation-container').append('<div class="screenshot_container selected"><img class="style-'+e+'" src="" alt="'+alt+'" /></div>');
		} else {
			jQuery(this).parents('.sub-navigation-container').append('<div class="screenshot_container"><img class="style-'+e+'" src="" alt="'+alt+'" /></div>');
		}
	});
	jQuery('#londres_header_style_type').parents('.sub-navigation-container').on("click", "img", function(){
		var idx = jQuery(this).attr('class').split('le-');
		jQuery('#londres_header_style_type').val( jQuery('#londres_header_style_type option').eq(idx[1]).val() );
		jQuery(this).parent().addClass('selected').siblings().removeClass('selected');
	});
	/* endof header style type */

	var def_sidebars = jQuery('#sidebar_name_list').html();

	jQuery('#tab_navigation-9-customcss textarea').keydown(function(e) {
	    if(e.keyCode === 9) { // tab was pressed
	        // get caret position/selection
	        var start = this.selectionStart;
	        var end = this.selectionEnd;
	
	        var $this = $(this);
	        var value = $this.val();
	
	        $this.val(value.substring(0, start)
	                    + "\t"
	                    + value.substring(end));
	
	        this.selectionStart = this.selectionEnd = start + 1;
	        e.preventDefault();
	    }
	});

	jQuery('#londres_export_options_button, #londres_export_style_options_button').css('top',0).closest('.option').find('br').remove();

	/*panel options*/
	jQuery('#londres_import_options_button').closest('.option').append('<a class="londres-button custom-option-button" style="position: relative; float: left; clear: both; margin-top: 20px;" id="londres_apply_imported_settings_button" ><span>Apply Settings</span></a>');
	jQuery('#londres_import_options_button').siblings('.londres-button').on("click",function(){
		var confirm = window.confirm("This will replace all your panel options.\n\rAre you sure?");
		if (confirm==true){
		 	var xmlPath = jQuery('#londres_import_options').val();
			jQuery.ajax({
				url: "admin-ajax.php",
				dataType: "json",
				type: 'POST',
				data: {
					xmlPath: xmlPath,
					thepath: jQuery('#homePATH').html()!=""?jQuery('#homePATH').html():jQuery('#homePATH2').html(),
					action: 'call_upper_load_settings',
					security: jQuery('#londres-theme-options').val()
				},
				error: function () {
				
				},
				success: function (c) {
					window.location = window.location;
				}
			});
		}
	});
	jQuery('#londres_reset_options_button').off().css({
		'position':'relative',
		'float':'left',
		'display':'inline-block',
		'clear':'both'
	});
	jQuery('#londres_reset_options_button').siblings('ul').css('display','none');
	jQuery('#londres_reset_options_button').on("click",function(e){
		e.stopPropagation();
		e.preventDefault();
		var confirm = window.confirm("Are you sure?");
		if (confirm == true){
		 	var xmlPath = jQuery('#templatepath').html()+"/londres_original_panel_options.xml";
			jQuery.ajax({
				url: "admin-ajax.php",
				dataType: "json",
				type: 'POST',
				data: {
					xmlPath: xmlPath,
					thepath: jQuery('#homePATH').html()!=""?jQuery('#homePATH').html():jQuery('#homePATH2').html(),
					action: 'call_upper_load_settings',
					upper_action: 'reset',
					security: jQuery('#londres-theme-options').val()
				},
				error: function () {
				
				},
				success: function (c) {
					window.location = window.location;
				}
			});
	        jQuery(this).siblings('ul').remove();
		} else {
			return false;
		}
	});
	
	/*panel style options*/
	jQuery('#londres_import_style_options_button').closest('.option').append('<a class="londres-button custom-option-button" style="position: relative; float: left; clear: both; margin-top: 20px;" id="londres_apply_imported_style_settings_button" ><span>Apply Settings</span></a>');
	jQuery('#londres_import_style_options_button').siblings('.londres-button').on("click",function(){
		var confirm = window.confirm("This will replace all your panel options.\n\rAre you sure?");
		if (confirm==true){
		 	var xmlPath = jQuery('#londres_import_style_options').val();
			jQuery.ajax({
				url: "admin-ajax.php",
				dataType: "json",
				type: 'POST',
				data: {
					xmlPath: xmlPath,
					thepath: jQuery('#homePATH').html()!=""?jQuery('#homePATH').html():jQuery('#homePATH2').html(),
					action: 'call_upper_load_settings',
					security: jQuery('#londres-theme-style-options').val()
				},
				error: function () {
			
				},
				success: function (c) {
					window.location = window.location;
				}
			});
		}
	});
	jQuery('#londres_reset_style_options_button').off().css({
		'position':'relative',
		'float':'left',
		'display':'inline-block',
		'clear':'both'
	});
	jQuery('#londres_reset_style_options_button').siblings('ul').css('display','none');
	jQuery('#londres_reset_style_options_button').on("click",function(e){
		e.stopPropagation();
		e.preventDefault();
		var confirm = window.confirm("Are you sure?");
		if (confirm == true){
		 	var xmlStylePath = jQuery('#templatepath').html()+"/londres_original_panel_style_options.xml";
			jQuery.ajax({
				url: "admin-ajax.php",
				dataType: "json",
				type: 'POST',
				data: {
					xmlStylePath: xmlStylePath,
					thepath: jQuery('#homePATH').html()!=""?jQuery('#homePATH').html():jQuery('#homePATH2').html(),
					action: 'call_upper_load_settings',
					upper_action: 'reset',
					security: jQuery('#londres-theme-style-options').val()
				},
				error: function () {
				
				},
				success: function (c) {
					window.location = window.location;
				}
			});
	        jQuery(this).siblings('ul').remove();
		} else {
			return false;
		}
	});
	
	var _default_menu_add_border = jQuery('#londres_menu_add_border').val();
	jQuery('#londres_menu_add_border').on("change", function(){
		if (jQuery(this).val() == "on"){
			jQuery('#londres_menu_border_color').closest('.option').fadeIn(500);
		} else {
			jQuery('#londres_menu_border_color').closest('.option').fadeOut(500);
		}
	}).trigger('change');
	
	var _default_ajax_search = jQuery('#londres_enable_ajax_search').val();
	jQuery('#londres_enable_ajax_search').on("change", function(){
		if (jQuery(this).val() == "on"){
			jQuery('#londres_search_show_author').closest('.option').prev().nextAll().addBack().fadeIn(500);
		} else jQuery('#londres_search_show_author').closest('.option').prev().nextAll().addBack().fadeOut(500);
	}).trigger('change');
	
	var _default_search = jQuery('#londres_enable_search').val();
	jQuery('#londres_enable_search').on("change", function(){
		if (jQuery(this).val() == "on" ){
			jQuery(this).closest('.option').nextUntil(jQuery('#londres_search_sidebars_available').closest('.option').next()).fadeIn(500);
			jQuery('#londres_enable_ajax_search').trigger('change');
		} else jQuery(this).closest('.option').nextAll().fadeOut(500);
	}).trigger('change');
	
	var _default_footer_display_social_icons = jQuery('#londres_footer_display_social_icons').val();
	jQuery('#londres_footer_display_social_icons').on("change", function(){
		if (jQuery(this).val() == 'on'){
			jQuery('#londres_footer_social_icons_alignment').closest('.option').fadeIn(500);
		} else {
			jQuery('#londres_footer_social_icons_alignment').closest('.option').fadeOut(500);
		}
	}).trigger('change');
	
	var _default_footer_display_custom_text = jQuery('#londres_footer_display_custom_text').val();
	jQuery('#londres_footer_display_custom_text').on("change", function(){
		if (jQuery(this).val() == 'on'){
			jQuery('#londres_footer_custom_text').closest('.option').add(jQuery('#londres_footer_custom_text_alignment').closest('.option')).fadeIn(500);
		} else {
			jQuery('#londres_footer_custom_text').closest('.option').add(jQuery('#londres_footer_custom_text_alignment').closest('.option')).fadeOut(500);
		}
	}).trigger('change');
	
	var _default_footer_display_logo = jQuery('#londres_footer_display_logo').val();
	jQuery('#londres_footer_display_logo').on("change", function(){
		if (jQuery(this).val() == 'on'){
			jQuery(this).closest('.option').nextUntil(jQuery('#londres_footer_display_social_icons').closest('.option')).css('display','block');
		} else {
			jQuery(this).closest('.option').nextUntil(jQuery('#londres_footer_display_social_icons').closest('.option')).css('display','none');
		}
	}).trigger('change');
	


	
	var _default_under_construction = jQuery('#londres_enable_under_construction').val();
	if (_default_under_construction === "on"){
		jQuery('#londres_under_construction_page').closest('.option').fadeIn(500);
	} else {
		jQuery('#londres_under_construction_page').closest('.option').fadeOut(500);
	}
	jQuery('#londres_enable_under_construction').on("change", function(){
		if (_default_under_construction === "on"){
			jQuery('#londres_under_construction_page').closest('.option').fadeIn(500);
		} else {
			jQuery('#londres_under_construction_page').closest('.option').fadeOut(500);
		}		
	});
	
	var _default_animate_thumbnails = jQuery('#londres_animate_thumbnails').val();
	if (_default_animate_thumbnails === "on"){
		jQuery('#londres_thumbnails_effect').closest('.option').fadeIn(500);
	} else {
		jQuery('#londres_thumbnails_effect').closest('.option').fadeOut(500);
	}
	jQuery('#londres_animate_thumbnails').on("change", function(){
		if (_default_animate_thumbnails === "on"){
			jQuery('#londres_thumbnails_effect').closest('.option').fadeIn(500);
		} else {
			jQuery('#londres_thumbnails_effect').closest('.option').fadeOut(500);
		}
	});
	
	var _default_body_shadow = jQuery('#londres_body_shadow').val();
	if (_default_body_shadow === "on"){
		jQuery('#londres_body_shadow').closest('.option').next().fadeIn(500).removeClass('optoff');
	} else {
		jQuery('#londres_body_shadow').closest('.option').next().fadeOut(500).addClass('optoff');
	}
	jQuery('#londres_body_shadow').on("change", function(){
		if (_default_body_shadow === "on"){
			jQuery('#londres_body_shadow').closest('.option').next().fadeIn(500).removeClass('optoff');
		} else {
			jQuery('#londres_body_shadow').closest('.option').next().fadeOut(500).addClass('optoff');
		}
	});
	
	//body background type
	var _default_body_background = jQuery('#londres_body_type').val();
	switch(_default_body_background){
		case "image":
			jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().fadeIn(500).removeClass('optoff');
			break;
		case "color":
			jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().fadeIn(500).removeClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().fadeOut(500).addClass('optoff');
			break;
		case "pattern": case "custom_pattern":
			jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeIn(500).removeClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().next().fadeIn(500).removeClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().next().fadeOut(500).addClass('optoff');
			jQuery('#londres_body_type').closest('.option').next().fadeOut(500).addClass('optoff');
			break;
	}
	jQuery('#londres_body_type').on("change", function(){
		var _default_body_background = jQuery('#londres_body_type').val();
		switch(_default_body_background){
			case "image":
				jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().fadeIn(500).removeClass('optoff');
				break;
			case "color":
				jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().fadeIn(500).removeClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().fadeOut(500).addClass('optoff');
				break;
			case "pattern": case "custom_pattern":
				jQuery('#londres_body_type').closest('.option').next().next().next().next().fadeIn(500).removeClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().next().fadeIn(500).removeClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().next().fadeOut(500).addClass('optoff');
				jQuery('#londres_body_type').closest('.option').next().fadeOut(500).addClass('optoff');
				break;
		}
	});	
	
	var _default_headerbg_type_light = jQuery('#londres_headerbg_type_light').val();
	switch (_default_headerbg_type_light){
		case "color":
			jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_opacity_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_headerbg_image_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_custom_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);		
		break;
	}
	jQuery('#londres_headerbg_type_light').on("change", function(){
		switch (_default_headerbg_type_light){
			case "color":
				jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_opacity_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_headerbg_image_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_custom_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_headerbg_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);		
			break;
		}
	});


	var _default_headerbg_after_scroll_type_light = jQuery('#londres_headerbg_after_scroll_type_light').val();
	switch (_default_headerbg_after_scroll_type_light){
		case "color":
			jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);		
		break;
	}
	jQuery('#londres_headerbg_after_scroll_type_light').on("change", function(){
		switch (_default_headerbg_after_scroll_type_light){
			case "color":
				jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_headerbg_after_scroll_image_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_light').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_light').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_light').closest('.option').removeClass('optoff').fadeIn(500);		
			break;
		}
	});

	
	var _default_headerbg_type_dark = jQuery('#londres_headerbg_type_dark').val();
	switch (_default_headerbg_type_dark){
		case "color":
			jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_opacity_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_headerbg_image_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);		
		break;
	}
	jQuery('#londres_headerbg_type_dark').on("change", function(){
		switch (_default_headerbg_type_dark){
			case "color":
				jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_opacity_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_headerbg_image_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_headerbg_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_custom_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);		
			break;
		}
	});
	
	var _default_headerbg_after_scroll_type_dark = jQuery('#londres_headerbg_after_scroll_type_dark').val();
	switch (_default_headerbg_after_scroll_type_dark){
		case "color":
			jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);		
		break;
	}
	jQuery('#londres_headerbg_after_scroll_type_dark').on("change", function(){
		switch (_default_headerbg_after_scroll_type_dark){
			case "color":
				jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_headerbg_after_scroll_image_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_color_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_opacity_dark').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_pattern_dark').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_headerbg_after_scroll_custom_pattern_dark').closest('.option').removeClass('optoff').fadeIn(500);		
			break;
		}
	});
	
	
	var _default_toppanelbg_type = jQuery('#londres_toppanelbg_type').val();
	switch (_default_toppanelbg_type){
		case "color":
			jQuery('#londres_toppanelbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_color').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_toppanelbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_toppanelbg_image').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_toppanelbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_toppanelbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_toppanelbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_toppanelbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
		break;
	}
	jQuery('#londres_toppanelbg_type').on("change", function(){
		switch (_default_toppanelbg_type){
			case "color":
				jQuery('#londres_toppanelbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_color').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_toppanelbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_toppanelbg_image').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_toppanelbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_toppanelbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_toppanelbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_toppanelbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			break;
		}
	});
	
	var _default_sec_footerbg_type = jQuery('#londres_sec_footerbg_type').val();
	switch (_default_sec_footerbg_type){
		case "color":
			jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_color').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_sec_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_sec_footerbg_image').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_pattern').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
		break;
	}
	jQuery('#londres_sec_footerbg_type').on("change", function(){
		switch (_default_sec_footerbg_type){
			case "color":
				jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_color').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_sec_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_sec_footerbg_image').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_sec_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_pattern').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_sec_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_sec_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			break;
		}
	});
	
	
	var _default_footerbg_type = jQuery('#londres_footerbg_type').val();
	switch (_default_footerbg_type){
		case "color":
			jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_footerbg_image').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeOut(500);
		break;
		case "custom_pattern":
			jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_pattern').closest('.option').removeClass('optoff').fadeOut(500);
			jQuery('#londres_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
		break;
	}
	jQuery('#londres_footerbg_type').on("change", function(){
		switch (_default_footerbg_type){
			case "color":
				jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_footerbg_image').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_pattern').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeOut(500);
			break;
			case "custom_pattern":
				jQuery('#londres_footerbg_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_color_opacity').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_pattern').closest('.option').removeClass('optoff').fadeOut(500);
				jQuery('#londres_footerbg_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			break;
		}
	});
	
	var _default_twitter_newsletter_type = jQuery('#londres_twitter_newsletter_type').val();
	switch (_default_twitter_newsletter_type){
		case "color":
			jQuery('#londres_twitter_newsletter_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_twitter_newsletter_color').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_twitter_newsletter_pattern').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "image":
			jQuery('#londres_twitter_newsletter_image').closest('.option').removeClass('optoff').fadeIn(500);
			jQuery('#londres_twitter_newsletter_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_twitter_newsletter_pattern').closest('.option').addClass('optoff').fadeOut(500);	
			jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
		break;
		case "pattern":
			jQuery('#londres_twitter_newsletter_image').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_twitter_newsletter_color').closest('.option').addClass('optoff').fadeOut(500);
			jQuery('#londres_twitter_newsletter_pattern').closest('.option').removeClass('optoff').fadeIn(500);		
			jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
		break;
	}
	jQuery('#londres_twitter_newsletter_type').on("change", function(){
		switch (_default_twitter_newsletter_type){
			case "color":
				jQuery('#londres_twitter_newsletter_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_twitter_newsletter_color').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_twitter_newsletter_pattern').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "image":
				jQuery('#londres_twitter_newsletter_image').closest('.option').removeClass('optoff').fadeIn(500);
				jQuery('#londres_twitter_newsletter_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_twitter_newsletter_pattern').closest('.option').addClass('optoff').fadeOut(500);	
				jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').addClass('optoff').fadeOut(500);
			break;
			case "pattern":
				jQuery('#londres_twitter_newsletter_image').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_twitter_newsletter_color').closest('.option').addClass('optoff').fadeOut(500);
				jQuery('#londres_twitter_newsletter_pattern').closest('.option').removeClass('optoff').fadeIn(500);		
				jQuery('#londres_twitter_newsletter_custom_pattern').closest('.option').removeClass('optoff').fadeIn(500);
			break;
		}
	});
	
	//style > body - body layout type
	var _default_body_layout_type = jQuery('#londres_body_layout_type').val();
	if (_default_body_layout_type === "full"){
		jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().next().fadeOut(500);
		jQuery('#londres_body_layout_type').closest('.option').next().fadeOut(500);
	} else {
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().next().fadeIn(500);
		if (!jQuery('#londres_body_layout_type').closest('.option').next().hasClass('optoff'))
			jQuery('#londres_body_layout_type').closest('.option').next().fadeIn(500);
	}
	jQuery('#londres_body_layout_type').on("change", function(){
		if (_default_body_layout_type === "full"){
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().next().fadeOut(500);
			jQuery('#londres_body_layout_type').closest('.option').next().fadeOut(500);
		} else {
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().next().fadeIn(500);
			if (!jQuery('#londres_body_layout_type').closest('.option').next().hasClass('optoff'))
				jQuery('#londres_body_layout_type').closest('.option').next().fadeIn(500);
		}
	});
	
	var _default_overlay_type = jQuery('#londres_pagetitle_overlay_type').val();
	jQuery('#londres_pagetitle_overlay_type').on("change", function(){
		_default_overlay_type = jQuery('#londres_pagetitle_overlay_type').val();
		if (jQuery('#londres_pagetitle_overlay_type').val() == "color"){
			jQuery('#londres_pagetitle_overlay_color').closest('.option').fadeIn(500);
			jQuery('#londres_pagetitle_overlay_pattern').closest('.option').fadeOut(500);
		} else {
			jQuery('#londres_pagetitle_overlay_color').closest('.option').fadeOut(500);
			jQuery('#londres_pagetitle_overlay_pattern').closest('.option').fadeIn(500);
		}
	}).trigger('change');
	
	var _default_overlay_type_shop = jQuery('#londres_pagetitle_overlay_type_shop').val();
	jQuery('#londres_pagetitle_overlay_type_shop').on("change", function(){
		_default_overlay_type_shop = jQuery('#londres_pagetitle_overlay_type_shop').val();
		if (jQuery('#londres_pagetitle_overlay_type_shop').val() == "color"){
			jQuery('#londres_pagetitle_overlay_color_shop').closest('.option').fadeIn(500);
			jQuery('#londres_pagetitle_overlay_pattern_shop').closest('.option').fadeOut(500);
		} else {
			jQuery('#londres_pagetitle_overlay_color_shop').closest('.option').fadeOut(500);
			jQuery('#londres_pagetitle_overlay_pattern_shop').closest('.option').fadeIn(500);
		}
	}).trigger('change');
	
	var _default_overlay_enable = jQuery('#londres_pagetitle_image_overlay').val();
	jQuery('#londres_pagetitle_image_overlay').on("change", function(){
		_default_overlay_enable = jQuery('#londres_pagetitle_image_overlay').val();
		if (jQuery('#londres_pagetitle_image_overlay').val() == "on"){
			jQuery('#londres_pagetitle_overlay_opacity').closest('.option').add(jQuery('#londres_pagetitle_overlay_type').closest('.option')).fadeIn(500);
			jQuery('#londres_pagetitle_overlay_type').trigger("change");
		} else {
			jQuery('#londres_pagetitle_overlay_type').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).addBack().fadeOut(500);
		}
	}).trigger('change');
	
	var _default_overlay_enable_shop = jQuery('#londres_pagetitle_image_overlay_shop').val();
	jQuery('#londres_pagetitle_image_overlay_shop').on("change", function(){
		_default_overlay_enable_shop = jQuery('#londres_pagetitle_image_overlay_shop').val();
		if (jQuery('#londres_pagetitle_image_overlay_shop').val() == "on"){
			jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').add(jQuery('#londres_pagetitle_overlay_type_shop').closest('.option')).fadeIn(500);
			jQuery('#londres_pagetitle_overlay_type_shop').trigger("change");
		} else {
			jQuery('#londres_pagetitle_overlay_type_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).addBack().fadeOut(500);
		}
	}).trigger('change');
	
	//style > header - background type
	var _default_header_bkg = jQuery('#londres_header_type').val();
	jQuery('#londres_header_type').on("change", function(){
		var _default_header_bkg = jQuery('#londres_header_type').val();
		switch (_default_header_bkg){
			case "without": 			
				jQuery('#londres_header_type').closest('.option').nextAll().fadeOut(500);
			break;
			case "none": case "border":
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
				.fadeIn(500);
				
				
				
				jQuery('#upload-londres_header_image').closest('.option')
					.add(jQuery('#londres_header_color').closest('.option')).add(jQuery('#londres_header_opacity').closest('.option'))
					.add(jQuery('#londres_header_pattern').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern').closest('.option'))
				.fadeOut(500);
				
				jQuery('#londres_pagetitle_image_parallax').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).addBack().fadeOut();
				
			break;
			case "image":
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
				.fadeIn(500);
				
				jQuery('#upload-londres_header_image').closest('.option').fadeIn(500);
				
				jQuery('#londres_header_color').closest('.option').add(jQuery('#londres_header_opacity').closest('.option'))
					.add(jQuery('#londres_header_pattern').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern').closest('.option'))
					.add(jQuery('#londres_banner_slider').closest('.option'))
				.fadeOut(500);
				
				jQuery('#londres_pagetitle_image_parallax').closest('.option').add(jQuery('#londres_pagetitle_image_overlay').closest('.option')).fadeIn(500);
				jQuery('#londres_pagetitle_image_overlay').trigger("change");
				
			break;
			case "color":
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_header_color').closest('.option')
					.add(jQuery('#londres_header_opacity').closest('.option'))
				.fadeIn(500);
				
				jQuery('#upload-londres_header_image').closest('.option')
					.add(jQuery('#londres_header_pattern').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern').closest('.option'))
					.add(jQuery('#londres_banner_slider').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).fadeOut();
				
			break;
			case "pattern":
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_header_pattern').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image').closest('.option')
					.add(jQuery('#londres_header_color').closest('.option')).add(jQuery('#londres_header_opacity').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern').closest('.option'))
					.add(jQuery('#londres_banner_slider').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).fadeOut();
				
			break;
			case "custom_pattern":
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax').closest('.option'))
				.fadeIn(500);
				
				jQuery('#upload-londres_header_custom_pattern').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image').closest('.option')
					.add(jQuery('#londres_header_color').closest('.option')).add(jQuery('#londres_header_opacity').closest('.option'))
					.add(jQuery('#londres_header_pattern').closest('.option'))
					.add(jQuery('#londres_banner_slider').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).fadeOut();
				
			break;
			case "banner":
			
				jQuery('#londres_header_text_alignment').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_banner_slider').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image').closest('.option')
					.add(jQuery('#londres_header_color').closest('.option')).add(jQuery('#londres_header_opacity').closest('.option'))
					.add(jQuery('#londres_header_pattern').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity').closest('.option').next()).fadeOut();
				
			break;
		}
		if (_default_header_bkg == "border" || _default_header_bkg == "image" || _default_header_bkg == "pattern" || _default_header_bkg == "custom_pattern" || _default_header_bkg == "banner" || _default_header_bkg == "color"){
			jQuery('#londres_header_height').closest('.option').fadeIn(500);
			jQuery('#londres_header_text_alignment').closest('.option').fadeIn(500);
			jQuery('#londres_hide_pagetitle').add(jQuery('#londres_hide_sec_pagetitle')).add(jQuery('#londres_breadcrumbs')).trigger('change');
		}
	}).trigger('change');
	
	
	var _default_header_bkg_shop = jQuery('#londres_header_type_shop').val();
	jQuery('#londres_header_type_shop').on("change", function(){
		var _default_header_bkg_shop = jQuery('#londres_header_type_shop').val();
		switch (_default_header_bkg_shop){
			case "without": 			
				jQuery('#londres_header_type_shop').closest('.option').nextAll().fadeOut(500);
			break;
			case "none": case "border":
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
				.fadeIn(500);
				
				
				
				jQuery('#upload-londres_header_image_shop').closest('.option')
					.add(jQuery('#londres_header_color_shop').closest('.option')).add(jQuery('#londres_header_opacity_shop').closest('.option'))
					.add(jQuery('#londres_header_pattern_shop').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern_shop').closest('.option'))
				.fadeOut(500);
				
				jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).addBack().fadeOut();
				
			break;
			case "image":
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
				.fadeIn(500);
				
				jQuery('#upload-londres_header_image_shop').closest('.option').fadeIn(500);
				
				jQuery('#londres_header_color_shop').closest('.option').add(jQuery('#londres_header_opacity_shop').closest('.option'))
					.add(jQuery('#londres_header_pattern_shop').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern_shop').closest('.option'))
					.add(jQuery('#londres_banner_slider_shop').closest('.option'))
				.fadeOut(500);
				
				jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').add(jQuery('#londres_pagetitle_image_overlay_shop').closest('.option')).fadeIn(500);
				jQuery('#londres_pagetitle_image_overlay_shop').trigger("change");
				
			break;
			case "color":
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax_shop').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_header_color_shop').closest('.option')
					.add(jQuery('#londres_header_opacity_shop').closest('.option'))
				.fadeIn(500);
				
				jQuery('#upload-londres_header_image_shop').closest('.option')
					.add(jQuery('#londres_header_pattern_shop').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern_shop').closest('.option'))
					.add(jQuery('#londres_banner_slider_shop').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).fadeOut();
				
			break;
			case "pattern":
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax_shop').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_header_pattern_shop').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image_shop').closest('.option')
					.add(jQuery('#londres_header_color_shop').closest('.option')).add(jQuery('#londres_header_opacity_shop').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern_shop').closest('.option'))
					.add(jQuery('#londres_banner_slider_shop').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).fadeOut();
				
			break;
			case "custom_pattern":
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax_shop').closest('.option'))
				.fadeIn(500);
				
				jQuery('#upload-londres_header_custom_pattern_shop').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image_shop').closest('.option')
					.add(jQuery('#londres_header_color_shop').closest('.option')).add(jQuery('#londres_header_opacity_shop').closest('.option'))
					.add(jQuery('#londres_header_pattern_shop').closest('.option'))
					.add(jQuery('#londres_banner_slider_shop').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).fadeOut();
				
			break;
			case "banner":
			
				jQuery('#londres_header_text_alignment_shop').closest('.option').prev().addBack()
					.add(jQuery('#londres_hide_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_breadcrumbs_shop').closest('.option').prev().addBack())
					.add(jQuery('#londres_pagetitle_image_parallax_shop').closest('.option'))
				.fadeIn(500);
				
				jQuery('#londres_banner_slider_shop').closest('.option').fadeIn(500);
				
				jQuery('#upload-londres_header_image_shop').closest('.option')
					.add(jQuery('#londres_header_color_shop').closest('.option')).add(jQuery('#londres_header_opacity_shop').closest('.option'))
					.add(jQuery('#londres_header_pattern_shop').closest('.option'))
					.add(jQuery('#upload-londres_header_custom_pattern_shop').closest('.option'))
				.fadeOut(500);
				
							jQuery('#londres_pagetitle_image_parallax_shop').closest('.option').nextUntil(jQuery('#londres_pagetitle_overlay_opacity_shop').closest('.option').next()).fadeOut();
				
			break;
		}
		if (_default_header_bkg_shop == "border" || _default_header_bkg_shop == "image" || _default_header_bkg_shop == "pattern" || _default_header_bkg_shop == "custom_pattern" || _default_header_bkg_shop == "banner" || _default_header_bkg_shop == "color"){
			jQuery('#londres_header_height_shop').closest('.option').fadeIn(500);
			jQuery('#londres_header_text_alignment_shop').closest('.option').fadeIn(500);
			jQuery('#londres_hide_pagetitle_shop').add(jQuery('#londres_hide_sec_pagetitle_shop')).add(jQuery('#londres_breadcrumbs_shop')).trigger('change');
		}
	}).trigger('change');
	
	
	var _default_seo_options = jQuery('#londres_enable_theme_seo').val();
	if (_default_seo_options === "on"){
		jQuery('#londres_enable_theme_seo').closest('.option').siblings().not(jQuery('#londres_enable_theme_seo').closest('.option').prev()).fadeIn(500);
	} else {
		jQuery('#londres_enable_theme_seo').closest('.option').siblings().not(jQuery('#londres_enable_theme_seo').closest('.option').prev()).fadeOut(500);
	}
	jQuery('#londres_enable_theme_seo').on("change", function(e){
		if (_default_seo_options === "on"){
			jQuery('#londres_enable_theme_seo').closest('.option').siblings().not(jQuery('#londres_enable_theme_seo').closest('.option').prev()).fadeIn(500);
		} else {
			jQuery('#londres_enable_theme_seo').closest('.option').siblings().not(jQuery('#londres_enable_theme_seo').closest('.option').prev()).fadeOut(500);
		}
	});
	
	//google fonts
	var _default_google_fonts = jQuery('#londres_enable_google_fonts').val();
	if (_default_google_fonts === "on"){
		jQuery('#londres_enable_google_fonts').closest('.option').next().fadeIn(500);
	} else {
		jQuery('#londres_enable_google_fonts').closest('.option').next().fadeOut(500);
	}
	jQuery('#londres_enable_google_fonts').on("change", function(){
		if (_default_google_fonts === "on"){
			jQuery('#londres_enable_google_fonts').closest('.option').next().fadeIn(500);
		} else {
			jQuery('#londres_enable_google_fonts').closest('.option').next().fadeOut(500);
		}		
	});
	
	//General > Projects > Enlarge pics
	var _default_proj_layout = jQuery('#londres_single_layout').val(); 
	if (_default_proj_layout === "fullwidth_slider"){
		jQuery('#londres_projects_enlarge_images').parent('.option').fadeOut(500);
	} else {
		jQuery('#londres_projects_enlarge_images').parent('.option').fadeIn(500);
	}
	jQuery('#londres_single_layout').on("change", function(e){
		if (_default_proj_layout === "fullwidth_slider"){
			jQuery('#londres_projects_enlarge_images').parent('.option').fadeOut(500);
		} else {
			jQuery('#londres_projects_enlarge_images').parent('.option').fadeIn(500);
		}
	});
	
	
	// social shares on projects
	var _default_project_single_social = jQuery('#londres_project_single_social_shares').val();
	if (_default_project_single_social == "on") jQuery('#londres_project_single_socials').closest('.option').fadeIn(500);
	else jQuery('#londres_project_single_socials').closest('.option').fadeOut(500);
	jQuery('#londres_project_single_social_shares').on("change", function(){
		if (jQuery(this).val() == "on")
			jQuery('#londres_project_single_socials').closest('.option').fadeIn(500);
		else jQuery('#londres_project_single_socials').closest('.option').fadeOut(500);
	});
	
	// social shares on posts
	var _default_post_single_social = jQuery('#londres_post_single_social_shares').val();
	if (_default_post_single_social == "on") jQuery('#londres_post_single_socials').closest('.option').fadeIn(500);
	else jQuery('#londres_post_single_socials').closest('.option').fadeOut(500);
	jQuery('#londres_post_single_social_shares').on("change", function(){
		if (jQuery(this).val() == "on")
			jQuery('#londres_post_single_socials').closest('.option').fadeIn(500);
		else jQuery('#londres_post_single_socials').closest('.option').fadeOut(500);
	});
	
	//General > Projects > Open|Close Cats
	var _default_enable_open_close_categories = jQuery('#londres_enable_open_close_categories').val();
	if (_default_enable_open_close_categories === "on"){
		jQuery('#londres_categories_initial_state').closest('.option').fadeIn(500).removeClass('optoff');
	} else {
		jQuery('#londres_categories_initial_state').closest('.option').fadeOut(500).addClass('optoff');
	}
	jQuery('#londres_enable_open_close_categories').on("change", function(e){
		var _default_enable_open_close_categories = jQuery('#londres_enable_open_close_categories').val();
		if (_default_enable_open_close_categories === "on"){
			jQuery('#londres_categories_initial_state').closest('.option').fadeIn(500).removeClass('optoff');
		} else {
			jQuery('#londres_categories_initial_state').closest('.option').fadeOut(500).addClass('optoff');
		}	
	});
	
	//FOOTER RIGHT CONTENT OPTIONS
	var _default_footer_right = jQuery('#londres_footer_right_content').val();
	if (_default_footer_right === "text"){
		jQuery('#londres_footer_right_text').parent('.option').fadeIn(500);
	} else {
		jQuery('#londres_footer_right_text').parent('.option').fadeOut(500);
	}
	jQuery('#londres_footer_right_content').on("change", function(e){
		if (_default_footer_right === "text"){
			jQuery('#londres_footer_right_text').parent('.option').fadeIn(500);
		} else {
			jQuery('#londres_footer_right_text').parent('.option').fadeOut(500);
		}	
	});
	
	var tp_cols_default = jQuery('#londres_toppanel_number_cols').val();	  
 	if(tp_cols_default == "three"){
 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeIn(500);
 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeOut(500);
 	} else if (tp_cols_default == "four"){
 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeIn(500);
 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeOut(500);
 	} else {
 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeOut(500);
 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeOut(500);
 	}
 	
	jQuery('#londres_toppanel_number_cols').on("change", function(e){
		if(tp_cols_default == "three"){
	 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeIn(500);
	 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeOut(500);
	 	} else if (tp_cols_default == "four"){
	 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeIn(500);
	 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeOut(500);
	 	} else {
	 		jQuery("#londres_toppanel_columns_order").closest('.option').fadeOut(500);
	 		jQuery("#londres_toppanel_columns_order_four").closest('.option').fadeOut(500);
	 	}
 	});
 	
 	//WIDGETS AREA
	var _default_widgets_area = jQuery('#londres_enable_widgets_area').val();
	var indexWidget = parseInt(jQuery('#londres_enable_widgets_area').parents('.option').index(),10);
	if (_default_widgets_area === "on"){
		for (var i=1; i<4; i++){
			jQuery('#londres_enable_widgets_area').parents('.sub-navigation-container').find('.option:eq('+(indexWidget+i)+')').fadeIn(500);	
		}
		jQuery('#londres_toppanel_number_cols').trigger("change");
	} else {
		for (var i=1; i<4; i++){
			jQuery('#londres_enable_widgets_area').parents('.sub-navigation-container').find('.option:eq('+(indexWidget+i)+')').fadeOut(500);	
		}
	}
	jQuery('#londres_enable_widgets_area').on("change", function(e){
		if (_default_widgets_area === "on"){
			for (var i=1; i<4; i++){
				jQuery('#londres_enable_widgets_area').parents('.sub-navigation-container').find('.option:eq('+(indexWidget+i)+')').fadeIn(500);	
			}
			jQuery('#londres_toppanel_number_cols').trigger("change");
		} else {
			for (var i=1; i<4; i++){
				jQuery('#londres_enable_widgets_area').parents('.sub-navigation-container').find('.option:eq('+(indexWidget+i)+')').fadeOut(500);	
			}
		}
	});
	
	//breadcrumbs
	var _default_breadcrumbs = jQuery('#londres_breadcrumbs').val();
	if (_default_breadcrumbs === "on"){
		jQuery('#londres_breadcrumbs').closest('.option').nextAll().fadeIn(500);
	} else {
		jQuery('#londres_breadcrumbs').closest('.option').nextAll().fadeOut(500);
	}
	jQuery('#londres_breadcrumbs').on("change", function(e){
		if (_default_breadcrumbs === "on"){
			jQuery('#londres_breadcrumbs').closest('.option').nextAll().fadeIn(500);
		} else {
			jQuery('#londres_breadcrumbs').closest('.option').nextAll().fadeOut(500);
		}
	});
	
	//pagetitle
	var _default_hide_pagetitle = jQuery('#londres_hide_pagetitle').val();
	if (_default_hide_pagetitle === "on"){
		jQuery('#londres_hide_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle').closest('.option').next().next().next().next().next()).fadeIn(500);
	} else {
		jQuery('#londres_hide_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle').closest('.option').next().next().next().next().next()).fadeOut(500);
	}
	jQuery('#londres_hide_pagetitle').on("change", function(e){
		if (_default_hide_pagetitle === "on"){
			jQuery('#londres_hide_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle').closest('.option').next().next().next().next().next()).fadeIn(500);
		} else {
			jQuery('#londres_hide_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle').closest('.option').next().next().next().next().next()).fadeOut(500);
		}		
	});
	
	//secondary title 
	var _default_hide_sec_pagetitle = jQuery('#londres_hide_sec_pagetitle').val();
	if (_default_hide_sec_pagetitle === "on"){
		jQuery('#londres_hide_sec_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle').closest('.option').next().next().next().next().next()).fadeIn(500);
	} else {
		jQuery('#londres_hide_sec_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle').closest('.option').next().next().next().next().next()).fadeOut(500);
	}
	jQuery('#londres_hide_sec_pagetitle').on("change", function(e){
		if (_default_hide_sec_pagetitle === "on"){
			jQuery('#londres_hide_sec_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle').closest('.option').next().next().next().next().next()).fadeIn(500);
		} else {
			jQuery('#londres_hide_sec_pagetitle').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle').closest('.option').next().next().next().next().next()).fadeOut(500);
		}		
	});
	
	
	
	//breadcrumbs
	var _default_breadcrumbs_shop = jQuery('#londres_breadcrumbs_shop').val();
	if (_default_breadcrumbs_shop === "on"){
		jQuery('#londres_breadcrumbs_shop').closest('.option').nextAll().fadeIn(500);
	} else {
		jQuery('#londres_breadcrumbs_shop').closest('.option').nextAll().fadeOut(500);
	}
	jQuery('#londres_breadcrumbs_shop').on("change", function(e){
		if (_default_breadcrumbs_shop === "on"){
			jQuery('#londres_breadcrumbs_shop').closest('.option').nextAll().fadeIn(500);
		} else {
			jQuery('#londres_breadcrumbs_shop').closest('.option').nextAll().fadeOut(500);
		}
	});
	
	//pagetitle
	var _default_hide_pagetitle_shop = jQuery('#londres_hide_pagetitle_shop').val();
	if (_default_hide_pagetitle_shop === "on"){
		jQuery('#londres_hide_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeIn(500);
	} else {
		jQuery('#londres_hide_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeOut(500);
	}
	jQuery('#londres_hide_pagetitle_shop').on("change", function(e){
		if (_default_hide_pagetitle_shop === "on"){
			jQuery('#londres_hide_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeIn(500);
		} else {
			jQuery('#londres_hide_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeOut(500);
		}		
	});
	
	//secondary title 
	var _default_hide_sec_pagetitle_shop = jQuery('#londres_hide_sec_pagetitle_shop').val();
	if (_default_hide_sec_pagetitle_shop === "on"){
		jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeIn(500);
	} else {
		jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeOut(500);
	}
	jQuery('#londres_hide_sec_pagetitle_shop').on("change", function(e){
		if (_default_hide_sec_pagetitle_shop === "on"){
			jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeIn(500);
		} else {
			jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').nextUntil(jQuery('#londres_hide_sec_pagetitle_shop').closest('.option').next().next().next().next().next()).fadeOut(500);
		}		
	});
	
	
	
	//pagetitle shadow
	var _default_page_title_shadow = jQuery('#londres_page_title_shadow').val();
	if (_default_page_title_shadow === "on"){
		jQuery('#londres_page_title_shadow').closest('.option').next().fadeIn(500);
	} else {
		jQuery('#londres_page_title_shadow').closest('.option').next().fadeOut(500);
	}
	jQuery('#londres_page_title_shadow').on("change", function(e){
		if (_default_page_title_shadow === "on"){
			jQuery('#londres_page_title_shadow').closest('.option').next().fadeIn(500);
		} else {
			jQuery('#londres_page_title_shadow').closest('.option').next().fadeOut(500);
		}
	});
	
  	//SOCIAL ICONS 
  	var _default_enable_socials = jQuery('#londres_enable_socials').val();
  	if (_default_enable_socials === "on"){
		jQuery('#londres_enable_socials').parents('.option').find('~ .option').each(function(){
			jQuery(this).fadeIn(500);
		});
  	} else {
	  	jQuery('#londres_enable_socials').parents('.option').find('~ .option').each(function(){
			jQuery(this).fadeOut(500);
		});
  	}
	jQuery('#londres_enable_socials').on("change", function(e){
		var _default_enable_socials = jQuery('#londres_enable_socials').val();
	  	if (_default_enable_socials === "on"){
			jQuery('#londres_enable_socials').parents('.option').find('~ .option').each(function(){
				jQuery(this).fadeIn(500);
			});
	  	} else {
		  	jQuery('#londres_enable_socials').parents('.option').find('~ .option').each(function(){
				jQuery(this).fadeOut(500);
			});
	  	}
	});

	// TOP PANEL & SOCIAL BAR MAMBO JAMBO
	var _default_top_panel = jQuery('#londres_enable_top_panel').val();
	if (_default_top_panel === "on"){
		for (var i=jQuery('#londres_enable_top_panel').closest('.option').index()+1; i< jQuery('#londres_toppanel_headingscolor').closest('.option').index()+1; i++){
			if (!jQuery('#tab_navigation-1-header').children().eq(i).hasClass('optoff')) jQuery('#tab_navigation-2-header').children().eq(i).fadeIn(500);
		}
	} else {
		for (var i=jQuery('#londres_enable_top_panel').closest('.option').index()+1; i< jQuery('#londres_toppanel_headingscolor').closest('.option').index()+1; i++){
			jQuery('#tab_navigation-1-header').children().eq(i).fadeOut(500);
		}
  	}
	jQuery('#londres_enable_top_panel').on("change", function(e){
	  	if (_default_top_panel === "on"){
			for (var i=jQuery('#londres_enable_top_panel').closest('.option').index()+1; i< jQuery('#londres_toppanel_headingscolor').closest('.option').index()+1; i++){
				if (!jQuery('#tab_navigation-1-header').children().eq(i).hasClass('optoff')) jQuery('#tab_navigation-1-header').children().eq(i).fadeIn(500);
			}
		} else {
			for (var i=jQuery('#londres_enable_top_panel').closest('.option').index()+1; i< jQuery('#londres_toppanel_headingscolor').closest('.option').index()+1; i++){
				jQuery('#tab_navigation-1-header').children().eq(i).fadeOut(500);
			}
	  	}
	});
	
	
	//suggested colors
	jQuery('#tab_navigation-1-general a.style-box').each(function(){
		jQuery(this).on("click",function(){
			jQuery('#londres_style_color')
				.attr('value',jQuery(this).attr('title'))
				.siblings('.color-preview').css('background-color', '#'+jQuery(this).attr('title'));
		});
	});
	
	jQuery('.styles-holder a.style-box[title='+jQuery('#londres_style_color').val()+']').closest('.option').addClass('selected-style');
	
  	// 404
	var def_notfound = jQuery('#londres_404_error_image').val();
	if (def_notfound == "off")	
		jQuery('#londres_404_error_image_url').closest('.option').fadeOut(500);
	else
		jQuery('#londres_404_error_image_url').closest('.option').fadeIn(500);

	jQuery('#londres_404_error_image').on("change", function(e){
		if (def_notfound == "off")	
			jQuery('#londres_404_error_image_url').closest('.option').fadeOut(500);
		else
			jQuery('#londres_404_error_image_url').closest('.option').fadeIn(500);
 	});
 	
 	//HOMEPAGE LAYOUT
 	jQuery("#londres_homepage_static_image_url").closest('.option').fadeOut(500);
 	
 	jQuery('#londres_homepage_slider').on("change", function(e){
 		if(jQuery(this).val() == 'static')
 			jQuery("#londres_homepage_static_image_url").closest('.option').fadeIn(500);
 		else
 			jQuery("#londres_homepage_static_image_url").closest('.option').fadeOut(500);
 			
 	});
 	 	
 	//CONTACT FORM TEXTAREA
 	jQuery("textarea[name=walker_contacts_email_default_content]").css("width", "440px").css("height", "270px");
 	
 	
 	//FOOTER
 	var cols_default  = jQuery('#londres_footer_number_cols').val();
	switch(cols_default){
		case "one": case "two":
	 		jQuery("#londres_footer_columns_order").closest('.option').fadeOut(500);
	 		jQuery("#londres_footer_columns_order_four").closest('.option').fadeOut(500);				
		break;
		case "three":
			jQuery("#londres_footer_columns_order").closest('.option').fadeIn(500);
			jQuery("#londres_footer_columns_order_four").closest('.option').fadeOut(500);
		break;
		case "four":
			jQuery("#londres_footer_columns_order_four").closest('.option').fadeIn(500);
			jQuery("#londres_footer_columns_order").closest('.option').fadeOut(500);	
		break;
	}
	 	
	jQuery('#londres_footer_number_cols').on("change", function(e){
		switch(cols_default){
			case "one": case "two":
		 		jQuery("#londres_footer_columns_order").closest('.option').fadeOut(500);
		 		jQuery("#londres_footer_columns_order_four").closest('.option').fadeOut(500);				
			break;
			case "three":
				jQuery("#londres_footer_columns_order").closest('.option').fadeIn(500);
				jQuery("#londres_footer_columns_order_four").closest('.option').fadeOut(500);
			break;
			case "four":
				jQuery("#londres_footer_columns_order_four").closest('.option').fadeIn(500);
				jQuery("#londres_footer_columns_order").closest('.option').fadeOut(500);	
			break;
		}
 	});
  

	//show twitter newsletter footer options
	var _default_show_twitter_newsletter_footer = jQuery('#londres_show_twitter_newsletter_footer').val();
	if (_default_show_twitter_newsletter_footer === "on"){
		for (var i= jQuery('#londres_show_twitter_newsletter_footer').closest('.option').index(); i<jQuery('#londres_twitter_newsletter_borderscolor').closest('.option').index(); i++){
			if (!jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).hasClass('optoff')) jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).fadeIn(500);
		}
	} else {
		for (var i= jQuery('#londres_show_twitter_newsletter_footer').closest('.option').index(); i<jQuery('#londres_twitter_newsletter_borderscolor').closest('.option').index(); i++){
			jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).fadeOut(500);
		}
	}
	jQuery('#londres_show_twitter_newsletter_footer').on("change", function(){
		if (_default_show_twitter_newsletter_footer === "on"){
			for (var i= jQuery('#londres_show_twitter_newsletter_footer').closest('.option').index(); i<jQuery('#londres_twitter_newsletter_borderscolor').closest('.option').index(); i++){
				if (!jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).hasClass('optoff')) jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).fadeIn(500);
			}
		} else {
			for (var i= jQuery('#londres_show_twitter_newsletter_footer').closest('.option').index(); i<jQuery('#londres_twitter_newsletter_borderscolor').closest('.option').index(); i++){
				jQuery('#londres_show_twitter_newsletter_footer').closest('.sub-navigation-container').find('.option').eq(i).fadeOut(500);
			}
		}
	});
	
	
  var _default_after_scroll_header = jQuery('#londres_header_after_scroll').val();
  if (_default_after_scroll_header == 'on'){
	  jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack()
	  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
	  .fadeIn(500);
  } else {
	  jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack()
	  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
	  .fadeOut(500);
  }
  jQuery('#londres_header_after_scroll').on("change", function(){
	  if (_default_after_scroll_header == 'on'){
		  jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack()
		  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
		  .fadeIn(500);
	  } else {
		  jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack()
		  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
		  .fadeOut(500);
	  }
  });
  
  
  var _default_fixed_menu = jQuery('#londres_fixed_menu').val();
  if (_default_fixed_menu == 'on'){
	  jQuery('#londres_header_after_scroll').trigger('change').closest('.option').prev().addBack()
  	  	.add(jQuery('#londres_header_hide_on_start').closest('.option'))
	  	.add(jQuery('#londres_content_to_the_top').closest('.option'))
	  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
	  .fadeIn(500);
  } else {
	  jQuery('#londres_header_after_scroll').closest('.option').prev().addBack()
	  	.add(jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack())
	  	.add(jQuery('#londres_header_hide_on_start').closest('.option'))
	  	.add(jQuery('#londres_content_to_the_top').closest('.option'))
	  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
	  .fadeOut(500);  
  }
  jQuery('#londres_fixed_menu').on("change", function(){
	  if (_default_fixed_menu == 'on'){
		  jQuery('#londres_header_after_scroll').trigger('change').closest('.option').prev().addBack()
		  	.add(jQuery('#londres_header_hide_on_start').closest('.option'))
		  	.add(jQuery('#londres_content_to_the_top').closest('.option'))
		  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
		  .fadeIn(500);
	  } else {
		  jQuery('#londres_header_after_scroll').closest('.option').prev().addBack()
		  	.add(jQuery('#londres_header_shrink_effect').closest('.option').prev().addBack())
		  	.add(jQuery('#londres_header_hide_on_start').closest('.option'))
		  	.add(jQuery('#londres_content_to_the_top').closest('.option'))
		  	.add(jQuery('#londres_header_after_scroll_style_light_dark').closest('.option'))
		  .fadeOut(500);  
	  }	  
  });
  
  //show primary footer options
	var _default_show_primary_footer = jQuery('#londres_show_primary_footer').val();
	jQuery('#londres_show_primary_footer').on("change", function(){
		if (_default_show_primary_footer === "on"){
			jQuery('#londres_show_primary_footer').closest('.option').nextUntil(jQuery('#londres_footerbg_headingscolor').closest('.option').next()).fadeIn(500);
			jQuery('#londres_footerbg_type').trigger('change');
		} else {
			jQuery('#londres_show_primary_footer').closest('.option').nextUntil(jQuery('#londres_footerbg_headingscolor').closest('.option').next()).fadeOut(500);
		}
	}).trigger('change');
	
	//show secondary footer options
	var _default_show_secondary_footer = jQuery('#londres_show_sec_footer').val();
	jQuery('#londres_show_sec_footer').on("change", function(){
		if (_default_show_secondary_footer === "on"){
			jQuery('#londres_show_sec_footer').closest('.option').nextAll().fadeIn(500);
			jQuery('#londres_sec_footerbg_type').trigger('change');
		} else {
			jQuery('#londres_show_sec_footer').closest('.option').nextAll().fadeOut(500);
		}
	}).trigger('change');
	
	/* display metas */
	var _default_display_metas = jQuery('#londres_display_metas').val();
	jQuery('#londres_display_metas').on("change", function(){
		if (_default_display_metas === "on"){
			jQuery('#londres_metas_to_display').parent().fadeIn(500);
		} else {
			jQuery('#londres_metas_to_display').parent().fadeOut(500);			
		}
	}).trigger('change');
  
  // continuous check for changed value
  setInterval(function () {
	  
	  //custom css
	  if (jQuery('#enable_custom_css').val() != _default_custom_css){
		  _default_custom_css = jQuery('#enable_custom_css').val();
		  jQuery('#enable_custom_css').trigger("change");
	  }
	  
	if (jQuery('#londres_menu_add_border').val() != _default_menu_add_border){
		_default_menu_add_border = jQuery('#londres_menu_add_border').val();
		jQuery('#londres_menu_add_border').trigger("change");
	}

  	if (jQuery('#londres_footer_display_logo').val() != _default_footer_display_logo){
		_default_footer_display_logo = jQuery('#londres_footer_display_logo').val();
		jQuery('#londres_footer_display_logo').trigger("change");
	}
	
	if (jQuery('#londres_footer_display_social_icons').val() != _default_footer_display_social_icons){
		_default_footer_display_social_icons = jQuery('#londres_footer_display_social_icons').val();
		jQuery('#londres_footer_display_social_icons').trigger("change");
	}
	if (jQuery('#londres_footer_display_custom_text').val() != _default_footer_display_custom_text){
		_default_footer_display_custom_text = jQuery('#londres_footer_display_custom_text').val();
		jQuery('#londres_footer_display_custom_text').trigger("change");
	}
	  
	if (jQuery('#londres_enable_theme_seo').val() != _default_seo_options){
		_default_seo_options = jQuery('#londres_enable_theme_seo').val();
		jQuery('#londres_enable_theme_seo').trigger("change");
	}
  
	// under construction
	if (jQuery('#londres_enable_under_construction').val() != _default_under_construction){
		_default_under_construction = jQuery('#londres_enable_under_construction').val();
		jQuery('#londres_enable_under_construction').trigger("change");
	}

	//fixed menu
	if (jQuery('#londres_fixed_menu').val() != _default_fixed_menu){
	  	_default_fixed_menu = jQuery('#londres_fixed_menu').val();
	  	jQuery('#londres_fixed_menu').trigger("change");
  	}
  	
  	//after scroll menu
  	if (jQuery('#londres_header_after_scroll').val() != _default_after_scroll_header){
	  	_default_after_scroll_header = jQuery('#londres_header_after_scroll').val();
	  	jQuery('#londres_header_after_scroll').trigger('change');
  	}


	//breadcrumbs
	if (jQuery('#londres_breadcrumbs').val() != _default_breadcrumbs){
		_default_breadcrumbs = jQuery('#londres_breadcrumbs').val();
		jQuery('#londres_breadcrumbs').trigger("change");
	}

	//display secondary page title
	if (jQuery('#londres_hide_sec_pagetitle').val() != _default_hide_sec_pagetitle){
		_default_hide_sec_pagetitle = jQuery('#londres_hide_sec_pagetitle').val();
		jQuery('#londres_hide_sec_pagetitle').trigger("change");
	}
	
	//display page title
	if (jQuery('#londres_hide_pagetitle').val() != _default_hide_pagetitle){
		_default_hide_pagetitle = jQuery('#londres_hide_pagetitle').val();
		jQuery('#londres_hide_pagetitle').trigger("change");
	}
	
	
	//breadcrumbs_shop
	if (jQuery('#londres_breadcrumbs_shop').val() != _default_breadcrumbs_shop){
		_default_breadcrumbs_shop = jQuery('#londres_breadcrumbs_shop').val();
		jQuery('#londres_breadcrumbs_shop').trigger("change");
	}

	//display secondary page title
	if (jQuery('#londres_hide_sec_pagetitle_shop').val() != _default_hide_sec_pagetitle_shop){
		_default_hide_sec_pagetitle_shop = jQuery('#londres_hide_sec_pagetitle_shop').val();
		jQuery('#londres_hide_sec_pagetitle_shop').trigger("change");
	}
	
	//display page title
	if (jQuery('#londres_hide_pagetitle_shop').val() != _default_hide_pagetitle_shop){
		_default_hide_pagetitle_shop = jQuery('#londres_hide_pagetitle_shop').val();
		jQuery('#londres_hide_pagetitle_shop').trigger("change");
	}

	//pagetitle shadow
	if (jQuery('#londres_page_title_shadow').val() != _default_page_title_shadow){
		_default_page_title_shadow = jQuery('#londres_page_title_shadow').val();
		jQuery('#londres_page_title_shadow').trigger("change");
	}

	//show secondary footer options
  	if (jQuery('#londres_show_sec_footer').val() != _default_show_secondary_footer){
	  	_default_show_secondary_footer = jQuery('#londres_show_sec_footer').val();
	  	jQuery('#londres_show_sec_footer').trigger("change");
  	}
	
	//show primary footer options
  	if (jQuery('#londres_show_primary_footer').val() != _default_show_primary_footer){
	  	_default_show_primary_footer = jQuery('#londres_show_primary_footer').val();
	  	jQuery('#londres_show_primary_footer').trigger("change");
  	}
  
  	//show twitter newsletter footer options
  	if (jQuery('#londres_show_twitter_newsletter_footer').val() != _default_show_twitter_newsletter_footer){
	  	_default_show_twitter_newsletter_footer = jQuery('#londres_show_twitter_newsletter_footer').val();
	  	jQuery('#londres_show_twitter_newsletter_footer').trigger("change");
  	}
  	
  	// header type light
  	if (jQuery('#londres_headerbg_type_light').val() != _default_headerbg_type_light){
	  	_default_headerbg_type_light = jQuery('#londres_headerbg_type_light').val();
	  	jQuery('#londres_headerbg_type_light').trigger("change");
  	}
  	
  	// header type dark
  	if (jQuery('#londres_headerbg_type_dark').val() != _default_headerbg_type_dark){
	  	_default_headerbg_type_dark = jQuery('#londres_headerbg_type_dark').val();
	  	jQuery('#londres_headerbg_type_dark').trigger("change");
  	}
  	
  	// header after scroll type light
  	if (jQuery('#londres_headerbg_after_scroll_type_light').val() != _default_headerbg_after_scroll_type_light){
	  	_default_headerbg_after_scroll_type_light = jQuery('#londres_headerbg_after_scroll_type_light').val();
	  	jQuery('#londres_headerbg_after_scroll_type_light').trigger("change");
  	}
  	
  	// header after scroll type dark
  	if (jQuery('#londres_headerbg_after_scroll_type_dark').val() != _default_headerbg_after_scroll_type_dark){
	  	_default_headerbg_after_scroll_type_dark = jQuery('#londres_headerbg_after_scroll_type_dark').val();
	  	jQuery('#londres_headerbg_after_scroll_type_dark').trigger("change");
  	}

  	// show header & top contents type
  	if (jQuery('#londres_toppanelbg_type').val() != _default_toppanelbg_type){
	  	_default_toppanelbg_type = jQuery('#londres_toppanelbg_type').val();
	  	jQuery('#londres_toppanelbg_type').trigger("change");
  	}
  	
  	// secondary footer type opts
  	if (jQuery('#londres_sec_footerbg_type').val() != _default_sec_footerbg_type){
	  	_default_sec_footerbg_type = jQuery('#londres_sec_footerbg_type').val();
	  	jQuery('#londres_sec_footerbg_type').trigger("change");
  	}
  	
  	// primary footer type opts
  	if (jQuery('#londres_footerbg_type').val() != _default_footerbg_type){
	  	_default_footerbg_type = jQuery('#londres_footerbg_type').val();
	  	jQuery('#londres_footerbg_type').trigger("change");
  	}
  	
  	// twitter newsletter type opts 
  	if (jQuery('#londres_twitter_newsletter_type').val() != _default_twitter_newsletter_type){
	  	_default_twitter_newsletter_type = jQuery('#londres_twitter_newsletter_type').val();
	  	jQuery('#londres_twitter_newsletter_type').trigger("change");
  	}
  	
  	// thumbails animate
  	if (jQuery('#londres_animate_thumbnails').val() != _default_animate_thumbnails){
	  	_default_animate_thumbnails = jQuery('#londres_animate_thumbnails').val();
	  	jQuery('#londres_animate_thumbnails').trigger("change");
  	}
  	
  	//body shadow
  	if (jQuery('#londres_body_shadow').val() != _default_body_shadow){
	  	_default_body_shadow = jQuery('#londres_body_shadow').val();
	  	jQuery('#londres_body_shadow').trigger("change");
  	}
  
  	//body background type
  	if (jQuery('#londres_body_type').val() != _default_body_background){
	  	_default_body_background = jQuery('#londres_body_type').val();
	  	jQuery('#londres_body_type').trigger("change");
  	}
  
  	//body layout page
  	if (jQuery('#londres_body_layout_type').val() != _default_body_layout_type){
	  	_default_body_layout_type = jQuery('#londres_body_layout_type').val();
	  	jQuery('#londres_body_layout_type').trigger("change");
  	}
  
  	//header background type
  	if (jQuery('#londres_header_type').val() != _default_header_bkg){
	  	_default_header_bkg = jQuery('#londres_header_type').val();
	  	jQuery('#londres_header_type').trigger("change");
  	}
  	
  	//header background type _shop
  	if (jQuery('#londres_header_type_shop').val() != _default_header_bkg_shop){
	  	_default_header_bkg_shop = jQuery('#londres_header_type_shop').val();
	  	jQuery('#londres_header_type_shop').trigger("change");
  	}
  
  	//google fonts
  	if (jQuery('#londres_enable_google_fonts').val() != _default_google_fonts){
	  	_default_google_fonts = jQuery('#londres_enable_google_fonts').val();
	  	jQuery('#londres_enable_google_fonts').trigger("change");
  	}
  
  	//projects enlarge pics
  	if (jQuery('#londres_single_layout').val() != _default_proj_layout){
	 	_default_proj_layout = jQuery('#londres_single_layout').val();
	 	jQuery('#londres_single_layout').trigger("change");
  	}
  	
  	//projects open|close
  	if (jQuery('#londres_enable_open_close_categories').val() != _default_enable_open_close_categories){
	 	_default_enable_open_close_categories = jQuery('#londres_enable_open_close_categories').val();
	 	jQuery('#londres_enable_open_close_categories').trigger("change");
  	}
  
  	//FOOTER RIGHT CONTENT
    if (jQuery('#londres_footer_right_content').val() != _default_footer_right){
	    _default_footer_right = jQuery('#londres_footer_right_content').val();
	    jQuery('#londres_footer_right_content').trigger("change");
    }
    
    //TOPPANEL
    if ( jQuery('#londres_enable_top_panel').val() != _default_top_panel ) {
    	_default_top_panel = jQuery('#londres_enable_top_panel').val();
		jQuery('#londres_enable_top_panel').trigger("change");    
    }
    
    //WIDGETS AREA
    if (jQuery('#londres_enable_widgets_area').val() != _default_widgets_area){
	    _default_widgets_area = jQuery('#londres_enable_widgets_area').val();
	    jQuery('#londres_enable_widgets_area').trigger("change");
    }
    
    //SOCIAL ICONS
    if (jQuery('#londres_enable_socials').val() != _default_enable_socials){
	    _default_enable_socials = jQuery('#londres_enable_socials').val();
	    jQuery('#londres_enable_socials').trigger("change");
    }
    
    //404
    if (jQuery('#londres_404_error_image').val() != def_notfound){
		def_notfound = jQuery('#londres_404_error_image').val();
		jQuery('#londres_404_error_image').trigger("change");
    }
    
    //SIDEBAR
    if (jQuery('#sidebar_name_list').html() != def_sidebars){
	    var sidebars = "";
	    jQuery('#sidebar_name_list li').each(function(){
		    sidebars += jQuery(this).children('span').html()+"|*|";
	    });
	    jQuery('input#londres_sidebar_name_names').val(sidebars);
	    def_sidebars = jQuery('#sidebar_name_list').html();
    }
    
    //FOOTER
    if ( jQuery('#londres_footer_number_cols').val() != cols_default ) {
    	cols_default  = jQuery('#londres_footer_number_cols').val();
		jQuery('#londres_footer_number_cols').trigger("change");    
    }
    
    //TOP PANEL
    if ( jQuery('#londres_toppanel_number_cols').val() != tp_cols_default ) {
    	tp_cols_default  = jQuery('#londres_toppanel_number_cols').val();
		jQuery('#londres_toppanel_number_cols').trigger("change");  
    }
    
    if (jQuery('#londres_enable_ajax_search').val() != _default_ajax_search){
	    _default_ajax_search = jQuery('#londres_enable_ajax_search').val();
	    jQuery('#londres_enable_ajax_search').trigger("change");
    }
    
    if (jQuery('#londres_enable_search').val() != _default_search){
	 	_default_search = jQuery('#londres_enable_search').val();
	 	jQuery('#londres_enable_search').trigger("change");
    }
    
    if (jQuery('#londres_enable_website_loader').val() != _default_website_loader){
	    _default_website_loader = jQuery('#londres_enable_website_loader').val();
	    jQuery('#londres_enable_website_loader').trigger("change");
    }
    
    if (jQuery('#londres_pagetitle_image_overlay').val() != _default_overlay_enable){
	    _default_overlay_enable = jQuery('#londres_pagetitle_image_overlay').val();
	    jQuery('#londres_pagetitle_image_overlay').trigger("change");
    }
    
    if (jQuery('#londres_pagetitle_image_overlay_shop').val() != _default_overlay_enable_shop){
	    _default_overlay_enable_shop = jQuery('#londres_pagetitle_image_overlay_shop').val();
	    jQuery('#londres_pagetitle_image_overlay_shop').trigger("change");
    }
        
    if (jQuery('#londres_pagetitle_overlay_type').val() != _default_overlay_type){
	    _default_overlay_type = jQuery('#londres_pagetitle_overlay_type').val();
	    jQuery('#londres_pagetitle_overlay_type').trigger("change");
    }
    
    if (jQuery('#londres_pagetitle_overlay_type_shop').val() != _default_overlay_type_shop){
	    _default_overlay_type_shop = jQuery('#londres_pagetitle_overlay_type_shop').val();
	    jQuery('#londres_pagetitle_overlay_type_shop').trigger("change");
    }
    
    //project single socials
	if (jQuery('#londres_project_single_social_shares').val() != _default_project_single_social){
		_default_project_single_social = jQuery('#londres_project_single_social_shares').val();
		jQuery('#londres_project_single_social_shares').trigger("change");
	}
	
	//post single socials
	if (jQuery('#londres_post_single_social_shares').val() != _default_post_single_social){
		_default_post_single_social = jQuery('#londres_post_single_social_shares').val();
		jQuery('#londres_post_single_social_shares').trigger("change");
	}
	
	//metas
	if (jQuery('#londres_display_metas').val() != _default_display_metas){
		_default_display_metas = jQuery('#londres_display_metas').val();
		jQuery('#londres_display_metas').trigger("change");
	}
    
  }, 1000);

});
