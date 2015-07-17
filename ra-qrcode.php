<?php  
/* 
Plugin Name: ra_qrcode
Plugin URI: http://www.robertoalicata.it/ra_qrcode
Version: 1.1.1
Author: Roberto Alicata
Author URI: http://www.robertoalicata.it
Description: a simple WordPress plugin to generate a QR code with a shortcode


Usage:
write [qrcode] to generate a QRcode for the actual url with size of 100x100 pixels

you can specify these attributes:
size 	(it indicates the size in pixels for width and height, default: 100)
alt  	(it indicates the alternative text for the image: default "scan QR code")
content (leave it blank to pass the actual url or write the content to encode)
click 	(write "yes" to make the image clickable)

example: [qrcode size=200 content="www.robertoalicata.it" alt="scan me NOW"]
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Add Shortcode
function ra_qrcode_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'size' => '100',
			'alt' => 'scan QR code',
			'content' => '',
			'click' => 'no',
		), $atts )
	);

	$current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '';

	$qr_pre_output = "";
	$qr_output = "";
	$qr_post_output = "";

	!empty($content)? $content = strip_tags(trim($content)) : $content = $current_url;


	if ($click == "yes"){
		$qr_pre_output = '<a href="'. $content  .'">';
		$qr_post_output = '</a>';
	}




	$qr_image = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $size . 'x' . $size . '&chl=' . $content  . '&choe=UTF-8';

	$qr_output = '<img class="qrcode" id="qr_code" src="' . $qr_image . '" alt="' . $alt . '" width="' . $size . '" height="' . $size . '" />';

	return $qr_pre_output . $qr_output . $qr_post_output;

}


add_shortcode( 'qrcode', 'ra_qrcode_shortcode' );


add_action('admin_head', 'ra_add_tc_button');

function ra_add_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
	
        add_filter("mce_external_plugins", "ra_add_tinymce_plugin");
        add_filter('mce_buttons', 'ra_register_my_tc_button');
    }
}

function ra_add_tinymce_plugin($plugin_array) {
    $plugin_array['ra_qrcode_button'] = plugins_url( '/js/qrcode-button.js', __FILE__ ); // CHANGE THE BUTTON SCRIPT HERE
    return $plugin_array;
}

function ra_register_my_tc_button($buttons) {
   array_push($buttons, "ra_qrcode_button");
   return $buttons;
}

function ra_code_css() {
    wp_enqueue_style('ra-code-css', plugins_url('/css/style.css', __FILE__));
}
 
add_action('admin_enqueue_scripts', 'ra_code_css');

?>