type Actions =
  | "viewAny"
  | "view"
  | "create"
  | "update"
  | "delete";
//   | "restore"
//   | "forceDelete";

type Subjects =
  | "Post"
  | "User"
  | "Category"
  | "Permission"
  | "Role"
  | "PhraseSet"
  | "Dashboard";

export default defineNuxtRouteMiddleware(async (to) => {
  const { getUser } = useAuthStore();
  const user = getUser;

  if (!user?.email) {
    return navigateTo("/login", { replace: true });
  }
  const permissions =
    (to.meta.permissions as { action: Actions; subject: Subjects }[]) || [];
  const hasPermission = permissions.every(({ action, subject }) =>
    canPerform(action, subject),
  );

  if (!hasPermission) {
    return navigateTo("/forbidden", { replace: true });
  }
});
