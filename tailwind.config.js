/** @type {import('tailwindcss').Config} */
export default {
  // Tailwind v4 (CSS-first):
  // - sources/content are configured in `assets/css/main.css` via `@source`
  // - keep this file only for optional theme extensions
  // Use class-based dark mode so `dark:*` utilities activate when `<html>` has class `dark`.
  darkMode: "class",
  theme: {
    extend: {},
  },
};