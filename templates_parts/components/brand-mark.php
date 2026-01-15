<?php
$wrapper_class = $args['wrapper_class'] ?? 'flex gap-3 items-center';
$badge_class = $args['badge_class'] ?? "flex text-xl font-bold text-white font-['Syne'] bg-black w-16 h-16 rounded-full items-center justify-center";
$text_class = $args['text_class'] ?? "uppercase text-xl font-bold tracking-tight font-['Syne']";
$label = $args['label'] ?? 'madeapp';
$badge_text = $args['badge_text'] ?? 'mda';
?>
<div class="<?php echo esc_attr($wrapper_class); ?>">
  <div class="<?php echo esc_attr($badge_class); ?>"><?php echo esc_html($badge_text); ?></div>
  <span class="<?php echo esc_attr($text_class); ?>"><?php echo esc_html($label); ?></span>
</div>