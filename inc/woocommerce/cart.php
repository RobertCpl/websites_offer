<?php

defined('ABSPATH') || exit;

// Disable classic form submit add-to-cart to avoid double add (AJAX is used).
add_action('wp_loaded', function () {
    if (!class_exists('WC_Form_Handler')) {
        return;
    }

    remove_action('wp_loaded', ['WC_Form_Handler', 'add_to_cart_action'], 20);
}, 5);

/**
 * Mini-cart fragments (count + dropdown contents) for custom header markup.
 *
 * This powers AJAX updates for:
 * - `span.mypage-cart-count`
 * - `div.mypage-mini-cart`
 */

if (!function_exists('mypage_cart_count_html')) {
    function mypage_cart_count_html(): string
    {
        if (!function_exists('WC') || !WC()->cart) {
            return '';
        }
        $count = (int) WC()->cart->get_cart_contents_count();
        ob_start();
?>
        <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 text-[11px] font-bold rounded-full bg-black text-white flex items-center justify-center mypage-cart-count">
            <?php echo esc_html($count); ?>
        </span>
<?php
        return (string) ob_get_clean();
    }
}

if (!function_exists('mypage_mini_cart_html')) {
    function mypage_mini_cart_html(): string
    {
        if (!function_exists('woocommerce_mini_cart')) {
            return '';
        }
        ob_start();
        woocommerce_mini_cart();
        $inner = (string) ob_get_clean();

        return '<div class="mypage-mini-cart">' . $inner . '</div>';
    }
}

add_filter('woocommerce_add_to_cart_fragments', function (array $fragments): array {
    $count_html = mypage_cart_count_html();
    if ($count_html !== '') {
        $fragments['span.mypage-cart-count'] = $count_html;
    }
    $mini_cart_html = mypage_mini_cart_html();
    if ($mini_cart_html !== '') {
        $fragments['div.mypage-mini-cart'] = $mini_cart_html;
    }
    return $fragments;
});



// Hooks to debug add-to-cart quantity

// add_filter('woocommerce_add_to_cart_quantity', function ($qty, $product_id) {
//     $rid = $_SERVER['REQUEST_TIME_FLOAT'] . '-' . wp_rand(1000, 9999);
//     error_log("=== woocommerce_add_to_cart_quantity === RID={$rid}");
//     error_log("woocommerce_add_to_cart_quantity product_id={$product_id} qty={$qty}");
//     if (defined('WP_DEBUG') && WP_DEBUG) {
//         $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);
//         foreach ($trace as $i => $frame) {
//             $file = $frame['file'] ?? '';
//             $line = $frame['line'] ?? '';
//             $func = $frame['function'] ?? '';
//             error_log("trace[{$i}] {$func} {$file}:{$line}");
//         }
//     }
//     return $qty;
// }, 999, 2);


// add_action('woocommerce_add_to_cart', function ($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
//     $rid = $_SERVER['REQUEST_TIME_FLOAT'] . '-' . wp_rand(1000, 9999);
//     error_log("=== woocommerce_add_to_cart === RID={$rid}");
//     error_log("product_id={$product_id} variation_id={$variation_id} qty={$quantity} cart_item_key={$cart_item_key}");
//     error_log("uri=" . ($_SERVER['REQUEST_URI'] ?? ''));
//     error_log("is_ajax=" . (wp_doing_ajax() ? '1' : '0'));
//     error_log("referrer=" . ($_SERVER['HTTP_REFERER'] ?? ''));
//     if (defined('WP_DEBUG') && WP_DEBUG) {
//         $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);
//         foreach ($trace as $i => $frame) {
//             $file = $frame['file'] ?? '';
//             $line = $frame['line'] ?? '';
//             $func = $frame['function'] ?? '';
//             error_log("trace[{$i}] {$func} {$file}:{$line}");
//         }
//     }
// }, 9999, 6);

// add_action('woocommerce_ajax_added_to_cart', function ($product_id) {
//     $rid = $_SERVER['REQUEST_TIME_FLOAT'] . '-' . wp_rand(1000, 9999);
//     error_log("=== woocommerce_ajax_added_to_cart === RID={$rid}");
//     error_log("product_id={$product_id}");
//     error_log("uri=" . ($_SERVER['REQUEST_URI'] ?? ''));
//     error_log("is_ajax=" . (wp_doing_ajax() ? '1' : '0'));
// }, 9999, 1);
