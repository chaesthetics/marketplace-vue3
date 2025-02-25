import { useNuxtApp } from "#app";
import type { AxiosInstance } from "axios";
import { ResponseError } from "~/errors/response-error";
import { isErrorStatusCode } from "./helpers";

export const useApi = () => {
  const { $api } = useNuxtApp() as unknown as { $api: AxiosInstance };

  const apiData = async <T>(
    method: string,
    url: string,
    data: unknown = {},
    params: unknown = {},
    headers: Record<string, string> = {},
  ): Promise<T> => {
    try {
      const response = await $api({
        method,
        url,
        data,
        params,
        headers,
      })
        .then((response) => response.data)
        .catch((error) => error.response);

      if (isErrorStatusCode(response.status)) {
        throw new ResponseError(response.data.message, response.status);
      }

      return response;
    } catch (error) {
      if (error instanceof ResponseError) {
        throw new ResponseError(error.message, error.status);
      } else {
        throw new Error(error?.toString());
      }
    }
  };

  const getData = <T>(
    url: string,
    params: unknown = {},
    headers: Record<string, string> = {},
  ): Promise<T> => {
    try {
      return apiData<T>("get", url, {}, params, headers);
    } catch (error) {
      if (error instanceof ResponseError) {
        throw new ResponseError(error.message, error.status);
      } else {
        throw new Error(error?.toString());
      }
    }
  };

  const postData = <T>(
    url: string,
    data: unknown,
    headers: Record<string, string> = {},
  ): Promise<T> => {
    try {
      return apiData<T>("post", url, data, headers);
    } catch (error) {
      if (error instanceof ResponseError) {
        throw new ResponseError(error.message, error.status);
      } else {
        throw new Error(error?.toString());
      }
    }
  };

  const putData = <T>(
    url: string,
    data: unknown,
    headers: Record<string, string> = {},
  ): Promise<T> => {
    try {
      return apiData<T>("put", url, data, headers);
    } catch (error) {
      if (error instanceof ResponseError) {
        throw new ResponseError(error.message, error.status);
      } else {
        throw new Error(error?.toString());
      }
    }
  };

  const deleteData = <T>(
    url: string,
    headers: Record<string, string> = {},
  ): Promise<T> => {
    try {
      return apiData<T>("delete", url, headers);
    } catch (error) {
      if (error instanceof ResponseError) {
        throw new ResponseError(error.message, error.status);
      } else {
        throw new Error(error?.toString());
      }
    }
  };

  return {
    apiData,
    getData,
    postData,
    putData,
    deleteData,
  };
};
