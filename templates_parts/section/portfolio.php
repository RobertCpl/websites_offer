  <!-- NEW PORTFOLIO SECTION -->
  <section class="animate-enter delay-500 lg:pt-32 pt-16 relative">
    <!-- Header -->
    <div class="flex flex-col mb-16 gap-x-y-5 gap-y-5">
      <span class="uppercase text-base font-semibold text-[#000000] tracking-tighter font-['Inter']">Portfolio</span>
      <h2 class="lg:text-5xl text-4xl font-semibold text-[#000000] tracking-tight font-['Syne']">Wybrane realizacje
      </h2>
      <p class="leading-relaxed text-lg font-medium text-gray-500 max-w-2xl">Projekty, które łączą nowoczesną estetykę
        z wynikami biznesowymi. Zobacz, jak pomagam markom rosnąć w sieci.</p>
    </div>

    <!-- Asymmetric Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Row 1: 1/3 + 2/3 -->

      <!-- Card 1 (Small) -->
      <article class="group md:col-span-1 overflow-hidden min-h-[400px] clay-card cursor-pointer rounded-[2.5rem] relative">
        <!-- Background Image -->
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/portfolio-lex.jpg'); ?>" alt="Kancelaria Prawna Website" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

        <!-- Gradient Overlay for Readability -->
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/40 to-transparent"></div>

        <!-- Content -->
        <div class="flex flex-col pt-8 pr-8 pb-8 pl-8 absolute top-0 right-0 bottom-0 left-0 justify-end">
          <div class="transform transition-transform duration-500 translate-y-2 group-hover:translate-y-0">
            <div class="flex flex-wrap gap-2 mb-4 gap-x-2 gap-y-2">
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full pt-1 pr-3 pb-1 pl-3 backdrop-blur-md">WordPress</span>
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full px-3 py-1 backdrop-blur-md">SEO</span>
            </div>
            <h3 class="text-2xl font-bold text-white font-['Syne'] mb-2">Kancelaria Prawna "Lex"</h3>
            <p class="leading-relaxed group-hover:opacity-100 transition-opacity duration-500 delay-100 text-sm text-gray-300 opacity-0">
              Minimalistyczna wizytówka, oraz blog</p>
          </div>
        </div>
      </article>

      <!-- Card 2 (Large) -->
      <article class="group md:col-span-2 overflow-hidden min-h-[400px] clay-card cursor-pointer rounded-[2.5rem] relative">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/portfolio-furniture.jpg'); ?>" alt="Furniture E-commerce" class="transition-transform duration-700 group-hover:scale-105 w-full h-full object-cover absolute top-0 right-0 bottom-0 left-0">
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/30 to-transparent"></div>

        <div class="flex flex-col pt-8 pr-8 pb-8 pl-8 absolute top-0 right-0 bottom-0 left-0 justify-end">
          <div class="transform transition-transform duration-500 translate-y-2 group-hover:translate-y-0">
            <div class="flex flex-wrap gap-2 mb-4 items-center">
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full px-3 py-1 backdrop-blur-md">Next.js</span>
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full pt-1 pr-3 pb-1 pl-3 backdrop-blur-md">Strapi</span>
              <!-- Metric Chip -->
              <span class="ml-2 px-3 py-1 rounded-lg bg-amber-400 text-black text-[11px] font-bold shadow-lg flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up">
                  <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                  <polyline points="16 7 22 7 22 13"></polyline>
                </svg>
                +150% Sprzedaży
              </span>
            </div>
            <h3 class="text-3xl font-bold text-white font-['Syne'] mb-2">Nowoczesny sklep meblowy</h3>
            <p class="leading-relaxed group-hover:opacity-100 transition-opacity duration-500 delay-100 text-base text-gray-200 opacity-0 max-w-2xl">
              Kompletny sklep internetowy z meblami premium. Bardzo szybkie ładowanie produktów i intuicyjny proces
              zakupowy.
            </p>
          </div>
        </div>
      </article>

      <!-- Row 2: 2/3 + 1/3 -->

      <!-- Card 3 (Large) -->
      <article class="group relative md:col-span-2 rounded-[2.5rem] overflow-hidden min-h-[400px] clay-card cursor-pointer">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/portfolio-saas.jpg'); ?>" alt="SaaS Dashboard" class="transition-transform duration-700 group-hover:scale-105 w-full h-full object-cover absolute top-0 right-0 bottom-0 left-0">
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/30 to-transparent"></div>

        <div class="flex flex-col pt-8 pr-8 pb-8 pl-8 absolute top-0 right-0 bottom-0 left-0 justify-end">
          <div class="transform transition-transform duration-500 translate-y-2 group-hover:translate-y-0">
            <div class="flex flex-wrap gap-2 mb-4 gap-x-2 gap-y-2 items-center">
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-white border-white/20 border rounded-full px-3 py-1 backdrop-blur-md">React</span>
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-white border-white/20 border rounded-full pt-1 pr-3 pb-1 pl-3 backdrop-blur-md">Tailwind</span>
              <!-- Metric Chip -->
              <span class="ml-2 px-3 py-1 rounded-lg bg-emerald-400 text-black text-[11px] font-bold shadow-lg flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap">
                  <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                99/100 Speed
              </span>
            </div>
            <h3 class="text-3xl font-bold text-white font-['Syne'] mb-2">Gabinet stylizacji paznokci</h3>
            <p class="leading-relaxed group-hover:opacity-100 transition-opacity duration-500 delay-100 text-base text-gray-200 opacity-0 max-w-2xl">
              Strona wizytówka, w pastelowych kolorach. Zacheca do umowienia wizyty</p>
          </div>
        </div>
      </article>

      <!-- Card 4 (Small) -->
      <article class="group relative md:col-span-1 rounded-[2.5rem] overflow-hidden min-h-[400px] clay-card cursor-pointer">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/portfolio-barber.jpg'); ?>" alt="Event Landing Page" class="transition-transform duration-700 group-hover:scale-105 w-full h-full object-cover absolute top-0 right-0 bottom-0 left-0">
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/40 to-transparent"></div>

        <div class="flex flex-col pt-8 pr-8 pb-8 pl-8 absolute top-0 right-0 bottom-0 left-0 justify-end">
          <div class="transform transition-transform duration-500 translate-y-2 group-hover:translate-y-0">
            <div class="flex flex-wrap gap-2 mb-4 gap-x-2 gap-y-2">
              <span class="text-[11px] uppercase font-bold text-[#000000] tracking-wide bg-[#ffffff] border-white/20 border rounded-full px-3 py-1 backdrop-blur-md">HTML/JS</span>
            </div>
            <h3 class="text-2xl font-bold text-white font-['Syne'] mb-2">Barber strona wizytówka</h3>
            <p class="leading-relaxed group-hover:opacity-100 transition-opacity duration-500 delay-100 text-sm text-slate-300 opacity-0">
            </p>
          </div>
        </div>
      </article>

    </div>
  </section>