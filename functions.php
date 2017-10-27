<?php
/* THEME CONTENT WIDTH
============================== */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

/* THEME VARIABLES
============================== */
define('TT_LIB', get_template_directory()  . '/lib');
define('TT_LIB_URI', get_template_directory_uri()  . '/lib');

/* REDUX THEME OPTIONS
	============================== */
if ( ! class_exists( 'Redux' ) && file_exists( TT_LIB . '/redux/ReduxCore/framework.php' ) ) {
	require_once( TT_LIB . '/redux/ReduxCore/framework.php' );
}
if ( ! isset( $redux_demo ) && file_exists( TT_LIB . '/inc/redux/realty-config.php' ) && file_exists( TT_LIB . '/inc/redux/loader.php' ) ) {
	require_once( TT_LIB . '/inc/redux/loader.php' ); // Load Redux extensions
	require_once( TT_LIB . '/inc/redux/realty-config.php' );
}


/* META BOXES
============================== */
define( 'RWMB_URL', trailingslashit( TT_LIB_URI . '/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( TT_LIB . '/meta-box' ) );
require_once TT_LIB . '/meta-box/meta-box.php';
include_once TT_LIB . '/meta-box.php';
			
			
/* REDUX FRAMEWORK FONTAWESOME
============================== */
function tt_themeOptionsStyles($hook) {
	if( 'themes.php?page=_options' == $hook ) {
  	return;
  }
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), time(), 'all' );  
	wp_enqueue_style( 'redux-custom', get_template_directory_uri() . '/lib/inc/redux/style.css', array(), time(), 'all' );  
	wp_enqueue_style( 'custom-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), time(), 'all' );  
	
}
add_action( 'admin_enqueue_scripts', 'tt_themeOptionsStyles');


/* TGM PLUGIN ACTIVATION
============================== */
require_once TT_LIB . '/tgm/class-tgm-plugin-activation.php';
require_once TT_LIB . '/tgm/plugins.php';


/* CUSTOM POST TYPES
============================== */
require_once ( TT_LIB . '/shortcodes.php' );
require_once ( TT_LIB . '/inc/custom-post-type-property.php' );


/* WIDGETS
============================== */
require_once ( TT_LIB . '/widgets/widget-agent-properties.php' );
require_once ( TT_LIB . '/widgets/widget-custom-property-search-form.php' );
require_once ( TT_LIB . '/widgets/widget-featured-agent.php' );
require_once ( TT_LIB . '/widgets/widget-featured-properties.php' );
require_once ( TT_LIB . '/widgets/widget-latest-posts.php' );
require_once ( TT_LIB . '/widgets/widget-membership-packages.php' );
require_once ( TT_LIB . '/widgets/widget-property-search-form.php' );
require_once ( TT_LIB . '/widgets/widget-property-listing.php' );
require_once ( TT_LIB . '/widgets/widget-property-map.php' );
require_once ( TT_LIB . '/widgets/widget-single-property.php' );
require_once ( TT_LIB . '/widgets/widget-testimonials.php' );


/* OTHER FUNCTIONS
============================== */
require_once ( TT_LIB . '/advanced-custom-fields.php' );
require_once ( TT_LIB . '/functions/function-membership.php' );
require_once ( TT_LIB . '/functions/function-page-builder.php' );
require_once ( TT_LIB . '/functions/function-property-search.php' );
require_once ( TT_LIB . '/functions/function-single-property.php' );
require_once ( TT_LIB . '/property-views.php' );


/* OTHER INCLUDES
============================== */
require_once ( TT_LIB . '/inc/custom-styles.php' );
require_once ( TT_LIB . '/inc/custom-scripts.php' );
require_once ( TT_LIB . '/inc/template-tags.php' );
require_once ( TT_LIB . '/tinymce/tinymce-buttons.php' );
require_once ( TT_LIB . '/add-to-favorites.php' );
require_once ( TT_LIB . '/add-to-follow.php' );
require_once ( TT_LIB . '/compare-properties.php' );
require_once ( TT_LIB . '/stripe/stripe-payments.php' );


/* ENQUEUES
============================== */
function tt_realty_scripts() {
	
	global $realty_theme_option;
	
	if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) {
		//wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/assets/css/bootstrap-rtl.min.css', null, '3.3.4' );
		wp_enqueue_style( 'bootstrap-rtl', '//cdn.rawgit.com/morteza/bootstrap-rtl/master/dist/css/bootstrap-rtl.min.css', null, '3.3.4' );
	}
	
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:100,100italic,300,300italic,regular,italic,700,700italic,900,900italic', null, null );
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/css/main.min.css', null, null );
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, null );
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if ( is_plugin_active( 'dsidxpress/dsidxpress.php' ) ) {
		wp_enqueue_style( 'tt-dsidxpress', get_template_directory_uri() . '/assets/css/idx.css', null, null );
	}
	
	wp_enqueue_style( 'print', get_template_directory_uri() . '/print.css', null, null, 'print' );
	
	if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) {
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/rtl.css', null, null );
	}
	
	wp_enqueue_script( 'jquery', null, null, false );
	
	// Avoid duplicate API load: Check for page template "Property Submit", "IDX" and if theme option "Google Maps API" i off
	$disableGoogleMapsApi = $realty_theme_option['disable-google-maps-api'];
	if ( ! is_page_template('template-idx.php') && $disableGoogleMapsApi == false ) {
		wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&v=3', array( 'jquery' ), null, false );
	}
	
	if ( is_page_template( 'template-property-submit.php' ) ) {
		wp_enqueue_media();	
	} 
	
	if ( ! is_page_template('template-idx.php') ) {
		wp_enqueue_script( 'google-maps-min', get_template_directory_uri() . '/assets/js/google-maps.min.js', array( 'jquery' ), null, true );
	}
	
	// Main JS file
	wp_enqueue_script( 'tt-theme-main', get_template_directory_uri() . '/assets/js/theme-main.min.js', array( 'jquery' ), null, true ); 	
	
	if ( is_page_template( 'template-property-submit-listing.php' ) ) {
		wp_enqueue_script( 'paypal-button', TT_LIB_URI . '/paypal/paypal-button.min.js', array( 'jquery' ), null, false );
	}
	
	// Map Style
  wp_localize_script( 'jquery', 'map_options', array( 'map_style' => $realty_theme_option['map-style'] ) );
	
	if ( $realty_theme_option['datepicker-language'] && $realty_theme_option['datepicker-language'] != 'en' && !is_page_template( 'template-property-submit.php' ) ) {
		wp_enqueue_script( 'datepicker-'. $realty_theme_option['datepicker-language'], get_template_directory_uri() . '/assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.' . $realty_theme_option['datepicker-language'] . '.js', array('tt-theme-main' ), null, false ); 
	}
	
	if ( ! $realty_theme_option['property-favorites-disabled'] && $realty_theme_option['property-favorites-temporary'] ) {	
		wp_enqueue_script( 'ajax-favorites-temporary', get_template_directory_uri() . '/assets/js/ajax-favorites-temporary.js', array( 'tt-theme-main' ), null, true );
	}
	
	if ( is_page_template( 'template-property-submit.php' ) ) {
		wp_enqueue_script( 'property-submit', get_template_directory_uri() . '/assets/js/theme-property-submit.js', array( 'jquery' ), null, true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if( isset( $_GET['sign-user'] ) || isset( $_GET['user-register'] ) ) {
		wp_enqueue_style( 'tt-notify-css', get_template_directory_uri() . '/assets/js/jquery-notification/css/jquery.notifyBar.css', null, null );
		wp_enqueue_script( 'tt-notify-bar', get_template_directory_uri() . '/assets/js/jquery-notification/jquery.notifyBar.js', array( 'jquery' ), null, true ); 
	}
	
}
add_action( 'wp_enqueue_scripts', 'tt_realty_scripts' );


/* CUSTOM LOGIN PAGE (wp-login.php)
============================== */
function tt_custom_login() {

	// Login Page Logo
	$output  = '<style type="text/css">';
	global $realty_theme_option;
	$login_logo = $realty_theme_option['logo-login']['url'];
	$background_login = $realty_theme_option['background-login'];
	if ( !empty( $login_logo ) ) {
		$output .= '.login h1 a { background: url(' . $login_logo . ') 50% 50% no-repeat !important; width: auto; }';
	}
	if ( $background_login ) {
		$output .= '.login { background-color: ' . $background_login . '; }';
	}
	else {
		$output .= '.login { background-color: #f8f8f8; }';
	}
	$output .= '.login form input[type="submit"] { border-radius: 0; border: none; -webkit-box-shadow: none; box-shadow: none; }';
	$output .= '.login form .input, .login .form input:focus { padding: 5px 10px; color: #666; -webkit-box-shadow: none; box-shadow: none; }';
	$output .= 'input[type=checkbox]:focus, input[type=email]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=url]:focus, select:focus, textarea:focus { -webkit-box-shadow: none; box-shadow: none; }';
	$output .= '</style>';
	
	echo $output;
	
	// Remove Login Shake
	remove_action('login_head', 'wp_shake_js', 12);

}
add_action('login_head', 'tt_custom_login');

// Email content type
function tt_set_html_content_type() {
	return 'text/html';
}

// Login Logo Link
function tt_wp_login_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'tt_wp_login_url' );


