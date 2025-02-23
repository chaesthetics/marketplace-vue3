import { defineStore, createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

export const useAuthStore = defineStore("auth",{
    persist: {
        storage: localStorage,
    },

    state: () => ({
        user: {
            email: "Auriel James Fernandezz",
            password: "passwordpassword",
        }
    }),

    getters: {
        getUser: (state) => state.user,
    },

    actions: {
    }
})