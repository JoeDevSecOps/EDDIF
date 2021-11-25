<?php
class wpdevart_bc_ControllerUserpermissions {
	private $model;
	private $view;
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/UserPermissions.php");
		$this->model = new wpdevart_bc_ModelUserpermissions();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/UserPermissions.php");
		$this->view = new wpdevart_bc_ViewUserpermissions($this->model);
	}  	
	  
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		$action = wpdevart_bc_Library::get_value('action');
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_permissions();
		}
	}
	  
	  
	private function display_permissions(){
		$this->view->display_permissions();
	}
	  	  
	private function save( $id ){
		$saved_parametrs = array();
		foreach($_POST as $post_mein_key => $post_mein_value){
			if(!is_array($post_mein_value)){					
				$saved_parametrs[sanitize_key($post_mein_key)] = sanitize_text_field(stripslashes($post_mein_value));
			} else{
				foreach($post_mein_value as $post_items_key => $post_items_value){
					$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)]=sanitize_text_field(stripslashes($post_items_value));					
				}	
			}			
		}		
		$permissions = json_encode($saved_parametrs);
		$option_name = 'wpdevart_permissions' ;

		if ( get_option( $option_name ) !== false ) {
			update_option( $option_name, $permissions );
		} else {
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $permissions, $deprecated, $autoload );
		}
		$this->view->display_permissions();
	}
 
}

?>