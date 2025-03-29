<script lang="ts" setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

</script>

<template>
    <div class="flex h-full min-w-[840px] w-full max-w-full flex-col">
      <div class="w-full h-[60vh] flex min-h-[60vh] justify-center items-center flex-col px-12 my-16 gap-6">
        <p class="font-['Inter', 'Noto Sans', 'Roboto', 'SF Pro'] text-[28px] font-bold text-neutral-800">Got more to sell? Post it now!</p>
        <div class="flex min-w-[676px] w-[800px] border rounded-xl px-6 py-4 shadow-[0_5px_20px_rgba(16,185,129,0.2)]">
          <div class="flex justify-between w-full">
            <div class="w-full flex-col">
              <textarea class="w-full outline-none resize-none placeholder-neutral-600 text-[17px] p-2 max-h-40 overflow-auto" 
              placeholder="Describe product ideas..."
              ></textarea>

              <div class="flex justify-start items-center divide-x">
                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.75 8C18.75 8.69036 18.1904 9.25 17.5 9.25C16.8096 9.25 16.25 8.69036 16.25 8C16.25 7.30964 16.8096 6.75 17.5 6.75C18.1904 6.75 18.75 7.30964 18.75 8Z"></path><path d="M11 9.52773L5.01386 15.5139L5.98614 16.4861L11 11.4723L14 14.4723L15.5 12.9723L18.0139 15.4861L18.9861 14.5139L15.5 11.0277L14 12.5277L11 9.52773Z"></path><path d="M3.25 4C2.83579 4 2.5 4.33579 2.5 4.75V19.25C2.5 19.6642 2.83579 20 3.25 20H20.75C21.1642 20 21.5 19.6642 21.5 19.25V4.75C21.5 4.33579 21.1642 4 20.75 4H3.25ZM3.875 5.375H20.125V18.625H3.875V5.375Z"></path></svg>
                <div class="flex px-2">
                </div>
              </div>
            </div>
            <div class="flex h-full flex-col justify-end">
              <button class="bg-green-600 text-white px-4 py-2 rounded-full flex gap-1 items-center">
                <span class="font-semibold">Post</span>  
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- <ProductsCard /> -->
    </div>
</template>