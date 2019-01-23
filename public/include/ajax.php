<?php

/* Ajax Call for Filter post based onterm */
add_action( 'wp_ajax_filter_post_based_term', 'filter_post_based_term' );
add_action( 'wp_ajax_nopriv_filter_post_based_term', 'filter_post_based_term' );
function filter_post_based_term() {
    check_ajax_referer( 'ajax-nonce-for-filter', 'security' );
    
    
    $post_type = $_POST['post_type'];
    $term_id = $_POST['term_id'];
    $taxonomy = $_POST['taxonomy'];
    
    $args = array(
        'post_type' => $post_type,
        'tax_query' => array(
            array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => $term_id
            )
        )
    );
    $the_query = new WP_Query( $args );
    global $wpdb;
    
    if ( $the_query->have_posts() ) {
        $output = "";
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
            if(!empty($featured_img_url)):
                $image = $featured_img_url;
            else:
                //$image = plugin_dir_url( dirname( __FILE__ ) ) . 'images/not-found.png'; 
                $image = plugins_url('amp-post-filter/images/not-found.png', dirname('') );
            endif;
            $permalink = get_permalink(get_the_ID());
            $title = get_the_title();
            $output .= "<div class='pf-column-3'>";
            $output .= "<img src='$image' alt='$title' alt='Tet' />";
            $output .= "<a href='$permalink'>$title</a>";
            $output .= "</div>";
        }
        /* Restore original Post Data */
        wp_reset_postdata();
       
    }else{
        $output = "No post match in your criteria.";
    }
    
    $return = array(
        'message' => 'Success',
        'posts' =>$output
    );
    wp_send_json($return);
    wp_die();
}