/* SETUP THEME
============================== */
function tt_estate_setup() {
	
	// Make theme available for translation.
	load_theme_textdomain( 'tt', get_template_directory() . '/languages' );
	
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( 'assets/css/editor-styles.css' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	// Enable support for Post Thumbnails and declare custom sizes.
	add_theme_support( 'post-thumbnails' );
	
	// Custom Image Sizes
	add_image_size( 'thumbnail-1600', 1600, 9999, false ); // NEW in v1.6.2 - Regenerate thumbnails: https://wordpress.org/plugins/regenerate-thumbnails/
	add_image_size( 'thumbnail-1200', 1200, 9999, false );
	add_image_size( 'thumbnail-16-9', 1200, 675, true );
	add_image_size( 'thumbnail-1200-400', 1200, 400, true );
	add_image_size( 'thumbnail-400-300', 400, 300, true );	
	add_image_size( 'property-thumb', 600, 300, true );
	add_image_size( 'square-400', 400, 400, true );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array( 'primary' => __( 'Main Menu', 'tt' ) ) );
	register_nav_menus( array( 'footer' => __( 'Footer Menu', 'tt' ) ) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', ) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'video' ) );

}
add_action( 'after_setup_theme', 'tt_estate_setup' );

/* Thumbnail size in wordpress 4.2.2. */
add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup() {
	add_image_size( 'edit-screen-thumbnail', 150, 150, true );
}


/* Sidebars
============================== */

// No Title > Add Widget Content Wrapper To Widget
// http://wordpress.stackexchange.com/questions/74732/adding-a-div-to-wrap-widget-content-after-the-widget-title
function tt_check_sidebar_params( $params ) {
  global $wp_registered_widgets;

  $settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
  if(is_object( $settings_getter )) {
	  
	  $settings = $settings_getter->get_settings();
	  $settings = $settings[ $params[1]['number'] ];
	
	  if ( $params[0][ 'after_widget' ] == '</div></li>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) ) {
		$params[0][ 'before_widget' ] .= '<div class="empty-title">';
	  }

  }
		
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'tt_check_sidebar_params' );

register_sidebar(
	array(
		'name'				=> __( 'Blog Sidebar', 'tt' ),
		'id'   				=> 'sidebar_blog',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Property Sidebar', 'tt' ),
		'id'   				=> 'sidebar_property',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Agent Sidebar', 'tt' ),
		'id'   				=> 'sidebar_agent',
		'before_widget' 	=> '<li class="widget %2$s">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5><div class="widget-content">'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Page Sidebar', 'tt' ),
		'id'   				=> 'sidebar_page',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Contact Sidebar', 'tt' ),
		'id'   				=> 'sidebar_contact',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'IDX Sidebar', 'tt' ),
		'id'   				=> 'sidebar_idx',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Footer Column 1', 'tt' ),
		'id'   				=> 'sidebar_footer_1',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Footer Column 2', 'tt' ),
		'id'   				=> 'sidebar_footer_2',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);

register_sidebar( 
	array(
		'name'				=> __( 'Footer Column 3', 'tt' ),
		'id'   				=> 'sidebar_footer_3',
		'before_widget' 	=> '<li class="widget %2$s"><div class="widget-content">',
		'after_widget' 		=> '</div></li>',
		'before_title' 		=> '<h5 class="widget-title">',
		'after_title' 		=> '</h5>'
	)
);


/* AJAX - WordPress URL
============================== */
function tt_ajax_url() {
?>
<script type="text/javascript">
var ajaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php 
}
add_action('wp_head','tt_ajax_url');


/* Add "Lost Password" link to wp_login_form()
============================== */	
function tt_add_lost_password_link() {
	return '<a href="' . wp_lostpassword_url(get_permalink()) . '">'.__("Lost Password?", "tt").'</a>';
}
add_action( 'login_form_bottom', 'tt_add_lost_password_link' );
function tt_lost_password_redirect() {
    wp_redirect( home_url() ); 
    exit;
}
add_action('password_reset', 'tt_lost_password_redirect');

//* Change the message/body of the email
add_filter( 'retrieve_password_message', 'wpse_retrieve_password_message', 10, 2 );
function wpse_retrieve_password_message( $message, $key ){
    $user_data = '';
    // If no value is posted, return false
    if( ! isset( $_POST['user_login'] )  ){
            return '';
    }
    // Fetch user information from user_login
    if ( strpos( $_POST['user_login'], '@' ) ) {

        $user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    if( ! $user_data  ){
        return '';
    }
	add_filter( 'wp_mail_content_type', 'tt_set_html_content_type');
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    // Setting up message for retrieve password
    $message = "Looks like you want to reset your password!\n\n";
    $message .= "Please click on this link:\n";
    $message .= '<a href="';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $message .= '">"';
    $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    $message .= '"</a>\n\n"';
    $message .= 'Kind Regards,<br/>Dream Team';
    // Return completed message for retrieve password
    return $message;
}
/* Login Failed - Username & Password Entered, But Incorrect
http://www.paulund.co.uk/create-your-own-wordpress-login-page
============================== */
function tt_login_failed( $user ) {

	$referrer = $_SERVER['HTTP_REFERER'];
	
  // Check that were not on the default login page
	if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) && $user != null ) {
		// Make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' ) ) {
			// Redirect to login page and append a querystring of login failed
	    wp_redirect( $referrer . '?login=failed');
	  } else {
	  	wp_redirect( $referrer );
	  }
	  exit;
	}
	
}
add_action( 'wp_login_failed', 'tt_login_failed' );


