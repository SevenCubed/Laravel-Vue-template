<template>
    <div>
        <div><h1 class="title">Login to your account</h1></div>
            <div>
        <label for="email">Your e-mail</label>
        <input type="email" placeholder="Email" v-model="form.email">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" placeholder="Password" v-model="form.password" name="password">
    </div>
    <div>
        <button @click="login" type="submit" class="button">Login</button>
        <!-- .prevent only necessary for <form> tags -->
    </div>
    </div>
</template>

<script>
  import axios from 'axios'

export default {
    data() {
        return{
            form: {
                email: '',
                password: ''
            },
            errors: []
        }
    },
    computed: {
        user() {
            return this.$store.getters['authentication/activeUser']
        }
    },
    methods: {
        login() {
            this.$store.dispatch('authentication/loginUser', this.form)
        }
    },
};
</script>

<style lang="scss" scoped>

</style>