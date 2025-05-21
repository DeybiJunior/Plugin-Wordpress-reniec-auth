<?php
/**
 * Plugin Name: Integración RENIEC - IDAAS Perú
 * Plugin URI: https://deybijunior.github.io
 * Description: Plugin que genera un botón de autenticación con RENIEC (IDAAS Perú) y redirecciona a una URL con parámetros firmados.
 * Version: 1.0.0
 * Author: Deybi Junior Ruiz Marquina
 * Author URI: https://deybijunior.github.io
 * Text Domain: andina-reniec-auth
 */

if (!defined('WPINC')) {
    die;
}

define('ANDINA_RENIEC_AUTH_VERSION', '1.0.0');
define('ANDINA_RENIEC_AUTH_PATH', plugin_dir_path(__FILE__));
define('ANDINA_RENIEC_AUTH_URL', plugin_dir_url(__FILE__));


function activate_andina_reniec_auth() {
}

function deactivate_andina_reniec_auth() {
}

register_activation_hook(__FILE__, 'activate_andina_reniec_auth');
register_deactivation_hook(__FILE__, 'deactivate_andina_reniec_auth');

require_once ANDINA_RENIEC_AUTH_PATH . 'inc/class-admin-settings.php';
require_once ANDINA_RENIEC_AUTH_PATH . 'inc/class-reniec-auth.php';

function andina_reniec_auth_enqueue_scripts() {
    wp_enqueue_style(
        'andina-reniec-auth-style',
        ANDINA_RENIEC_AUTH_URL . 'assets/css/style.css',
        array(),
        ANDINA_RENIEC_AUTH_VERSION
    );
}


function run_andina_reniec_auth() {
    $admin_settings = new Andina_Reniec_Auth_Admin_Settings();
    $reniec_auth = new Andina_Reniec_Auth();
    
    add_action('admin_menu', array($admin_settings, 'add_plugin_page'));
    add_action('admin_init', array($admin_settings, 'page_init'));
    
    add_shortcode('reniec_auth_button', array($reniec_auth, 'render_auth_button'));
    
    if (isset($_GET['response-reniec']) && $_GET['response-reniec'] == '1') {
        add_action('init', array($reniec_auth, 'process_callback'));
    }
}

run_andina_reniec_auth();