/* Login Form Bottom - Add Login Errors
============================== */
function tt_login_form_bottom() {
	return '<div id="login-errors"></div>';
}
//add_action( 'login_form_bottom', 'tt_login_form_bottom' );


/* Login Failed - No Username & Password Entered
http://www.paulund.co.uk/create-your-own-wordpress-login-page
============================== */
function tt_login_blank( $user ) {

	if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
  	$referrer = $_SERVER['HTTP_REFERER'];
  }
  else {
	 	$referrer = '';
  }
  
  $error = false;

	// Check Login
	if( isset($_POST['log']) && $_POST['log'] == '' || isset($_POST['pwd']) && $_POST['pwd'] == '' ) {
		$error = true;
	}

	// Check that were not on the default login page
	if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer, 'wp-admin' ) && $error ) {
		// Make sure we don't already have a failed login attempt
  	if ( !strstr($referrer, '?login=failed') ) {
  		// Redirect to the login page and append a querystring of login failed
      wp_redirect( $referrer . '?login=failed' );
    } else {
      wp_redirect( $referrer );
    }
  exit;
	}
  	
}
add_action( 'authenticate', 'tt_login_blank' );


/* Disable WP Admin Bar For Non-Admins
============================== */
function tt_remove_admin_bar() {
	if ( !current_user_can('administrator') && !is_admin() ) {
	  show_admin_bar(false);
	}
} 
add_action( 'after_setup_theme', 'tt_remove_admin_bar' ); 


/* Disable wp-admin For Non-Admins, If Not Running Ajax OR Updating User Data
============================== */
function tt_disable_wp_admin_for_non_admins() {
  if ( !current_user_can('manage_options') &&  $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php' && !tt_ajax_add_remove_favorites() && !tt_ajax_update_user_profile_function() ) {
  	wp_redirect( home_url() ); 
  	exit;
  }
}
//add_action('admin_init', 'tt_disable_wp_admin_for_non_admins');


/* Login with Username OR Email Address
http://en.bainternet.info/wordpress-allow-login-with-email/
============================== */
function tt_allow_email_login( $user, $username, $password ) {
	if ( is_email( $username ) ) {
		$user = get_user_by_email( $username );
		if ( $user ) {
			$username = $user->user_login;
		}
	}
	return wp_authenticate_username_password(null, $username, $password );
}
add_filter( 'authenticate', 'tt_allow_email_login', 20, 3 );


/* CUSTOM MAP MARKERS ICONS
============================== */
if ( ! function_exists( 'tt_mapMarkers' ) ) {
	function tt_mapMarkers() {
	
		global $realty_theme_option;
		
		$default_marker_property = $realty_theme_option['map-marker-property-default'];	
		
		if ( !empty( $realty_theme_option['map-marker-property']['url'] ) ) {
			
			if ( is_ssl() ) {
		    $custom_marker_property_url = str_replace( 'http://', 'https://', $realty_theme_option['map-marker-property']['url'] );
		  }
		  else {
			  $custom_marker_property_url = $realty_theme_option['map-marker-property']['url'];
		  }
			
			$custom_marker_property = $realty_theme_option['map-marker-property'];
			$custom_marker_property_width_retina = $custom_marker_property['width'] / 2;
			$custom_marker_property_height_retina = $custom_marker_property['height'] / 2;
			
		}
		
		$default_marker_cluster = $realty_theme_option['map-marker-cluster-default'];	
		
		if ( !empty( $realty_theme_option['map-marker-cluster']['url'] ) ) {
			
			if ( is_ssl() ) {
		    $custom_marker_cluster_url = str_replace( 'http://', 'https://', $realty_theme_option['map-marker-cluster']['url'] );
		  }
		  else {
			  $custom_marker_cluster_url = $realty_theme_option['map-marker-cluster']['url'];
		  }
		  
			$custom_marker_cluster = $realty_theme_option['map-marker-cluster'];
			$custom_marker_cluster_width_retina = $custom_marker_cluster['width'] / 2;
			$custom_marker_cluster_height_retina = $custom_marker_cluster['height'] / 2;
			
		}
	
		// Check For Custom Marker Property
		if ( !empty( $realty_theme_option['map-marker-property']['url'] ) ) {
		?>
	var customIcon = new google.maps.MarkerImage(
		'<?php echo $custom_marker_property['url']; ?>',
		null, // size is determined at runtime
	  null, // origin is 0,0
	  null, // anchor is bottom center of the scaled image
	  new google.maps.Size(<?php echo $custom_marker_property_width_retina; ?>, <?php echo $custom_marker_property_height_retina; ?>)
	);			
		<?php
		}
		// No Custom Marker Property Found: Use Default
		else {
		?>
	var customIcon = new google.maps.MarkerImage(
		'<?php echo $default_marker_property; ?>',
		null, // size is determined at runtime
	  null, // origin is 0,0
	  null, // anchor is bottom center of the scaled image
	  new google.maps.Size(50, 69)
	);
		<?php }
		
		// Check For Custom Marker Cluster
		if ( !empty( $realty_theme_option['map-marker-cluster']['url'] ) ) {
		?>
	var markerClusterOptions = {
		gridSize: 60, // Default: 60
		maxZoom: 14,
		styles: [{
			width: <?php echo $custom_marker_cluster_width_retina; ?>,
			height: <?php echo $custom_marker_cluster_height_retina; ?>,
			url: "<?php echo $custom_marker_cluster['url']; ?>"
		}]
	};
		<?php
		}
		// No Custom Marker Cluster Found: Use Default
		else {
		?>
	var markerClusterOptions = {
		gridSize: 60, // Default: 60
		maxZoom: 14,
		styles: [{
			width: 50,
			height: 50,
			url: "<?php echo $default_marker_cluster; ?>"
		}]
	};
		<?php }
	
	}
}


