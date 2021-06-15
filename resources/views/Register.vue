<template>
<div>
    <div><h1 class="title">Register an account</h1></div>
    <div>
        <label for="name">Name</label>
        <span v-if="errors.name">{{errors.name[0]}}</span>
        <input type="text" placeholder="Name" v-model="form.name">
    </div>
    <div>
        <label for="email">Your e-mail</label>
        <input type="email" placeholder="Email" v-model="form.email">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" placeholder="Password" v-model="form.password" name="password">
    </div>
    <div><button @click.prevent="register" class="button" type="submit">Register</button></div>
</div>
</template>

<script setup>
export default {
data() {
    return {
        form: {
            name: '',
            email: '',
            password: '',
        },
        errors: [],
    }
},
methods:{
    register(){
            this.$store.dispatch('authentication/registerUser', this.form)

        }
}
}
</script>

<style lang="scss" scoped>

</style>