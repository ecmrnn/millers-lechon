<script setup lang="ts">
    const props = defineProps(['id']);
</script>

<template>
    <div :id="props.id" class="absolute -top-48 aspect-square left-0"></div>
</template>