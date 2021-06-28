import axios from "axios";
import router from '../../router'

export default {
    namespaced: true,

    state: {
    },
    getters: {
    },
    mutations: {
    },
    actions: {
        addProduct({commit}, product) {
            console.log('DEBUG')
            console.log(product)
            console.log('DEBUG')
            axios.post('api/products/store', product)
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
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                })
            //           .then(() => { //currently doesn't care about errors, that's a problem
            //             router.push({ name: "Dashboard"})})
        },
    }
}