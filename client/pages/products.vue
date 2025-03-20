<script setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

</script>
<template></template>