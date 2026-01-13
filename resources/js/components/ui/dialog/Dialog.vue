<script setup lang="ts">
import { watch } from 'vue';

const props = defineProps({
    dialogOpen: Boolean
});

watch(props, () => {
    if (props.dialogOpen) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})
</script>

<template>
    <div v-if="dialogOpen" class="fixed z-50 top-0 left-0 bg-black/25 w-screen h-screen flex items-end justify-center lg:grid lg:place-items-center">
        <div class="bg-white p-5 rounded-t-lg lg:rounded-3xl w-full overflow-auto max-h-screen max-w-[500px] space-y-5">
            <slot></slot>
        </div>
    </div>
</template>