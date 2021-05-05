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
  },
  download(url) {
    return axiosInstance.get(url, {
      responseType: 'blob'
    }).then(res => {
      let fileURL = window.URL.createObjectURL(new Blob([res.data]));
      let fileLink = document.createElement('a');

      fileLink.href = fileURL;
      fileLink.setAttribute('download', 'file.xlsx');
      document.body.appendChild(fileLink);

      fileLink.click();
    })
  }
};
