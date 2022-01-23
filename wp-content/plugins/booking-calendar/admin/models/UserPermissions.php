<?php
class wpdevart_bc_ModelUserpermissions {
	
  public function get_pages_permissions() {
    global $wpdb;
	$option_name = 'wpdevart_permissions' ;
	$default = 'publish_pages';
    $permissions = get_option( $option_name, $default ); 
   
    return $permissions;
  }	
  
}

?>