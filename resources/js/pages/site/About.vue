<script setup lang="ts">
import Anchor from '@/components/Anchor.vue';
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';
import Site from '@/layouts/Site.vue';
import { Link } from '@inertiajs/vue3';
import { BookOpenText, CookingPot, HeartHandshake, Quote } from 'lucide-vue-next';

const managers = [
    {
        'id': 1,
        'image': '',
        'name': 'Evelyn “Mame” Maranan',
        'management_date': '2023 - present',
        'quote': "For us, Lechon is more than a business; it's the taste of our childhood. We never change the original methods—that's the Miller promise.",
    },
    {
        'id': 2,
        'image': '',
        'name': 'Christopher “Epoy” Maranan',
        'management_date': '2010 - 2023',
        'quote': "Every pig is chosen and roasted with the same care since 1974. The crispy skin and the rich seasoning—that's a matter of daily pride.",
    },
    {
        'id': 3,
        'image': '',
        'name': 'Juan “Mang Johnny” Maranan',
        'management_date': '1974 - 2010',
        'quote': "We've been blessed to serve Pililla for decades. When you order from Miller's, you're becoming part of our family's continuing story.",
    },
]
</script>

<template>
    <Site>
        <!-- Hero Section -->
        <div class="grid place-items-center text-white space-y-10 text-center p-20 bg-green-900 rounded-3xl">
            <h1 class="text-6xl lg:text-9xl font-black uppercase">Lechon <br /> Story</h1>
            <h2 class="uppercase text-xl font-semibold">Serving Pililla since 1974</h2>

            <p class="max-w-[500px]">Miller’s Lechon began as a small family endeavor built on tradition. For decades, we’ve stayed true to the same roasting methods that made our lechon a local favorite—slow-cooked, crispy, and made with heart.</p>
            
            <a href="#story">
                <Button>Read our Story</Button>
            </a>
        </div>

        <!-- What do you call this? -->
         <Section gradientStart="right">
            <div class="flex flex-col-reverse lg:flex-row justify-between gap-10">
                <p class="text-2xl lg:text-4xl font-bold w-full lg:w-1/2 leading-relaxed">Since 1974, our family has poured heart and tradition into every roast—serving Pililla with the same flavors we grew up loving.</p>
                <Quote :size="48"></Quote>
            </div>
         </Section>

        <!-- Our Story -->
        <Section gradientStart="left">
            <div class="grid lg:grid-cols-2 gap-5 lg:gap-10 relative">
                <Anchor id="story"></Anchor>
                <div class="bg-green-200 rounded-3xl overflow-hidden">
                    <!-- Image goes here -->
                </div>

                <div class="space-y-5 lg:space-y-10">
                    <BookOpenText :size="48"></BookOpenText>
                    <h2 class="capitalize text-3xl lg:text-4xl font-semibold leading-snug">Celebrating the Family and Craft Behind Every Roast</h2>

                    <h3 class="capitalize text-2xl font-semibold">A Family Tradition</h3>
                    <p class="text-justify leading-relaxed">The quality of Miller's Lechon is a direct reflection of the commitment passed down through our family since 1974. Every generation—from the founders, Juan and Irenea Maranan, to the current manager, Evelyn 'Ellen'—has maintained a strict adherence to our father’s time-honored roasting techniques, ensuring that the taste of true Pililla tradition graces every table.</p>

                    <h3 class="capitalize text-2xl font-semibold">crafting the perfect roast</h3>
                    <p class="text-justify leading-relaxed">Miller's Lechon’s renowned taste is achieved through methods perfected over half a century, but two elements truly set our roast apart: the signature spice blend and the secret family sauce. Our special sauce is a unique component—a secret family recipe carefully passed down through the generations from our matriarch to her daughter—that provides a distinct, savory depth. Additionally, before roasting, every Lechon is hand-rubbed with a special blend of herbs and spices personally mixed and managed by Evelyn 'Ellen,' who currently runs the business. This secret spice mix ensures the flavor penetrates deep into the meat, guaranteeing a rich, savory taste in every single bite.</p>
                </div>
            </div>
        </Section>

        <!-- Meet the Family -->
        <Section gradientStart="right">
            <div class="text-center grid place-items-center">
                <HeartHandshake :size="48"></HeartHandshake>
                <h2 class="text-3xl lg:text-5xl font-semibold mt-5 mb-2.5 lg:mt-10">Meet The Family</h2>
                <p class="text-xl max-w-[500px]">Get to know the previous and current owners of Miller’s Lechon</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mt-5 lg:mt-10">
                <div v-bind:key="manager.id" v-for="manager in managers" class="space-y-2.5">
                    <div class="aspect-video bg-green-200 rounded-2xl">
                        <!-- Image goes here -->
                        <!-- <img :src="manager.image" alt=""> -->
                    </div>
                    <h3 class="font-bold text-center capitalize text-2xl">{{ manager.name }}</h3>
                    <p class="text-center">{{ manager.quote }}</p>
                </div>
            </div>
        </Section>

        <!-- What do you call this again? -->
         <Section gradientStart="left">
            <div class="grid lg:grid-cols-2 gap-5">
                <div class="space-y-5">
                    <CookingPot :size="48" class="text-amber-400"></CookingPot>
                    <h2 class="text-2xl lg:text-4xl font-bold">Taste the Heritage in Every Roast</h2>
                    <p class="text-justify max-w-[600px]">For over 50 years, Miller's Lechon has been committed to serving Pililla's finest roast. From our family kitchen to your table, we guarantee every Lechon is roasted to perfection—crispy, savory, and bursting with traditional flavor. Experience the taste of history today.</p>
                    <Link :href="'/menu'">
                        <Button variant="primary">Order your Miller's Lechon</Button>
                    </Link>
                </div>

                <div class="aspect-video bg-green-200 rounded-2xl">
                    <!-- Image goes here -->
                </div>
            </div>
         </Section>
    </Site>
</template>