<?php
/**
 * Custom pages - this file contains ana manages the main functionality that is related
 * with custom pages. Custom pages are pages that allow adding items from selected post types.
 * The items data(fields) that should be added is set within an array and the custom pages
 * structure is built depending on the data set in that array.
 */

add_action('admin_menu', 'londres_add_custom_pages');
add_action('wp_ajax_londres_insert_post', 'londres_insert_post');
add_action('wp_ajax_londres_add_instance', 'londres_add_instance');
add_action('wp_ajax_londres_save_order', 'londres_save_order');
add_action('wp_ajax_londres_detele_item', 'londres_detele_item');
add_action('wp_ajax_londres_edit_item', 'londres_edit_item');
add_action('wp_ajax_londres_detele_instance', 'londres_detele_instance');



//define the main constants that will be used
define("LONDRES_CUSTOM_PREFIX", 'custom_');
define("LONDRES_DEFAULT_TERM", 'default');
define("LONDRES_TERM_SUFFIX", '_category');
define("LONDRES_NONCE", 'londres-custom-page');

$londres_data->custom_pages=array();
/**
 * Adds all the custom pages to the menu.
 */
function londres_add_custom_pages(){
	global $londres_data;

	foreach($londres_data->custom_pages as $page){
		$portfolio_permalink = get_option("londres_portfolio_permalink");
		add_theme_page( 'edit.php?post_type='.$portfolio_permalink, $page->page_name, 'delete_pages', $page->post_type, 'londres_build_custom_page' );		
	}
}


