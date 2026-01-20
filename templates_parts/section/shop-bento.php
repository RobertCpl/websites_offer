<?php

/**
 * Shop bento grid section.
 */
defined('ABSPATH') || exit;

$products = wc_get_products([
  'status' => 'publish',
  'limit' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
]);

$count = count($products);
if ($count === 0) {
  return;
}

?>

<section
  class="shop-bento-grid grid grid-cols-1 gap-6 animate-enter delay-200 mb-20 md:mb-32 md:grid-cols-3"
  id="realizacje"
  style="grid-auto-rows: minmax(260px, 1fr);">
  <?php foreach ($products as $product) : ?>
    <?php
    $image_id = $product->get_image_id();
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : wc_placeholder_img_src('large');
    $image_srcset = $image_id ? wp_get_attachment_image_srcset($image_id, 'large') : '';
    $image_sizes = '(min-width: 768px) 66vw, 100vw';
    $name = $product->get_name();
    $link = get_permalink($product->get_id());
    $tags = wc_get_product_terms($product->get_id(), 'product_tag', ['fields' => 'names']);

    ?>
    <a
      href="<?php echo esc_url($link); ?>"
      class="shop-bento-item group relative overflow-hidden rounded-[2.5rem] clay-card cursor-pointer min-h-[260px] md:min-h-[350px]">
      <img
        src="<?php echo esc_url($image_url); ?>"
        <?php if (!empty($image_srcset)) : ?>
        srcset="<?php echo esc_attr($image_srcset); ?>"
        sizes="<?php echo esc_attr($image_sizes); ?>"
        <?php endif; ?>
        class="absolute inset-0 w-full !h-full object-cover transition-transform duration-700 group-hover:scale-105"
        alt="<?php echo esc_attr($name); ?>">
      <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors duration-500"></div>
      <span class="absolute top-[20%] right-[5%] text-white text-lg font-semibold drop-shadow bg-black/40 px-3 py-1.5 rounded-full">
        <?php echo esc_html($name); ?>
      </span>
      <?php if (!empty($tags)) : ?>
        <div class="absolute bottom-6 left-6 flex flex-wrap gap-2">
          <?php foreach ($tags as $tag_name) : ?>
            <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full px-3 py-1 backdrop-blur-md">
              <?php echo esc_html($tag_name); ?>
            </span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </a>
  <?php endforeach; ?>
</section>