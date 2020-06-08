<?php
/**
 * Plugin Name:       Custom Post Filter
 * Description:       Filter Post using post taxonomy.
 * Version:           1.0.0
 * Author:            XcodeWeb
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('AMPPF')) {
    define('AMPPF', plugin_dir_path(__FILE__));
}

function activate_amppf_plugin() {
    require_once AMPPF . 'includes/class-amppf-activator.php';
    new Pf_Activator();
}

function deactivate_amppf_plugin() {
    require_once AMPPF . 'includes/class-amppf-deactivator.php';
    new Pf_Deactivator();
}
register_activation_hook(__FILE__, 'activate_amppf_plugin');
register_deactivation_hook(__FILE__, 'deactivate_amppf_plugin');
if (is_admin()) {
    require_once AMPPF . 'admin/admin-init.php';
    new Pf_admin();
}
require_once AMPPF . 'public/public_init.php';
new Pf_frontend();