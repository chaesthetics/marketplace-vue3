<script lang="ts" setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

import useItems from '~/composables/items/useItem';
const { items, filters, handleRefresh } = await useItems();

watch(
  () => filters.value.currentPage,
  async (newPage, oldPage) => {
      await handleRefresh();
  }
);

</script>

<template>
    <div class="flex h-full min-w-[840px] w-full max-w-full flex-col">
      <div class="w-full h-[60vh] flex min-h-[60vh] justify-center items-center flex-col px-12 my-16 gap-6">
        <p class="font-['Inter', 'Noto Sans', 'Roboto', 'SF Pro'] text-[28px] font-bold text-neutral-800">Find products for your marketplace with AI!</p>
        <div class="relative flex items-center gap-4 p-1 bg-gray-100 rounded-lg">
          <div class="flex items-center gap-2 bg-white rounded-md px-6 py-2">
            <svg viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width:20;height:20"><path d="M16.3542 6.80965L10.5729 9.53024V16.8031L12.6012 15.8598L12.8627 15.9673C13.2094 16.1098 13.5217 16.3164 13.7852 16.5728L10.2636 18.2107C10.0965 18.2885 9.90354 18.2885 9.73642 18.2107L2.86142 15.0131C2.64098 14.9105 2.5 14.6895 2.5 14.4464V5.55363C2.5 5.31052 2.64098 5.08946 2.86142 4.98693L9.73642 1.78926C9.90354 1.71152 10.0965 1.71152 10.2636 1.78926L17.1386 4.98693C17.359 5.08946 17.5 5.31052 17.5 5.55363V13.0461C17.2004 12.7648 16.9608 12.4204 16.8013 12.0328L16.5682 11.467L16.5676 11.4656C16.5143 11.3357 16.4411 11.226 16.3542 11.1362V6.80965ZM4.01189 5.71554L10 8.53348L15.9881 5.71554L10 2.93037L4.01189 5.71554ZM9.42708 9.53024L3.64583 6.80965V14.1142L9.42708 16.8031V9.53024Z" fill="currentColor"></path><path d="M13.1778 14.389L12.6158 14.6197V14.6184C12.4614 14.6822 12.4614 14.9009 12.6158 14.9647L13.1796 15.1966C14.1029 15.576 14.8361 16.3086 15.2162 17.2318L15.4506 17.8006C15.5144 17.9557 15.7331 17.955 15.7969 17.8006L16.0276 17.2387C16.407 16.3155 17.1396 15.5816 18.0622 15.201L18.6342 14.9653C18.7886 14.9022 18.7886 14.6834 18.6342 14.6197L18.0666 14.3859C17.1434 14.0058 16.4107 13.2733 16.0307 12.35L15.7969 11.7825C15.7338 11.6281 15.515 11.6281 15.4512 11.7825L15.2156 12.3544C14.8349 13.2776 14.101 14.0096 13.1778 14.389Z" fill="currentColor"></path></svg>
            <span class="font-['Inter', 'Noto Sans', 'Roboto', 'SF Pro'] font-semibold text-[14px] items-center">Product search</span>
          </div>
          <div class="flex items-center gap-2 rounded-md px-6 py-2 text-neutral-500">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="grey" xmlns="http://www.w3.org/2000/svg" style="width:20;height:20"><path d="M16.25 6.25L12.0833 2.08333H4.375C4.02982 2.08333 3.75 2.36315 3.75 2.70833V17.2917C3.75 17.6368 4.02982 17.9167 4.375 17.9167H14.1804L14.0289 17.549C13.9114 17.2635 13.7504 17.0015 13.5539 16.7708H4.89583V3.22916H11.25V7.08333H15.1042V10.8386C15.5216 10.7968 15.9616 11.0044 16.151 11.4656L16.1516 11.467L16.25 11.706V6.25ZM14.317 5.93749H12.3958V4.01628L14.317 5.93749Z" fill="currentColor"></path><path d="M12.1991 14.6196L12.7611 14.389C13.6844 14.0096 14.4182 13.2776 14.7989 12.3544L15.0346 11.7825C15.0983 11.6281 15.3171 11.6281 15.3802 11.7825L15.614 12.35C15.9941 13.2732 16.7267 14.0058 17.65 14.3859L18.2175 14.6196C18.3719 14.6834 18.3719 14.9022 18.2175 14.9653L17.6456 15.201C16.7229 15.5816 15.9903 16.3155 15.6109 17.2387L15.3802 17.8006C15.3165 17.955 15.0977 17.9557 15.0339 17.8006L14.7995 17.2318C14.4195 16.3086 13.6862 15.576 12.763 15.1966L12.1991 14.9647C12.0447 14.9009 12.0447 14.6822 12.1991 14.6184V14.6196Z" fill="currentColor"></path><path d="M9.58333 8.64583H6.04167V7.5H9.58333V8.64583Z" fill="currentColor"></path><path d="M12.0833 10.9375H6.04167V9.79166H12.0833V10.9375Z" fill="currentColor"></path></svg>
            <span class="font-['Noto Sans'] font-semibold text-[14px]">Business research</span>
          </div>
          <div class="absolute flex items-center bg-green-600 text-white rounded-md px-[6px] py-[4px] items-center text-[12px] font-medium -top-3 -right-8"
          >
            Upcoming
          </div>
        </div>
        <div class="flex min-w-[676px] w-[800px] border rounded-xl px-6 py-4 shadow-[0_5px_20px_rgba(16,185,129,0.2)]">
          <div class="flex justify-between w-full">
            <div class="w-full flex-col">
              <textarea class="w-full outline-none resize-none placeholder-neutral-600 text-[17px] p-2 max-h-40 overflow-auto" 
              placeholder="Describe product ideas..."
              ></textarea>

              <div class="flex justify-start items-center divide-x">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.75 8C18.75 8.69036 18.1904 9.25 17.5 9.25C16.8096 9.25 16.25 8.69036 16.25 8C16.25 7.30964 16.8096 6.75 17.5 6.75C18.1904 6.75 18.75 7.30964 18.75 8Z"></path><path d="M11 9.52773L5.01386 15.5139L5.98614 16.4861L11 11.4723L14 14.4723L15.5 12.9723L18.0139 15.4861L18.9861 14.5139L15.5 11.0277L14 12.5277L11 9.52773Z"></path><path d="M3.25 4C2.83579 4 2.5 4.33579 2.5 4.75V19.25C2.5 19.6642 2.83579 20 3.25 20H20.75C21.1642 20 21.5 19.6642 21.5 19.25V4.75C21.5 4.33579 21.1642 4 20.75 4H3.25ZM3.875 5.375H20.125V18.625H3.875V5.375Z"></path></svg>
                <div class="flex px-2">
                  <div class="flex items-center gap-2 flex-row">
                    <label class="relative flex items-center cursor-pointer">
                      <input type="checkbox" class="sr-only peer">
                      <div class="w-8 h-4 bg-gray-300 rounded-full peer-checked:bg-green-500 peer transition-colors"></div>
                      <div class="absolute left-0 top-1/2 h-3 w-3 bg-white rounded-full shadow-md transform translate-x-1 -translate-y-1/2 peer-checked:translate-x-4 transition-transform"></div>
                    </label>
                    <span>Deep search</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex h-full flex-col justify-end">
              <button class="bg-green-600 text-white px-4 py-2 rounded-full flex gap-1 items-center">
                <svg viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width:20;height:20"><g clip-path="url(#clip0_365_22384)"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.0108 4.80568L10.4489 5.03633V5.03508C10.2945 5.09884 10.2945 5.31761 10.4489 5.38137L11.0127 5.61327C11.936 5.99269 12.6692 6.72527 13.0492 7.6485L13.2837 8.21731C13.3474 8.37233 13.5662 8.37171 13.63 8.21731L13.8606 7.65538C14.24 6.73215 14.9727 5.99832 15.8953 5.61765L16.4673 5.382C16.6217 5.31886 16.6217 5.10009 16.4673 5.03633L15.8997 4.80256C14.9764 4.42251 14.2438 3.68993 13.8637 2.7667L13.63 2.19914C13.5668 2.04475 13.348 2.04475 13.2843 2.19914L13.0486 2.77108C12.6679 3.69431 11.9341 4.42626 11.0108 4.80568ZM8.88634 3.67628C9.20095 3.6426 9.45835 3.38934 9.45835 3.07293C9.45835 2.75651 9.20098 2.49735 8.88578 2.52504C5.58713 2.81482 3 5.58445 3 8.95834C3 12.5252 5.8915 15.4167 9.45835 15.4167C11.0355 15.4167 12.4806 14.8514 13.602 13.9123L16.7731 17.0834C16.9968 17.3071 17.3596 17.3071 17.5833 17.0834C17.8071 16.8596 17.8071 16.4969 17.5833 16.2732L14.4123 13.1021C15.2365 12.1178 15.7729 10.884 15.8917 9.53057C15.9194 9.21537 15.6602 8.95834 15.3438 8.95834C15.0274 8.95834 14.7741 9.21574 14.7404 9.53036C14.4551 12.1954 12.1991 14.2708 9.45835 14.2708C6.52433 14.2708 4.14584 11.8924 4.14584 8.95834C4.14584 6.21758 6.22132 3.96158 8.88634 3.67628Z" fill="currentColor"></path></g><defs><clipPath id="clip0_365_22384"><rect width="20" height="20" fill="currentColor" transform="translate(0.5)"></rect></clipPath></defs></svg>
                <span class="font-semibold">Search</span>  
              </button>
            </div>
          </div>
        </div>
      </div>
      <ProductsCard 
        :items="items?.data ?? []"
        :filters="filters"
      />
    </div>
</template>