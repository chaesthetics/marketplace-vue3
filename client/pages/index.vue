<script lang="ts" setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "view", subject: "Post" }],
});

import CsvUpload from '~/components/CsvUpload.vue';

</script>

<template>
    <div class="flex h-full w-full justify-center">
        <CsvUpload />
    </div>
</template>