<script lang="ts" setup>

definePageMeta({
  middleware: ["auth"],
  layout: "authenticated",
  permissions: [{ action: "viewAny", subject: "Post" }],
});

</script>

<template>
    <div class="flex h-full w-full justify-center">
        <p>Coming soon.</p>
    </div>
</template>