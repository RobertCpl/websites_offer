<?php

/**
 * WooCommerce single product template.
 *
 * Minimal version aligned with this theme layout.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="lg:px-12 max-w-[1600px] mr-auto ml-auto pt-8 pr-4 pb-20 pl-4">
  <?php
  // do_action('woocommerce_before_single_product');

  while (have_posts()) :
    the_post();
    $product = wc_get_product(get_the_ID());
    if (!$product) {
      continue;
    }

    $image_id = $product->get_image_id();
    $gallery_ids = $product->get_gallery_image_ids();
    $thumb_ids = array_values(array_unique(array_filter(array_merge([$image_id], $gallery_ids))));
    $thumb_ids = array_slice($thumb_ids, 0, 4);
    $remaining_thumbs = max(0, count($gallery_ids) + ($image_id ? 1 : 0) - 4);
    $short_description = $product->get_short_description();
    $average_rating = (float) $product->get_average_rating();
    $review_count = (int) $product->get_review_count();
    $price_html = $product->get_price_html();
  ?>

    <!-- 1. PRODUCT HERO SECTION -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:gap-20 animate-enter delay-100 gap-x-12 gap-y-12 items-start">
      <!-- Left Column: Images -->
      <div class="flex flex-col gap-6">
        <div class="w-full clay-card rounded-[3rem] overflow-hidden aspect-[4/5] relative bg-white group cursor-zoom-in">
          <?php
          if ($image_id) {
            echo wp_get_attachment_image(
              $image_id,
              'large',
              false,
              ['class' => 'w-full !h-full object-cover transition-transform duration-700 group-hover:scale-105']
            );
          }
          ?>
        </div>

        <?php if (!empty($thumb_ids)) : ?>
          <div class="grid grid-cols-4 gap-4">
            <?php foreach ($thumb_ids as $index => $thumb_id) : ?>
              <?php
              $is_primary = $index === 0;
              $is_last_with_more = $index === 3 && $remaining_thumbs > 0;
              $thumb_classes = $is_primary
                ? 'aspect-square rounded-[1.5rem] overflow-hidden border-2 border-black clay-card transition-transform hover:scale-95'
                : 'aspect-square rounded-[1.5rem] overflow-hidden border border-transparent hover:border-slate-300 clay-card transition-all hover:scale-95' .
                ($is_last_with_more ? ' relative' : '');
              $img_classes = 'w-full h-full object-cover' . ($is_last_with_more ? ' opacity-70' : '');
              ?>
              <div class="<?php echo esc_attr($thumb_classes); ?>">
                <?php
                echo wp_get_attachment_image(
                  $thumb_id,
                  'thumbnail',
                  false,
                  ['class' => $img_classes]
                );
                ?>
                <?php if ($is_last_with_more) : ?>
                  <span class="absolute inset-0 flex items-center justify-center font-['Syne'] font-bold text-lg">
                    +<?php echo esc_html($remaining_thumbs); ?>
                  </span>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Right Column: Details -->
      <div class="flex flex-col pt-4 lg:sticky lg:top-8">
        <div class="flex flex-wrap gap-2 mb-6">
          <?php
          $tag_terms = wp_get_post_terms($product->get_id(), 'product_tag', ['fields' => 'names']);
          $chips = array_values(array_unique(array_filter(
            is_array($tag_terms) ? $tag_terms : []
          )));

          foreach ($chips as $chip) :
          ?>
            <span class="text-[11px] uppercase font-bold text-slate-500 tracking-wide bg-white border border-slate-200 rounded-full px-3 py-1">
              <?php echo esc_html($chip); ?>
            </span>
          <?php endforeach; ?>
        </div>

        <h1 class="leading-tight lg:text-4xl text-4xl font-bold text-slate-900 tracking-tight mb-4">
          <?php the_title(); ?>
        </h1>

        <?php if (!empty($short_description)) : ?>
          <div class="leading-relaxed text-base font-light text-slate-500 max-w-xl mb-8">
            <?php echo wp_kses_post(wpautop($short_description)); ?>
          </div>
        <?php endif; ?>

        <div class="w-full h-px bg-slate-200 mb-8"></div>

        <div class="flex items-end gap-3 mb-8">
          <?php if ($product->is_on_sale() && $product->get_regular_price()) : ?>
            <span class="text-4xl font-bold font-['Syne'] text-slate-900 tracking-tight">
              <?php echo wp_kses_post(wc_price((float) $product->get_sale_price())); ?>
            </span>
            <span class="text-lg text-slate-400 line-through mb-1.5 font-medium">
              <?php echo wp_kses_post(wc_price((float) $product->get_regular_price())); ?>
            </span>
          <?php else : ?>
            <span class="text-4xl font-bold font-['Syne'] text-slate-900 tracking-tight">
              <?php echo wp_kses_post($price_html); ?>
            </span>
          <?php endif; ?>
        </div>

        <div class="flex flex-col lg:flex-row gap-4">
          <form class="cart flex flex-1 flex-col lg:flex-row gap-4" method="post" enctype="multipart/form-data" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>">
            <div class="flex bg-white border-slate-200 border rounded-full p-2 shadow-sm items-center justify-between">
              <?php
              $min_qty = $product->get_min_purchase_quantity();
              $max_qty = $product->get_max_purchase_quantity();
              $input_value = $min_qty;
              $max_attr = $max_qty > 0 ? $max_qty : '';
              ?>
              <div class="flex w-full items-center justify-between" data-quantity-selector>
                <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors text-slate-600" data-quantity-action="decrease" aria-label="<?php echo esc_attr__('Zmniejsz ilosc', 'mypage'); ?>">
                  <span class="text-xl font-bold">-</span>
                </button>
                <input
                  type="number"
                  name="quantity"
                  min="<?php echo esc_attr($min_qty); ?>"
                  <?php if ($max_attr !== '') : ?>
                  max="<?php echo esc_attr($max_attr); ?>"
                  <?php endif; ?>
                  step="1"
                  value="<?php echo esc_attr($input_value); ?>"
                  class="w-10 text-center bg-transparent font-bold text-lg focus:outline-none"
                  readonly />
                <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors text-slate-900" data-quantity-action="increase" aria-label="<?php echo esc_attr__('Zwieksz ilosc', 'mypage'); ?>">
                  <span class="text-xl font-bold">+</span>
                </button>
              </div>
            </div>
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button flex-1 bg-black text-white rounded-full flex items-center justify-center gap-3 p-3 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-slate-200/50 group">
              <span class="text-base tracking-widest"><?php echo esc_html($product->single_add_to_cart_text()); ?></span>
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- 2. FULL WIDTH DESCRIPTION SECTION -->
    <section class="mt-20 lg:mt-32 w-full animate-enter delay-200">
      <div class="clay-card bg-white rounded-[3rem] p-8 lg:p-16 relative overflow-hidden">
        <div class="relative z-10 max-w-4xl mx-auto">
          <span class="uppercase text-sm font-bold text-slate-400 tracking-widest mb-2 block">
            <?php echo esc_html__('Specyfikacja', 'mypage'); ?>
          </span>
          <h2 class="text-3xl lg:text-4xl font-bold mb-8">
            <?php echo esc_html__('Szczegoly, ktore robia roznice', 'mypage'); ?>
          </h2>

          <div class="prose prose-lg text-slate-600 font-light font-['Inter'] leading-relaxed">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </section>

    <?php do_action('woocommerce_after_single_product'); ?>
  <?php endwhile; ?>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
