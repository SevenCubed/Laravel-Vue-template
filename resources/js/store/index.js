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
        //https://dev.to/messerli90/build-an-advanced-search-and-filter-with-vuex-in-nuxt-3jn8
        //https://www.youtube.com/watch?v=OjS6SWS6G5c
        testlist: [],
        users: [],
        products: [],
        filteredProducts: [],
        categories: [],
        filters: {
            categories: [],
            price: [],
            user: [],
            search: '',
            order: 'default'
        },
        isLoading: false,
    },
    mutations: {
        // CR :: eigelijk SET je hier users en fetch je ze niet, dus SET_USERS zou in mijn optiek beter zijn
        fetchUsers(state, users) {
            return (state.users = users);
        },
        fetchProducts(state, products) {
            state.products = products;
            state.filteredProducts = products.products
        },
        fetchCategories(state, categories) {
            return (state.categories = categories);
        },
        loadingStatus(state, status) {
            state.isLoading = status
        },
        SET_FILTER_CATEGORY(state, category) {
            state.filters.categories = category //I'll improve this later for multiples
        },
        SET_FILTER_PRICE(state, price) { //I feel like I SHOULD be able to consolidate this with the category mutation, by just adding some kind of "payload type" parameter
            state.filters.price = price
        },
        SET_FILTER_SEARCH(state, search){
            state.filters.search = search
        },
        SET_FILTERS(state, filters) {
            state.filters = filters //Or I just update all the filters
        },
        FILTER_PRODUCTS(state) {
            state.filteredProducts = state.products.products;
            if (state.filters.categories.length) { //Filter categories by filtering the list based on if the products include the filtered categories
                state.filteredProducts = state.filteredProducts.filter(product => {
                    return state.filters.categories.includes(product.categories)
                });
            }
            if (state.filters.price.length) { //Filter prices by checking if the products are within any of the selected ranges. 
                let range = state.filters.price;
                if(range[1] == 1000){
                    range[1] = Infinity; //If the upper limit is set at the max, go to infinity and beyond
                }
                state.filteredProducts = state.filteredProducts.filter(product => {
                    // return state.filters.price.some(range => {
                    //     return product.price >= range[0] && product.price <= range[1]
                    // }) Old system when it was checkmarks and not a slider
                    return product.price >= range[0] && product.price <= range[1]
                });
            }
            if(state.filters.search !== ''){
                const search = state.filters.search.toLowerCase();
                state.filteredProducts = state.filteredProducts.filter(product => {
                    return (product.name !== null && product.name.toLowerCase().includes(search)) //Search in name..
                        || (product.description !== null && product.description.toLowerCase().includes(search)) //Or description..
                });
            }
            //Ordering
            if(state.filters.order == 'createdAtAsc'){
                const orderedProducts = state.filteredProducts
                orderedProducts.sort((a, b) => {
                    return new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
                })
            }
            else if(state.filters.order == 'createdAtDesc') {
                const orderedProducts = state.filteredProducts
                orderedProducts.sort((a, b) => {
                    return new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
                })
            }
        },
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        users: state => {
            return state.users;
        },
        products: state => {
            return state.products;
        },
        filteredProducts: state => {
            return state.filteredProducts;
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
                .catch(function (error) {
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
        fetchProducts({ commit, state }) {
            commit('loadingStatus', true)
            const products = axios
                .get("api/products")
                .catch(function (error) {
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
                .catch(function (error) {
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
        },
        async filterCategory({ commit, dispatch }, category) {
            await commit('SET_FILTER_CATEGORY', category)
            dispatch('filterProducts')
        },
        async filterPrice({ commit, dispatch }, price) {
            await commit('SET_FILTER_PRICE', price)
            dispatch('filterProducts')
        },        
        async filterSearch({commit, dispatch}, search) {
            await commit('SET_FILTER_SEARCH', search)
            dispatch('filterProducts')
        },
        async updateFilters({ commit, dispatch }, filters) {
            await commit('SET_FILTERS', filters)
            dispatch('filterProducts')
        },        
        async filterProducts({ commit }) {
            await commit('FILTER_PRODUCTS')
        },

    }
});
