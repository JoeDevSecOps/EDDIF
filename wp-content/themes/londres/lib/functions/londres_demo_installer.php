<?php
		
add_action ('wp_ajax_call_upper_demo_installer', 'upper_demo_installer') ;
function upper_demo_installer(){ 
	
	if (!isset($_POST)) wp_send_json_error('no direct access');
	if (!wp_verify_nonce($_POST['security'],'londres-theme-update-options')) return;
	if (!current_user_can( 'administrator' )) return;
	
	set_time_limit(0);
	ignore_user_abort(false);
	
	$demo = isset($_POST['demo']) ? $_POST['demo'] : "";
	$errors = false;
	
	$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
	
	if (!function_exists('WP_Filesystem')){
		$abspath = ($os === "win") ? "\\wp-admin\\includes\\file.php" : "/wp-admin/includes/file.php";
		require_once(ABSPATH.str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $abspath));
	}
	WP_Filesystem();
	
	global $wpdb, $current_user, $pagenow, $wp_filesystem, $table_prefix;
	$demosurl = "http://paulomoreira.org/demos/londres/";
	$londres_stylesheet = get_option('stylesheet') ? get_option('stylesheet') : "londres";
	
	$output = "";
	
	switch($_POST['upper_action']){
		
		case 'dbreset': 
			/* reset database */
			try {
				
				$londressiteurl = get_option('siteurl');
				$londreshome = home_url('/');
				
				require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

				// Grab the WordPress database tables
				$db_tables = $wpdb->tables();

				// Get current options
				$blog_title = get_option('blogname');
				$public = get_option('blog_public');

				$admin_user = get_user_by('login', 'admin');
				$user = ( ! $admin_user || ! user_can($admin_user->ID, 'update_core') ) ? $current_user : $admin_user;

				// Run through the database columns, drop all the tables and
				// install wp with previous settings
				if ( $db_tables = $wpdb->get_col("SHOW TABLES LIKE '{$wpdb->prefix}%'") ) {
					foreach ($db_tables as $db_table) {
						$wpdb->query("DROP TABLE {$db_table}");
					}
					
					$keys = wp_install($blog_title, $user->user_login, $user->user_email, $public);
					
					$keys['url'] = $londressiteurl;
											
					londres_wp_update_user($user, $keys);
				}

				switch_theme( $londres_stylesheet );
				
				update_option('siteurl',$londressiteurl);
				update_option('home',$londreshome);
				
			} catch (Exception $e) {
				$errors = $e->getMessage();
			}	
			echo json_encode($errors);
		break;
		
		case 'fake-dbreset': 
			try {
				
				$londressiteurl = get_option('siteurl');
				$londreshome = home_url('/');
				
				require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

				// Get current options
				$blog_title = get_option('blogname');
				$public = get_option('blog_public');

				$admin_user = get_user_by('login', 'admin');
				$user = ( ! $admin_user || ! user_can($admin_user->ID, 'update_core') ) ? $current_user : $admin_user;

				switch_theme( $londres_stylesheet );
				
				update_option('siteurl',$londressiteurl);
				update_option('home', $londreshome);
				
			} catch (Exception $e) {
				$errors = $e->getMessage();
			}
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
		
		case 'install_plugins':
			try{
				$plugins_url = "http://paulomoreira.org/plugins/londres/";
				$plugins = array(
					array('name' => 'londres_custom_post_types', 'path' => $plugins_url . 'londres_custom_post_types.zip', 'install' => 'londres_custom_post_types/londres_custom_post_types.php'),
					
					array('name' => 'widget-importer-exporter', 'path' => 'https://downloads.wordpress.org/plugin/widget-importer-exporter.1.6.zip', 'install' => 'widget-importer-exporter/widget-importer-exporter.php'),
					array('name' => 'contact-form-7', 'path' => 'https://downloads.wordpress.org/plugin/contact-form-7.5.4.2.zip', 'install' => 'contact-form-7/wp-contact-form-7.php'),
					array('name' => 'really-simple-captcha', 'path' => 'https://downloads.wordpress.org/plugin/really-simple-captcha.2.1.zip', 'install' => 'really-simple-captcha/really-simple-captcha.php'),
					array('name' => 'classic-widgets', 'path' => 'https://downloads.wordpress.org/plugin/classic-widgets.0.2.zip', 'install' => 'classic-widgets/classic-widgets.php'),
					array('name' => 'classic-editor', 'path' => 'https://downloads.wordpress.org/plugin/classic-editor.1.6.2.zip', 'install' => 'classic-editor/classic-editor.php'),
					
					array('name' => 'masterslider', 'path' => $plugins_url . 'masterslider.zip', 'install' => 'masterslider/masterslider.php'),
					array('name' => 'revslider', 'path' => $plugins_url . 'revslider.zip', 'install' => 'revslider/revslider.php'),
					array('name' => 'js_composer', 'path'=> $plugins_url . 'js_composer.zip', 'install' => 'js_composer/js_composer.php'),
					array('name' => 'Ultimate_VC_Addons', 'path'=> $plugins_url . 'Ultimate_VC_Addons.zip', 'install' => 'Ultimate_VC_Addons/Ultimate_VC_Addons.php'),
					array('name' => 'cubeportfolio', 'path'=> $plugins_url . 'cubeportfolio.zip', 'install' => 'cubeportfolio/cubeportfolio.php')

				);
				$plgs = londres_get_plugins($plugins);
			} catch (Exception $e){
				$errors = $e->getMessage();
			}
			flush();
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
		
		case 'load_settings':
			if (isset($_POST['xmlPath'])){
				$xml = false;
				$xml = $wp_filesystem->get_contents($_POST['xmlPath']);
				if (!$xml) $xml = wp_remote_fopen($_POST['xmlPath']);
				if ($xml != false){
					$contents = json_decode(json_encode((array)simplexml_load_string($xml)),1);
					foreach($contents['option'] as $opt){
						if ($opt['id'] == 'ultimate_selected_google_fonts' && is_string($opt['value']) && $opt['value'] != ""){
							update_option($opt['id'], unserialize(stripslashes($opt['value'])),true);
						} else {
							if ($opt['id'] == 'page_on_front'){
								update_option('show_on_front','page', true);
								update_option('page_on_front', $opt['value'], true);
							}
							update_option($opt['id'], $opt['value'], true);
						}
					}
				} else {
					if (!is_string($errors)) $errors = "";
					$errors .= "sumwong";
				}
			}
			
			if (isset($_POST['xmlStylePath'])) {
				$xml = false;
				$xml = $wp_filesystem->get_contents($_POST['xmlStylePath']);
				if (!$xml) $xml = wp_remote_fopen($_POST['xmlStylePath']);
				if ( $xml != false ) {
					$contents = json_decode( json_encode( (array) simplexml_load_string( $xml ) ), 1 );
					foreach ( $contents['option'] as $opt ) {
						update_option( $opt['id'], $opt['value'], true );
					}
				} else {
					if (!is_string($errors)) $errors = "";
					$errors .= "sumwong";
				}
			}
			flush();
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
		
		case 'import_content_set_options':
			ob_start();
			try{
				require_once( ABSPATH . '/wp-admin/includes/media.php' );
				// import content
				londres_autoimport($demosurl, $demo);
				
				// set the menu
				// usar qq cena tipo nome do demo, seria o ideal. até pode ser sempre o mmo slug, mais fácil, menos código.
				$menuslug = "primary-navigation";
				$menu_id = $wpdb->get_results( $wpdb->prepare("SELECT term_id from $wpdb->terms WHERE slug LIKE %s", $menuslug), OBJECT );
				$mods['nav_menu_locations']['PrimaryNavigation'] = $menu_id[0]->term_id;
				
				//top bar menu
				$tbmenuslug = "top-bar-menu";
				$tbmenu_id = $wpdb->get_results( $wpdb->prepare("SELECT term_id FROM $wpdb->terms WHERE slug LIKE %s", $tbmenuslug), OBJECT ); 
				if (isset($tbmenu_id[0])) $mods['nav_menu_locations']['topbarnav'] = $tbmenu_id[0]->term_id;

				update_option("theme_mods_".$londres_stylesheet, $mods);
				update_option("mods_londres", $mods);
				
				ob_end_clean();
				
			} catch (Exception $e){
				$errors_flush = $e->getMessage();
			}
			ob_end_clean();
			flush();
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
		
		case 'import_widgets':
			$filename = "widgets.wie";
			ob_start();
			londres_wie_process_import_file($demosurl . $demo . "/" . $filename);
			ob_end_clean();
			if ( !defined('RS_PLUGIN_PATH') ) londres_plugin_activate('revslider/revslider.php');
			flush();
			ob_flush();
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
		
		case 'complete-installation':
			// import revsliders instances. this is a new version of the revslider. need to check the new method.
			//rev
			try{
				if (function_exists('londres_add_increase_time')) londres_add_increase_time();
				
				$dir = "http://paulomoreira.org/demos/londres/" . $_POST['upper_demo'] . "/revdemos/";
				
				//get the zips
				$zips = $matches = array();
				$revlist = $dir."revlist.txt";
			
				$thefile = $wp_filesystem->get_contents($revlist);
				if (!$thefile) $thefile = wp_remote_fopen($revlist);
			
				if ($thefile != ""){
					$revs = explode(",", $thefile);
					foreach ($revs as $rev){
						$zips[] = str_replace(" ", "", $dir).$rev;
					}
					
					require_once( ABSPATH . '/wp-content/plugins/revslider/revslider.php' );
					$rs = new RevSlider();
					$errors = false;
				
					foreach($zips as $zip){
						if ($zip != ""){
							$slug = explode("/",$zip);
							$slug = str_replace(".zip","",$slug[count($slug)-1]);
							
							if (!londres_add_imported_id( $slug, true )) continue;
							
							$uploads = wp_upload_dir();
							$newfile = $uploads['basedir']."/".$slug.".zip";
							$filecopy = $wp_filesystem->get_contents($zip);
							if (!$filecopy) $filecopy = wp_remote_fopen($zip);
							$copy = $wp_filesystem->put_contents( $newfile, $filecopy, FS_CHMOD_FILE );
							ob_start();
							$response = $rs->importSliderFromPost(true, true, $newfile); 
							if (!$response['success']) $errors = true;
							ob_end_clean();
						}
					}
				}
			
				//cubes.
				if ($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."cubeportfolio"."'") != $wpdb->prefix."cubeportfolio"){
					$charset_collate = ( ( !empty($wpdb->charset) )? ' DEFAULT CHARACTER SET ' . $wpdb->charset : '' ) .
		                               ( ( !empty($wpdb->collate) )? ' COLLATE ' . $wpdb->collate : '');
					$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."cubeportfolio"." (
		                        id              INT(10)       UNSIGNED AUTO_INCREMENT NOT NULL,
		                        active          TINYINT(1)    UNSIGNED NOT NULL DEFAULT %d,
		                        name            VARCHAR(255)  NOT NULL,
		                        type            VARCHAR(255)  NOT NULL,
		                        customcss       TEXT          NOT NULL,
		                        options         TEXT          NOT NULL,
		                        loadMorehtml    TEXT,
		                        template        TEXT,
		                        filtershtml     TEXT,
		                        googlefonts     TEXT,
		                        popup           MEDIUMTEXT,
		                        jsondata        MEDIUMTEXT,
		                        PRIMARY KEY (id),
		                        INDEX(active)
		                    ){$charset_collate};";
		            $wpdb->query($wpdb->prepare($sql, 1));
		            $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."cubeportfolio_items"." (
		                        id                INT(10)       UNSIGNED AUTO_INCREMENT NOT NULL,
		                        cubeportfolio_id  INT(10)       UNSIGNED NOT NULL,
		                        sort              TINYINT(1)    UNSIGNED NOT NULL DEFAULT %d,
		                        page              TINYINT(2)    UNSIGNED NOT NULL,
		                        items             TEXT          NOT NULL,
		                        isLoadMore        TEXT,
		                        isSinglePage      TEXT,
		                        PRIMARY KEY(id),
		                        INDEX(cubeportfolio_id)
		                    ){$charset_collate};";
		             $wpdb->query($wpdb->prepare($sql, 1));
				}
			
				$cubefp = "http://paulomoreira.org/demos/londres/" . $_POST['upper_demo'] . "/cubeportfolio.json";
				
				global $encode_data;
				$encode_data = $wp_filesystem->get_contents($cubefp);
				if (!$encode_data) $encode_data = wp_remote_fopen($cubefp);
				if ($encode_data != ""){
					require_once( ABSPATH . '/wp-content/plugins/cubeportfolio/php/des_CubePortfolioImport.php' );
					$cubeimport = new des_CubePortfolioImport($encode_data);
				}
				
				//MASTERS
				$mastersfp = "http://paulomoreira.org/demos/londres/" . $_POST['upper_demo'] . "/masterslider.json";
				global $master_encode_data;
				$master_encode_data = $wp_filesystem->get_contents($mastersfp);
				if (!$master_encode_data) $master_encode_data = wp_remote_fopen($mastersfp);
				
				if ($master_encode_data){
					if (!class_exists('MSP_Importer')){
						if (file_exists(ABSPATH . '/wp-content/plugins/masterslider/admin/includes/classes/class-msp-importer.php')){
							include ABSPATH . '/wp-content/plugins/masterslider/admin/includes/classes/class-msp-importer.php';
						}
					}
					$msp_importer = new MSP_Importer();
					ob_start();
					$msp_importer->import_data($master_encode_data);
					ob_end_clean();
				}
				
			} catch(Exception $e){
				$errors_flush = $e->getMessage();
			}
			flush();
			ob_flush();
			sleep(1);
			wp_send_json_success( $errors, 200 );
		break;
	}
}

