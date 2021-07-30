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
            <button @click="test" type="submit" class="button">Test</button>

    </div>
</template>

<script>
import axios from 'axios'
//
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
        },
        JWT() {
            return this.$store.getters['authentication/JWT']
        }
    },
    methods: {
        login() {
            this.$store.dispatch('authentication/loginUser', this.form)
        },
        test() {
            const config = {
                headers: 
                    {
                        'Authorization': 'Bearer ' + this.JWT.token,
                    }
                };
            axios.post('api/auth/me',
            null,
            config
            )
            .catch(function (error) {
                if (error.response) {
                    // Th//e request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.data);
                    console.log(error.response.status);
                    // console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    // console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    // console.log("Error", error.message);
                }
                console.log(error.config);
            })
            .then(response => {
                console.log("Test Response:", response.data)
            });
        },
    },
};
</script>

<style lang="scss" scoped>

</style>