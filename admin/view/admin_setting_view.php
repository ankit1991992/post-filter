<div class="wrap">
    <h1 class="wp-heading-inline">WP Post Filter Setting</h1>
    <hr>
    <div class="pf_content">
        <input type="hidden" id="admin_url_pf" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
        <?php
        $args = array(
            'public' => true,
            '_builtin' => false,
        );

        $output = 'objects'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'

        global $wp_post_types;
        $obj = $wp_post_types['post'];
        $post_types = get_post_types($args, $output, $operator);
        ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="select_post_name">Post Type : </label></th>
                    <td>
                        <?php 
                        echo '<select class="select" id="select_post_name">';
                        echo '<option value="">Select Post Type</option>';
                        echo '<option value=' . $obj->name . '>' . $obj->labels->singular_name . '</option>';
                        foreach ($post_types as $key => $post_type) {
                            echo '<option value=' . $key . '>' . $post_type->label . '</option>';
                        }
                        echo '</select>'
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="select_post_name">Taxonomy Name : </label></th>
                    <td>
                    <select class="taxonomy_names">
                        <option value="">Select Taxonomy</option>
                    </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <a href="javascript:void(0)" id="generate_shortcode" class="button button-primary">Generate Shortcode</a>    
        </p>
    </div>
    <?php 
    $get_commoditys = json_decode(get_option('pf_generated_shortcode',true),true);
    if(!empty($get_commoditys)):
    ?>
    <div class="shortcode_list">
        <table>
            <?php
                foreach ($get_commoditys as $key => $commodity) {
                    $post_type = $commodity["post_type"];
                    $taxonomy = $commodity["taxonomy"];
                    echo "<tr id='$key'>";
                    echo "<td class='$key'>[wp_post_filter post_type='$post_type' taxonomy='$taxonomy']</td>";
                    echo "<td class='field_opeartion'><a class='pf_copy_shortcode' href='javascript:void(0);' data-id='$key'><span class='dashicons dashicons-admin-page'></span></a></td>";
                    echo "<td class='field_opeartion'><a class='pf_delete_shortcode' href='javascript:void(0);' data-id='$key'><span class='dashicons dashicons-trash'></span></a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    <?php  endif; ?>
</div>