<?php
class wpdevart_bc_ControllerExtras {
	private $model;	
	private $view;	
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/Extras.php");
		$this->model = new wpdevart_bc_ModelExtras();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/Extras.php");
		$this->view = new wpdevart_bc_ViewExtras($this->model);
	}  	
		
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		$id = wpdevart_bc_Library::get_value('id', 0);
		if (method_exists($this, $task)) {
		  $this->$task($id);
		}
		else {
		  $this->display_extras();
		}
	}
	  
	private function display_extras($error_msg="",$delete=true){
		$this->view->display_extras($error_msg,$delete);
	}  
	  
	private function add(){
		$this->view->edit_extra();
	}
	  
	private function edit( $id ){
		$this->view->edit_extra( $id );
	}
	  
	private function save( $id ){
		global $wpdb;
		$saved_parametrs = wpdevart_bc_Library::sanitizeAllPost(array_slice($_POST, 2, -2));
		$data_json = json_encode($saved_parametrs);
		$user = get_current_user_id();
		$title = wpdevart_bc_Library::getData($_POST, 'title', 'text', '');
		if ($id != 0) {
		  $save = $wpdb->update($wpdb->prefix . 'wpdevart_extras', array(
			'title' => $title,
			'data' => $data_json,
		  ), array('id' => $id));
		}
		else {
		  $save = $wpdb->insert($wpdb->prefix . 'wpdevart_extras', array(
			'title' => $title,                       
			'data' => $data_json,         
			'user_id' => $user,         
		  ), array(
			'%s',
			'%s',
			'%d',
		  ));
		  $id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wpdevart_extras');
		} 
		if(isset($_POST["save"])) {
			$this->display_extras();
		}
		else {
			wpdevart_bc_Library::redirect( add_query_arg(array(
			  'page' => 'wpdevart-extras',
			  'task' => 'edit',
			  'id' => $id
			), admin_url('admin.php')) );
		}
	}
	
	private function duplicate( $id ){
		global $wpdb; 
		$theme = $this->model->get_extra_rows( $id );
		if($theme){
			$title = $theme->title . ' - Copy';
			$data_json = $theme->data;
			$user = $theme->user_id;
			$save = $wpdb->insert($wpdb->prefix . 'wpdevart_extras', array(
				'title' => $title,                       
				'data' => $data_json,         
				'user_id' => $user,         
			), array(
				'%s',
				'%s',
				'%d',
			));
		}
		$this->display_extras();
	}
	  
	private function delete( $id ){
		global $wpdb; 
		$error_msg = "";
		$delete = true;
		$exists = $this->model->check_exists( $id );
		if($exists === false) {
			$del_query = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"',$id ));
			if($del_query) {
				$error_msg = "Item succesfully deleted.";
			}
		} else {
			$error_msg = "You can't delete form which in use";
			$delete = false;
		}
		$this->display_extras($error_msg,$delete);
	}
	  
	private function delete_selected(){
		global $wpdb; 
		$error_msg = "";
		$delete = true;
		$check_for_action = (isset($_POST['check_for_action']) ? ( $_POST['check_for_action']) : '');
		foreach($check_for_action as $check){
			$exists = $this->model->check_exists( $check );
			if($exists === false) {
				$del_query = $wpdb->query($wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"',$check ));
				if($del_query) {
					$error_msg = "Items succesfully deleted.";
				}
			} else {
				$error_msg = "You can't delete form which in use";
				$delete = false;
			}
		}
		$this->display_extras($error_msg,$delete);
	}
	 
 
  
}

?>