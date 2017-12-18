<?php

/*-----------------------------------------------------------------------------------*/
/* Set post type vote
/*-----------------------------------------------------------------------------------*/
function custom_post_type_vote() {
    $labels = array(
        'name'                  => _x( 'Vote', 'Post Type General Name', 'oav' ),
        'singular_name'         => _x( 'Vote', 'Post Type Singular Name', 'oav'),
        'menu_name'             => __( 'Votes', 'oav'),
    );
    $args = array(
        'label'                 => __( 'Voting', 'oav'),
        'description'           => __( 'Add a vote', 'oav'),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'            => array( 'taxonomy_votes' ),
//        'menu_icon'             => 'dashicons-format-video',
        'hierarchical'          => false,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true, 
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'has_archive'           => true,		
        'exclude_from_search'   => false,
    );   
    register_post_type( 'vote', $args );
}

add_action( 'init', 'custom_post_type_vote' );
