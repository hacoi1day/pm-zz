<template>
  <b-card
    header="Không có quyền truy cập !!!"
    header-tag="header"
  >
    <h2 class="text-401 text-center">401</h2>
    <h4 class="text-center">Không có quyền truy cập !!!</h4>
    <div class="text-center">
      <b-button variant="success" @click="goHome()">Trang chủ</b-button>
    </div>
  </b-card>
</template>

<script>
export default {
  name: 'error-401',
  methods: {
    goHome() {
      this.$router.push({name: 'home'});
    }
  }
}
</script>

<style>
.text-401 {
  font-size: 80px;
  font-weight: bold;
  margin: 20px;
}
</style>