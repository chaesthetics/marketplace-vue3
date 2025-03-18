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
    <!-- Sidebar Wrapper (Fixed Width) -->
    <div class="h-full flex-shrink-0 w-auto flex">
      <SideNav class="w-full h-full" />
    </div>

    <!-- Main Content -->
    <div class="flex flex-col flex-grow gap-2">
      <Navbar />
      <div class="h-[calc(100vh-80px)]">
        <slot />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
