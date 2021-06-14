<template>
  <div>
    <div class="add">
    <form @submit="submitForm" action="">
        <input type="text" v-model="form.name" placeholder="Input name...">
        <input type="text" v-model="form.email" placeholder="Input email...">
        <input type="submit" value="Submit">
    </form>
    {{form}}
  </div>
    <div v-if="users">
    <div v-for="user in users" :key="user.id" class="test">
     <h2> {{user.name}}</h2>
<!--
x  When displaying data from server, compute from state data or from getter? Getters, don't modify the state from a component
x  How to inject data into a Model view? -> Use a Resource
x  mass import components for the router? It's possible
x  What's best for authentication? Sanctum +vuex
 -->
    </div>
  </div>
  </div>
</template>
<script>
const default_layout = "default";
import {mapGetters} from 'vuex';

export default {
  data() {
    return {    
      form:{
                name: '',
                email: '',
                password: '123',
           } 
          };
  },
  mounted(){
  this.$store.dispatch('fetchUsers')
  },
  computed: {
    ...mapGetters([
      'users'
    ])
  },
  methods: {
            submitForm(){            
            console.log(this.form)
            axios.post('api/users/store', this.form)
            .then((res) => {
                     //Perform Success Action
                 })
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
              }).finally(() => {
console.log('Axios post request succesful, if it still doesn\'t work you can start blaming Laravel.')                 });        }
  }
};
</script>
<style scoped>
.test h2{
  background: #f4f4f4;
  padding: 20px;
  border-radius: 10px;
  margin: 10px auto;
  max-width: 600px;
  color: #444;
  text-align: center;
}
.test h2:hover {
  background: #ddd;
}
.test a{
  text-decoration: none;
}
</style>