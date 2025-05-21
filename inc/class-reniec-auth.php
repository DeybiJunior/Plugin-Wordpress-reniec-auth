<?php
/**
 *
 * @package Andina_Reniec_Auth
 */

class Andina_Reniec_Auth {

    /**
     *
     * @var array
     */
    private $options;


    public function __construct() {
        $this->options = get_option('andina_reniec_auth_options', array(
            'client_id' => '',
            'client_secret' => '',
            'redirect_uri' => '',
        ));

        $autoload_file = ANDINA_RENIEC_AUTH_PATH . 'vendor/autoload.php';
        if (file_exists($autoload_file)) {
            require_once $autoload_file;
        }
    }

    /**
     *
     * @param string $redirect_uri URI de redirección
     * @return string URL de autenticación
     */
    public function generate_auth_url($redirect_uri = '') {
        if (empty($redirect_uri)) {
            $redirect_uri = !empty($this->options['redirect_uri']) ? 
                            $this->options['redirect_uri'] : 
                            add_query_arg('response-reniec', '1', home_url(add_query_arg(array(), $GLOBALS['wp']->request)));
        }

        $state = wp_generate_password(24, false);
        
        if (!session_id()) {
            session_start();
        }
        $_SESSION['reniec_auth_state'] = $state;

        
        $params = array(
            'client_id' => $this->options['client_id'],
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'openid profile',
            'state' => $state,
        );

        
        $auth_url = 'https://idaas.reniec.gob.pe/authorize';
        
        $auth_url = add_query_arg($params, $auth_url);

        return $auth_url;
    }

    public function process_callback() {
        if (!isset($_GET['state']) || !isset($_GET['code'])) {
            wp_redirect(home_url());
            exit;
        }

        if (!session_id()) {
            session_start();
        }

        if (!isset($_SESSION['reniec_auth_state']) || $_SESSION['reniec_auth_state'] !== $_GET['state']) {
            wp_die('Error de verificación de estado. Posible intento de CSRF.');
        }

        unset($_SESSION['reniec_auth_state']);
        
        wp_safe_redirect(home_url());
        exit;
    }

    /**
     *
     * @param array $atts Atributos del shortcode
     * @return string HTML del botón
     */
    public function render_auth_button($atts = array()) {
        $atts = shortcode_atts(array(
            'text' => 'Autenticarse con RENIEC',
            'class' => 'reniec-auth-button',
            'redirect' => '',
        ), $atts, 'reniec_auth_button');

        if (empty($this->options['client_id']) || empty($this->options['client_secret'])) {
            if (current_user_can('manage_options')) {
                return '<div class="reniec-auth-error">Error: La configuración de RENIEC IDAAS está incompleta. <a href="' . admin_url('options-general.php?page=andina-reniec-auth') . '">Completar configuración</a>.</div>';
            } else {
                return '<div class="reniec-auth-error">El servicio de autenticación con RENIEC no está disponible en este momento.</div>';
            }
        }

        $auth_url = $this->generate_auth_url($atts['redirect']);

        ob_start();
        include ANDINA_RENIEC_AUTH_PATH . 'templates/button-template.php';
        return ob_get_clean();
    }
}