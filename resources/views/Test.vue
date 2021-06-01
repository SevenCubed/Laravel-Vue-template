<template>
  <div>
    <div v-for="test in tests" :key="test.id" class="test">
        <router-link :to="{name: 'TestDetails', params: { id: test.id}}"><h2>{{test.title}}</h2></router-link>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
export default {
  computed: {},
  data() {
    return {
      message: "Hello",
      tests: [
        { title: "Test 1", id: 1, details: "lorem" },
        { title: "Test 2", id: 2, details: "lorem" },
        { title: "Test 3", id: 3, details: "lorem" },
      ],
    };
  },
  components: {},
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