<template>
<div>

    <div v-if="isLoading"><Spinner line-fg-color="#777777" size="medium" message="Loading product..."/></div>
    <div v-else class="container">
        <nav class="breadcrumb">
            <ul>
                <li><router-link :to="{ name: 'Products' }">Products</router-link></li>
                <li><router-link class="is-capitalized" :to="{ name: 'Products' }">{{product.categories}}</router-link></li>
                <li class="is-active is-capitalized"><a href="#">{{product.name}}</a></li>
            </ul>
        </nav>
        <div class=" columns is-1 is-centered ">
            <div class="column is-three-quarters">
                <div class="box">
                    <h1 class='title is-5 is-capitalized'>{{product.name}}</h1>
                    <p class="has-text-grey is-size-7"><i class="fas fa-clock"></i> sinds {{product.created_at}}</p>
                    €{{product.price}}
                    <figure class="image is-4by3">
                    <img :src="product.card_image" alt="Placeholder image">
                    </figure>
                    <div class="section has-text-left">
                        <p class="title is-6">Description:</p>
                        <p class="is-size-7">{{product.description}}</p>
                        <p class="is-size-7">Show more ads</p>
                    </div>
                </div>
            </div>
            <div class="column is-one-quarter">
                <div class="box">
                    <p class="title is-6">{{product.user.name}}</p>
                    <p class="is-7">{{userActive}}</p>
                    <p class="i-7">This is where I put the link to filter all ads for this user, and possibly data about their verification status, location and preferred payment methods.
                    </p>
                </div>
            </div>
       </div>
    </div>
</div>
</template>
<script>

import Spinner from 'vue-simple-spinner' //Custom package

export default {
    components: {
        Spinner,
    },
    props: ['initProduct'],
    data() {
        return {
            product: this.initProduct,
        }
    },
    computed: {
        isLoading () {
            return this.$store.getters.isLoading;
        },
        userActive () {
            const user = new Date(this.product.user.created_at)
            const current = new Date();
            let diff = Math.floor((current-user)/(1000*60*60*24)) //milli to secs, secs to mins, mins to hours, hours to days
            return `Active for ${diff} days.`
        },
    },
    created(){
        if (this.product === undefined){
            this.$store.commit('loadingStatus', true)
            axios.get(`api/products/${this.$route.params.id}`).then((res)=>{
            this.product = res.data.data
            this.$store.commit('loadingStatus', false)
            console.log('product was undefined, fetching data directly')
        })
        }
    }

}
</script>
