import { createMongoAbility, AbilityBuilder, PureAbility } from "@casl/ability";

export function useDefineAbility() {
  const auth = useAuthStore();
  const abilities = auth.getPermissions;
  const { can, build } = new AbilityBuilder(createMongoAbility);

  abilities.forEach((value) => {
    const splittedAbility = value.split(" ");
    can(splittedAbility[0]?.trim(), splittedAbility[1]?.trim());
  });
  return build();
}

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

export type AppAbility = PureAbility<[Actions, Subjects]>;

const defineAbilityFor = (): AppAbility => {
  const { can, build } = new AbilityBuilder<PureAbility<[Actions, Subjects]>>(
    PureAbility,
  );
  const auth = useAuthStore();
  const permissions = auth.getPermissions;

  permissions.forEach((permission) => {
    const [action, subject] = permission.split(" ") as [Actions, Subjects];
    can(action, subject);
  });

  return build();
};
export const canPerform = (action: Actions, subject: Subjects): boolean => {
  const ability = defineAbilityFor();
  return ability.can(action, subject);
};
