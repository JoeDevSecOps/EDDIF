<?php
class wpdevart_bc_ControllerGlobalsettings {
	private $model;	
	private $view;	
	  
	public function __construct() {
		require_once(WPDEVART_PLUGIN_DIR . "/admin/models/GlobalSettings.php");
		$this->model = new wpdevart_bc_ModelGlobalsettings();
		require_once(WPDEVART_PLUGIN_DIR . "/admin/views/GlobalSettings.php");
		$this->view = new wpdevart_bc_ViewGlobalsettings($this->model);
	}  	
		
	public function perform() {
		$task = wpdevart_bc_Library::get_value('task');
		if (method_exists($this, $task)) {
		  $this->$task();
		}
		else {
		  $this->display_setting();
		}
	}
	  
	  
	private function display_setting($error_msg="",$delete=true){
		$this->view->display_setting($error_msg,$delete);
	}  
	  
	private function save(){		
		$saved_parametrs = wpdevart_bc_Library::sanitizeAllPost($_POST);
		$data_json = json_encode($saved_parametrs);
		if(get_option("wpdevartec_settings") === false){
			add_option("wpdevartec_settings", $data_json);
		} else {
			update_option("wpdevartec_settings", $data_json);
		}
        $this->display_setting();
	}
	 
  
}

?>