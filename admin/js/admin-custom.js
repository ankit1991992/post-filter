
jQuery(document).ready(function($){

    /* code for copy shortcode */
    jQuery( ".pf_copy_shortcode" ).click(function() {
        var selected_class = jQuery(this).data("id");
        var $temp = jQuery("<input>");
        jQuery("body").append($temp);
        $temp.val(jQuery('.'+selected_class).text()).select();
        document.execCommand("copy");
        $temp.remove();
        Swal({
            position: '',
            type: 'success',
            title: 'Shortcode copied!',
            showConfirmButton: false,
            timer: 1500
        });
    });

    /* Ajax call for the generate taxonomy list */
    jQuery('#select_post_name').on('change', function ($) {
        var post_val = this.value;
        var admin_url = jQuery("#admin_url_pf").val();
        jQuery.ajax({
            url: admin_url,
            type: 'post',
            data: {
                action: "get_term_name_ajax",
                post_name: post_val
            },
            success: function (data) {
                jQuery('.taxonomy_names option').remove();
                jQuery('.taxonomy_names').append(data.options);
            }
        });
    });
    
    
    /* Shortcode Generatation */
    jQuery( "#generate_shortcode" ).click(function() {
        var post_type = jQuery('#select_post_name').val();
        var taxonomy = jQuery('.taxonomy_names').val();
        var admin_url = jQuery("#admin_url_pf").val();
        if(post_type != "" && taxonomy != ""){
            jQuery.ajax({
                url: admin_url,
                type: 'post',
                data: {
                    action: "pf_generate_shortcode",
                    post_type: post_type,
                    taxonomy: taxonomy
                },
                success: function (response) { 
                    if(response.message == true){
                        location.reload();
                    }else{
                        Swal({
                            position: '',
                            type: 'error',
                            title: 'Shortcode already generated!',
                            showConfirmButton: false,
                            showCloseButton: true,
                            timer: 2500
                        });
                    }
                }
            })
        }else{
            Swal({
                position: '',
                type: 'error',
                title: 'Both fields are required!',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 2500
            });
        }
    });

    /* Ajax call for delete generated shortcode */
    jQuery( ".pf_delete_shortcode" ).click(function() {
        var admin_url = jQuery("#admin_url_pf").val();
        var key_id = jQuery(this).data("id");
        
        jQuery.ajax({
            url: admin_url,
            type: 'post',
            data: {
                action: "pf_delete_generated_shortcode",
                id: key_id
            },
            success: function (response) { 
                location.reload();
            }
        });
    });
});