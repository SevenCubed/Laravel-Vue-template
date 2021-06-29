<template>
  <div id="main">
    <Header />
    <div id="nav" class="section">
    <router-view />
  </div>
      <Footer />

</div>
</template>
<script>

import Footer from '../views/components/Footer.vue'
import Header from '../views/components/Header.vue'
//import TestingVuex from './components/TestingVuex.vue';

export default {
  data(){
    return{

    }
  },
  components: {
    Footer,
    Header,
  },
  created() {
    const token = localStorage.getItem('token');
    console.log(token);
    this.$store.dispatch('authentication/activeUser', token)
  },
}

</script>

<style>
.mainbody{
  padding-top: 60px;
}
</style>