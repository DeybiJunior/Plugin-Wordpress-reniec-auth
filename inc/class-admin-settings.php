<?php
/**
 * @package Andina_Reniec_Auth
 */

class Andina_Reniec_Auth_Admin_Settings {

    /**
     * @var array
     */
    private $options;

    public function __construct() {
        $this->options = get_option('andina_reniec_auth_options', array(
            'client_id' => '',
            'client_secret' => '',
            'redirect_uri' => '',
        ));
    }

    public function add_plugin_page() {
        add_options_page(
            'Configuración RENIEC IDAAS', 
            'RENIEC IDAAS', 
            'manage_options', 
            'andina-reniec-auth', 
            array($this, 'create_admin_page') 
        );
    }

    public function create_admin_page() {
        ?>
        <div class="wrap">
            <h1>Configuración de Integración RENIEC - IDAAS Perú</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('andina_reniec_auth_option_group');
                do_settings_sections('andina-reniec-auth-admin');
                submit_button();
                ?>
            </form>
            <hr>
            <h2>Uso del Shortcode</h2>
            <p>Para mostrar el botón de autenticación RENIEC, utiliza el siguiente shortcode en cualquier página o entrada:</p>
            <code>[reniec_auth_button]</code>
            <p>También puedes personalizar el texto del botón:</p>
            <code>[reniec_auth_button text="Iniciar sesión con RENIEC"]</code>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            'andina_reniec_auth_option_group',
            'andina_reniec_auth_options',
            array($this, 'sanitize') 
        );

        add_settings_section(
            'andina_reniec_auth_setting_section', 
            'Configuración de IDAAS', 
            array($this, 'print_section_info'), 
            'andina-reniec-auth-admin'
        );

        add_settings_field(
            'client_id', 
            'Client ID', 
            array($this, 'client_id_callback'), 
            'andina-reniec-auth-admin', 
            'andina_reniec_auth_setting_section' 
        );

        add_settings_field(
            'client_secret', 
            'Client Secret', 
            array($this, 'client_secret_callback'), 
            'andina-reniec-auth-admin', 
            'andina_reniec_auth_setting_section'
        );

        add_settings_field(
            'redirect_uri', 
            'Redirect URI', 
            array($this, 'redirect_uri_callback'), 
            'andina-reniec-auth-admin', 
            'andina_reniec_auth_setting_section'
        );
    }

    /**
     * @param array $input Valores a sanitizar.
     * @return array
     */
    public function sanitize($input) {
        $new_input = array();
        
        if (isset($input['client_id']))
            $new_input['client_id'] = sanitize_text_field($input['client_id']);
        
        if (isset($input['client_secret']))
            $new_input['client_secret'] = sanitize_text_field($input['client_secret']);
        
        if (isset($input['redirect_uri']))
            $new_input['redirect_uri'] = esc_url_raw($input['redirect_uri']);
        
        return $new_input;
    }

    public function print_section_info() {
        echo 'Ingrese la configuración para la integración con RENIEC IDAAS:';
    }

    public function client_id_callback() {
        printf(
            '<input type="text" id="client_id" name="andina_reniec_auth_options[client_id]" value="%s" class="regular-text" />',
            isset($this->options['client_id']) ? esc_attr($this->options['client_id']) : ''
        );
    }


    public function client_secret_callback() {
        printf(
            '<input type="password" id="client_secret" name="andina_reniec_auth_options[client_secret]" value="%s" class="regular-text" />',
            isset($this->options['client_secret']) ? esc_attr($this->options['client_secret']) : ''
        );
    }

    public function redirect_uri_callback() {
        printf(
            '<input type="url" id="redirect_uri" name="andina_reniec_auth_options[redirect_uri]" value="%s" class="regular-text" />',
            isset($this->options['redirect_uri']) ? esc_attr($this->options['redirect_uri']) : ''
        );
        echo '<p class="description">URL a la que RENIEC redirigirá después de la autenticación. Por defecto, se usará la URL de la página actual si se deja en blanco.</p>';
    }
}