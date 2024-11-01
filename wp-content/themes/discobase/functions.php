<?php
  // Set dynamic site version
  $version = wp_get_theme()->get( 'Version' );

  // Init theme support
  function disco_init_theme_support() {
    add_theme_support( 'title_tag ');
  }

  add_action( 'after_setup_theme', 'disco_init_theme_support' );
?>