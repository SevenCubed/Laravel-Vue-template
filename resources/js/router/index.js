import Vue from "vue";
import VueRouter from "vue-router";
import Test from "../../views/Test.vue";
import Questions from "../../views/Questions.vue";
import NotFound from "../../views/NotFound.vue";
import SubTest from "../../views/components/SubTest.vue";
import TestingVuex from "../../views/components/TestingVuex.vue";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/"
        },
        {
            path: "/test",
            name: "About",
            component: Test
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
            path: "/test/:id",
            name: 'TestDetails',
            component: SubTest,
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
