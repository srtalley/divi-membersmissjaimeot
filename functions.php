<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/* Add Included Class Files */
// Adds the ability to show different terms for a membership
require_once( dirname( __FILE__ ) . '/classes/affiliate-royale.php');

/* Add custom functions below */

add_action( 'wp_enqueue_scripts', 'ds_enqueue_assets', 15 );
function ds_enqueue_assets() {

  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), et_get_theme_version() );
  wp_dequeue_style( 'divi-style' );
  wp_enqueue_style( 'child-theme', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

  // wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', '', '1.1.7', true );

}//end function ds_enqueue_assets
