<script lang="ts" setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

import ItemForm from '~/components/pages/ItemForm.vue';

</script>

<template>
    <div class="flex h-full min-w-[840px] w-full max-w-full flex-col">
      <div class="w-full h-[60vh] flex min-h-[60vh] justify-center items-center flex-col px-12 my-16 gap-6">
        <p class="font-['Inter', 'Noto Sans', 'Roboto', 'SF Pro'] text-[28px] font-bold text-neutral-800">Got more to sell? Post it now!</p>
        <ItemForm />
      </div>
      <!-- <ProductsCard /> -->
    </div>
</template>