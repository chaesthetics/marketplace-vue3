export default defineNuxtRouteMiddleware(async (to) => {
  const { getUser } = useAuthStore();
  const user = getUser;

  if (user?.email) {
    return navigateTo("/", { replace: true });
  }
});
