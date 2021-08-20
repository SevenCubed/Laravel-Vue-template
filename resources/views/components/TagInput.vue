<template>
  <div class='tag-input'>
    <div v-for='(tag, index) in tags' :key='tag' class='tag-input__tag'>
      <span @click='removeTag(index)'>x</span>
      {{ tag }}
    </div>
    <input type='text' 
    placeholder="Enter a Tag" 
    class='tag-input__text'
    @keydown.enter='addTag' 
    @keydown.188='addTag'
    @keydown.delete='removeLastTag'
    list="categories"
    />
    <datalist id="categories">
      <option v-for="category in categories" >{{category.name}}</option>
    </datalist>
  </div>
</template>
<script>

/*
TODO:
Add clear indication a given input is invalid.
see: https://www.jotform.com/blog/html5-datalists-what-you-need-to-know-78024/
//https://github.com/shentao/vue-multiselect
*/
export default {
  props: ['startingTags'],
  data () {
    return {
      tags: this.startingTags || [],
      selectedCategories: [],
    }
  },
  methods: {
      addTag(event){
        event.preventDefault();
        let tag = event.target.value.trim();
        if (tag.length > 0){
          const catIndex = (this.categories.findIndex((category) => category.name.toLowerCase() == tag.toLowerCase()))+1; //The database indices start at 1, not 0
          console.log(catIndex);
          if(catIndex > 0){
            if(!this.selectedCategories.includes(catIndex)){
              this.tags.push(tag);
              this.selectedCategories.push(catIndex);
            }
          }
          event.target.value = '';
          this.updateParent();
        }  
      },
      removeTag(index){
        this.tags.splice(index, 1)
        this.selectedCategories.splice(index, 1)
        this.updateParent();
      },
      removeLastTag(event) {
        if (event.target.value.length === 0) {
          this.removeTag(this.tags.length - 1)
        }
      },
      updateParent(){
        this.$emit('childUpdated', this.selectedCategories)
      },
  },
  mounted() {
    console.log("Starting Tags:", this.tags)
    if(!this.categories.length){
      console.log('Categories empty. Fetching...')
      this.$store.dispatch("fetchCategories");
    }
  },

  computed: {
      categories() {
          return this.$store.getters.categories;
      },
  },
}
</script>
<style scoped>
.tag-input {
  width: 100%;
  border: 1px solid #eee;
  font-size: 0.9em;
  height: 50px;
  box-sizing: border-box;
  padding: 0 10px;
}

.tag-input__tag {
  height: 30px;
  float: left;
  margin-right: 10px;
  background-color: #eee;
  margin-top: 10px;
  line-height: 30px;
  padding: 0 5px;
  border-radius: 5px;
}

.tag-input__tag > span {
  cursor: pointer;
  opacity: 0.75;
}

.tag-input__text {
  border: none;
  outline: none;
  font-size: 0.9em;
  line-height: 50px;
  background: none;
}
</style>