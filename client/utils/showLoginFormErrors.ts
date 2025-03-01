import { AxiosError } from "axios";
import httpCodes from "./httpCodes";  

interface LoginFormError {
  path: string;
  message: string;
}

const showLoginFormErrors = (error: Error, form: Ref): void => {
  const axiosError = error as AxiosError;
  const status = axiosError.response?.status;

  if (status !== undefined && httpCodes.has(status)) {
    const errorMessage =
      // @ts-expect-error should have .message
      axiosError.response?.data?.message || errorMap.get(status)!;
    const errors: LoginFormError[] = [
      { path: "password", message: errorMessage },
    ];
    form.value.setErrors(errors);
  }
};

export default showLoginFormErrors;
