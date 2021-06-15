import axios from "axios";
import router from '../../router'

export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: null
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        activeUser(state) {
            return state.user
        },
    },
    mutations: {
        loginUser(state, user) {
            state.authenticated = true;
            state.user = user;
        },
        logoutUser(state) {
            state.authenticated = false;
            state.user = null;
        },
    },
    actions: {    
        loginUser( {commit, state}, user ) {
            axios
            .post('api/login',{
            email: user.email,
            password: user.password
            })
            .then(response => {
                console.log(response.data)
                commit('loginUser', response.data)
                router.push({ name: 'Dashboard'})
            })
        },
        registerUser( {commit}, user) {
                axios.post('api/register', user)
                .catch((error) =>  this.errors = error.response.data)
                .then(() => { //currently doesn't care about errors, that's a problem
                    commit('loginUser', user)
                    router.push({ name: "Dashboard"})})
        },
        logoutUser( {commit}) {
            axios
            .post('api/logout')
            .then(() => {
                commit('logoutUser')
                router.push({ name: 'Login'})
            })
        }
    }
}