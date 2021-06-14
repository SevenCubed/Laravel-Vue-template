import axios from "axios";

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
        user(state) {
            return state.user
        },
    },
    mutations: {
        setAuthenticated(state, value) {
            state.authenticated = value
        },
        setUser(state, value) {
            state.user = value
        },
    },
    actions: {    
        async signIn({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login', credentials) //problem

            return dispatch('me')
        },
        async signOut({ dispatch }) {
            await axios.post('/logout')

            return dispatch('me')
        },

        me({ commit }) {

            return axios.get('/api/user').then((response) => {

                commit('setAuthenticated', true)
                commit('setUser', response.data)
            }).catch(() => {
                commit('setAuthenticated', false)
                commit('setUser', null)
            })
        }
    },
}