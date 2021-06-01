<template>
  <div id="main">
    <div id="nav">
      <router-link to="/">Home</router-link>
      <router-link :to="{ name: 'About' }">About</router-link>
            <router-link :to="{ name: 'Questions' }">Questions</router-link>

    </div>
    <button @click="redirect">Redirect</button>
    <button @click="back">Back</button>
    <button @click="forward">Go Forward</button>
    <router-view />
  </div>
</template>
<script>
export default {
  methods:{
    redirect(){},
    back(){
      this.$router.go(-1)
    },
    forward(){},
  }
}
</script>

<style>
/* See app.css */
</style>