/* Excerpt
============================== */
function tt_excerpt_more( $more ) {
	return ' ..';
}
add_filter('excerpt_more', 'tt_excerpt_more');

function tt_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'tt_excerpt_length', 999 );


/* PROPERTY
============================== */

// Property Price
if ( ! function_exists( 'tt_property_price' ) ) {
	function tt_property_price() {
		
		global $post, $realty_theme_option;
		
		$property_price = doubleval( get_post_meta( $post->ID, 'estate_property_price', true ) );
		$property_price_prefix = get_post_meta( $post->ID, 'estate_property_price_prefix', true );
		$property_price_suffix = get_post_meta( $post->ID, 'estate_property_price_suffix', true );
		
		$currency_sign = $realty_theme_option['currency-sign'];
		$currency_sign_position = $realty_theme_option['currency-sign-position'];
		$price_thousands_separator = $realty_theme_option['price-thousands-separator'];
		$price_prefix = $realty_theme_option['price-prefix'];
		$price_suffix = $realty_theme_option['price-suffix'];
		
		if ( $realty_theme_option['price-decimals'] ) {
			$decimals = $realty_theme_option['price-decimals'];
		}
		else {
			$decimals = 0;
		}
		$decimal_point = '.';
		
		// Default Currency Sign "$"
		if ( empty( $currency_sign ) ) {
	  	$currency_sign = __( '$', 'tt' );
	  }
	  
	  if ( !empty( $property_price ) ) {
		  
		  if ( $property_price == -1 ) {
				$output = __( 'Price Upon Request', 'tt' );  
			}
		    
			else if ( $property_price ) {
				
				$output = '';
				
				if ( $property_price_prefix ) {
					$output .= $property_price_prefix . "&nbsp;";
				} else if ( $price_prefix ) {
					$output .= $price_prefix . "&nbsp;";
				}
		
				$formatted_price = number_format( $property_price, $decimals, $decimal_point, $price_thousands_separator );
				
				if( $currency_sign_position == 'right' ) {
					$output .= $formatted_price . $currency_sign;
				} else {
					$output .= $currency_sign . $formatted_price;
				}
				
				if ( $property_price_suffix ) {
					$output .= $property_price_suffix;
				} else if ( $price_suffix ) {
					$output .= $price_suffix;
				}
				
			}
			
			else {
				$output = false;
			}
		
		return $output;
		
		}
		
	}
}

// New Property
if ( ! function_exists( 'tt_icon_new_property' ) ) {
	
	function tt_icon_new_property() {
	
		// Current Date
		$today = date( 'r' );
		// Property Publishing Date
		$property_published = get_the_time( 'r' );
		// Property Age in Days
		$property_age = round( (strtotime( $today ) - strtotime( $property_published ) ) / ( 24 * 60 * 60 ),0 );
		
		// If Property Publishing Date is .. days or less, show New Icon
		global $realty_theme_option;
		$new_days_integer = $realty_theme_option['property-new-badge'];
		if ( $new_days_integer && $property_age <= $new_days_integer ) {
			return '<i class="fa fa-fire" data-toggle="tooltip" title="' . __( 'New Offer', 'tt' ) . '"></i>';
		}
		else {
			return false;
		}
	
	}
}

// Featured Property
if ( ! function_exists( 'tt_icon_property_featured' ) ) {
	function tt_icon_property_featured() {
		
		$property_featured = get_post_meta( get_the_ID(), 'estate_property_featured', true );
		if ( $property_featured ) {
			echo '<i class="fa fa-star" data-toggle="tooltip" title="' . __( 'Featured Property', 'tt' ) . '"></i>';
		}
		else {
			return false;
		}
		
	}
}

// Property Address
if ( ! function_exists( 'tt_icon_property_address' ) ) {
	function tt_icon_property_address() {
		
		$google_maps = get_post_meta( get_the_ID(), 'estate_property_google_maps', true );
		if ( isset( $google_maps ) ) {
			$property_address = $google_maps['address'];
		}
		if ( $property_address ) {
			echo '<i class="fa fa-map-marker" data-toggle="tooltip" title="' . $property_address . '"></i>';
		}
		else {
			return false;
		}
		
	}
}

// Property Video
if ( ! function_exists( 'tt_icon_property_video' ) ) {
	function tt_icon_property_video() {
		
		$property_video_provider = get_post_meta( get_the_ID(), 'estate_property_video_provider', true );
		$property_video_id = get_post_meta( get_the_ID(), 'estate_property_video_id', true );
		
		if ( $property_video_id && ( $property_video_provider == "youtube" || $property_video_provider == "vimeo" ) ) {
			if ( $property_video_provider == "youtube") {
				$video_url = '//www.youtube.com/watch?v=';
			}
			if ( $property_video_provider == "vimeo" ) {
				$video_url = '//vimeo.com/';
			}
			return '<a href="' . $video_url . $property_video_id . '" class="property-video-popup"><i class="fa fa-video-camera" data-toggle="tooltip" title="' . __( 'Watch Trailer', 'tt' ) . '"></i></a>';
		}
		else {
			return false;
		}
		
	}
}

// Delete Property
function tt_ajax_delete_property_function() {
	wp_trash_post( $_GET['delete_property'] );
	die;
}
add_action( 'wp_ajax_tt_ajax_delete_property_function', 'tt_ajax_delete_property_function' );


