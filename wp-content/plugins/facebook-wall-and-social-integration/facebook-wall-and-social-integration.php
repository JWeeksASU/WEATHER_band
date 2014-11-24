<?php
/*
Plugin Name: facebook wall and social integration
Plugin URI: http://extensions.techhelpsource.com/wordpress/facebook-wall-pro/
Description: Facebook feed of page/group/profile and social integration by mitsol(free version)
Author: mitsol	
Version: 1.4
Author URI: http://extensions.techhelpsource.com/ 
License: GPLv2 or later 
*/ 
/* 
Copyright 2013 mitsol (email : mridulcs@yahoo.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//for paid version - 

if(is_admin())
{
include_once dirname(__FILE__) . '/admin/facebook-wall-admin.php';

register_activation_hook(__FILE__, 'facebook_wall_and_social_integration_activation'); // code to be run after activate of plugin
register_deactivation_hook(__FILE__, 'facebook_wall_and_social_integration_deactivation'); 

//admin style 
add_action('admin_print_styles', 'mitsol_admin_css_all_page');	
add_action( 'admin_menu', 'facebook_wall_and_social_integration_plugin_settings' ); //add  setings menu item in dashboard menu
}
else {
	
include_once dirname(__FILE__) . '/facebook-wall-and-social-integration-functions.php';
add_shortcode("mitsol_fbwall_feed_short_code", 'facebook_wall_and_social_integration_replace_scode'); 
//add_action( 'widgets_init', create_function('', 'return register_widget("facebook_wall_and_social_integration");') ); //add a widget at right of wp site

add_filter('widget_text', 'shortcode_unautop'); // enabling short code in default text widget also see echo do_shortcode($var); in function
add_filter('widget_text', 'do_shortcode',11); 
//add_action('wp_enqueue_scripts', 'facebook_wall_and_social_integration_scripts'); //add scripts at last to load page fast
//add_action( 'wp_footer', 'facebook_wall_and_social_integration_uniquejs' );

error_reporting(0); 
}

