<?php

/**
 * WooCommerce product archive template (Shop page, product categories, etc.).
 *
 * Minimal version aligned with this theme layout.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="lg:px-12 max-w-[1600px] mr-auto ml-auto pt-8 pr-4 pb-20 pl-4">

  <?php get_template_part('templates_parts/section/shop-intro'); ?>

  <?php get_template_part('templates_parts/section/shop-bento'); ?>

  <?php get_template_part('templates_parts/section/shop-benefits'); ?>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
