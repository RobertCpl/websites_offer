<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MADEAPP | Strony bez kompromisów</title>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-LEL8JE83GM"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-LEL8JE83GM');
  </script>
  <script src="https://unpkg.com/lucide@latest" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Syne:wght@500;600;700;800&amp;display=swap" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Syne:wght@500;600;700;800&amp;display=swap" rel="stylesheet">
  </noscript>
  <?php wp_head(); ?>
</head>


<body <?php body_class('antialiased overflow-x-hidden selection:bg-amber-300 selection:text-amber-900 text-slate-900 bg-[#F3F0FF]'); ?>>
  <?php wp_body_open(); ?>

  <!-- Navigation -->
  <nav class="lg:px-12 flex animate-enter w-full max-w-[1600px] mr-auto ml-auto pt-8 pr-6 pb-8 pl-6 relative items-center justify-between z-50">
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
        <a href="<?php echo esc_url($shop_url); ?>" class="mobile-link text-lg font-medium transition-colors w-full text-center py-2 hover:text-black text-black">SKLEP</a>
        <a href="#contact" class="mobile-link text-lg font-medium transition-colors w-full text-center py-2 hover:text-black default">KONTAKT</a>
      </div>
    </div>
  </nav>