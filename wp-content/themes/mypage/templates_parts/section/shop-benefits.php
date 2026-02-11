<?php

/**
 * Shop benefits section.
 */
defined('ABSPATH') || exit;
?>

<section class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-center animate-enter delay-300" id="zalety">
  <div class="flex flex-col gap-8">
    <div class="flex flex-col gap-4">
      <span class="uppercase text-sm font-semibold text-[#e17100] tracking-[0.7px]">
        Standardy jakości
      </span>
      <h2 class="text-4xl lg:text-5xl font-semibold text-[#0f172b] tracking-[-1.2px]">
        Zalety współpracy
      </h2>
      <p class="text-lg text-[#6a7282] mt-2">
        Tworzymy rozwiązania, które nie tylko wyglądają, ale przede wszystkim działają na korzyść Twojego biznesu.
      </p>
    </div>

    <ul class="flex flex-col gap-6 pt-2">
      <li class="flex items-start gap-4">
        <div class="shrink-0 w-12 h-12 rounded-2xl bg-[#0f172b]"></div>
        <div>
          <h4 class="text-xl font-bold text-black mb-1">Superszybkie ładowanie</h4>
          <p class="text-sm leading-relaxed text-[#6a7282]">
            Optymalizacja kodu i grafik sprawia, że strona ładuje się błyskawicznie, co uwielbiają użytkownicy i
            Google.
          </p>
        </div>
      </li>

      <li class="flex items-start gap-4">
        <div class="shrink-0 w-12 h-12 rounded-2xl bg-[#ffb900]"></div>
        <div>
          <h4 class="text-xl font-bold text-black mb-1">Mobile First</h4>
          <p class="text-sm leading-relaxed text-[#6a7282]">
            Perfekcyjny wygląd na każdym urządzeniu. Projektujemy z myślą o smartfonach od samego początku.
          </p>
        </div>
      </li>

      <li class="flex items-start gap-4">
        <div class="shrink-0 w-12 h-12 rounded-2xl bg-[#7f22fe]"></div>
        <div>
          <h4 class="text-xl font-bold text-black mb-1">Bezpieczeństwo i wsparcie</h4>
          <p class="text-sm leading-relaxed text-[#6a7282]">
            Regularne kopie zapasowe, certyfikat SSL i pomoc techniczna w cenie pakietu. Śpisz spokojnie.
          </p>
        </div>
      </li>
    </ul>
  </div>

  <div class="h-[500px] lg:h-[700px] w-full relative">
    <div class="rounded-[48px] overflow-hidden w-full h-full relative bg-white shadow-[10px_20px_30px_0px_rgba(174,174,192,0.15)]">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/shop.webp',); ?>" class="absolute inset-0 w-full h-full object-cover" alt="Zespół przy pracy">
      <div class="absolute inset-0 bg-linear-to-t from-black/50 to-transparent"></div>

      <div class="absolute bottom-8 left-8 right-8 bg-white/95 backdrop-blur-xl p-6 rounded-3xl shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)] border border-white/50">
        <div class="flex items-center justify-between">
          <div class="flex flex-col">
            <span class="text-xs font-bold uppercase text-[#90a1b9] tracking-[0.6px] mb-1">Gwarancja jakości</span>
            <span class="text-xl font-bold text-black">100% Satysfakcji</span>
          </div>
          <div class="w-12 h-12 bg-black rounded-full"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="mt-12 flex flex-col gap-4 text-[#6a7282]">
  <p class="text-base leading-6">Nasze gotowe strony internetowe to rozwiązanie dla osób, które chcą wyglądać profesjonalnie od pierwszego dnia i jednocześnie oszczędzić czas. Każdy projekt jest przemyślany pod kątem użyteczności, czytelnego układu oraz tego, co najważniejsze w sprzedaży i pozyskiwaniu klientów: jasnego przekazu, dobrze poprowadzonych sekcji i skutecznych wezwań do działania.</p>
  <p class="text-base leading-6">Wybierając stronę z tej listy, zyskujesz:</p>
  <ul class="list-disc pl-6 space-y-3 text-base leading-6">
    <li>
      Szybki start – zamiast tygodni czekania możesz działać praktycznie od razu.
    </li>
    <li>
      Spójny, nowoczesny design – układ sekcji dopasowany do realnych potrzeb biznesu.
    </li>
    <li>
      Strukturę przyjazną SEO – logiczne nagłówki, miejsca na opisy usług i lokalizacje.
    </li>
    <li>
      Rozwiązanie na przyszłość – stronę można rozwijać o kolejne podstrony, blog lub ofertę.
    </li>
  </ul>
  <p class="text-base leading-6">Jeśli nie masz pewności, który projekt będzie najlepszy, kieruj się branżą, stylem (minimalistyczny / elegancki / dynamiczny) oraz tym, jak chcesz prezentować ofertę. Dobrze dobrana strona pomoże Ci budować zaufanie, uporządkować komunikację i zwiększyć liczbę zapytań od klientów.</p>
</section>