<template>
  <div class="change-password">
    <router-link to="/auth/login">
      <font-awesome-icon class="mr-2" icon="angle-left"/>
      <span>Đăng nhập</span>
    </router-link>
    <h3 class="title">Đổi mật khẩu</h3>
    <ValidationObserver v-slot="{ handleSubmit }">
      <b-form @submit.prevent="handleSubmit(onSubmit)">
        <ValidationProvider 
          v-slot="{errors}" 
          rules="required|min:6" 
          name="Mật khẩu mới"
          vid="password"
        >
          <b-form-group
            id="input-password"
            label="Mật khẩu mới:"
            label-for="password"
          >
            <b-form-input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Nhập mật khẩu mới"
              :state="errors.length !== 0 ? false : null"
            ></b-form-input>
            <b-form-invalid-feedback :state="errors ? false : true">
              {{ errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <ValidationProvider 
          v-slot="{errors}" 
          rules="required|min:6|confirmed:password"
          name="Xác nhận mật khẩu"
        >
          <b-form-group
            id="input-passwordConfirm"
            label="Xác nhận mật khẩu:"
            label-for="passwordConfirm"
          >
            <b-form-input
              id="passwordConfirm"
              v-model="form.passwordConfirm"
              type="password"
              placeholder="Nhập xác nhận mật khẩu"
              :state="errors.length !== 0 ? false : null"
            ></b-form-input>
            <b-form-invalid-feedback :state="errors ? false : true">
              {{ errors[0] }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>

        <b-button type="submit" class="float-right" variant="primary">Đổi mật khẩu</b-button>
      </b-form>
    </ValidationObserver>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';

import { extend } from 'vee-validate';
import { confirmed } from 'vee-validate/dist/rules';
import { changePasswordWithToken, checkToken } from '../../apis/auth';

extend('confirmed', {
  ...confirmed,
  message: '{_field_} chưa chính xác'
});

export default {
  name: 'change-password-token',
  components: {
    ValidationObserver, ValidationProvider,
  },
  data () {
    return {
      form: {
        password: '',
        passwordConfirm: ''
      },
      token: ''
    }
  },
  created () {
    let { token } = this.$route.query;
    // check has token
    if (!token) {
      this.$router.push({name: 'login'});
    }
    this.token = token;
    // check token is valid
    checkToken(token).catch(() => {
      this.$notify({
        type: 'error',
        title: 'Có lỗi',
        text: 'Token không hợp lệ'
      });
      this.$router.push({name: 'login'});
    });
  },
  methods: {
    async onSubmit () {
      const res = await changePasswordWithToken(this.form, this.token);
      if (res) {
        this.$router.push({name: 'login'});
      }
    }
  }
}
</script>

<style scoped lang="scss">
.change-password {
  width: 600px;
  padding: 20px;
  border-radius: 10px;
  background-color: white;
  .title {
    text-align: center;
  }
}
</style>
