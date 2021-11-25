<?php

	$londres_thisPostID = get_the_ID(); $londres_color_code = get_option("londres_style_color");

	if (get_post_meta($londres_thisPostID, "londres_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($londres_thisPostID, "londres_enable_custom_pagetitle_options_value", true)){
		$type = get_option("londres_header_type");
		$thecolor = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_header_color"))); 
		$opacity = intval(str_replace("%","",get_option("londres_header_opacity")))/100;
		$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
		$image = get_option("londres_header_image"); 
	$pattern = is_string(get_option("londres_header_pattern")) ? LONDRES_PATTERNS_URL.get_option("londres_header_pattern") : ""; 
		$custompattern = get_option("londres_header_custom_pattern"); 
		$margintop = get_option("londres_header_text_margin_top");	
		$banner = get_option("londres_banner_slider");
		$showtitle = get_option("londres_hide_pagetitle") == "on" ? true : false;
		$showsectitle = get_option("londres_hide_sec_pagetitle") == "on" ? true : false;
		$tcolor = get_option("londres".'_header_text_color');
		$tsize = intval(str_replace(" ", "", get_option("londres".'_header_text_size')),10)."px";
		$tfont = get_option("londres".'_header_text_font');
		$stcolor = get_option("londres".'_secondary_title_text_color');
		$stsize = intval(str_replace(" ", "", get_option("londres".'_secondary_title_text_size')),10)."px";
		$stfont = get_option("londres".'_secondary_title_font');
		$stmargin = intval(str_replace(" ", "", get_option("londres".'_header_sec_text_margin_top')),10)."px";
		$originalalign = get_option("londres_header_text_alignment");
		$pt_parallax = get_option("londres_pagetitle_image_parallax") == "on" ? true : false;
		$pt_overlay = get_option("londres_pagetitle_image_overlay") == "on" ? true : false;
		$pt_overlay_type = get_option("londres_pagetitle_overlay_type");
		$pt_overlay_the_color = londres_hex2rgb(str_replace("__USE_THEME_MAIN_COLOR__", $londres_color_code, get_option("londres_pagetitle_overlay_color")));
		$pt_overlay_pattern = (is_string(get_option("londres_pagetitle_overlay_pattern"))) ? LONDRES_PATTERNS_URL.get_option("londres_pagetitle_overlay_pattern") : "";
		$pt_overlay_opacity = intval(str_replace("%","",get_option("londres_pagetitle_overlay_opacity")))/100;
		$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
		$breadcrumbs = get_option("londres_breadcrumbs");
		$breadcrumbs_margintop = get_option('londres_breadcrumbs_text_margin_top');
		$pagetitlepadding = get_option('londres_page_title_padding');
	} else {
		$type = get_post_meta($londres_thisPostID, "londres_header_type_value", true);
		$thecolor = londres_hex2rgb(get_post_meta($londres_thisPostID, "londres_header_color_value", true)); 
		$opacity = intval(str_replace("%","",get_post_meta($londres_thisPostID, "londres_header_color_opacity_value", true)))/100;
		$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
		$image = get_post_meta($londres_thisPostID, "londres_header_image_value", true);
		$image = explode('|!|',$image);
		if (isset($image[1])) $image = explode('|*|',$image[1]);
		$image = $image[0];
		$pattern = LONDRES_PATTERNS_URL.get_post_meta($londres_thisPostID, "londres_header_pattern_value", true).".jpg";
		$custompattern = get_option("londres_header_custom_pattern_value"); 
		$margintop = get_post_meta($londres_thisPostID, "londres_header_text_margin_top_value", true);
		$banner = get_post_meta($londres_thisPostID, "londres_banner_slider_value", true);
		$showtitle = get_post_meta($londres_thisPostID, "londres_hide_pagetitle_value", true) == "yes" ? true : false;
		$showsectitle = get_post_meta($londres_thisPostID, "londres_hide_sec_pagetitle_value", true) == "yes" ? true : false;
		$tcolor = get_post_meta($londres_thisPostID, "londres_header_text_color_value", true);
		$tsize = intval(str_replace(" ", "", get_post_meta($londres_thisPostID, "londres_header_text_size_value", true)),10)."px";
		$tfont = get_post_meta($londres_thisPostID, "londres_header_text_font_value", true);
		$stcolor = get_post_meta($londres_thisPostID, "londres_secondary_title_text_color_value", true);
		$stsize = intval(str_replace(" ", "", get_post_meta($londres_thisPostID, "londres_secondary_title_text_size_value", true)),10)."px";
		$stfont = get_post_meta($londres_thisPostID, "londres_secondary_title_font_value", true);
		$stmargin = intval(str_replace(" ", "", get_post_meta($londres_thisPostID, "londres_header_secondary_text_margin_top_value", true)),10)."px";
		$originalalign = get_post_meta($londres_thisPostID, "londres_header_text_alignment_value", true);
		$pt_parallax = get_post_meta($londres_thisPostID, "londres_pagetitle_image_parallax_value", true) == "on" ? true : false;
		$pt_overlay = get_post_meta($londres_thisPostID, "londres_pagetitle_image_overlay_value", true) == "on" ? true : false;
		$pt_overlay_type = get_post_meta($londres_thisPostID, "londres_pagetitle_overlay_type_value", true);
		$pt_overlay_the_color = londres_hex2rgb(get_post_meta($londres_thisPostID, "londres_pagetitle_overlay_color_value", true));
		$pt_overlay_pattern = LONDRES_PATTERNS_URL.get_post_meta($londres_thisPostID, "londres_pagetitle_overlay_pattern_value", true).".jpg";
		$pt_overlay_opacity = intval(str_replace("%","",get_post_meta($londres_thisPostID, "londres_pagetitle_overlay_opacity_value", true)))/100;
		$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
		$breadcrumbs = get_post_meta($londres_thisPostID, "londres_enable_breadcrumbs_value", true) == "yes" ? "on" : "off";
		$breadcrumbs_margintop = intval(str_replace(" ", "", get_post_meta($londres_thisPostID, "londres_breadcrumbs_margin_top_value", true)),10)."px";
		$pagetitlepadding = intval(str_replace(" ", "", get_post_meta($londres_thisPostID, "londres_page_title_padding_value", true)),10)."px";
	}
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
	
	londres_set_import_fonts($londres_import_fonts);
	
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
		<div class="fullwidth-container <?php if ($type == "pattern") echo "bg-pattern"; ?> <?php if ($pt_parallax) echo "parallax"; ?><?php if (($type == "image" || $type == "pattern" || $type == "featured_image") && get_option('londres_enable_grayscale') == 'on') echo " londres_grayscale "; ?>" <?php if ($pt_parallax) echo 'data-stellar-ratio="0.5"'; ?>
	    	<?php
		    	$londres_output = ".fullwidth-container{";
		    	if ($type == "featured_image"){
			    	$type = "image";
			    	$image = wp_get_attachment_url( get_post_thumbnail_id($londres_thisPostID) );
				}
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
								<?php echo wp_kses_post(get_the_title($londres_thisPostID)); ?>
							</h1>
							<?php
							$londres_output = ".present-container h1.page_title{color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";
							if ($margintop != "") $londres_output .= esc_attr("margin-top: ".intval($margintop,10)."px;");
							$londres_output .= "}";
							londres_set_custom_inline_css($londres_output);
						}
		    			if ($showsectitle){
			    			if (is_string(get_post_meta($post->ID, 'secondaryTitle_value', true)) && get_post_meta($post->ID, 'secondaryTitle_value', true) != ""){
						    	?>
							    <h2 class="secondaryTitle">
							    	<?php echo wp_kses_post(get_post_meta($post->ID, 'secondaryTitle_value', true)); ?>
							    </h2>
					    		<?php
					    	} else {
								if (is_string(get_option('londres_blog_secondary_title')) && get_option('londres_blog_secondary_title') != ""){
									?>
								    <h2 class="secondaryTitle">
								    	<?php echo wp_kses_post(get_option('londres_blog_secondary_title')); ?>
								    </h2>
									<?php
								}
							}
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
			
					/* new metas on pagetitle */
					if ((get_post_meta( $londres_thisPostID , 'upper_single_display_metas_value' , true ) == "yes" || get_post_meta( $londres_thisPostID , 'upper_single_display_metas_value' , true ) == "") && (get_post_meta( $londres_thisPostID , 'upper_single_display_metas_where_value' , true ) == 'pagetitle' || get_post_meta( $londres_thisPostID , 'upper_single_display_metas_where_value' , true ) == '')){
				
						?>
						<div class="metas-container">
							<div class="align-metas-center">
		    			
				    			<?php
					    			$metas = get_post_meta( $londres_thisPostID , 'upper_single_metas_value' , true );
					    			if ($metas=="") $metas = "date,author,tags,categories";
					    			$metas = explode(",", $metas);
					    			if (!empty($metas)){
						    			$londres_output = ".londres-apply-tcolor{ color:#".esc_attr($tcolor)." !important; }";
						    			londres_set_custom_inline_css($londres_output);
						    			$firstMeta = true;
						    			foreach ($metas as $meta){
							    			switch ($meta){
								    			case "date":
									    			if (!$firstMeta){
										    			echo '<p class="metas-sep londres-apply-tcolor">|</p>';
									    			} else {
										    			$firstMeta = false;
									    			} 
								    				?>
								    				<p class="blog-date londres-apply-tcolor"><?php echo get_the_date(); ?></p>
								    				<?php
								    			break;
								    			case "author":
								    				if (!$firstMeta){
										    			echo '<p class="metas-sep londres-apply-tcolor">|</p>';
									    			} else {
										    			$firstMeta = false;
									    			}
								    				?>
								    				<p class="londres-apply-tcolor"><?php
									    				if (function_exists('icl_t')){
										    				printf(esc_html__("%s","londres"), icl_t( 'londres', 'by', get_option('londres_by_text')));
									    				} else {
										    				printf(esc_html__("%s","londres"), get_option("londres_by_text"));
									    				}
								    				?>: <a class="the_author londres-apply-tcolor" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"> <?php  esc_html(the_author_meta('nickname')); ?></a></p>
								    				<?php
								    			break;
								    			case "tags":
								    				$posttags = get_the_tags();
													if ($posttags) {
														if (!$firstMeta){
											    			echo '<p class="metas-sep londres-apply-tcolor">|</p>';
										    			} else {
											    			$firstMeta = false;
										    			}
														$first = true;
														echo '<p class="londres-apply-tcolor">';
														if (function_exists('icl_t')){
										    				printf(esc_html__("%s","londres"), icl_t( 'londres', 'by', get_option('londres_tags_text')));
									    				} else {
										    				printf(esc_html__("%s","londres"), get_option("londres_tags_text"));
									    				}
														echo ': ';
														foreach($posttags as $tag) {
															if ($tag->name != "uncategorized"){
																if ($first){
																	echo "<a class='londres-apply-tcolor' href='".esc_url( get_term_link($tag) )."'>".esc_html($tag->name)."</a>"; 
																	$first = false;
																} else {
																	echo "<span>, </span><a class='londres-apply-tcolor' href='".esc_url( get_term_link($tag) )."'>".esc_html($tag->name)."</a>";
																}
															}
													  	}
													  	echo '</p>';
													}
								    			break;
								    			case "categories":
								    				$postcats = get_the_category();
													if ($postcats) {
														if (!$firstMeta){
											    			echo '<p class="metas-sep londres-apply-tcolor">|</p>';
										    			} else {
											    			$firstMeta = false;
										    			}
														$first = true;
														echo '<p class="londres-apply-tcolor">';
														if (function_exists('icl_t')){
										    				printf(esc_html__("%s","londres"), icl_t( 'londres', 'by', get_option('londres_categories_text')));
									    				} else {
										    				printf(esc_html__("%s","londres"), get_option("londres_categories_text"));
									    				}
														echo ': ';
														foreach($postcats as $cat) {
															if ($cat->name != "uncategorized"){
																if ($first){
																	echo "<a class='londres-apply-tcolor' href='".esc_url( get_term_link($cat) )."'>".esc_html($cat->name)."</a>"; 
																	$first = false;
																} else {
																	echo "<span>, </span><a class='londres-apply-tcolor' href='".esc_url( get_term_link($cat) )."'>".esc_html($cat->name)."</a>"; 
																}	
															}
													  	}
													  	echo '</p>';
													}
								    			break;
								    			case "comments":
								    				if (!$firstMeta){
										    			echo '<p class="metas-sep londres-apply-tcolor">|</p>';
									    			} else {
										    			$firstMeta = false;
									    			}
								    				echo '<p class="londres-apply-tcolor">';
								    				printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'londres' ), number_format_i18n( get_comments_number() ) );
								    				echo '</p>';
								    			break;
								    			case "customtext":
								    				if (!$firstMeta){
										    			echo '<p class="metas-sep" class="londres-apply-tcolor">|</p>';
									    			} else {
										    			$firstMeta = false;
									    			}
								    				echo '<p class="londres-apply-tcolor">'.wp_kses_post( get_post_meta( $londres_thisPostID , 'upper_single_meta_custom_text_value' , true ) ).'</p>';
								    			break;
							    			}
						    			}
					    			}
				    			?>
				    		</div>
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
	
	$is_custom_sidebar_layout = get_post_meta($londres_thisPostID, 'enable_post_custom_sidebar_layout_value', true) == "true" ? true : false;
	$sidebar_scheme = $is_custom_sidebar_layout ? get_post_meta( $londres_thisPostID, 'sidebar_for_default_value', true ) : get_option('londres_blog_single_sidebar');
	$sidebar = $is_custom_sidebar_layout ? londres_convert_to_class(get_post_meta( $londres_thisPostID, 'sidebars_available_value', true )) : londres_convert_to_class(get_option('londres_sidebars_available'));
	
	if ($sidebar == "") $sidebar = "defaultblogsidebar";
	switch ( $sidebar_scheme ){
		case "none":
			?>
			<div class="blog-default wideblog">
				<div class="master_container container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<?php 
								if (post_password_required()) echo get_the_password_form();
								else londres_print_single_post(); 
							?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "left":
			?>
			<div class="blog-default">
				<div class="master_container container">
					<section class="page_content left sidebar col-xs-12 col-md-3">
						
						<div class="blog-sidebar-bg">
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
						</div>
					</section>
					<section class="page_content right col-xs-12 col-md-9">
						<div class="blog-default-bg">
							<?php 
								if (post_password_required()) echo get_the_password_form();
								else londres_print_single_post(); 
							?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			?>
			
			<div class="blog-default">
				<div class="master_container container">
					<section class="page_content left col-xs-12 col-md-9">
						<div class="blog-default-bg">
							<?php 
								if (post_password_required()) echo get_the_password_form();
								else londres_print_single_post(); 
							?>
						</div>
					</section>
					<section class="page_content right sidebar col-xs-12 col-md-3">
						<div class="blog-sidebar-bg">
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
						</div>
					</section>
				</div>
			</div>
			
			<?php
		break;
		default:
			?>
			<div class="blog-default wideblog">
				<div class="master_container container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<?php 
								if (post_password_required()) echo get_the_password_form();
								else londres_print_single_post(); 
							?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
	}	

	function londres_print_single_post(){
		$londres_inline_script = '';
		?>
		<article id="post-<?php esc_attr(the_ID()); ?>" class="post">
				
			   	
	    	<?php
	    	
	    	$posttype = get_post_meta(get_the_ID(), 'posttype_value', true);
	    	
	    	$postid = get_the_ID(); ?>
	    	
	    	<div class="postcontent">

	    	<?php
	    	
	    		switch($posttype){
		    		case "image":
		    			if (wp_get_attachment_url( get_post_thumbnail_id($postid)) && get_post_meta( $postid, 'londres_display_featured_image_value', true ) == "yes" ){
						?>
							<div class="featured-image-thumb">
								<?php
									if (get_option("londres_enlarge_images") == "on"){ ?>
										<a class="featured-image-fb des_prettyphoto" href="<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id($postid))); ?>" title="<?php the_title_attribute(); ?>">
									<?php
						    		}
								?>
									<img src="<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id($postid))); ?>" title="<?php the_title_attribute(); ?>"/>
								<?php
									if (get_option("londres_enlarge_images") == "on"){ ?>
										<span class="post_overlay"><i class="fa fa-search" aria-hidden="true"></i></span>
										</a>
									<?php
									}
								?>
							</div>
							<?php 
							if (get_option("londres_enlarge_images") == "on"){
								$londres_inline_script .= '
									jQuery(document).ready(function(){
										"use strict";
										jQuery(".featured-image-thumb > a.des_prettyphoto").prettyPhoto({
									    	animationSpeed: "normal",
											padding: 15,
											opacity: 0.7,
											showTitle: false,
											allowresize: true,
											counter_separator_label: "/",
											//theme: "light_square",
											hideflash: false, 
											deeplinking: false, 
											modal: false, 
											callback: function () {
												var url = location.href;
												var hashtag = (url.indexOf( "#!prettyPhoto" )) ? true : false;
												if ( hashtag ) {
													location.hash = "!";
												}
											},
											social_tools: ""
								    	});
									});
								';
							}
						}
		    		break;
		    		
		    		case "slider": 
		    			$randClass = rand(0,1000);
						?>
						<div class="flexslider <?php echo esc_attr($posttype); ?>" id="<?php echo esc_attr($randClass); ?>">
							<ul class="slides">
								<?php
									$sliderData = get_post_meta($postid, "sliderImages_value", true);
									$slide = explode("|*|",$sliderData);
								    foreach ($slide as $s){
								    	if ($s != ""){
								    		$params = explode("|!|",$s);
								    		$attachment = get_post( $params[0] );
								    		echo "<li>";
								    		if (get_option("londres_enlarge_images") == "on"){
									    		echo "<a href='".esc_url($params[1])."' rel='des_prettyPhoto[pp_gal]' class='slide-images des_prettyphoto'>";
								    		}
								    		echo "<img src='".esc_url($params[1])."' >";
								    		if (get_option("londres_enlarge_images") == "on"){
									    		echo "<span class='post_overlay'><i class='fa fa-search' aria-hidden='true'></i></span></a>";
								    		}
								    		echo "</li>";	
								    	}
								    }
								?>
							</ul>
						</div>
						<?php
						$animation = get_option("londres_posts_flex_transition");
						$directionNav = get_option("londres_posts_flex_navigation");
						$slideshowSpeed = get_option("londres_posts_flex_slide_duration") ? get_option("londres_posts_flex_slide_duration") : 3000;
						$pauseOnHover = get_option("londres_posts_flex_pause_hover");
						$controlNav = get_option("londres_posts_flex_controls");
						$slideshow = get_option("londres_posts_flex_autoplay");
						$height = get_option("londres_posts_flex_height");
						$animationDuration = get_option("londres_posts_flex_transition_duration") ? get_option("londres_posts_flex_transition_duration") : 1000;
						if ($directionNav == "on" || $directionNav == "true") $directionNav = true; else $directionNav = false;
						if ($pauseOnHover == "on" || $pauseOnHover == "true") $pauseOnHover = true; else $pauseOnHover = false;
						if ($controlNav == "on" || $controlNav == "true") $controlNav = true; else $controlNav = false;
						if ($slideshow == "on" || $slideshow == "true") $slideshow = true; else $slideshow = false;
						
						if (get_option("londres_enlarge_images") == "on"){
							$londres_inline_script .= '
								jQuery(document).ready(function(){
									"use strict";
									jQuery("li:not(.clone) > a.des_prettyphoto, li:not(.clone) > a[rel=\'des_prettyPhoto[pp_gal]\'], .featured-image-thumb > a.des_prettyphoto").prettyPhoto({
								    	animationSpeed: "normal",
										padding: 15,
										opacity: 0.7,
										showTitle: false,
										allowresize: true,
										counter_separator_label: "/",
										hideflash: false, 
										deeplinking: false, 
										modal: false, 
										callback: function () {
											var url = location.href;
											var hashtag = (url.indexOf( "#!prettyPhoto" )) ? true : false;
											if ( hashtag ) {
												location.hash = "!";
											}
										},
										social_tools: ""
							    	});
								});
							';
						}

						$londres_inline_script .= '
							jQuery(document).ready(function(){
								"use strict";
								jQuery("#'.esc_html($randClass).'.flexslider").flexslider({
									animation: "'.esc_html($animation).'",
									slideDirection: "horizontal", 
									directionNav: "'.esc_html($directionNav).'",
									slideshowSpeed: '.esc_html($slideshowSpeed).',
									controlsContainer: "#'.esc_html($randClass).' .flex-viewport",
									pauseOnAction: false,
									pauseOnHover: "'.esc_html($pauseOnHover).'",
									keyboardNav: false,
									controlNav: "'.esc_html($controlNav).'",
									slideshow: "'.esc_html($slideshow).'",
									animationDuration: '.esc_html($animationDuration).',
									start: function(slider){
										jQuery("#'.esc_html($randClass).'.flexslider").css("overflow","visible");
										jQuery(slider).find(".flex-direction-nav").css({ "position":"absolute", "width":"100%", "top":"50%" });
										jQuery(slider).flexslider("next");
									}
								});
								jQuery("#'.esc_html($randClass).' ul.slides li, #'.esc_html($randClass).' ul.slides li a").css({"max-height":"'.esc_html($height).'","overflow":"hidden"});
							});
						';		
		    		break;
		    		
		    		case "audio":
		    			$randClass = rand(0,1000);
						?>
						<div class="audioContainer">
							<?php
								if (get_post_meta($postid, 'audioSource_value', true) == 'embed') echo get_post_meta($postid, 'audioCode_value', true); 
								else {
									$audio = explode("|!|",get_post_meta($postid, 'audioMediaLibrary_value', true));
									if (isset($audio[1])) {
										$ext = explode(".",$audio[1]);
										if (isset($ext)) $ext = $ext[count($ext)-1];
										?>
										<audio controls="controls"><source type="audio/<?php echo esc_attr($ext); ?>" src="<?php echo esc_url($audio[1]); ?>"></audio>
										<?php
									}
								}
							?>
						</div>
						<?php
		    		break;
		    		
		    		case "video":
						$videosType = get_post_meta($postid, "videoSource_value", true);
						if ($videosType != "embed"){
							$videos = get_post_meta($postid, "videoCode_value", true);
							$videos = preg_replace( '/\s+/', '', $videos );
							$vid = explode(",",$videos);
						}
						switch (get_post_meta($postid, "videoSource_value", true)){
							case "media":
								echo "<video id='html5video' preload='metadata' controls='controls' >";
								$media = get_post_meta($londres_thisPostID, 'videoMediaLibrary_value', true);
								$media = explode("|*|",$media);
								foreach ($media as $m){
									if (strlen($m) > 0){
										$videoattrs = explode("|!|",$m);
										$ext = explode('.',$videoattrs[1]);
										$ext = $ext[count($ext)-1];
										echo "<source src=".esc_url($videoattrs[1])." type='video/".esc_attr($ext)."'>";
									}
								}
								echo "</video>";
							break;
							case "youtube":
								echo "<div id='the_movies' class='vendor ".esc_attr(get_post_meta($postid, "videoSource_value", true))."'></div>";
								foreach ($vid as $v){
									echo "<div class='v_links'>https://www.youtube.com/embed/".esc_attr($v)."?autoplay=1&amp;wmode=transparent&amp;autohide=1&amp;showinfo=0&amp;rel=0</div>";	
								}
								break;
							case "vimeo":
								echo "<div id='the_movies' class='vendor ".esc_attr(get_post_meta($postid, "videoSource_value", true))."'></div>";
								foreach ($vid as $v){
									echo "<div class='v_links'>https://player.vimeo.com/video/".esc_attr($v)."?autoplay=1&amp;title=0&amp;byline=0&amp;portrait=0</div>";	
								}
								break;
						}
						
						$londres_inline_script .= '
							jQuery(document).ready(function(){
							"use strict";
						';
						if (get_post_meta($postid, "videoSource_value", true) != "embed" && get_post_meta($postid, "videoSource_value", true) != "media"){
							$londres_inline_script .= '
							var aux_html = "<iframe src=\'"+jQuery(".v_links").eq(0).html()+"\' width=\'560\' height=\'349\' frameborder=\'0\' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
							jQuery("#the_movies").html(aux_html).fitVids();
							';
						}
						$londres_inline_script .= '
							jQuery("#the_movies").css({"position":"relative","float":"left","width":"100%"}).siblings(".the_content").css({"display":"inline-block","width":"100%"});
							if (jQuery("#the_movies").siblings(".v_links").length > 1){
				          		jQuery("#the_movies").siblings(".movies-nav").remove();
						  		var aux_html = "<ul class=\'flex-direction-nav movies-nav\'><li><a class=\'prev\' href=\'javascript:;\'>Previous</a></li><li><a class=\'next\' href=\'javascript:;\'>Next</a></li></ul>";
				            	jQuery("#the_movies").append(aux_html);
				          		jQuery("#the_movies .flex-direction-nav").css({
					          		"position": "absolute",
					          		"width":"100%",
					          		"top":"50%",
				          		}).find("li").css({"margin":0,"padding":0}).find("a").css({"display":"inline-block", "position":"relative", "opacity":1});
						  		jQuery("#the_movies .flex-direction-nav li").eq(0).css("float","left");
						  		jQuery("#the_movies .flex-direction-nav li").eq(1).css("float","right");
				          		
				          		jQuery("#the_movies").siblings(".current_movie").remove();
				          		jQuery("#the_movies").after("<div hidden class=\'current_movie upper_hidden\'>0</div>");
				          		
				          		jQuery(document).on("click", ".movies-nav .prev", function(e){
				          			e.preventDefault();
				          			var index = parseInt(jQuery(".current_movie").html());
				          			var nextIndex = 0;
				          			if (index == 0) nextIndex = jQuery("#the_movies").siblings(".v_links").length - 1;
				          			else nextIndex = index-1;
				          			jQuery("#the_movies iframe").attr("src", jQuery("#the_movies").siblings(".v_links").eq(nextIndex).html() );
				          			jQuery("#the_movies").siblings(".current_movie").html(nextIndex);
				          			
				          		});
				          		jQuery(document).on("click", ".movies-nav .next", function(e){
				          			e.preventDefault();
				          			var index = parseInt(jQuery(".current_movie").html());
				          			var nextIndex = 0;
				          			if (index == jQuery("#the_movies").siblings(".v_links").length - 1) nextIndex = 0;
				          			else nextIndex = index+1;
				          			jQuery("#the_movies iframe").attr("src", jQuery("#the_movies").siblings(".v_links").eq(nextIndex).html() );
				          			jQuery("#the_movies").siblings(".current_movie").html(nextIndex);
				
				          		});
				          	}
						';
						$londres_inline_script .= '
							});
						';
					break;
					
					case "gallery":
						$slider = get_post_meta($postid,'gallery_slider_value',true);
						if ($slider != '-1'){
							if (substr($slider, 0, 10) === "revSlider_"){
								?>
								<div class="gallery_container">
									<?php
										if (!function_exists('putRevSlider')){
											echo 'Please install the missing plugin - Revolution Slider.';
										} else {
											putRevSlider(substr($slider, 10));
										}
									?>
								</div>
								<?php
							} else {
								?>
								<div class="gallery_container">
									<?php
										if (!function_exists('masterslider')){
											echo 'Please install the missing plugin - MasterSlider.';
										} else {
											echo do_shortcode( '[masterslider alias="'.substr($slider, 13).'"]' );
										}
									?>
								</div>
								<?php
							}
						}
					break;
		    	}
		    						    	
	    		?>
				
				<div class="the_title"><h2><?php echo wp_kses_post(the_title()); ?></h2></div>
		    
			    
	    		<div class="the_content">
			    	<?php 
			    		the_content();
			    		$args = array(
							'before'           => '<div class="navigation margin-top-0px"><div class="des-pages"><span class="pages current">' . esc_html__('Post Pages:', 'londres') . '</span>',
							'after'            => '</div></div>',
							'link_before'      => '<div class="postpagelinks">',
							'link_after'       => '</div>',
							'next_or_number'   => 'number',
							'nextpagelink'     => esc_html__('Next page','londres'),
							'previouspagelink' => esc_html__('Previous page','londres'),
							'pagelink'         => '%',
							'echo'             => 1
						); 
			    		wp_link_pages($args); 
			    	?>

			    </div>
	    		
	    		
	    		<?php
					if (get_option("londres_post_single_social_shares") == "on" && get_option('londres_post_single_socials') != "" && defined('LONDRES_PLG_ACTIVE')){
					$post_single_socials = explode(",",get_option('londres_post_single_socials'));
					?>
					<div class="share-buttons">
		                
			        	<h5><?php
				        	if (function_exists('icl_t')){
					        	echo sprintf(esc_html__("%s","londres"), icl_t( 'londres', 'SHARE THIS', get_option('londres_share_post_text')));
				        	} else {
					        	echo sprintf(esc_html__("%s","londres"), get_option("londres_share_post_text"));
				        	}
			        	?></h5>
			            
						<!--  NEW STUFF -->
			            <div class="posts-shares">
			                <div class="social-shares clearfix">
						        <ul>
							        <?php
								        if (in_array("facebook", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("https://www.facebook.com/sharer.php?u=".get_the_permalink()."&amp;t=".get_the_title()); ?>" class="share-facebook" target="_blank" ><i class="fa fa-facebook"></i><?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
								        if (in_array("twitter", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("https://twitter.com/home?status=".get_the_title()."_".get_the_permalink()); ?>" class="share-twitter" target="_blank" ><i class="fa fa-twitter"></i><?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
								        if (in_array("linkedin", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("https://linkedin.com/shareArticle?mini=true&amp;url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-linkedin" ><i class="fa fa-linkedin"></i><?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
								        if (in_array("googleplus", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("https://google.com/bookmarks/mark?op=edit&amp;bkmk=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-google" ><i class="fa fa-google-plus"></i><?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
								        if (in_array("pinterest", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); echo esc_url("https://www.pinterest.com/pin/create/button/?url=".get_the_permalink()."&amp;media=".$url."&amp;") ?>" target="_blank" class="share-pinterest" ><i class="fa fa-pinterest"></i><?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
								        if (in_array("tumblr", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("https://www.tumblr.com/share/?url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" ><i class="fa fa-tumblr"></i><?php esc_html_e( '', 'londres' )?></a>							
											</li>
									        <?php
								        }
								        if (in_array("email", $post_single_socials)){
									        ?>
									        <li>
												<a href="<?php echo esc_url("mailto:?subject=".get_the_title()."&amp;body=".get_the_permalink()); ?>" class="share-mail" ><i class="fa fa-envelope-o"></i> <?php esc_html_e( '', 'londres' )?></a>
											</li>
									        <?php
								        }
							        ?>	
						        </ul>
						    </div>
			                
			            </div>
			            
			         </div> 
					<?php
				}
				$extraclass = !defined('LONDRES_PLG_ACTIVE') ? "margin-correction" : "";
				?>
				<nav id="nav-below" role="article" class="navigation <?php echo esc_attr($extraclass); ?>">
					<?php 
						if (function_exists('icl_t')){
							previous_post_link( '<div class="nav-previous"><i class="ion-ios-arrow-thin-left"></i>%link</div>', sprintf(esc_html__("%s",'londres'), icl_t( 'londres', 'Previous post', get_option('londres_single_previous_text')))); 
							next_post_link( '<div class="nav-next">%link<i class="ion-ios-arrow-thin-right"></i></div>', sprintf(esc_html__("%s",'londres'), icl_t( 'londres', 'Next post', get_option('londres_single_next_text')) )); 
						} else {
							previous_post_link( '<div class="nav-previous"><i class="ion-ios-arrow-thin-left"></i>%link</div>', sprintf(esc_html__("%s",'londres'), get_option('londres_single_previous_text'))); 
							next_post_link( '<div class="nav-next">%link<i class="ion-ios-arrow-thin-right"></i></div>', sprintf(esc_html__("%s",'londres'), get_option('londres_single_next_text') )); 
						}
					?>
				</nav>
				
				<?php
					if (get_option("londres_post_about_author") == "on"){
						?>
						<div class="about-author">
						    <div class="img-container">
							    <?php echo str_replace('avatar-80', 'avatar-80', get_avatar(get_the_author_meta('email'), 80)); ?>
						    </div>
						    <h5><?php
							    if (function_exists('icl_t')){
				    				printf(esc_html__("%s","londres"), icl_t( 'londres', 'by', get_option('londres_by_text')));
			    				} else {
				    				printf(esc_html__("%s","londres"), get_option("londres_by_text"));
			    				}
						    ?><a href="<?php echo esc_attr( get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></h5>
						    <p><?php the_author_meta('description'); ?></p>
						</div>
						<?php
					}
					
					if (comments_open( get_the_ID() ) || get_comments_number( get_the_ID() ) ){
						?>
					    <div class="the_comments">
						    <?php comments_template( '', true ); ?>
					    </div>
						<?php
					}
				?>
				
		    </div> <!-- end of .postcontent -->
	    	
	    </article> <!-- end of post -->
		<?php
		$londres_inline_script .= '
			jQuery(document).ready(function(){
				"use strict";
				jQuery(".social-shares a[target=\'_blank\']").on("click", function(){
			        newwindow=window.open(jQuery(this).attr("href"),"","height=450,width=700");
			        if (window.focus) {newwindow.focus()}
			        return false;
			    });
			});
		';
		wp_add_inline_script('londres-global', $londres_inline_script, 'after');
	}
	