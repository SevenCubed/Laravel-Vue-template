import axios from "axios";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        testlist: [
            {name:'Orc Thrower', max: 2},
            {name:'Orc Blitzer', max: 4},
            {name:'Orc Lineman', max: 12},
            {name:'Goblin Lineman', max: 12},
            {name:'Troll', max: 1},
          ],
          todos: [

          ],
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
        }
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
            return state.posts;
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
            axios.get('api/users')
            .then(res=> {
                commit('fetchUsers', res.data)
            })
        }
    }
});
