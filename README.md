# Integración RENIEC - IDAAS Perú
Este plugin de WordPress integra tu sitio con el sistema de autenticación IDAAS de RENIEC Perú, permitiendo a los usuarios identificarse de forma segura.

## 🚀 Características

### ✅ Custom Post Type y Taxonomías
- Configuración Fácil: Ajustes para Client ID, Client Secret y URI de redirección de IDAAS.
- Botón de Autenticación: Shortcode para insertar un botón que redirige a la plataforma IDAAS.
- Gestión Segura: Manejo del flujo de autenticación, redirección y validación de seguridad.
- Personalización: Opciones para modificar el texto y la clase CSS del botón.

## 📦 Estructura del Plugin

```
andina-reniec-auth/
├── andina-reniec-auth.php          # Archivo principal
├── inc/
│   ├── class-admin-settings.php    # Configuración del admin
│   └── class-reniec-auth.php       # Lógica de autenticación
├── templates/
│   └── button-template.php         # Plantilla del botón
└── assets/
│   └── css/style.css               # Estilos CSS
└── README.md                     # Esta documentación
```

# 👨‍💻 Autor
Deybi Junior Ruiz Marquina
Website: https://deybijunior.github.io
Versión: 1.0.0

# 📄 Licencia
Este plugin está licenciado bajo GPL v2 o posterior.