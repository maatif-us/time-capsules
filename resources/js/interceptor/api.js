import axios from 'axios';
import store from '@/store';

const apiRequest = axios.create({
 baseURL: '/api',
});

apiRequest.interceptors.request.use(
 (config) => {
    const token = store.getters['auth/accessToken'];
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }

    return config;
 },
 (error) => {
    return Promise.reject(error);
 }
);
export default apiRequest;
