<template>
  <div class="auth">
    <router-view></router-view>
  </div>
</template>

<script>
import { me } from '../../apis/auth';
import { getToken } from '../../utils/token';
export default {
  name: 'auth',
  created () {
    if (getToken() !== '' && me()) {
      this.$router.push({name: 'home'});
    }
  },
}
</script>

<style lang="scss">
.auth {
  background-color: lightgrey;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>