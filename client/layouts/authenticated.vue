<script lang="ts" setup>
const { getAppShouldReload, storeBuildVersion } = useAuthStore();

watchEffect(() => {
  console.log("getAppShouldReload: " + getAppShouldReload);
});

onMounted(async () => {
  await storeBuildVersion();
  if (getAppShouldReload === true) {
    location.reload();
  }
});
</script>

<template>
  <div class="bg-white h-screen flex overflow-hidden w-full">
    <div class="h-full flex-shrink-0 w-auto flex">
      <SideNav class="w-full h-full" />
    </div>

    <!-- Main Content -->
    <div class="flex flex-col gap-2 overflow-x-scroll flex-grow overflow-x-scroll
    ">
      <Navbar />
      <div class="h-[calc(100vh-80px)]">
        <slot />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
