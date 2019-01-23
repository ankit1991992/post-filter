jQuery(document).ready(function($){
    
    jQuery( ".pf_term_list" ).click(function() {
        jQuery('#pf_overlay').show();
        var term_id = jQuery(this).data("id");
        var post_type = jQuery(".pf_hidden_type").val(); 
        var admin_url = jQuery("#admin_url_pf").val();   
        var pf_nonce = jQuery(".pf_nonce").val();
        var pf_taxonomy = jQuery("#pf_taxonomy").val();
        
        jQuery.ajax({
            url: admin_url,
            type: 'POST',
            data: {
                action: "filter_post_based_term",
                post_type: post_type,
                term_id : term_id,
                taxonomy : pf_taxonomy,
                security :pf_nonce
            },
            success: function (data) {
                console.log(data.posts);
                jQuery('#pf_overlay').hide();
                jQuery('.pf_load_post .pf-column-3').remove();
                jQuery('.pf_load_post').html(data.posts)
            }
        }); 
    });
});