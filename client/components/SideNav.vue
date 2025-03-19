<script setup>
import { ref, onMounted, nextTick, watch } from 'vue';
import { useLocalStorage } from '@vueuse/core';
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

// const isCollapsed = useLocalStorage('sidebar-collapsed', false);
const isCollapsed = ref(false);

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value;
};

const menuItems = ref([
  { text: 'Search', link: '/', tooltip: 'Search', icon: '<svg width="18" height="18" viewBox="0 0 16 16" fill="black" xmlns="http://www.w3.org/2000/svg"><path d="M11.1021 11.9123C9.98058 12.8513 8.53548 13.4167 6.95833 13.4167C3.39149 13.4167 0.5 10.5252 0.5 6.95833C0.5 3.39149 3.39149 0.5 6.95833 0.5C10.5252 0.5 13.4167 3.39149 13.4167 6.95833C13.4167 8.53548 12.8513 9.98058 11.9123 11.1021L15.4884 14.6782L14.6782 15.4884L11.1021 11.9123ZM12.2708 6.95833C12.2708 4.02432 9.89235 1.64583 6.95833 1.64583C4.02432 1.64583 1.64583 4.02432 1.64583 6.95833C1.64583 9.89235 4.02432 12.2708 6.95833 12.2708C9.89235 12.2708 12.2708 9.89235 12.2708 6.95833Z"></path></svg>' },
  { text: 'Products', link: '/products', tooltip: 'Products', icon: '<svg width="20" height="20" viewBox="0 0 18 16" xmlns="http://www.w3.org/2000/svg" fill="black"><path d="M1.30179 4.62619L8.70476 0.65826C8.88919 0.559409 9.11085 0.559409 9.29528 0.65826L16.6983 4.62619C17.1427 4.8644 17.1366 5.50378 16.6877 5.73346L9.2847 9.52103C9.10593 9.61249 8.89411 9.61249 8.71535 9.52103L1.31237 5.73346C0.863462 5.50378 0.85735 4.86441 1.30179 4.62619ZM2.71957 5.16632L9.00002 8.37958L15.2805 5.16632L9.00002 1.80005L2.71957 5.16632Z"></path><path d="M1.47906 7.44784L1.30181 7.54284C0.857373 7.78106 0.863485 8.42043 1.3124 8.65011L8.71537 12.4377C8.89413 12.5291 9.10595 12.5291 9.28472 12.4377L16.6877 8.65011C17.1366 8.42043 17.1427 7.78106 16.6983 7.54284L16.521 7.44784L15.2801 8.08275L15.2805 8.08297L9.00004 11.2962L2.71959 8.08297L2.72001 8.08275L1.47906 7.44784Z"></path><path d="M1.30181 10.4595L1.47906 10.3645L2.72001 10.9994L2.71959 10.9996L9.00004 14.2129L15.2805 10.9996L15.2801 10.9994L16.521 10.3645L16.6983 10.4595C17.1427 10.6977 17.1366 11.3371 16.6877 11.5668L9.28472 15.3543C9.10595 15.4458 8.89413 15.4458 8.71537 15.3543L1.3124 11.5668C0.863485 11.3371 0.857373 10.6977 1.30181 10.4595Z"></path></svg>' },
  { text: 'Favorites', link: '/favorites', tooltip: 'Favourites', icon: '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black"><path d="M11.9999 8.44456L10.1527 6.5973C8.68761 5.13224 6.31227 5.13224 4.84721 6.5973C3.38215 8.06236 3.38215 10.4377 4.84721 11.9028L11.9999 19.0555L19.1527 11.9027C20.6177 10.4377 20.6177 8.06233 19.1527 6.59727C17.6876 5.13221 15.3123 5.13221 13.8472 6.59727L11.9999 8.44456ZM11.9999 21L3.87494 12.875C1.8729 10.873 1.87291 7.62706 3.87494 5.62503C5.87697 3.62299 9.12291 3.623 11.1249 5.62503L11.9999 6.50001L12.8749 5.625C12.8752 5.62478 12.8754 5.62456 12.8756 5.62434C14.8777 3.62297 18.1231 3.62319 20.1249 5.625C22.127 7.62703 22.127 10.873 20.1249 12.875L11.9999 21Z" fill="#222222"></path></svg>' },
  { text: 'Messages', link: '/messages', tooltip: 'Messages', icon: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="black"><path d="M6.56248 14.2708V15.8493L9.08803 14.2708H12.0833V15.4167H9.41665L6.37289 17.319C5.95661 17.5792 5.41665 17.2799 5.41665 16.789V15.4167H2.70831C2.36314 15.4167 2.08331 15.1368 2.08331 14.7917V3.95833C2.08331 3.61315 2.36314 3.33333 2.70831 3.33333H17.2916C17.6368 3.33333 17.9166 3.61315 17.9166 3.95833V10.4167H16.7708V4.47916H3.22915V14.2708H6.56248Z"></path><path d="M15 6.66666H4.99998V7.8125H15V6.66666Z"></path><path d="M4.99998 9.375H9.16665V10.5208H4.99998V9.375Z"></path><path d="M16.207 11.5904C16.0541 11.2807 15.6125 11.2807 15.4597 11.5904L14.9506 12.6219C14.8899 12.7448 14.7726 12.8301 14.6369 12.8498L13.4986 13.0152C13.1569 13.0649 13.0204 13.4849 13.2677 13.7259L14.0914 14.5288C14.1896 14.6245 14.2344 14.7624 14.2112 14.8976L14.0167 16.0313C13.9584 16.3717 14.3156 16.6312 14.6213 16.4705L15.6394 15.9353C15.7608 15.8714 15.9058 15.8714 16.0272 15.9353L17.0453 16.4705C17.351 16.6312 17.7083 16.3717 17.6499 16.0313L17.4554 14.8976C17.4323 14.7624 17.4771 14.6245 17.5753 14.5288L18.3989 13.7259C18.6462 13.4849 18.5098 13.0649 18.168 13.0152L17.0297 12.8498C16.894 12.8301 16.7767 12.7448 16.716 12.6219L16.207 11.5904Z"></path></svg>' },
]);

let tippyInstances = [];
const initializeTippy = () => {
  nextTick(() => {
    tippyInstances.forEach(instance => instance.destroy());
    tippyInstances = [];
    if (isCollapsed.value) {
      tippyInstances = tippy('.nav-item', {
        placement: 'right',
        theme: 'light-border',
        arrow: true,
        animateFill: true,
        duration: [0, 300],
        animation: 'smooth-zoom',
        offset: [0, 35],
        onShow(instance) {
          if (isCollapsed.value) {
            instance.hide();
          }
        },
      });
    }
  });
};


onMounted(initializeTippy);
watch(menuItems, initializeTippy, { deep: true });
watch(isCollapsed, ()=> {
  initializeTippy();
});

const bottomMenuItems = [
  { text: 'Settings', link: '/settings', icon: '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="27" fill="black" data-spm-anchor-id=""><path d="M9 5.25H15V6.625H9V5.25Z" fill="#222222"></path><path d="M12 18.75C12.5523 18.75 13 18.3023 13 17.75C13 17.1977 12.5523 16.75 12 16.75C11.4477 16.75 11 17.1977 11 17.75C11 18.3023 11.4477 18.75 12 18.75Z" fill="#222222"></path><path d="M5.75 2.5C5.33579 2.5 5 2.83579 5 3.25V20.75C5 21.1642 5.33579 21.5 5.75 21.5H18.25C18.6642 21.5 19 21.1642 19 20.75V3.25C19 2.83579 18.6642 2.5 18.25 2.5H5.75ZM6.375 3.875H17.625V20.125H6.375V3.875Z" fill="#222222"></path></svg>' },
  { text: 'Profile', icon: 'heroicons-outline:user', link: '/profile' },
];
</script>

<template>
  <div class="flex h-screen">
    <img src="../assets/qmart.png" :class="`absolute top-[20px] left-[80px] w-[7rem] ${isCollapsed ? 'block' : 'hidden'}`" />
    <!-- Sidebar -->
    <aside :class="[
      'bg-[#F8F8F8] text-black transition-all duration-500 ease-in-out flex flex-col overflow-hidden py-6 shadow-sm',
      isCollapsed ? 'w-16 items-center' : 'w-56 px-3'
    ]" class="flex flex-col justify-between">

      <div class="flex items-center justify-between">
        <img src="../assets/qmart.png" :class="`w-[7rem] ${isCollapsed ? 'hidden' : 'block'}`" />

        <button @click="toggleSidebar" class="p-2 rounded transition-all duration-500 ease-in-out">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
            data-spm-anchor-id="a2700.accio_index.0.i57.2c017b7acdX0bZ">
            <path
              d="M0.0996002 15V3.00003C0.0996002 2.19963 0.3828 1.51563 0.9492 0.949232C1.21494 0.675211 1.53401 0.458556 1.88673 0.312639C2.23946 0.166721 2.61834 0.0946355 3 0.100832H15C15.8004 0.100832 16.4844 0.382832 17.0508 0.949232C17.6172 1.51563 17.9004 2.19963 17.9004 3.00123V15.0012C17.9004 15.8004 17.6172 16.4844 17.0508 17.0508C16.7852 17.3251 16.4661 17.5419 16.1134 17.6881C15.7607 17.8342 15.3817 17.9065 15 17.9004H3C2.61825 17.9065 2.23932 17.8342 1.88659 17.6881C1.53386 17.5419 1.21484 17.3251 0.9492 17.0508C0.67502 16.7852 0.45818 16.4661 0.312058 16.1134C0.165936 15.7607 0.0936299 15.3818 0.0996002 15ZM6.9 16.1004H15C15.3036 16.1004 15.564 15.9924 15.7776 15.7776C15.8817 15.677 15.964 15.556 16.0195 15.4223C16.0751 15.2885 16.1026 15.1448 16.1004 15V3.00003C16.1004 2.69643 15.9924 2.43723 15.7776 2.22243C15.6769 2.11835 15.556 2.036 15.4222 1.98048C15.2885 1.92496 15.1448 1.89745 15 1.89963H6.9V16.1004ZM3 1.89963C2.6964 1.89963 2.436 2.00763 2.2224 2.22243C2.11832 2.32311 2.03597 2.44405 1.98045 2.57779C1.92493 2.71154 1.89742 2.85524 1.8996 3.00003V15C1.8996 15.3036 2.0076 15.564 2.2224 15.7776C2.32308 15.8817 2.44402 15.9641 2.57776 16.0196C2.7115 16.0751 2.85521 16.1026 3 16.1004H5.1V1.89963H3Z"
              fill="#767676" data-spm-anchor-id="a2700.accio_index.0.i104.2c017b7acdX0bZ"></path>
          </svg>
        </button>
      </div>

      <button :class="`flex items-center gap-2 border border-black px-8 py-1 rounded-full transition my-4 justify-center items-center
      ${isCollapsed ? 'border-none bg-none' : ' bg-white'} `">
          <svg class="w-4 h-4" fill="black" stroke="black" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
          </svg>
          <span :class="`font-medium ${isCollapsed ? 'hidden' : 'block'}`">New search</span>
        </button>

      <nav class="flex flex-col gap-2 flex-1 w-full items-center">
        
        <NuxtLink v-for="item in menuItems" :key="item.text" :to="item.link"
          class="nav-item flex items-center gap-2 p-2 rounded transition-all duration-500 ease-in-out"
          :class="isCollapsed ? 'justify-center w-fit px-0' : 'justify-start w-full'" 
          :data-tippy-content="item.tooltip"
          >
          <div v-if="item.icon.startsWith('<svg')" v-html="item.icon" class="w-5 h-5"></div>
          <Icon v-else :name="item.icon" class="w-5 h-5 transition-all duration-500 ease-in-out text-gray-700" />
          <span class="transition-all text-gray-600 font-semibold duration-500 ease-in-out overflow-hidden whitespace-nowrap"
            :class="{ 'hidden': isCollapsed, 'block': !isCollapsed }">
            {{ item.text }}
          </span>
        </NuxtLink>
      </nav>

      <nav class="flex flex-col gap-2 w-full mt-auto items-center">
        <NuxtLink v-for="item in bottomMenuItems" :key="item.text" :to="item.link"
          class="flex items-center gap-2 p-2 rounded transition-all duration-500 ease-in-out"
          :class="isCollapsed ? 'justify-center w-fit px-0' : 'justify-start w-full'">
          <div v-if="item.icon.startsWith('<svg')" v-html="item.icon" class="w-5 h-5"></div>
          <Icon v-else :name="item.icon" class="w-5 h-5 transition-all duration-500 ease-in-out text-gray-700" />
          <span class="transition-all text-gray-600 font-semibold duration-500 ease-in-out overflow-hidden whitespace-nowrap"
            :class="{ 'hidden': isCollapsed, 'block': !isCollapsed }">
            {{ item.text }}
          </span>
        </NuxtLink>

      </nav>
    </aside>
  </div>
</template>

<style scope>
.icon-class {
  stroke-width: 0.1;
}
</style>