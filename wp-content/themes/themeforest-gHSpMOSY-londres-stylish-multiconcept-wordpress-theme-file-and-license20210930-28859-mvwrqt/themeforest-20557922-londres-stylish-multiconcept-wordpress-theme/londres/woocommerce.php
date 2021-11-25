<?php
	get_header(); londres_print_menu();
	$londres_thisPostID = get_the_ID(); 
	$woocommerce = londres_get_the_woo();
	$londres_color_code = get_option("londres_style_color");
	
	$type = get_option("londres_header_type_shop");
	$thecolor = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_color_shop"))); 
	$opacity = intval(str_replace("%","",get_option("londres_header_opacity_shop")))/100;
	$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
	$image = get_option("londres_header_image_shop"); 
	$pattern = is_array(get_option("londres_header_pattern_shop")) ? "":LONDRES_PATTERNS_URL.get_option("londres_header_pattern_shop"); 
	$custompattern = get_option("londres_header_custom_pattern_shop"); 
	$margintop = get_option("londres_header_text_margin_top_shop");	
	$banner = get_option("londres_banner_slider_shop");
	$showtitle = get_option("londres_hide_pagetitle_shop") == "on" ? true : false;
	$showsectitle = get_option("londres_hide_sec_pagetitle_shop") == "on" ? true : false;
	$tcolor = str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_text_color_shop"));
	$tsize = intval(str_replace(" ", "", get_option("londres_header_text_size_shop")),10)."px";
	$tfont = get_option("londres_header_text_font_shop");
	$stcolor = str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_secondary_title_text_color_shop"));
	$stsize = intval(str_replace(" ", "", get_option("londres_secondary_title_text_size_shop")),10)."px";
	$stfont = get_option("londres_secondary_title_font_shop");
	$stmargin = intval(str_replace(" ", "", get_option("londres_header_sec_text_margin_top_shop")),10)."px";
	$originalalign = get_option("londres_header_text_alignment_shop");
	$pt_parallax = get_option("londres_pagetitle_image_parallax_shop") == "on" ? true : false;
	$pt_overlay = get_option("londres_pagetitle_image_overlay_shop") == "on" ? true : false;
	$pt_overlay_type = get_option("londres_pagetitle_overlay_type_shop");
	$pt_overlay_the_color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_pagetitle_overlay_color_shop")));
	$pt_overlay_pattern = (is_string(get_option("londres_pagetitle_overlay_pattern_shop"))) ? LONDRES_PATTERNS_URL.get_option("londres_pagetitle_overlay_pattern_shop") : "";
	$pt_overlay_opacity = intval(str_replace("%","",get_option("londres_pagetitle_overlay_opacity_shop")))/100;
	$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
	$breadcrumbs = get_option("londres_breadcrumbs_shop");
	$breadcrumbs_margintop = get_option('londres_breadcrumbs_text_margin_top_shop');
	$pagetitlepadding = get_option('londres_page_title_padding_shop');
	$height = "auto";

	$textalign = $originalalign;
	if ($originalalign == "titlesleftcrumbsright") $textalign = "left";
	if ($originalalign == "titlesrightcrumbsleft") $textalign = "right";
	
	$londres_import_fonts[] = $tfont;
	$principalfont = explode("|",$tfont);
	$principalfont[0] = $principalfont[0]."', 'Arial', 'sans-serif";
	if (!isset($principalfont[1])) $principalfont[1] = "";
		
	$londres_import_fonts[] = $stfont;
	$secondaryfont = explode("|",$stfont);
	$secondaryfont[0] = $secondaryfont[0]."', 'Arial', 'sans-serif";
	if (!isset($secondaryfont[1])) $secondaryfont[1] = "";
		
	if ($type != "without"){
		
		$ptitleaux = $bcaux = "";
		if ($originalalign == "titlesleftcrumbsright" || $originalalign == "titlesrightcrumbsleft"){
    		$ptitleaux .= "max-width: 50%;";
    		$bcaux .= "max-width: 50%;";
    		if ($originalalign == "titlesleftcrumbsright"){
				$ptitleaux .= "float:left;";
				$bcaux .= "float:right;";
			} else {
				$ptitleaux .= "float:right;";
				$bcaux .= "float:left;";
			}
		}
		$bcaux .= "margin-top:".intval($breadcrumbs_margintop,10)."px;";
		switch($originalalign){
			case "left": case "titlesrightcrumbsleft":
				$bcaux .= "text-align: left;";
			break;
			case "right": case "titlesleftcrumbsright":
				$bcaux .= "text-align:right;";
			break;
			case "center": 
				$bcaux .= "text-align:center;";
			break;
		}
		?>
		<div class="fullwidth-container <?php if ($type == "pattern") echo "bg-pattern"; ?> <?php if ($pt_parallax) echo "parallax"; ?><?php if (($type == "image" || $type == "pattern") && get_option('londres_enable_grayscale') == 'on') echo " londres_grayscale "; ?>" <?php if ($pt_parallax) echo 'data-stellar-ratio="0.5"'; ?> 
	    	<?php
		    	$londres_output = ".fullwidth-container{";
		 		if ($height != "") $londres_output.= "height: ". $height . ";";
				if ($type == "none") $londres_output.= "background: none;"; 
				if ($type == "color") $londres_output.= "background: " . $color . ";";
				if ($type == "image") $londres_output.= "background: url(" . $image . ") no-repeat; background-size: 100% auto;";  
	 			if ($type == "pattern") $londres_output.= "background: url('" . $pattern . "') 0 0 repeat;";
				$londres_output .= "}";
				londres_set_custom_inline_css($londres_output);
		
	    	?> <?php if ($type == "image" && !$pt_parallax) echo ' data-background-alignment="center" '; ?>>
	    	<?php
		    	if ($type == "image" && $pt_overlay){
			    	$londres_output = ".pagetitle_overlay{";
			    	echo '<div class="pagetitle_overlay"></div> '; 
			    	if ($pt_overlay_type == "color") $londres_output.= 'background-color:'.$pt_overlay_color.' !important';
			    	else $londres_output.= 'background:url('.$pt_overlay_pattern.') repeat;opacity:'.$pt_overlay_opacity.' !important;';
			    	$londres_output .= "}";
					londres_set_custom_inline_css($londres_output);
		    	}
		    	if ($type === "banner"){
			    	?> 
			    	<div class="revBanner">
				    	<?php
					    	if (substr($banner, 0, 10) === "revSlider_"){
								if (!function_exists('putRevSlider')){
									echo esc_html__('Please install the missing plugin - Revolution Slider.', 'londres');
								} else {
									putRevSlider(substr($banner, 10));
								}
							} 
							if (substr($banner, 0, 13) === "masterSlider_"){
								if (!function_exists('masterslider')){
									echo esc_html__('Please install the missing plugin - MasterSlider.', 'londres');
								} else {
									echo do_shortcode( '[masterslider alias="'.substr($banner, 13).'"]' );
								}
							}
				    	?>
				    </div> 
				    <?php
		    	} else {
		    	?>
				<div class="container present-container <?php echo esc_attr($originalalign); ?>">
					<?php
						$londres_output = ".present-container{padding: ".esc_attr($pagetitlepadding)." 15px;}";
						londres_set_custom_inline_css($londres_output);
					?>
					<div class="pageTitle">
					<?php
						$londres_output = ".present-container .pageTitle{text-align: ".esc_attr($textalign).";".esc_attr($ptitleaux)."}";
						londres_set_custom_inline_css($londres_output);
						if ($showtitle){
							?>
							<h1 class="page_title">
								<?php
									if ( is_product() || is_product_category() || is_product_tag() || is_shop() ){
						    		   echo esc_html(get_option("londres_shop_primary_title"));
					    		   	} else {
						    		   woocommerce_page_title();
					    		   	}
								?>
							</h1>
							<?php
							$londres_output = ".present-container h1.page_title{color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";
							if ($margintop != "") $londres_output .= esc_attr("margin-top: ".intval($margintop,10)."px;");
							$londres_output .= "}";
							londres_set_custom_inline_css($londres_output);
						}
						if ($showsectitle && get_option("londres_shop_secondary_title")!=""){
					    	?>
						    <h2 class="secondaryTitle">
							    <?php
									echo esc_html(get_option("londres_shop_secondary_title"));
								?>
						    </h2>
				    		<?php
				    		$londres_output = ".present-container .secondaryTitle{color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}';font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};}";
							londres_set_custom_inline_css($londres_output);
		    			}
		    		?>
		    		</div>
		    		<?php
		    		if ($breadcrumbs == "on"){
			    		?>
			    		<div class="londres_breadcrumbs">
							<?php 
								londres_the_breadcrumb(); 
								$londres_output = ".londres_breadcrumbs{".esc_attr($bcaux)."}";
								londres_set_custom_inline_css($londres_output);
							?>
			    		</div>
			    		<?php
					}
					?>
				</div>
		<?php }
		?>
		</div>	
		<?php
	}


	$sidebar_scheme = get_option('londres_woo_sidebar_scheme');
	$sidebar = londres_convert_to_class(get_option('londres_woo_sidebar'));
	switch ($sidebar_scheme){
		case "none":
			?>
			<div class="master_container master_container_bgwhite" >
				<section class="page_content" id="section_page-<?php echo esc_attr($londres_thisPostID); ?>">
					<div class="container">
						<?php 
							if (post_password_required()) echo get_the_password_form();
							else woocommerce_content(); 
						?>
					</div>
				</section>
			</div>
			<?php
		break;
		case "left":
			?>
			<div class="master_container master_container_bgwhite" >
				<div class="container">
					<?php
						if (!post_password_required()){
							?>
							<section class="page_content left sidebar col-xs-12 col-md-3">
								<?php 
								if ($sidebar === "defaultblogsidebar") $sidebar = 'sidebar-widgets';
								if ( function_exists('dynamic_sidebar') && is_active_sidebar( $sidebar )) { 
									ob_start();
									do_shortcode(dynamic_sidebar($sidebar));
									$html = ob_get_contents();
									ob_end_clean();
									$html = wp_kses_no_null( $html, array( 'slash_zero' => 'keep' ) );
									$html = wp_kses_normalize_entities($html);
									echo wp_kses_hook($html, 'post', array());  
								} else get_sidebar();
								?>
							</section>
							<?php
						}
					?>
					<section class="page_content right col-xs-12 col-md-9 <?php if (post_password_required()) echo ' border-none '; ?>" id="section_page-<?php echo esc_attr($londres_thisPostID); ?>" >
						<?php 
							if (post_password_required()) echo get_the_password_form();
							else woocommerce_content(); 
						?>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			?>
			<div class="master_container master_container_bgwhite" >
				<div class="container">
					<section class="page_content left col-xs-12 col-md-9 <?php if (post_password_required()) echo ' border-none '; ?>" id="section_page-<?php echo esc_attr($londres_thisPostID); ?>" >
						<?php 
							if (post_password_required()) echo get_the_password_form();
							else woocommerce_content(); 
						?>
					</section>
					<?php
						if (!post_password_required()){
							?>
							<section class="page_content right sidebar col-xs-12 col-md-3">
								<?php 
								if ($sidebar === "defaultblogsidebar") $sidebar = 'sidebar-widgets';
								if ( function_exists('dynamic_sidebar') && is_active_sidebar( $sidebar )) { 
									ob_start();
									do_shortcode(dynamic_sidebar($sidebar));
									$html = ob_get_contents();
									ob_end_clean();
									$html = wp_kses_no_null( $html, array( 'slash_zero' => 'keep' ) );
									$html = wp_kses_normalize_entities($html);
									echo wp_kses_hook($html, 'post', array());  
								} else get_sidebar();
								?>
							</section>
							<?php
						}
					?>
				</div>
			</div>
			<?php
		break;
		default:
			?>
			<div class="master_container master_container_bgwhite" >
				<section class="page_content" id="section_page-<?php echo esc_attr($londres_thisPostID); ?>">
					<div class="container">
						<?php 
							if (post_password_required()) echo get_the_password_form();
							else woocommerce_content(); 
						?>
					</div>
				</section>
			</div>
			<?php
		break;
	}

		
get_footer(); ?>