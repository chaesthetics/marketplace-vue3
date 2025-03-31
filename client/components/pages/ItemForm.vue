<script lang="ts" setup>
import { ref } from 'vue';
import type { UploadItems } from '../../.types/item';
import type { FormSubmitEvent } from '#ui/types'
import * as Yup from 'yup'
import { ResponseError } from "~/errors/response-error";
import { useApi } from "~/helpers/api";

const { postData } = useApi();
const form = ref();
const loading = ref(false);
const auth = useAuthStore();

const state = reactive<UploadItems>({
    title: '',
    file: null,
});

const hasErrors = ref(false);

const schema = Yup.object({
    title: Yup.string().required('Product name is required'),
    file: Yup.mixed().required('Product image is required'),
});

const previewUrl = ref<string | null>(null);

const handleFileUpload = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files && input.files[0]) {
    state.file = input.files[0];
    previewUrl.value = URL.createObjectURL(input.files[0]);
  }
};

const { displayToast } = getToastMessage();

const handleSubmitItem = async(
    event: FormSubmitEvent<{ title: string; file: File}>
) => {
    hasErrors.value = false;
    loading.value = true;
    try{
        await postData('/api/items', event.data);
        loading.value = false;
    } catch(error){
        if (error instanceof ResponseError) {
            if (error.message){
                hasErrors.value = true;
                loading.value = false;
                return displayToast(error.message, "red");
            }
        displayToast(error.message, "red");
        loading.value = false;
    }
}

}
</script>

