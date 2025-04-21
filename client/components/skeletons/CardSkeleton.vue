<script setup>
const skeletonCount = 8;
</script>
<template>
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="n in skeletonCount"
          :key="n"
          class="flex flex-col bg-white rounded-2xl shadow-xl overflow-hidden animate-pulse"
        >
          <div class="relative pt-[100%] px-4 bg-gray-200 rounded-md" />
  
          <div class="p-4 space-y-2">
            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
            <div class="h-5 bg-gray-300 rounded w-1/3 mt-2"></div>
          </div>
        </div>
      </div>
    </div>
</template>
  