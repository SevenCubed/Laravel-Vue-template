<template>
    <div>
<h1 class="title">Dashboard</h1>
{{user.name}}
{{user.email}}
      <router-link :to="{ name: 'Add Product' }" class="navbar-item">
        Add New Product
      </router-link>
       <button v-on:click="test()">Test</button>
    </div>
</template>

<script setup>

export default {
    data() {
        return{
        }    
    },
    computed: {
        user() {
            return this.$store.getters['authentication/activeUser']
        },
    },
    methods: {
        test(){
            const id = this.user.id
            console.log(id)
            this.$store.dispatch("fetchAds", id)
        }
    },
    // mounted(){
    //     axios.get('/api/user').then((res)=>{
    //         this.user = res.data;
    //     })
    // }
};
</script>

<style lang="scss" scoped>

</style>