/* CONTACT FORM - Single Property
============================== */
if ( ! function_exists( 'submit_property_contact_form' ) ) {
function submit_property_contact_form() {
	global $realty_theme_option;
	if ( wp_verify_nonce( $_POST['nonce'] ) && ! empty( $_POST['email'] ) && ! empty( $_POST['message'] ) ) {
		 
		$property_title = $_POST['property_title'];
		$property_url = $_POST['property_url'];
		$recipient = array();
		if ( $realty_theme_option['property-contact-form-cc-admin'] ) {
			
			$recipient[] = $_POST['agent_email'];
			$recipient[] = $realty_theme_option['property-contact-form-cc-admin'];
		} else {
			$recipient[] = $_POST['agent_email'];
		}
		
		if ( empty( $property_title ) ) {
			$subject = get_bloginfo('name') . ' - ' . __( 'Agent Profile Page Contact Form', 'tt' );
		} else {
			$subject = get_bloginfo('name') . ' - ' . __( 'Property', 'tt' ) . ': '. $property_title;
		}
		add_filter( 'wp_mail_content_type', 'tt_set_html_content_type');
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = '-';
	  $phone = $_POST['phone'];
		$headers = array();
	  $headers[] = "From: $name <$email>";
	  
	  $message = __( 'Name:', 'tt' ) . ' ' . $name . "\r\n" . __( 'Phone:', 'tt' ) . ' ' . $phone . "\r\n".  __( 'Email:', 'tt' ) . ' ' . $email . "\r\n"  . __( 'Property:', 'tt' ) . ' ' . $property_title . "\r\n" . $property_url . "\r\n\n" . __( 'Message:', 'tt' ) . "\r\n\n" . $_POST['message'];
		
		wp_mail( $recipient, $subject, $message, $headers );
			
		}
		remove_filter( 'wp_mail_content_type', 'tt_set_html_content_type');
		
	die;
}
}
add_action( 'wp_ajax_nopriv_submit_property_contact_form', 'submit_property_contact_form' );
add_action( 'wp_ajax_submit_property_contact_form', 'submit_property_contact_form' );


/* CONTACT FORM - Single Agent
============================== */
if ( ! function_exists( 'submit_agent_contact_form' ) ) {
function submit_agent_contact_form() {

	if ( wp_verify_nonce( $_POST['nonce'] ) && !empty( $_POST['email'] ) && !empty( $_POST['message'] ) ) {
		
	  $recipient = $_POST['agent_email'];
	  $name = $_POST['name'];
	  $subject = __( 'Message from', 'tt' ) . ' ' . $name;
	  $email = $_POST['email'];
	  $phone = '-';
	  $phone = $_POST['phone'];
	  $headers = array(); 
	  add_filter( 'wp_mail_content_type', 'tt_set_html_content_type');
	  $headers[] = "From: $name <$email>";
	  
	  $message = __( 'Name:', 'tt' ) . ' ' . $name . "\r\n" . __( 'Phone:', 'tt' )  . ' '. $phone .'\r\n'. __( 'Email:', 'tt' ) . " " . $_POST['email'].  "\r\n\n" . __( 'Message:', 'tt' ) . "\r\n\n" . $_POST['message'] ;
		
	  wp_mail( $recipient, $subject, $message, $headers );
	  remove_filter( 'wp_mail_content_type', 'tt_set_html_content_type');
		
		
	}
	
	die;
	
}
}
add_action( 'wp_ajax_nopriv_submit_agent_contact_form', 'submit_agent_contact_form' );
add_action( 'wp_ajax_submit_agent_contact_form', 'submit_agent_contact_form' );


/* BLOG
============================== */

if ( ! function_exists( 'tt_blog_pagination' ) ) {
	function tt_blog_pagination() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
	
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
	
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
	
		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	
		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
	
		// Set up paginated links.
		$links = paginate_links( array(
			'base'     		=> $pagenum_link,
			'format'   		=> $format,
			'total'    		=> $GLOBALS['wp_query']->max_num_pages,
			'current'  		=> $paged,
			'end_size'           => 4,
			'mid_size'           => 2,
			'type'				=> 'list',
			'add_args' 		=> array_map( 'urlencode', $query_args ),
			'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
			'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
		) );
	
		if ( $links ) {
		?>
		<nav id="pagination" role="navigation">
			<?php echo $links; ?>
		</nav>
		<?php
		}
	}
}

// Post Content & Navigation
if ( ! function_exists( 'tt_post_content_navigation' ) ) {
	function tt_post_content_navigation() {
	?>
			
		<div class="entry-content">
			<?php 
			the_content( __( 'Continue reading ..', 'tt' ) ); 
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tt' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			
			tt_social_sharing();
			?>
		</div><!-- .entry-content -->
		
		<?php
			
	}
}

// Comments
if ( ! function_exists( 'tt_list_comments' ) ) {
	function tt_list_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$args = array(
			'walker'            => null,
			'max_depth'         => '10',
			'style'             => 'ul',
			'callback'          => null,
			'end-callback'      => null,
			'type'              => 'comment',
			'reply_text'        => __( 'Reply', 'tt' ),
			'page'              => '',
			'per_page'          => '',
			'avatar_size'       => 130,
			'reverse_top_level' => null,
			'reverse_children'  => '',
			'format'            => 'html5',
			'short_ping'        => true
		);
		
		if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
		} else {
		$tag = 'li';
		$add_below = 'div-comment';
		}
		?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-avatar">
				<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="comment-author vcard">
				<?php printf(__('<h5 class="fn">%s</h5>'), get_comment_author_link()) ?>
				
				<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tt' ) ?></em>
				<br />
				<?php endif; ?>
				
				<div class="comment-meta">
				<span><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . " " . __('ago', 'tt'); ?></span>
				</div>
			
			</div>
			
			<div class="comment-content">
				<?php comment_text() ?>
				<?php if( comments_open() ) { ?>
				<div class="reply btn btn-default btn-xs">
					<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
				<?php } ?>
			</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif;
	}
}

