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
  <div class="bg-[#fafafa] h-screen flex gap-x-2 overflow-hidden w-full p-2">
    <div class="h-full flex-shrink-0 max-w-[250px]">
      <SideNav />
    </div>
    <div class="flex flex-col flex-grow gap-2">
      <Navbar />
      <div class="h-[calc(100vh-80px)]">
        <slot />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
