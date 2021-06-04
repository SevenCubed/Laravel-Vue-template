<template>
 <div>
    <button class="button is-small" @click="redirect">Redirect</button>
    <button class="button is-small" @click="back">Back</button>
    <button class="button is-small" @click="forward">Go Forward</button>
</div>
</template>
<script>

export default {
  methods:{
    redirect(){
      this.$router.push({ name: 'Home'})
    },
    back(){
      this.$router.go(-1)
    },
    forward(){
      this.$router.go(+1)
    },
  },
}
</script>

<style>
/* See app.css */
</style>