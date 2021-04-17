<template>
  <b-card
    header="Sửa thông tin cá nhân"
    header-tag="header"
  >
    <b-container fluid>
        <b-row>
          <b-col md="6">
            <b-form @submit.prevent="handleSubmit">
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="name">Họ và tên</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="name"
                    type="text"
                    placeholder="Nhập Họ và tên"
                    v-model="user.name"
                  ></b-form-input>
                </b-col>
              </b-row>
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="email">Địa chỉ Email</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="email"
                    type="email"
                    placeholder="Nhập địa chỉ email"
                    v-model="user.email"
                    disabled
                  ></b-form-input>
                </b-col>
              </b-row>
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="phone">Số điện thoại</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="phone"
                    type="text"
                    placeholder="Nhập địa chỉ số điện thoại"
                    v-model="user.phone"
                  ></b-form-input>
                </b-col>
              </b-row>
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="birthday">Ngày sinh</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="birthday"
                    type="date"
                    placeholder="Nhập địa ngày sinh"
                    v-model="user.birthday"
                  ></b-form-input>
                </b-col>
              </b-row>
              <b-row class="my-2">
                <b-col sm="4">
                  <label for="gender">Giới tính</label>
                </b-col>
                <b-col sm="4" class="d-flex">
                  <b-form-radio name="gender" value="1" v-model="user.gender" class="mr-3">Nam</b-form-radio>
                  <b-form-radio name="gender" value="0" v-model="user.gender">Nữ</b-form-radio>
                </b-col>
              </b-row>

              <b-row class="my-2">
                <b-col sm="4">
                  <label for="address">Địa chỉ</label>
                </b-col>
                <b-col sm="8">
                  <b-form-input
                    id="address"
                    type="text"
                    placeholder="Nhập địa địa chỉ"
                    v-model="user.address"
                  ></b-form-input>
                </b-col>
              </b-row>
              <select-department :value="user.department_id" :onChange="handleChangeDepartment"/>
              <b-row>
                <b-col sm="12" class="text-center mt-3">
                  <b-button type="submit" variant="primary">Sửa thông tin</b-button>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
          <b-col md="6">
            <div class="upload-avatar">
              <p class="mb-2">Ảnh đại diện</p>
              <img class="image-preview mb-3" :src="user.avatar" :alt="user.avatar">
              <div class="input-upload">
                <input 
                  type="file" 
                  name="input-avatar" 
                  class="input-hidden"
                  ref="inputAvatar"
                  accept="image/*"
                  @change="onSelectedFile"
                >
                <b-button variant="success" @click="onSelectFile">Tải lên</b-button>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-container>
  </b-card>
</template>

<script>
import { mapState } from 'vuex';
import { storeFile } from '../../apis/storage';
import { editUser } from '../../apis/user';
import SelectDepartment from '../../components/select/SelectDepartment';

export default {
  name: 'user-info-edit',
  components: {
    'select-department': SelectDepartment
  },
  computed: mapState({
    user: state => state.user.userInfo
  }),
  data () {
    return {
      
    };
  },
  methods: {
    async handleSubmit () {
      await editUser(this.user);
      this.$notify({
        type: 'success',
        title: 'Thành công',
        text: 'Sửa thông tin thành công !'
      });
      this.$router.push({name: 'user-info'});
    },
    onSelectFile () {
      this.$refs.inputAvatar.click();
    },
    async onSelectedFile (event) {
      const files = event.target.files;
      let {url} = await storeFile(files[0]);
      this.user.avatar = url;
    },
    handleChangeDepartment (departmentId) {
      this.user.department_id = departmentId;
    }
  }
}
</script>

<style>

</style>