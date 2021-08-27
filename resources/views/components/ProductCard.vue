<template>

<div class="column is-2">
    <div class="card">
        <router-link class="is-clickable" tag="div"
        :to="{
            name: 'ProductDetails',
            params: { id: product.id, initProduct: product }
        }">
            <div class="card-image">
                <figure class="image is-3by2">
                    <img :src="product.card_image" alt="Placeholder image">
                </figure>
            </div>
            <div class="card-content py-1 has-text-left">
                <p class="is-size-8 is-capitalized">{{product.name}}</p>
                <p class="is-size-6 has-text-weight-bold">€{{product.price}} {{product.user.location}}</p>
            </div>
        </router-link>  
    </div>
</div>
</template>

<script setup>

export default {
 props: {
     product: Object
 }
};
</script>

<style lang="scss" scoped>

</style>