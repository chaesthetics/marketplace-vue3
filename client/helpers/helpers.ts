import type { Item } from "~/.types/item";
import { HTTP_ERROR_STATUS_CODES } from "./constants";

export const handleError = (
  statusMessage: string | undefined,
  statusCode: number | undefined = undefined,
  showAsToast: boolean = true,
) => {
  const toast = useToast();

  if (showAsToast) {
    toast.add({
      title: statusMessage,
      color: "red",
    });
  } else {
    showError({
      statusCode: statusCode,
      statusMessage: statusMessage,
    });
  }
};

export const getNumber = (value: number) => {
  if (typeof value === "number" && !Number.isNaN(value)) {
    return value; // Return the number itself
  }
  return 0; // Return 0 if not a number
};

export const isSuccessStatusCode = (statusCode: number) => {
  return !HTTP_ERROR_STATUS_CODES.includes(statusCode);
};

export const isErrorStatusCode = (statusCode: number) => {
  return HTTP_ERROR_STATUS_CODES.includes(statusCode);
};

export const getImageUrl = (item: Item): string => {
  return `http://localhost:8000/storage/${item.file_path}/${item.file_name}`;
}