import type { ErrorResponse } from "~/.types/general";
import type { Item, ItemsResponse } from "~/.types/item";
import { useApi } from "~/helpers/api";
import { ResponseError } from "~/errors/response-error";
import { handleError } from "~/helpers/helpers";
import type { Filter } from "~/.types/general";

const useItems = async() => {
    const { getData } = useApi();
    const items = ref<ItemsResponse>();
    const filters = ref<Filter>({
        currentPage: 1,
        perPage: 100,
        filters: [],
      });

    const urlSearchParams = ref(new URLSearchParams());

    const fetcher = async() => {
        try {
            const response = await getData<ItemsResponse | ErrorResponse>(
                `/api/items?${urlSearchParams.value.toString()}`,
            );
            items.value = response as ItemsResponse;
        } catch (error) {
            if (error instanceof ResponseError) {
                handleError(error.message, error.status);
                throw new ResponseError(error.message, error.status);
            } else {
                throw new Error(`Fetch error: ${error}`);
            }
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
    }
}

export default useItems;