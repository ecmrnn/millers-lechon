<script lang="ts" setup>
import Section from '@/components/Section.vue';
import Button from '@/components/ui/button/Button.vue';
import Site from '@/layouts/Site.vue';
import { Form, Link } from '@inertiajs/vue3';
import { PiggyBank, Store, Trash2, Truck } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { removeItem, clear } from '@/routes/cart';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import SelectLabel from '@/components/ui/select/SelectLabel.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';

defineProps({
    cart: Object,
    totalSum: Number,
    deliveryCost:  Number,
});

const page = usePage();
const itemCount = computed(() => page.props.itemCount as number);
const shippingMode = ref('pick_up');
</script>

<template>
    <Site>
        <Section>
            <h1 class="text-3xl lg:text-6xl font-bold uppercase">Cart</h1>
        </Section>
        <Section gradientStart="right">
            <div v-if="cart && itemCount > 0">
                <div class="p-5 lg:p-10 bg-white rounded-lg lg:rounded-3xl border-2 border-zinc-200 space-y-5 lg:space-y-10">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="font-semibold text-xl lg:text-2xl">Products in Cart</h2>
                            <p>List of all products you ordered</p>
                        </div>
                        <p class="font-semibold">{{ itemCount }} ITEM<span v-if="itemCount > 1">S</span></p>
                    </div>
                    <div>
                        <div class="grid mb-2.5 grid-cols-4 uppercase font-semibold p-2">
                            <p>Product</p>
                            <p class="text-center">Price</p>
                            <p class="text-center">Quantity</p>
                            <p class="text-center">Sub Total</p>
                        </div>
                        <div v-for="item in cart.items" v-bind:key="item.id" class="grid relative grid-cols-4 border-2 mb-1 last:mb-0 border-zinc-200 rounded-lg p-2">
                            <div class="flex gap-2 items-center">
                                <img class="aspect-square w-16 bg-green-200" />
                
                                <div>
                                    <p class="font-semibold text-lg capitalize">{{ item.product.name }}</p>
                                    <p v-if="item.freebie_id" class="text-sm capitalize">{{ item.freebie.name }}</p>
                                    <p v-if="item.weight" class="text-sm capitalize">{{ item.weight }}kg.</p>
                                </div>
                            </div>
                            <p class="text-center self-center">{{ Number(item.price).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                            <p class="text-center self-center">{{ item.quantity }}</p>
                            <p class="text-center self-center font-semibold">{{ Number(item.quantity * item.price * (item.weight ? item.weight : 1)).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                            <div class="absolute top-1/2 right-5 -translate-y-1/2">
                                <Form v-bind="removeItem.form()" method="post">
                                    <input type="hidden" :value="item.id" id="cart_item_id" name="cart_item_id" />
                                    <button class="p-2">
                                        <Trash2></Trash2>
                                    </button>
                                </Form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-2 gap-5 lg:gap-10 mt-5 lg:mt-10">
                    <div class="p-5 lg:p-10 bg-white rounded-lg lg:rounded-3xl border-2 border-zinc-200 space-y-5 lg:space-y-10">
                        <div>
                            <h2 class="font-semibold text-xl lg:text-2xl">Choose Shipping Mode</h2>
                            <p>Select how you want to get your order</p>
                        </div>

                        <div class="space-y-5">
                            <button @click="shippingMode = 'pick_up'" v-bind:class="shippingMode === 'pick_up' ? 'border-stone-800/25 bg-green-200' : 'border-zinc-200 bg-white'" class="p-5 flex w-full text-left gap-5 items-start border-2 rounded-lg">
                                <Store :size="24"></Store>
                                
                                <div>
                                    <p class="text-xl font-semibold">Pick Up</p>
                                    <p class="max-w-[400px] text-sm">You will personally get your order at our physical store: 410 Manila East Rd., Hulo, Pililla, Rizal free of charge!</p>
                                </div>
                            </button>
                            <div>
                                <button @click="shippingMode = 'delivery'" v-bind:class="shippingMode === 'delivery' ? 'border-stone-800/25 bg-green-200' : 'border-zinc-200 bg-white'" class="p-5 flex w-full text-left gap-5 items-start border-2 rounded-lg">
                                    <Truck :size="24"></Truck>
                                
                                    <div>
                                        <p class="text-xl font-semibold">Delivery</p>
                                        <p class="max-w-[400px] text-sm">We will deliver your order via courier service, additional fees are applied</p>
                                    </div>
                                </button>

                                <div v-if="shippingMode === 'delivery'" class="mt-5 space-y-2.5 p-5 border-2 border-zinc-200 rounded-lg">
                                    <Label for="region_id">Region</Label>
                                    <Select>
                                        <SelectTrigger class="w-full" id="region_id" name="region_id">
                                            <SelectValue placeholder="Select a Region" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectLabel>Region</SelectLabel>
                                            <SelectItem value="regioniva">
                                                Region IV - A
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <Label for="province_id">City / Province</Label>
                                    <Select>
                                        <SelectTrigger class="w-full" id="province_id" name="province_id">
                                            <SelectValue placeholder="Select a Province" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectLabel>Province</SelectLabel>
                                            <SelectItem value="regioniva">
                                                Rizal
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <Label for="municipailty_id">Municipailty</Label>
                                    <Select>
                                        <SelectTrigger class="w-full" id="municipailty_id" name="municipailty_id">
                                            <SelectValue placeholder="Select a Municipailty" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectLabel>Municipailty</SelectLabel>
                                            <SelectItem value="regioniva">
                                                Pililla
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <Label for="baranggay_id">Baranggay</Label>
                                    <Select>
                                        <SelectTrigger class="w-full" id="baranggay_id" name="baranggay_id">
                                            <SelectValue placeholder="Select a Baranggay" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectLabel>Baranggay</SelectLabel>
                                            <SelectItem value="regioniva">
                                                Hulo
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <Label for="street">Street</Label>
                                    <Input id="street" name="street" placeholder="e.g. 410 Manila East Rd." />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 lg:p-10 bg-white rounded-lg lg:rounded-3xl border-2 border-zinc-200 space-y-5 lg:space-y-10">
                        <div>
                            <h2 class="font-semibold text-xl lg:text-2xl">Order Summary</h2>
                            <p>Verify that your order is correct</p>
                        </div>

                        <div class="grid grid-cols-2 gap-1">
                            <p>Order Total</p>
                            <p class="text-right">{{ Number(totalSum).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                            <p>Delivery Costs</p>
                            <p class="text-right">{{ Number(deliveryCost).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                            <p class="font-semibold">Total</p>
                            <p class="font-semibold text-right">{{ Number((totalSum ? totalSum : 0) + (deliveryCost ? deliveryCost : 0)).toLocaleString('en-US', {style: 'currency', currency: 'PHP'}) }}</p>
                        </div>

                        <div class="flex justify-end gap-5">
                            <Form v-bind="clear.form()" method="post">
                                <Button variant="secondary">Empty Cart</Button>
                            </Form>
                            <Button variant="primary">Checkout</Button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="itemCount === 0">
                <PiggyBank class="mb-5" :size="48"></PiggyBank>

                <h2 class="font-semibold text-2xl">Nothing to see here...</h2>
                <p>Add a product on your cart first, ka-millers!</p>

                <Link href="/menu">
                    <Button variant="primary" class="mt-5">Browse Menu</Button>
                </Link>
            </div>
        </Section>
    </Site>
</template>