<?php
/*-----------------------------------------------------------------------------------*/
/* Votes  Taxonomy
/*-----------------------------------------------------------------------------------*/
function taxonomy_votes() {

    $labels = array(
        'name'                        => _x( 'Themen', 'Post Type General Name', 'oav'),
        'singular_name'               => _x( 'Thema', 'Post Type Singular Name', 'oav'),
        'menu_name'                   => __( 'Themen', 'oav'),

    );
    $args = array(
        'labels'                      => $labels,
        'hierarchical'                => true,
        'public'                      => true,
        'show_ui'                     => true,
        'show_admin_column'           => true,
        'show_in_nav_menus'           => true,
    );
    register_taxonomy( 'taxonomy_votes', array( 'vote' ), $args );

}

add_action( 'init', 'taxonomy_votes' );
