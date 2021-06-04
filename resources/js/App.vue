<template>
  <div id="main">
    <div id="nav">
      <router-link to="/">Home</router-link>
      <router-link :to="{ name: 'About' }">About</router-link>
            <router-link :to="{ name: 'Questions' }">Questions</router-link>

    </div>
    <router-view />
<Footer />
  </div>
</template>
<script>

import Footer from '../views/components/Footer.vue'

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
  }
}
</script>

<style>
/* See app.css */
</style>