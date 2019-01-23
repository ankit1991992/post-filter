<?php
add_shortcode( 'wp_post_filter', 'rmcc_post_listing_parameters_shortcode' );
function rmcc_post_listing_parameters_shortcode( $atts ) {
    global $wpdb;
    ob_start();
    
    // define attributes and their defaults
    extract( shortcode_atts( array (
        'post_type' => '',
        'order' => 'date',
        'orderby' => 'title',
        'posts' => -1,
        'taxonomy' => ''
    ), $atts ) );
    
    $args = array(
        'taxonomy' => $taxonomy,
        'orderby' => 'name',
        'hide_empty' => false,
        'order'   => 'ASC',
        'parent' => 0
    );
    
    ?>
    <div class="pf_container">
        <!-- Sidbar Category List START -->
        <div class="pf-column-sidebar">
            <input type="hidden" class="pf_hidden_type" value="<?php echo $post_type; ?>" />
            <input type="hidden" id="admin_url_pf" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
            <input type="hidden" id="pf_taxonomy" value="<?php echo $taxonomy; ?>" />
            <input type="hidden" class="pf_nonce" value="<?php echo wp_create_nonce('ajax-nonce-for-filter') ?>" />
            <?php 
            $parent = get_terms($args);
            echo "<ul class='pf_parent'>";
            foreach ($parent as $parent_term) {
                $child = get_terms($taxonomy, array('hide_empty' => 0, 'parent' => $parent_term->term_id));
                $parent_name = $parent_term->name;
                $parent_id = $parent_term->term_id;
                echo "<li><a class='pf_term_list' href='javascript:void(0)' data-id='$parent_id'>$parent_name</a></li>";
                
                if(!empty($child)){
                    echo "<ul class='pf_child'>";
                    foreach ($child as $child_term) {
                        $child_name = $child_term->name;
                        $child_id = $child_term->term_id;
                        echo "<li><a class='pf_term_list' href='javascript:void(0)' data-id='$child_id'>$child_name</a></li>";
                    }
                    echo "</ul>";
                }
            }
            echo "</ul>";
            ?>            
        </div>
        <!-- Sidbar Category List END -->
        <!-- Get All Post Based on Filter START -->
        <div class="pf_filter-post">
            <div id="pf_overlay">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/ajax-spinner-gif.gif'; ?>" class="loading_circle" alt="loading" />
            </div>
            <div class="pf_load_post">
                <?php
                global $wp_query;
                $options = array(
                    'post_type' => $post_type,
                    'order' => $order,
                    'orderby' => $orderby,
                    'posts_per_page' => -1,
                    'taxonomy' => $taxonomy
                );
                $the_query = new WP_Query( $options );
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <?php 
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
                    if(!empty($featured_img_url)):
                        $image = $featured_img_url;
                    else:
                        $image = plugin_dir_url( dirname( __FILE__ ) ) . 'images/not-found.png'; 
                    endif;
                    $permalink = get_permalink(get_the_ID());
                    ?>
                        <div class="pf-column-3">
                            <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" />
                            <a href="<?php echo $permalink; ?>"><?php the_title(); ?></a>
                        </div>
                    <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php else:  ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Get All Post Based on Filter END -->
    </div>
    <?php
}