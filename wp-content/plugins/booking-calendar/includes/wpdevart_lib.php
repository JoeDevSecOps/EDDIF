<?php
class wpdevart_bc_Library {
	
	public function __construct() {
		
	}
	
	public static function wpdevart_header($args = array()) { ?>
		<div class="wpdevart_plugins_header div-for-clear">
			<?php if (WPDEVART_PRO != 'extended') {  ?>
				<div class="wpdevart_plugins_get_pro div-for-clear">
					<div class="wpdevart_plugins_get_pro_info">
						<h3><?php  echo $args['title']; ?></h3>
						<p><?php  echo $args['desc']; ?></p>
					</div>
					<a target="blank" href="<?php echo WPDEVART_PLUGIN_URL; ?>" class="wpdevart_upgrade">Upgrade</a>
				</div>
			<?php } ?>
			<a target="blank" href="<?php echo wpdevart_booking_support_url; ?>" class="wpdevart_support">Have any Questions? Get quick support!</a>
		</div>
	<?php
	}
	public static function timezone_from_offset($offset) {	
		$timezones = array(
			'-12'=>'Pacific/Kwajalein',
			'-11:30'=>'Pacific/Samoa',
			'-11'=>'Pacific/Samoa',
			'-10:30'=>'Pacific/Honolulu',
			'-10'=>'Pacific/Honolulu',
			'-9:30'=>'Pacific/Marquesas',
			'-9'=>'America/Juneau',
			'-8:30'=>'Pacific/Pitcairn',
			'-8'=>'America/Los_Angeles',
			'-7:30'=>'America/Denver',
			'-7'=>'America/Denver',
			'-6:30'=>'America/Mexico_City',
			'-6'=>'America/Mexico_City',
			'-5:30'=>'America/New_York',
			'-5'=>'America/New_York',
			'-4:30'=>'America/Caracas',
			'-4'=>'America/Manaus',
			'-3:30'=>'America/St_Johns',
			'-3'=>'America/Argentina/Buenos_Aires',
			'-2:30'=>'America/St_Johns',
			'-2'=>'Brazil/DeNoronha',
			'-1:30'=>'Atlantic/Azores',
			'-1'=>'Atlantic/Azores',
			'-0:30'=>'Europe/London',
			'0'=>'Europe/London',
			'0:30'=>'Europe/London',
			'1:30'=>'Africa/Johannesburg',
			'1'=>'Europe/Paris',
			'2'=>'Europe/Helsinki',
			'2:30'=>'Europe/Moscow',
			'3'=>'Europe/Moscow',
			'3:30'=>'Asia/Tehran',
			'4'=>'Asia/Baku',
			'4:30'=>'Asia/Kabul',
			'5'=>'Asia/Karachi',
			'5:30'=>'Asia/Calcutta',
			'5:45'=>'Asia/Katmandu',
			'6'=>'Asia/Colombo',
			'6:30'=>'Asia/Rangoon',
			'7'=>'Asia/Bangkok',
			'7:30'=>'Asia/Singapore',
			'8'=>'Asia/Singapore',
			'8:30' => 'Asia/Harbin',
			'8:45' => 'Australia/Eucla',
			'9'=>'Asia/Tokyo',
			'9:30'=>'Australia/Darwin',
			'10'=>'Pacific/Guam',
			'10:30' => 'Australia/Lord_Howe',
			'11'=>'Australia/Sydney',
			'11:30'=>'Pacific/Norfolk',
			'12'=>'Asia/Kamchatka',
			'12:45' => 'Pacific/Chatham',
			'13'=>'Pacific/Enderbury',
			'13:45' => 'Pacific/Chatham',
			'14'=>'Pacific/Kiritimati'
			 );
		$intoffset = intval($offset);
		$stroffset = strval($intoffset);
		if (isset($timezones[$stroffset])) 
			return ($timezones[$stroffset]);
		else 
			return false;
	}
	
	public static function page_access($page){
		if ( get_option( 'wpdevart_permissions' ) !== false ) {
			$permissions = get_option( 'wpdevart_permissions' );
			$permissions = json_decode($permissions,true);
		}	
		if(isset($permissions[$page . '_accs']) && $permissions[$page . '_accs'] == 'on') {
			return true;
		}
		return false;
	}
	public static function multi_lng(){
		?>
		<div id="multi_lng_button" class="button"><?php _e('Multilingual fields?','booking-calendar'); ?></div>
		<div id="multi_lng_popup">
			<div id="multi_lng_popup_container">
				<div><?php echo  __('If you use multilingual Form, Extra, Notifications, then you need to type translation words instantly from here(not from translation files). Just find the language prefix(code) and add words as it shown in example.','booking-calendar') . '<br>[en]First Name[/en][fr]Prénom[/fr][es]Nombre de pila[/es]'; ?></div>
				<div><label for='wpdevart_lang'><?php _e('Get prefixes for your languages','booking-calendar'); ?></label><br>
				<?php wp_dropdown_languages( array('id' => 'wpdevart_lang') ); ?>
				<span id="lang_prefix">en</span>
				</div>
				<i class="fa fa-close"></i>
			</div>
		</div>
        <?php		
	}
	
	public static function translated_text($text, $lang = ""){
		$translated_text = $text;
		$lng = strpos(get_locale(), "_") !== false ? substr( get_locale(), 0, strpos(get_locale(), "_")) : get_locale(); 
		if ($lang != ""){
			$lng = $lang;
		}
		$fPos = strpos($text, "[$lng]") !== false ? strpos($text, "[$lng]") + strlen("[$lng]") : false;
		$lPos = strpos($text, "[/$lng]");
		if ($fPos !== false && $lPos !== false) {
			$length = $lPos - $fPos;
			$translated_text = substr($text, $fPos, $length);
		}
		
		return $translated_text;										
	}
	
	
	public static function print_field_pro_message($args){
		$msg = ""; 
		if (isset($args["pro"]) &&  WPDEVART_PRO != "extended") {
			if (WPDEVART_PRO == "free") {
				$msg = "<span class='pro_feature' data-pro='" . $args["pro"]  . "'>(" . ucfirst($args["pro"]) . ")</span>";
			} 
			elseif (WPDEVART_PRO == "pro" && $args["pro"] == "extended") {
				$msg = "<span class='pro_feature' data-pro='" . $args["pro"]  . "'>(" . ucfirst($args["pro"]) . ")</span>";
			}
		}
		
		return $msg;										
	}
	
	public static function is_pro($args){
		$pro = false; 
		if (isset($args["pro"]) &&  WPDEVART_PRO != "extended") {
			if (WPDEVART_PRO == "free") {
				$pro = true; 
			} 
			elseif (WPDEVART_PRO == "pro" && $args["pro"] == "extended") {
				$pro = true; 
			}
		}
		
		return $pro;										
	}
	
	public static function redirect( $url ) {
		$url = html_entity_decode($url); ?>
		<script>
		  window.location = '<?php echo $url; ?>';
		</script>
		<?php exit();
    }
	
	public static function get_value($key, $default_value=""){
		if (isset($_GET[$key])) {
		  $value = sanitize_text_field($_GET[$key]);
		}
		elseif (isset($_POST[$key])) {
		  $value = sanitize_text_field($_POST[$key]);
		}
		else {
		  $value = '';
		}
		if (!$value) {
		  $value = $default_value;
		}
		return $value;
	}
	
	public static function getData($data, $key, $type = "text", $default_value = "", $cond = null ){
		switch($type){
			case "text":
			$sanitize = "sanitize_text_field";
		}
        if (isset($data[$key])) {
		  if(!is_null($cond)){	
			  if($cond){	
				$value = $sanitize($data[$key]);
			  }else  {
				  $value = $default_value;
			  }
		  } else {
			  $value = $sanitize($data[$key]);
		  }
		}
		else  {
		  $value = $default_value;
		}
		return $value;
	}
	
