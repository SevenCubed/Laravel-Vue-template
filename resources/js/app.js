require("./bootstrap");
import Vue from "vue";

//Main pages
import App from "./App.vue";

//Import store
import store from "./store";

//Import router
import router from "./router";

//Import Bulma CSS
import "./../../node_modules/Bulma/CSS/bulma.css";

//Axios stuff for Sanctum auth
import axios from 'axios';
axios.defaults.withCredentials = true;

new Vue({
    el: "#app",
    store,
    router,
    render: (h) => h(App),
});
