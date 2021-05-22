<?php

class mrc_org
{
    function __construct(){
        add_action( 'init', array($this, 'register_post_type' ));
        add_action( 'init', array($this, 'org_type_taxonomy'), 0 );
        //add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
    }
    
    function register_post_type() {
        $labels = array(
             'name' => __( 'Organisers', 'myridingclub' ),
             'singular_name' => __('Organiser', 'myridingclub'  ),
             'add_new' => __('New Organiser', 'myridingclub' ),
             'add_new_item' => __( 'Add A New Organiser', 'myridingclub'  ),
             'edit_item' => __( 'Edit Organiser', 'myridingclub'  ),
             'new_item' => __( 'New Organiser', 'myridingclub'  ),
             'view_item' => __( 'View Organiser', 'myridingclub'  ),
             'search_items' => __( 'Search Organisers', 'myridingclub'  ),
             'not_found' =>  __( 'No Organisers Found', 'myridingclub'  ),
             'not_found_in_trash' => __( 'No Organisers Found In Trash', 'myridingclub'  ),
            );
            
        $args = array(
             'labels' => $labels,
             'has_archive' => true,
             'public' => true,
             'hierarchical' => false,
             'supports' => array(
              'title',
              'editor',
              'excerpt',
              'custom-fields',
              'thumbnail',
              'page-attributes'
             ),
             //'taxonomies' => 'category',
             'rewrite'   => array( 'slug' => 'organiser' ),
             'show_in_rest' => true
            );
            
        register_post_type( 'mrc_organiser', $args );    
        
       

    }
    
     function prefix_disable_gutenberg($current_status, $post_type)
        {
            // Use your post type key instead of 'product'
            if ($post_type === 'mrc_organiser') return false;
            return $current_status;
        }
    
    function org_type_taxonomy() {
        // Add new taxonomy, make it hierarchical like categories
        //first do the translations part for GUI
         
          $labels = array(
            'name' => _x( 'Organiser Type', 'taxonomy general name' ),
            'singular_name' => _x( 'Organiser Type', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Organiser Type' ),
            'all_items' => __( 'All Organiser Type' ),
            'parent_item' => __( 'Parent Organiser Type' ),
            'parent_item_colon' => __( 'Parent Organiser Type:' ),
            'edit_item' => __( 'Edit Organiser Type' ), 
            'update_item' => __( 'Update Organiser Type' ),
            'add_new_item' => __( 'Add New Organiser Type' ),
            'new_item_name' => __( 'New Organiser Type Name' ),
            'menu_name' => __( 'Organiser Type' ),
          );    
         
        // Now register the taxonomy
          register_taxonomy('organiser_category',array('mrc_organiser'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'organiser-type' ),
          ));
         
        }
}

$mrc_org = new mrc_org;
