<?php

add_action('wpmu_new_blog', 'landbryo_create_pages', 10, 2);

function landbryo_create_pages($blog_id, $user_id){
  switch_to_blog($blog_id);

// create home page
  $page_id = wp_insert_post(array(
    'post_title'     => 'Home',
    'post_name'      => 'home',
    'post_content'   => '',
    'post_status'    => 'publish',
    'post_author'    => $user_id, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 1,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
    'page_template'  => 'page-home.php',
  ));

// create contact page
  $page_id = wp_insert_post(array(
    'post_title'     => 'Contact',
    'post_name'      => 'contact',
    'post_content'   => '[gravityform id="1" title="false" description="false"]',
    'post_status'    => 'publish',
    'post_author'    => $user_id, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 2,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
    'page_template'  => '',
 ));

// Find and delete the WP default post and page
    $defaultPage = get_page_by_title( 'Sample Page' );
    $defaultPost = get_page_by_title( 'Hello world!' );
    wp_delete_post( $defaultPage->ID );
    wp_delete_post( $defaultPost->ID );

// Set default home page
    $home = get_page_by_title( 'Home' );
    update_option( 'page_on_front', $home->ID );
    update_option( 'show_on_front', 'page' );

  // Leave this line at the end of this function
  restore_current_blog();
}

// set permalink structure
function set_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%postname%/' );
}
add_action( 'wpmu_new_blog', 'set_permalinks' );
