<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Home, Menu, NotebookTabs, PiggyBank, ShoppingCart, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import Button from './ui/button/Button.vue';
const menuToggle = ref(true);
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const itemCount = computed(() => page.props.itemCount as number);

const links = [
    {
        'icon': Home,
        'title': 'Home',
        'href': '/',
        'description': 'The gateway to the Millers Lechon experience. Take a look on our offerings and feedbacks from our previous customers.',
        'shortDescription': 'View our services'
    },
    {
        'icon': PiggyBank,
        'title': 'About',
        'href': '/about',
        'description': 'The story of our heritage, our secret roasting process, and the commitment to quality that defines our Lechon.',
        'shortDescription': 'Know our story'
    },
    {
        'icon': NotebookTabs,
        'title': 'Menu',
        'href': '/menu',
        'description': 'A visual showcase of our offerings, from whole lechon and belly rolls to signature side dishes, including pricing and serving sizes.',
        'shortDescription': 'Check our products'
    },
]
</script>

<template>
    <div class="relative">
        <button class="flex flex-row-reverse lg:flex-row gap-5 items-center hover:cursor-pointer relative z-20" @click="menuToggle = ! menuToggle">
            <div class="aspect-square p-3.5 rounded-full border-2 *:transition-all *:last:absolute ease-in-out border-stone-800/25 bg-amber-400 grid place-items-center">
                <Menu :class="menuToggle ? 'scale-100' : 'scale-0'"></Menu>
                <X :class="menuToggle ? 'scale-0' : 'scale-100'"></X>
            </div>

            <div class="font-bold uppercase leading-5 hidden lg:block text-left *:transition-all ease-in-out">
                <p :class="menuToggle ? 'scale-0' : 'scale-100'">Close</p>
                <p :class="menuToggle ? '-translate-y-1/2' : 'translate-y-0'">Menu</p>
            </div>
        </button>

        <nav :class="menuToggle 
            ? '-translate-y-full lg:p-5 -z-10 lg:pt-24 pt-28 fixed -top-5 left-1/2 -translate-x-1/2 w-full h-screen max-w-4xl transition-all duration-500 ease-in-out'
            : 'translate-y-0 lg:p-5 -z-10 lg:pt-24 pt-28 fixed -top-5 left-1/2 -translate-x-1/2 w-full h-screen max-w-4xl transition-all duration-500 ease-in-out'">
            <div class="bg-white flex flex-col lg:flex-row gap-5 lg:gap-10 lg:rounded-3xl p-5 lg:p-10 border-2 border-zinc-200">
                <div class="hidden lg:block">
                    <p class="font-bold uppercase text-4xl leading-tight">Miller's <br/> Lechon</p>
                    <p class="font-semibold uppercase">Since 1974</p>
                </div>

                <div class="lg:hidden">
                    <p class="font-bold uppercase text-4xl leading-tight">Hello!</p>
                    <p class="font-semibold uppercase">What you wanna do?</p>
                </div>

                <div class="p-5 border-2 lg:grow rounded-2xl bg-zinc-100/25">
                    <div v-for="link in links" v-bind:key="link.title" class="mb-5 last:mb-0 group">
                        <Link :href="link.href" class="flex flex-row gap-5 items-center lg:items-start *:transition-all ease-in-out">
                            <div class="border-2 border-zinc-200 bg-white p-2.5 group-hover:bg-green-200 group-hover:border-green-300 rounded-2xl grid place-items-center">
                                <component :is="link.icon"></component>
                            </div>
                            
                            <div>
                                <p class="text-xl font-bold lg:mb-1">{{ link.title }}</p>
                                <p class="w-full hidden lg:block">{{ link.description }}</p>
                                <p class="w-full lg:hidden text-sm">{{ link.shortDescription }}</p>
                            </div>
                        </Link>
                    </div>
                </div>

                <div class="flex lg:hidden gap-5 items-stretch">
                    <Link href="/cart">
                        <button class="aspect-square relative p-3.5 rounded-full border-2 border-stone-800/25 bg-amber-400 grid place-items-center">
                            <ShoppingCart></ShoppingCart>
                            <div v-if="itemCount > 0" class="bg-red-500 rounded-full w-5 aspect-square grid place-items-center absolute -top-1 -left-1">
                            <p class="bg-red-500 rounded-full w-1 p-2 animate-ping aspect-square"></p>
                            <span class="absolute text-xs font-semibold text-white">{{ itemCount }}</span>
                        </div>
                        </button>
                    </Link>
        
                    <Link href="/login">
                        <Button>Login</Button>
                    </Link>
                </div>
            </div>
        </nav>
    </div>
</template>