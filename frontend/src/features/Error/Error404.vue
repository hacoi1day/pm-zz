<template>
  <b-card
    header="Trang không tồn tại !!!"
    header-tag="header"
  >
  <h2 class="text-404 text-center">404</h2>
    <h4 class="text-center">Trang không tồn tại !!!</h4>
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
.text-404 {
  font-size: 80px;
  font-weight: bold;
  margin: 20px;
}
</style>