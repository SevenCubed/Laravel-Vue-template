import axios from 'axios';
import store from './index.js';

axios.interceptors.response.use((response) => {
    return response
},
    function (error) {
        let originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            console.log('401 Interceptor online.')
            originalRequest._retry = true;
            let config = {
                headers:
                {
                    'Authorization': 'Bearer ' + store.getters['authentication/JWT'].token,
                }
            };
            return axios.post('api/auth/refresh',
                null,
                config)
                .then(response => {
                    console.log("Refresh Response:", response.status, response.data)
                    let token;
                    token = {
                        token: response.data.access_token,
                        expiry: response.data.expires_in
                    };
                    // Put Token in State
                    store.commit('authentication/LOGIN_USER', token)
                    // Reset headers
                    originalRequest.headers.Authorization = 'Bearer ' + store.getters['authentication/JWT'].token
                    // Return original object
                    return axios(originalRequest);
                });
        }
        return Promise.reject(error);
    }
);