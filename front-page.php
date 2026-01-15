<?php
get_template_part('templates_parts/layout/header');
?>
<!-- Main Content Wrapper -->
<main class="lg:px-12 max-w-[1600px] mr-auto ml-auto pt-8 pr-4 pb-20 pl-4">
  <?php get_template_part('templates_parts/section/hero'); ?>
  <?php get_template_part('templates_parts/section/bento-grid'); ?>
  <?php get_template_part('templates_parts/section/stats'); ?>
  <?php get_template_part('templates_parts/section/about'); ?>
  <?php get_template_part('templates_parts/section/benefits'); ?>
  <?php get_template_part('templates_parts/section/portfolio'); ?>
  <?php get_template_part('templates_parts/section/pricing'); ?>
  <?php get_template_part('templates_parts/section/tech-stack'); ?>
  <?php get_template_part('templates_parts/section/contact'); ?>
</main>
<?php
get_template_part('templates_parts/layout/footer');
?>