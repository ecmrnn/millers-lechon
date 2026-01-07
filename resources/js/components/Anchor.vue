<script setup lang="ts">
    const props = defineProps(['id']);
</script>

<template>
    <div :id="props.id" class="absolute w-2 -top-48 aspect-square bg-red-500"></div>
</template>