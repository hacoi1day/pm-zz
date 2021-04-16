import axios from 'axios';
import { baseUrl } from '../configs/api';
import { getToken } from './token';

const apiUrl = `${baseUrl}/api/`;

const request = axios.create({
  baseURL: apiUrl,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

request.interceptors.request.use((config) => {
  let token = getToken();
  config.headers.Authorization = `Bearer ${token}`
  console.log('request', config);
  return config;
}, function (error) {
  console.log('request error');
  return Promise.reject(error);
});

request.interceptors.response.use((response) => {
  console.log('response');
  return response;
}, (error) => {
  console.log('response error', error.response.data);
  return Promise.reject(error);
});

export default {
  get (url) {
    return request.get(url);
  },
  post (url, data) {
    return request.post(url, data);
  },
  put (url, data) {
    return request.put(url, data);
  },
  delete(url) {
    return request.delete(url);
  },
  uploadFile(file) {
    let formData = new FormData();
    formData.append('file', file);
    return request.post('storage/store-file', formData);
  }
}
