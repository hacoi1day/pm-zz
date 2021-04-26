<template>
  <div class="login">
    <h3 class="title">Đăng nhập</h3>
    <b-form @submit.prevent="onLogin">
      <b-form-group
        id="input-email"
        label="Email:"
        label-for="email"
      >
        <b-form-input
          id="email"
          v-model="user.email"
          type="email"
          placeholder="Nhập địa chỉ email"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="input-password"
        label="Mật khẩu:"
        label-for="password"
      >
        <b-form-input
          id="password"
          v-model="user.password"
          type="password"
          placeholder="Nhập mật khẩu"
          required
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" class="float-right" variant="primary">Đăng nhập</b-button>
    </b-form>
    <router-link to="/auth/reset-password">Quên mật khẩu</router-link>
  </div>
</template>

<script>
import { login, me } from '../../apis/auth';
import { getToken, setToken } from '../../utils/token';
export default {
  name: 'login',
  data () {
    return {
      user: {
        email: '',
        password: ''
      }
    };
  },
  created () {
    if (getToken() !== '' && me()) {
      this.$router.push({name: 'home'});
    }
  },
  methods: {
    async onLogin () {
      const user = await login(this.user.email, this.user.password);
      this.$store.commit('setUser', user);
      const { token } = user;
      setToken(token);
      this.$router.push({name: 'home'});
    },
  }
}
</script>

<style scoped lang="scss">
.login {
  width: 600px;
  padding: 20px;
  border-radius: 10px;
  background-color: white;
  .title {
    text-align: center;
  }
}
</style>