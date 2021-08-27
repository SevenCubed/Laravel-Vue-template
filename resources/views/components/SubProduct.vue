<template>
<div>

    <div v-if="isLoading"><Spinner line-fg-color="#777777" size="medium" message="Loading product..."/></div>
    <div v-else class="container">
        <nav class="breadcrumb">
            <ul>
                <li><router-link :to="{ name: 'Products' }">Products</router-link></li>
                <li><router-link class="is-capitalized" :to="{ name: 'Products' }">{{product.categories}}</router-link></li>
                <li class="is-active is-capitalized"><a href="#">{{product.name}}</a></li>
            </ul>
        </nav>
        <div class=" columns is-1 is-centered ">
            <div class="column is-three-quarters">
                <div class="box">
                    <h1 class='title is-5 is-capitalized'>{{product.name}}</h1>
                    <div v-if="product.user.id == currentUser.id">This is YOUR ad!
                        <router-link class="is-capitalized" :to="{name: 'Update Product', params: { id: product.id }}">Edit?</router-link>
                    </div>
                    <p class="has-text-grey is-size-7"><i class="fas fa-clock"></i> since {{product.created_at}}</p>
                    €{{product.price}}
                    <figure class="image is-4by3">
                    <img :src="product.card_image" alt="Placeholder image">
                    </figure>
                    <div class="section has-text-left">
                        <p class="title is-6">Description:</p>
                        <p class="is-size-7">{{product.description}}</p>
                        <p class="is-size-7">Show more ads</p>
                    </div>
                </div>
            </div>
            <div class="column is-one-quarter">
                <div class="box">
                    <p class="title is-6">{{product.user.name}}</p>
                    <p class="is-7">{{userActive}}</p>
                    <p class="is-7">{{product.user.location}}</p>
                    <p class="is-7">This is where I put the link to filter all ads for this user, and possibly data about their verification status, location and preferred payment methods.
                    </p>
                </div>
                <!-- Bids - this should probably be a component, it grew waaaay more bloated than I expected. Too bad! -->
                <div class="box">
                    <!-- User hasnt bid yet -->
                    <div class="block" v-if="!userHasBid">
                        <div class="level">
                            <div class="level-left">
                                <div class="level-item title is-6">
                                    Bids
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    (From €{{product.price}})
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control has-icons-left">
                            <input class="input" type="number" placeholder="" v-model="placedBid" :class="{'is-danger' : errors.bid, 'is-success' : isSuccess}">
                            <span v-if="errors.bid" class="has-text-danger is-size-7">{{errors.bid}}</span>
                            <span class="icon is-small is-left">
                                <i class="fas fa-euro-sign"></i>
                            </span>
                            </div>
                        </div>
                        <div class="field">
                            <button class="button is-fullwidth" @click="placeBid(placedBid)" :class="{'is-loading' : isBidding, 'is-success is-static' : isSuccess}">Place Bid</button>
                            <span v-if="successes.bid" class="has-text-success is-size-7">{{successes.bid}}</span>
                        </div>
                    </div>
                    <!-- User has bid -->
                    <div class="block" v-if="userHasBid">
                        <div class="title is-6 has-text-left">
                            You have an ongoing bid
                        </div>
                        <div class="field">
                            <div class="control has-icons-left">
                            <input :disabled="!editOpen || isSuccess" class="input" type="number" placeholder="" v-model="placedBid" :class="{'is-danger' : errors.bid, 'is-success' : isSuccess}">
                            <span v-if="errors.bid" class="has-text-danger is-size-7">{{errors.bid}}</span>
                            <span class="icon is-small is-left">
                                <i class="fas fa-euro-sign"></i>
                            </span>
                            </div>
                        </div>
                        <!-- Delete/Edit buttons -->
                        <div v-if="!editOpen" class="field columns">
                            <div class="column">
                            <button class="button is-fullwidth is-warning is-light" @click="toggleEdit()" :class="{'is-loading' : isBidding, 'is-success is-static' : isSuccess}">Edit</button>
                            </div>
                            <div class="column">
                            <button class="button is-fullwidth is-danger is-light" @click="removeBid()" :class="{'is-loading' : isBidding, 'is-success is-static' : isSuccess}">Withdraw</button>
                            </div>
                        </div>
                        <div v-if="editOpen" class="field columns">
                            <div class="column">
                                <button class="button is-fullwidth is-warning is-light" @click="updateBid()" :class="{'is-loading' : isBidding, 'is-success is-static' : isSuccess}">Edit Bid</button>
                            </div>
                        </div>
                        <span v-if="successes.bid" class="has-text-success is-size-7">{{successes.bid}}</span>
                    </div>
                    <!-- All Bids -->
                    <div class="block" v-if="product.bids.length">
                        <div class="columns is-multiline is-size-7" v-for="bid in orderedBids" :key="bid.id" :class="{'has-text-info': currentUser.id == bid.user_id}">
                                <div class="column is-half has-text-weight-semibold has-text-left">
                                    {{bid.user}}
                                </div>
                                <div class="column is-one-quarter has-text-weight-semibold">
                                    €{{bid.amount}}
                                </div>
                                <div class="column is-one-quarter">
                                    {{bid.timestamp}} 
                                </div>
                        </div>
                    </div>
                    <div class="block is-italic" v-else>
                        No bids yet!
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
</template>
<script>

