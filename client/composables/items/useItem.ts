import type { ErrorResponse } from "~/.types/general";
import type { Item, ItemsResponse } from "~/.types/item";
import { useApi } from "~/helpers/api";
import { ResponseError } from "~/errors/response-error";
import { handleError } from "~/helpers/helpers";
import type { Filter } from "~/.types/general";

const useItems = async() => {
    const { getData } = useApi();
    const items = ref<ItemsResponse>({ data: [] });
    const isLoading = ref(false);

    const filters = ref<Filter>({
        currentPage: 1,
        perPage: 20,
        filters: [],
    });

    const urlSearchParams = ref(new URLSearchParams());

    const fetcher = async() => {
        isLoading.value = true;
        try {
            const response = await getData<ItemsResponse | ErrorResponse>(
                `/api/items?${urlSearchParams.value.toString()}`,
            );

            const newItems = response?.data as Item[];
            if (filters.value.currentPage > 1 && items.value?.data?.length) {
                items.value.data = [...items.value.data, ...newItems];
              } else {
                if(response?.data){
                    items.value.data = response.data as Item[];
                }
              }
        } catch (error) {
            if (error instanceof ResponseError) {
                handleError(error.message, error.status);
                throw new ResponseError(error.message, error.status);
            } else {
                throw new Error(`Fetch error: ${error}`);
            }
        } finally {
            isLoading.value = false;
        }
    }

    const handleRefresh = async () => {
        urlSearchParams.value = new URLSearchParams();
        urlSearchParams.value.append("page", filters.value.currentPage.toString());
        urlSearchParams.value.append("results", filters.value.perPage.toString());
        await fetcher();
      };

    await fetcher();

    return {
        items,
        fetcher,
        filters,
        handleRefresh,
        isLoading,
    }
}

export default useItems;