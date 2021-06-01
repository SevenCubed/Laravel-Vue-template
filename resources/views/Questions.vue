<template>
  <div>
    <div v-for="question in questions" :key="question.id" class="test">
     <h2> {{question.title}}?</h2>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
export default {
  computed: {},
  data() {
    return {
      questions: [
        { title: "Vue Version", id: 1, details: "lorem" },
        { title: "CSS not working", id: 2, details: "lorem" },
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