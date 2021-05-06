<template>
  <div class="reset-password">
    <router-link to="/auth/login">
      <font-awesome-icon class="mr-2" icon="angle-left"/>
      <span>Đăng nhập</span>
    </router-link>
    <h3 class="title">Quên mật khẩu</h3>
    <ValidationObserver v-slot="{ handleSubmit }">
      <b-form @submit.prevent="handleSubmit(onResetPassword)">
        <ValidationProvider 
          v-slot="{errors}" 
          rules="required|email" 
          name="Email"
          vid="password"
        >
          <b-form-group
            id="input-email"
            label="Email:"
            label-for="email"
          >
            <b-form-input
              id="email"
              v-model="email"
              type="email"
              placeholder="Nhập địa chỉ email"
              :state="errors.length !== 0 ? false : null"
            ></b-form-input>
            <b-form-invalid-feedback :state="errors ? false : true">
              {{ errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <b-button type="submit" class="float-right" variant="primary">Gửi Email</b-button>
      </b-form>
    </ValidationObserver>
  </div>
</template>

<script>
import { me, resetPassword } from '../../apis/auth';
import { getToken } from '../../utils/token';
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  name: 'reset-password',
  components: {
    ValidationObserver, ValidationProvider,
  },
  data () {
    return {
      email: ''
    }
  },
  created () {
    if (getToken() !== '' && me()) {
      this.$router.push({name: 'home'});
    }
  },
  methods: {
    async onResetPassword () {
      this.$Progress.start();
      const res = await resetPassword(this.email);
      this.$Progress.finish();
      if (res) {
        this.$router.push({name: 'login'});
      }
    }
  },
  
}
</script>

<style scoped lang="scss">
.reset-password {
  width: 600px;
  padding: 20px;
  border-radius: 10px;
  background-color: white;
  .title {
    text-align: center;
  }
}
</style>