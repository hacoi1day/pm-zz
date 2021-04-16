<template>
  <div class="reset-password">
    <h3 class="title">Quên mật khẩu</h3>
    <b-form @submit.prevent="onResetPassword">
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
          required
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" class="float-right" variant="primary">Gửi Email</b-button>
    </b-form>
  </div>
</template>

<script>
import { me, resetPassword } from '../../apis/auth';
import { getToken } from '../../utils/token';
export default {
  name: 'reset-password',
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
      console.log(res);
      this.$Progress.finish();
    }
  }
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