<template>
    <UForm 

        :class="`flex min-w-[676px] w-[800px] border rounded-xl px-6 py-4 ${hasErrors ? 'shadow-[0_5px_30px_rgba(239,68,68,0.5)]' 
        : 'shadow-[0_5px_20px_rgba(16,185,129,0.2)]'}`"
        :state="state"
        :schema="schema"
        ref="form"
        @submit.prevent="handleSubmitItem"
    >
          <div class="flex justify-between w-full">
            <div class="w-full flex-col">
              <textarea class="w-full outline-none resize-none placeholder-neutral-600 text-[17px] p-2 max-h-40 overflow-auto" 
              placeholder="Enter product name"
              v-model="state.title"
              ></textarea>
              <div v-if="previewUrl" class="flex h-[120px] w-[120px] pb-4">
                <img 
                  :src="previewUrl" 
                  class="flex object-fill w-full h-full rounded-lg shadow-lg" 
                />
              </div>
              
              <div class="flex justify-start items-center divide-x">
                <div class="relative cursor-pointer flex justify-center items-center py-1 rounded">
                  <input 
                    type="file" 
                    class="absolute w-full inset-0 h-full opacity-0 cursor-pointer"
                    @change="handleFileUpload"
                  />
                  <svg class="mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="green"><path d="M18.75 8C18.75 8.69036 18.1904 9.25 17.5 9.25C16.8096 9.25 16.25 8.69036 16.25 8C16.25 7.30964 16.8096 6.75 17.5 6.75C18.1904 6.75 18.75 7.30964 18.75 8Z"></path><path d="M11 9.52773L5.01386 15.5139L5.98614 16.4861L11 11.4723L14 14.4723L15.5 12.9723L18.0139 15.4861L18.9861 14.5139L15.5 11.0277L14 12.5277L11 9.52773Z"></path><path d="M3.25 4C2.83579 4 2.5 4.33579 2.5 4.75V19.25C2.5 19.6642 2.83579 20 3.25 20H20.75C21.1642 20 21.5 19.6642 21.5 19.25V4.75C21.5 4.33579 21.1642 4 20.75 4H3.25ZM3.875 5.375H20.125V18.625H3.875V5.375Z"></path></svg>
                </div>
                <button class="flex h-full min-w-8 items-center justify-center px-2 text-green-700" aria-pressed="false" aria-label="Search"><svg width="24" height="24" viewBox="0 0 24 24" fill="gray" xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]"><path fill-rule="evenodd" clip-rule="evenodd" d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9851 4.00291C11.9933 4.00046 11.9982 4.00006 11.9996 4C12.001 4.00006 12.0067 4.00046 12.0149 4.00291C12.0256 4.00615 12.047 4.01416 12.079 4.03356C12.2092 4.11248 12.4258 4.32444 12.675 4.77696C12.9161 5.21453 13.1479 5.8046 13.3486 6.53263C13.6852 7.75315 13.9156 9.29169 13.981 11H10.019C10.0844 9.29169 10.3148 7.75315 10.6514 6.53263C10.8521 5.8046 11.0839 5.21453 11.325 4.77696C11.5742 4.32444 11.7908 4.11248 11.921 4.03356C11.953 4.01416 11.9744 4.00615 11.9851 4.00291ZM8.01766 11C8.08396 9.13314 8.33431 7.41167 8.72334 6.00094C8.87366 5.45584 9.04762 4.94639 9.24523 4.48694C6.48462 5.49946 4.43722 7.9901 4.06189 11H8.01766ZM4.06189 13H8.01766C8.09487 15.1737 8.42177 17.1555 8.93 18.6802C9.02641 18.9694 9.13134 19.2483 9.24522 19.5131C6.48461 18.5005 4.43722 16.0099 4.06189 13ZM10.019 13H13.981C13.9045 14.9972 13.6027 16.7574 13.1726 18.0477C12.9206 18.8038 12.6425 19.3436 12.3823 19.6737C12.2545 19.8359 12.1506 19.9225 12.0814 19.9649C12.0485 19.9852 12.0264 19.9935 12.0153 19.9969C12.0049 20.0001 11.9999 20 11.9999 20C11.9999 20 11.9948 20 11.9847 19.9969C11.9736 19.9935 11.9515 19.9852 11.9186 19.9649C11.8494 19.9225 11.7455 19.8359 11.6177 19.6737C11.3575 19.3436 11.0794 18.8038 10.8274 18.0477C10.3973 16.7574 10.0955 14.9972 10.019 13ZM15.9823 13C15.9051 15.1737 15.5782 17.1555 15.07 18.6802C14.9736 18.9694 14.8687 19.2483 14.7548 19.5131C17.5154 18.5005 19.5628 16.0099 19.9381 13H15.9823ZM19.9381 11C19.5628 7.99009 17.5154 5.49946 14.7548 4.48694C14.9524 4.94639 15.1263 5.45584 15.2767 6.00094C15.6657 7.41167 15.916 9.13314 15.9823 11H19.9381Z" fill="currentColor"></path></svg><span style="width: fit-content; opacity: 1; will-change: transform, opacity; transform: none;"><div class="whitespace-nowrap pl-1 pr-1 [display:--force-hide-label]">Search</div></span></button>
                <button class="flex h-full min-w-8 items-center justify-center px-2 text-green-700" aria-pressed="false" aria-label="Reason"><svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]"><path d="m12 3c-3.585 0-6.5 2.9225-6.5 6.5385 0 2.2826 1.162 4.2913 2.9248 5.4615h7.1504c1.7628-1.1702 2.9248-3.1789 2.9248-5.4615 0-3.6159-2.915-6.5385-6.5-6.5385zm2.8653 14h-5.7306v1h5.7306v-1zm-1.1329 3h-3.4648c0.3458 0.5978 0.9921 1 1.7324 1s1.3866-0.4022 1.7324-1zm-5.6064 0c0.44403 1.7252 2.0101 3 3.874 3s3.43-1.2748 3.874-3c0.5483-0.0047 0.9913-0.4506 0.9913-1v-2.4593c2.1969-1.5431 3.6347-4.1045 3.6347-7.0022 0-4.7108-3.8008-8.5385-8.5-8.5385-4.6992 0-8.5 3.8276-8.5 8.5385 0 2.8977 1.4378 5.4591 3.6347 7.0022v2.4593c0 0.5494 0.44301 0.9953 0.99128 1z" clip-rule="evenodd" fill="currentColor" fill-rule="evenodd"></path></svg><span style="width:fit-content;opacity:1;will-change:transform,opacity;transform:none"><div class="whitespace-nowrap pl-1 pr-1 [display:--force-hide-label]">Reason</div></span></button>
                <div class="flex px-2">
                </div>
              </div>
            </div>
            <div class="flex h-full flex-col justify-end w-[120px]">
              <button class="bg-green-600 text-white px-4 py-2 rounded-full flex gap-1 items-center w-full flex justify-center">
                <span type="submit" class="font-semibold">Upload</span>  
              </button>
            </div>
          </div>
        </UForm>
</template>