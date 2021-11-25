<?php
class wpdevart_bc_ViewGlobalsettings {
	public $model_obj;
    	
    public function __construct( $model ) {
		$this->model_obj = $model;
    }	
	
    public function display_setting() { 
		$wpdevart_themes = array(
			'general' => array(
				'title' => __('General','booking-calendar'),
				'sections' => array(
				    'general' => array(
						'recaptcha_public_key' => array(
							'id'   => 'recaptcha_public_key',
							'title' => __('Recaptcha Public Key:','booking-calendar'),
							'description' =>__('Recaptcha Public Key:','booking-calendar'),
							'type' => 'text',
							'pro' => 'extended',
							'default' => ''
						),
						'recaptcha_private_key' => array(
							'id'   => 'recaptcha_private_key',
							'title' => __('Recaptcha Private Key:','booking-calendar'),
							'description' =>__('Recaptcha Private Key:','booking-calendar'),
							'type' => 'text',
							'pro' => 'extended',
							'default' => ''
						),
						'get_recaptcha' => array(
							'id'   => 'get_recaptcha',
							'title' => __('','booking-calendar'),
							'description' =>'<a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">Get Recaptcha</a>',
							'type' => 'info',
							'default' => ''
						),
						'recreate_db' => array(
							'id'   => 'recreate_db',
							'title' => __('If you have a problem with the database please press this button','booking-calendar'),
							'description' =>__('If you have a problem with the database please press this button','booking-calendar'),
							'button' => __('Recreate database','booking-calendar'),
							'link' => admin_url( 'admin.php?page=wpdevart-global-settings&task=recreate_db' ),
							'type' => 'button',
							'default' => ''
						)
					)
					
				)
			)	
		);
		$settings = $this->model_obj->get_setting_rows();
		?>
		<div id="wpdevart_global" class="wpdevart-item-container wpdevart-main-item-container">
			<div class="div-for-clear">
				<span class="admin_logo"></span>
				<h1><?php _e('General Settings','booking-calendar'); ?> </h1>
			</div>
			<form action="?page=wpdevart-global-settings" method="post" class="div-for-clear">
			    <div id="wpdevart_wpdevart-item_title">
					<input type="button" value="<?php _e('Save','booking-calendar'); ?>" class="action-link wpda-input" name="save" onclick="content_required('save',this)">
				</div>
				<div id="wpdevart-tabs-container" class="div-for-clear">
					<div id="wpdevart-tabs-item-container" class="div-for-clear">
						<?php foreach( $wpdevart_themes as $key=>$wpdevart_setting ) { ?>
							<div id="wpdevart_theme-tab-<?php echo $key; ?>_container" class="wpdevart_container wpdevart-item-section <?php echo ($key == "general")? "show" : ""; ?>"> 
							<?php foreach( $wpdevart_setting['sections'] as $value_key=>$value_setting ) { ?>
								
									<div>
										<?php
										foreach( $value_setting as $key => $wpdevart_setting_value ) {
											if(isset($wpdevart_setting_value["extra_div"]) && $wpdevart_setting_value["extra_div"]){
												echo "<div class='items_open'>";
											}
											
											if( isset($settings[$key]) ) {
												$sett_value = $settings[$key];
											} else if(isset($settings) && ($wpdevart_setting_value["type"] == "checkbox" || $wpdevart_setting_value["type"] == "checkbox_enable")){
												if(isset($wpdevart_setting_value["valid_options"])) {
													$sett_value = array();
												} else {
													$sett_value = "";
												}
											} else {
												$sett_value = $wpdevart_setting_value['default'];
											}

											$function_name = "wpdevart_callback_" . $wpdevart_setting_value['type'];
											wpdevart_bc_Library::$function_name($wpdevart_setting_value, $sett_value);
											if(isset($wpdevart_setting_value["extra_div_end"]) && $wpdevart_setting_value["extra_div_end"]){
												echo "</div>";
											}
										}
									?>
									</div>	
							<?php } ?>	
							</div>	
						<?php  } ?>
						<input type="hidden" id="button_action" name="button_action" value="">
						<input type="hidden" name="task" value="save">
				    </div>
				</div>
			</form>
		</div>
	<?php	
	}

}

?>