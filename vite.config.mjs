import { defineConfig } from "vite";
import { resolve } from "node:path";

export default defineConfig({
  base: "/my-project/assets/build/",

  build: {
    outDir: "assets/build",
    emptyOutDir: true,
    manifest: "manifest.json",

    rollupOptions: {
      input: {
        main: resolve(process.cwd(), "assets/js/main.js"),
      },
    },
  },

  server: {
    host: "localhost",
    port: 5173,
    strictPort: true,
  },
});