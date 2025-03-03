export default defineNuxtConfig({
  modules: [
    '@nuxt/ui',
    '@pinia/nuxt', 
    '@pinia-plugin-persistedstate/nuxt'
  ],

  plugins: [
    '~/plugins/vanta.js', 
  ],

  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_MARKETPLACE_API_BASE,
    },
  },

  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  ssr: false,
})
