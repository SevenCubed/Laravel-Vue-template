<template>
    <div>
<h1 class="title">Dashboard</h1>
    </div>
</template>

<script setup>

export default {
    data() {
        return{
            user: null,
        }    
    },
    mounted(){
        axios.get('/api/user').then((res)=>{
            this.user = res.data;
        })
    }
};
</script>

<style lang="scss" scoped>

</style>