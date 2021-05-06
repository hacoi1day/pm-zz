<template>
  <b-card
    header="Đặt lại mật khẩu"
    header-tag="header"
  >
    <multiselect v-model="value" :options="options" label="name" :multiple="true" track-by="id"></multiselect>
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
      let res = await resetPasswordUser(userIds);
      if (res) {
        this.value = null;
      }
    }
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

</style>