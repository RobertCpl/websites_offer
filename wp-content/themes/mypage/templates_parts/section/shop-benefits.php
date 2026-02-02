<?php

/**
 * Shop benefits section.
 */
defined('ABSPATH') || exit;
?>

<section class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-center animate-enter delay-300" id="zalety">
  <div class="flex flex-col gap-8 order-2 lg:order-1">
    <div class="flex flex-col gap-4">
      <span class="uppercase text-sm font-semibold text-amber-600 tracking-wider font-['Inter']">
        Standardy jakości
      </span>
      <h2 class="text-4xl lg:text-5xl font-semibold text-slate-900 font-['Syne'] tracking-tight">
        Zalety współpracy
      </h2>
      <p class="text-lg text-slate-500 mt-2 font-['Inter']">
        Tworzymy rozwiązania, które nie tylko wyglądają, ale przede wszystkim działają na korzyść Twojego biznesu.
      </p>
    </div>

    <ul class="flex flex-col gap-6 mt-4">
      <li class="flex items-start gap-4 p-4 rounded-3xl hover:bg-white hover:shadow-sm transition-all duration-300 border border-transparent hover:border-slate-100">
        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center">
          <iconify-icon icon="solar:rocket-2-linear" width="24" stroke-width="1.5"></iconify-icon>
        </div>
        <div>
          <h4 class="text-xl font-bold text-slate-900 mb-1 font-['Syne']">Superszybkie ładowanie</h4>
          <p class="text-slate-500 text-sm leading-relaxed">
            Optymalizacja kodu i grafik sprawia, że strona ładuje się błyskawicznie, co uwielbiają użytkownicy i
            Google.
          </p>
        </div>
      </li>

      <li class="flex items-start gap-4 p-4 rounded-3xl hover:bg-white hover:shadow-sm transition-all duration-300 border border-transparent hover:border-slate-100">
        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-amber-400 text-slate-900 flex items-center justify-center">
          <iconify-icon icon="solar:smartphone-linear" width="24" stroke-width="1.5"></iconify-icon>
        </div>
        <div>
          <h4 class="text-xl font-bold text-slate-900 mb-1 font-['Syne']">Mobile First</h4>
          <p class="text-slate-500 text-sm leading-relaxed">
            Perfekcyjny wygląd na każdym urządzeniu. Projektujemy z myślą o smartfonach od samego początku.
          </p>
        </div>
      </li>

      <li class="flex items-start gap-4 p-4 rounded-3xl hover:bg-white hover:shadow-sm transition-all duration-300 border border-transparent hover:border-slate-100">
        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-violet-600 text-white flex items-center justify-center">
          <iconify-icon icon="solar:shield-check-linear" width="24" stroke-width="1.5"></iconify-icon>
        </div>
        <div>
          <h4 class="text-xl font-bold text-slate-900 mb-1 font-['Syne']">Bezpieczeństwo i wsparcie</h4>
          <p class="text-slate-500 text-sm leading-relaxed">
            Regularne kopie zapasowe, certyfikat SSL i pomoc techniczna w cenie pakietu. Śpisz spokojnie.
          </p>
        </div>
      </li>
    </ul>
  </div>

  <div class="order-1 lg:order-2 h-[500px] lg:h-[700px] w-full relative">
    <div class="clay-card rounded-[3rem] overflow-hidden w-full h-full relative z-10 bg-white">
      <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&amp;w=2670&amp;auto=format&amp;fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="Zespół przy pracy">
      <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

      <div class="absolute bottom-8 left-8 right-8 bg-white/95 backdrop-blur-xl p-6 rounded-3xl shadow-lg border border-white/50">
        <div class="flex items-center justify-between">
          <div class="flex flex-col">
            <span class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1">Gwarancja jakości</span>
            <span class="text-xl font-bold text-slate-900 font-['Syne']">100% Satysfakcji</span>
          </div>
          <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center text-white">
            <iconify-icon icon="solar:star-fall-linear" width="24"></iconify-icon>
          </div>
        </div>
      </div>
    </div>
    <div class="absolute -top-10 -right-10 w-64 h-64 bg-amber-200 rounded-full blur-3xl opacity-50 -z-10"></div>
    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-violet-200 rounded-full blur-3xl opacity-50 -z-10"></div>
  </div>
</section>
