<template>
  <b-card
    header="Đặt lại mật khẩu"
    header-tag="header"
  >
    <b-form-group label="Nhân viên" label-for="user_ids" description="Chọn nhân viên cần đặt lại mật khẩu">
      <multiselect id="user_ids" v-model="value" :options="options" label="name" :multiple="true" track-by="id"></multiselect>
    </b-form-group>
    <b-form-group label="Mật khẩu" label-for="password" description="Nếu không nhập mật khẩu thì mật khẩu được đặt ngẫu nhiên.">
      <b-form-input type="password" name="password" id="password" placeholder="Nhập mật khẩu" v-model="password"/>
    </b-form-group>
    
    <b-button variant="success" class="mt-2" size="sm" @click="resetPassword()">Đặt lại mật khẩu</b-button>
  </b-card>
</template>

<script>
import Multiselect from 'vue-multiselect';
import { dropdownUser, resetPasswordUser } from '../../apis/user';

export default {
  name: 'user-reset-passowrd',
  components: {
    Multiselect,
  },
  data () {
    return {
      options: [],
      value: null,
      password: ''
    };
  },
  created () {
    this.fetchDropdownUser();
  },
  methods: {
    async fetchDropdownUser () {
      let res = await dropdownUser();
      this.options = res;
    },
    async resetPassword () {

      if (!this.value) {
        this.$notify({
          type: 'error',
          title: 'Có lỗi',
          text: 'Chưa chọn Nhân viên nào !'
        });
        return false;
      }

      let userIds = this.value.map(item => item.id);
      
      // post to server
      let res = await resetPasswordUser(userIds, this.password);
      if (res) {
        this.value = null;
      }
      this.password = '';
    }
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

</style>