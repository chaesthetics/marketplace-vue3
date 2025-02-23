export default defineNuxtConfig({
  modules: [
    '@nuxt/ui',
    '@pinia/nuxt', 
    '@pinia-plugin-persistedstate/nuxt'
  ],
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  ssr: false,
})
