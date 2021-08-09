import axios from "axios";
import router from "../../router";

export default {
    namespaced: true,

    state: {},
    getters: {},
    mutations: {},
    actions: {
        addProduct({ commit }, product) {
            axios.post("api/products", product)
            console.log("Add Product request:", product)
                .catch(function (error) {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log(error.response.status, error.response.data);
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log("Error", error.message);
                    }
                    console.log(error.config)
                })
                .then((res) => { //currently doesn't care about errors, that's a problem
                    console.log(res)
                })
        },
        updateProduct({ commit }, {product, id}) {
            console.log("Update Product request:", product)
            axios
                .post(`api/products/${id}`, product) //This HAS to be POST if I'm using FormData, inside there is a _method: PUT parameter that Laravel recognizes.
                .catch(function (error) {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log(error.response.status, error.response.data);
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log("Error", error.message);
                    }
                    console.log(error.config)
                })
                .then((res) => { //currently doesn't care about errors, that's a problem
                    console.log(res)
                })
        },
    }
};
