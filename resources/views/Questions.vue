<template>
  <div>
    <div v-if!="questions">No questions</div>
    <div v-if="questions">
    <div v-for="question in questions" :key="question.id" class="test">
     <h2> {{question.title}}?</h2>
     <!-- Hot refresh? 
     Watch options?
     Devtools mutations?
     List of installed packages?
     Separate store files?
     action: ()=>{} vs action(){} syntax?
     {commit}?-->
    </div>
  </div>
  </div>
</template>
<script>
const default_layout = "default";
import {mapGetters} from 'vuex';

export default {
  computed: {},
  data() {
    return {
      questions: [],
    };
  },
  mounted(){
  this.$store.dispatch('fetchUsers')
  },
  components: {
    ...mapGetters([
      'users'
    ])
  },
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