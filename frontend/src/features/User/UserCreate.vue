<template>
  <div>
    <b-card
      header="Thêm mới nhân viên"
      header-tag="header"
    >
      <user-form
        mode="create"
        :onSubmit="handleOnSubmit"
      />
    </b-card>
  </div>
</template>

<script>
import { createUser } from '../../apis/user';
import UserForm from './partials/UserForm';

export default {
  name: 'user-create',
  components: {
    'user-form': UserForm
  },
  data () {
    return {

    }
  },
  methods: {
    async handleOnSubmit (form) {
      await createUser(form);
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Thêm Nhân viên mới thành công !'
      });
      this.$router.push({name: 'user-list'});
    }
  }
}
</script>

<style lang="scss">
.upload-avatar {
  text-align: center;
  p {
    margin-bottom: 10px;
  }
  .image-preview {
    max-width: 150px;
    max-height: 150px;
  }
  .input-upload {
    .input-hidden {
      display: none;
    }
    button {

    }
  }
}
</style>