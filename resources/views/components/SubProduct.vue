<template>
<div v-if="product">
<h1 class='title is-6'>{{name}}</h1>
€{{product.price}}
<p>{{product.description}}</p>
<p>{{product.user.name}}</p>
</div>
</template>
<script>
export default {
    props: ['initProduct'],
    data() {
        return {
            product: this.initProduct,
        }
    },
    computed: {
        name(){
            return this.product.name.charAt(0).toUpperCase() + this.product.name.slice(1)
        },
    },
    created(){
        if (this.product === undefined){
            axios.get(`api/products/${this.$route.params.id}`).then((res)=>{
            this.product = res.data.data
            console.log('product was undefined, fetching data directly')
        })
        }
    }

}
</script>
