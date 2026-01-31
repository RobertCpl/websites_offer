<?php

/**
 * Fallback template.
 *
 * This theme previously had an empty `index.php`, which caused regular pages
 * (including WooCommerce Cart/Checkout pages) to render blank.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="lg:px-12 max-w-[1600px] mr-auto ml-auto pt-8 pr-4 pb-20 pl-4">
  <section class="clay-card bg-white rounded-[3rem] p-8 lg:p-16">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <h1 class="text-3xl lg:text-4xl font-bold mb-6 tracking-tight"><?php the_title(); ?></h1>
        <div class="prose prose-lg max-w-none text-slate-600 font-light font-['Inter'] leading-relaxed">
          <?php the_content(); ?>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <h1 class="text-3xl lg:text-4xl font-bold mb-6 tracking-tight"><?php esc_html_e('Brak treści', 'mypage'); ?></h1>
    <?php endif; ?>
  </section>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
