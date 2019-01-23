<?php

class Pf_admin_settings {
    function __construct() {
        add_action('admin_menu', array($this, 'add_scr_plugin_admin_menu'));
    }
    function add_scr_plugin_admin_menu() {
        add_menu_page( __( 'Post Setting', 'Post Setting' ), __( 'Post Setting', 'Post Setting' ), 'wp_pf_settings', 'Post Setting', null, 'dashicons-welcome-widgets-menus', '5' );
		add_submenu_page('Post Setting', 'Post Setting', 'Post Setting', 'manage_options', 'wp_pf_setting',array($this, 'wp_pf_settings_fun')); 
    }

    function wp_pf_settings_fun() {	
        require AMPPF . 'admin/view/admin_setting_view.php';
    }
}


