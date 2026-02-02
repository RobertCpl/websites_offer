  <!-- Contact Section -->
  <section class="animate-enter delay-500 pt-16 relative" id="contact">
    <!-- Distinct Background for this section -->
    <!-- <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 via-white to-amber-50/50 -z-10"></div> -->

    <div class="overflow-hidden lg:p-16 bg-amber-400 border-white/60 border rounded-[3rem] pt-4 pr-4 pb-4 pl-4 relative shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] backdrop-blur-2xl">

      <!-- Decorative blob -->
      <!-- <div
          class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-gradient-to-br from-indigo-100/50 to-purple-100/50 rounded-full blur-3xl opacity-60 pointer-events-none">
      </div> -->

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 z-10 relative gap-x-12 gap-y-12 items-start">

        <!-- Left Column: Content -->
        <div class="flex flex-col gap-8 pt-4">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 w-fit">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            <span class="uppercase text-xs font-bold text-indigo-900 tracking-wider">Bezpłatna konsultacja</span>
          </div>

          <div class="">
            <h2 class="lg:text-5xl text-4xl font-semibold text-slate-900 tracking-tight font-['Syne'] mb-6">
              Porozmawiajmy o Twoim projekcie
            </h2>
            <p class="leading-relaxed text-lg text-gray-600 tracking-normal font-['Inter'] mb-6">
              Masz pomysł, ale nie wiesz jak go wdrożyć? A może potrzebujesz wyceny? Napisz do mnie. Pomogę Ci
              ułożyć plan działania i dobiorę technologię idealną dla Twojego biznesu.
            </p>
          </div>

          <ul class="flex flex-col gap-4 gap-x-4 gap-y-4">
            <li class="flex gap-3 font-medium text-gray-600 gap-x-3 gap-y-3 items-center">
              <div class="shrink-0 flex bg-[#ffffff] w-6 h-6 rounded-full items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-purple-800 w-[14px] h-[14px]" data-icon-replaced="true" style="width: 14px; height: 14px">
                  <polyline points="20 6 9 17 4 12" class=""></polyline>
                </svg>
              </div>
              Szybka odpowiedź (zazwyczaj do 4h)
            </li>
            <li class="flex gap-3 font-medium text-gray-600 gap-x-3 gap-y-3 items-center">
              <div class="shrink-0 flex text-green-600 bg-[#ffffff] w-6 h-6 rounded-full items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-purple-800 w-[14px] h-[14px]" data-icon-replaced="true" style="width: 14px; height: 14px">
                  <polyline points="20 6 9 17 4 12" class=""></polyline>
                </svg>
              </div>
              Konkrety bez lania wody
            </li>
            <li class="flex font-medium text-gray-600 gap-x-3 gap-y-3 items-center">
              <div class="shrink-0 flex bg-[#ffffff] w-6 h-6 rounded-full items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-[14px] h-[14px] text-purple-800" data-icon-replaced="true" style="width: 14px; height: 14px;">
                  <polyline points="20 6 9 17 4 12" class=""></polyline>
                </svg>
              </div>
              Bezpłatna wycena i plan działania
            </li>
          </ul>

          <div class="mt-4 p-6 bg-slate-50 rounded-3xl border border-slate-100 flex gap-4 items-center">
            <?php
            echo mypage_attachment_image_by_filename('avatar-320.webp', 'full', [
              'alt' => 'Avatar',
              'class' => 'w-12 h-12 object-cover border-white border-2 rounded-full shadow-sm',
              'loading' => 'lazy',
              'decoding' => 'async',
              'sizes' => '48px',
            ]);
            ?>
            <div class="">
              <p class="text-sm font-bold text-slate-900">Masz pytania?</p>
              <a href="mailto:kontakt@madeapp.pl" class="text-sm text-indigo-600 font-medium hover:underline">kontakt@madeapp.pl</a>
            </div>
          </div>
        </div>

        <!-- Right Column: Form -->
        <?php $contact_nonce = wp_create_nonce('contact_form_submit'); ?>
        <form id="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" class="flex flex-col gap-6 lg:bg-transparent lg:p-0 lg:shadow-none lg:border-none bg-white border-slate-100 border rounded-[2.5rem] pt-4 pr-2 pb-2 pl-2 shadow-sm gap-x-6 gap-y-6">
          <input type="hidden" name="action" value="contact_form_submit">
          <input type="hidden" name="nonce" value="<?php echo esc_attr($contact_nonce); ?>">
          <div class="hidden">
            <label for="contact-website">Strona (zostaw puste)</label>
            <input type="text" id="contact-website" name="website" autocomplete="off" tabindex="-1">
          </div>

          <!-- Email -->
          <div class="flex flex-col gap-x-2 gap-y-2">
            <label for="email" class="text-sm font-semibold text-slate-900 ml-1">Adres email</label>
            <input type="email" name="email" required="" autocomplete="email" placeholder="np. jan@firma.pl" class="placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all duration-300 text-slate-900 bg-slate-50 w-full border-slate-200 border rounded-2xl pt-4 pr-6 pb-4 pl-6" id="email">
          </div>

          <!-- Name -->
          <div class="flex flex-col gap-2">
            <label for="name" class="text-sm font-semibold text-slate-900 ml-1">Imię</label>
            <input type="text" id="name" name="name" required="" autocomplete="name" placeholder="Jak mam się do Ciebie zwracać?" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all duration-300">
          </div>

          <!-- Message -->
          <div class="flex flex-col gap-2">
            <label for="message" class="text-sm font-semibold text-slate-900 ml-1">Wiadomość</label>
            <textarea name="message" required="" rows="5" placeholder="Opisz krótko, czego potrzebujesz..." class="placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all duration-300 resize-none text-slate-900 bg-slate-50 w-full border-slate-200 border rounded-2xl pt-4 pr-6 pb-4 pl-6" id="message"></textarea>
          </div>

          <!-- Submit -->
          <div class="flex flex-col gap-3 mt-2">
            <div id="contact-form-status" class="text-lg font-medium text-gray-700 hidden" role="status" aria-live="polite"></div>
            <button type="submit" class="group relative flex items-center justify-center w-full bg-black text-white text-base font-semibold py-4 px-8 rounded-full overflow-hidden transition-transform active:scale-95 hover:shadow-lg hover:shadow-indigo-500/20">
              <span class="relative z-10 flex items-center gap-2">
                Wyślij wiadomość
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1">
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
              </span>
              <div class="absolute inset-0 bg-slate-800 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
            </button>
            <p class="text-xs font-medium text-gray-600 text-center">
              Odpowiadam zwykle w ciągu 24h
            </p>
          </div>

        </form>
      </div>
    </div>
  </section>
