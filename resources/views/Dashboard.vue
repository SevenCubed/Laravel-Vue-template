<template>
    <div>
<h1 class="title">Dashboard</h1>
<div class="button" @click="testNotifications()">TEST!</div>
<div class="title is-3">
Notifications!
</div>
<div v-if="notifications.length" class="block">
    <div  v-for="notification in notifications" :key="notification.id" class="has-text-left is-fullwidth">
        <div class="notification is-light is-small" :class="notification.data.type">
              <button class="delete" @click="markAsRead(notification.id)"></button>
                {{notification.data.message}}
        </div>
    </div>
    <div class="button block" @click="markAllAsRead()">Mark all as read.</div>
</div> 
<br> 
{{user.name}}
{{user.email}}
{{user.location}}
      <router-link :to="{ name: 'Add Product' }" class="navbar-item">
        Add New Product
      </router-link>
    <ol>
        <li>
            Checkmark for mail notification
        </li>
        <li>
            
        </li>
    </ol>
    <div v-if="ads.length && !isLoading">
        <div class="title is-3">
            Current ads
        </div>
            <div  v-for="ad in ads" :key="ad.id" class="columns has-text-left">
                <div class="column is-four-fifths ">
                <router-link class="is-clickable" tag="div"
                    :to="{
                        name: 'ProductDetails',
                        params: { id: ad.id, initProduct: ad }
                    }">
                        <b>{{ad.id}}</b> {{ad.name}}  €{{ad.price}}
                        <!-- spruce this up later -->
                </router-link>
                </div>
                <div class="column">
                <router-link :to="{name: 'Update Product', params: { id: ad.id }}">
                    <i class="fas fa-edit"></i>
                </router-link>
                </div>
                <i class="fas fa-trash-alt column is-clickable" @click="deleteModal(ad)"></i>            
            </div>
        <div class="modal" :class="{'is-active': showModalFlag}">
            <div class="modal-background">
            </div>
            <div class="modal-card">
                <header class="modal-card-head">
                </header>
                <section class="modal-card-body">
                    <p>Are you sure you wish to remove your advertisement for {{ ad.name }}? This process is irreversible.</p>
                </section>
                <footer class="modal-card-foot">
                <button class="button is-success" @click="deleteConfirm(ad.id)">Confirm</button>
                <button class="button" @click="deleteCancel">Cancel</button>
                </footer>
            </div>
        </div>
    </div>
    <div v-if="!ads.length && !isLoading">
        You are not currently selling anything! Have you considered doing so?
    </div>
        <div v-if="user.bids.length && !isLoading">
        <div class="title is-3">
            Ongoing bids
        </div>
        <div  v-for="bid in user.bids" :key="bid.id" class="columns has-text-left">
            <div class="column is-four-fifths ">
                    <b>{{bid.id}}</b> {{bid.product_id}}  €{{bid.amount}}
                    <!-- spruce this up later -->
            </div>
        </div>  
        <div class="modal" :class="{'is-active': showModalFlag}">
            <div class="modal-background">
            </div>
            <div class="modal-card">
                <header class="modal-card-head">
                </header>
                <section class="modal-card-body">
                    <p>Are you sure you wish to remove your advertisement for {{ ad.name }}? This process is irreversible.</p>
                </section>
                <footer class="modal-card-foot">
                <button class="button is-success" @click="deleteConfirm(ad.id)">Confirm</button>
                <button class="button" @click="deleteCancel">Cancel</button>
                </footer>
            </div>
        </div>
    </div>
    <div v-if="!ads.length && isLoading">
        <Spinner line-fg-color="#777777" size="medium" message=""/>
    </div>
    <div v-if="ads.length && isLoading">
        <!-- This shouldn't ever happen, but y'know -->
        Something went wrong, please refresh.
    </div>
</div>
</template>

<script setup>
import { EventBus } from '../js/eventBus'

import Spinner from 'vue-simple-spinner' //Custom package
import Alert from './components/Alert';

export default {
    data() {
        return{
            ads: false,
            showModalFlag: false,
            ad: "",
        }    
    },
    components: {
        Spinner,
    },
    computed: {
        user() {
            return this.$store.getters['authentication/activeUser']
        },
        isLoading () {
            return this.$store.getters.isLoading;
        },
        notifications() {
          return this.$store.getters['authentication/notifications']
        },
    },
    mounted() {
        const id = this.$store.state.authentication.user.id
        console.log("Attempting to fetch ads...")
        //could probably make this better by having the whole Current User be a special Resource with all the needed info
        this.$store.commit('loadingStatus', true)
            axios
            .post("api/users/ads", {'id': id})
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
                    console.log("Error", error.message);
                }
                console.log(error.config);
            })
            .then(response => {
                this.ads = response.data.data.products
                this.$store.commit('loadingStatus', false)
            });
    },
    methods: {
        deleteModal(ad) {
            this.ad = ad;
            this.showModalFlag = true;
        },
        deleteConfirm(id) {
            axios
            .delete(`api/products/${id}`)
            .then(response => {
                console.log(response)
                const i = this.ads.map(ad => ad.id).indexOf(id);
                this.ads.splice(i, 1)
                this.showModalFlag = false;
            })
        },
        deleteCancel() {
            this.showModalFlag = false;
            this.ad = "";
        },
        deleteAd(id){
            axios
            .delete(`api/products/${id}`)
            .then(response => {
                console.log(response)
                const i = this.ads.map(ad => ad.id).indexOf(id);
                this.ads.splice(i, 1)
            })
        },
        testNotifications(){
            axios
            .get('api/notifications/test')
            .then(response => {
                console.log(response)
                this.notifications = response.data;
            })
        },
        markAsRead(id){
            axios
            .post(`api/notifications/mark-as-read/${id}`)
            .then(response => {
                const i = this.notifications.map(notifications => notification.id).indexOf(id);
                this.notifications.splice(i, 1)
                //TODO: Make this go via store
            })
        },
        markAllAsRead(){
            axios
            .post('api/notifications/mark-all-as-read')
            .then(response => {
                console.log(response);
                this.notifications = [];
                //TODO: Make this go via store
            })
        },
    },
};
</script>

<style lang="scss" scoped>

</style>