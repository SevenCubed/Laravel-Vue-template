import axios from "axios";
import router from '../../router'

export default {
    namespaced: true,

    state: {
        authenticated: false,
        token: localStorage.getItem('api_token') || '', //is this okay? state isn't immutable this way
        user: null,
    },
    getters: {
        authenticated(state) {
            return !!state.token
        },
        activeUser(state) {
            return state.user
        },
    },
    mutations: {
        loginUser(state, user) {
            state.authenticated = true;
            state.user = user;
            state.token = user.api_token;
        },
        logoutUser(state) {
            state.authenticated = false;
            state.user = null;
            state.token = ''
        },
        activeUser(state, user) {
            state.user = user;
            if(user == ''){
                state.authenticated = false;
                if(!!state.token){
                    localStorage.removeItem('api_token') //This is a clause to delete any outdated tokens.
                }
            }
        },
    },
    actions: {    
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
                console.log(response)
                // const token = response.data.api_token
                // console.log(token)
                // localStorage.setItem('api_token', token)
                commit('loginUser', response.data)
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
                    commit('loginUser', user)
                    router.push({ name: "Dashboard"})})
        },
        logoutUser( {commit, state}) {
            axios
            .post('api/auth/logout')
            .then(() => {                
                localStorage.removeItem('api_token')
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