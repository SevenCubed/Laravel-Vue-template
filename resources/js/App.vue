<template>
  <div id="main" class="has-background-white-ter">
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
  beforeCreate() {
    console.log(window.$cookies.get("JWT"))
    const cookieJWT = this.$cookies.get('JWT');
    if(!!cookieJWT){
      console.log("Before create:", cookieJWT.token);
      this.$store.dispatch('authentication/initUser', cookieJWT.token)
    }
  },
}

</script>

<style>
.mainbody{
  padding-top: 60px;
}
</style>