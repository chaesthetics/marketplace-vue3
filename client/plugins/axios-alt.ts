import axios from "axios";

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig();
  const route = useRoute();
  const auth = useAuthStore();
  const cookieHeader = useCookie("XSRF-TOKEN");

  let headers = {
    Accept: "application/json",
    "Content-Type": "application/json",
    "X-XSRF-TOKEN": cookieHeader.value ? (cookieHeader.value as string) : "",
    Authorization: `Bearer ${auth.getToken}`,
  };

  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["cookie", "referer"]),
    };
  }

  const api = axios.create({
    baseURL: config.public.apiBase,
    withCredentials: true,
    headers,
  });

  api.interceptors.request.use(
    (config) => {
      try {
        const token = auth.getToken;
        if (token) {
          config.headers["Authorization"] = `Bearer ${token}`;
        }
      } catch (error) {
        console.log(error);
      }
      return config;
    },
    (error) => {
      return Promise.reject(error);
    },
  );

  api.interceptors.response.use(
    (response) => {
      return response;
    },
    (error) => {
      if (error?.response?.status === 401) {
        auth.clearAuth();
        auth.storeAttemptedURL(route.fullPath);

        navigateTo("/login");
      }

      return Promise.reject(error);
    },
  );

  return {
    provide: {
      api,
      axios,
    },
  };
});
