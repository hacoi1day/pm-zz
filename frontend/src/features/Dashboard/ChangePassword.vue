<template>
  <b-card
    header="Đổi mật khẩu"
    header-tag="header"
  >
    <b-container fluid>
      <b-row>
        <b-col sm="6">
          <ValidationObserver v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Mật khẩu hiện tại"
              >
                <b-form-group
                  label="Mật khẩu hiện tại:"
                  label-for="currentPassword"
                >
                  <b-form-input
                    id="currentPassword"
                    v-model="form.currentPassword"
                    type="password"
                    placeholder="Nhập mật khẩu hiện tại"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required|min:6|max:32" 
                name="Mật khẩu mới"
              >
                <b-form-group
                  label="Mật khẩu mới:"
                  label-for="password"
                >
                  <b-form-input
                    id="password"
                    v-model="form.password"
                    type="password"
                    placeholder="Nhập mật khẩu hiện tại"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required|min:6|max:32" 
                name="Xác nhận mật khẩu"
              >
                <b-form-group
                  label="Xác nhận mật khẩu:"
                  label-for="passwordConfirm"
                >
                  <b-form-input
                    id="passwordConfirm"
                    v-model="form.passwordConfirm"
                    type="password"
                    placeholder="Xác nhận mật khẩu"
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-input>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <b-button type="submit" variant="primary">Đổi mật khẩu</b-button>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import { changePassword } from '../../apis/auth';
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  name: 'change-password',
  components: {
    ValidationObserver,
    ValidationProvider,
  },
  data () {
    return {
      form: {
        currentPassword: '',
        password: '',
        passwordConfirm: ''
      }
    }
  },
  methods: {
    async onSubmit () {
      let res = await changePassword(this.form);
      if (!res) {
        this.resetForm();
      } else {
        this.$router.push({name: 'info'});
      }
    },
    resetForm () {
      this.form.currentPassword = '';
      this.form.password = '';
      this.form.passwordConfirm = '';
    }
  },
}
</script>

<style>

</style>