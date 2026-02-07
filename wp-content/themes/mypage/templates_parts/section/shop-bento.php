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
  class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 animate-enter delay-200 mb-20 md:mb-32"
  id="realizacje"
  style="grid-auto-rows: minmax(624px, auto);">
  <?php foreach ($products as $product) : ?>
    <?php
    $image_id = $product->get_image_id();
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : wc_placeholder_img_src('large');
    $image_srcset = $image_id ? wp_get_attachment_image_srcset($image_id, 'large') : '';
    $image_sizes = '(min-width: 768px) 33vw, 100vw';
    $name = $product->get_name();
    $link = get_permalink($product->get_id());
    $tags = wc_get_product_terms($product->get_id(), 'product_tag', ['fields' => 'names']);
    ?>
    <div class="shop-bento-item relative flex flex-col gap-3">
      <a
        href="<?php echo esc_url($link); ?>"
        class="group relative overflow-hidden rounded-[40px] cursor-pointer w-full h-[531px] block shadow-[20px_20px_30px_0px_#d4d4d8]">
        <img
          src="<?php echo esc_url($image_url); ?>"
          <?php if (!empty($image_srcset)) : ?>
          srcset="<?php echo esc_attr($image_srcset); ?>"
          sizes="<?php echo esc_attr($image_sizes); ?>"
          <?php endif; ?>
          class="absolute inset-0 w-full h-full! object-cover transition-transform duration-700 group-hover:scale-105"
          alt="<?php echo esc_attr($name); ?>">
        <?php if (!empty($tags)) : ?>
          <div class="absolute bottom-6 right-6 flex flex-wrap gap-2 z-10 justify-end">
            <?php foreach ($tags as $tag_name) : ?>
              <span class="backdrop-blur-[6px] bg-black border border-white/20 text-[11px] uppercase font-bold text-white tracking-[0.275px] rounded-full px-[13px] py-[5px]">
                <?php echo esc_html($tag_name); ?>
              </span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <div class="absolute inset-0 pointer-events-none rounded-[inherit] shadow-[inset_-10px_-10px_20px_0px_rgba(174,174,192,0.1),inset_10px_10px_20px_0px_rgba(255,255,255,0.8)]"></div>
      </a>
      <div class="px-4 mt-1">
        <h3 class="text-[24px] leading-[28px] font-semibold text-black"><?php echo esc_html($name); ?></h3>
      </div>
      <div class="px-4 mt-0">
        <p class="text-[16px] leading-[20px] font-semibold text-[#6a7282]"><?php echo wp_kses_post($product->get_price_html()); ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</section>