/* helper functions */

function londres_wie_process_import_file( $file ) {
	WP_Filesystem();
	global $wie_import_results, $wp_filesystem;
	$data = false;
	$data = $wp_filesystem->get_contents($file);
	if (!$data) $data = wp_remote_fopen($file);
	// Make results available for display on import/export page
	if ($data){
		ob_start();
		londres_wie_import_data( $data );
		ob_end_clean();		
	}
}

function londres_wie_available_widgets() {

	global $wp_registered_widget_controls;

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes
			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];
		}
		
	}
	return $available_widgets;
}

function londres_wie_import_data( $data ) {

	global $wp_registered_sidebars;
	$available_widgets = londres_wie_available_widgets();
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}
	$results = array();
	if (is_string($data)) $data = json_decode($data);
	foreach ( $data as $sidebar_id => $widgets ) {
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}
		$sidebar_available = true;
		$use_sidebar_id = $sidebar_id;
		$sidebar_message_type = 'success';
		$sidebar_message = '';
		
		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {
			$fail = false;
			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = esc_html__( 'Site does not support widget', 'londres' ); // explain why widget not imported
			}

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {

					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = esc_html__( 'Widget already exists', 'londres' ); // explain why widget not imported

						break;

					}
	
				}

			}
			// No failure
			if ( ! $fail ) {

				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = (array) $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = esc_html__( 'Imported', 'londres' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = esc_html__( 'Imported to Inactive', 'londres' );
				}

			}

			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : esc_html__( 'No Title', 'londres' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		}

	}

}


