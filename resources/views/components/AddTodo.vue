<template>
    <div>
<h3 class="title is-5">Add Todo</h3>
<div class="add">
    <form @submit="onSubmit" action="">
        <input type="text" v-model="title" placeholder="Add Todo...">
        <input type="submit" value="Submit">
    </form>
</div>
    </div>
</template>

<script setup>
import { mapActions } from 'vuex';
export default {
    data() {
        return {
            title: '',
        }
    },
    methods:{
        ...mapActions([
            'addTodo'
        ]),
        onSubmit(e){
            e.preventDefault();
            this.addTodo(this.title)
        }
    }
};
</script>

<style lang="scss" scoped>

</style>