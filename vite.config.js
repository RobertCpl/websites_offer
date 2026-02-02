import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import { fileURLToPath } from "url";

const fromConfig = (p) => fileURLToPath(new URL(p, import.meta.url));

export default defineConfig({
  plugins: [tailwindcss()],
  server: {
    host: true, // nasłuchuj na wszystkich interfejsach
    port: 5173,
    strictPort: true,
    cors: true,
    // ważne gdy strona WP jest na innym porcie (u Ciebie 8080)
    origin: "http://localhost:5173",
    hmr: {
      protocol: "ws",
      host: "localhost",
      clientPort: 5173,
    },
  },
  build: {
    outDir: fromConfig("./dist"),
    emptyOutDir: true,
    // Put the manifest in dist/manifest.json (WordPress integration expects it there).
    // Vite defaults to dist/.vite/manifest.json when manifest: true.
    manifest: "manifest.json",
    rollupOptions: {
      input: {
        main: fromConfig("./wp-content/themes/mypage/assets/js/main.js"),
        styles: fromConfig("./wp-content/themes/mypage/assets/css/main.css"),
      },
      output: {
        entryFileNames: "assets/[name].[hash].js",
        chunkFileNames: "assets/[name].[hash].js",
        assetFileNames: "assets/[name].[hash][extname]",
      },
    },
  },
  // base: "/wp-content/themes/custom_theme/dist/"
});
