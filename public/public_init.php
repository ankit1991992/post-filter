<?php

class Pf_frontend {
    public function __construct() {
        require AMPPF . 'public/include/ajax.php';
        require AMPPF . 'public/pf_shortcode_generate.php';
        add_action('wp_enqueue_scripts', array($this, 'pf_load_jquery'));
        add_action('wp_enqueue_scripts', array($this, 'pf_frontend_script_register'));
    }
	public function pf_frontend_script_register($hook) {
        wp_enqueue_style( 'pf_main', plugins_url('/css/pf_main.css', __FILE__),array(), $this->version, 'all'  );
       
        wp_enqueue_script( 'pf_custom_frontend', plugin_dir_url( __FILE__ ) . 'js/pf_public.js', array( 'jquery' ), $this->version, false );
    }
    
    public function pf_load_jquery() {
        if ( ! wp_script_is( 'jquery', 'enqueued' )) {
            wp_enqueue_script( 'jquery' );
        }
    }
}