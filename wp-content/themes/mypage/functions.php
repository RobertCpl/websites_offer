<?php

require_once get_stylesheet_directory() . '/inc/woocommerce/cart.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/live-preview.php';
require_once get_stylesheet_directory() . '/inc/woocommerce/checkout-company-nip.php';

// WooCommerce support (Shop, product archives, single products).
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

add_action('wp_enqueue_scripts', function () {
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();
    $contact_form_nonce = wp_create_nonce('contact_form_submit');


    // DEV mode toggle: when WP_DEBUG=true we load assets from Vite dev server (HMR),
    // otherwise we load built assets from dist/manifest.json.
    $is_dev = defined('WP_DEBUG') && WP_DEBUG;

    if ($is_dev) {
        // DEV: Vite dev server
        // Load CSS early (in <head>) so critical styles (e.g. loader overlay) apply immediately.
        wp_enqueue_style(
            'theme-main-css',
            'http://localhost:5173/wp-content/themes/mypage/assets/css/main.css',
            [],
            null
        );

        wp_enqueue_script(
            'vite-client',
            'http://localhost:5173/@vite/client',
            [],
            null
        );

        wp_enqueue_script(
            'theme-main',
            'http://localhost:5173/wp-content/themes/mypage/assets/js/main.js',
            [],
            null,
            true
        );

        // Vite outputs ES modules; WordPress defaults to classic scripts unless specified.
        wp_script_add_data('vite-client', 'type', 'module');
        wp_script_add_data('theme-main', 'type', 'module');

        wp_add_inline_script(
            'theme-main',
            'window.ContactForm=' . wp_json_encode([
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => $contact_form_nonce,
            ]) . ';',
            'before'
        );
    } else {

        // PROD: manifest
        // Vite writes manifest to dist/.vite/manifest.json by default (when manifest: true),
        // but we prefer dist/manifest.json (when manifest is a string).
        $manifest_path_candidates = [
            $theme_dir . '/dist/manifest.json',
            $theme_dir . '/dist/.vite/manifest.json',
        ];
        $manifest_path = null;

        foreach ($manifest_path_candidates as $candidate) {
            if (file_exists($candidate)) {
                $manifest_path = $candidate;
                break;
            }
        }

        if (!$manifest_path) {
            return;
        }

        $manifest = json_decode(file_get_contents($manifest_path), true);
        $entry = $manifest['wp-content/themes/mypage/assets/js/main.js'] ?? null;
        $css_entry = $manifest['wp-content/themes/mypage/assets/css/main.css'] ?? null;

        // CSS jako osobny entry (Tailwind v4 CSS-first) — preferowane.
        if (!empty($css_entry['file'])) {
            wp_enqueue_style(
                'theme-main-css',
                $theme_uri . '/dist/' . $css_entry['file'],
                [],
                null
            );
        }

        // Back-compat: CSS powiązany z JS entry (jeśli był importowany w JS)
        if ($entry && !empty($entry['css'])) {
            foreach ($entry['css'] as $css_file) {
                wp_enqueue_style(
                    'theme-main-css',
                    $theme_uri . '/dist/' . $css_file,
                    [],
                    null
                );
            }
        }

        // JS z manifestu
        if (!$entry || empty($entry['file'])) {
            return;
        }

        wp_enqueue_script(
            'theme-main',
            $theme_uri . '/dist/' . $entry['file'],
            [],
            null,
            true
        );

        // Vite build outputs ESM by default.
        wp_script_add_data('theme-main', 'type', 'module');

        wp_add_inline_script(
            'theme-main',
            'window.ContactForm=' . wp_json_encode([
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => $contact_form_nonce,
            ]) . ';',
            'before'
        );
    }
});

// Ensure Vite scripts are loaded as ES modules (some setups ignore wp_script_add_data('type','module')).
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if (in_array($handle, ['vite-client', 'theme-main'], true)) {
        return sprintf(
            '<script type="module" src="%s"></script>' . "\n",
            esc_url($src)
        );
    }

    return $tag;
}, 10, 3);

