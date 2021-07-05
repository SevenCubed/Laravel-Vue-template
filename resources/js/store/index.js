import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";
import authentication from "./modules/authentication";
import products from "./modules/products";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authentication,
        products
    },
    state: {
        testlist: [],
        todos: [],
        users: [],
        products: [],
        categories: [],
        isLoading: false,
    },
    mutations: {
        // CR :: eigelijk SET je hier users en fetch je ze niet, dus SET_USERS zou in mijn optiek beter zijn
        fetchUsers(state, users) {
            return (state.users = users);
        },
        fetchProducts(state, products) {
            return (state.products = products);
        },
        fetchCategories(state, categories) {
            return (state.categories = categories);
        },
        loadingStatus (state, status) {
            state.isLoading = status
        },
    },
    getters: {
        isLoading (state) {
            return state.isLoading;
        },
        users: state => {
            return state.users;
        },
        products: state => {
            return state.products;
        },
        categories: state => {
            return state.categories;
        },
    },
    actions: {
        fetchUsers({ commit }) {
            // CR :: je hoeft het niet in een variabelen te zetten
            const res = axios
                .get("api/users")
                // CR :: .then komt voor .catch
                .catch(function(error) {
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
                .then(res => {
                    commit("fetchUsers", res.data);
                });
        },
        fetchProducts({ commit }) {
            commit('loadingStatus', true)
            const products = axios
                .get("api/products")
                .catch(function(error) {
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
                .then(products => {
                    console.log(products.data.data);
                    commit("fetchProducts", products.data.data);
                    commit('loadingStatus', false)
                });
        },
        fetchCategories({ commit }) { //I imagine an actual published commerce website would just write these out in HTML, since they have all of them from the get-go
                axios
                .get("api/categories")
                .catch(function(error) {
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
                    commit("fetchCategories", response.data);
                });
        }
    }
});