/**
 * Updates the user password and clears / sets 
 * the authentication cookie for the user
 *
 * @access private
 * @param $user Current or admin user
 * @param $keys Array returned by wp_install()
 * @return true on install success, false otherwise
 */
function londres_wp_update_user($user, $keys) {
	global $wpdb;			
	extract($keys, EXTR_SKIP);

	$query = $wpdb->prepare("UPDATE $wpdb->users SET user_pass = '%s', user_activation_key = '' WHERE ID = '%d'", $user->user_pass, $user_id);
	
	if ( $wpdb->query($query) ) {
		// Remove password reminder after installing
		if ( get_user_meta($user_id, 'default_password_nag') ) delete_user_meta($user_id, 'default_password_nag');

		wp_clear_auth_cookie();
		wp_set_auth_cookie($user_id);
		
		return true;
	}			
	return false;
}


/* plugins stuff */


function londres_get_plugins($plugins){
	$args = array(
		'path' => ABSPATH.'wp-content/plugins/',
		'preserve_zip' => false
	);
	$output = array();
	foreach($plugins as $plugin){
		/* without the if, plugins gets updated from the zip each demo install */
		londres_plugin_download($plugin['path'], $args['path'].$plugin['name'].'.zip');
		londres_plugin_unpack($args, $args['path'].$plugin['name'].'.zip');
		/* leave revslider for later. */
		if ($plugin['name'] != "revslider") {
			$output[] = $plugin;
			londres_plugin_activate($plugin['install']);
		}
	}
	return $output;
}

