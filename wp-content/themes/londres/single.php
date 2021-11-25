<?php
/**
 * @package WordPress
 * @subpackage Londres
 */

get_header(); londres_print_menu(); ?>
	
	<?php 
		if (have_posts()) {
			the_post(); 
			$londres_type = get_post_type();
			$londres_portfolio_permalink = get_option("londres_portfolio_permalink");
			switch ($londres_type){
				case "post":
					get_template_part('post-single', 'single');
				break;
				case $londres_portfolio_permalink:
					get_template_part('proj-single', 'single');
				break;
				default:
					the_content();
				break;
			}
		}
	?>
	
<?php get_footer(); ?>