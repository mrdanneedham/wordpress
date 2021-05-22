<?php

/**
*		Manage admin columns in wordpress
*
**/

// Just add the columns
add_filter( 'manage_[post-type]_posts_columns', 'smashing_filter_posts_columns' );
function smashing_filter_posts_columns( $columns ) {
  $columns['image'] = __( 'Image' );
  $columns['price'] = __( 'Price', 'smashing' );
  $columns['area'] = __( 'Area', 'smashing' );
  return $columns;
}

// edit visible columns too
add_filter( 'manage_realestate_posts_columns', 'smashing_realestate_columns' );
function smashing_realestate_columns( $columns ) {
    $columns = array(
      'cb' => $columns['cb'],
      'image' => __( 'Image' ),
      'title' => __( 'Title' ),
      'price' => __( 'Price', 'smashing' ),
      'area' => __( 'Area', 'smashing' ),
    );
  return $columns;
}

// Populate the columns with data
add_action( 'manage_realestate_posts_custom_column', 'smashing_realestate_column', 10, 2);
function smashing_realestate_column( $column, $post_id ) {
  // Image column
  if ( 'image' === $column ) {
    echo get_the_post_thumbnail( $post_id, array(80, 80) );
  }
}

// Make column sortable
add_filter( 'manage_edit-realestate_sortable_columns', 'smashing_realestate_sortable_columns');
function smashing_realestate_sortable_columns( $columns ) {
  $columns['price'] = 'price_per_month';
  return $columns;
}

// add meta into query to make it sortable.
add_action( 'pre_get_posts', 'smashing_posts_orderby' );
function smashing_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'price_per_month' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'price_per_month' );
    $query->set( 'meta_type', 'numeric' );
  }
}
