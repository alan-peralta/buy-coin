import axios from 'axios'

const axiosIns = axios.create({
    baseURL: 'http://localhost:8000/api/',
    withXSRFToken: true
});

axiosIns.interceptors.request.use(
    (config) => {
        config.headers['Content-Type'] = 'application/json';
        const token = localStorage.getItem('access-token');
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);


export default axiosIns
