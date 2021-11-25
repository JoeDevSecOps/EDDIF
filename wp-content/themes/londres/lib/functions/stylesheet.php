<?php
function londres_styles(){

	 if (!is_admin()){
		
		wp_enqueue_style('londres-blog', LONDRES_CSS_PATH .'blog.css'); 
	 	wp_enqueue_style('londres-bootstrap', LONDRES_CSS_PATH .'bootstrap.css');
		wp_enqueue_style('londres-icons', LONDRES_CSS_PATH .'icons-font.css');
		wp_enqueue_style('londres-component', LONDRES_CSS_PATH .'component.css');
		
		wp_enqueue_style('londres-IE', LONDRES_CSS_PATH .'IE.css');	
		wp_style_add_data('londres-IE','conditional','lt IE 9');
		
		wp_enqueue_style('londres-editor', get_template_directory_uri().'/editor-style.css');
		wp_enqueue_style('londres-woo-layout', LONDRES_CSS_PATH .'londres-woo-layout.css');
		wp_enqueue_style('londres-woo', LONDRES_CSS_PATH .'londres-woocommerce.css');
		wp_enqueue_style('londres-ytp', LONDRES_CSS_PATH .'mb.YTPlayer.css');
		wp_enqueue_style('londres-retina', LONDRES_CSS_PATH .'retina.css');
		
		
	}
}
add_action('wp_enqueue_scripts', 'londres_styles', 1);

?>