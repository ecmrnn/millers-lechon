<script setup lang="ts">
import Anchor from '@/components/Anchor.vue';
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';
import Site from '@/layouts/Site.vue';
import { Crown, Ham, Inbox, PiggyBank } from 'lucide-vue-next';
// import { Link } from '@inertiajs/vue3';

const props = defineProps([
    'categories',
    'highlight',
]);
</script>

<template>
    <Site>
        <!-- Hero Section -->
        <div class="grid place-items-center text-white space-y-10 text-center p-20 bg-green-900 rounded-3xl">
            <h1 class="text-6xl lg:text-9xl font-black uppercase">Miller's <br /> Menu</h1>
            <h2 class="uppercase text-xl font-semibold">Serving Pililla since 1974</h2>

            <p class="max-w-[500px]">Featuring our whole roasts, parts, and savory Filipino sides! Browse are Menu and add it to your cart for checkout!</p>
            
            <a href="#menu">
                <Button>Browse Menu</Button>
            </a>
        </div>
        
        <!-- What do you call this again? -->
        <Section gradientStart="left" v-if="props.highlight !== null">
            <div class="grid lg:grid-cols-2 gap-5">
                <div class="space-y-5">
                    <Crown :size="48" class="text-amber-400"></Crown>
                    <h2 class="text-2xl lg:text-4xl font-bold capitalize">{{ props.highlight.name }}, <br /> perfect for any occasion!</h2>
                    <p class="font-semibold">Starting at {{ Number(props.highlight.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                    <p class="text-justify max-w-[600px]">{{ props.highlight.description }}</p>
                    
                    <Button variant="secondary">Add to Cart</Button>
                </div>

                <div class="aspect-video bg-green-200 rounded-2xl">
                    <!-- Image goes here -->
                </div>
            </div>
        </Section>

        <!-- Menu Header -->
        <section class="py-5 p-5 lg:px-20 bg-white sticky top-24 z-20 shadow-[-20px_0_white,20px_0_white,0_2px_rgb(245,245,245,0.5)]">
            <Anchor id="menu"></Anchor>
            <div class="grid grid-cols-3 gap-5">
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <PiggyBank :size="32" class="hidden md:block"></PiggyBank>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Lechon Fiesta</h2>
                        <p class="hidden lg:block">For Large Occassions</p>
                    </div>
                </button>
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <Ham :size="32" class="hidden md:block"></Ham>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Lechon Familia</h2>
                        <p class="hidden lg:block">For Family/Any Occassion</p>
                    </div>
                </button>
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <Inbox :size="32" class="hidden md:block"></Inbox>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Food Trays</h2>
                        <p class="hidden lg:block">Perfect Pair for Lechon</p>
                    </div>
                </button>
            </div>
        </section>

        <!-- Lechon Fiesta -->
         <Section v-bind:key="category.id" v-for="category in props.categories" :gradientStart="category.id % 2 == 0 ? 'right' : 'left'">      
            <div>
                <div class="mb-10">
                    <h2 class="text-2xl lg:text-4xl font-bold">{{  category.name }}</h2>
                    <p>{{  category.description }}</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div v-for="product in category.products" v-bind:key="product.id" class="p-5 bg-white border-2 border-zinc-200 rounded-2xl space-y-5">
                        <img src="" class="aspect-video rounded-xl bg-green-200" />
                        
                        <div>
                            <h3 class="capitalize font-semibold text-xl">{{  product.name }}</h3>
                            <p class="font-semibold">{{  Number(product.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                        </div>

                        <p>{{  product.description }}</p>

                        <Button variant="secondary">Add to Cart</Button>
                    </div>
                </div>
            </div>
         </Section>
    </Site>
</template>