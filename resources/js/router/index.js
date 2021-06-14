import Vue from "vue";
import VueRouter from "vue-router";
import Questions from "../../views/Questions.vue";
import NotFound from "../../views/NotFound.vue";
import Products from "../../views/Products.vue";
import SubProduct from "../../views/components/SubProduct.vue";
import TestingVuex from "../../views/components/TestingVuex.vue";
import Register from "../../views/Register.vue";
import Login from "../../views/Login.vue";
import Dashboard from "../../views/Dashboard.vue";



Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/"
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
        },
        {
            path: "/register",
            name: "Register",
            component: Register,
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
        },
        {
            path: "/vuextest",
            name: "Vuex Test",
            component: TestingVuex,
            props: true,
        },
        {
            path: "/questions",
            name: "Questions",
            component: Questions
        },
        {
            path: "/products",
            name: "Products",
            component: Products
        },
        {
            path: "/products/:id",
            name: 'ProductDetails',
            component: SubProduct,
            props: true
        },

        //redirects
        {
            path: '/all-tests',
            redirect: '/test'
        },
        //404 catchall
        {
            path: '/:catchAll(.*)',
            name: 'NotFound',
            component: NotFound,

        },
    ]
});
