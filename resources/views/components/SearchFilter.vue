<template>
    <div class="box has-background-info-light has-text-left">
        <h1 class="title is-size-5">Search</h1>
        <p class="is-size-6 has-text-weight-bold">Filters</p>
        <input class="is-size-7"
        v-model="filters.search"
        type="search"
        placeholder="Use any search term"
        aria-label="Use any search term"
        @input="searchDebounced(filters.search)"
        >        
        <br>
        <br>
        <div class="content">
        <h1 class="is-size-6 has-text-weight-bold">Questions</h1>
            <ul class="is-size-7">
                <li>Navigation guard for login?</li>
                <li></li>
            </ul>
            </div>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Prices</h1>
            <Vue-slider v-model="sliderValue" :enable-cross="false" :min="0" :max="1000" :interval="1" @change="priceSliderDebounced()"/>
            <!-- https://nightcatsama.github.io/vue-slider-component/#/basics/simple -->
            {{sliderValue}}
            </div>
            <br>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Categories</h1>
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
            </div>
        <div class="">
            <div class="">
                <p
                class=""
                @click="orderOpen = !orderOpen"
                >
                <span class="is-size-6 has-text-weight-bold"><i class="fa-solid fa-arrow-down-wide-short"></i>Order By: </span>
                <span class="is-size-6">{{ orderText }}</span>
                </p>
                <ul v-show="orderOpen" class="">
                <li
                    class="is-size-7"
                    :class="{ 'has-text-weight-bold' :filters.order === 'createdAtDesc' }"
                    @click="handleFilterOrder('createdAtDesc')"
                >
                    Created At ↓
                </li>
                <li
                    class="is-size-7"
                    :class="{ 'has-text-weight-bold' :filters.order === 'createdAtAsc' }"
                    @click="handleFilterOrder('createdAtAsc')"
                >
                    Created At ↑
                </li>
                <li
                    class="is-size-7"
                    :class="{ 'has-text-weight-bold' :filters.order === 'priceDesc' }"
                    @click="handleFilterOrder('priceDesc')"
                >
                    Price ↓
                </li>
                <li
                    class="is-size-7"
                    :class="{ 'has-text-weight-bold' :filters.order === 'priceAsc' }"
                    @click="handleFilterOrder('priceAsc')"
                >
                    Price ↑
                </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>

/*
TODO:
Sort algorithm https://medium.com/@rajat_m/implement-5-sorting-algorithms-using-javascript-63c5a917e811
*/

import { debounce } from '../../js/helpers/index'
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

export default 
{
    data() {
        return {
            priceRanges: [
                [0,10000],
                // [5,10],
                // [10,50],
                // [50,100],
                // [100,500],
                // [500,2,147,483,647]
            ],
            filters: {
                categories: [],
                price: [],
                user: [],
                search: '',
                order: '',
            },
            limits: [
                [5, 5], //categories
                [5, 5],  //price
            ],
            sliderValue: [0,1000],
            orderOpen: false,
        };
    },
    components: {
        VueSlider
    },
    mounted() {
        this.$store.dispatch("fetchCategories");
        this.filters = this.$store.state.filters;
        if(this.filters.price.length){
            console.log('slider?')
            this.sliderValue = this.filters.price;
        }
    },

    computed: {
        categories() {
            return this.$store.getters.categories;
        },
        orderText() {
            switch (this.filters.order) {
                case 'createdAtAsc':
                    return 'Created At ↑'
                case 'createdAtDesc':
                    return 'Created At ↓'
                case 'priceAsc':
                    return 'Price ↑'
                case 'priceDesc':
                    return 'Price ↓'
                default:
                    return 'Default'
            }
        },
    },
    created() {
        this.searchDebounced = debounce(this.search, 500);
        this.priceSliderDebounced = debounce(this.priceSlider, 500);
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
        search(){
            this.$store.dispatch("updateFilters", this.filters)
        },
        priceSlider(){
            this.filters.price = this.sliderValue
            this.$store.dispatch("updateFilters", this.filters)
        },
        closeOrderDropDown (e) {
            this.orderOpen = false
        },
        handleFilterOrder (orderBy) {
            this.orderOpen = false
            this.filters.order = orderBy
            this.$store.dispatch("updateFilters", this.filters)
        },
    },

}
</script>

<style lang="scss" scoped>

</style>