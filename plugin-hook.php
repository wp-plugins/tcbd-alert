<?php
/*
Plugin Name: TCBD Alert
Plugin URI: http://demos.tcoderbd.com/wordpress_plugins/tcbd-alert/
Description: This plugin will enable Awesome Bootstrap Alert box in your Wordpress theme.
Author: Md Touhidul Sadeek
Version: 1.0
Author URI: http://tcoderbd.com
*/

/*  Copyright 2015 tCoderBD (email: info@tcoderbd.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Define Plugin Directory
define('TCBD_ALERT_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

// Hooks TCBD functions into the correct filters
function tcbd_alert_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tcbd_alert_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tcmd_alert_register_mce_button' );
	}
}
add_action('admin_head', 'tcbd_alert_add_mce_button');

// Declare script for new button
function tcbd_alert_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['tcbd_alert_mce_button'] = TCBD_ALERT_PLUGIN_URL.'js/tinymce.js';
	return $plugin_array;
}

// Register new button in the editor
function tcmd_alert_register_mce_button( $buttons ) {
	array_push( $buttons, 'tcbd_alert_mce_button' );
	return $buttons;
}


function tcbd_alert_scripts(){
	// Latest jQuery WordPress
	wp_enqueue_script('jquery');

	// TCBD Alert JS
	wp_enqueue_script('tcbd-alert-js', TCBD_ALERT_PLUGIN_URL.'js/tcbd-alert.js', array('jquery'), '1.0', true);

	// TCBD Alert CSS
	wp_register_style('tcbd-alert', TCBD_ALERT_PLUGIN_URL.'css/tcbd-alert.css', array(), '1.0');
	wp_enqueue_style('tcbd-alert');
}
add_action('wp_enqueue_scripts', 'tcbd_alert_scripts');



// TCBD Alert Shortcode
function tcbd_alert_text( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'type' => 'success'
	), $atts ) );
	return '
	<div role="alert" class="alert alert-'.$type.' alert-dismissible fade in">
      <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
      '.$content.'
    </div>
	';
}	
add_shortcode('tcbd-alert', 'tcbd_alert_text');
