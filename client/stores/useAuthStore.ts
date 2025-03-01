import { defineStore, createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import type { 
    UserProfile,
    RegisterCredentials,
    LoginCredentials,
    RegisterResponse,
    LoginResponse,
    CurrentUserResponse,
 } from "../.types/auth";
 import type { ErrorResponse } from "~/.types/general";
 import { ResponseError } from "~/errors/response-error";
 import { useApi } from "~/helpers/api";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

export const useAuthStore = defineStore("auth",{
    persist: {
        storage: localStorage,
    },

    state: () => ({
        user: null as UserProfile | null,
        token: null as string | null,
        permissions: [""],
        attemptedURL: null as string | null,
        buildVersion: null as string | null,
        appShouldReload: false,
    }),

    getters: {
        getUser: (state) => state.user,
        getToken: (state) => state.token,
        getPermissions: (state) => state.permissions,
        getAttemptedURL: (state) => state.attemptedURL,
        getBuildVersion: (state) => state.buildVersion,
        getAppShouldReload: (state) => state.appShouldReload,
    },

    actions: {
        async fetchCurrentUser() {
          try {
            if (this.getToken !== null) {
              const { getData } = useApi();
    
              const response = await getData<CurrentUserResponse | ErrorResponse>(
                `/api/auth/profile`,
              );
    
              const { user, permissions } = response as CurrentUserResponse;
    
              this.user = user;
              this.permissions = permissions;
            }
          } catch (error) {
            if (error instanceof ResponseError) {
              throw new ResponseError(error.message, error.status);
            } else {
              throw new Error(error?.toString());
            }
          }
        },

        async register(credentials: RegisterCredentials) {
          try{
            const { postData } = useApi();
            const response = await postData<RegisterResponse | ErrorResponse>(
              `/api/auth/register`,
              credentials,
            );
          } catch(error){
            if (error instanceof ResponseError){
              throw new ResponseError(error.message, error.status);
            } else {
              throw new Error(error?.toString());
            }
          }
        },
    
        async login(credentials: LoginCredentials) {
          try {
            const { getData, postData } = useApi();
    
            await getData("/sanctum/csrf-cookie");
    
            const response = await postData<LoginResponse | ErrorResponse>(
              `/api/auth/login`,
              credentials,
            );
    
            const { user, permissions, token } = response as LoginResponse;
    
            this.user = user;
            this.permissions = permissions;
            await this.storeToken(token);
          } catch (error) {
            if (error instanceof ResponseError) {
              throw new ResponseError(error.message, error.status);
            } else {
              throw new Error(error?.toString());
            }
          }
        },
    
        async logout() {
          this.user = null;
          this.token = null;
          this.permissions = [];
          this.attemptedURL = null;
    
          navigateTo("/login");
        },
    
        async clearAuth() {
          this.user = null;
          this.token = null;
          this.permissions = [];
        },
    
        async storeAttemptedURL(url: string | null) {
          let finalUrl = url;
          if (finalUrl === null) {
            finalUrl = this.attemptedURL;
          } else {
            finalUrl = finalUrl === "/login" ? this.attemptedURL : finalUrl;
          }
          this.attemptedURL = finalUrl;
        },
    
        async storeToken(token: string) {
          this.token = token;
        },
    
        async storeBuildVersion() {
          const res = await fetch("/build-number.txt");
          const v = await res.text();
          this.buildVersion = v;
        },
    
        updateBuildReloadFlag(build: string) {
          this.appShouldReload = this.buildVersion !== build;
        },
      },
})