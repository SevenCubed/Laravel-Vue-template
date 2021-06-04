<template>
  <div id="main">
    <Header />
    <div id="nav" class="section">
      <router-link to="/">Home</router-link>
      <router-link :to="{ name: 'About' }">About</router-link>
      <router-link :to="{ name: 'Questions' }">Questions</router-link>
    <router-view />
  </div>
      <Footer />

</div>
</template>
<script>

import Footer from '../views/components/Footer.vue'
import Header from '../views/components/Header.vue'

export default {
  // methods:{
  //   redirect(){
  //     this.$router.push({ name: 'Home'})
  //   },
  //   back(){
  //     this.$router.go(-1)
  //   },
  //   forward(){
  //     this.$router.go(+1)
  //   },
  // },
  components: {
    Footer,
    Header,
  }
}
</script>

<style>
.mainbody{
  padding-top: 60px;
}
</style>