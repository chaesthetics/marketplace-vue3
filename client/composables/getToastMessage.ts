import colors from "#ui-colors";

const getToastMessage = () => {
  const toast = useToast();

  return {
    displayToast: (
      titleKey: string,
      color: "gray" | (typeof colors)[number] = "primary",
      extraMsg = "",
    ) =>
      toast.add({
        title: `${titleKey} ${extraMsg}`,
        color,
      }),
  };
};

export default getToastMessage;
