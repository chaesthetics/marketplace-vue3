<script setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

</script>
<template>
  <div class="w-full h-full flex items-center justify-center">
    <p>Coming soon.</p>
  </div>
</template>