function londres_plugin_download($url, $path){
	global $wp_filesystem;
	$data = $result = false;
	$data = $wp_filesystem->get_contents($url);
	if (!$data) $data = wp_remote_fopen($url);
	if ($data){
		$result = $wp_filesystem->put_contents($path, $data, FS_CHMOD_FILE);
	}
	
	return $result;
}

function londres_plugin_unpack($args, $target){
	global $wp_filesystem;
	if ($zip = zip_open($target)){
		if (is_resource($zip)){
			while ($entry = zip_read($zip)){
				$is_file = substr(zip_entry_name($entry), -1) == '/' ? false : true;
				$file_path = $args['path'].zip_entry_name($entry);
				if ($is_file){
					if (zip_entry_open($zip,$entry,"r")) {
						$fstream = zip_entry_read($entry, zip_entry_filesize($entry));
						$wp_filesystem->put_contents($file_path, $fstream, FS_CHMOD_FILE);
					}
					zip_entry_close($entry);
				} else {
					if (zip_entry_name($entry)){
						if (!is_dir($file_path)) wp_mkdir_p($file_path);
					}
				}
			}
			zip_close($zip);
		}
	}
	if ($args['preserve_zip'] === false){
		if (file_exists($target)) unlink($target);
	}
}

function londres_plugin_activate($installer){
	$current = get_option('active_plugins');
	$plugin = plugin_basename(trim($installer));
	
	if (!in_array($plugin, $current)) {
		$current[] = $plugin;
		sort($current);
		do_action('activate_plugin', trim($plugin));
		update_option('active_plugins', $current);
		do_action('activate_'.trim($plugin));
		do_action('activated_plugin', trim($plugin));
		return true;
	}
	else return false;
}

/* endof plugins stuff */



/* end of helper functions */

?>