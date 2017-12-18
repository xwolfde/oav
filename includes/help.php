<?php

namespace OAV;

add_action( "load-plugins.php", 'OAV\plugin_help_tab' , 20 );

function plugin_help_tab () {
    $current_screen = get_current_screen();
    
    if( $current_screen->id === "plugins" ) {

    $current_screen->add_help_tab( array(
        'id'            => 'plugin_help',
        'title'         => __(' OAV Plugin'),
        'content'	=> '<p><strong>' . __( 'OAV', 'oav' ) . '</strong></p><p>' 
                               . __( 'Dokumentation ist noch nicht in Sicht :)','oav')
                               .'</p>' 
    ) );
    }
}