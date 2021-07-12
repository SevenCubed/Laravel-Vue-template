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
                <li>File upload encoding?</li>
                <li>There's got to be a better way @ formdata</li>
                <li>CR: Collection = JSON? (jasper)</li>
                <li>Is using Infinity a good idea?</li>
            </ul>
            </div>
            <div class="">
            <h1 class="is-size-6 has-text-weight-bold">Prices</h1>
            <Vue-slider v-model="sliderValue" :enable-cross="false" :min="0" :max="1000" :interval="1" @change="priceSliderDebounced()"/>
            <!-- https://nightcatsama.github.io/vue-slider-component/#/basics/simple -->
            {{sliderValue}}
            <!-- <ul class="is-size-7" v-if="priceRanges">
                <li class="is-size-7" v-for="(price, index) in priceRanges" :key="price.id" v-if="index < limits[1][0]">
                    <input type="checkbox" class="form-check-input" 
                        v-model="filters.price"
                        v-bind:value="price"
                        @change="updateFilters()">
                    {{price}}
                </li>
                <a href="javascript:void(0)" class="mt-1" @click="toggle(1)">{{ limits[1][0]===limits[1][1]?'+Show more': '-Hide more'}}</a>
            </ul> -->
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
            {{filters}}
            </div>
    </div>
</template>

<script setup>

/*
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
            },
            limits: [
                [5, 5], //categories
                [5, 5],  //price
            ],
            sliderValue: [0,1000]
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
    },

}
</script>

<style lang="scss" scoped>

</style>