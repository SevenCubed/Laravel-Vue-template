import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import Questions from "../../views/Questions.vue";
import NotFound from "../../views/NotFound.vue";
import Products from "../../views/Products.vue";
import SubProduct from "../../views/components/SubProduct.vue";
import TestingVuex from "../../views/components/TestingVuex.vue";
import AddProduct from "../../views/components/AddProduct.vue";
import UpdateProduct from "../../views/components/UpdateProduct.vue";
import Register from "../../views/Register.vue";
import Login from "../../views/Login.vue";
import Dashboard from "../../views/Dashboard.vue";



Vue.use(VueRouter);

//https://forum.vuejs.org/t/solved-delay-vue-action-until-a-state-variable-is-set/9063/5
const checkUser = (to, from, next) => {
  function proceed() {
    if (!!store.state.authentication.user) {
      console.log("User loaded, proceeding.")
      next()
    }
  }
  if (!store.state.authentication.user) {
    console.log("User not loaded, waiting and watching.")
    store.watch(
      (state) => !!state.authentication.user,
      (value) => {
        if (value === true) {
          proceed()
        }
      }
    )
  } else {
    proceed()
  }
}

const router = new VueRouter({
  routes: [
    {
      path: "/",
      name: "Home",
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
      beforeEnter(to, from, next) {
        if (!store.getters['authentication/authenticated']) {
          next()
        } else {
          console.log("Redirecting to index");
          next({
            name: "Home" //Redirect if someone is on the login path (for instance due to an unfortunate bookmark or history) to the index.
          });
        }
      }
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
      beforeEnter(to, from, next) {
        if (!store.getters['authentication/authenticated']) {
          next()
        } else {
          console.log("Redirecting to index");
          next({
            name: "Home" //As above so below
          });
        }
      }
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      component: Dashboard,
      meta: { requiresAuth: true },
      beforeEnter: checkUser,
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
      component: AddProduct,
      meta: { requiresAuth: true },
    },
    {
      //TODO: Add check if the user == the original poster.
      //I am beginning to wonder if this app has safety cracks at every possible step..
      path: "/update-product/:id",
      name: "Update Product",
      component: UpdateProduct,
      meta: { requiresAuth: true },
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