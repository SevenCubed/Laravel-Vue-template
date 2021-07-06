<template>
    <div class="box has-background-info-light has-text-left">
        <h1 class="title is-size-5">Search</h1>
        <p class="is-size-6 has-text-weight-bold">Filters</p>
        <p class="is-size-7">This is where I put the search filters, once I figure out how to update those live.</p>
        <br>           
        <div class="content">
        <h1 class="is-size-6 has-text-weight-bold">Questions</h1>
            <ul class="is-size-7">
                <li>Mounted products check?</li>
            </ul>
            </div>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Prices</h1>
            <ul v-if="priceRanges">
                <li class="is-capitalized is-size-7 is-clickable has-text-weight-bold" @click="filterByPrice([])">All</li>
                <li class="is-capitalized is-size-7 is-clickable" v-for="price in priceRanges" :key="price.id" @click="filterByPrice(price)">{{price}}</li>
            </ul>
            </div>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Categories</h1>
            <ul v-if="categories">
                <li class="is-capitalized is-size-7 is-clickable has-text-weight-bold" @click="filterByCategory([])">All</li>
                <li class="is-capitalized is-size-7 is-clickable" v-for="category in categories" :key="category.id" @click="filterByCategory(category.name)">{{category.name}}</li>
            </ul>
            <div class="section">
            <ul>
                <li  v-for="category in categories" :key="category.id">
                    <input type="checkbox" class="form-check-input" 
                        v-model="filters.categories"
                        v-bind:value="category.name">
                    {{category.name}}
                </li>
            </ul>
             <ul>
                <li  v-for="price in priceRanges" :key="price.id">
                    <input type="checkbox" class="form-check-input" 
                        v-model="filters.price"
                        v-bind:value="price">
                    {{price}}
                </li>
            </ul>
            </div>
            </div>
        {{filters}}
    </div>
</template>

<script setup>

export default 
{
    data() {
        return {
            priceRanges: [
                [0,5],
                [5,10],
                [10,50],
                [50,100],
                [100,500],
                [500,2,147,483,647]
            ],
            filters: {
                categories: [],
                price: [],
            }
        };
    },
    mounted() {
        this.$store.dispatch("fetchCategories");
    },
    computed: {
        categories() {
            return this.$store.getters.categories;
        },
    },
    methods: {
        filterByCategory (category) {
            this.$store.dispatch("filterCategory", category)
        },
        filterByPrice (price) {
            this.$store.dispatch("filterPrice", price)
        },
    },

}
</script>

<style lang="scss" scoped>

</style>