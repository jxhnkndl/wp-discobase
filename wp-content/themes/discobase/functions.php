<?php

// Set dynamic site version
$version = wp_get_theme()->get( 'Version' );


// Init theme support
function disco_init_theme_support() {
  add_theme_support( 'title_tag ');
}

add_action( 'after_setup_theme', 'disco_init_theme_support' );


// Register custom post types
function disco_register_custom_post_types() {
  register_post_type('artist', array(
    'labels' => array(
      'name'            => 'Artists',
      'singular_name'   => 'Artist',
    ),
    'public'            => true,
    'menu_icon'         => 'dashicons-format-audio',
    'hierarchial'       => true
  ));

  remove_post_type_support( 'artist', 'title');
  remove_post_type_support( 'artist', 'editor');

  register_post_type('album', array(
    'labels' => array(
      'name'            => 'Albums',
      'singular_name'   => 'Album',
    ),
    'public'            => true,
    'menu_icon'         => 'dashicons-controls-volumeon',
    'hierarchial'       => true
  ));

  remove_post_type_support( 'album', 'title');
  remove_post_type_support( 'album', 'editor');
}

add_action( 'init', 'disco_register_custom_post_types');