// Social Sharing Buttons
if ( ! function_exists( 'tt_social_sharing' ) ) {
	function tt_social_sharing() {
	?>
	  <div id="share-post" class="social primary-tooltips">
			<a href="http://www.facebook.com/share.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-facebook" data-toggle="tooltip" title="<?php _e( 'Share on Facebook', 'tt' ); ?>"></i></a>
			<a href="http://twitter.com/share?text=<?php the_title(); ?>&url=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-twitter" data-toggle="tooltip" title="<?php _e( 'Share on Twitter', 'tt' ); ?>"></i></a>
			<a href="https://plus.google.com/share?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank"><i class="fa fa-google-plus" data-toggle="tooltip" title="<?php _e( 'Share on Google+', 'tt' ); ?>"></i></a>
			<?php 
			if ( has_post_thumbnail() ) {
				$attachment_id =  get_post_thumbnail_id();
				$attachment_array = wp_get_attachment_image_src( $attachment_id );
			?>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>&media=<?php echo $attachment_array[0]; ?>&description=<?php echo strip_tags( get_the_excerpt() ); ?>" target="_blank"><i class="fa fa-pinterest" data-toggle="tooltip" title="<?php _e( 'Share on Pinterest', 'tt' ); ?>"></i></a>
			<?php } ?>
		</div>

		<?php
	}
}


/* Page Banner
============================== */
if ( ! function_exists( 'tt_page_banner' ) ) {
	function tt_page_banner() {
		if ( has_post_thumbnail( get_the_ID() ) ) {	
			$post_thumbnail_id = get_post_thumbnail_id();
			$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'full', true );
			?>
			<div id="page-banner" style="background-image: url(<?php echo $post_thumbnail[0]; ?>)">
				<div class="overlay"></div>
				<div class="container">
					<div class="banner-title">
						<?php the_title(); ?>
					</div>
				</div>
			</div>
			<?php 
		}
	}
}

/* Query - Taxonomy
============================== */
function tt_taxonomy_query( $query ) {
	if( is_tax() ) {
		// Search Results Per Page: Check for Theme Option
		global $realty_theme_option;
		$search_results_per_page = $realty_theme_option['search-results-per-page'];
		if ( $search_results_per_page ) {
			$query->set( 'posts_per_page', $search_results_per_page );
		}
  }
}
add_action( 'pre_get_posts', 'tt_taxonomy_query' );


/* User - Property Submit - Delete Images
============================== */
function tt_ajax_delete_uploaded_image_function() {
	delete_post_meta( $_POST['property_id'], 'estate_property_images', $_POST['image_id'] );
	die;
}
add_action( 'wp_ajax_tt_ajax_delete_uploaded_image_function', 'tt_ajax_delete_uploaded_image_function' );


/* Author Base 
http://wordpress.org/support/topic/how-to-change-author-base-without-front
============================== */
if ( ! function_exists( 'tt_author_permalinks' ) ) {
function tt_author_permalinks() {
	global $wp_rewrite;
	$wp_rewrite->author_base = 'agent';
	$wp_rewrite->author_structure = '/' . $wp_rewrite->author_base . '/%author%';
	
	// Assign User level "1" to agents, so they appear in author dropdown
	$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
	foreach( $all_agents as $agent_id ) {
		update_user_meta( $agent_id, 'wp_user_level', '1');	
	}
}
}
add_action( 'init', 'tt_author_permalinks' );


/* Add Role "agent". Run Once After Theme Activation.
http://advent.squareonemd.co.uk/controlling-wordpress-custom-post-types-capabilities-and-roles/
============================== */
if ( ! function_exists( 'tt_add_role_agent' ) ) {
	function tt_add_role_agent() {
		global $wp_roles;
		$capabilities = array(
			'unfiltered_html' => true,
			'upload_files' => true
		);
		//remove_role( 'agent' );
		add_role( 'agent', __( 'Agent', 'tt' ), $capabilities );
		// Remove "read" Capability For "subscriber" Role.
		$role_subscriber = get_role( 'subscriber' );
	  $role_subscriber->remove_cap( 'read' );
	  $role_subscriber->add_cap('upload_files');
	  $role_subscriber->add_cap('unfiltered_html');
	}
}
add_action( 'after_switch_theme', 'tt_add_role_agent' );
//add_action( 'init', 'tt_add_role_agent' );


/* Property Submit Listing - Edit link
============================== */
if ( ! function_exists( 'tt_permalink_property_submit_edit' ) ) {
	function tt_permalink_property_submit_edit($url) {
		global $post;	
		if ( is_page_template( 'template-property-submit-listing.php' ) ) {	
			// Get page that is using "Property Submit" Page Template
			$template_page_property_submit_array = get_pages( array (
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-property-submit.php'
				)
			);
			foreach( $template_page_property_submit_array as $template_page_property_submit ) {
				$submit_page = $template_page_property_submit->ID;
				break;
			}
			return get_permalink( $submit_page ) . '?edit=' . $post->ID;
		}
		else {
			return add_query_arg($_GET, $url);
		}
	}
}
add_filter('the_permalink', 'tt_permalink_property_submit_edit');


