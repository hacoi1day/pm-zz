<template>
  <vue-progress-bar></vue-progress-bar>
</template>

<script>
import axiosInstance from '../utils/axiosInstance';
export default {
  name: 'top-bar',
  created () {
    axiosInstance.interceptors.request.use((config) => {
      this.$Progress.start();
      return config;
    }, function (error) {
      this.$Progress.fail()
      return Promise.reject(error);
    });

    axiosInstance.interceptors.response.use((response) => {
      this.$Progress.finish();
      return response;
    }, (error) => {
      this.$Progress.fail()
      return Promise.reject(error);
    });
  }
}
</script>

<style>

</style>