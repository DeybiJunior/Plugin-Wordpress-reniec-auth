<?php
/**
 * @package Andina_Reniec_Auth
 */

if (!defined('WPINC')) {
    die;
}
?>

<div class="reniec-auth-container">
    <a href="<?php echo esc_url($auth_url); ?>" class="<?php echo esc_attr($atts['class']); ?>">
        <?php echo esc_html($atts['text']); ?>
    </a>
</div>