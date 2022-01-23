<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Admin menu
function cacsp_menu() {
	add_options_page( __( 'Cookies and Content Security Policy', 'cookies-and-content-security-policy' ), __( 'Cookies and Content Security Policy', 'cookies-and-content-security-policy' ), 'manage_options', 'cacsp_settings', 'cacsp_options' );
}

// Settings textarea table row
function cacsp_settings_textarea_row( $header, $id, $value, $code = true, $example = '', $placeholder = '' ) {
	if ( $code ) {
		$code = ' code';
	}
	if ( !$value ) {
		$value = esc_attr( $placeholder );
	}
	$cacsp_settings_textarea_row = '<tr valign="top">
		<th scope="row">' . $header . '</th>
		<td>
			<textarea name="' . $id . '" id="' . $id . '" rows="10" cols="50" class="large-text' . $code . '" placeholder="' . esc_attr( $placeholder ) . '">' . $value . '</textarea>';
			if ( $example ) {
				$cacsp_settings_textarea_row .= '<small>' . __( 'Example:', 'cookies-and-content-security-policy' ) . '<br>' . $example . '</small>';
			}
		$cacsp_settings_textarea_row .= '</td> 
	</tr>';
	return $cacsp_settings_textarea_row;
}

// Settings input table row
function cacsp_settings_input_row( $header, $id, $value, $code = true, $example = '', $placeholder = '', $description = '', $type = 'text' ) {
	if ( $code ) {
		$code = ' code';
	}
	if ( !$value ) {
		$value = esc_attr( $placeholder );
	}
	$cacsp_settings_input_row = '<tr valign="top">
		<th scope="row">' . $header . '</th>
		<td>
			<input name="' . $id . '" type="' . $type . '" id="' . $id . '" value="' . $value . '" class="large-text' . $code . '" placeholder="' . esc_attr( $placeholder ) . '">';
			if ( $example ) {
				$cacsp_settings_input_row .= '<small>' . __( 'Example:', 'cookies-and-content-security-policy' ) . '<br>' . $example . '</small>';
			}
			if ( $description ) {
				$cacsp_settings_input_row .= '<small>' . $description . '</small>';
			}
			$cacsp_settings_input_row .= '
		</td> 
	</tr>';
	return $cacsp_settings_input_row;
}

// Check if domain exists berfor adding from Quickstart
function cacsp_check_existing_domain( $add_domain, $domain_group ) {
	$domains = get_cacsp_options( $domain_group, false, '', true );
	$domains_arr = explode( "\n", $domains );
	foreach ( $domains_arr as &$domain ) {
		if ( $domain == $add_domain ) {
			$add_domain = '';
			break;
		}
	}
	if ( strlen( $add_domain ) > 0 ) {
		return $add_domain . "\n";
	}
}

// Admin page
add_action( 'admin_menu', 'cacsp_menu' );
function cacsp_options() {
	include_once( 'settings-cacsp-update-options.php' );
	?>

	<div class="wrap">
		<h1><?php _e( 'Cookies and Content Security Policy', 'cookies-and-content-security-policy' ); ?></h1>

		<form method="post">
			<?php
			$tab = '';
			if ( isset( $_GET[ 'tab' ] ) ) {
				$tab = sanitize_key( $_GET[ 'tab' ] );
			}
			$active_tab = strlen( $tab ) ? $tab : 'activate';
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=cacsp_settings&tab=activate" class="nav-tab <?php echo $active_tab == 'activate' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Activate', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=quickstart" class="nav-tab <?php echo $active_tab == 'quickstart' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Quickstart', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=domains" class="nav-tab <?php echo $active_tab == 'domains' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Domains', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=texts" class="nav-tab <?php echo $active_tab == 'texts' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Texts', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=colors" class="nav-tab <?php echo $active_tab == 'colors' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Colors', 'cookies-and-content-security-policy' ); ?></a>
				<a href="?page=cacsp_settings&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Support', 'cookies-and-content-security-policy' ); ?></a>
			</h2>
			<?php if ( $active_tab == 'activate' ) {
				include_once( 'settings-cacsp-tab-activate.php' );
			} elseif ( $active_tab == 'quickstart' ) { 
				include_once( 'settings-cacsp-tab-quickstart.php' );
			} elseif ( $active_tab == 'domains' ) { 
				include_once( 'settings-cacsp-tab-domains.php' );
			} elseif ( $active_tab == 'texts' ) {
				include_once( 'settings-cacsp-tab-texts.php' );
			} elseif ( $active_tab == 'settings' ) {
				include_once( 'settings-cacsp-tab-settings.php' );
			} elseif ( $active_tab == 'colors' ) {
				include_once( 'settings-cacsp-tab-colors.php' );
			} elseif ( $active_tab == 'support' ) {
				include_once( 'settings-cacsp-tab-support.php' );
			}
			wp_nonce_field( 'cacsp_nonce_action', 'cacsp_nonce_name', false );
			?>
		</form>
	</div>
	<script>
	jQuery(function() {
		var cookiesAndContentPolicyForm = jQuery('.settings_page_cacsp_settings form');
		var initialState = cookiesAndContentPolicyForm.serialize();
		jQuery('.settings_page_cacsp_settings a.nav-tab ').click(function (e) {
			if (initialState !== cookiesAndContentPolicyForm.serialize()) {
				window.onbeforeunload = function() {
				   return '<?php _e( 'You have unsaved changes, do you want to continue?', 'cookies-and-content-security-policy' ); ?>';
				};
			}
		});
	});
	jQuery(function() {
	    jQuery('.cacsp-color').wpColorPicker();
	});
	</script>
<?php
}
