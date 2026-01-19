<!-- Bento Grid Layout -->
<section class="grid grid-cols-1 min-h-[600px] lg:grid-cols-12 mb-16 gap-x-6 gap-y-6">

  <!-- Left Large Card (Megaphone) -->
  <div class="col-span-1 lg:col-span-5 bg-linear-to-br from-[#A5B4FC] to-[#C7D2FE] rounded-[3rem] relative overflow-hidden clay-card group animate-enter delay-200 h-[400px] lg:h-auto">
    <div class="absolute inset-0 bg-white/10"></div>
    <div class="absolute inset-0 flex items-center justify-center transform group-hover:scale-105 transition-transform duration-700 ease-out">
      <?php
      echo mypage_attachment_image_by_filename('hero-megaphone.webp', 'full', [
        'alt' => '3D Megaphone Abstract',
        'class' => 'filter contrast-125 opacity-90 mix-blend-multiply w-[120%] h-[120%] object-cover brightness-110',
        'loading' => 'eager',
        'fetchpriority' => 'high',
        'decoding' => 'async',
        'sizes' => '(min-width: 1024px) 42vw, 100vw',
      ]);
      ?>
    </div>
    <div class="absolute top-0 left-0 right-0 h-1/2 bg-linear-to-b to-transparent pointer-events-none from-white/20">
    </div>
  </div>

  <!-- Right Column Container -->
  <div class="col-span-1 lg:col-span-7 flex flex-col gap-6">

    <!-- Top Right Wide Card (Blue Abstract) -->
    <div class="flex-1 overflow-hidden clay-card animate-enter delay-300 min-h-[300px] bg-[#BFDBFE] rounded-[3rem] relative">
      <div class="bg-linear-to-r opacity-80 absolute top-0 right-0 bottom-0 left-0 from-blue-300 via-indigo-300 to-purple-300">
      </div>
      <div class="filter mix-blend-overlay w-32 h-32 rounded-full absolute top-1/2 left-1/3 blur-2xl bg-white/40">
      </div>
      <?php
      echo mypage_attachment_image_by_filename('hero-icon.webp', 'full', [
        'alt' => '3D Icon',
        'class' => 'filter contrast-125 transform hover:scale-105 transition-transform duration-700 ease-out opacity-90 mix-blend-multiply w-full h-full object-cover absolute top-0 right-0 bottom-0 left-0 brightness-110',
        'loading' => 'eager',
        'decoding' => 'async',
        'sizes' => '(min-width: 1024px) 58vw, 100vw',
      ]);
      ?>
    </div>

    <!-- Bottom Row Split -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-enter delay-500 min-h-[280px] gap-x-6 gap-y-6">

      <!-- Yellow CTA Card -->
      <div class="flex flex-col clay-card overflow-hidden min-h-[280px] bg-amber-400 rounded-[3rem] pt-8 pr-8 pb-8 pl-8 relative justify-evenly">
        <div class="relative z-10">
          <h3 class="leading-tight text-2xl font-semibold text-[#000000] font-['Syne'] mb-1">Twój bezpłatny audyt
          </h3>
        </div>

        <a href="#contact" class="self-start z-10 flex group cursor-pointer overflow-hidden max-w-none rounded-full mt-4 pt-4 pr-6 pb-4 pl-6 relative items-center justify-center gap-4 text-white bg-black">
          <span class="uppercase text-sm font-medium tracking-widest">Skontatkuj się</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-lucide="arrow-right" class="lucide lucide-arrow-right w-4 h-4 transform group-hover:translate-x-1 transition-transform">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
          </svg>
        </a>
        <div class="-bottom-10 -right-10 w-32 h-32 rounded-full absolute blur-2xl bg-yellow-300"></div>
      </div>

      <!-- Purple Waves Card -->
      <div class="overflow-hidden clay-card min-h-[280px] bg-[#6366f1] rounded-[3rem] relative">
        <?php
        echo mypage_attachment_image_by_filename('bento-purple.webp', 'full', [
          'alt' => 'Purple texture',
          'class' => 'absolute inset-0 w-full h-full object-cover mix-blend-hard-light filter brightness-75 contrast-125',
          'loading' => 'lazy',
          'decoding' => 'async',
          'sizes' => '(min-width: 1024px) 29vw, (min-width: 768px) 50vw, 100vw',
        ]);
        ?>
        <div class="bg-linear-to-t to-transparent from-indigo-900/50 absolute top-0 right-0 bottom-0 left-0">
        </div>
        <div class="flex absolute bottom-12 right-12 items-center justify-center">
          <div class="relative group cursor-pointer">
            <div class="absolute inset-0 bg-white/20 rounded-full blur-xl transform group-hover:scale-110 transition-transform duration-500">
            </div>
            <?php
            echo mypage_attachment_image_by_filename('profile-320.webp', 'full', [
              'alt' => 'Profile photo',
              'class' => 'transform group-hover:scale-105 transition-transform duration-300 z-10 w-40 h-32 object-cover border-white/30 border-4 rounded-3xl relative shadow-2xl',
              'loading' => 'lazy',
              'decoding' => 'async',
              'sizes' => '160px',
            ]);
            ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>