<?php
namespace OAV;

add_shortcode('oav', 'OAV\show_oav'); 

function show_oav( $atts ) {
    
    global $post;
    
    $oav_options             =   get_option('oav_plugin_options');
    
    $oav_shortcode = shortcode_atts( array(
        'url'                   => '',
        'id'                    => '',
        'showinfo'              => '1',
        'showtitle'             => '1',
        'titletag'              => 'h2',
        'rand'                  => ''
    ), $atts );
    
    $url_shortcode          = $oav_shortcode['url'];
    $id_shortcode           = $oav_shortcode['id'];
    $taxonomy_genre         = $oav_shortcode['rand'];
    
    $args_video = array(
        'post_type'         =>  'Video',
        'p'                 =>  $id_shortcode,
        'posts_per_page'    =>  1,
        'orderby'           =>  'date',
        'order'             =>  'DESC'
    );
    
    $argumentsTaxonomy = array(
        'post_type' => 'Video',
        'posts_per_page' => 1,
        'orderby'   =>  'rand',
    
    );
    
    
    if( !empty( $url_shortcode ) ) {
        
        $video_flag = assign_video_flag($url_shortcode);
        
        wp_enqueue_script( 'rrze-main-js' );
        wp_enqueue_style( 'mediaelementplayercss' );
        wp_enqueue_script( 'mediaelementplayerjs' );
        wp_enqueue_script( 'myjs' );
       
       
        if($video_flag) {
            
            $oembed_url         = 'https://www.video.uni-erlangen.de/services/oembed/?url=https://www.video.uni-erlangen.de/webplayer/id/' . http_check_and_filter($url_shortcode) . '&format=json';
            $video_url          = json_decode(wp_remote_retrieve_body(wp_safe_remote_get($oembed_url)), true);       
            $video_file         = $video_url['file'];
            $preview_image      = 'https://cdn.video.uni-erlangen.de/Images/player_previews/'. http_check_and_filter($url_shortcode) .'_preview.img';
            $picture            = $preview_image;
            $showtitle          = ($oav_shortcode['showtitle'] == 1) ? $video_url['title'] : '';
            $modaltitle         = $video_url['title'];
            $author             = ($oav_shortcode['showinfo'] == 1) ? $video_url['author_name'] : '';
            $copyright          = ($oav_shortcode['showinfo'] == 1) ? $video_url['provider_name'] : '';
            
            $id = uniqid();
            
            ob_start();
            include( plugin_dir_path( __DIR__ ) . 'templates/rrze-video-shortcode-template.php');
            return ob_get_clean();

        } else {

            $id = uniqid();
            $youtube_id = http_check_and_filter($url_shortcode);
            
            ob_start();
            include( plugin_dir_path( __DIR__ ) . 'templates/rrze-video-shortcode-youtube-template.php');
            return ob_get_clean();

        }  
        
    } else {
        
       /*
        * Wenn die id im shortcode gesetzt ist.
        * Dann wird der Datensatz aus dem Video Post Type gezogen
        * 
        * video_flag = 1 - Videos aus dem FAU-Videoportal
        * video-flag = 0 - Videos aus Youtube
        */
        
        //$shortcode_video = new \WP_Query($args_video);
        
        $shortcode_video = assign_wp_query_arguments( $url_shortcode, $id_shortcode , $args_video, $argumentsTaxonomy);
    
        if ( $shortcode_video->have_posts() ) : while ($shortcode_video->have_posts()) : $shortcode_video->the_post();
        
            wp_enqueue_script( 'rrze-main-js' );
            wp_enqueue_style( 'mediaelementplayercss' );
            wp_enqueue_script( 'mediaelementplayerjs' );
            wp_enqueue_script( 'myjs' );
           

            $url = get_post_meta( $post->ID, 'url', true );
            
            $video_flag = assign_video_flag($url);

            if($video_flag) {
                $url_data           = get_post_meta( $post->ID, 'url', true );
                $video_id           = http_check_and_filter($url_data);
                $description        = get_post_meta( $post->ID, 'description', true );
                $genre              = wp_strip_all_tags(get_the_term_list($post->ID, 'genre', true ));
                $thumbnail          = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                $oembed_url         = 'https://www.video.uni-erlangen.de/services/oembed/?url=https://www.video.uni-erlangen.de/webplayer/id/' . $video_id . '&format=json';
                $video_url          = json_decode(wp_remote_retrieve_body(wp_safe_remote_get($oembed_url)), true);       
                $video_file         = $video_url['file'];
                $preview_image      = 'https://cdn.video.uni-erlangen.de/Images/player_previews/'. $video_id .'_preview.img';
                $picture            = (!$thumbnail) ? $preview_image : $thumbnail;
                $showtitle          = ($oav_shortcode['showtitle'] == 1) ? $video_url['title'] : '';
                $modaltitle         = $video_url['title'];
                $author             = $video_url['author_name'];
                $copyright          = $video_url['provider_name'];
                $id = uniqid();
                
                ob_start();
                include( plugin_dir_path( __DIR__ ) . 'templates/rrze-video-shortcode-template.php');
                return ob_get_clean();

            } else {

                $id = uniqid();

                $showtitle          = ($oav_shortcode['showtitle'] == 1) ? get_the_title() : '';
                $modaltitle         = get_the_title();
                $youtube_data       = get_post_meta( $post->ID, 'url', true );
                $youtube_id         = http_check_and_filter($youtube_data);
                $description        = get_post_meta( $post->ID, 'description', true );
                
                ob_start();
                include( plugin_dir_path( __DIR__ ) . 'templates/rrze-video-shortcode-youtube-template.php');
                return ob_get_clean();

            }

        endwhile;

        else :

            $no_posts = '<p>' . _e( 'Es wurden keine Videos gefunden!', 'rrze-video' ) . '</p>';
            echo $no_posts;

        endif;

        wp_reset_postdata();    

    }
}
