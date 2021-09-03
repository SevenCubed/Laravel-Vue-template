import axios from 'axios';
import store from './index.js';

axios.interceptors.response.use((response) => {
    return response
},
    function (error) {
        let originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            const JWT = window.$cookies.get("JWT");
            console.log('401 Interceptor online.', JWT.token)
            originalRequest._retry = true;
            let config = {
                headers:
                {
                    'Authorization': 'Bearer ' + JWT.token, 
                    //This **** header is supposed to be 'Bearer ' not 'Bearer: ' That's an hour lost on a colon, that officially makes me a programmer, right?
                }
            };
            return axios.post('api/auth/refresh',
                null,
                config)
                .then(response => {
                    console.log("Refresh Response:", response.status, response.data)
                    let JWT;
                    JWT = {
                        token: response.data.access_token,
                        expiry: response.data.expires_in
                    };
                    // Put token in cookie
                    window.$cookies.set("JWT", JWT, '14d');
                    // Put Token in State
                    store.commit('authentication/LOGIN_USER', JWT)
                    // Reset headers
                    originalRequest.headers.Authorization = 'Bearer ' + JWT.token
                    //Reset Axios headers
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + JWT.token;
                    // Return original object
                    return axios(originalRequest);
                });
        }
        // If there's a 500 on the refresh, the token has expired past it's refresh_ttl.
        if ((error.response.status === 500 && originalRequest.url.includes("api/auth/refresh")) || (error.response.status === 401 && originalRequest._retry)) {
            console.log('Tried again, failed, invalid token.', originalRequest.url)
            window.$cookies.remove("JWT")
            this.$store.commit('authentication/logoutUser') //reset the auth state
        }
        return Promise.reject(error);
    }
);