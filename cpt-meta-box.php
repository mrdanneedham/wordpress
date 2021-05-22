// In the main class construct

add_action( 'load-post.php', [$this,'mrc_event_details_meta_boxes_setup'] );
add_action( 'load-post-new.php', [$this,'mrc_event_details_meta_boxes_setup'] );


function mrc_event_details_meta_boxes_setup() {
    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action( 'add_meta_boxes', [$this,'mrc_event_meta_boxes'] );
    add_action( 'save_post', [$this,'mrc_save_event_details_meta'], 10, 2 );
}

 /* Create one or more meta boxes to be displayed on the post editor screen. */
  function mrc_event_meta_boxes() {

    add_meta_box(
      'mrc-event-details',      // Unique ID
      esc_html__( 'Event Details', 'myridingclub' ),    // Title
      [$this, 'mrc_event_details_meta_box'],   // Callback function
      'mrc_event',         // Admin page (or post type)
      'normal',         // Context
      'default'         // Priority
    );
}

/* Display the post meta box. */
    function mrc_event_details_meta_box( $post ) { ?>
    
        <?php wp_nonce_field( basename( __FILE__ ), 'mrc_event_details_nonce' ); ?>
    
        <div>
            <label>Event Date</label>
            <input class="widefat" type="date" name="mrc_event_date" id="mrc_event_date" value="<?php echo esc_attr( get_post_meta( $post->ID, 'mrc_event_date', true ) ); ?>" size="30" />
        </div>
        
        <div>
            <label>Event Location</label>
            <input class="widefat" type="text" name="mrc_event_location" id="mrc_event_location" value="<?php echo esc_attr( get_post_meta( $post->ID, 'mrc_event_location', true ) ); ?>" size="30" />
        </div>
        
        <div>
            <label>Enable Online Entries</label>
            <select class="widefat" name="mrc_event_enable_entries" id="mrc_event_enable_entries">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        
        <div>
            <label>Entries Open</label>
            <input class="widefat" type="date" name="mrc_event_entries_open" id="mrc_event_entries_open" value="<?php echo esc_attr( get_post_meta( $post->ID, 'mrc_event_entries_open', true ) ); ?>" size="30" />
        </div>
        
        <div>
            <label>Entries Close</label>
            <input class="widefat" type="date" name="mrc_event_entries_close" id="mrc_event_entries_close" value="<?php echo esc_attr( get_post_meta( $post->ID, 'mrc_event_entries_close', true ) ); ?>" size="30" />
        </div>
        
    <?php }


/* Save the meta box’s post metadata. */
    function mrc_save_event_details_meta( $post_id, $post ) {
    
      /* Verify the nonce before proceeding. */
      if ( !isset( $_POST['mrc_event_details_nonce'] ) || !wp_verify_nonce( $_POST['mrc_event_details_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    
      /* Get the post type object. */
      $post_type = get_post_type_object( $post->post_type );
    
      /* Check if the current user has permission to edit the post. */
      if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;
    
        $fields = array(
            'mrc_event_date'
            ,'mrc_event_location'
            ,'mrc_event_enable_entries'
            ,'mrc_event_entries_open'
            ,'mrc_event_entries_close'
            );
            
        foreach($fields as $field)
        {
            /* Get the posted data and sanitize it for use as an HTML class. */
            $new_meta_value = ( isset( $_POST[$field] ) ? sanitize_html_class( $_POST[$field] ) : '' );
            
            /* Get the meta key. */
            $meta_key = $field;
            
            /* Get the meta value of the custom field key. */
            $meta_value = get_post_meta( $post_id, $meta_key, true );
            
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
            
            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );
            
            /* If there is no new meta value but an old value exists, delete it. */
            elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }
      
    }
    
