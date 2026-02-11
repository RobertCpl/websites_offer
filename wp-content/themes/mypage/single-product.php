<?php

/**
 * WooCommerce single product template.
 *
 * Minimal version aligned with this theme layout.
 */
defined('ABSPATH') || exit;

get_template_part('templates_parts/layout/header');
?>

<main class="max-w-[1600px] mx-auto px-3 md:px-8 lg:px-12 pb-16">
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

    <div class="flex flex-col pb-4 md:hidden">
      <div class="flex flex-wrap gap-x-2 gap-y-2 pb-4">
        <?php
        $tag_terms = wp_get_post_terms($product->get_id(), 'product_tag', ['fields' => 'names']);
        $chips = array_values(array_unique(array_filter(
          is_array($tag_terms) ? $tag_terms : []
        )));

        foreach ($chips as $chip) :
        ?>
          <span class="text-[11px] uppercase font-bold text-slate-500 tracking-[0.275px] bg-white border border-slate-200 rounded-full px-[13px] py-[5px]">
            <?php echo esc_html($chip); ?>
          </span>
        <?php endforeach; ?>
      </div>

      <h1 class="text-[36px] leading-[45px] tracking-[-0.9px] font-['Syne'] font-bold text-slate-900 pb-8">
        <?php the_title(); ?>
      </h1>
    </div>

    <!-- 1. PRODUCT HERO SECTION -->
    <section class="flex flex-col gap-6 md:flex-row md:gap-8 lg:gap-8 xl:gap-12 animate-enter delay-100 items-start">
      <!-- Left Column: Images -->
      <div class="flex flex-col gap-6 w-full order-1 md:order-1 md:flex-1">
        <div class="w-full rounded-4xl lg:rounded-[48px] xl:rounded-[48px] overflow-hidden aspect-5/6 relative bg-white group">
          <?php
          if ($image_id) {
            echo wp_get_attachment_image(
              $image_id,
              'large',
              false,
              ['class' => 'w-full !h-full object-cover']
            );
          }
          ?>
        </div>

        <?php if (!empty($thumb_ids)) : ?>
          <div class="flex flex-wrap items-center gap-8 w-full md:gap-8 lg:gap-8 xl:gap-12">
            <?php foreach ($thumb_ids as $index => $thumb_id) : ?>
              <?php
              $is_primary = $index === 0;
              $is_last_with_more = $index === 3 && $remaining_thumbs > 0;
              $thumb_classes = 'w-[152px] lg:w-[124px] aspect-[5/6] rounded-[32px] overflow-hidden border border-slate-200';
              $img_classes = 'w-full !h-full object-cover' . ($is_last_with_more ? ' opacity-70' : '');
              ?>
              <div class="<?php echo esc_attr($thumb_classes); ?>" style="aspect-ratio: 5 / 6;">
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
      <div class="flex flex-col pt-8 order-2 w-full md:order-2 md:flex-1 md:pt-4 lg:pt-4 md:sticky md:top-0">
        <div class="hidden md:flex md:flex-wrap md:gap-x-2 md:gap-y-2 md:pb-6 lg:pb-6">
          <?php
          $tag_terms = wp_get_post_terms($product->get_id(), 'product_tag', ['fields' => 'names']);
          $chips = array_values(array_unique(array_filter(
            is_array($tag_terms) ? $tag_terms : []
          )));

          foreach ($chips as $chip) :
          ?>
            <span class="text-[11px] uppercase font-bold text-slate-500 tracking-[0.275px] bg-white border border-slate-200 rounded-full px-[13px] py-[5px]">
              <?php echo esc_html($chip); ?>
            </span>
          <?php endforeach; ?>
        </div>

        <h1 class="hidden md:block text-[36px] lg:text-[48px] leading-[45px] lg:leading-[45px] tracking-[-0.9px] font-['Syne'] font-bold text-slate-900 pb-8 lg:pb-8">
          <?php the_title(); ?>
        </h1>

        <?php if (!empty($short_description)) : ?>
          <div class="text-[16px] leading-[24px] font-medium text-slate-500 pb-6 lg:pb-6">
            <?php echo wp_kses_post(wpautop($short_description)); ?>
          </div>
        <?php endif; ?>

        <div class="flex flex-col items-start pb-6 lg:pb-6 xl:pb-8 md:items-start md:justify-start">
          <div class="flex items-center justify-center pb-4 md:justify-start">
            <span class="text-[20px] font-medium text-black">
              <?php echo esc_html__('Nasza cena zawiera', 'mypage'); ?>
            </span>
          </div>
          <div class="flex flex-col gap-2 w-full">
            <?php
            $offer_items = [
              [
                'icon' => get_template_directory_uri() . '/assets/icons/product/photos.svg',
                'label' => __('podmianę zdjęć', 'mypage'),
              ],
              [
                'icon' => get_template_directory_uri() . '/assets/icons/product/text.svg',
                'label' => __('podmianę tekstów', 'mypage'),
              ],
              [
                'icon' => get_template_directory_uri() . '/assets/icons/product/seo.svg',
                'label' => __('uzupełnienie meta tagów pod seo', 'mypage'),
              ],
              [
                'icon' => get_template_directory_uri() . '/assets/icons/product/server.svg',
                'label' => __('instalacja na serwerze klienta', 'mypage'),
              ],
            ];

            foreach ($offer_items as $item) :
            ?>
              <div class="flex items-center gap-2 px-7 py-2">
                <img src="<?php echo esc_url($item['icon']); ?>" alt="" class="w-6 h-6" loading="lazy" />
                <span class="text-[16px] leading-[24px] font-medium text-slate-500">
                  <?php echo esc_html($item['label']); ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flex items-end gap-2 pb-6 md:pb-8 lg:pb-8">
          <?php if ($product->is_on_sale() && $product->get_regular_price()) : ?>
            <span class="text-[36px] lg:text-[36px] leading-[40px] lg:leading-[40px] font-bold font-['Syne'] text-slate-900 tracking-[-0.9px]">
              <?php echo wp_kses_post(wc_price((float) $product->get_sale_price())); ?>
            </span>
          <?php else : ?>
            <span class="text-[36px] lg:text-[36px] leading-[40px] lg:leading-[40px] font-bold font-['Syne'] text-slate-900 tracking-[-0.9px]">
              <?php echo wp_kses_post($price_html); ?>
            </span>
          <?php endif; ?>
        </div>

        <?php if ($product->is_on_sale() && $product->get_regular_price()) : ?>
          <div class="text-sm text-slate-400 line-through font-medium pb-6">
            <?php echo wp_kses_post(wc_price((float) $product->get_regular_price())); ?>
          </div>
        <?php endif; ?>

        <form class="cart flex flex-wrap gap-8 xl:gap-12 self-stretch" method="post" enctype="multipart/form-data" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>">
          <div class="flex bg-white border-slate-200 border rounded-full shadow-sm items-center justify-between h-[50px] w-[129px] md:w-[151px] lg:w-[129px] p-[9px]">
            <?php
            $min_qty = $product->get_min_purchase_quantity();
            $max_qty = $product->get_max_purchase_quantity();
            $input_value = $min_qty;
            $max_attr = $max_qty > 0 ? $max_qty : '';
            ?>
            <div class="flex w-full items-center justify-between" data-quantity-selector>
              <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-500" data-quantity-action="decrease" aria-label="<?php echo esc_attr__('Zmniejsz ilosc', 'mypage'); ?>">
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
                class="w-10 text-center bg-transparent font-bold text-[18px] text-slate-500 focus:outline-none"
                readonly />
              <button type="button" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-900" data-quantity-action="increase" aria-label="<?php echo esc_attr__('Zwieksz ilosc', 'mypage'); ?>">
                <span class="text-xl font-bold">+</span>
              </button>
            </div>
          </div>
          <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button w-full xl:w-auto xl:flex-1 bg-black text-white rounded-full flex items-center justify-center px-3 py-3.25 shadow-[0px_20px_25px_-5px_rgba(226,232,240,0.5),0px_8px_10px_-6px_rgba(226,232,240,0.5)]">
            <span class="text-[16px] tracking-[1.6px] font-normal"><?php echo esc_html($product->single_add_to_cart_text()); ?></span>
          </button>
        </form>
       
      </div>
    </section>

    <!-- 2. FULL WIDTH DESCRIPTION SECTION -->
    <section class="mt-16 w-full">
      <div class="bg-white rounded-4xl p-6 overflow-hidden">
        
      </div>
    </section>

    <?php do_action('woocommerce_after_single_product'); ?>
  <?php endwhile; ?>
</main>

<?php
get_template_part('templates_parts/layout/footer');
?>
