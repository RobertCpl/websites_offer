  <!-- Footer -->
  <footer class="border-t border-slate-200 mt-12 bg-[#F3F0FF]">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
      <!-- Left: Logo & Brand -->
      <?php
      get_template_part('templates_parts/components/brand-mark', null, [
        'wrapper_class' => 'flex items-center gap-3',
        'badge_class' => "flex text-lg font-bold text-white font-['Syne'] bg-black w-14 h-14 rounded-full items-center justify-center",
        'text_class' => "uppercase text-lg font-bold tracking-tight font-['Syne']",
      ]);
      ?>

      <!-- Right: Copyright -->
      <div class="text-sm font-medium text-slate-500 font-['Inter'] text-center md:text-right">
        © 2026 madeapp. Wszelkie prawa zastrzeżone.
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
  </body>

  </html>
