<script setup lang="ts">
const props = defineProps(['variant']);
let btnClass = '';

switch (props.variant) {
  case 'secondary':
    btnClass = 'px-5 py-3 rounded-full h-full border-2 border-stone-800/25 text-black bg-white uppercase font-bold';
    break;
  default:
    btnClass = 'px-5 py-3 rounded-full h-full border-2 border-stone-800/25 text-black bg-amber-400 uppercase font-bold';
    break;
}
</script>

<template>
  <button :class="btnClass">
    <slot></slot>
  </button>
</template>
