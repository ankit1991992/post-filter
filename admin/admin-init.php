<?php

class Pf_admin {
    
    function __construct() {
        
        require AMPPF . 'admin/admin_setting.php';
        new Pf_admin_settings();


        require AMPPF . 'admin/ajax/ajax.php';
        add_action('admin_enqueue_scripts', array($this, 'tp_load_css_in_admin_panel'));
    }
	
	function tp_load_css_in_admin_panel($hook) {
        wp_enqueue_style( 'pf_main', plugins_url('/css/pf_main.css', __FILE__) );
        wp_enqueue_script( 'sweetalert', plugins_url('/js/sweetalert2.all.min.js', __FILE__) );
        wp_enqueue_script( 'pf_custom', plugins_url('/js/admin-custom.js', __FILE__) );
	}
}