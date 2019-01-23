<?php
class Pf_Activator {
    function __construct() {
        $this->activate();
    }
    function activate() {
        update_option('pf_status', "active");
        update_option('pf_generated_shortcode','active');
    }
}
