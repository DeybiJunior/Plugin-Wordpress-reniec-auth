# Detalles de Implementación: Integración RENIEC - IDAAS Perú

# 🏗️ Enfoque Técnico y Arquitectura

- Diseño: Modular y orientado a objetos para facilitar el mantenimiento.
- Clases Principales:
  - andina-reniec-auth.php: Inicializa el plugin.
  - inc/class-admin-settings.php: Gestiona la configuración administrativa.
  - inc/class-reniec-auth.php: Contiene la lógica de autenticación y callback.
- Estructura:
  - templates/button-template.php: Plantilla para el botón.
  - assets/css/style.css: Estilos del botón.

# 🚀 Instalación
1. Prerrequisitos: WordPress 5.0+ y PHP 7.0+, credenciales IDAAS RENIEC.
2. Subir Plugin: Copia la carpeta andina-reniec-auth a /wp-content/plugins/.
3. Activar: Desde el panel de administración de WordPress, activa el plugin.
4. Configurar: Ve a Ajustes > RENIEC IDAAS para ingresar las credenciales.

# 📝 Uso del Shortcode
- Inserta el botón de autenticación en cualquier página o entrada usando: [reniec_auth_button]
- Personalización: [reniec_auth_button text="Identificarme con RENIEC" class="mi-clase-personalizada"]

# 🔒 Decisiones de Seguridad

- Verificación de state para prevenir ataques CSRF.
- Sanitización de entradas y escapado de salidas.
- Uso de nonces para operaciones administrativas.
- Ocultamiento de errores sensibles.