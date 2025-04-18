<script lang="ts" setup>
import type { Item } from '~/.types/item';
import { getImageUrl } from '~/helpers/helpers';

const props = defineProps<{
  items: Item[];
}>();

</script>

<template>
  <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 p-4">

  <div v-for="item in items" :key="item.title" class="mb-4 break-inside-avoid bg-white rounded-2xl shadow-xl p-4">
    <img :src="getImageUrl(item)" :alt="item.title" class="rounded-2xl">
    <h3 class="text-lg mt-2">{{ item.title }}</h3>
    <p class="text-sm text-gray-500">{{ 'Category' }}</p>
  </div>
  </div>
</template>