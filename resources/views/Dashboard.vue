<template>
    <div>
<h1 class="title">Dashboard</h1>
{{user.name}}
{{user.email}}
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
    // mounted(){
    //     axios.get('/api/user').then((res)=>{
    //         this.user = res.data;
    //     })
    // }
};
</script>

<style lang="scss" scoped>

</style>