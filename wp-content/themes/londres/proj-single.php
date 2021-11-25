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
								<?php if (is_front_page() && is_home()) echo wp_kses_post(get_option('londres_blog_single_primary_title')); else echo wp_kses_post(get_the_title($londres_thisPostID)); ?>
							</h1>
							<?php
							$londres_output = ".present-container h1.page_title{color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";
							if ($margintop != "") $londres_output .= esc_attr("margin-top: ".intval($margintop,10)."px;");
							$londres_output .= "}";
							londres_set_custom_inline_css($londres_output);
						}
		    			if ($showsectitle){
			    			if (get_post_meta($londres_thisPostID, 'secondaryTitle_value', true) != "" || get_option('londres_blog_secondary_title') != ""){
						    	?>
							    <h2 class="secondaryTitle">
							    	<?php echo wp_kses_post(get_post_meta($londres_thisPostID, 'secondaryTitle_value', true)); ?>
							    </h2>
					    		<?php
						    	$londres_output = ".present-container .secondaryTitle{color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}';font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};}";
								londres_set_custom_inline_css($londres_output);
					    	}
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
	
	?>
	
	<div class="master_container master_container_bgwhite" >
	
	<?php
	
	$singleLayout = get_post_meta($londres_thisPostID, 'singleLayout_value', true);
	if ($singleLayout == "default"){
		$singleLayout = get_option("londres_single_layout");
	}

	if (get_post_meta($londres_thisPostID, "portfolioType_value", true) != "other") {
		$pj_cols = " col-md-7";
		$ct_cols = " col-md-5";
		if ($singleLayout != "left_media"){
			$pj_cols = " col-md-12";
			$ct_cols = " col-md-12";
		}
		?>
			
			
		<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class(); ?> role="article">
			
			<?php
				if (post_password_required()) {
					?>
					<div class="proj-content"><?php echo get_the_password_form(); ?></div>
					<?php
				}
				else {
					?>
					<div class="proj-content">
						<div class="projects_description">
							<div class="projects_media <?php echo esc_attr($singleLayout . $pj_cols); ?>">
								<?php
									$output = "";
									
									if ($singleLayout == 'fullwidth_media'){
										$output .= "[vc_row full_width='stretch_row_content_no_spaces' video_opts='' multi_color_overlay=''][vc_column width='1/1'][vc_column_text]";
									}
								
									if (get_post_meta($londres_thisPostID, "portfolioType_value", true) == "image"){
										$output .= "<div id='p-slider-".esc_attr(get_the_ID())."' class='flexslider clearfix'><ul class='slides da-thumbs-plus'>";
										
										$sliderData = get_post_meta($londres_thisPostID, "sliderImages_value", true);
										$slide = explode("|*|",$sliderData);
										foreach ($slide as $s){
									    	if ($s != ""){
									    		$url = explode("|!|",$s);
									    		$output .= "<li><img src='".esc_url($url[1])."' width='100%' class='rp_style1_img'></li>";	
									    	}
									    }
									    $output .= "</ul></div>";
									} 
									if (get_post_meta($londres_thisPostID, "portfolioType_value", true) == "video") {
										$videosType = get_post_meta($londres_thisPostID, "videoSource_value", true);
										if ($videosType != "embed"){
											$videos = get_post_meta($londres_thisPostID, "videoCode_value", true);
											$videos = preg_replace( '/\s+/', '', $videos );
											$vid = explode(",",$videos);
										}
										switch (get_post_meta($londres_thisPostID, "videoSource_value", true)){
											case "media":
												$output .= "<video id='html5video' preload='metadata' controls='controls' >";
												$media = get_post_meta($londres_thisPostID, 'videoMediaLibrary_value', true);
												$media = explode("|*|",$media);
												foreach ($media as $m){
													if (strlen($m) > 0){
														$videoattrs = explode("|!|",$m);
														$ext = explode('.',$videoattrs[1]);
														$ext = $ext[count($ext)-1];
														$output .= "<source src=".esc_url($videoattrs[1])." type='video/".esc_attr($ext)."'>";
													}
												}
												$output .= "</video>";
											break;
											case "youtube":
												$output .= "<div id='the_movies' class='vendor'></div>";
												foreach ($vid as $v){
													$output .= "<div class='v_links'>https://www.youtube.com/embed/".esc_attr($v)."?autoplay=1&amp;wmode=transparent&amp;autohide=1&amp;showinfo=0&amp;rel=0</div>";	
												}
												break;
											case "vimeo":
												$output .= "<div id='the_movies' class='vendor'></div>";
												foreach ($vid as $v){
													$output .= "<div class='v_links'>https://player.vimeo.com/video/".esc_attr($v)."?autoplay=1&amp;title=0&amp;byline=0&amp;portrait=0</div>";	
												}
												break;
											case "embed":
												$output .= "<div class='embedded'>".get_post_meta($londres_thisPostID, "videoCode_value", true)."</div>";
												break;
										}
									}
									
								if ($singleLayout == "fullwidth_media"){
									$output .= "[/vc_column_text][/vc_column][/vc_row]";
									echo do_shortcode($output);
								} else {
									echo do_shortcode( $output, false );
								}
								?>
							</div>
							<div class="content_container <?php echo esc_attr($ct_cols); ?>">
								<?php 
									$content = get_the_content(get_the_ID());
									$content = apply_filters('the_content', $content); 
									londres_content_shortcoder($content);
									
									$content = wp_kses_no_null( $content, array( 'slash_zero' => 'keep' ) );
									$content = wp_kses_normalize_entities($content);
									echo wp_kses_hook($content, 'post', array()); // WP changed the order of these funcs and added args to wp_kses_hook
		
									$shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
									if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
										londres_set_custom_inline_css($shortcodes_custom_css);
									}						
								?>
							</div>
						</div>
					</div>
					
					<?php
						if (get_option("londres_project_single_social_shares") == "on" && get_option('londres_project_single_socials') != ""){
						$proj_single_socials = explode(",",get_option('londres_project_single_socials'));
						?>
						<div class="share-buttons">
			                
				        	<h5><?php 
					        	if (function_exists('icl_t')){
						        	echo sprintf(esc_html__("%s","londres"), icl_t( 'londres', 'SHARE THIS PROJECT', get_option('londres_share_proj_text'))); 
					        	} else {
						        	echo sprintf(esc_html__("%s","londres"), get_option("londres_share_proj_text")); 
					        	}
					        ?></h5>
				            
							<!--  NEW STUFF -->
				            <div class="posts-shares">
				                <div class="social-shares clearfix">
							        <ul>
								        <?php
									        if (in_array("facebook", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("https://www.facebook.com/sharer.php?u=".get_the_permalink()."&amp;t=".get_the_title()); ?>" class="share-facebook" target="_blank" ><i class="fa fa-facebook"></i><?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        if (in_array("twitter", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("https://twitter.com/home?status=".get_the_title()."_".get_the_permalink()); ?>" class="share-twitter" target="_blank" ><i class="fa fa-twitter"></i><?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        if (in_array("linkedin", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("https://linkedin.com/shareArticle?mini=true&amp;url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-linkedin" ><i class="fa fa-linkedin"></i><?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        if (in_array("googleplus", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("https://google.com/bookmarks/mark?op=edit&amp;bkmk=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-google" ><i class="fa fa-google-plus"></i><?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        if (in_array("pinterest", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); echo esc_url("https://www.pinterest.com/pin/create/button/?url=".get_the_permalink()."&amp;media=".$url."&amp;") ?>" target="_blank" class="share-pinterest" ><i class="fa fa-pinterest"></i><?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        if (in_array("tumblr", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("https://www.tumblr.com/share/?url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" ><i class="fa fa-tumblr"></i><?php esc_html_e( '', 'londres' )?></a>							
												</li>
										        <?php
									        }
									        if (in_array("email", $proj_single_socials)){
										        ?>
										        <li>
													<a href="<?php echo esc_url("mailto:?subject=".get_the_title()."&amp;body=".get_the_permalink()); ?>" class="share-mail" ><i class="fa fa-envelope-o"></i> <?php esc_html_e( '', 'londres' )?></a>
												</li>
										        <?php
									        }
									        
									        if (!isset($londres_inline_script)) $londres_inline_script = '';
									        $londres_inline_script .= '
									        jQuery(document).ready(function(){
										        "use strict";
												// Open social-shares links in Popup
												jQuery(".social-shares a[target=\'_blank\']").on("click", function(){
											        newwindow=window.open(jQuery(this).attr("href"),"","height=450,width=700");
											        if (window.focus) {newwindow.focus()}
											        return false;
											    });
											});
									        ';
									        
								        ?>	
							        </ul>
							    </div>
				                
				            </div>
				            
				         </div> 
						<?php
						}
					?>
			             
			        
			        <div class="projects_nav1 container">
						<?php 
							if (function_exists('icl_t')){
								previous_post_link( '<div class="nav-previous-nav1">%link</div>', sprintf(esc_html__("%s","londres"), icl_t( 'londres', 'Previous Project', get_option('londres_prev_single_proj')) )); 
								next_post_link( '<div class="nav-next-nav1">%link</div>', sprintf(esc_html__("%s", "londres"), icl_t( 'londres', 'Next Project', get_option('londres_next_single_proj')) )); 
							} else {
								previous_post_link( '<div class="nav-previous-nav1">%link</div>', sprintf(esc_html__("%s","londres"), get_option("londres_prev_single_proj") )); 
								next_post_link( '<div class="nav-next-nav1">%link</div>', sprintf(esc_html__("%s", "londres"), get_option("londres_next_single_proj") )); 
							}
						?>
					</div>
					
					
					<div class="the_comments">
					    <?php if (comments_open()) {
						  	remove_action('comment_form','wp_comment_form_unfiltered_html_nonce');
						  	comments_template( '', true ); 
					    }
					    ?>
				    </div>
					<?php
				}
			?>

		</article>
		
		
		
			
		<?php
			
		if (!isset($londres_inline_script)) $londres_inline_script = '';
		$londres_inline_script .= '
			jQuery(document).ready(function(){
				"use strict";
		';
		//image
		if (get_post_meta($londres_thisPostID, "portfolioType_value", true) == "image"){
			if (get_post_meta($londres_thisPostID, "custom_slider_opts_value", true) == "on"){
				$animation = get_post_meta($londres_thisPostID, "projs_flex_transition_value", true);
				$directionNav = get_post_meta($londres_thisPostID, "projs_flex_navigation_value", true);
				$slideshowSpeed = get_post_meta($londres_thisPostID, "projs_flex_slide_duration_value", true) != "" ? get_post_meta($londres_thisPostID, "projs_flex_slide_duration_value", true) : 3000;
				$pauseOnHover = get_post_meta($londres_thisPostID, "projs_flex_pause_hover_value", true);
				$controlNav = get_post_meta($londres_thisPostID, "projs_flex_controls_value", true);
				$slideshow = get_post_meta($londres_thisPostID, "projs_flex_autoplay_value", true);
				$height = get_post_meta($londres_thisPostID, "projs_flex_height_value", true);
				$animationDuration = get_post_meta($londres_thisPostID, "projs_flex_transition_duration_value", true) != "" ? get_post_meta($londres_thisPostID, "projs_flex_transition_duration_value", true) : 1000;
			} else {
				$animation = get_option("londres_projs_flex_transition");
				$directionNav = get_option("londres_projs_flex_navigation");
				$slideshowSpeed = get_option("londres_projs_flex_slide_duration") ? get_option("londres_projs_flex_slide_duration") : 3000;
				$pauseOnHover = get_option("londres_projs_flex_pause_hover");
				$controlNav = get_option("londres_projs_flex_controls");
				$slideshow = get_option("londres_projs_flex_autoplay");
				$height = get_option("londres_projs_flex_height");
				$animationDuration = get_option("londres_projs_flex_transition_duration") ? get_option("londres_projs_flex_transition_duration") : 1000;
			}
			if ($directionNav == "on" || $directionNav == "true") $directionNav = true; else $directionNav = false;
			if ($pauseOnHover == "on" || $pauseOnHover == "true") $pauseOnHover = true; else $pauseOnHover = false;
			if ($controlNav == "on" || $controlNav == "true") $controlNav = true; else $controlNav = false;
			if ($slideshow == "on" || $slideshow == "true") $slideshow = true; else $slideshow = false;
			$londres_inline_script .= '
				if (jQuery("#p-slider-'.esc_js($londres_thisPostID).'").find("li").length > 1){
					jQuery("#p-slider-'.esc_js($londres_thisPostID).'").css("opacity",0).flexslider({
						animation: "'.esc_js($animation).'",
						slideDirection: "horizontal", 
						directionNav: "'.esc_js($directionNav).'",
						slideshowSpeed: '.esc_js($slideshowSpeed).',
						controlsContainer: "#p-slider-'.esc_js($londres_thisPostID).' .flex-viewport",
						pauseOnAction: false,
						pauseOnHover: "'.esc_js($pauseOnHover).'",
						keyboardNav: false,
						controlNav: "'.esc_js($controlNav).'",
						slideshow: "'.esc_js($slideshow).'",
						animationDuration: '.esc_js($animationDuration).',
						start: function(slider){
							jQuery(slider).find(".flex-direction-nav").css({"position":"absolute","width":"100%","top":"50%"});
							jQuery(window).resize();
							jQuery("#p-slider-'.esc_js($londres_thisPostID).'").css("opacity",1);
							if (typeof window.lastcube != "undefined" && typeof window.lastcube.resizeSinglePageInline == "function"){
								window.lastcube.resizeSinglePageInline();
							}
						},
						after:function(slider){
							if (typeof window.lastcube != "undefined" && typeof window.lastcube.resizeSinglePageInline == "function"){
								window.lastcube.resizeSinglePageInline();
							}
						}
					});
					jQuery("#p-slider-'.esc_js($londres_thisPostID).' ul.slides").css({"max-height":"'.esc_js($height).'"});
				} else {
					jQuery("#p-slider-'.esc_js($londres_thisPostID).'").find("ul li").css("display","block");
					jQuery("#p-slider-'.esc_js($londres_thisPostID).'").find("li a img").css("opacity",1);
					jQuery("#p-slider-'.esc_js($londres_thisPostID).'").find(".magnifier").on("click", function(){
						jQuery("#p-slider-'.esc_js($londres_thisPostID).'").find("li a").trigger("click");
					});
				}
			';
		}
		//video
		if (get_post_meta($londres_thisPostID, "portfolioType_value", true) == "video") {
			if (get_post_meta($londres_thisPostID, "videoSource_value", true) != "embed" && get_post_meta($londres_thisPostID, "videoSource_value", true) != "media"){
				$londres_inline_script .= '
					var aux_html = "<iframe src=\'"+jQuery(".v_links").eq(0).html()+"\' width=\'560\' height=\'349\' frameborder=\'0\' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
					jQuery("#the_movies").html(aux_html).fitVids();
				';
			}
			$londres_inline_script .= '
				if (jQuery("#the_movies").css({"position":"relative","float":"left","width":"100%"}).siblings(".v_links").length > 1){
	          		jQuery(".projects_media #the_movies").siblings(".movies-nav").remove();
	            	jQuery(".projects_media #the_movies").append("<ul class=\'flex-direction-nav movies-nav\'><li><a class=\'prev\' href=\'javascript:;\'>Previous</a></li><li><a class=\'next\' href=\'javascript:;\'>Next</a></li></ul>");
	          		jQuery(".projects_media #the_movies .flex-direction-nav").css({
		          		"position": "absolute",
		          		"width":"100%",
		          		"top":"50%",
	          		}).find("li").css({"margin":0,"padding":0}).find("a").css({"display":"inline-block","position":"relative","opacity":1});
			  		jQuery(".projects_media #the_movies .flex-direction-nav li").eq(0).css("float","left");
			  		jQuery(".projects_media #the_movies .flex-direction-nav li").eq(1).css("float","right");

	          		jQuery(".projects_media #the_movies").siblings(".current_movie").remove();
	          		jQuery(".projects_media #the_movies").after("<div hidden class=\'current_movie upper_hidden\'>0</div>");
	          		
	          		jQuery(".movies-nav").find(".prev").on("click",function(e){
	          			e.preventDefault();
	          			var index = parseInt(jQuery(".current_movie").html());
	          			var nextIndex = 0;
	          			if (index == 0) nextIndex = jQuery(".projects_media #the_movies").siblings(".v_links").length - 1;
	          			else nextIndex = index-1;
	          			jQuery("#the_movies iframe").attr("src", jQuery(".projects_media #the_movies").siblings(".v_links").eq(nextIndex).html() );
	          			jQuery(".projects_media #the_movies").siblings(".current_movie").html(nextIndex);
	          			
	          		});
	          		jQuery(".movies-nav").find(".next").on("click",function(e){
	          			e.preventDefault();
	          			var index = parseInt(jQuery(".current_movie").html());
	          			var nextIndex = 0;
	          			if (index == jQuery(".projects_media #the_movies").siblings(".v_links").length - 1) nextIndex = 0;
	          			else nextIndex = index+1;
	          			jQuery("#the_movies iframe").attr("src", jQuery(".projects_media #the_movies").siblings(".v_links").eq(nextIndex).html() );
	          			jQuery(".projects_media #the_movies").siblings(".current_movie").html(nextIndex);
	          		});
	          	}
			';
		}
		$londres_inline_script .= '
				if (!jQuery(".nav-previous-nav1").length){
					jQuery(".nav-previous-nav1").html("<a href=\'javascript:;\' rel=\'prev\' >l</a>");
				}
				if (!jQuery(".nav-next-nav1").length){
					jQuery(".nav-next-nav1").html("<a href=\'javascript:;\' rel=\'next\' >r</a>");
				}
				
				if (typeof window.lastcube != "undefined" && typeof window.lastcube.resizeSinglePageInline == "function"){
					window.lastcube.resizeSinglePageInline();
				}
				
			});
		';
		
		$londres_output = ".nav-previous-nav1 a, .nav-next-nav1 a{ color: rgb(102, 102, 102); opacity: 0.3; filter: alpha(opacity=30); }";
		londres_set_custom_inline_css($londres_output);
		
		wp_add_inline_script('londres-global', $londres_inline_script, 'after');
	} else {
		?>
		<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class('proj-content'); ?> role="article">
			<div class="content_container col-md-12">
				<?php 
					$content = get_the_content(get_the_ID());
					$content = apply_filters('the_content', $content); 
					londres_content_shortcoder($content);
					
					$content = wp_kses_no_null( $content, array( 'slash_zero' => 'keep' ) );
					$content = wp_kses_normalize_entities($content);
					echo wp_kses_hook($content, 'post', array()); // WP changed the order of these funcs and added args to wp_kses_hook
					
					$shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
					if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
						londres_set_custom_inline_css($shortcodes_custom_css);
					}
				?>
			</div>
			<?php
				if (get_option("londres_project_single_social_shares") == "on" && get_option('londres_project_single_socials') != ""){
				$proj_single_socials = explode(",",get_option('londres_project_single_socials'));
				?>
				<div class="share-buttons">
	                
		        	<h5><?php 
			        	if (function_exists('icl_t')){
				        	echo sprintf(esc_html__("%s","londres"), icl_t( 'londres', 'SHARE THIS PROJECT', get_option('londres_share_proj_text'))); 
			        	} else {
				        	echo sprintf(esc_html__("%s","londres"), get_option("londres_share_proj_text")); 
			        	}
			        ?></h5>
		            
					<!--  NEW STUFF -->
		            <div class="posts-shares">
		                <div class="social-shares clearfix">
					        <ul>
						        <?php
							        if (in_array("facebook", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php echo esc_url("https://www.facebook.com/sharer.php?u=".get_the_permalink()."&amp;t=".get_the_title()); ?>" class="share-facebook" target="_blank" ><i class="fa fa-facebook"></i><?php esc_html_e( '', 'londres' )?></a>
										</li>
								        <?php
							        }
							        if (in_array("twitter", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php echo esc_url("https://twitter.com/home?status=".get_the_title()."_".get_the_permalink()); ?>" class="share-twitter" target="_blank" ><i class="fa fa-twitter"></i><?php esc_html_e( '', 'londres' )?></a>
										</li>
								        <?php
							        }
							        if (in_array("linkedin", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php echo esc_url("https://linkedin.com/shareArticle?mini=true&amp;url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-linkedin" ><i class="fa fa-linkedin"></i><?php esc_html_e( '', 'londres' )?></a>
										</li>
								        <?php
							        }
							        if (in_array("googleplus", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php echo esc_url("https://google.com/bookmarks/mark?op=edit&amp;bkmk=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" class="share-google" ><i class="fa fa-google-plus"></i><?php esc_html_e( '', 'londres' )?></a>
										</li>
								        <?php
							        }
							        if (in_array("pinterest", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); echo esc_url("https://www.pinterest.com/pin/create/button/?url=".get_the_permalink()."&amp;media=".$url."&amp;") ?>" target="_blank" class="share-pinterest" ><i class="fa fa-pinterest"></i><?php esc_html_e( '', 'londres' )?></a>
										</li>
								        <?php
							        }
							        if (in_array("tumblr", $proj_single_socials)){
								        ?>
								        <li>
											<a href="<?php echo esc_url("https://www.tumblr.com/share/?url=".get_the_permalink()."&amp;title=".get_the_title()); ?>" target="_blank" ><i class="fa fa-tumblr"></i><?php esc_html_e( '', 'londres' )?></a>							
										</li>
								        <?php
							        }
							        if (in_array("email", $proj_single_socials)){
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
			?>
	             
	        
	        <div class="projects_nav1 container">
				<?php 
					if (function_exists('icl_t')){
						previous_post_link( '<div class="nav-previous-nav1">%link</div>', sprintf(esc_html__("%s","londres"), icl_t( 'londres', 'Previous Project', get_option('londres_prev_single_proj')) )); 
						next_post_link( '<div class="nav-next-nav1">%link</div>', sprintf(esc_html__("%s", "londres"), icl_t( 'londres', 'Next Project', get_option('londres_next_single_proj')) )); 
					} else {
						previous_post_link( '<div class="nav-previous-nav1">%link</div>', sprintf(esc_html__("%s","londres"), get_option("londres_prev_single_proj") )); 
						next_post_link( '<div class="nav-next-nav1">%link</div>', sprintf(esc_html__("%s", "londres"), get_option("londres_next_single_proj") )); 
					}
				?>
			</div>
			
			
			<div class="the_comments">
			    <?php if (comments_open()) {
				  	remove_action('comment_form','wp_comment_form_unfiltered_html_nonce');
				  	comments_template( '', true ); 
			    }
			    ?>
		    </div>
		</article>
	<?php
		if (!isset($londres_inline_script)) $londres_inline_script = '';
		$londres_inline_script .= '
			jQuery(document).ready(function(){
				"use strict";
				if (typeof window.lastcube != "undefined" && typeof window.lastcube.resizeSinglePageInline == "function"){
					setTimeout(function(){ window.lastcube.resizeSinglePageInline(); },1000);
				}
			});
		';
		wp_add_inline_script('londres-global', $londres_inline_script, 'after');
	}

	?>
	</div> <!-- endof master_container -->