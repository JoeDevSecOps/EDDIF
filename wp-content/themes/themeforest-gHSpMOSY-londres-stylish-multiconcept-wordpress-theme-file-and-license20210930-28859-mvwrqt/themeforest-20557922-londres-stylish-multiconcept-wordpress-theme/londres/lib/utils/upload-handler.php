<?php

add_action ('wp_ajax_call_upper_upload_handler', 'upper_upload_handler') ;

function upper_upload_handler(){
	
	if (!isset($_POST)) wp_send_json_error('no direct access');
	if (!wp_verify_nonce($_POST['security'],'londres-theme-upload-handler')) return;
	
	if(current_user_can('edit_posts')){
		$uploads_dir=wp_upload_dir();
	 
		$uploaddir = $uploads_dir['path'];
		$uploadname=str_replace(' ','', basename($_FILES['upperfile']['name']));
	
		if(file_exists($uploaddir.'/'.$uploadname)){
			$uploadname=time().$uploadname;
		}
		$uploadfile = $uploaddir.'/'.$uploadname;
	 
	 
		if (move_uploaded_file($_FILES['upperfile']['tmp_name'], $uploadfile)) {
		  echo wp_kses_post($uploadname);
		} else {
		  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
		  // Otherwise onSubmit event will not be fired
		  echo "error";
		}
	} else {
		echo 'you don\'t have permission to access this file';
	}
	
	wp_die();
}

?>