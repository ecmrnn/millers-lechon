<script setup lang="ts">
import Anchor from '@/components/Anchor.vue';
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import SelectLabel from '@/components/ui/select/SelectLabel.vue';
import Site from '@/layouts/Site.vue';
import { Crown } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Form } from '@inertiajs/vue3';
import { addItem } from '@/routes/cart';
// import NativeSelect from '@/components/ui/native-select/NativeSelect.vue';
// import NativeSelectOption from '@/components/ui/native-select/NativeSelectOption.vue';

const props = defineProps({
    categories: Object,
    highlight: Object,
    freebies: Object
});

const cartModalOpen = ref(false);
const selectedProduct = ref();
const selectedFreebie = ref();

const openProductModal = (product: object) => {
    selectedProduct.value = product;
    cartModalOpen.value = true;
};

const hasFreebies = computed(() => {
    return selectedProduct.value.category.has_freebies === 1;
});

const selectFreebie = (freebie_id: number) => {
    selectedFreebie.value = freebie_id;
}

watch(cartModalOpen, (value) => {
    if (value) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
        selectedFreebie.value = null;
    }
})

const closeModal = () => {
    cartModalOpen.value = false;
    selectedFreebie.value = false;
}
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
        <Section gradientStart="left" v-if="props.highlight">
            <div class="grid lg:grid-cols-2 gap-5">
                <div class="space-y-5">
                    <Crown :size="48" class="text-amber-400"></Crown>
                    <h2 class="text-2xl lg:text-4xl font-bold capitalize">{{ props.highlight.name }}, <br /> perfect for any occasion!</h2>
                    <p class="font-semibold">Starting at {{ Number(props.highlight.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                    <p class="text-justify max-w-[600px]">{{ props.highlight.description }}</p>
                    
                    <Button variant="secondary" @click="openProductModal(props.highlight)">Add to Cart</Button>
                </div>

                <div class="aspect-video bg-green-200 rounded-2xl">
                    <!-- Image goes here -->
                </div>
            </div>
        </Section>

        <!-- Menu Header -->
        <section v-if="props.categories !== null" class="py-5 p-5 lg:px-20 bg-white sticky top-24 z-20 shadow-[-20px_0_white,20px_0_white,0_2px_rgb(245,245,245,0.5)]">
            <Anchor id="menu"></Anchor>
            <div class="grid grid-cols-3 gap-5">
                <div v-for="category in props.categories" v-bind:key="category.id">
                    <a :href="`#${category.id}`">
                        <button class="p-5 border-2 rounded-2xl border-zinc-200 w-full bg-white lg:text-left flex flex-col text-center lg:flex-row gap-5 items-center">
                            <div>
                                <h2 class="text-lg leading-none lg:text-2xl font-semibold">{{ category.name }}</h2>
                                <p class="hidden lg:block">{{ category.description }}</p>
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </section>

         <Section v-bind:key="category.id" v-for="category in props.categories" :gradientStart="category.id % 2 == 0 ? 'right' : 'left'">      
            <Anchor :id="`${category.id}`"></Anchor>
            <div>
                <div class="mb-10">
                    <h2 class="text-2xl lg:text-4xl font-bold">{{  category.name }}</h2>
                    <p>{{  category.description }}</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div v-for="product in category.products" v-bind:key="product.id" class="p-5 bg-white border-2 border-zinc-200 rounded-2xl space-y-5">
                        <img src="" class="aspect-video rounded-xl bg-green-200" />
                        
                        <div>
                            <h3 class="capitalize font-bold text-2xl">{{  product.name }}</h3>
                            <p class="font-semibold">{{  Number(product.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}<span v-if="product.unit_type === 'kg'">/kg</span></p>
                        </div>

                        <p>{{ product.description }}</p>

                        <Button variant="secondary" @click="openProductModal(product)">Add to Cart</Button>
                    </div>
                </div>
            </div>
        </Section>

        <!-- Add to Cart Modal -->
         <div v-if="cartModalOpen"  class="fixed z-50 top-0 left-0 bg-black/25 w-screen h-screen flex items-end justify-center sm:grid sm:place-items-center">
            <div class="bg-white p-5 lg:rounded-3xl w-full overflow-auto max-h-screen max-w-[500px] space-y-5">
                <h2 class="text-2xl lg:text-3xl capitalize font-bold">{{ selectedProduct.name }}</h2>

                <div class="space-y-2.5">
                    <img src="" class="aspect-video rounded-2xl bg-green-200" />

                    <div class="flex justify-between">
                        <div>
                            <p class="font-semibold text-sm">Price</p>
                            <p class="font-semibold text-lg">{{ Number(selectedProduct.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}<span v-if="selectedProduct.unit_type === 'kg'">/kg</span></p>
                        </div>
                    </div>

                    <p>{{ selectedProduct.description }}</p>
                </div>
                
                <Form v-slot="{ errors, processing }" @submitComplete="closeModal"  v-bind="addItem.form()" :options="{preserveScroll:true}" class="space-y-5">
                    <input type="hidden" :value="selectedProduct.id" id="product_id" name="product_id" />
                    <input v-if="hasFreebies" type="hidden" :value="selectedFreebie ? selectedFreebie : ''" id="freebie_id" name="freebie_id" />
                    
                    <div class="space-y-2 5">
                        <div class="flex gap-5">
                            <div class="space-y-2.5 w-full">
                                <Label for="quantity">Quantity</Label>
                                <Input min="1" defaultValue="1" type="number" id="quantity" name="quantity"></Input>
                                <InputError :message="errors.quantity" />
                            </div>
                            <div v-if="selectedProduct.unit_type === 'kg'" class="space-y-2.5 w-full">
                                <Label for="weight">Weight</Label>
                                <Input min="1" defaultValue="1" type="number" id="weight" name="weight"></Input>
                                <InputError v-if="errors.weight" :message="errors.weight" />
                            </div>
                        </div>
                        <div v-if="hasFreebies" class="space-y-2.5">
                            <Label for="freebie">Select a Freebie</Label>

                             <Select>
                                <SelectTrigger class="w-full" id="freebie" name="freebie">
                                    <SelectValue placeholder="Select a Freebie" />
                                </SelectTrigger>

                                <SelectContent>
                                    <SelectLabel>Freebies</SelectLabel>
                                    <SelectItem @click="selectFreebie(freebie.id)" :value="freebie.name" v-for="freebie in freebies" v-bind:key="freebie.id">
                                        {{ freebie.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError v-if="errors.freebie_id" :message="errors.freebie_id" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-2.5">
                        <Button :disabled="processing" class="text-xs" variant="secondary" @click="cartModalOpen = false">Cancel</Button>
                        <Button :disabled="processing" class="text-xs" variant="primary" type="submit">Add to Cart</Button>
                    </div>
                </Form>
            </div>
         </div>
    </Site>
</template>