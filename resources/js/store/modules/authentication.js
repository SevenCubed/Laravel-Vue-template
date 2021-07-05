import axios from "axios";
import router from '../../router'

export default {
    namespaced: true,

    state: {
        authenticated: false,
        token: localStorage.getItem('token') || '', //is this okay? state isn't immutable this way
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
            state.token = user.token;
        },
        logoutUser(state) {
            state.authenticated = false;
            state.user = null;
            state.token = ''
        },
        activeUser(state, user) {
            state.user = user;
        },
    },
    actions: {    
        loginUser( {commit, state}, user ) {
            axios
            .post('api/login',{
            email: user.email,
            password: user.password
            })
            .catch((error) =>  this.errors = error.response.data)
            .then(response => {
                console.log(response.data)
                const token = response.data.token
                localStorage.setItem('token', token)
                commit('loginUser', response.data)
                router.push({ name: 'Dashboard'})

            })
        },
        registerUser( {commit, state}, user) {
                axios.post('api/register', user)
                .catch((error) =>  this.errors = error.response.data)
                .then(response => { //currently doesn't care about errors, that's a problem\
                    console.log(response)
                    const token = response.data.token
                    localStorage.setItem('token', token)
                    commit('loginUser', user)
                    router.push({ name: "Dashboard"})})
        },
        logoutUser( {commit, state}) {
            axios
            .post('api/logout')
            .then(() => {                
                localStorage.removeItem('token')
                commit('logoutUser')
                router.push({ name: 'Home'})
            })
        },
        activeUser( {commit}, token ) {
            axios
            .post('api/activeUser',  {'token':  token})
            .catch((error) =>  this.errors = error.response.data)
            .then(response => { 
                console.log(response.data)
                commit('activeUser', response.data)
            })
        },
}}