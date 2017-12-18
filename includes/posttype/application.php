<?php
/* 
 * Define posttyype application
 */

namespace OAV;
/*-----------------------------------------------------------------------------------*/
/* Set post type attributes
/*-----------------------------------------------------------------------------------*/
function custom_post_type_videos() {
    $labels = array(
        'name'                  => _x( 'Antrag', 'Post Type General Name', 'oav' ),
        'singular_name'         => _x( 'Antrag', 'Post Type Singular Name', 'oav'),
        'menu_name'             => __( 'Anträge', 'oav'),
        'parent_item_colon'     => __( 'Übergeordneter Antrag', 'oav'),
        'all_items'             => __( 'Alle Anträge', 'oav'),
        'add_new_item'          => __( 'Neuen Antrag hinzufügen', 'oav'),
        'add_new'               => __( 'Antrag hinzufügen', 'oav'),
        'edit_item'             => __( 'Antrag bearbeiten', 'oav'),
        'update_item'           => __( 'Antrag aktualisieren', 'oav'),
        'view_item'             => __( 'Antrag anzeigen', 'oav'),
        'search_items'          => __( 'Antrag suchen', 'oav'),

    );
    $args = array(
        'label'                 => __( 'Antrag', 'oav'),
        'description'           => __( 'Anträge auf der Webseite anzeigen', 'oav'),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array( 'Genre' ),
        'menu_icon'             => 'dashicons-format-video',
        'hierarchical'          => false,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true, 
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'has_archive'           => true,		
        'exclude_from_search'   => false,
    );   
    register_post_type( 'application', $args );

}

add_action( 'init', 'OAV\custom_post_type_videos' );