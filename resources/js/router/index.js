import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import Questions from "../../views/Questions.vue";
import NotFound from "../../views/NotFound.vue";
import Products from "../../views/Products.vue";
import SubProduct from "../../views/components/SubProduct.vue";
import TestingVuex from "../../views/components/TestingVuex.vue";
import AddProduct from "../../views/components/AddProduct.vue";
import Register from "../../views/Register.vue";
import Login from "../../views/Login.vue";
import Dashboard from "../../views/Dashboard.vue";



Vue.use(VueRouter);


const router = new VueRouter({
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
            meta: { requiresAuth: true },
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
            path: "/add-product",
            name: "Add Product",
            component: AddProduct
        },
        {
            path: "/products",
            name: "Products",
            component: Products,
           // meta: { requiresAuth: true },
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
    ],
    
});


router.beforeEach((to, from, next) => {
    const authUser = store.getters["authentication/authenticated"];
    const reqAuth = to.matched.some((record) => record.meta.requiresAuth);
    const loginQuery = { path: "/login", query: { redirect: to.fullPath } };

    if (reqAuth && !authUser) {
          next(loginQuery);
    }
     else {
      next(); // make sure to always call next()!
    }
});

export default router;