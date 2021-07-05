<template>
    <div class="box has-background-info-light has-text-left">
        <h1 class="title is-size-5">Search</h1>
        <p class="is-size-6 has-text-weight-bold">Filters</p>
        <p class="is-size-7">This is where I put the search filters, once I figure out how to update those live.</p>
        <br>
        <h1 class="is-size-6 has-text-weight-bold">Questions</h1>
            <ul class="is-size-7">
                <li>CR json?</li>
            </ul>
            <br>
            <h1 class="is-size-6 has-text-weight-bold">Categories</h1>
            <ul v-if="categories">
                <li class="is-capitalized is-size-7" v-for="category in categories" :key="category.id">{{category.name}}</li>
            </ul>
        
    </div>
</template>

<script setup>

export default 
{
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch("fetchCategories");
        console.log(categories);
    },
    computed: {
        categories() {
            return this.$store.getters.categories;
        },
    }

}
</script>

<style lang="scss" scoped>

</style>