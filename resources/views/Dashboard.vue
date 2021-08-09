<template>
    <div>
<h1 class="title">Dashboard</h1>
{{user.name}}
{{user.email}}
      <router-link :to="{ name: 'Add Product' }" class="navbar-item">
        Add New Product
      </router-link>
    <div v-if="ads.length && !isLoading">
        <div class="title is-3">
            Current ads
        </div>
            <div  v-for="ad in ads" :key="ad.id" class="columns has-text-left">
                <div class="column is-four-fifths ">
                <router-link class="is-clickable" tag="div"
                    :to="{
                        name: 'ProductDetails',
                        params: { id: ad.id, initProduct: ad }
                    }">
                        <b>{{ad.id}}</b> {{ad.name}}  €{{ad.price}}
                        <!-- spruce this up later -->
                </router-link>
                </div>
                <div class="column">
                <router-link :to="{name: 'Update Product', params: { id: ad.id }}">
                    <i class="fas fa-edit"></i>
                </router-link>
                </div>
                <i class="fas fa-trash-alt column is-clickable" @click="deleteAd(ad.id)"></i>
            </div>
    </div>
    <div v-if="!ads.length && !isLoading">
        You are not currently selling anything! Have you considered doing so?
    </div>
    <div v-if="!ads.length && isLoading">
        <Spinner line-fg-color="#777777" size="medium" message=""/>
    </div>
    <div v-if="ads.length && isLoading">
        <!-- This shouldn't ever happen, but y'know -->
        Something went wrong, please refresh.
    </div>
</div>
</template>

<script setup>

import Spinner from 'vue-simple-spinner' //Custom package

export default {
    data() {
        return{
            ads: false,
        }    
    },
    components: {
        Spinner,
    },
    computed: {
        user() {
            return this.$store.getters['authentication/activeUser']
        },
        isLoading () {
            return this.$store.getters.isLoading;
        },
    },
    mounted() {
        const id = this.$store.state.authentication.user.id
        console.log("Attempting to fetch ads...")
        this.$store.commit('loadingStatus', true)
            axios
            .post("api/users/ads", {'id': id})
            .catch(function (error) {
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log("Error", error.message);
                }
                console.log(error.config);
            })
            .then(response => {
                this.ads = response.data.data.products
                this.$store.commit('loadingStatus', false)
            });
    },
    methods: {
        deleteAd(id){
            axios
            .delete(`api/products/${id}`)
            .then(response => {
                console.log(response)
                const i = this.ads.map(ad => ad.id).indexOf(id);
                this.ads.splice(i, 1)
            })
        }
    },
};
</script>

<style lang="scss" scoped>

</style>