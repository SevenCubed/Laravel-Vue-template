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
    },
    mutations: {
        fetchUsers(state, users) {
            return state.users = users;
        },
        fetchProducts(state, products) {
            return state.products = products;
        },

    },
    getters: {
        users: state => {
            return state.users;
        },
        products: state => {
            return state.products
        },
    },
    actions: {
        async fetchTodos() {
            const res = await axios.get(
                'https://jsonplaceholder.typicode.com/todos'
            )
            console.log(res.data);
            this.commit('setTodos', res.data);
        },
        fetchUsers({commit}) {
            const res = axios.get('api/users')
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
                  console.log('Error', error.message);
                }
                console.log(error.config);
              })
            .then(res=> {
                commit('fetchUsers', res.data)
            })
        },
        fetchProducts({commit}) {
            const products = axios.get('api/products')
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
                  console.log('Error', error.message);
                }
                console.log(error.config);
              })
            .then(products => {
                console.log(products.data.data)
                commit('fetchProducts', products.data.data)
            })
        }
    }
});
