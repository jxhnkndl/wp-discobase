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


// Create custom fields for Artist post type
function disco_register_artist_field_group() {
  if ( function_exists( 'acf_add_local_field_group' ) ) :

    // GROUP: Artist 
    acf_add_local_field_group(
      array(
        'key'      => 'group_artist',
        'title'    => 'Artist',
        'location' => array(
          array(
            array(
              'param'     => 'post_type',
              'operator'  => '==',
              'value'     => 'artist'
            )
          )
        )
      )
    );

    // FIELD: Artist Name
    acf_add_local_field(
      array(
        'parent'      => 'group_artist',
        'key'         => 'field_artist_name',
        'label'       => 'Artist Name',
        'name'        => 'artist_name',
        'type'        => 'text',
        'required'    => 1
      )
    );

    // FIELD: Artist Photo
    acf_add_local_field(
      array(
        'parent'              => 'group_artist',
        'key'                 => 'field_artist_image',
        'label'               => 'Artist Photo',
        'name'                => 'artist_photo',
        'type'                => 'image',
        'required'            => 1,
        'allowed_file_types'  => 'png, jpg, jpeg, webp',
        'instructions'        => 'PNG, JPG, JPEG, WEBP formats accepted'
      )
    );

    // FIELD: Artist Discography
    acf_add_local_field(
      array(
        'parent'            => 'group_artist',
        'key'               => 'field_artist_discography',
        'label'             => 'Discography',
        'name'              => 'artist_discography',
        'type'              => 'repeater',
        'required'          => 0,
        'layout'            => 'block',
        'button_label'      => 'Add Album',
        'sub_fields'        => array(
          array(
            'key'               => 'field_discography_album',
            'label'             => 'Album',
            'name'              => 'discography_album',
            'type'              => 'relationship',
            'required'          => 0,
            'post_type'         => array( 'album' ),
            'taxonomy'          => array( 'genre' ),
            'result_elements'   => array( 'post_type', 'post_title' ),
            'multiple'          => false,
          )
        )
      )
    );

  endif;
}

add_action( 'acf/init', 'disco_register_artist_field_group');


