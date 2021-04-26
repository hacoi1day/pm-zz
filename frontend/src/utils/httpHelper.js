import axiosInstance from './axiosInstance';
export default {
  get (url) {
    return axiosInstance.get(url);
  },
  post (url, data) {
    return axiosInstance.post(url, data);
  },
  put (url, data) {
    return axiosInstance.put(url, data);
  },
  delete(url) {
    return axiosInstance.delete(url);
  },
  uploadFile(file) {
    let formData = new FormData();
    formData.append('file', file);
    return axiosInstance.post('storage/store-file', formData);
  }
};
