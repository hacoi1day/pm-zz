import axios from 'axios';
import { baseUrl } from '../configs/api';
import { getToken } from './token';
import router from '../routers';

const apiUrl = `${baseUrl}/api/`;

const axiosInstance = axios.create({
  baseURL: apiUrl,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

axiosInstance.interceptors.request.use((config) => {
  let token = getToken();
  config.headers.Authorization = `Bearer ${token}`
  return config;
}, function (error) {
  return Promise.reject(error);
});

axiosInstance.interceptors.response.use((response) => {
  return response;
}, (error) => {
  let statusCode = error.response.code;
  switch (statusCode) {
    case 401:
      router.push({name: 'login'});
  }
  
  return Promise.reject(error);
});

export default axiosInstance;
