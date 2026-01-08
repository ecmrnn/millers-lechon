<script setup lang="ts">
import Anchor from '@/components/Anchor.vue';
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';
import Site from '@/layouts/Site.vue';
import { Crown, Ham, Inbox, PiggyBank } from 'lucide-vue-next';
// import { Link } from '@inertiajs/vue3';
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
        <Section gradientStart="left">
            <div class="grid lg:grid-cols-2 gap-5">
                <div class="space-y-5">
                    <Crown :size="48" class="text-amber-400"></Crown>
                    <h2 class="text-2xl lg:text-4xl font-bold capitalize">lechon belly, <br /> perfect for any occasion!</h2>
                    <p class="font-semibold">Starting at Php1,000.00</p>
                    <p class="text-justify max-w-[600px]">Boneless and rolled with special herbs and spices for maximum flavor and easy carving. A decadent, presentation-ready centerpiece that serves 10–15 guests.</p>
                    
                    <Button variant="secondary">Add to Cart</Button>
                </div>

                <div class="aspect-video bg-green-200 rounded-2xl">
                    <!-- Image goes here -->
                </div>
            </div>
        </Section>

        <!-- Menu Header -->
        <section class="p-5 bg-white rounded-3xl sticky top-24 z-20
            before:content-[''] before:w-10 before:absolute before:h-full before:bg-white before:left-0 before:top-0 before:-translate-x-1/2
            after:content-[''] after:w-10 after:absolute after:h-full after:bg-white after:right-0 after:top-0 after:translate-x-1/2">
            <div class="grid grid-cols-3 gap-5">
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <PiggyBank :size="32"></PiggyBank>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Lechon Fiesta</h2>
                        <p class="hidden lg:block">For Large Occassions</p>
                    </div>
                </button>
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <Ham :size="32"></Ham>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Lechon Familia</h2>
                        <p class="hidden lg:block">For Family/Any Occassion</p>
                    </div>
                </button>
                <button class="p-5 border-2 rounded-2xl border-zinc-200 bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                    <Inbox :size="32"></Inbox>
                    
                    <div>
                        <h2 class="text-lg leading-none lg:text-2xl font-semibold">Food Trays</h2>
                        <p class="hidden lg:block">Perfect Pair for Lechon</p>
                    </div>
                </button>
            </div>
        </section>
    </Site>
</template>