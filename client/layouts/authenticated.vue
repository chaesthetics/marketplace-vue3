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
  <div class="bg-white h-screen min-h-screen flex overflow-hidden w-full">
    <div class="h-full flex-shrink-0 w-auto flex">
      <SideNav class="w-full h-full" />
    </div>

    <!-- Main Content -->
    <div class="flex flex-col overflow-x-auto h-full w-full
    ">
      <Navbar />
      <div class="flex flex-1 h-full w-full">
        <slot />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
