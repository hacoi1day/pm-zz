import Vue from 'vue';
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
  let {data} = response;
  if (data.message) {
    Vue.notify({
      type: 'success',
      title: 'Thành công',
      text: data.message
    });
  }
  return response;
}, (error) => {
  let res = error.response.data;
  let statusCode = error.response.code;
  switch (statusCode) {
    case 401:
      router.push({name: 'error-401'});
      break;
    case 500:
      if (res.message) {
        Vue.notify({
          type: 'error',
          title: 'Có lỗi',
          text: res.message
        });
      }
      break;
  }
  
  return Promise.reject(error);
});

export default axiosInstance;
