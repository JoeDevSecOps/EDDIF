<?php get_header(); londres_print_menu(); $londres_color_code = get_option("londres_style_color"); ?>

	<div class="container">
		<div class="entry-header">
			<div class="error-c">
				<img src="<?php echo esc_url(get_template_directory_uri() . "/images/error.png");?>" title="404"/>
				<br>
				<h1 class="heading-error"><?php
					if (function_exists('icl_t')){
						wp_kses_post(printf(esc_html__( "%s", "londres" ), stripslashes_from_strings_only(icl_t( 'londres', 'Oops! There is nothing here...', get_option('londres_404_heading')))));
					} else {
						wp_kses_post(printf(esc_html__( "%s", "londres" ), stripslashes_from_strings_only(get_option('londres_404_heading'))));
					}
				?></h1>
							
				<p class="text-error"><?php
					if (function_exists('icl_t')){
						wp_kses_post(printf(esc_html__( "%s", "londres" ), stripslashes_from_strings_only(icl_t( 'londres', "It seems we can't find what you're looking for. Perhaps searching one of the links in the above menu, can help.", get_option('londres_404_text')))));
					} else {
						wp_kses_post(printf(esc_html__( "%s", "londres" ), stripslashes_from_strings_only(get_option('londres_404_text'))));
					}
				?></p>
				
				<a href="<?php echo esc_url(home_url("/")); ?>" class="errorbutton"><?php
					if (function_exists('icl_t')){
						printf(esc_html__("%s","londres"), icl_t( 'londres', 'GO TO HOMEPAGE', get_option('londres_404_button_text')));
					} else {
						printf(esc_html__("%s","londres"), get_option('londres_404_button_text'));
					}
				?></a>
			</div>
			
		</div>
	</div>
	
<?php londres_get_custom_inline_css(); wp_footer(); ?>