import Spinner from 'vue-simple-spinner' //Custom package

export default {
    components: {
        Spinner,
    },
    props: ['initProduct'],
    data() {
        return {
            product: this.initProduct,
            placedBid: '', 
            errors: { 
                bid: '',
            },
            successes: {
                bid: '',
            },
            isBidding: false,
            isSuccess: false,
            editOpen: false,
        }
    },
    computed: {
        //TODO Add Geodistance measurement
        currentUser() {
            return this.$store.getters['authentication/activeUser'];
        },
        isLoading () {
            return this.$store.getters.isLoading;
        },
        userHasBid() {
            return this.product.bids.map(bid => bid.user_id).includes(this.currentUser.id) //Extract all the user_ids from the bids array, then check if the current user matches
        },
        userActive () {
            const user = new Date(this.product.user.created_at)
            const current = new Date();
            let diff = Math.floor((current-user)/(1000*60*60*24)) //milli to secs, secs to mins, mins to hours, hours to days
            return `Active for ${diff} days.`
        },
        orderedBids () {
            return this.product.bids.sort((a, b) => {
                return b.amount - a.amount
            })
        },
    },
    methods: {
        placeBid(bid) {
            this.successes.bid = '';
            this.isBidding = true;
            if(bid < this.product.price){
                this.errors.bid = "Your bid is too low.";
                this.isBidding = false;
            }
            else {
                const data = new FormData();
                data.append('amount', this.placedBid)
                data.append('product_id', this.product.id)
                data.append('user_id', this.currentUser.id)
                axios.post('api/bids', data)
                .then(response => {
                console.log(response)
                this.errors.bid = '';
                this.isBidding = false;
                this.isSuccess = true;
                this.successes.bid = response.data.message
                this.product.bids.push(response.data.new_bid)
                })
            }
        },
        removeBid() {
            this.isBidding = true;
            const i = this.product.bids.map(bid => bid.user_id).indexOf(this.currentUser.id);
            const withdrawnBid = this.product.bids[i].id
            //get the correct bid from the bids list, then get the actual id to plug it into axios
            axios.delete(`api/bids/${withdrawnBid}`)
            .then(response => {
                console.log(response)
                this.isBidding = false;
                this.isSuccess = true;
                this.product.bids.splice(i, 1)
                this.successes.bid = response.data;
            })
        },
        updateBid() {
             if(this.placedBid < this.product.price){
                this.errors.bid = "Your bid is too low.";
                this.isBidding = false;
            }
            else {
                this.isBidding = true;
                const data = new FormData();
                data.append('amount', this.placedBid)
                data.append('_method', 'PUT')
                const i = this.product.bids.map(bid => bid.user_id).indexOf(this.currentUser.id);
                const updatedBid = this.product.bids[i].id
                axios.post(`api/bids/${updatedBid}`, data) //Same as with product, has to be post + formdata or a 404 is thrown.
                    .then(response => {
                    console.log(response)
                    this.errors.bid = '';
                    this.isBidding = false;
                    // this.editOpen = false;
                    this.isSuccess = true;
                    this.product.bids[i].amount = this.placedBid
                    this.successes.bid = response.data;
                })
            }
        },
        toggleEdit() {
            if(!this.editOpen) {
            const i = this.product.bids.map(bid => bid.user_id).indexOf(this.currentUser.id)
            this.placedBid = this.product.bids[i].amount
            }
            this.editOpen = !this.editOpen;
        },
    },
    created(){
        if (this.product === undefined){
            this.$store.commit('loadingStatus', true)
            axios.get(`api/products/${this.$route.params.id}`).then((res)=>{
                this.product = res.data
                this.$store.commit('loadingStatus', false)
                console.log('product was undefined, fetching data directly:', res.data)
            })
        }
    }

}
</script>
