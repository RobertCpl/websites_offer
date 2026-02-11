<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MADEAPP | Strony bez kompromisów</title>
  <!-- Google tag (gtag.js) -->
  <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-LEL8JE83GM"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-LEL8JE83GM');
  </script> -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Syne:wght@500;600;700;800&amp;display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Syne:wght@500;600;700;800&amp;display=swap" rel="stylesheet">
  </noscript>
  <?php wp_head(); ?>
</head>


<body <?php body_class('antialiased overflow-x-hidden selection:bg-amber-300 selection:text-amber-900 text-gray-500 bg-[#F3F0FF]'); ?>>
  <?php wp_body_open(); ?>

  <!-- Navigation -->
  <nav class="lg:px-12 flex animate-enter w-full max-w-400 mr-auto ml-auto pt-8 pr-6 pb-8 pl-6 relative items-center justify-between z-50">
    <?php
    $shop_url = function_exists('wc_get_page_permalink')
      ? call_user_func('wc_get_page_permalink', 'shop')
      : get_post_type_archive_link('product');

    get_template_part('templates_parts/components/brand-mark', null, [
      'wrapper_class' => 'flex gap-3 items-center z-50',
      'badge_class' => "flex text-xl font-bold text-white font-['Syne'] bg-black w-16 h-16 rounded-full items-center justify-center",
      'text_class' => "uppercase text-xl font-bold tracking-tight font-['Syne']",
    ]);
    ?>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex gap-8 text-[15px] font-medium gap-x-8 gap-y-8 items-center text-slate-600">
      <a href="<?php echo esc_url(home_url('/#cennik')); ?>" class="transition-colors hover:text-black">OFERTA</a>
      <a href="<?php echo esc_url(home_url('/#co-robie')); ?>" class="transition-colors hover:text-black">CO ROBIE</a>
      <a href="<?php echo esc_url(home_url('/#technologie')); ?>" class="transition-colors hover:text-black">TECHNOLOGIE</a>
      <a href="<?php echo esc_url($shop_url); ?>" class="transition-colors hover:text-black">SKLEP</a>
    </div>

    <!-- Right Side Actions (Button + Hamburger) -->
    <div class="flex items-center gap-4 z-50">
      <!-- Changed button to anchor for smooth scroll -->
      <a href="#contact" class="hidden lg:flex hover:scale-105 transition-transform text-sm font-semibold text-white tracking-wide bg-black rounded-full pt-3 pr-6 pb-3 pl-6 gap-x-1.5 gap-y-1.5 items-center">Kontakt</a>

      <?php if (function_exists('WC')) : ?>
        <!-- `.woocommerce` ensures WooCommerce mini-cart selectors apply on non-shop pages. -->
        <div class="relative woocommerce" data-mini-cart-root>
          <button type="button" class="relative inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-white/60 transition-colors" aria-label="<?php echo esc_attr__('Koszyk', 'mypage'); ?>" aria-haspopup="dialog" aria-expanded="false" data-mini-cart-toggle>
            <span class="sr-only"><?php echo esc_html__('Otwórz koszyk', 'mypage'); ?></span>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/cart.svg',); ?>" alt="cart" class="w-5" loading="lazy" />
            <?php
            if (function_exists('mypage_cart_count_html')) {
              echo mypage_cart_count_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            ?>
          </button>

          <div class="hidden absolute -right-14 md:right-0 mt-3 w-xs md:w-96 max-w-[90vw] bg-white border border-slate-200 rounded-2xl shadow-xl p-4 z-50" data-mini-cart-dropdown>
            <div class="flex items-center justify-between mb-3">
              <span class="text-sm font-semibold"><?php echo esc_html__('Koszyk', 'mypage'); ?></span>
            </div>

            <?php
            if (function_exists('mypage_mini_cart_html')) {
              echo mypage_mini_cart_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- Hamburger Icon -->
      <button class="lg:hidden flex flex-col focus:outline-none w-10 h-10 gap-1.5 items-center justify-center relative z-50" aria-label="Toggle menu" id="hamburger-btn">
        <span class="block h-0.5 w-6 rounded-full bg-black transition-all duration-300 origin-center"></span>
        <span class="block h-0.5 w-6 rounded-full bg-black transition-all duration-300 origin-center"></span>
        <span class="block h-0.5 w-6 rounded-full bg-black transition-all duration-300 origin-center"></span>
      </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div class="flex flex-col overflow-hidden transition-all duration-500 ease-in-out lg:hidden bg-[#F3F0FF] border-slate-200 border-b absolute top-full left-0 w-full shadow-xl gap-x-6 gap-y-6 items-center menu-closed z-40" id="mobile-menu">
      <div class="flex flex-col w-full pt-8 pb-8 gap-x-6 gap-y-6 items-center">
        <a href="<?php echo esc_url(home_url('/#cennik')); ?>" class="mobile-link transition-colors hover:text-black default text-lg font-medium text-center w-full pt-2 pb-2">OFERTA</a>
        <a href="<?php echo esc_url(home_url('/#co-robie')); ?>" class="mobile-link transition-colors hover:text-black default text-lg font-medium text-center w-full pt-2 pb-2">CO ROBIE</a>
        <a href="<?php echo esc_url(home_url('/#technologie')); ?>" class="mobile-link text-lg font-medium transition-colors w-full text-center py-2 hover:text-black default">TECHNOLOGIE</a>
        <a href="<?php echo esc_url($shop_url); ?>" class="mobile-link text-lg font-medium transition-colors w-full text-center py-2 hover:text-black">SKLEP</a>
        <a href="#contact" class="mobile-link text-lg font-medium transition-colors w-full text-center py-2 hover:text-black default">KONTAKT</a>
      </div>
    </div>
  </nav>