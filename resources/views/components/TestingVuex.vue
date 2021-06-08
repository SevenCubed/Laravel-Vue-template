<template>
    <div>
        <h3 class="title">Test List</h3>
        <button @click="addPlayer(2)">Add players</button>
                <button @click="fetchTodos()">Testing</button>

        <ul>
            <li v-for="player in testlist">
                <span class="name">{{player.name}}</span>
                <span class="max">{{player.max}}</span>
                </li>
        </ul>
        <h3 class="title">Testing Todo List</h3>
        <AddTodo />
        <ul> <li v-for="todo in todos">{{todo.title}}</li>
               </ul>
    </div>
</template>

<script setup>
import {mapActions} from "vuex";
import {mapGetters} from "vuex";
import AddTodo from "./AddTodo.vue";

export default {
    computed: {
        testlist(){
            return this.$store.state.testlist;
        },
        todos(){
          return this.$store.state.todos;  
        },
        ...mapGetters([
            'changeTest',
        ])
    },
    methods:{
        ...mapActions([
            'addPlayer',
            'fetchTodos'
        ])
    },
    components:{
        AddTodo,
    }
}
</script>
<style lang="scss" scoped>

</style>