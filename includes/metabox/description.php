<?php

/*-----------------------------------------------------------------------------------*/
/* Adds description Metabox
/*-----------------------------------------------------------------------------------*/
namespace OAV;
add_action( 'add_meta_boxes', 'OAV\description_meta_box' );

function description_meta_box() {
    add_meta_box(
        'description_box',
        __( 'Beschreibung', 'oav'),
        'OAV\description_callback',
        'video',
        'normal',
        'high'
    );   
}



function description_callback( $post) {

    wp_nonce_field( '_description_nonce', 'description_nonce' ); 

    $value = get_post_meta( $post->ID, 'description', true );

    echo '<label for="description"></label>';
    //echo '<input type="text" name="description" id="description" value="'.  esc_attr( $value ) . '"/>';
    echo '<textarea cols="100" rows="10" type="text" name="description" id="description" value="'.  esc_attr( $value ) . '" >' . esc_attr( $value ) . '</textarea>';
   
}

function description_meta_box_save( $post_id, $post, $update ) {

    $post_type = get_post_type($post_id);

    if ( "video" != $post_type ) return;

    if ( isset( $_POST['description'] ) ) {
        update_post_meta( $post_id, 'description', sanitize_text_field( $_POST['description'] ) );
    }

    if ( isset( $_POST['description'] ) ) {
        $description = sanitize_text_field( $_POST['description'] );
        update_post_meta( $post_id, 'description', $description );
    } else {
        update_post_meta( $post_id, 'description', FALSE );
    }
}

add_action( 'save_post', 'OAV\description_meta_box_save', 10, 3 );

function video_admin_notice () {
    $error = get_transient( 'video_id_failure' );
    delete_transient( 'video_id_failure' );
    
    if ( $error ) {
        $class = 'notice notice-error';
        $message1 = __( 
            'Bitte geben Sie eine Video ID mit genau 5 Ziffern ein!', 
            'rrze-test' );
        
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message1 ) );
        
    }
}
