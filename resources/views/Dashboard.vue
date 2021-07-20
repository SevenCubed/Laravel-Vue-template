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
    mounted() {
        const token = localStorage.getItem('api_token');
        console.log(token);
        if(!!token){
            this.$store.dispatch('authentication/activeUser', token)
        }
        console.log(this.$store.state.authentication.user, " user")
        const id = this.$store.state.authentication.user.id
        this.$store.dispatch("fetchAds", id);
    },
    methods: {
        test(){
            const id = this.user.id
            console.log(id)
            this.$store.dispatch("fetchAds", id)
        }
    },
    //https://github.com/tymondesigns/jwt-auth/wiki/Creating-Tokens
    mounted(){
        axios.get('/api/user').then((res)=>{
            console.log(res.data)
        })
    }
};
</script>

<style lang="scss" scoped>

</style>