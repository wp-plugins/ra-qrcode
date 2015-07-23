<?php  
/* 
Plugin Name: ra_qrcode
Plugin URI: http://www.robertoalicata.it/ra_qrcode
Version: 2.0.0
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


class Ra_Qrcode_Widget extends WP_Widget {

	function ra_qrcode_widget() {
		// Istanzia l'oggetto genitore
		parent::__construct( false, 'RA QRcode__' );
	}

	function widget( $args, $instance ) {
		// Output del widget
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			//do widget here			


		$out = '[qrcode size=' .$instance['size'] . ' content="' . $instance['content'] . '" alt="' . $instance['alt'] . '" ';
		if ($instance['click'] == "on") {
			$out .= 'click="yes" ';
		}
		$out .= ']';


		echo do_shortcode( $out );
		echo $after_widget;
		
	}

	function update( $new_instance, $old_instance ) {
		// Salva le opzioni del widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
		$instance['size'] = strip_tags($new_instance['size']);
		$instance['alt'] = strip_tags($new_instance['alt']);
		$instance['click'] = $new_instance['click'];

		return $instance;
	}

	function form( $instance ) {
		// Stampa il modulo di amministrazione con le opzioni del widget
		if ( $instance ) {
			$title = esc_attr($instance['title'] );
			$content = esc_attr($instance['content'] );
			$size = esc_attr($instance['size'] );
			$alt = esc_attr($instance['alt'] );
			$click = esc_attr($instance['click'] );
		} else {
			$title = "QR code";
			$content = '';
			$size = '100';
			$alt = '';
			$click = false;
		}

		?>
			<p>
				<label>Title</label>
				<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Content to Encode in QR Code:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="<?php echo $content; ?>" />
				<br/><small>leave it blank to pass the actual url or write the content to encode.</small>
			</p>
			<p>
			<table class="widefat">
				<tr>
					<td>
						<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:'); ?></label> 
						<input size="3" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" />
						<span>in pixels</span>
					</td>
					<td>
						<label for="<?php echo $this->get_field_id( 'click' ); ?>"><?php _e('Clickable?'); ?></label>
						<input class="checkbox" type="checkbox" <?php checked( (bool) $click, true ); ?> id="<?php echo $this->get_field_id( 'click' ); ?>" name="<?php echo $this->get_field_name( 'click' ); ?>" />
									
					</td>
				</tr>
			</table>

			</p>
			<p>
				<label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alternative Text:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $alt; ?>" />
				<br/><small>it indicates the alternative text for the image: default "scan QR code".</small>
			</p>
		<?php

	}
}

function ra_qrcode_register_widgets() {
	register_widget( 'Ra_Qrcode_Widget' );
}

add_action( 'widgets_init', 'ra_qrcode_register_widgets' );





?>