function londres_get_created_camera_sliders(){
	$londres_slider_data=array();
	global $wpdb;
	
	/* rev sliders */
	$table_name = $wpdb->prefix."revslider_sliders";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	    //table is not created. plugin is yet to install.
		$londres_slider_data = array(array('id'=>'no_slider','name'=>'No Sliders Found.'));
	} else {
		$q = "SELECT * from {$table_name} WHERE %d";
		$revs = $wpdb->get_results( $wpdb->prepare($q,1), ARRAY_A);
		
		$revsliders = array();
		if ( $revs ) {
			foreach($revs as $r) {
				array_push($revsliders, array('id'=>"revSlider_".$r['alias'], 'name'=>$r['title']));	
			}
		}
		
		if (count($revsliders)>0){
			array_unshift($revsliders,array('id'=>'-1','name'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--- Revolution Sliders ---&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'));
			$londres_slider_data = array_merge($londres_slider_data,$revsliders);
		} else {
			$londres_slider_data = array(array('id'=>'no_slider','name'=>'No Sliders Found.'));
		}
	}
	
	
	/* master sliders */
	$table_name = $wpdb->prefix."masterslider_sliders";
	if($wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE %s", $table_name) ) != $table_name) {
	    //table is not created. plugin is yet to install.
	} else {
		$sliders = true;
		$q = "SELECT * from {$table_name} WHERE %d";
		$masters = $wpdb->get_results( $wpdb->prepare($q,1), ARRAY_A);
		$mastersliders = array();
		if ( $masters ) {
			foreach($masters as $m) {
				array_push($mastersliders, array('id'=>"masterSlider_".$m['alias'], 'name'=>$m['title']));
			}
		}
		if (count($mastersliders)>0){
			array_unshift($mastersliders,array('id'=>'-1','name'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--- MasterSlider Sliders ---&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'));
			$londres_slider_data = array_merge($londres_slider_data,$mastersliders);
		}
	}

	if (count($londres_slider_data) < 1) $londres_slider_data = array(array('id'=>'no_slider','name'=>'No Sliders Found.'));
	return $londres_slider_data;
}



/**
 * Builds a custom page - when the page is opened, an object from a manager class builds the page structure.
 */
function londres_build_custom_page(){
	if(isset($_GET['page'])){
		global $londres_data;

		$pageid=$_GET['page'];
		$custom_page=$londres_data->custom_pages[$pageid];
		$custom_page_manager=new LondresCustomPageManager($custom_page, LONDRES_CUSTOM_PREFIX, LONDRES_TERM_SUFFIX, LONDRES_DEFAULT_TERM, LONDRES_NONCE);
		$custom_page_manager->build_page();
	}

}

/**
 * Inserts a post - this is the function that is called via AJAX request, when
 * a new custom post should be inserted.
 */
function londres_insert_post(){
	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	global $londres_data, $current_user;

	$post_type=$_POST['post_type'];
	$custom_page=$londres_data->custom_pages[$post_type];

	//insert the post
	$dataManager=new LondresCustomDataManager();
	$post=$dataManager->insert_post($_POST, $custom_page, LONDRES_CUSTOM_PREFIX, LONDRES_TERM_SUFFIX);

	//get the display template for the inserted post
	$templater=new LondresTemplater();
	echo wp_kses_post($templater->get_custom_page_list_template($post, $custom_page, LONDRES_CUSTOM_PREFIX));
	die();

}

/**
 * Creates a new instance of a custom page item - it is related with inserting a new
 * category from the selected custom post type.
 */
function londres_add_instance(){

	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	global $londres_data;

	//insert a new category(term) for the custom post type
	$res=wp_insert_term( $_POST['name'], $_POST['taxonomy']);
	$custom_page=$londres_data->custom_pages[$_POST['post_type']];

	if($res instanceof WP_Error){
		$html='-1';
	}else{
		$templater=new LondresTemplater();
		$html=$templater->get_before_custom_section($_POST['name']);
		$html.=$templater->get_custom_page_form_template($_POST['name'], $res['term_id'], $custom_page, LONDRES_CUSTOM_PREFIX);
		$html.='<ul class="sortable"></ul>'.$templater->get_after_custom_section();
	}

	echo wp_kses_post($html);
	die();

}

/**
 * Saves the new order of the items - should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - order - the new order to be saved (as a string, separated by commas)
 * - category - the category the items to be ordered belong to
 */
function londres_save_order(){
	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	if(isset($_POST['order'])&& $_POST['order'] && isset($_POST['category']) && $_POST['category'] && isset($_POST['posttype'])){
			update_option('londres_order'.$_POST['category'].$_POST['posttype'], $_POST['order']);
	}
}

/**
 * Creates an ordered post list - gets the unordered posts and the order string
 * saved as option that corresponds to those post group.
 * @param $posts the posts to be ordered
 * @param $category the category the posts belong to
 * @return an array of the posts that ordered according to the saved order
 */
function londres_get_ordered_post_list($posts, $category, $posttype){
	$new_post_array=array();

	$order=explode(',',get_option('londres_order'.$category.$posttype));
	if(sizeof($order)!=sizeof($posts)){
		return $posts;
	}else{
		//make the post array key the ID of the post so that it can be accessed by ID
		foreach($posts as $post){
			$new_post_array[$post->ID]=$post;
		}
			
		foreach($order as $index){
			$ordered_post_array[]=$new_post_array[$index];
		}
	}

	return $ordered_post_array;
}

/**
 * Deletes an item and changes the saved item order not to contain this item. Should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - itemid - the ID of the item to be deleted
 * - category - the category the item belongs to
 */
function londres_detele_item(){
	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	if(isset($_POST['itemid']) && isset($_POST['category']) && isset($_POST['posttype'])){
		$res=wp_delete_post($_POST['itemid']);
		if($res){
			//the item has been deleted successfully, update the new order value
			$order_option='londres_order'.$_POST['category'].$_POST['posttype'];
			$order_arr=explode(',',get_option($order_option));
			$new_order=londres_remove_item_by_value($order_arr,$_POST['itemid']);
			update_option($order_option, implode(',',$new_order));
		}else{
			echo '-1';
			die();
		}
	}
}

/**
 * Edits an item - Should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - itemid - the ID of the item to be edited
 */
function londres_edit_item(){
	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	if(isset($_POST['itemid'])&& $_POST['itemid']){
		$dataManager=new LondresCustomDataManager();
		$post=$dataManager->edit_post($_POST, LONDRES_CUSTOM_PREFIX);
	}
}

/**
 * Deletes a group of items with their parent instance. Should be called via AJAX request, 
 * the following parameters should be set in the request:
 * - category - the category (term name) the slider represents
 * - taxonomy - the taxonomy name
 * - post_type - the type of the posts the slider contains
 */
function londres_detele_instance(){
	//check the nonce field for security
	check_ajax_referer(LONDRES_NONCE, 'nonce');

	if(isset($_POST['category'])&& isset($_POST['taxonomy'])){
		$dataManager=new LondresCustomDataManager();
		$dataManager->delete_term($_POST['category'],$_POST['taxonomy'],$_POST['post_type']);
	}
}
