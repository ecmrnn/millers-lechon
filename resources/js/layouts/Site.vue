<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Menu, ShoppingCart } from 'lucide-vue-next';
</script>

<template>
    <div class="bg-zinc-100/50 tracking-wide">
        <header class="p-5 sticky z-50 top-0 bg-zinc-100 flex justify-between items-center">
            <button class="flex gap-5 items-center hover:cursor-pointer">
                <div class="aspect-square p-3.5 rounded-full border-2 border-stone-800/25 bg-amber-400 grid place-items-center">
                    <Menu></Menu>
                </div>
    
                <p class="font-bold uppercase">Menu</p>
            </button>
    
            <div class="flex gap-5 items-stretch">
                <Link href="/cart">
                    <button class="aspect-square p-3.5 rounded-full border-2 border-stone-800/25 bg-amber-400 grid place-items-center">
                        <ShoppingCart></ShoppingCart>
                    </button>
                </Link>
    
                <Link href="/login">
                    <button class="px-5 rounded-full h-full border-2 border-stone-800/25 bg-amber-400 grid place-items-center uppercase font-semibold">Login</button>
                </Link>
            </div>
        </header>
    
        <main class="min-h-screen px-5 space-y-5">
            <slot></slot>
        </main>
    
        <footer class="m-5 flex flex-col lg:flex-row gap-10 lg:gap-20 justify-between rounded-3xl bg-green-900 text-white p-10 lg:p-20">
            <div class="font-bold uppercase text-5xl">
                <p>Miller's</p>
                <p>Lechon</p>
                <p class="text-xl">Since 1974</p>
            </div>
    
    
            <nav class="flex gap-5 lg:gap-20 flex-col xl:flex-row">
                <div>
                    <h2 class="font-semibold uppercase mb-5">Navigation</h2>
                    <ul class="space-y-1">
                        <li><Link href="/">Home</Link></li>
                        <li><Link href="/about">About</Link></li>
                        <li><Link href="/menu">Menu</Link></li>
                        <li><Link href="/order">Order</Link></li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="font-semibold uppercase mb-5">Socials</h2>
                    <ul class="space-y-1">
                        <li><Link href="/">Facebook</Link></li>
                        <li><Link href="/">Instagram</Link></li>
                        <li><Link href="/">X / Twitter</Link></li>
                    </ul>
                </div>
    
                <div>
                    <h2 class="font-semibold uppercase mb-5">Operations</h2>
                    <ul class="space-y-1">
                        <li>Address: 410 manila east road, hulo, pililla, Rizal</li>
                        <li>Working Hours: 8:00 AM - 5:00 pm</li>
                        <li>Phone: +63 917 298 1519</li>
                    </ul>
                </div>
            </nav>
        </footer>
    </div>
</template>