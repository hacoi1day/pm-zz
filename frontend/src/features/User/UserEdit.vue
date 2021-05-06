<template>
  <b-card
      header="Sửa thông tin nhân viên"
      header-tag="header"
    >
      <b-container fluid>
        <user-form
          mode="edit"
          :userId="userId"
          :onSubmit="handleSubmit"
        />
      </b-container>
    </b-card>
</template>

<script>
import { editUser } from '../../apis/user';
import UserForm from './partials/UserForm';
export default {
  name: 'user-edit',
  components: {
    'user-form': UserForm
  },
  data () {
    return {
      userId: this.$route.params.id,
    }
  },
  methods: {
    async handleSubmit (form) {
      let res = await editUser(form);
      if (res) {
        this.$notify({
          type: 'success',
          title: 'Thành công',
          text: 'Sửa Nhân viên mới thành công !'
        });
        this.$router.push({name: 'user-list'});
      }
      
    }
  }
}
</script>

<style>

</style>