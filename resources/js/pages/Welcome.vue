<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Site from '../layouts/Site.vue';
import { CalendarClock, ChefHat, HandPlatter, Map, MessageCircleHeart, Quote, Sparkles, Timer, Truck, Utensils } from 'lucide-vue-next';
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';

const services =  [
    {
        'icon': Truck,
        'title': 'we deliver lechon',
        'description': 'We bring the feast to you! Offering island-wide delivery in Pililla and extended service to select areas in Rizal. Delivery fees apply and are calculated upon checkout.'
    },
    {
        'icon': CalendarClock,
        'title': 'we accept advance order',
        'description': 'Plan your party with confidence. Book your Lechon for any future date by placing a minimum PHP 2,000 down payment on our site. Final payment is due at fulfillment.'
    },
    {
        'icon': Timer,
        'title': 'we accept rush order',
        'description': 'Need a Lechon today? Call us now! While we prioritize advance orders, we strive to accommodate same-day requests based on availability and preparation time. Additional fees may apply.'
    },
    {
        'icon': Utensils,
        'title': 'we offer food trays',
        'description': 'Complement your Lechon with our curated side dishes and classic Filipino specialties, served fresh in convenient trays. Perfect for hassle-free party planning.'
    },
    {
        'icon': ChefHat,
        'title': 'we offer labor services',
        'description': 'Need help carving and serving your Lechon for a professional presentation? Inquire about our on-site labor services to ensure your event runs smoothly.'
    },
    {
        'icon': HandPlatter,
        'title': 'we offer catering services',
        'description': 'Planning a large event or wedding? Our team can handle the full catering setup, from Lechon to full banquet service. Contact us directly for a custom quote.'
    },
];

const feedbacks = [
    {
        'id': 1,
        'testimony': "I ordered the 18kg Lechon for my son's baptism, and it was the absolute star of the show! The skin was incredibly crispy—perfectly 'tunog-kalye'—and the meat was juicy and seasoned all the way through.",
        'name': 'Marcus A.',
        'address': 'Makati City',
        'order': 'Lechon Fiesta, Lechon 18kg.',
        'source': 'Google Map' 
    },
    {
        'id': 2,
        'testimony': "Planning a party for 70 people is stressful, but Miller's made the main course effortless. We used their Advance Order service, and the Lechon was delivered right on time, hot, and ready to carve. Their service is just as good as their food.",
        'name': 'Sofia B.',
        'address': 'Mandaluyong City',
        'order': 'Lechon Fiesta, Lechon 15kg.',
        'source': 'Google Map' 
    },
    {
        'id': 3,
        'testimony': "We've been getting our Lechon from the Miller family for years. The consistency and quality are unmatched. You can taste the tradition in every bite. When you order from them, you're not just buying a meal, you're supporting a legacy.",
        'name': 'Michael S.',
        'address': 'Quezon City',
        'order': 'Lechon Fiesta, Lechon Belly.',
        'source': 'Google Map' 
    },
]

const mapsApi = import.meta.env.VITE_MAPS_EMBED_API_KEY;
const base = 'https://www.google.com/maps/embed/v1/place?key=';
const query = '&q=Millers+Lechon+Aka+Johnnys+Lechon'
const mapsSrc = base + mapsApi + query;
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <Site>
        <!-- Hero Section -->
        <div class="grid place-items-center text-white space-y-10 text-center p-20 bg-green-900 rounded-3xl">
            <h1 class="text-6xl lg:text-9xl font-black uppercase">Miller's <br /> Lechon</h1>
            <h2 class="uppercase text-xl font-semibold">Serving Pililla since 1974</h2>

            <p class="max-w-[500px]">Nested in the heart of Pililla, Rizal, Miller’s Lechon is a family-owned culinary destination known for its perfectly roasted lechon and heartfelt Filipino hospitality.</p>
            
            <div class="flex flex-col md:flex-row gap-5">
                <Link href="/menu"><Button>Order Lechon</Button></Link>
                <Link href="/about"><Button variant="secondary">About Miller's</Button></Link>
            </div>
        </div>

        <!-- What you need to know -->
        <Section gradientStart="right">
            <div class="text-center grid place-items-center">
                <Sparkles :size="48"></Sparkles>
                <h2 class="text-3xl lg:text-5xl font-semibold mt-5 mb-2.5 lg:mt-10">What You Need To Know</h2>
                <p class="text-xl max-w-[500px]">Explore our services to have a glimpse of what we can do for you</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-10">
                <div v-bind:key="service.title" v-for="service in services" class="p-5 lg:p-10">
                    <component :is="service.icon" :size="48"></component>
                    
                    <div class="mt-10 space-y-2.5">
                        <h3 class="font-bold capitalize text-2xl">{{ service.title }}</h3>
                        <p class="text-justify">{{ service.description }}</p>
                    </div>
                </div>
            </div>
        </Section>

        <!-- What other people says -->
        <Section gradientStart="left">
            <div class="text-center grid place-items-center">
                <MessageCircleHeart :size="48"></MessageCircleHeart>
                <h2 class="text-3xl lg:text-5xl font-semibold mt-5 mb-2.5 lg:mt-10">What Other People Says</h2>
                <p class="text-xl max-w-[500px]">Read the feedbacks our customer says about Miller&apos;s Lechon</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div v-bind:key="feedback.id" v-for="feedback in feedbacks" class="p-5 space-y-5 lg:space-y-10 lg:p-10">
                    <Quote :size="48"></Quote>
                    
                    <p class="text-justify text-lg lg:text-2xl italic">{{ feedback.testimony }}</p>
                    
                    <div>
                        <h3 class="font-bold capitalize text-2xl mb-2.5">{{ feedback.name + ', ' + feedback.address  }}</h3>    
                        <p>Ordered {{ feedback.order}}</p>
                        <p class="opacity-50">Review Via {{ feedback.source }}</p>
                    </div>
                </div>
            </div>
        </Section>

         <!-- Where to find us -->
        <Section gradientStart="right">
            <div class="text-center grid place-items-center mb-10">
                <Map :size="48"></Map>
                <h2 class="text-3xl lg:text-5xl font-semibold mt-5 mb-2.5 lg:mt-10">Where To Find Us</h2>
                <p class="text-xl max-w-[500px]">We are on Google Maps! You may use Waze and enter our address to reach us. See ya!</p>
            </div>

            <div class="border-2 rounded-2xl overflow-hidden border-stone-800/25">
                <iframe
                    class="w-full h-[400px]"
                    frameborder="0" style="border:0"
                    referrerpolicy="no-referrer-when-downgrade"
                    :src="mapsSrc"
                    allowfullscreen>
                </iframe>
            </div>
        </Section>
    </Site>
</template>
