<?php

defined('ABSPATH') || exit;

if (!function_exists('mypage_render_live_preview_field')) {
    /**
     * Render the live preview URL field in WooCommerce product settings.
     */
    function mypage_render_live_preview_field(): void
    {
        if (!function_exists('woocommerce_wp_text_input')) {
            return;
        }

        woocommerce_wp_text_input([
            'id' => '_live_preview_url',
            'label' => __('Podglad na zywo (URL)', 'mypage'),
            'description' => __('Adres URL otwierany po kliknieciu zdjecia produktu.', 'mypage'),
            'desc_tip' => true,
            'type' => 'url',
            'placeholder' => 'https://',
        ]);
    }
}
add_action('woocommerce_product_options_general_product_data', 'mypage_render_live_preview_field');

if (!function_exists('mypage_save_live_preview_field')) {
    /**
     * Save live preview URL from product settings.
     */
    function mypage_save_live_preview_field(int $product_id): void
    {
        if (!isset($_POST['_live_preview_url'])) {
            return;
        }

        $raw_url = wp_unslash($_POST['_live_preview_url']);
        $url = esc_url_raw($raw_url);

        if ($url === '') {
            delete_post_meta($product_id, '_live_preview_url');
            return;
        }

        update_post_meta($product_id, '_live_preview_url', $url);
    }
}
add_action('woocommerce_process_product_meta', 'mypage_save_live_preview_field');

if (!function_exists('mypage_get_live_preview_url')) {
    /**
     * Get sanitized live preview URL for the given product.
     */
    function mypage_get_live_preview_url(int $product_id): string
    {
        if ($product_id <= 0) {
            return '';
        }

        $url = get_post_meta($product_id, '_live_preview_url', true);
        if (!is_string($url) || $url === '') {
            return '';
        }

        return esc_url_raw($url);
    }
}
