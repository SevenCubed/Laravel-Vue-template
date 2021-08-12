<template>
<div class="content">
    <div ><h1 class="title">Add a new product</h1></div>
    <div class="">
        <label for="name">Name</label>
        <input type="text" placeholder="Name" v-model="form.name">
        <span class="is-size-7 has-text-danger" v-if="errors.name">*{{errors.name[0]}}</span>
    </div>
    <div class="">
        <label for="price">Price</label>
        <input type="number" placeholder="0" v-model="form.price" name="price">
        <span class="is-size-7 has-text-danger" v-if="errors.price">*{{errors.price[0]}}</span>
    </div>
    <div class="">
        <label for="description">Description</label>
        <textarea type="description" placeholder="???" v-model="form.description"></textarea>
        <span class="is-size-7 has-text-danger" v-if="errors.description">*{{errors.description[0]}}</span>
    </div>
    <div class="container">
        <TagInput @childUpdated="updateCategories" />
        <span class="is-size-7 has-text-danger" v-if="errors.categories">*{{errors.categories[0]}}</span>
        </div>
    <div>
    <input type="file" multiple @change="selectFile" />
    <span class="is-size-7 has-text-danger" v-if="errors.files">*{{errors.files[0]}}</span>
    </div>
    <div>
        <button @click.prevent="addProduct" class="button" type="submit">Add</button></div>
</div>
</template>

<script>
/*
TODO:
Layout
Multi image
Image preview?
*/

import TagInput from './TagInput.vue'
import { EventBus } from '../../js/eventBus'


export default {
    data() {
        return {
            form: {
                name: '',
                description: '',
                price: '',
                user: '',
                files: '',
                categories: [],
            },
        errors: {},
        selectedCategories: [],
        }
    },
    components: {
        TagInput,
    },
    computed: {
        user(){
            return this.$store.getters['authentication/activeUser']
        },
        categories() {
          return this.$store.getters.categories;
        },
    },
    methods:{
        updateCategories(updatedCategories){
            this.selectedCategories = updatedCategories
        },
        addProduct(){
            this.form.user = this.user.id;
            this.form.categories = this.selectedCategories;
            const categoryJSON = JSON.stringify({
                categories: this.selectedCategories
            });
            const data = new FormData();
            data.append('name', this.form.name)
            data.append('description', this.form.description)
            data.append('price', this.form.price)
            data.append('user', this.form.user)
            data.append('files', this.form.files)
            data.append('categories', categoryJSON)
            console.log(this.form)
            this.$store.dispatch('products/addProduct', data)
        },
        selectFile(event) {
            const file = event.target.files[0];
            const reader = new FileReader()
            if(event.target.files[0]['size'] < 2097152)
            {              
                this.form.files = file;
                
            }
            else{
                alert('File size can not be bigger than 2 MB')
            }
            // `files` is always an array because the file input may be in multiple mode
            //this.form.files = event.target.files[0];
        },
    },
    created(){
        EventBus.$on('errors', (data) => {
            console.log('Event Bus arrived:', data.data)
            this.errors = data.data.errors
        })
    }
}
</script>

<style lang="scss" scoped>

</style>