/**
 * Renderowanie obrazków z Media Library po nazwie pliku (np. "hero-icon.webp").
 *
 * Do czego to jest:
 * - W templatkach chcemy używać tylko `wp_get_attachment_image()` (żeby mieć `srcset` / `sizes`),
 *   ale ta funkcja potrzebuje ID załącznika.
 * - Ta funkcja wyszukuje ID załącznika po `_wp_attached_file` (czyli po ścieżce/nazwie w uploads)
 *   i zwraca gotowy tag `<img>` z `wp_get_attachment_image()`.
 *
 * Jeśli nie znajdzie załącznika, zwraca pusty string (nie ma fallbacków do plików z motywu).
 */
if (!function_exists('mypage_attachment_image_by_filename')) {
    function mypage_attachment_image_by_filename(string $filename, string $size = 'full', array $attr = []): string
    {
        $filename = trim($filename);
        if ($filename === '') {
            return '';
        }

        // Prosty cache w trakcie jednego requestu (żeby nie odpalać get_posts() kilka razy).
        static $cache = [];
        $cache_key = $filename . '|' . $size . '|' . md5(wp_json_encode($attr));
        if (isset($cache[$cache_key])) {
            return $cache[$cache_key];
        }

        $ids = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'meta_query' => [[
                'key' => '_wp_attached_file',
                'value' => $filename,
                'compare' => 'LIKE',
            ]],
        ]);

        $html = !empty($ids[0])
            ? (string) wp_get_attachment_image((int) $ids[0], $size, false, $attr)
            : '';

        $cache[$cache_key] = $html;
        return $html;
    }
}

add_action('phpmailer_init', function ($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Username = 'reconrc@gmail.com';

    // Password from environment variable or constant na produkcji mozna ustawic stala do gmail w pliku wp-config.php
    $password = defined('GMAIL_APP_PASSWORD')
        ? constant('GMAIL_APP_PASSWORD')
        : getenv('GMAIL_APP_PASSWORD');
    if (empty($password)) {
        return;
    }

    $phpmailer->Password = $password;
    $phpmailer->setFrom('reconrc@gmail.com', 'Madeapp');
});

add_filter('wp_mail_from', function () {
    return 'reconrc@gmail.com';
});

add_filter('wp_mail_from_name', function () {
    return 'Madeapp';
});

add_action('wp_mail_failed', function ($error) {
    return $error;
});

// Obsluga formularza kontaktowego
add_action('wp_ajax_contact_form_submit', 'handle_contact_form_submit');
add_action('wp_ajax_nopriv_contact_form_submit', 'handle_contact_form_submit');

function handle_contact_form_submit()
{
    $nonce = sanitize_text_field($_POST['nonce'] ?? '');
    $nonce_valid = wp_verify_nonce($nonce, 'contact_form_submit');
    if (!$nonce_valid) {
        wp_send_json_error(['message' => 'Nieprawidłowy token bezpieczeństwa.'], 403);
    }

    $honeypot = sanitize_text_field($_POST['website'] ?? '');
    if (!empty($honeypot)) {
        wp_send_json_error(['message' => 'Spam detected.'], 400);
    }

    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => 'Podaj poprawny adres email.'], 400);
    }

    if (empty($message)) {
        wp_send_json_error(['message' => 'Wiadomość nie może być pusta.'], 400);
    }

    $subject = sprintf('Wiadomość z formularza: %s', $name ?: 'bez imienia');
    $body = "Imię: {$name}\n";
    $body .= "Email: {$email}\n\n";
    $body .= "Wiadomość:\n{$message}\n";

    $headers = [];
    if (!empty($email)) {
        $reply_to_name = $name ?: 'Kontakt z formularza';
        $headers[] = sprintf('Reply-To: %s <%s>', $reply_to_name, $email);
    }

    $sent = wp_mail('reconrc@gmail.com', $subject, $body, $headers);
    if (!$sent) {
        wp_send_json_error([
            'message' => 'Nie udało się wysłać wiadomości. Spróbuj ponownie później.',
        ], 500);
    }

    wp_send_json_success(['message' => 'Wiadomość została wysłana. Dziękuję!']);
}
