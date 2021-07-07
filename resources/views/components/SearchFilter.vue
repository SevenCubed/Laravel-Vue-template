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
            <!-- <ul v-if="priceRanges">
                <li class="is-capitalized is-size-7 is-clickable has-text-weight-bold" @click="filterByPrice([])">All</li>
                <li class="is-capitalized is-size-7 is-clickable" v-for="price in priceRanges" :key="price.id" @click="filterByPrice(price)">{{price}}</li>
            </ul> -->
            <ul class="is-size-7" v-if="priceRanges">
                <li class="is-size-7" v-for="(price, index) in priceRanges" :key="price.id" v-if="index < limits[1][0]">
                    <input type="checkbox" class="form-check-input" 
                        v-model="filters.price"
                        v-bind:value="price"
                        @change="updateFilters()">
                    {{price}}
                </li>
                <a href="javascript:void(0)" class="mt-1" @click="toggle(1)">{{ limits[1][0]===limits[1][1]?'+Show more': '-Hide more'}}</a>
            </ul>
            </div>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Categories</h1>
            <!-- <ul v-if="categories">
                <li class="is-capitalized is-size-7 is-clickable has-text-weight-bold" @click="filterByCategory([])">All</li>
                <li class="is-capitalized is-size-7 is-clickable" v-for="category in categories" :key="category.id" @click="filterByCategory(category.name)">{{category.name}}</li>
            </ul> -->
            <ul class="is-size-7" v-if="categories">
                <li class="is-capitalized is-size-7" v-for="(category, index) in categories" :key="category.id" v-if="index < limits[0][0]">
                    <input type="checkbox" class="form-check-input" 
                        v-model="filters.categories"
                        v-bind:value="category.name"
                        @change="updateFilters()">
                    {{category.name}}
                </li>
                <a href="javascript:void(0)" class="mt-1" @click="toggle(0)">{{ limits[0][0]===limits[0][1]?'+Show more': '-Hide more'}}</a>
            </ul>
            </div>
            <br>
            <div class="has-text-left is-capitalized is-size-7">
            {{filters}}
            </div>
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
            },
            limits: [
                [5, 5], //categories
                [5, 5],  //price
            ],
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
        updateFilters(){
            this.$store.dispatch("updateFilters", this.filters)
        },
        toggle(index) {
            console.log(this.limits[index][0])
            const newValue = (this.limits[index][0] === this.limits[index][1]) ? 10000 : this.limits[index][1];
            this.limits[index].splice(0, 1, newValue) //Splicing because just setting it does not trigger Vue reactivity.
        },
    },

}
</script>

<style lang="scss" scoped>

</style>