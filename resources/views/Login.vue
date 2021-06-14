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
        <button @click.prevent="loginUser" type="submit" class="button">Login</button>
    </div>
    </div>
</template>

<script>

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
    methods: {
        loginUser(){ //Should probably refactor this into Vuex
            axios.post('api/login', this.form)
            .then((res) => {console.log(res)})
            .catch((error) => {this.errors = error.response.data.errors;})
        }
    },
};
</script>

<style lang="scss" scoped>

</style>