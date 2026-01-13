<script setup lang="ts">
const props = defineProps(['variant']);
let btnClass = '';
const cl = 'px-5 py-3 cursor-pointer rounded-full border-2 uppercase font-bold disabled:opacity-50 disabled:cursor-not-allowed';

switch (props.variant) {
  case 'secondary':
    btnClass = 'border-zinc-200 text-black bg-white';
    break;
  case 'danger':
    btnClass = 'border-red-200 text-red-500 bg-white';
    break;
  default:
    btnClass = 'border-stone-800/25 text-black bg-amber-400';
    break;
}
</script>

<template>
  <button :class="cl + ' ' + btnClass">
    <slot></slot>
  </button>
</template>
