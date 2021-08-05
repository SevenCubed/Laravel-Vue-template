import axios from "axios";
import router from '../../router'

export default {
    namespaced: true,

    state: {
        authenticated: !!window.$cookies.get("JWT"),
        user: null,
        JWT: null,
    },
    getters: {
        authenticated(state) {
            return !!state.authenticated
        },
        activeUser(state) {
            return state.user
        },
        JWT(state) {
            return state.JWT
        },
    },
    mutations: {
        LOGIN_USER(state, JWT) {
            state.JWT = JWT;
            state.authenticated = true;
            console.log('Authentication mutation:', state.authenticated, state.JWT)
        },
        SET_JWT(state, JWT) {
            state.JWT = JWT;
            console.log("Setting initial JWT");
        },
        SET_USER(state, user) {
            state.user = user;
            console.log('User: ', user)
        },
        logoutUser(state) {
            state.authenticated = false;
            state.user = null;
        },
        activeUser(state, user) {
            state.user = user;
            if(user == ''){
                state.authenticated = false;
                if(!!state.token){
                    // localStorage.removeItem('api_token') //This is a clause to delete any outdated tokens.
                }
            }
        },
    },
    actions: {
        initUser( {commit}, JWT ) {
            const config =
            {
                headers: 
                    {
                        'Authorization': 'Bearer ' + JWT.token,
                    }
            };
            axios
            .post('api/auth/me',
            null,
            config
            )
            .then(response => {
                commit('SET_USER', response.data)
            });
        }, 
        loginUser( {commit, state}, user ) {
            axios
            .post('api/auth/login',{
            email: user.email,
            password: user.password
            })
            .catch(function (error) {
                console.log("ERROR!")
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log("Error", error.message);
                }
                console.log(error.config);
            })
            .then(response => {
                console.log("Login res:", response.data)
                const JWT = {
                    token: response.data.access_token,
                    expiry: response.data.expires_in
                };
                window.$cookies.set("JWT", JWT);
                commit('LOGIN_USER', JWT)
                router.push({ name: 'Dashboard'})
            })
        },
        registerUser( {commit, state}, user) {
                axios.post('api/register', user)
                .catch((error) =>  this.errors = error.response.data)
                .then(response => { //currently doesn't care about errors, that's a problem\
                    console.log(response)
                    const token = response
                    localStorage.setItem('api_token', token)
                    commit('SET_USER', user)
                    router.push({ name: "Dashboard"})})
        },
        logoutUser( {commit, state}) {
            axios
            .post('api/auth/logout')
            .then(() => {                
                window.$cookies.remove("JWT");
                commit('logoutUser')
                router.push({ name: 'Home'})
            })
        },
        activeUser( {commit}, token ) {
            axios
            .post('api/activeUser',  {'token':  token})
            .catch((error) =>  { this.errors = error.response.data
            })
            .then(response => { 
                commit('activeUser', response.data)
            })
        },
}}