/* PayPal Payment Button
============================== */
if ( ! function_exists( 'tt_package_payment_button' ) ) {
	function tt_package_payment_button($package_id) {
		
		global $post, $realty_theme_option;
		
		if ( isset( $package_id ) ) {
			$package_id = $package_id;
			
		}
		else {
			$package_id = $post->ID;
		}
		
		$package = get_post($package_id);
		$payment_title = $package->post_title;
		$paypal_subscription_period = get_post_meta($package_id,'estate_package_period_unit', true);
		$paypal_subscription_recurrence = get_post_meta($package_id,'estate_package_valid_renew', true);
		$paypal_settings_amount = get_post_meta($package_id,'estate_package_price', true);
		$paypal_settings_enable = true;
		
		
		$paypal_settings_currency_code = $realty_theme_option['paypal-currency-code'];
		$paypal_settings_merchant_id = $realty_theme_option['paypal-merchant-id'];
		$paypal_settings_sandbox = $realty_theme_option['paypal-sandbox'];
		$paypal_enable_subscription = true;
		if ( $paypal_settings_enable && $paypal_settings_merchant_id && $paypal_settings_currency_code && $paypal_settings_amount ) {                                  
		    
		$paypal_output  = '<div title="' . $paypal_settings_currency_code . ' ' . $paypal_settings_amount .'" data-toggle="tooltip" style="display:inline-block">';
			$paypal_output .= '<script async src= "' . TT_LIB_URI . '/paypal/paypal-button.min.js?merchant=' . $paypal_settings_merchant_id . '"';
			if ( $paypal_enable_subscription ) {
				$paypal_output .= 'data-button="subscribe"';
				$paypal_output .= 'data-recurrence="' . $paypal_subscription_recurrence . '"';
				$paypal_output .= 'data-period="' . $paypal_subscription_period . '"';
				$paypal_output .= 'data-src="1"'; // For Indefinite Cycles
			}
			else {
				$paypal_output .= 'data-button="subscribe"';
			}
			if ( $paypal_settings_sandbox ) {
			$paypal_output .= 'data-env="sandbox"';
			}
			$paypal_output .= 'data-name="' . $payment_title . '"';
			$paypal_output .= 'data-number="' . $package_id . '"';
			$paypal_output .= 'data-amount="' . $paypal_settings_amount . '"';
			$paypal_output .= 'data-currency="' . $paypal_settings_currency_code . '"';
			$paypal_output .= 'data-number="' . $package_id . '"';
			$paypal_output .= 'data-quantity="1"';
			$paypal_output .= 'data-shipping="0"';
			$paypal_output .= 'data-tax="0"';
			$paypal_output .= 'data-style="secondary"';
			$paypal_output .= 'data-size="small"';
			$paypal_output .= 'data-callback="' . TT_LIB_URI . '/paypal/ipn.php' . '"';
			$paypal_output .= '></script>';
			$paypal_output .= '</div>';
			
			return $paypal_output;
				
		}
	
	}
}
if ( ! function_exists( 'tt_paypal_payment_button' ) ) {
	function tt_paypal_payment_button($property_id) {
		
		global $post, $realty_theme_option;
		if ( isset( $property_id ) ) {
			$property_id = $property_id;
		}
		else {
			$property_id = $post->ID;
		}
		
		$paypal_settings_enable = $realty_theme_option['paypal-enable'];
		$paypal_enable_subscription = $realty_theme_option['paypal-enable-subscription'];
		$paypal_subscription_recurrence = $realty_theme_option['paypal-subscription-recurrence'];
		$paypal_subscription_period = $realty_theme_option['paypal-subscription-period'];
		
		$paypal_settings_merchant_id = $realty_theme_option['paypal-merchant-id'];
		$paypal_settings_amount = $realty_theme_option['paypal-amount'];
		$paypal_featured_amount = $realty_theme_option['paypal-featured-amount'];
		
		$property_extra_featured = get_post_meta( $property_id, 'estate_property_featured', true );
		if ( $property_extra_featured ) {
			$paypal_settings_amount = $paypal_settings_amount + $paypal_featured_amount;
		}
		
		$paypal_settings_currency_code = $realty_theme_option['paypal-currency-code'];
		$paypal_settings_sandbox = $realty_theme_option['paypal-sandbox'];
		
		if ( $paypal_settings_enable && $paypal_settings_merchant_id && $paypal_settings_currency_code && $paypal_settings_amount ) {                              
			$paypal_output  = '<div title="' . $paypal_settings_currency_code . ' ' . $paypal_settings_amount .'" data-toggle="tooltip" style="display:inline-block">';
			$paypal_output .= '<script async src= "' . TT_LIB_URI . '/paypal/paypal-button.min.js?merchant=' . $paypal_settings_merchant_id . '"';
			if ( $paypal_enable_subscription ) {
				$paypal_output .= 'data-button="subscribe"';
				$paypal_output .= 'data-recurrence="' . $paypal_subscription_recurrence . '"';
				$paypal_output .= 'data-period="' . $paypal_subscription_period . '"';
				$paypal_output .= 'data-src="1"'; // For Indefinite Cycles
			}
			else {
				$paypal_output .= 'data-button="buynow"';
			}
			if ( $paypal_settings_sandbox ) {
			$paypal_output .= 'data-env="sandbox"';
			}
			$paypal_output .= 'data-name="' . get_the_title() . '"';
			$paypal_output .= 'data-number="' . $property_id . '"';
			$paypal_output .= 'data-amount="' . $paypal_settings_amount . '"';
			$paypal_output .= 'data-currency="' . $paypal_settings_currency_code . '"';
			$paypal_output .= 'data-number="' . $property_id . '"';
			$paypal_output .= 'data-quantity="1"';
			$paypal_output .= 'data-shipping="0"';
			$paypal_output .= 'data-tax="0"';
			$paypal_output .= 'data-style="secondary"';
			$paypal_output .= 'data-size="small"';
			$paypal_output .= 'data-callback="' . TT_LIB_URI . '/paypal/ipn.php' . '"';
			$paypal_output .= '></script>';
			$paypal_output .= '</div>';
			
			return $paypal_output;
				
		}
	
	}
}

/* User Profile - Additional Fields
============================== */
if ( ! function_exists( 'tt_custom_user_contact_methods' ) ) {
	function tt_custom_user_contact_methods( $user_contact ) {
		$user_contact['company_name'] 				= __( 'Company Name', 'tt' ); 
		$user_contact['office_phone_number'] 	= __( 'Office Phone Number', 'tt' ); 
		$user_contact['mobile_phone_number'] 	= __( 'Mobile Phone Number', 'tt' ); 
		$user_contact['fax_number'] 					= __( 'Fax Number', 'tt' );
		$user_contact['custom_facebook'] 			= __( 'Facebook', 'tt' );
		$user_contact['custom_twitter'] 			= __( 'Twitter', 'tt' );
		$user_contact['custom_google'] 				= __( 'Google+', 'tt' );
		$user_contact['custom_linkedin'] 			= __( 'Linkedin', 'tt' );
		
		$user_contact['subscribed_package'] 			= __( 'Membership Plan', 'tt' );
		$user_contact['subscribed_package_default_id'] 			= __( 'Membership Plan Default ID', 'tt' );
		$user_contact['user_package_activation_time'] 			= __( 'Activation Date', 'tt' );
		$user_contact['subscribed_listing_remaining'] 			= __( 'Remaining Allowed Listings', 'tt' );
		$user_contact['subscribed_featured_listing_remaining'] 			= __( 'Remaining Allowed Featured Listings', 'tt' );
		$user_contact['subscribed_free_package_once'] 			= __( 'Free Package Subscribed', 'tt' );
		
		return $user_contact;
	}
}
add_filter('user_contactmethods', 'tt_custom_user_contact_methods');


