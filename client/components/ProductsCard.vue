<script lang="ts" setup>
import type { Item } from '~/.types/item';
import { getImageUrl } from '~/helpers/helpers';

const props = defineProps<{
  items: Item[];
}>();

// const products = [
//   {
//     image: "https://s.alicdn.com/@img/imgextra/i1/O1CN01IAD3T61dOYmNmytja_!!6000000003726-2-tps-1080-1215.png_400x400q80.jpg",
//     title: "Validate your side hustle idea to win $10K!",
//     category: "Business research"
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H83033673246d47a2a9c51619d701c0ad2.png_400x400q80.jpg",
//     title: "Wireless Boombox Speakers",
//     category: "Business research"
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H28a6fe3e3a3945d8b396f2adbc5944189.png_400x400q80.jpg",
//     title: "New arrival plant pots",
//     category: "Deep search"
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H6d76236b8623460bb118809ede9cef267.png_400x400q80.jpg",
//     title: "Noise-Canceling Headphones",
//     category: "Business research"
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H054dcb9bd54c48718383f8bd922cea27c.png_400x400q80.jpg",
//     title: "GIA-Certified Diamond Rings",
//     category: "Business research"
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/Hd0e32a878b2f4f4a99d81dc3ab691546c.png_400x400q80.jpg",
//     title: "Extendable Smart Dining Table",
//     category: "Business research",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H92e9e1c7fb1d4678ade60186eb2f79ce4.png_400x400q80.jpg",
//     title: "Hot-selling VR Fitness Equipment",
//     category: "Deep search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H932417e06f4c40acb36b1dc4de9a57e9P.png_400x400q80.jpg",
//     title: "Source wedding favors",
//     category: "Deep search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H29ac52401e1d4721986fd81d41612358I.png_400x400q80.jpg",
//     title: "2025 trending outdoor lightning",
//     category: "Deep search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/S3f16d4467d594ccc9396be3a62b18633T.png_400x400q80.jpg",
//     title: "Ski gogles trend",
//     category: "Business research",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H7d45cc4e32f04a26b246c8626d2a6eb1U.png_400x400q80.jpg",
//     title: "Flannel blanket, fashionable, large size, reversible, custom, super soft, warm, cozy, luxury",
//     category: "Deep search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/S610b11b2b4aa48fab7f5cd69dd0e8218V.png_400x400q80.jpg",
//     title: "Skincare tools trends",
//     category: "Business research",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/H0ca569f92f224838868f8f56f6fb732fi.png_400x400q80.jpg",
//     title: "Source camping tents",
//     category: "Product search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/S35d5293408f94866a0fda008c85089f5X.png_400x400q80.jpg",
//     title: "New Arrival Companion Toy",
//     category: "Deep search",
//   },
//   {
//     image: "https://s.alicdn.com/@sc02/kf/Hef957aaa444245b1a6e956100bb1c84bR.png_400x400q80.jpg",
//     title: "Micro-influencer limited swimwear collaborations",
//     "category": "Business research",
//   }
// ];

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