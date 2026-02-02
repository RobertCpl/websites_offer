<?php

/**
 * Cart page template (slug: cart).
 *
 * Renders WooCommerce default cart shortcode regardless of page content.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="lg:px-12 max-w-[1600px] mr-auto ml-auto pt-8 pr-4 pb-20 pl-4">
  <section class="clay-card bg-white rounded-[3rem] p-8 lg:p-16">
    <h1 class="text-3xl lg:text-4xl font-bold mb-6 tracking-tight"><?php esc_html_e('Koszyk', 'mypage'); ?></h1>

    <?php
    if (function_exists('WC')) {
      echo do_shortcode('[woocommerce_cart]'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
      echo '<p>' . esc_html__('WooCommerce nie jest aktywny.', 'mypage') . '</p>';
    }
    ?>
  </section>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
