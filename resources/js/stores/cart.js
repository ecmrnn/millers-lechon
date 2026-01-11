import { defineStore } from 'pinia';
// import axios from 'axios';

export default useCartStore = defineStore('cart', {
    state: () => ({
        items: []
    }),
    getters: {
        hasItems: (state) => state.items.length > 0
    },
    actions: {
        async fetchCart () {

        }
    }
});