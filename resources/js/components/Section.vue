<script setup lang="ts">
const props = defineProps(['gradientStart']);
const gradientClass = "w-[1000px] z-0 bg-radial from-green-200 to-white to-70% aspect-square rounded-full absolute";
let rightGradient = "";
let leftGradient = "";

if (props.gradientStart) {
    switch (props.gradientStart) {
        case 'right':
                rightGradient = "translate-x-1/2 -translate-y-1/2 top-0 right-0";
                leftGradient = "-translate-x-1/2 translate-y-1/2 bottom-0 left-0";
            break;
        case 'left':
                rightGradient = "translate-x-1/2 translate-y-1/2 bottom-0 right-0";
                leftGradient = "-translate-x-1/2 -translate-y-1/2 top-0 left-0";
            break;
        default:
            break;
    }
}
</script>

<template>
    <section class="p-10 lg:p-20 bg-white rounded-3xl relative overflow-hidden">
        <div class="z-10 relative">
            <slot></slot>
        </div>

        <!-- Gradient -->
        <div :class="rightGradient + ' ' + gradientClass"></div>
        <div :class="leftGradient + ' ' + gradientClass"></div>
    </section>
</template>