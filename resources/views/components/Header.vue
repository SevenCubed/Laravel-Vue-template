<template>
   <nav class="navbar is-dark is-fixed-top" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <!-- <a class="navbar-item" href="https://bulma.io">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a> -->

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <router-link to="/" class="navbar-item">
        Home
      </router-link>
      <router-link :to="{ name: 'Vuex Test' }" class="navbar-item">
        Vuex Test
      </router-link>
            <router-link :to="{ name: 'Questions' }" class="navbar-item">
        Questions
      </router-link>
                <router-link :to="{ name: 'Products' }" class="navbar-item">
        Products
      </router-link>
      <a class="navbar-item">If you get a 500 server error, check if you added the Controller to the namespace</a>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">
            About
          </a>
          <a class="navbar-item">
            Jobs
          </a>
          <a class="navbar-item">
            Contact
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            Report an issue
          </a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <div v-if="!authenticated">
            <router-link class="button is-primary" :to="{ name: 'Register' }">
              Register</router-link>
            <router-link class="button is-primary" :to="{ name: 'Login' }">
              Login
              </router-link></div>
              <div v-if="authenticated">
            <router-link class="button is-primary" :to="{ name: 'Dashboard' }">
              Dashboard</router-link>
              <button class="button is-primary" @click="logout">
              Logout
              </button>
              </div>

        </div>
      </div>
    </div>
  </div>
</nav>
</template>

<script setup>
export default{
      data(){
      return {}
      },
      computed: {
        authenticated() {
          return this.$store.getters['authentication/authenticated']
        },
      },
          methods: {
        logout() {
            this.$store.dispatch('authentication/logoutUser')
        }
    },
}
</script>

<style lang="scss" scoped>

</style>