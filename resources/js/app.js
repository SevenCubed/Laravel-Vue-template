require("./bootstrap");
import Vue from "vue";

//Main pages
import App from "./App.vue";

//Because I call for a cookie inside the initial state, I have to import this before the store
import VueCookies from 'vue-cookies';

//Import store, before router because see above
import store from "./store";

//Import router
import router from "./router";

//Import Bulma CSS
import "./../../node_modules/Bulma/CSS/bulma.css";
import "./../../node_modules/@creativebulma/bulma-badge/dist/bulma-badge.css"

//Axios stuff for Sanctum auth
import axios from 'axios';
axios.defaults.withCredentials = true;

Vue.use(VueCookies);

new Vue({
    el: "#app",
    store,
    router,
    render: (h) => h(App),
});
