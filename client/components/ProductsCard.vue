<script lang="ts" setup>
import type { Item } from '~/.types/item';
const config = useRuntimeConfig()
import type { Filter } from "~/.types/general";

const props = defineProps<{
  items: Item[];
  filters: Filter;
}>();

const bottomRef = ref<HTMLElement | null>(null)

onMounted(() => {
  const observer = new IntersectionObserver(
    async (entries) => {
      if (entries[0].isIntersecting) {
        props.filters.currentPage++;
      }
    },
    {
      root: document.querySelector('.layout-container'),
      threshold: 0.5,
    }
  );

  if (bottomRef.value) {
    observer.observe(bottomRef.value);
  }

  onBeforeUnmount(() => observer.disconnect());
});

</script>

<template>
  <div class="container mx-auto px-4 py-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <div v-for="item in items" 
           :key="item.id" 
           class="flex flex-col bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="relative pt-[100%] px-4 rounded-md">
          <img :src="`${config.public.apiBase}${item?.image_url?.replace(/^\/+/, '')}`" 
               :alt="item.title"
               class="absolute top-0 left-0 w-full h-full object-contain"/>
        </div>
        <div class="p-4">
          <h3 class="text-lg font-medium">{{ item.title }}</h3>
          <p class="text-sm text-gray-500 mt-1">{{ 'No category' }}</p>
          <p class="text-lg font-bold text-green-600 mt-2">₱{{ item.price }}</p>
        </div>
      </div>
    </div>
    <div ref="bottomRef" class="h-1"/>
  </div>
</template>