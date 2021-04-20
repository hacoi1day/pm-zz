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
import {createUser} from '../../apis/user';
import {storeFile} from '../../apis/storage';
import UserForm from './partials/UserForm';

export default {
  name: 'user-create',
  components: {
    'user-form': UserForm
  },
  data () {
    return {
      user: {
        name: '',
        email: '',
        phone: '',
        birthday: '',
        avatar: 'https://via.placeholder.com/150',
        gender: '',
        address: '',
        password: '123456'
      },
      isEditPassword: false
    }
  },
  methods: {
    async handleSubmit () {
      await createUser(this.user);
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Thêm Nhân viên mới thành công !'
      });
      this.$router.push({name: 'user-list'});
    },
    onSelectFile () {
      this.$refs.inputAvatar.click();
    },
    async onSelectedFile (event) {
      const files = event.target.files;
      let {url} = await storeFile(files[0]);
      this.user.avatar = url;
    },
    handleOnSubmit (form) {
      console.log(form);
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