/* User Profile - Additional Field "Image" 
http://www.flyinghippo.com/blog/adding-custom-fields-uploading-images-wordpress-users/ 
============================== */
if ( ! function_exists( 'tt_user_profile_picture_field' ) ) {
	function tt_user_profile_picture_field( $user ) { 
	?>
	<style type="text/css">
		.profile-upload-options th,
		.profile-upload-options td,
		.profile-upload-options input {
			margin: 0;
			vertical-align: top;
		}
		.user-preview-image {
			display: block;
			height: auto;
			width: 300px;
		}
	</style>
	
	<table class="form-table profile-upload-options">
		<tr>
			<th>
				<label for="user_image"><?php _e( 'Profile Picture', 'tt' ); ?></label>
			</th>
			<td>
				<img class="user-preview-image" src="<?php echo esc_attr( get_the_author_meta( 'user_image', $user->ID ) ); ?>"><br />
				<input type="text" name="user_image" id="user_image" value="<?php echo esc_attr( get_the_author_meta( 'user_image', $user->ID ) ); ?>" class="regular-text" />
				<input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />
			</td>
		</tr>
	</table>
	
	<script type="text/javascript">
		(function($) {
			<?php add_thickbox(); ?>
			$( '#uploadimage' ).on( 'click', function() {
				tb_show( 'Profile Picture', 'media-upload.php?type=image&TB_iframe=1' );
				window.send_to_editor = function( html ) 
				{
					imgurl = $( 'img', html ).attr( 'src' );
					$( '#user_image' ).val(imgurl);
					tb_remove();
				}
				return false;
			});
		})(jQuery);
	</script>
	<?php 
	}	
}
add_action( 'show_user_profile', 'tt_user_profile_picture_field' );
add_action( 'edit_user_profile', 'tt_user_profile_picture_field' );


/* User Profile - Save "Image" Field
============================== */
function tt_save_user_profile_picture_field( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'user_image', $_POST[ 'user_image' ] );
}
add_action( 'personal_options_update', 'tt_save_user_profile_picture_field' );
add_action( 'edit_user_profile_update', 'tt_save_user_profile_picture_field' );


/* User Profile - Delete User Image
============================== */
function tt_ajax_delete_user_profile_picture_function() {
	delete_user_meta( $_POST['user_id'], 'user_image' );
	die;
}
add_action( 'wp_ajax_tt_ajax_delete_user_profile_picture_function', 'tt_ajax_delete_user_profile_picture_function' );


/* Retrieve ttachment ID from file URL
https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
============================== */
if ( ! function_exists( 'tt_get_image_id' ) ) {
	function tt_get_image_id( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) ); 
	  return $attachment[0]; 
	}
}


/* Theme Option - Body Classes
============================== */
function tt_body_classes( $classes ) {
	global $realty_theme_option;	
	if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) {
		$classes[] = 'rtl';
	}
	if ( $realty_theme_option['site-header-position-fixed'] || is_page_template('template-map-vertical.php' ) ) {
		$classes[] = 'fixed-header';
	}
	return $classes;
}
add_filter( 'body_class', 'tt_body_classes' );


/* Page ID of Page Template "Property Search"
============================== */
if ( ! function_exists( 'tt_page_id_template_search' ) ) {
	function tt_page_id_template_search() {
		global $realty_theme_option;
		if ( $realty_theme_option['property-search-results-template'] == 'default-template' ) {
			$template_page_property_search_array = get_pages( array (
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-property-search.php'
			));
		}
		else {
			$template_page_property_search_array = get_pages( array (
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-map-vertical.php'
			));
		}
		foreach ( $template_page_property_search_array as $template_page_property_search ) {
			return $template_page_property_search = $template_page_property_search->ID;
			break;
		}
	}
}


/* Open Graph Meta Tag (Facebook Sharer Thumbnail Assignment)
============================== */
function tt_meta_open_graph() {
	global $post;
	if ( is_singular() ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '" />';
		}
	}
}
add_action( 'wp_head', 'tt_meta_open_graph', 5 );


/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
 
function tt_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return $request . '?sign-user="successful"';
		}
	} else {
		return $redirect_to;
	}
}
add_filter( 'login_redirect', 'tt_login_redirect', 10, 3 );


/**
 * Restrict users to media they have uploaded.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
 
function show_users_own_media_library( $query ) {
 $id = get_current_user_id();
 if ( ! current_user_can( 'manage_options' ) )
 $query['author'] = $id;
 return $query;
}
add_filter( 'ajax_query_attachments_args', 'show_users_own_media_library', 1, 1 );


function vimeo_oembed_fetch_url( $provider, $url, $args ) {
	if ( strpos( $provider, 'vimeo.com' ) !== false )  {
		foreach ( $args as $key => $value ) {
			$provider = add_query_arg( $key, absint( $value ), $provider );
		}
	}
	return $provider;
}

add_filter( 'oembed_fetch_url', 'vimeo_oembed_fetch_url', 10, 3 );


/* Admin notices
============================== */
if ( ! function_exists( 'tt_admin_notices' ) ) {
	
	function tt_admin_notices() {
		if ( ! tt_page_id_template_search() ) {
			echo '<div class="notice is-dismissible update-nag"><p>' . __( 'Please create a page that is using page template "Property Search Results". Otherwise property search form doesn\'t know where to display the results.', 'tt' ) . '</p></div>';
		}
	}

}
add_action( 'admin_notices', 'tt_admin_notices' );

/* author/agent bio enable html */

remove_filter('pre_user_description', 'wp_filter_kses');

//

// manage email recipeint in contact fomr 7.
if ( ! function_exists( 'tt_wpcf7_agent_admin_email' ) ) {
	
  function tt_wpcf7_agent_admin_email (&$WPCF7_ContactForm) {
	  
	global $realty_theme_option, $post;
	
	if( $realty_theme_option['send-email-to-admin-only-cf7'] ){
		return;
	}
	$email = '';
	$agent = get_post_meta( $post->ID, 'estate_property_custom_agent', true );
	if($agent){
		$email = get_userdata( $agent );
		$email = $email->user_email;
	} else {
		$email = get_the_author_meta('user_email');
	}
	$recipients = $email;
	if ( $realty_theme_option['property-contact-form-cc-admin'] ) {
		
		$recipients = $email .','. $realty_theme_option['property-contact-form-cc-admin'];

		
	}
	$WPCF7_ContactForm->mail['recipient'] = $recipients;
	
  
  }
add_action("wpcf7_before_send_mail", "tt_wpcf7_agent_admin_email");
}
/// dsIDX ACF conflict fix.

add_action( 'admin_print_scripts-post-new.php', 'tt_acf_idx_conflict_script', 11 );
add_action( 'admin_print_scripts-post.php', 'tt_acf_idx_conflict_script', 11 );

function tt_acf_idx_conflict_script() {
    global $post_type;
 
  if( 'property' == $post_type ) {
	  
	 wp_dequeue_script( 'googlemaps3' ); 
     wp_dequeue_script( 'dsidxpress_google_maps_geocode_api' ); 
	//wp_enqueue_script( 'google-maps-api', '//maps.google.com/maps/api/js?sensor=false&libraries=places&v=3.18', array( 'jquery' ), null, false  );
  }
}