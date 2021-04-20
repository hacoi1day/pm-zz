<template>
  <b-form @submit.prevent="handleSubmit">
    <b-container fluid>
      <b-row>
        <b-col sm="6">
          <input-text
            name="name"
            label="Họ và tên"
            placeholder="Nhập họ và tên"
            :value="form.name"
            :onChange="value => form.name = value"
          />

          <input-text
            name="name"
            label="Email"
            placeholder="Nhập email"
            :value="form.email"
            :onChange="value => form.email = value"
          />

          <input-text
            name="phone"
            label="Số điện thoại"
            placeholder="Nhập số điện thoại"
            :value="form.phone"
            :onChange="value => form.phone = value"
          />

          <input-date
            name="birthday1"
            label="Ngày sinh"
            placeholder="Nhập ngày sinh"
            :value="form.birthday"
            :onChange="value => form.birthday = value"
          />

          <input-radio
            name="gender"
            label="Giới tính"
            :options="[{id: 1, text: 'Nam'}, {id: 0, text: 'Nữ'}]"
            :value="1"
            :onChange="value => form.gender = value"
          />

          <input-text
            name="name"
            label="Địa chỉ"
            placeholder="Nhập địa chỉ"
            :value="form.address"
            :onChange="value => form.address = value"
          />
          
          <b-row>
            <b-col sm="12" class="text-center mt-3">
              <b-button type="submit" variant="primary">
                {{ mode === 'create' ? 'Thêm' : 'Sửa' }} Nhân viên
              </b-button>
            </b-col>
          </b-row>

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
    
  </b-form>
</template>

<script>
import { storeFile } from '../../../apis/storage';
import InputText from '../../../components/input/InputText.vue';
import InputDate from '../../../components/input/InputDate.vue';
import InputRadio from '../../../components/input/InputRadio.vue';
export default {
  components: { InputText, InputDate, InputRadio },
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
        gender: '',
        address: '',
        password: '123456'
      }
    }
  },
  methods: {
    handleSubmit () {
      this.onSubmit(this.form);
    },
    onSelectFile () {
      this.$refs.inputAvatar.click();
    },
    async onSelectedFile (event) {
      const files = event.target.files;
      let {url} = await storeFile(files[0]);
      this.user.avatar = url;
    },
  }
}
</script>

<style>

</style>