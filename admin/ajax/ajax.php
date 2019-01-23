<?php
/* Ajax Call for get term name */
add_action( 'wp_ajax_get_term_name_ajax', 'get_term_name_ajax' );
function get_term_name_ajax() {
    global $wpdb;
    $post_name_ajax = $_POST['post_name'];
    $taxonomies = get_object_taxonomies($post_name_ajax);
    $option = '';
    $option .='<option value="">Select Taxonomy</option>';
    foreach ($taxonomies as $taxonomy) {
        $option .='<option value="' . $taxonomy . '">' . $taxonomy . '</option>';
    }
    $return = array(
        'message' => 'Success',
        'options' => $option
    );
    wp_send_json($return);
    wp_die();
}

/* Ajax Call for Generate Shortcode */
add_action( 'wp_ajax_pf_generate_shortcode', 'pf_generate_shortcode' );
function pf_generate_shortcode() {
    global $wpdb;
    $post_type = $_POST['post_type'];
    $taxonomy = $_POST['taxonomy'];

    $com_data = get_option('pf_generated_shortcode',true);
    $com_array = json_decode($com_data,true);
    
    if(array_key_exists($taxonomy, $com_array)){
        $status = "Shortcode already generated";
    }else{
        $com_array[$taxonomy] = array(
            'post_type' => $post_type,
            'taxonomy' => $taxonomy
        );
        $update_date = wp_json_encode($com_array);
        
        $updated_code = update_option( 'pf_generated_shortcode', $update_date );
        if ($updated_code == true) {
            $response = 'Success';
            $status = true;
        } else {
            $response = 'Failed';
        }
    }

    $return = array(
        'message' => $response,
        'message' => $status,
        'options' => $updated_code
    );
    wp_send_json($return);
    wp_die();
}



/* Ajax Call for Delete Generated Shortcode */
add_action( 'wp_ajax_pf_delete_generated_shortcode', 'pf_delete_generated_shortcode' );
function pf_delete_generated_shortcode() {
    global $wpdb;
    $id = $_POST['id'];
    
    $short_code = json_decode(get_option('pf_generated_shortcode',true),true);
    unset($short_code[$id]);
    $updated_com = json_encode($short_code);
    $updated_code = update_option( 'pf_generated_shortcode', $updated_com );
    
    if ($updated_code == true) {
        $response = 'Success';
    } else {
        $response = 'Failed';
    }
    $return = array(
        'message' => $response,
    );
    wp_send_json($return);
    wp_die();
}