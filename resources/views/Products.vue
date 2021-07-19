<template>
<div>
    <div v-if='isLoading'>
        <Spinner line-fg-color="#777777" size="large" message="Loading products..."/>
    </div>
    <div v-else>
        <div class="columns">
            <div class="column is-2">
                <SearchFilter />
                <div class="section has-text-left">
                    <h1 class="title is-size-6">Extra</h1>
                    <p class="is-size-7"> A section to add any other tidbits, that don't fall into categories or search filters
                    </p>
                </div>
            </div>
            <div class="column is-9">
                <h2 class="title">Products</h2>
                <div class="columns is-variable is-multiline is-1">
                    <ProductCard v-for="product in products" :key="product.id" :product="product"/>
                </div>
                <button v-show='totalProducts != products.length' class="button" v-on:click="addPages()">Load More</button>
            </div>
            <div class="column is-1">
                <!-- Empty filler -->
            </div>
       </div>
    </div>
</div>
</template>
<script>

/*
TODO:
Default sort by date, youngest first
Add sorting/ordering
Paginate
*/

const default_layout = "default";

import ProductCard from '../views/components/ProductCard.vue'
import Spinner from 'vue-simple-spinner' //Custom package
import SearchFilter from '../views/components/SearchFilter.vue'

export default {
    data() {
        return {
            paginationIndex: 18,
        }
    },
    components: {
        ProductCard,
        Spinner,
        SearchFilter,
    },
    
    mounted() {
        if(!this.users.length){
            console.log('Users empty, fetching...')
            this.$store.dispatch("fetchUsers");
        }
        if(!this.products.length){
            console.log('Products empty, fetching...')
            this.$store.dispatch("fetchProducts");
        }
        // window.onscroll = () => this.addPages();
        // this.addPages();
    },
    computed: {
        isLoading () {
            return this.$store.getters.isLoading;
        },
        products() {
            return this.$store.getters.filteredProducts.slice(0, this.paginationIndex);
        },
        totalProducts() {
            return this.$store.getters.filteredProducts.length
        },
        users() {
            return this.$store.state.users;
        }
    },
    methods: {
        addPages() {
            if(this.totalProducts != this.products.length){
                const docElement = document.documentElement;
                if (docElement.scrollTop + window.innerHeight === docElement.offsetHeight) {
                    this.paginationIndex += 18;
                }
            }
        },
    },

    // CRx :: filters? - This was something I used to force the names to capitalize. It turns out to be deprecated + Bulma allows for a simple CSS class to do this for me in is-capitalized
};
</script>
<style scoped>
.test h2 {
    background: #f4f4f4;
    padding: 20px;
    border-radius: 10px;
    margin: 10px auto;
    max-width: 600px;
    color: #444;
    text-align: center;
}
.test h2:hover {
    background: #ddd;
}
.test a {
    text-decoration: none;
}
</style>
