<template>
  <div class="login">
    <h3 class="title">Đăng nhập</h3>
    <ValidationObserver v-slot="{ handleSubmit }">
      <b-form @submit.prevent="handleSubmit(onLogin)">
        <ValidationProvider 
          v-slot="{errors}" 
          rules="email|required" 
          name="Email"
        >
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
              :state="errors.length !== 0 ? false : null"
            ></b-form-input>
            <b-form-invalid-feedback :state="errors ? false : true">
              {{ errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        
        <ValidationProvider 
          v-slot="{errors}" 
          rules="required" 
          name="Mật khẩu"
          vid="password"
        >
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
              :state="errors.length !== 0 ? false : null"
            ></b-form-input>
            <b-form-invalid-feedback :state="errors ? false : true">
              {{ errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        
        <b-button type="submit" class="float-right" variant="primary">Đăng nhập</b-button>
      </b-form>
    </ValidationObserver>
    <router-link to="/auth/reset-password">Quên mật khẩu</router-link>
  </div>
</template>

<script>
import { login, me } from '../../apis/auth';
import { getToken, setToken } from '../../utils/token';
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  name: 'login',
  components: {
    ValidationObserver, ValidationProvider,
  },
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
      if (!user) {
        this.$notify({
          type: 'error',
          title: 'Có lỗi',
          text: 'Tài khoản hoặc mật khẩu không chính xác !'
        });
        this.user.password = '';
        return false;
      }
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