// Create custom fields for Album post type
function disco_register_album_field_group() {
  if ( function_exists( 'acf_add_local_field_group' ) ) :

    // Album field group
    acf_add_local_field_group(
      array(
        'key'      => 'group_album',
        'title'    => 'Album',
        'location' => array(
          array(
            array(
              'param'     => 'post_type',
              'operator'  => '==',
              'value'     => 'album'
            )
          )
        )
      )
    );

    // FIELD: Album Title
    acf_add_local_field(
      array(
        'parent'    => 'group_album',
        'key'       => 'field_album_title',
        'label'     => 'Album Title',
        'name'      => 'album_title',
        'type'      => 'text',
        'required'  => 1
      )
    );

    // FIELD: Album genre
    acf_add_local_field(
      array(
        'parent'      => 'group_album',
        'key'         => 'field_album_genre',
        'label'       => 'Album Genre',
        'name'        => 'album_genre',
        'type'        => 'taxonomy',
        'taxonomy'    => 'genre',
        'required'    => 1,
        'field_type'  => 'multi_select',
        'allow_null'  => 0,
        'add_term'    => 0,
        'multiple'    => 1
      )
    );

    // FIELD: Album Type
    acf_add_local_field(
      array(
        'parent'      => 'group_album',
        'key'         => 'field_album_type',
        'label'       => 'Album Type',
        'name'        => 'album_type',
        'type'        => 'taxonomy',
        'taxonomy'    => 'album_type',
        'required'    => 1,
        'field_type'  => 'radio',
        'allow_null'  => 0,
        'add_term'    => 0,
        'multiple'    => 0
      )
    );

    // FIELD: Album Artist
    acf_add_local_field(
      array(
        'parent'            => 'group_album',
        'key'               => 'field_album_artist',
        'label'             => 'Artist',
        'name'              => 'album_artist',
        'type'              => 'relationship',
        'required'          => 1,
        'post_type'         => array( 'artist' ),
        'taxonomy'          => array( 'genre' ),
        'result_elements'   => array( 'post_type', 'post_title' ),
        'multiple'          => false,
      )
    );

    // FIELD: Album Cover
    acf_add_local_field(
      array(
        'parent'              => 'group_album',
        'key'                 => 'field_album_cover',
        'label'               => 'Album Cover',
        'name'                => 'album_cover',
        'type'                => 'image',
        'required'            => 1,
        'allowed_file_types'  => 'png, jpg, jpeg, webp',
        'instructions'        => 'PNG, JPG, JPEG, WEBP formats accepted'
      )
    );

    // FIELD: Tracklist
    acf_add_local_field(
      array(
        'parent'            => 'group_album',
        'key'               => 'field_album_tracklist',
        'label'             => 'Tracklist',
        'name'              => 'album_tracklist',
        'type'              => 'repeater',
        'required'          => 0,
        'layout'            => 'block',
        'button_label'      => 'Add Track',
        'sub_fields'        => array(
          array(
            'key'             => 'field_track_title',
            'label'           => 'Track Title',
            'name'            => 'track_title',
            'type'            => 'text',
            'required'        => 1
          )
        )
      )
    );

    // FIELD: Album Rating
    acf_add_local_field(
      array(
        'parent'      => 'group_album',
        'key'         => 'field_album_rating',
        'label'       => 'Album Rating',
        'name'        => 'album_rating',
        'type'        => 'button_group',
        'required'    => 1, 
        'choices'     => array(
          '1' => '1 Star',
          '2' => '2 Stars',
          '3' => '3 Stars',
          '4' => '4 Stars',
          '5' => '5 Stars'
        ),
        'allow_null'  => 0
      )
    );

    // FIELD: Album Review
    acf_add_local_field(
      array(
        'parent'      => 'group_album',
        'key'         => 'group_album_review',
        'label'       => 'Album Review',
        'name'        => 'album_review',
        'type'        => 'wysiwyg',
        'required'    => 0,
        'tooolbar'    => 'full'    
      )
    );

    // FIELD: Spotify Link
    acf_add_local_field(
      array(
        'parent'      => 'group_album',
        'key'         => 'group_album_spotify',
        'label'       => 'Spotify Link',
        'name'        => 'album_spotify_link',
        'type'        => 'text',
        'required'    => 1,    
      )
    );

  endif;
}

add_action( 'acf/init', 'disco_register_album_field_group');


// Register custom genre and album type taxonomies
function disco_register_custom_taxonomies() {
  $custom_taxonomies = array(
    'genre'       => 'Genres',
    'album_type'  => 'Album Types'
  );

  // Loop through each taxonomy to register it with WP
  foreach ($custom_taxonomies as $taxonomy => $name) {
    $target_taxonomies;
    
    // Determine which post types to apply each taxonomy to
    if ( $taxonomy === 'genre') :
      $target_taxonomies = array( 'album', 'artist' );
    else :
      $target_taxonomies = array( 'album' );
    endif;

    // Register each taxonomy and attach to its relevant post type(s)
    register_taxonomy( $taxonomy, $target_taxonomies, array(
      'labels' => array(
        'name' => $name,
        'singular_name' => substr($name, 0, -1)
      ),
      'hierarchical' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'rewrite' => array( 'slug' => $taxonomy )
    ));
  }
}

add_action( 'init', 'disco_register_custom_taxonomies' );


// Register genre types in genre category
function disco_register_terms() {
  if ( taxonomy_exists( 'genre' ) ) :
    $genres = array( 'Pop', 'Rock', 'Alternative', 'Indie', 'Punk', 'Metal', 'Electronic', 'Ambient', 'Folk', 'Country', 'Hip Hop', 'Jazz' );

    // Add the genre name to the genre taxonomy
    foreach ( $genres as $genre ) {
      wp_insert_term( $genre, 'genre' );
    }
  endif;

  if ( taxonomy_exists( 'album_type' ) ) :
    $album_types = array( 'LP', 'EP', 'Single', 'Compilation Album', 'Live Album' );

    // Add the album type to the album type taxonomy
    foreach ($album_types as $album_type) {
      wp_insert_term( $album_type, 'album_type' );
    }
  endif;
}

add_action( 'init', 'disco_register_terms' );