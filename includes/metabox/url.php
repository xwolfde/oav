<?php
/*-----------------------------------------------------------------------------------*/
/* Adds URL Metabox
/*-----------------------------------------------------------------------------------*/
namespace OAV;

add_action( 'add_meta_boxes', 'OAV\url_meta_box' );

function url_meta_box() { 
    add_meta_box(
        'url_box',
        __( 'URL', 'oav'),
        'OAV\url_callback',
        'post',
        'normal',
        'high'
    );    
}


function url_callback( $post) {
    wp_nonce_field( '_url_nonce', 'url_nonce' ); 
    $value = get_post_meta( $post->ID, 'url', true );

    echo '<label for="url"></label>';
    echo '<input type="text" size="80" name="url" id="url" value="'.  esc_attr( $value ) . '"/>';
    echo '<br /><em> z. B. http://www.video.uni-erlangen.de/webplayer/id/13953</em>';
}

function url_meta_box_save( $post_id, $post, $update ) {
    $post_type = get_post_type($post_id);
    if ( "video" != $post_type ) return;
    if ( isset( $_POST['url'] ) ) {
        update_post_meta( $post_id, 'url', sanitize_text_field( $_POST['url'] ) );
    }
    
    if ( isset( $_POST['url'] )  ) {
        $url = sanitize_text_field( $_POST['url'] );
        update_post_meta( $post_id, 'url', $url );
    } else {
        update_post_meta( $post_id, 'url', FALSE );
    }
}

add_action( 'save_post', 'OAV\url_meta_box_save', 10, 3 );
