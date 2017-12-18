<?php
/*-----------------------------------------------------------------------------------*/
/* Genre Taxonomy
/*-----------------------------------------------------------------------------------*/
namespace OAV;

function taxonomy_genre() {

    $labels = array(
        'name'                        => _x( 'Genre', 'Post Type General Name', 'oav'),
        'singular_name'               => _x( 'Genre', 'Post Type Singular Name', 'oav'),
        'menu_name'                   => __( 'Genre', 'oav'),
        'all_items'                   => __( 'Alle Genres anzeigen', 'oav'),
        'parent_item'                 => __( 'Übergeordnetes Genre', 'oav'),
        'parent_item_colon'           => __( 'Übergeordnetes Genre', 'oav'),
        'new_item_name'               => __( 'Neue Genre', 'oav'),
        'add_new_item'                => __( 'Neues Genre hinzufügen', 'oav'),
        'edit_item'                   => __( 'Genre bearbeiten', 'oav'),
        'update_item'                 => __( 'Genre aktualisieren', 'oav'),
        'separate_items_with_commas'  => __( 'Elemente mit Komma trennen', 'oav'),
        'search_items'                => __( 'Genre suchen', 'oav'),
        'add_or_remove_items'         => __( 'Genre hinzufügen oder entfernen', 'oav'),
        'choose_from_most_used'       => __( 'Am häufigsten verwendet', 'oav'),
        'not_found'                   => __( 'Nicht gefunden', 'oav'),
    );
    $args = array(
        'labels'                      => $labels,
        'hierarchical'                => true,
        'public'                      => true,
        'show_ui'                     => true,
        'show_admin_column'           => true,
        'show_in_nav_menus'           => true,
    );
    register_taxonomy( 'genre', array( 'video' ), $args );

}

add_action( 'init', 'OAV\taxonomy_genre' );
