import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        testlist: [],
          todos: [],
          users: [],
          products: [],
    },
    mutations: {
        addPlayer: (state, payload) => {
            state.testlist.forEach( player => {
                player.max+=payload
            })
            return testlist
        },
        setTodos: (state, todos) => (state.todos = todos),
        addTodo: (state, todo) => state.todos.unshift(todo),

        fetchUsers(state, users) {
            return state.users = users;
        },
        fetchProducts(state, products) {
            return state.products = products;
        },
    },
    getters: {
            changeTest: state => {
                const changeTest = state.testlist.map( player => {
                    return {
                        name: '**'+ player.name + '**',
                        max: player.max /2
                    }
                });
                return changeTest;
        },
        users: state => {
            return state.users;
        }
    },
    actions: {
        addPlayer: (context, payload) => {
           setTimeout(function(){
               context.commit('addPlayer', payload);
           },2000) 
        },
        async fetchTodos() {
            const res = await axios.get(
                'https://jsonplaceholder.typicode.com/todos'
            )
            console.log(res.data);
            this.commit('setTodos', res.data);
        },
        async addTodo({ commit }, title) {
            const res = await axios.post(
                'https://jsonplaceholder.typicode.com/todos', {title, completed:false}
            );
            commit('addTodo', res.data);
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
            const res = axios.get('api/products')
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
            .then(res => {
                commit('fetchProducts', res.data)
            })
        }
    }
});