	public static function sanitizeAllPost($post, $textareas = array() ){
		$allowed_tags = wp_kses_allowed_html( 'post' );
		$saved_parametrs = array();
		foreach($post as $post_mein_key => $post_mein_value){
			if(!is_array($post_mein_value)){
                if(in_array($post_mein_key,$textareas))	{			
					$saved_parametrs[sanitize_key($post_mein_key)] = wp_kses(stripslashes($post_mein_value),$allowed_tags);
				} else{
					$saved_parametrs[sanitize_key($post_mein_key)] = sanitize_text_field(stripslashes($post_mein_value));
				}
			} else{
				foreach($post_mein_value as $post_items_key => $post_items_value){
					if(!is_array($post_items_value)){
						if(in_array($post_mein_key,$textareas))	{			
							$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)]= wp_kses(stripslashes($post_items_value),$allowed_tags);
						} else{						
							$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)]=sanitize_text_field(stripslashes($post_items_value));	
						}
					} else{
						foreach($post_items_value as $key => $value){
							if(in_array($post_mein_key,$textareas))	{			
								$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)][sanitize_key($key)]= wp_kses(stripslashes($value),$allowed_tags);
							} else{	
								if(!is_array($value)){
									$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)][sanitize_key($key)]=sanitize_text_field(stripslashes($value));
								} else{
									foreach($value as $k=>$v){
									$saved_parametrs[sanitize_key($post_mein_key)][sanitize_key($post_items_key)][sanitize_key($key)][$k]=sanitize_text_field(stripslashes($v));
									}
								}
							}							
						}	
					}						
				}	
			}			
		}
		return $saved_parametrs;
	}
	 
    public static function wpdevart_callback_empty($args,$value) {
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			  </div>
		  </div>
	  </div>
	  <?php
	}
	 
    public static function wpdevart_callback_info($args,$value) {
	  ?>
	  <div class="wpdevart-item-container <?php echo isset($args['class']) ? $args['class'] : ""; ?> div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-info" id="wpdevart_wrap_<?php echo $args['id']; ?>">
				<?php echo $args['description']; ?>
			  </div>
		  </div>
	  </div>
	  <?php
	}
	
	 
    public static function wpdevart_callback_button($args,$value) {
	  ?>
	  <div class="wpdevart-item-container <?php echo isset($args['class']) ? $args['class'] : ""; ?> div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-info" id="wpdevart_wrap_<?php echo $args['id']; ?>">
				<a href="<?php echo $args['link']; ?>" class="button"><?php echo $args['button']; ?></a>
			  </div>
		  </div>
	  </div>
	  <?php
	}
	
	public static function wpdevart_callback_color($args,$value) {
		if(!is_array($value))
			$value=sanitize_text_field($value);
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-color" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			    <?php if (self::is_pro($args)) : ?>
					<div class="pro-field  overlay"></div>
				<?php endif; ?>
				<input type="text" id="<?php echo $args['id']; ?>" name="<?php echo $args['id']; ?>" value="<?php if(!is_array($value)) echo $value; ?>" <?php echo ((isset($args['disabled']) && $args['disabled']==true))? "disabled='disabled'" : ""; ?> class="color <?php echo self::is_pro($args)? "pro-field" : ""; ?>" <?php echo self::is_pro($args) ? "readonly" : ""; ?>>
			  </div>
		  </div>
		  <script  type="text/javascript">
			 jQuery(document).ready(function() {
			   jQuery('.color').wpColorPicker();
			 });
		  </script>
	  </div>
	  <?php
	}
	
	public static function wpdevart_callback_upload($args,$value) {
		if(!is_array($value))
			$value=esc_url($value);
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-color" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			    <input type="text" class="wp-media-input <?php echo self::is_pro($args) ? "pro-field" : ""; ?>" name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>_input" value="<?php if(!is_array($value)) echo $value; ?>"/>
			    <input type="button" class="button wp-media-buttons-icon <?php echo self::is_pro($args) ? "pro-field" : ""; ?>" name="<?php echo $args['id']; ?>_button" id="<?php echo $args['id']; ?>" value="<?php _e("Add Image","booking-calendar"); ?>"/>
				
			  </div>
		  </div>
		  <script  type="text/javascript">
			 jQuery(document).ready(function() {
			   jQuery('#<?php echo $args['id']; ?>').click(function(e) {
					var imageUrl = "";
					media_uploader = wp.media({
						frame:    "post", 
						state:    "insert", 
						multiple: false 
					});

					media_uploader.on("insert", function(){
						var uploaded_image = media_uploader.state().get('selection').first().attributes.url;
						jQuery('#<?php echo $args['id']; ?>_input').val(uploaded_image);
					});	
					media_uploader.open();
				});
			 });
		  </script>
	  </div>
	  
	  <?php
	}
    public static function wpdevart_callback_select($args,$value) {
		
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-checkbox" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			    <div class="stylesh-select">
				<?php if(isset($args['currency']) && $args['currency'] === true) { ?>
					<select id="<?php echo $args['id']; ?>" name="<?php echo $args['id']; ?>" <?php echo (isset($args['onchange'])? 'onchange="'.$args['onchange'].'"' : '' ); ?> <?php echo self::is_pro($args) ? "class='pro-field'" : ""; ?>>
					<?php
					foreach ($args['valid_options'] as $valid_option) { ?>
						<option value='<?php echo $valid_option['code']; ?>' <?php echo selected($value,$valid_option['code']); ?>><?php echo $valid_option['name']. ' - ' .$valid_option['simbol']; ?></option>
					<?php  } ?>
					</select>
				<?php } else { ?>
					<select id="<?php echo $args['id']; ?>" name="<?php echo $args['id']; ?>" <?php echo (isset($args['onchange'])? 'onchange="'.$args['onchange'].'"' : '' ); ?> <?php echo self::is_pro($args) ? "class='pro-field'" : ""; ?>>
					<?php
					foreach ($args['valid_options'] as $key => $valid_option) { ?>
						<option value='<?php echo $key; ?>' <?php echo selected($value,$key); ?>><?php echo $valid_option; ?></option>
					<?php  } ?>
					</select>	
				<?php } ?>
			    </div>
				<?php if($args['id'] == "theme_id" && count($args['valid_options']) == 0){ ?>
					<p style="color: #e20404;margin: 0;font-weight: bold;"><?php _e('Add Theme','booking-calendar'); ?></p>
				<?php } ?>
			  </div>
		  </div>
	  </div>
	  <?php
	}


    public static function wpdevart_callback_checkbox($args,$value) {
	  ?>
	   <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-checkbox stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['id']; ?>">
				<?php
				if (isset($args['valid_options']) && $args['valid_options']!='') {
					foreach ($args['valid_options'] as $key => $valid_option) { ?>
						<input type='checkbox' id='checkbox_<?php echo $key; ?>' value='<?php echo $key; ?>' name='<?php echo $args['id'].'[]'; ?>' <?php echo checked(in_array($key,$value)); ?> class='multi-checkbox  <?php echo self::is_pro($args) ? "pro-field" : ""; ?>'><label for='checkbox_<?php echo $key; ?>'><?php echo $valid_option; ?></label>
					<?php }  
				 } else {  ?>
					<input type='checkbox' id='<?php echo $args['id']; ?>' name='<?php echo $args['id']; ?>' <?php echo checked($value,'on'); ?> <?php echo self::is_pro($args) ? "class='pro-field'" : ""; ?>>
					<label for='<?php echo $args['id']; ?>' class="label_switch"></label>
				<?php } ?>
			  </div>
		  </div>
	  </div>
	  <?php
	}

    public static function wpdevart_callback_radio($args,$value) {
	  ?>
	<div class="wpdevart-item-container div-for-clear">
	    <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['id']; ?>">
				<?php
				if (isset($args['valid_options']) && $args['valid_options']!='') {
					foreach ($args['valid_options'] as $key => $valid_option) { ?>
						<input type='radio' id='radio_<?php echo $key; ?>' value='<?php echo $key; ?>' name='<?php echo $args['id']; ?>' <?php checked($value,$key); ?> <?php echo self::is_pro($args) ? "class='pro-field'" : ""; ?>><label for='radio_<?php echo $key; ?>'><?php echo $valid_option; ?></label>
					<?php }  
				}  ?>
			  </div>
		</div>
	</div>
	  <?php
	}


    public static function wpdevart_callback_text($args,$value) {
			
		if(!is_array($value))
			$value=sanitize_text_field($value);
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title" id="label_<?php echo $args['id']; ?>" >
				 <span class="wpdevart-title"><?php echo $args['title']; ?></span>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio div-for-clear" id="wpdevart_wrap_<?php echo $args['id']; ?>">
				<input type="text" id="<?php echo $args['id']; ?>" name="<?php echo $args['id']; ?>" value="<?php if(!is_array($value) && $value != "0") echo htmlspecialchars(stripslashes($value)); ?>" <?php echo ((isset($args['readonly']) && $args['readonly']==true))? "readonly" : ""; ?> <?php echo (isset($args['width']) && $args['width'])? 'style="width:'.$args['width'].'px"': ""; ?> <?php echo self::is_pro($args) ? "class='pro-field' readonly" : ""; ?>>
			  </div>
		  </div>
	  </div>
	  <?php
	}


    public static function wpdevart_callback_textarea($args,$value) {
	  ?>
	   <div class="wpdevart-item-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="wpdevart-title"><?php echo $args['title']; ?>
				 <?php  echo self::print_field_pro_message($args); ?>
				 <?php if(isset($args['required']) && $args['required'] == "on"){ ?>
				    <span class="wpdevart-required">*</span> 
				 <?php } ?>
				 </span>
				 <?php if(isset($args['description']) && $args['description'] != "") { ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
				 <?php } ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			    <?php if(isset($args['wp_editor']) && $args['wp_editor'] && user_can_richedit()) {
					wp_editor(((!is_array($value))? $value : ""), $args['id'], array('teeny' => FALSE, 'textarea_name' => $args['id'], 'media_buttons' => FALSE, 'textarea_rows' => 5));
				} else { ?>
					<textarea id="<?php echo $args['id']; ?>" name="<?php echo $args['id']; ?>" <?php echo self::is_pro($args) ? "class='pro-field' readonly" : ""; ?>><?php if(!is_array($value) && $value != "") echo $value; ?></textarea>
				<?php } ?>
			  </div>
		  </div>
	  </div>
	  <?php
	}


    public static function wpdevart_callback_checkbox_enable($args,$value) {
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	    <div class="wpdevart-fild-item-container"> 
	      <div class="section-title">
		     <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			 <?php  echo self::print_field_pro_message($args); ?>
			 <?php if(isset($args['description']) && $args['description'] != "") { ?>
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
			 <?php } ?>
		  </div>
		  <div class="wpdevart-item-elem-container element-checkbox-enable stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			  <input type="checkbox" class="checkbox <?php echo self::is_pro($args) ? 'pro-field' : ""; ?>" name="<?php echo $args['id']; ?>" id="<?php echo $args['id'] ?>" <?php checked($value,'on'); ?>>
			  <label for='<?php echo $args['id']; ?>' class="label_switch"></label>
		  </div>
		</div>
	  </div>
		  <script>
		  jQuery(document).ready(function () {

			var wpdevart_element_<?php echo $args["id"]; ?> = {
			  id : "<?php echo $args["id"]; ?>",
			  enable : [
				<?php
				foreach ($args['enable'] as $enable) :
				echo "'". $enable ."', ";
				endforeach; 
				?>        
				],
			  disable : "<?php echo (isset($args["enable_type"]) && $args["enable_type"] == 0) ? 1 : 0; ?>"
			};
			wpdevart_elements.checkbox_enable(wpdevart_element_<?php echo $args["id"]; ?>);
			jQuery('#<?php echo $args["id"]; ?>').on( "click", function() {
			  wpdevart_elements.checkbox_enable(wpdevart_element_<?php echo $args["id"]; ?>);
			});

		  });
		  </script>
	  <?php
	}

    public static function wpdevart_callback_radio_enable($args,$value) {
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	    <div class="wpdevart-fild-item-container">
	      <div class="section-title">
		     <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			 <?php  echo self::print_field_pro_message($args); ?>
			 <?php if(isset($args['description']) && $args['description'] != "") { ?>
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
			 <?php } ?>
		  </div>
		  <div class="wpdevart-item-elem-container element-radio-enable" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			<?php
			if (isset($args['valid_options']) && $args['valid_options']!='') {
				foreach ($args['valid_options'] as $key => $valid_option) { ?>
					<input type='radio' id='radio_<?php echo $key; ?>' value='<?php echo $key; ?>' name='<?php echo $args['id']; ?>' <?php echo checked($value,$key); ?> <?php echo self::is_pro($args) ? "class='pro-field'" : ""; ?>><label for='radio_<?php echo $key; ?>'><?php echo $valid_option; ?></label>
				<?php }  
			}
			?>
		  </div>
		</div>
	  </div>
		  <script>
		  jQuery(document).ready(function () {

			var wpdevart_element_<?php echo $args["id"]; ?> = {
			  id : "<?php echo $args["id"]; ?>",
			  enable : [
				<?php
				foreach ($args['enable'] as $key => $value) {
					echo "{key: '" . $key ."', val: [" ; 
					if(is_array($value)) {
						foreach ($value as $item){
							echo "'".$item."',";
						} 
					} else {
						echo "'".$value."',";
					}
					echo "]},";
				}  
				?>        
				]
			};
			
			wpdevart_elements.radio_enable(wpdevart_element_<?php echo $args["id"]; ?>);
			jQuery('input[type=radio][name="<?php echo $args['id']; ?>"]').on( "change", function() {
			  wpdevart_elements.radio_enable(wpdevart_element_<?php echo $args["id"]; ?>);
			});

		  });
		  </script>
	  <?php
	}

    public static function wpdevart_callback_hidden($args,$value) {
	  ?>
	  <input type="hidden" name="<?php echo $args["id"]; ?>" id="<?php echo $args["id"]; ?>" value="<?php echo $args["default"]; ?>">
	  <?php
	}
	

    public static function wpdevart_callback_conditions($args,$value) {
		$placeholder = (isset($args['day']) && $args['day'] == true) ? __("Day Count","booking-calendar") : __("Hour Count","booking-calendar");
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	    <div class="wpdevart-fild-item-container">
	      <div class="section-title">
		     <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			 <?php  echo self::print_field_pro_message($args); ?>
			 <?php if(isset($args['description']) && $args['description'] != "") { ?>
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
			 <?php } ?>
		  </div>
		  <div class="wpdevart-item-elem-container element-sale-conditions" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			<span class="add_hour <?php echo self::is_pro($args) ? "pro-field" : ""; ?>"  onclick="add_conditions(this,'<?php echo $args['id']; ?>','<?php echo $placeholder; ?>','<?php _e("Percent","booking-calendar"); ?>');"><?php _e("Add Conditions","booking-calendar"); ?></span> 
			<?php
			if (isset($value['count']) && count($value['count'])) {
				for($i=0; $i<count($value['count']); $i++) { ?>
				    <div class="conditions_element div-for-clear">
						<input type='text' class='short_input' value='<?php echo isset($value['count'][$i]) ? $value['count'][$i] : ""; ?>' name='<?php echo $args['id']; ?>[count][]' placeholder="<?php echo $placeholder; ?>">
						<select name="<?php echo $args['id']; ?>[type][]">
							<option value="percent" <?php selected(isset($value['type'][$i]) && $value['type'][$i] == "percent"); ?>>Percent</option>
							<option value="price" <?php selected(isset($value['type'][$i]) && $value['type'][$i] == "price"); ?>>Price</option>
						</select>
						<input type='text' class='short_input' value='<?php echo isset($value['percent'][$i]) ? $value['percent'][$i] : ""; ?>' name='<?php echo $args['id']; ?>[percent][]' placeholder="<?php _e("Percent","booking-calendar"); ?>">
						<span class="delete_hour_item"><i class="fa fa-close"></i></span>
					</div>
				<?php }  
			} else { ?>
				    <div class="conditions_element div-for-clear">
						<input type='text' class='short_input' value='' name='<?php echo $args['id']; ?>[count][]' placeholder="<?php echo $placeholder; ?>">
						<select name="<?php echo $args['id']; ?>[type][]">
							<option value="percent" selected="selected">Percent</option>
							<option value="price">Price</option>
						</select>
						<input type='text' class='short_input' value='' name='<?php echo $args['id']; ?>[percent][]' placeholder="<?php _e("Percent","booking-calendar"); ?>">
						<span class="delete_hour_item"><i class="fa fa-close"></i></span>
					</div>
				<?php
			}
			?>
		  </div>
		</div>
	  </div>
	  <?php
	}
	
	
    public static function wpdevart_callback_hours_element($args,$value) {
	  ?>
	  <div class="wpdevart-item-container div-for-clear">
	    <div class="wpdevart-fild-item-container">
	      <div class="section-title">
		     <span class="wpdevart-title"><?php echo $args['title']; ?></span>
			 <?php  echo self::print_field_pro_message($args); ?>
			 <?php if(isset($args['description']) && $args['description'] != "") { ?>
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo $args['description']; ?></span></span>
			 <?php } ?>
		  </div>
		  <div class="wpdevart-item-elem-container element-radio-enable" id="wpdevart_wrap_<?php echo $args['id']; ?>">
			<span class="add_hour <?php echo self::is_pro($args) ? "pro-field" : ""; ?>" onclick="add_hour(this,'<?php echo $args['id']; ?>');"><?php _e("Add Hour","booking-calendar"); ?></span> 
		    <span class="add_default" onclick="add_default(this,'<?php echo $args['id']; ?>');"><?php _e("Add Default","booking-calendar"); ?></span> 
			<?php
			if (isset($value['hour_value']) && count($value['hour_value'])) {
				for($i=0; $i<count($value['hour_value']); $i++) { ?>
				    <div class="hour_element div-for-clear">
						<input type='text' class='hour_value short_input' value='<?php echo isset($value['hour_value'][$i]) ? sanitize_text_field($value['hour_value'][$i]) : ""; ?>' name='<?php echo $args['id']; ?>[hour_value][]' placeholder="<?php _e("Hour","booking-calendar"); ?>">
						<input type='text' class='hour_price short_input' value='<?php echo isset($value['hour_price'][$i]) ? sanitize_text_field($value['hour_price'][$i]) : ""; ?>' name='<?php echo $args['id']; ?>[hour_price][]' placeholder="<?php _e("Price","booking-calendar"); ?>">
						<input type='text' class='hours_marked_price short_input' value='<?php echo isset($value['hours_marked_price'][$i]) ? sanitize_text_field($value['hours_marked_price'][$i]) : ""; ?>' name='<?php echo $args['id']; ?>[hours_marked_price][]' placeholder="<?php _e("Marked Price","booking-calendar"); ?>">
						<select name='<?php echo $args['id']; ?>[hours_availability][]' class="half_input">
						   <option value="available" <?php selected(isset($value['hour_price'][$i]) && $value['hour_price'][$i] == "available"); ?>><?php _e("Available","booking-calendar"); ?></option>
						   <option value="booked" <?php selected(isset($value['hour_price'][$i]) && $value['hour_price'][$i] == "booked"); ?>><?php _e("Booked","booking-calendar"); ?></option>
						   <option value="unavailable" <?php selected(isset($value['hour_price'][$i]) && $value['hour_price'][$i] == "unavailable"); ?>><?php _e("Unavailable","booking-calendar"); ?></option>
						</select>
						<input type='text' class='hours_number_availability half_input' value='<?php echo isset($value['hours_number_availability'][$i]) ? sanitize_text_field($value['hours_number_availability'][$i]) : ""; ?>' name='<?php echo $args['id']; ?>[hours_number_availability][]' placeholder="<?php _e("Number Availabile","booking-calendar"); ?>">
						<input type='text' class='hour_info full_input' value='<?php echo isset($value['hour_info'][$i]) ? sanitize_text_field($value['hour_info'][$i]) : ""; ?>' name='<?php echo $args['id']; ?>[hour_info][]' placeholder="<?php _e("Hour Information","booking-calendar"); ?>">
						<span class="delete_hour_item"><i class="fa fa-close"></i></span>
					</div>
				<?php }  
			} else { ?>
				    <div class="hour_element div-for-clear">
						<input type='text' class='hour_value short_input' value='' name='<?php echo $args['id']; ?>[hour_value][]' placeholder="<?php _e("Hour","booking-calendar"); ?>">
						<input type='text' class='hour_price short_input' value='' name='<?php echo $args['id']; ?>[hour_price][]' placeholder="<?php _e("Price","booking-calendar"); ?>">
						<input type='text' class='hours_marked_price short_input' value='' name='<?php echo $args['id']; ?>[hours_marked_price][]' placeholder="<?php _e("Marked Price","booking-calendar"); ?>">
						<select name='<?php echo $args['id']; ?>[hours_availability][]' class="half_input">
						   <option value="available"><?php _e("Available","booking-calendar"); ?></option>
						   <option value="booked"><?php _e("Booked","booking-calendar"); ?></option>
						   <option value="unavailable"><?php _e("Unavailable","booking-calendar"); ?></option>
						</select>
						<input type='text' class='hours_number_availability half_input' value='' name='<?php echo $args['id']; ?>[hours_number_availability][]' placeholder="<?php _e("Number Availabile","booking-calendar"); ?>">
						<input type='text' class='hour_info full_input' value='' name='<?php echo $args['id']; ?>[hour_info][]' placeholder="<?php _e("Hour Information","booking-calendar"); ?>">
						<span class="delete_hour_item"><i class="fa fa-close"></i></span>
					</div>
				<?php
			}
			?>
		  </div>
		</div>
		<?php /*<input type='hidden' id='hour_value_element' value='<?php echo $value; ?>' name='<?php echo $args['id']; ?>'> */ ?>
	  </div>
	  <?php
	}
	
	
	
	/*
	*FORM
	*/
     
	 
    public static function wpdevart_form_select($args,$value) {
	  ?>
	  <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<select id="<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>" disabled="disabled">
				<?php foreach ($args['valid_options'] as $key => $valid_option) { ?>
					<option value='<?php echo $key; ?>' <?php echo selected($value,$key); ?>><?php echo $valid_option; ?></option>
				<?php  } ?>
				</select>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					<label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Multiple select",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='form_multi_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[multi]' <?php echo checked(isset($value['multi']) && $value['multi'] == 'on'); ?> >
					<label for='form_multi_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Options",'booking-calendar'); ?>
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php _e('Add one per line','booking-calendar'); ?></span></span>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<textarea id='form_opt_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[options]'><?php if(isset($value['options'])) echo sanitize_textarea_field($value['options']); ?></textarea>
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}
	
	 public static function wpdevart_form_countries($args,$value) {
	  ?>
	  <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<select id="<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>" disabled="disabled">
				<?php foreach ($args['valid_options'] as $key => $valid_option) { ?>
					<option value='<?php echo $key; ?>' <?php echo selected($value,$key); ?>><?php echo $valid_option; ?></option>
				<?php  } ?>
				</select>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					<label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}


    public static function wpdevart_form_checkbox($args,$value) {
	  ?>
	   <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<?php
				if (isset($args['options']) && $args['options']!='') {
					foreach ($args['options'] as $key => $valid_option) { ?>
						<input type='checkbox' id='checkbox_<?php echo $key; ?>' value='<?php echo $key; ?>' name='<?php echo $args['name'].'[]'; ?>' disabled='disabled'><label for='checkbox_<?php echo $key; ?>'><?php echo $valid_option; ?></label>
					<?php }  
				 } else {  ?>
					<input type='checkbox' id='<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>'  disabled='disabled'>
				<?php } ?>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
			<div class="form-fild-options">
				<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
				<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			    <div class="wpdevart-item-container div-for-clear">
					<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
					<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
					</div>
				</div>
			    <div class="wpdevart-item-container div-for-clear">
					<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
					<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					   <label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
					</div>
				</div>
		    </div>
	  </div>
	  <?php
	}

    public static function wpdevart_form_radio($args,$value) {
	  ?>
	<div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	    <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<?php
				if (isset($args['options']) && $args['options']!='') {
					foreach ($args['options'] as $key => $valid_option) { ?>
						<input type='radio' id='radio_<?php echo $key; ?>' value='<?php echo $key; ?>' name='<?php echo $args['name']; ?>' disabled='disabled'><label for='radio_<?php echo $key; ?>'><?php echo $valid_option; ?></label>
					<?php }  
				} ?>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		</div>
		<div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo $value['label']; ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					   <label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
		</div>
	</div>
	  <?php
	}


    public static function wpdevart_form_text($args,$value) {
	  ?>
	  <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title" id="label_<?php echo $args['name']; ?>" >
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<input type="text" id="<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>"  disabled='disabled'>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
			<div class="form-fild-options">
				<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
				<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			    <div class="wpdevart-item-container div-for-clear">
					<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
					<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>"  class="form_label">
					</div>
				</div>
			    <div class="wpdevart-item-container div-for-clear">
					<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
					<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type='checkbox' id='required_<?php echo $args['name']; ?>' name="<?php echo $args['name']; ?>[required]" <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					   <label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
					</div>
				</div>
			    <div class="wpdevart-item-container div-for-clear red-section">
					<div class="section-title"> <?php echo __("Is Email",'booking-calendar'); ?> 
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo __("Use only for Email field",'booking-calendar'); ?></span></span></div>
					<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type='checkbox' id='form_isemail_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[isemail]' <?php echo checked(isset($value['isemail']) && $value['isemail'] == 'on'); ?> >
					   <label for='form_isemail_<?php echo $args['name']; ?>' class="label_switch"></label>
					</div>
				</div>
			    <div class="wpdevart-item-container div-for-clear red-section">
					<div class="section-title"> <?php echo __("Confirm Email",'booking-calendar'); ?></div>
					<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type='checkbox' id='form_confirm_email_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[confirm_email]' <?php echo checked(isset($value['confirm_email']) && $value['confirm_email'] == 'on'); ?> >
					   <label for='form_confirm_email_<?php echo $args['name']; ?>' class="label_switch"></label>
					</div>
				</div>
			    <div class="wpdevart-item-container div-for-clear">
					<div class="section-title"> <?php echo __("Is Name",'booking-calendar'); ?></div>
					<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
						<input type='checkbox' id='form_isname_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[isname]' <?php echo checked(isset($value['isname']) && $value['isname'] == 'on'); ?> >
					   <label for='form_isname_<?php echo $args['name']; ?>' class="label_switch"></label>
					</div>
				</div>
		    </div>
		  <script>
		  jQuery(document).ready(function () {
				var id = "#form_isemail_<?php echo $args["name"]; ?>";
				var enable = "#form_confirm_email_<?php echo $args["name"]; ?>";
				if (jQuery(id).prop('checked')) {
					jQuery(enable).closest('.wpdevart-item-container.red-section').slideDown();
				}
				else{
					jQuery(enable).closest('.wpdevart-item-container.red-section').slideUp();
				}
				jQuery(id).on( "click", function() {
				  if (jQuery(id).prop('checked')) {
						jQuery(enable).closest('.wpdevart-item-container.red-section').slideDown();
					}
					else{
						jQuery(enable).closest('.wpdevart-item-container.red-section').slideUp();
					}
				});
		  });
		  </script>
	  </div>
	  <?php
	}

    public static function wpdevart_form_textarea($args,$value) {
	  ?>
	   <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<textarea id="<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>" disabled='disabled'></textarea>
				
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					<label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}

    public static function wpdevart_form_recapthcha($args,$value) {
	  ?>
	   <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required">*</span>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}
	
	public static function wpdevart_form_upload($args,$value) {
	  ?>
	   <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php echo $args['label']; ?></span><span class="wpdevart-required"><?php if(isset($value['required']) && $value['required'] == 'on') echo "*"; ?></span>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php echo $args['name']; ?>">
				<input type="file" id="<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>" disabled='disabled'>
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[type]' value="<?php echo $args['type']; ?>">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo $value['label']; ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Required",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='required_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[required]' <?php echo checked(isset($value['required']) && $value['required'] == 'on'); ?> class="form_req">
					<label for='required_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php _e("Allowed File Types",'booking-calendar'); ?> 
				<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo __("Choose the file types that you want to allow users for submitting in form.",'booking-calendar'); ?></span></span>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<textarea id='form_opt_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[extensions]'><?php echo (isset($value['extensions']))? $value['extensions'] : "png,jpg,jpeg,gif,doc,xls,xlsx"; ?></textarea>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php _e("Allowed maximum size(KB)",'booking-calendar'); ?>
					<span class="wpdevart-info-container">?<span class="wpdevart-info"><?php echo __("Type the allowed maximum size for uploading files(KB).",'booking-calendar'); ?></span></span>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='text' id='max_size_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[max_size]' value="<?php echo (isset($value['max_size']))? $value['max_size'] : 20000; ?>">
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}
	
    public static function wpdevart_extras_field($args,$value = "") {
       if(isset($value["items"]) && is_array($value["items"])) {
		   $last_element = end($value["items"]);
		   $max_id = str_replace('field_item', '', $last_element['name']);
	   } else {
		   $max_id = 3;
	   }	 
	   
	  ?>
	   <div class="wpdevart-item-container wpdevart-item-parent-container div-for-clear">
	      <div class="wpdevart-fild-item-container">
			  <div class="section-title">
				 <span class="section-title-txt"><?php if(isset($args['label'])) echo $args['label']; ?>
			  </div>
			  <div class="wpdevart-item-elem-container element-radio" id="wpdevart_wrap_<?php if(isset($args['name'])) echo $args['name']; ?>">
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i>
				</div>
				<div class="delete-form-fild"><i class="fa fa-close"></i>
				</div>
				<div class="open-form-fild-options"><i class="fa fa-chevron-down" aria-hidden="true"></i>
				</div>
			  </div>
		  </div>
		  <div class="form-fild-options">
			<input type="hidden" name='<?php echo $args['name']; ?>[name]' value="<?php echo $args['name']; ?>">
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Label",'booking-calendar'); ?> </div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type="text" id="label_<?php echo $args['name']; ?>" name="<?php echo $args['name']; ?>[label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>" class="form_label">
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Regardless of counting days",'booking-calendar'); ?> 
				<?php echo WPDEVART_PRO == "free" ? "<span class='pro_feature' data-pro='" . WPDEVART_PRO  . "'>(Pro)</span>" : ""; ?>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='independent_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[independent]' <?php echo checked(isset($value['independent']) && $value['independent'] == 'on'); ?> <?php echo WPDEVART_PRO == "free" ? "class='pro-field'" : ""; ?>>
			        <label for='independent_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title"> <?php echo __("Regardless of Item count",'booking-calendar'); ?> 
				<?php echo WPDEVART_PRO == "free" ? "<span class='pro_feature' data-pro='" . WPDEVART_PRO  . "'>(Pro)</span>" : ""; ?>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear stylesh-checkbox" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					<input type='checkbox' id='independent_counts_<?php echo $args['name']; ?>' name='<?php echo $args['name']; ?>[independent_counts]' <?php echo checked(isset($value['independent_counts']) && $value['independent_counts'] == 'on'); ?> <?php echo WPDEVART_PRO == "free" ? "class='pro-field'" : ""; ?>>
			        <label for='independent_counts_<?php echo $args['name']; ?>' class="label_switch"></label>
				</div>
			</div>
			<div class="wpdevart-item-container div-for-clear">
				<div class="section-title div-for-clear"><span class="extra-items"> <?php echo __("Items",'booking-calendar'); ?></span>
					<div class="add_extra_field_item" data-max="<?php echo $max_id; ?>" data-field="<?php echo $args['name']; ?>"></div>
				</div>
				<div class="wpdevart-item-elem-container div-for-clear" id="wpdevart_wrap_<?php echo $args['name']; ?>">
					
					<div class="wpdevart-extra-items-container">
						<ul class="extra-items-labels div-for-clear">
							<li>Label</li>
							<li>Operation</li>
							<li>Price type</li>
							<li>Price/Percent</li>
						</ul>
						<?php if(isset($args["items"]) && count($args["items"])) { ?>
							<ul class="wpdevart-extra-item-container div-for-clear">
							<?php foreach($args["items"] as $key=>$item) {
								if(isset($value['items'][''.$key.''])) {
									$val = $value['items'][''.$key.''];
								} else {
									$val = 0;
								}
								echo self::wpdevart_extras_field_item($args['name'],$item,$val);
							 } ?>
							</ul> 
						<?php } ?>
						<?php if(WPDEVART_PRO == "free") : ?>
						<ul class="pro-feature extra-items-labels div-for-clear">
							<li></li>
							<li><span class="pro_feature">(Pro)</span></li>
							<li><span class="pro_feature">(Pro)</span></li>
							<li><span class="pro_feature"></span></li>
						</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		  </div>
	  </div>
	  <?php
	}
	
	public static function wpdevart_redirect($url){ ?>
			<script>
				window.location = "<?php echo $url; ?>";
			</script>	
		<?php exit();
	}
	
		
    public static function wpdevart_extras_field_item($name,$args,$value=0) {
	  ?>
		<li> 
			<div class="wpdevart-extra-item  div-for-clear">
				<input type="hidden" name="<?php echo $name; ?>[items][<?php echo $args["name"]; ?>][name]" value="<?php echo (isset($args["name"]))? $args["name"] : ""; ?>">
				<input type="text" name="<?php echo $name; ?>[items][<?php echo $args["name"]; ?>][label]" value="<?php if(isset($value['label'])) echo sanitize_text_field($value['label']); ?>">
				<select name="<?php echo $name; ?>[items][<?php echo $args["name"]; ?>][operation]" <?php echo WPDEVART_PRO == "free" ? "class='pro-field'" : ""; ?>>
					<option value="+" <?php selected(isset($value["operation"]) && $value["operation"]=="+"); ?>>+</option>
					<option value="-" <?php selected(isset($value["operation"]) && $value["operation"]=="-"); ?>>-</option>
				</select>
				<select name="<?php echo $name; ?>[items][<?php echo $args["name"]; ?>][price_type]" <?php echo WPDEVART_PRO == "free" ? "class='pro-field'" : ""; ?>>
					<option value="price" <?php selected(isset($value["price_type"]) && $value["price_type"]=="price"); ?>>Price</option>
					<option value="percent" <?php selected(isset($value["price_type"]) && $value["price_type"]=="percent"); ?>>Percent</option>
				</select>
				<input type="text" name="<?php echo $name; ?>[items][<?php echo $args["name"]; ?>][price_percent]" value="<?php if(isset($value['price_percent'])) echo sanitize_text_field($value['price_percent']); ?>">
				<div class="drag-form-fild"><i class="fa fa-arrows-v" ></i></div>
				<div class="delete-extra-fild"><i class="fa fa-close"></i></div>
			</div>
		</li>
	  <?php
	}
	
	public static function items_nav($wpdevart_page,$items_count,$form_id){ ?>   
        <script type="text/javascript">
			function get_page(x,y) {
				var items_county=<?php if($items_count){ if($items_count%20){ echo ($items_count-$items_count%20)/20+1;} else echo ($items_count-$items_count%20)/20;} else echo 1;?>;
				switch(y) {
					case 1:
						if(x >= items_county) {
							jQuery(".wpdevart_page").val(items_county);
						} else {
							jQuery(".wpdevart_page").val(x+1);
						}
					    break;
					case 2:
						jQuery(".wpdevart_page").val(items_county);
						break;
					case -1:
						if(x == 1) {
							jQuery(".wpdevart_page").val(1);
						} else {
							jQuery(".wpdevart_page").val(x-1);
						}
					    break;
					case -2:
					    jQuery(".wpdevart_page").val(1);
					    break;
					default:
					    jQuery(".wpdevart_page").val(1);
				}	
				jQuery("#<?php echo $form_id; ?>").submit();	
			 }
		</script>
		<div class="tablenav top">
			<div class="tablenav-pages">
				<span class="displaying-num"><?php echo $items_count; ?> items</span>
				<?php 
				if($items_count > 20) {
					$first = "first-page";
					$prev = "prev-page";
					$next = "next-page";
					$last = "last-page";
					if($wpdevart_page==1) {
						$first = "first-page disabled";
						$prev = "prev-page disabled";
						$next = "next-page";
						$last = "last-page"; 
					}
					if($wpdevart_page>=(1+($items_count-$items_count%20)/20) ) {
						$first = "first-page ";
						$prev = "prev-page";
						$next = "next-page disabled";
						$last = "last-page disabled"; 
					} ?>     
					<span class="pagination-links">
						<a class="<?php echo $first; ?>" href="javascript:get_page(<?php echo $wpdevart_page; ?>,-2);">«</a>
						<a class="<?php echo $prev; ?>" href="javascript:get_page(<?php echo $wpdevart_page; ?>,-1);">‹</a>
						<span class="paging-input">
						<span class="total-pages"><?php echo $wpdevart_page; ?></span>
						of <span class="total-pages">
						<?php echo ($items_count-$items_count%20)/20+1; ?>
						</span>
						</span>
						<a class="<?php echo $next; ?>" href="javascript:get_page(<?php echo $wpdevart_page; ?>,1);">›</a>
						<a class="<?php echo $last; ?>" href="javascript:get_page(<?php echo $wpdevart_page; ?>,2);">»</a>
					</span>
				<?php } ?>
			</div>
	    </div >
		<input type="hidden" class="wpdevart_page" name="wpdevart_page" value="<?php echo (isset($_POST['wpdevart_page']))? esc_js($_POST['wpdevart_page']): 1; ?>"  />
		<?php
	
	}
	
	private function text_for_tr($options) {
		$for_tr = array(
			"for_available" => "available",
			"for_booked" => "Booked",
			"for_unavailable" => "Unavailable",
			"for_check_in" => "Check in",
			"for_check_out" => "Check out",
			"for_night_count" => "Number of nights",
			"for_date" => "Date",
			"for_no_hour" => "No hour available.",
			"for_start_hour" => "Start hour",
			"for_end_hour" => "End hour",
			"for_hour" => "Hour",
			"for_item_count" => "Item count",
			"for_termscond" => "I accept to agree to the Terms & Conditions.",
			"for_reservation" => "Reservation",
			"for_select_days" => "Please select the days from calendar.",
			"for_price" => "Price",
			"for_total" => "Total",
			"for_submit_button" => "Book Now",
			"for_request_successfully_sent" => "Your request has been successfully sent. Please wait for approval.",
			"for_request_successfully_received" => "Your request has been successfully received. We are waiting you!",
			"for_error_single" => "There are no services available for this day.",
			"for_night" => "You must select at least two days",
			"for_min" => "You must select at least [min] days",
			"for_max" => "You must select  more than [max] days",
			"for_min_hour" => "You must select at least [min] hour",
			"for_max_hour" => "You must select  more than [max] hour",
			"for_capcha" => "Was not verified by recaptcha",
			"for_error_multi" => "There are no services available for the period you selected.",
			"for_notify_admin_on_book" => "Email on book to administrator doesn't send",
			"for_notify_admin_on_approved" => "Email on approved to administrator doesn't send",
			"for_notify_user_on_book" => "Email on book to user doesn't send",
			"for_notify_user_on_approved" => "Email on approved to user doesn't send",
			"for_notify_user_canceled" => "Email on canceled to user doesn't send",
			"for_notify_user_deleted" => "Email on delete to user doesn't send",
			"for_pay_in_cash" => "Pay in cash",
			"for_paypal" => "Pay with PayPal",
			"for_shipping_info" => "Same as billing info"
		);
		
		foreach($for_tr as $key => $for) {
			if(isset($options['use_mo']) && $options['use_mo'] == "on") {
				$for_trarray[$key] = __($for,'booking-calendar');
			} elseif(isset($options[$key])){
				$for_trarray[$key] = self::translated_text($options[$key]);
			} else {
				$for_trarray[$key] = __($for,'booking-calendar');
			}
		}
		
		return $for_trarray;
	}

	public function send_mail($data, $from, $options, $type = '') {
		if(file_exists(ABSPATH . WPINC . '/PHPMailer/PHPMailer.php')){
			require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
			require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
		}else{
			require_once ABSPATH . WPINC . '/class-phpmailer.php';
		}
		$for_trarray = $this->text_for_tr($options);
		$sale_percent_html = "";
		$hour_html = "";
		$admin_email_types = array();
		$user_email_types = array();
		$admin_error_types = array();
		$user_error_types = array();
		$countries = self::get_countries();
		$site_url = site_url();
		$moderate_link = admin_url() . "admin.php?page=wpdevart-reservations";
		$form_data = $this->get_form_data($data['form'], $data['calendar_id']);
        $extras_data = $this->get_extra_data($data['extras'], $data['calendar_id'], $data['price']);
		$cur_pos = (isset($options['currency_pos']) && $options['currency_pos'] == "before") ? "before" : "after";
		$currency = $data['currency'];
		if(isset($data['sale_percent']) && !empty($data['sale_percent'])){
			if($data['sale_type'] == "percent"){
				$sale_percent_value = ($data['sale_percent'] != "100") ? (($data['total_price'] * 100) / (100 - $data['sale_percent'])) : $data['price'];
				$sale_percent_html = (($cur_pos == "before" ? $currency : '') . $sale_percent_value . ($cur_pos == "after" ? $currency : '')) . " - " . $data['sale_percent'] . "% = ";
			} else {
				$sale_percent_value = $data['total_price'] + $data['sale_percent'];
				$sale_percent_html = (($cur_pos == "before" ? $currency : '') . $sale_percent_value . ($cur_pos == "after"  ? $currency : '')) . " - " . ($cur_pos == "before" ? $currency : '') . $data['sale_percent'] . ($cur_pos == "after" ? $currency : '') ." = ";
			}
		}
		if($data['check_in']) {
			$check_in = date($options["date_format"], strtotime($data['check_in']));
			$check_out = date($options["date_format"], strtotime($data['check_out']));
			$res_day = $check_in. "-" .$check_out;
		} else {
			$res_day = date($options["date_format"], strtotime($data['single_day']));
		}
		$hide_price = (isset($options['hide_price']) && $options['hide_price'] == "on") ? true : false;
		if(isset($data['start_hour']) && $data['start_hour'] != ""){
			$hour_html = $data['start_hour'];
		}
		if(isset($data['end_hour']) && $data['end_hour'] != ""){
			$hour_html = $hour_html." - ".$data['end_hour'];
		}
		if($hour_html != ""){
			$hour_html = "<tr><td style='padding: 4px 7px;'>".$for_trarray["for_hour"]."</td> <td  style='padding: 4px 7px;'>".$hour_html.'</td></tr>';
		}
		$res_info = "<table border='1' style='border-collapse:collapse;min-width: 360px;border-color: #c6c6c6;'>
						<caption style='text-align:left;'>".__('Details','booking-calendar')."</caption>
						<tr><td style='padding: 4px 7px;'>".__('Reservation dates','booking-calendar')."</td><td style='padding: 4px 7px;'>".$res_day."</td></tr>".$hour_html."
						<tr><td style='padding: 4px 7px;'>".$for_trarray["for_item_count"]."</td><td style='padding: 4px 7px;'>".$data['count_item']."</td></tr>";
		if($data['price'] != "NaN" && !$hide_price){				
			$res_info .= "<tr><td style='padding: 4px 7px;'>".$for_trarray["for_price"]."</td> <td style='padding: 4px 7px;'>".($cur_pos == "before" ? esc_html($currency) : '') . $data['price'] . ($cur_pos == "after" ? esc_html($currency) : '')."</td></tr>";
		}
		if($data['total_price'] != "NaN" && !$hide_price){
			$res_info .= "<tr><td style='padding: 4px 7px;'>".$for_trarray["for_total"]."</td> <td style='padding: 4px 7px;'>".$sale_percent_html . ($cur_pos == "before" ? esc_html($currency) : '') . $data['total_price'] . ($cur_pos == "after" ? esc_html($currency) : '')."</td></tr>";
		}
		$res_info .= "</table>";
		$form = "";
		$extras = "";		
		if(count($form_data)) {
			$form .= "<table border='1' style='border-collapse:collapse;min-width: 360px;border-color: #c6c6c6;'>";
			$form .= "<caption style='text-align:left;'>".__('Contact Information','booking-calendar')."</caption>";
			foreach($form_data as $form_fild_data) {
				if($form_fild_data['type'] == 'countries' && trim($form_fild_data['value']) != "") {
					$form .= "<tr><td style='padding: 4px 7px;'>". self::translated_text($form_fild_data["label"],$data['lang']) ."</td> <td style='padding: 4px 7px;'>". $countries[$form_fild_data["value"]] ."</td></tr>";
				}else {
					$form .= "<tr><td style='padding: 4px 7px;'>". self::translated_text($form_fild_data["label"],$data['lang']) ."</td> <td style='padding: 4px 7px;'>". $form_fild_data["value"] ."</td></tr>";
				}
			}
			$form .= "</table>";
		}	
		if(count($extras_data)) {
			$extras .= "<table border='1' style='border-collapse:collapse;min-width: 360px;border-color: #c6c6c6;'>";
			$extras .= "<caption style='text-align:left;'>".__('Extra Information','booking-calendar')."</caption>";
			foreach($extras_data as $extra_data) {
				$extras .= "<tr><td colspan='2' style='padding: 4px 7px;'>".self::translated_text($extra_data["group_label"],$data['lang'])."</td></tr>";
				$extras .= "<tr><td style='padding: 4px 7px;'>". self::translated_text($extra_data["label"],$data['lang']) ."</td>"; 
				$extras .= "<td style='padding: 4px 7px;'>";
				if($extra_data["price_type"] == "percent") {
					$extras .= "<span class='price-percent'>".$extra_data["operation"].$extra_data["price_percent"]."%</span>";
					$extras .= "<span class='price'>".$extra_data["operation"] . ($cur_pos == "before" ? esc_html($currency) : '') . $extra_data["price"] . ($cur_pos == "after" ? esc_html($currency) : '')."</span></td></tr>";
				} else {
					$extras .= "<span class='price'>".$extra_data["operation"] .($cur_pos == "before" ? esc_html($currency) : '') . $extra_data["price"] . ($cur_pos == "after" ? esc_html($currency) : '')."</span></td></tr>";
				}
				
			}
			$extras .= "<tr><td style='padding: 4px 7px;'>" . __('Price change','booking-calendar')."</td><td style='padding: 4px 7px;'>".(($data['extras_price'] < 0)? "" : "+").($cur_pos == "before" ? esc_html($currency) : '') . $data['extras_price'] . ($cur_pos == "after" ? esc_html($currency) : '')."</td></tr>";
			$extras .= "</table>";
		}
		if ($from == 'book') {
			if(isset($options['notify_admin_on_book']) && $options['notify_admin_on_book'] == "on") {
				$admin_email_types[] = 'notify_admin_on_book';
			}
			if(isset($options['notify_user_on_book']) && $options['notify_user_on_book'] == "on") {
				$user_email_types[] = 'notify_user_on_book';
			}
			if(isset($options['enable_instant_approval']) && $options['enable_instant_approval'] == "on") {
				if(isset($options['notify_admin_on_approved']) && $options['notify_admin_on_approved'] == "on") {
					$admin_email_types[] = 'notify_admin_on_approved';
				}
				if(isset($options['notify_user_on_approved']) && $options['notify_user_on_approved'] == "on") {
					$user_email_types[] = 'notify_user_on_approved';
				}
			}	
		} elseif ($from == 'reservation') {
			if(isset($options['notify_admin_on_book']) && $options['notify_admin_on_book'] == "on" && $type == "book") {
				$admin_email_types[] = 'notify_admin_on_book';
			}
			if(isset($options['notify_admin_on_approved']) && $options['notify_admin_on_approved'] == "on" && $type == "approved") {
				$admin_email_types[] = 'notify_admin_on_approved';
			}		
			
			if(isset($options['notify_user_on_book']) && $options['notify_user_on_book'] == "on" && $type == "book") {
				$user_email_types[] = 'notify_user_on_book';
			}
			if(isset($options['notify_user_on_approved']) && $options['notify_user_on_approved'] == "on" && $type == "approved") {
				$user_email_types[] = 'notify_user_on_approved';
			}
			if(isset($options['notify_user_canceled']) && $options['notify_user_canceled'] == "on" && $type == "canceled") {
				$user_email_types[] = 'notify_user_canceled';
			}
			if(isset($options['notify_user_deleted']) && $options['notify_user_deleted'] == "on" && ($type == "deleted" ||  $type == "rejected")) {
				$user_email_types[] = 'notify_user_deleted';
			}
		} elseif ($from == 'payment') {
			if(isset($options['notify_admin_paypal']) && $options['notify_admin_paypal'] == "on" && $type == "completed") {
				$admin_email_types[] = 'notify_admin_paypal';
			}
			if(isset($options['notify_user_paypal']) && $options['notify_user_paypal'] == "on" && $type == "completed") {
				$user_email_types[] = 'notify_user_paypal';
			}
			if(isset($options['notify_user_paypal_failed']) && $options['notify_user_paypal_failed'] == "on" && $type == "failed") {
				$user_email_types[] = 'notify_user_paypal_failed';
			}
		}
		
		
		/*Attachment*/
		$attachments = ($from == 'book') ? $data['files'] : array();
		
		/*Email to admin*/
		if(count($admin_email_types)) {	
			foreach($admin_email_types as $admin_email_type) {
				$to = "";
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				if(isset($options[$admin_email_type.'_to']) && $options[$admin_email_type.'_to'] != "") {
					$to = stripslashes($options[$admin_email_type.'_to']);
				}
				if(isset($options[$admin_email_type.'_fromname']) && $options[$admin_email_type.'_fromname'] != "") {
					$fromname = stripslashes(self::translated_text($options[$admin_email_type.'_fromname'],$data['lang']));
				}
				if(isset($options[$admin_email_type.'_subject']) && $options[$admin_email_type.'_subject'] != "") {
					$subject = self::translated_text($options[$admin_email_type.'_subject'],$data['lang']);
				}
				if(isset($options[$admin_email_type.'_content']) && $options[$admin_email_type.'_content'] != "") {
					$content = stripslashes(self::translated_text($options[$admin_email_type.'_content'],$data['lang']));
					$content = str_replace("[calendartitle]", $this->get_calendar_title($data['calendar_id']), $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[moderatelink]", $moderate_link, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = str_replace("[totalprice]", $data['total_price'], $content);
					$content = str_replace("[ID]", $data["id"], $content);
					$mail_content = "<div class='wpdevart_email' style='text-align: center;color:".((isset($options['mail_color']) && $options['mail_color'] != "") ? $options['mail_color'] : "#5A5A5A")." !important;background-color:".((isset($options['mail_bg']) && $options['mail_bg'] != "") ? $options['mail_bg'] : "#e8e8f7")." !important;line-height: 1.5;font-size: 15px;'>";
					if(isset($options['mail_header_img']) && $options['mail_header_img'] != ""){
						$mail_content .= "<img src='".esc_url($options['mail_header_img'])."' style='max-width:670px;margin:20px auto 0;'>";
					}
					$mail_content .= "<div style='width: 670px;margin: 0 auto;padding: 15px;background-color:" .((isset($options['mail_content_bg']) && $options['mail_content_bg'] != "") ? $options['mail_content_bg'] : "#e8e8f7")." !important;'>".$content."</div>";
					if(isset($options['mail_footer_text']) && $options['mail_footer_text'] != ""){
						$mail_content .= "<p style='color:" .((isset($options['mail_footer_text_color']) && $options['mail_footer_text_color'] != "") ? $options['mail_footer_text_color'] : "#a7a7a7")." !important;padding: 10px 0; font-size: 13px;'>".$options['mail_footer_text']."</p>";
					}
					$mail_content .= "</div>";
				}
				
				if(isset($options[$admin_email_type.'_from']) && $options[$admin_email_type.'_from'] != "") {
					if(isset($options['use_phpmailer']) && $options['use_phpmailer'] == "on"){
						if(trim($options[$admin_email_type.'_from']) == "[useremail]") {
							$from = $data['email'];
						} else {
							$from = $options[$admin_email_type.'_from'];
						}
					} else {
						if(trim($options[$admin_email_type.'_from']) == "[useremail]") {
							$from = "From: '" . $fromname . "' <" . $data['email'] . ">" . "\r\n";
						} else {
							$from = "From: '" . $fromname . "' <" . stripslashes($options[$admin_email_type.'_from']) . ">" . "\r\n";
						}
					}
				}
				
				
				if(isset($options['use_phpmailer']) && $options['use_phpmailer'] == "on"){
					if(file_exists(ABSPATH . WPINC . '/PHPMailer/PHPMailer.php')){
						$mail_to_send = new \PHPMailer\PHPMailer\PHPMailer();
					}else{
						$mail_to_send = new PHPMailer();
					}
					$mail_to_send->CharSet  = get_option('blog_charset');
					$mail_to_send->FromName = $fromname;
					$mail_to_send->From     = $from;
					$mail_to_send->Subject  = wp_strip_all_tags($subject );
					$mail_to_send->Body 	= $mail_content ;
					if(!$mail_to_send->Body) {	
						$mail_to_send->Body = $mail_to_send->FromName ." sent you this email";
					}
					if(count($attachments)){
						foreach($attachments as $attachment){
							$mail_to_send->AddAttachment($attachment);
						}
					}
					$mail_to_send->AltBody = wp_strip_all_tags($content);
					$mail_to_send->IsHTML(true);
					$to_arr = explode(",", $to);
					foreach($to_arr as $mail){
						$mail_to_send->AddAddress($mail);
					}
					if ($mail_to_send->Send() ) {
						$admin_error_types[$admin_email_type] = true;
					} else {
						$admin_error_types[$admin_email_type] = false;
					}
				} else {
					$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
					$admin_error_types[$admin_email_type] = wp_mail($to, $subject, $mail_content, $headers, $attachments);
				}
			}	
		}	
			/*Email to user*/
		if(count($user_email_types)) {	
			foreach($user_email_types as $user_email_type) {	
				$from = "";
				$fromname = "";
				$subject = "";
				$content = "";
				$to = $data['email'];
				if(isset($options[$user_email_type.'_subject']) && $options[$user_email_type.'_subject'] != "") {
					$subject = self::translated_text($options[$user_email_type.'_subject'],$data['lang']);
				}
				if(isset($options[$user_email_type.'_fromname']) && $options[$user_email_type.'_fromname'] != "") {
					$fromname = stripslashes(self::translated_text($options[$user_email_type.'_fromname'],$data['lang']));
				}
				if(isset($options[$user_email_type.'_content']) && $options[$user_email_type.'_content'] != "") {
					$content = stripslashes(self::translated_text($options[$user_email_type.'_content'],$data['lang']));
					$content = str_replace("[calendartitle]", $this->get_calendar_title($data['calendar_id']), $content);
					$content = str_replace("[details]", $res_info, $content);
					$content = str_replace("[siteurl]", $site_url, $content);
					$content = str_replace("[form]", $form, $content);
					$content = str_replace("[extras]", $extras, $content);
					$content = str_replace("[totalprice]", $data['total_price'], $content);
					$content = str_replace("[ID]", $data["id"], $content);
					$mail_content = "<div class='wpdevart_email' style='text-align: center;color:".((isset($options['mail_color']) && $options['mail_color'] != "") ? $options['mail_color'] : "#5A5A5A")." !important;background-color:".((isset($options['mail_bg']) && $options['mail_bg'] != "") ? $options['mail_bg'] : "#e8e8f7")." !important;line-height: 1.5;font-size: 15px;'>";
					if(isset($options['mail_header_img']) && $options['mail_header_img'] != ""){
						$mail_content .= "<img src='".esc_url($options['mail_header_img'])."' style='max-width:670px;margin:20px auto 0;'>";
					}
					$mail_content .= "<div style='width: 670px;margin: 0 auto;padding: 15px;background-color:" .((isset($options['mail_content_bg']) && $options['mail_content_bg'] != "") ? $options['mail_content_bg'] : "#e8e8f7")." !important;'>".$content."</div>";
					if(isset($options['mail_footer_text']) && $options['mail_footer_text'] != ""){
						$mail_content .= "<p style='color:" .((isset($options['mail_footer_text_color']) && $options['mail_footer_text_color'] != "") ? $options['mail_footer_text_color'] : "#a7a7a7")." !important;padding: 10px 0; font-size: 13px;'>".$options['mail_footer_text']."</p>";
					}
					$mail_content .= "</div>";
				}
				if(isset($options[$user_email_type.'_from']) && $options[$user_email_type.'_from'] != "") {
					if(isset($options['use_phpmailer']) && $options['use_phpmailer'] == "on"){
						$from = $options[$user_email_type.'_from'];
					} else {
						$from = "From: '" . $fromname . "' <" . stripslashes($options[$user_email_type.'_from']) . ">" . "\r\n";
					}
				}
				if(isset($options['use_phpmailer']) && $options['use_phpmailer'] == "on"){
					if(file_exists(ABSPATH . WPINC . '/PHPMailer/PHPMailer.php')){
						$mail_to_send = new \PHPMailer\PHPMailer\PHPMailer();
					}else{
						$mail_to_send = new PHPMailer();
					}
					$mail_to_send->CharSet = 'UTF-8';
					$mail_to_send->FromName = $fromname;
					$mail_to_send->From     = $from;
					$mail_to_send->Subject  = wp_strip_all_tags($subject );
					$mail_to_send->Body 	= $mail_content;
					if(!$mail_to_send->Body) {	
						$mail_to_send->Body = $mail_to_send->FromName ." sent you this email";
					}
					if(count($attachments)){
						foreach($attachments as $attachment){
							$mail_to_send->AddAttachment($attachment);
						}
					}
					$mail_to_send->AltBody = wp_strip_all_tags($content);
					$mail_to_send->IsHTML(true);
					$to_arr = explode(",", $to);
					foreach($to_arr as $mail){
						$mail_to_send->AddAddress($mail);
					}
					if ($mail_to_send->Send() ) {
						$user_error_types[$user_email_type] = true;
					} else {
						$user_error_types[$user_email_type] = false;
					}
				} else {
					$headers = "MIME-Version: 1.0\n" . $from . " Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\n";
					$user_error_types[$user_email_type] = wp_mail($to, $subject, $mail_content, $headers, $attachments);
				}
			}
		}	
		$result = array($admin_error_types,$user_error_types);
		return 	$result;
	}
	
	private function get_calendar_title($cal_id) {
		global $wpdb;
		$title = $wpdb->get_var($wpdb->prepare('SELECT title FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
	   
		return $title;
	}
	
	private function get_form_data($form, $cal_id) {
		global $wpdb;
		if($form) {
			$form_value = json_decode($form, true);
			$form_id = $wpdb->get_var($wpdb->prepare('SELECT form_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$form_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_forms WHERE id="%d"', $form_id));
			$form_info = json_decode($form_info, true);
			if(isset($form_info['apply']) || isset($form_info['save']))	{
				array_shift($form_info);
			}
			foreach($form_info as $key=>$form_fild_info) { 
				if(isset($form_value["wpdevart_".$key])) {
					$form_info[$key]["value"] = $form_value["wpdevart_".$key];
				}
				else {
					$form_info[$key]["value"] = "";
				}
			}
		} else {
			$form_info = array();
		}
		return $form_info;
	} 
	
	private function get_extra_data($extra, $cal_id, $price = false) {
		global $wpdb;
		if($price !== false) {
			$price = $price;
			$extra = $extra;
		} else  {
			$price = $extra["price"];
			$extra = $extra["extras"];
		}
		if($extra) {
			$extras_value = json_decode($extra, true);
			$extra_id = $wpdb->get_var($wpdb->prepare('SELECT extra_id FROM ' . $wpdb->prefix . 'wpdevart_calendars WHERE id="%d"', $cal_id));
			$extra_info = $wpdb->get_var($wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . 'wpdevart_extras WHERE id="%d"', $extra_id));
			$extra_info = json_decode($extra_info, true);
			
			if(isset($extra_info['apply']) || isset($extra_info['save']))	{
				array_shift($extra_info);
			}
			foreach($extras_value as $key=>$extra_value) { 
				if(isset($extra_info[$key])) {
					$extras_value[$key]["group_label"] = $extra_info[$key]["label"];
					if($extra_value['price_type'] == "percent") {
						$extras_value[$key]["price"] = ($price*$extra_value['price_percent'])/100;
					} else {
						$extras_value[$key]["price"] = $extra_value['price_percent'];
					}
				}
				else {
					$extras_value[$key]["group_label"] = "";
				}
			}
		} else {
			$extras_value = array();
		}
		return $extras_value;
	} 
	
 
 public static function get_countries(){
		$countries = array('' => __('Select Country','booking-calendar'),	'AF' => 'Afghanistan',	'AX' => 'Aland Islands',	'AL' => 'Albania',	'DZ' => 'Algeria',	'AS' => 'American Samoa',	'AD' => 'Andorra',	'AO' => 'Angola',	'AI' => 'Anguilla',	'AQ' => 'Antarctica',	'AG' => 'Antigua And Barbuda',	'AR' => 'Argentina',	'AM' => 'Armenia',	'AW' => 'Aruba',	'AU' => 'Australia',	'AT' => 'Austria',	'AZ' => 'Azerbaijan',	'BS' => 'Bahamas',	'BH' => 'Bahrain',	'BD' => 'Bangladesh',	'BB' => 'Barbados',	'BY' => 'Belarus',	'BE' => 'Belgium',	'BZ' => 'Belize',	'BJ' => 'Benin',	'BM' => 'Bermuda',	'BT' => 'Bhutan',	'BO' => 'Bolivia',	'BA' => 'Bosnia And Herzegovina',	'BW' => 'Botswana',	'BV' => 'Bouvet Island',	'BR' => 'Brazil',	'IO' => 'British Indian Ocean Territory',	'BN' => 'Brunei Darussalam',	'BG' => 'Bulgaria',	'BF' => 'Burkina Faso',	'BI' => 'Burundi',	'KH' => 'Cambodia',	'CM' => 'Cameroon',	'CA' => 'Canada',	'CV' => 'Cape Verde',	'KY' => 'Cayman Islands',	'CF' => 'Central African Republic',	'TD' => 'Chad',	'CL' => 'Chile',	'CN' => 'China',	'CX' => 'Christmas Island',	'CC' => 'Cocos (Keeling) Islands',	'CO' => 'Colombia',	'KM' => 'Comoros',	'CG' => 'Congo',	'CD' => 'Congo, Democratic Republic',	'CK' => 'Cook Islands',	'CR' => 'Costa Rica',	'CI' => 'Cote D\'Ivoire',	'HR' => 'Croatia',	'CU' => 'Cuba',	'CY' => 'Cyprus',	'CZ' => 'Czech Republic',	'DK' => 'Denmark',	'DJ' => 'Djibouti',	'DM' => 'Dominica',	'DO' => 'Dominican Republic',	'EC' => 'Ecuador',	'EG' => 'Egypt',	'SV' => 'El Salvador',	'GQ' => 'Equatorial Guinea',	'ER' => 'Eritrea',	'EE' => 'Estonia',	'ET' => 'Ethiopia',	'FK' => 'Falkland Islands (Malvinas)',	'FO' => 'Faroe Islands',	'FJ' => 'Fiji',	'FI' => 'Finland',	'FR' => 'France',	'GF' => 'French Guiana',	'PF' => 'French Polynesia',	'TF' => 'French Southern Territories',	'GA' => 'Gabon',	'GM' => 'Gambia',	'GE' => 'Georgia',	'DE' => 'Germany',	'GH' => 'Ghana',	'GI' => 'Gibraltar',	'GR' => 'Greece',	'GL' => 'Greenland',	'GD' => 'Grenada',	'GP' => 'Guadeloupe',	'GU' => 'Guam',	'GT' => 'Guatemala',	'GG' => 'Guernsey',	'GN' => 'Guinea',	'GW' => 'Guinea-Bissau',	'GY' => 'Guyana',	'HT' => 'Haiti',	'HM' => 'Heard Island & Mcdonald Islands',	'VA' => 'Holy See (Vatican City State)',	'HN' => 'Honduras',	'HK' => 'Hong Kong',	'HU' => 'Hungary',	'IS' => 'Iceland',	'IN' => 'India',	'ID' => 'Indonesia',	'IR' => 'Iran, Islamic Republic Of',	'IQ' => 'Iraq',	'IE' => 'Ireland',	'IM' => 'Isle Of Man',	'IL' => 'Israel',	'IT' => 'Italy',	'JM' => 'Jamaica',	'JP' => 'Japan',	'JE' => 'Jersey',	'JO' => 'Jordan',	'KZ' => 'Kazakhstan',	'KE' => 'Kenya',	'KI' => 'Kiribati',	'KR' => 'Korea',	'KW' => 'Kuwait',	'KG' => 'Kyrgyzstan',	'LA' => 'Lao People\'s Democratic Republic',	'LV' => 'Latvia',	'LB' => 'Lebanon',	'LS' => 'Lesotho',	'LR' => 'Liberia',	'LY' => 'Libyan Arab Jamahiriya',	'LI' => 'Liechtenstein',	'LT' => 'Lithuania',	'LU' => 'Luxembourg',	'MO' => 'Macao',	'MK' => 'Macedonia',	'MG' => 'Madagascar',	'MW' => 'Malawi',	'MY' => 'Malaysia',	'MV' => 'Maldives',	'ML' => 'Mali',	'MT' => 'Malta',	'MH' => 'Marshall Islands',	'MQ' => 'Martinique',	'MR' => 'Mauritania',	'MU' => 'Mauritius',	'YT' => 'Mayotte',	'MX' => 'Mexico',	'FM' => 'Micronesia, Federated States Of',	'MD' => 'Moldova',	'MC' => 'Monaco',	'MN' => 'Mongolia',	'ME' => 'Montenegro',	'MS' => 'Montserrat',	'MA' => 'Morocco',	'MZ' => 'Mozambique',	'MM' => 'Myanmar',	'NA' => 'Namibia',	'NR' => 'Nauru',	'NP' => 'Nepal',	'NL' => 'Netherlands',	'AN' => 'Netherlands Antilles',	'NC' => 'New Caledonia',	'NZ' => 'New Zealand',	'NI' => 'Nicaragua',	'NE' => 'Niger',	'NG' => 'Nigeria',	'NU' => 'Niue',	'NF' => 'Norfolk Island',	'MP' => 'Northern Mariana Islands',	'NO' => 'Norway',	'OM' => 'Oman',	'PK' => 'Pakistan',	'PW' => 'Palau',	'PS' => 'Palestinian Territory, Occupied',	'PA' => 'Panama',	'PG' => 'Papua New Guinea',	'PY' => 'Paraguay',	'PE' => 'Peru',	'PH' => 'Philippines',	'PN' => 'Pitcairn',	'PL' => 'Poland',	'PT' => 'Portugal',	'PR' => 'Puerto Rico',	'QA' => 'Qatar',	'RE' => 'Reunion',	'RO' => 'Romania',	'RU' => 'Russian Federation',	'RW' => 'Rwanda',	'BL' => 'Saint Barthelemy',	'SH' => 'Saint Helena',	'KN' => 'Saint Kitts And Nevis',	'LC' => 'Saint Lucia',	'MF' => 'Saint Martin',	'PM' => 'Saint Pierre And Miquelon',	'VC' => 'Saint Vincent And Grenadines',	'WS' => 'Samoa',	'SM' => 'San Marino',	'ST' => 'Sao Tome And Principe',	'SA' => 'Saudi Arabia',	'SN' => 'Senegal',	'RS' => 'Serbia',	'SC' => 'Seychelles',	'SL' => 'Sierra Leone',	'SG' => 'Singapore',	'SK' => 'Slovakia',	'SI' => 'Slovenia',	'SB' => 'Solomon Islands',	'SO' => 'Somalia',	'ZA' => 'South Africa',	'GS' => 'South Georgia And Sandwich Isl.',	'ES' => 'Spain',	'LK' => 'Sri Lanka',	'SD' => 'Sudan',	'SR' => 'Suriname',	'SJ' => 'Svalbard And Jan Mayen',	'SZ' => 'Swaziland',	'SE' => 'Sweden',	'CH' => 'Switzerland',	'SY' => 'Syrian Arab Republic',	'TW' => 'Taiwan',	'TJ' => 'Tajikistan',	'TZ' => 'Tanzania',	'TH' => 'Thailand',	'TL' => 'Timor-Leste',	'TG' => 'Togo',	'TK' => 'Tokelau',	'TO' => 'Tonga',	'TT' => 'Trinidad And Tobago',	'TN' => 'Tunisia',	'TR' => 'Turkey',	'TM' => 'Turkmenistan',	'TC' => 'Turks And Caicos Islands',	'TV' => 'Tuvalu',	'UG' => 'Uganda',	'UA' => 'Ukraine',	'AE' => 'United Arab Emirates',	'GB' => 'United Kingdom',	'US' => 'United States',	'UM' => 'United States Outlying Islands',	'UY' => 'Uruguay',	'UZ' => 'Uzbekistan',	'VU' => 'Vanuatu',	'VE' => 'Venezuela',	'VN' => 'Viet Nam',	'VG' => 'Virgin Islands, British',	'VI' => 'Virgin Islands, U.S.',	'WF' => 'Wallis And Futuna',	'EH' => 'Western Sahara',	'YE' => 'Yemen',	'ZM' => 'Zambia',	'ZW' => 'Zimbabwe',);
		return $countries;
	}
}
?>