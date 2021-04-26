<template>
  <b-container fluid>
    <b-row>
      <b-col sm="6">
        <ValidationObserver v-slot="{ handleSubmit }">
          <b-form @submit.prevent="handleSubmit(onHandleSubmit)">
            <ValidationProvider 
              v-slot="{errors}" 
              rules="required" 
              name="Họ và tên"
            >
              <b-form-group
                label="Họ và tên:"
                label-for="name"
              >
                <b-form-input
                  id="name"
                  v-model="form.name"
                  type="text"
                  placeholder="Nhập họ và tên"
                  :state="errors.length !== 0 ? false : null"
                ></b-form-input>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
            <ValidationProvider 
              v-slot="{errors}" 
              rules="required|email|unique:users,email" 
              name="Địa chỉ email"
              :debounce="500"
            >
              <b-form-group
                label="Địa chỉ email:"
                label-for="email"
              >
                <b-form-input
                  id="email"
                  v-model="form.email"
                  type="text"
                  placeholder="Nhập địa chỉ email"
                  :state="errors.length !== 0 ? false : null"
                ></b-form-input>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
            <ValidationProvider 
              v-slot="{errors}" 
              rules="required" 
              name="Số điện thoại"
            >
              <b-form-group
                label="Số điện thoại:"
                label-for="phone"
              >
                <b-form-input
                  id="phone"
                  v-model="form.phone"
                  type="text"
                  placeholder="Nhập số điện thoại"
                  :state="errors.length !== 0 ? false : null"
                ></b-form-input>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
            <ValidationProvider 
              name="Ngày sinh"
            >
              <label for="birthday">Ngày sinh</label>
              <b-form-datepicker id="birthday" v-model="form.birthday" class="mb-2"></b-form-datepicker>
            </ValidationProvider>

            <ValidationProvider 
              name="Giới tính"
            >
              <b-form-group label="Giới tính">
                <b-form-radio v-model="form.gender" name="gender" :value="true">Nam</b-form-radio>
                <b-form-radio v-model="form.gender" name="gender" :value="false">Nữ</b-form-radio>
              </b-form-group>
            </ValidationProvider>

            <ValidationProvider 
              name="Địa chỉ"
            >
              <b-form-group
                label="Địa chỉ:"
                label-for="address"
              >
                <b-form-textarea
                  id="address"
                  v-model="form.address"
                  type="text"
                  placeholder="Nhập địa chỉ"
                ></b-form-textarea>
              </b-form-group>
            </ValidationProvider>
            <b-button type="submit" variant="primary">Thêm mới</b-button>
          </b-form>
        </ValidationObserver>
      </b-col>
      <b-col sm="6">
        <div class="upload-avatar">
          <p class="mb-2">Ảnh đại diện</p>
          <img 
            class="image-preview mb-3" 
            :src="form.avatar" 
            :alt="form.avatar"
          />
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
</template>

<script>
import { storeFile } from '../../../apis/storage';
import { ValidationObserver, ValidationProvider } from 'vee-validate';

export default {
  components: { 
    ValidationObserver, ValidationProvider
  },
  name: 'user-form',
  props: {
    mode: {
      type: String,
      default: 'create'
    },
    userId: {
      type: Object,
      default: null
    },
    onSubmit: {
      type: Function
    }
  },
  created () {
    if (this.mode === 'edit' && this.userId !== null) {
      console.log(this.userId);
    }
  },
  data () {
    return {
      form: {
        id: '',
        name: '',
        email: '',
        phone: '',
        birthday: '',
        avatar: 'https://via.placeholder.com/150',
        gender: true,
        address: '',
        password: '123456'
      }
    }
  },
  methods: {
    onHandleSubmit () {
      this.onSubmit(this.form);
    },
    onSelectFile () {
      this.$refs.inputAvatar.click();
    },
    async onSelectedFile (event) {
      const files = event.target.files;
      let {url} = await storeFile(files[0]);
      this.form.avatar = url;
    },
  }
}
</script>

<style>

</style>