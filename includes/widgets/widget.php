<?php

namespace OAV;

add_action( 'widgets_init', function(){
	register_widget( 'OAV\Antraege_Widget' );
});

class Antraege_Widget extends \WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'oav_widget',
            'description' => __('Zeigt Anträge in einem Widget an.'),
        );
        parent::__construct( 'oav_widget', 'OAV Widget', $widget_ops );
        
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
             
        global $post;
        
        $yt_options             =   get_option('oav_plugin_options');
        
        extract( $args );
        
        echo $before_widget;
        
        $form_id                = (!empty($instance['id'])) ? $instance['id'] :'';
        $form_url               = (!empty($instance['url'])) ? $instance['url'] :'';
        $form_title             = (!empty($instance['title'])) ? $instance['title'] :'';
        $form_showtitle         = (!empty($instance['showtitle'])) ? $instance['showtitle'] :'';
        $width                  = ! empty($instance['width'] ) ? $instance['width'] : 270;
        $height                 = ! empty($instance['height'] ) ? $instance['height'] : 150;
        $meta                   = (!empty($instance['meta'])) ? $instance['meta'] :'';
        $taxonomy_genre         = (!empty($instance['genre'])) ? $instance['genre'] :'';
        $youtube_resolution     = (!empty($instance['resolution'])) ? $instance['resolution'] :'';
    }

    

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $id         = ! empty( $instance['id'] ) ? $instance['id'] : '';     
        $url        = ! empty( $instance['url'] ) ? $instance['url'] : '';
        $width      = ! empty( $instance['width'] ) ? $instance['width'] : 270;
        $height     = ! empty( $instance['height'] ) ? $instance['height'] : 150;
        $showtitle  = ! empty( $instance['showtitle']) ? $instance['showtitle'] : '';   
        $meta       = ! empty( $instance['meta'] ) ? $instance['meta'] : '';   
        $genre      = ! empty( $instance['genre'] ) ? $instance['genre'] :'';
        $resolution = ! empty( $instance['resolution'] ) ? $instance['resolution'] : '';
        ?>
        
         <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Titel:', 'rrze-video' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" placeholder="title" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        <em><?php _e('Videotitel' ) ?></em>
        </p>
        
         <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php esc_attr_e( 'ID:', 'rrze-video' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" placeholder="id" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>">
        <em><?php _e('Datensatz-ID' ) ?></em>
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_attr_e( 'Url:', 'rrze-video' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" placeholder="url" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
        <em><?php _e('z. B. http://www.video.uni-erlangen.de/webplayer/id/13953') ?></em>
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_attr_e( 'Breite:', 'rrze-video' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>">
        <em><?php _e('Breite des Vorschaubildes' ) ?></em>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>"><?php _e('Zeige Widget Videotitel:' ) ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id( 'showtitle' ); ?>"
        name="<?php echo $this->get_field_name( 'showtitle' ); ?>" type="text">
        <option value='1'<?php echo ( $showtitle == '1' ) ? 'selected' : ''; ?>>
            Ein
          </option>
          <option value='0'<?php echo ( $showtitle == '' ) ? 'selected' : ''; ?>>
            Aus
          </option> 
        </select>                
        </p> 
        
        <p>
        <label for="<?php echo $this->get_field_id( 'meta' ); ?>"><?php _e('Zeige Metainformationen:' ) ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id('meta'); ?>"
        name="<?php echo $this->get_field_name( 'meta' ); ?>" type="text">
        <option value='1'<?php echo ( $meta == '1' ) ? 'selected' : ''; ?>>
            Ein
          </option>
          <option value='0'<?php echo ( $meta == '' )?'selected' : ''; ?>>
            Aus
          </option> 
        </select>                
        </p>  
        
        <?php 
        
        $terms = get_terms( array(
            'taxonomy' => 'genre',
            'hide_empty' => true,
        ) );
        
        ?>
        
        <p>
        <label for="<?php echo $this->get_field_id('genre'); ?>">Zufallsvideo nach Genre:</label>
        <select class='widefat' id="<?php echo $this->get_field_id('genre'); ?>"
        name="<?php echo $this->get_field_name('genre'); ?>" type="text">
            <option value="0" selected="selected"><?php _e('Genre auswählen') ?></option>
        <?php        
        
        foreach($terms as $term) {
            
            if($term->name == $genre) {
            ?>
                <option value=<?php echo $term->name ?> selected><?php echo $term->name; ?></option>
            <?php    
            }
            else {
            ?>
                <option value=<?php echo $term->name ?> ><?php echo $term->name; ?></option>
            <?php
            }
        }
        ?>
        </select>                
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'resolution' ); ?>"><?php _e('Auflösung des Youtube-Bildes:' ) ?></label>
        <select class='widefat' id="<?php echo $this->get_field_id( 'resolution' ); ?>"
        name="<?php echo $this->get_field_name( 'resolution' ); ?>" type="text">
        <option value="" selected="selected"><?php _e('Auswählen') ?></option> 
        <option value='1'<?php echo ( $resolution == '1' ) ? 'selected' : ''; ?>>
            maxresultion
          </option>
          <option value='2'<?php echo ( $resolution == '2' ) ? 'selected' : ''; ?>>
            default
          </option>
           <option value='3'<?php echo ( $resolution == '3' ) ? 'selected' : ''; ?>>
            hqdefault
          </option> 
           <option value='4'<?php echo ( $resolution == '4' ) ? 'selected' : ''; ?>>
            mqdefault
          </option>
           <option value='5'<?php echo ( $resolution == '5' ) ? 'selected' : ''; ?>>
            sddefault
          </option> 
        </select>                
        </p> 
        <?php
    }

   /*
     * Im Widget-Screen werden die alten Eingaben mit
     * den neuen Eingaben ersetzt und gespeichert.  
     */
    public function update( $new_instance, $old_instance ) { 
        
        $instance = $old_instance;
        $instance[ 'title' ]        = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'id' ]           = strip_tags( $new_instance[ 'id' ] );
        $instance[ 'url' ]          = strip_tags( $new_instance[ 'url' ] );
        $instance[ 'width' ]        = strip_tags( $new_instance[ 'width' ] );
        $instance[ 'height' ]       = strip_tags( $new_instance[ 'height' ] );
        $instance[ 'showtitle' ]    = strip_tags( $new_instance[ 'showtitle' ] );
        $instance[ 'meta' ]         = strip_tags( $new_instance[ 'meta' ] );
        $instance[ 'genre' ]        = strip_tags( $new_instance[ 'genre' ] );
        $instance[ 'resolution' ]   = strip_tags( $new_instance[ 'resolution' ] );
        
        return $instance;
    } 

    
    
}