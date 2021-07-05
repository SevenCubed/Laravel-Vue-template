<template>
<div>
    <div><h1 class="title">Add a new product</h1></div>
    <div>
        <label for="name">Name</label>
        <span v-if="errors.name">{{errors.name[0]}}</span>
        <input type="text" placeholder="Name" v-model="form.name">
    </div>
    <div>
        <label for="price">Price</label>
        <input type="number" placeholder="0" v-model="form.price" name="price">
    </div>
    <div>
        <label for="description">Description</label>
                <span v-if="errors.description">{{errors.description[0]}}</span>
        <textarea type="description" placeholder="???" v-model="form.description"></textarea>
    </div>
    <div>
            <input type="file" @change="selectFile">
    </div>
    <div>
        <button @click.prevent="register" class="button" type="submit">Add</button></div>
    {{user}}
</div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                description: '',
                price: '',
                user: '',
                file: '',
            },
        errors: [],
        }
    },
    computed: {
        user(){
            return this.$store.state.authentication.user.id;
        }
    },
    methods:{
    register(){         
                    this.form.user = this.user;   
        console.log(this.form)
            this.$store.dispatch('products/addProduct', this.form)
            },
            selectFile(event) {
            // `files` is always an array because the file input may be in multiple mode
            this.form.file = event.target.files[0];
        }
    }
}
</script>

<style lang="scss" scoped>

</style>