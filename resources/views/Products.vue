<template>
  <div>
      <h2 class="title">Products </h2> 
    <div v-if="products">
    <div v-for="product in products" :key="product.id" class="test">
    <router-link :to="{name: 'ProductDetails', params: {id:product.id, product: product}}">
    <h1 class='title is-6'>{{product.name | capitalize}} by {{users[product.user_id].name}}</h1>
    </router-link>
    </div>
  </div>
  </div>
</template>
<script>
const default_layout = "default";

export default {
  data() {
    return {};
    },
  mounted(){  
  this.$store.dispatch('fetchUsers')
  this.$store.dispatch('fetchProducts')
  },
  computed: {
    products(){
        return this.$store.state.products //TODO refactor to getter!
    },
    users(){
        return this.$store.state.users
    },
  },
  methods: {
},
filters: {
  capitalize: function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  }
}
};
</script>
<style scoped>
.test h2{
  background: #f4f4f4;
  padding: 20px;
  border-radius: 10px;
  margin: 10px auto;
  max-width: 600px;
  color: #444;
  text-align: center;
}
.test h2:hover {
  background: #ddd;
}
.test a{
  text-decoration: none;
}
</style>