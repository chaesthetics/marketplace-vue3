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
  <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 p-4">
    <div v-for="item in items" :key="item.title" class="mb-4 break-inside-avoid bg-white rounded-2xl shadow-xl p-4">
      <img :src="`${config.public.apiBase}${item?.image_url.replace(/^\/+/, '')}`" :alt="item.title" class="rounded-2xl">
      <h3 class="text-lg mt-2">{{ item.title }}</h3>
      <p class="text-sm text-gray-500">{{ 'Category' }}</p>
    </div>
    <div ref="bottomRef" />
  </div>
</template>