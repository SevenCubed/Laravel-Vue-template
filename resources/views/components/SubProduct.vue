<template>
<div>
<h1 class='title is-6'>{{name}}</h1>
€{{product.price}}
<p>{{product.description}}</p>
</div>
</template>
<script>
export default {
    props: ['product'],
    computed: {
        name(){
            return this.product.name.charAt(0).toUpperCase() + this.product.name.slice(1)
        },

    },
}
</script>
