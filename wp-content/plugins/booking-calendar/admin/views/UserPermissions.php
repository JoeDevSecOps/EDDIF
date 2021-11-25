<?php
class wpdevart_bc_ViewUserpermissions {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
    public function display_permissions() {
		$pages_rows = $this->model_obj->get_pages_permissions();
		$pages_rows = json_decode($pages_rows,true);
		
        $wpdevart_pages = array(
			'calendar_page' => array(
				'id'   => 'calendar_page',
				'title' => __('Calendars','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			),
			'calendar_page_accs' => array(
				'id'   => 'calendar_page_accs',
				'title' => __('Can edit other users calendars','booking-calendar'),
				'description' => '',
				'type' => 'checkbox',
				'pro' => 'pro',
				'default' => ''
			),
			'reservation_page' => array(
				'id'   => 'reservation_page',
				'title' => __('Reservations','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			),
			'form_page' => array(
				'id'   => 'form_page',
				'title' => __('Forms','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			),
			'form_page_accs' => array(
				'id'   => 'form_page_accs',
				'title' => __('Can edit other users forms','booking-calendar'),
				'description' => '',
				'type' => 'checkbox',
				'pro' => 'pro',
				'default' => ''
			),
			'extra_page' => array(
				'id'   => 'extra_page',
				'title' => __('Extras','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			),
			'extra_page_accs' => array(
				'id'   => 'extra_page_accs',
				'title' => __('Can edit other users extras','booking-calendar'),
				'description' => '',
				'type' => 'checkbox',
				'pro' => 'pro',
				'default' => ''
			),
			'theme_page' => array(
				'id'   => 'theme_page',
				'title' => __('Themes','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			),
			'theme_page_accs' => array(
				'id'   => 'theme_page_accs',
				'title' => __('Can edit other users themes','booking-calendar'),
				'description' => '',
				'type' => 'checkbox',
				'pro' => 'pro',
				'default' => ''
			),
			'global_settings_page' => array(
				'id'   => 'global_settings_page',
				'title' => __('Global Settings','booking-calendar'),
				'description' => '',
				'valid_options' => $this->get_users(),
				'type' => 'select',
				'pro' => 'pro',
				'default' => 'publish_pages'
			)
		);
		?>
		<div id="wpdevart_themes" class="wpdevart-list-container user-permissions">
			<div id="action-buttons" class="div-for-clear">
				<div class="div-for-clear">
					<h1><?php _e('User permissions for booking calendar pages','booking-calendar'); ?> </h1>
				</div>
			</div>	
			<form action="admin.php?page=wpdevart-user-permissions" method="post" id="calendars_form">
			    <div class="wpdevart-item-section"> 
					<div class="wpdevart-item-section-cont">
					<?php
						foreach( $wpdevart_pages as $key => $wpdevart_page ) { 
							if ( !isset($pages_rows) ) {
								$sett_value = $wpdevart_page['default'];
							} else {
								$sett_value = isset($pages_rows[$key]) ? $pages_rows[$key] : "";
							}
							$function_name = "wpdevart_callback_" . $wpdevart_page['type'];
							wpdevart_bc_Library::$function_name($wpdevart_page, $sett_value);
						} ?>
					</div>	
				</div>
				<input type="hidden" name="task" value="save">
				<input type="submit" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save">
			</form>
		</div>
    <?php 
	}
	 private function get_users(){
		$users_role = get_option("wp_user_roles");
		$users = array(   
		    "manage_options" => __("Administrator",'booking-calendar'),
			"publish_pages" => __("Editor",'booking-calendar'), 	
			"publish_posts" => __("Author",'booking-calendar'), 
		    "edit_posts" => __("Contributor",'booking-calendar'),
		    "read" => __("Subscriber",'booking-calendar')
		); 
		$user_arr = array("administrator","editor","author","contributor","subscriber");
		if($users_role && is_array($users_role)){
			foreach($users_role as $key=>$user){
				if(!in_array($key, $user_arr)){
					$users[$key] = $user["name"];
				}
			}
		}
		return  $users;
	 }
 
}

?>