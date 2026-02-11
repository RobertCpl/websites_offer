<?php

/**
 * WooCommerce product archive template (Shop page, product categories, etc.).
 *
 * Minimal version aligned with this theme layout.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="mx-auto px-4 md:px-8 lg:px-12 max-w-400">

  <?php get_template_part('templates_parts/section/shop-intro'); ?>

  <?php get_template_part('templates_parts/section/shop-bento'); ?>

  <?php get_template_part('templates_parts/section/shop-benefits'); ?>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
