<template>
  <b-card
    header="Đổi mật khẩu"
    header-tag="header"
  >
    <b-container fluid>
        <b-row>
          <b-col md="6">
            <b-form @submit.prevent="handleSubmit">

              <b-row class="my-2">
                <b-col sm="4 d-flex align-items-center">
                  <label for="currentPassword">Mật khẩu hiện tại</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="currentPassword"
                    type="password"
                    placeholder="Mật khẩu hiện tại"
                    v-model="form.currentPassword"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="4 d-flex align-items-center">
                  <label for="password">Mật khẩu mới</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="password"
                    type="password"
                    placeholder="Mật khẩu mới"
                    v-model="form.password"
                  ></b-form-input>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="4 d-flex align-items-center">
                  <label for="passwordComfirm">Xác nhận mật khẩu</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="passwordComfirm"
                    type="password"
                    placeholder="Xác nhận mật khẩu"
                    v-model="form.passwordComfirm"
                  ></b-form-input>
                </b-col>
              </b-row>
              
              <b-row>
                <b-col sm="12" class="text-center mt-3">
                  <b-button type="submit" variant="primary">Đổi mật khẩu</b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
        </b-row>
      </b-container>
  </b-card>
</template>

<script>
export default {
  name: 'change-password',
  data () {
    return {
      form: {
        currentPassword: '',
        password: '',
        passwordComfirm: ''
      }
    }
  },
  methods: {
    handleSubmit () {
      console.log(this.form);
    }
  }
}
</script>

<style>

</style>