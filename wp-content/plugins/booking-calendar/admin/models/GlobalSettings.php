<?php
class wpdevart_bc_ModelGlobalsettings {
	
  
  public function get_setting_rows() {
    $settings = get_option("wpdevartec_settings") === false ? array() :  json_decode(get_option("wpdevartec_settings"), true);
    return $settings;
  }
 
  
}

?>