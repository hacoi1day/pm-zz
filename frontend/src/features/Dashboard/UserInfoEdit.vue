<template>
  <b-card
    header="Sửa thông tin cá nhân"
    header-tag="header"
  >
    <b-container fluid v-if="form">
      <b-row>
        <b-col sm="6">
          <ValidationObserver v-slot="{ handleSubmit }">
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Địa chỉ email"
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
                    readonly
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
                v-slot="{errors}" 
                rules="required" 
                name="Ngày sinh"
              >
                <label for="birthday">Ngày sinh</label>
                <b-form-datepicker id="birthday" v-model="form.birthday" class="mb-2"></b-form-datepicker>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}" 
                rules="required" 
                name="Giới tính"
              >
                <b-form-group label="Giới tính">
                  <b-form-radio v-model="form.gender" name="gender" :value="true">Nam</b-form-radio>
                  <b-form-radio v-model="form.gender" name="gender" :value="false">Nữ</b-form-radio>
                </b-form-group>
                <b-form-invalid-feedback :state="errors ? false : true">
                  {{ errors[0] }}
                </b-form-invalid-feedback>
              </ValidationProvider>

              <ValidationProvider 
                v-slot="{errors}"
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
                    :state="errors.length !== 0 ? false : null"
                  ></b-form-textarea>
                  <b-form-invalid-feedback :state="errors ? false : true">
                    {{ errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <b-button type="submit" variant="primary">Cập nhật</b-button>
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
  </b-card>
</template>

<script>
import { mapState } from 'vuex';
import { storeFile } from '../../apis/storage';
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { changeUserInfo } from '../../apis/auth';

export default {
  name: 'info-edit',
  components: {
    ValidationObserver,
    ValidationProvider,
  },
  computed: mapState({
    form: state => state.user.userInfo
  }),
  created () {
    console.log(this.form.gender);
    this.form.gender = this.form.gender === 1;
    console.log(this.form.gender);
  },
  data () {
    return {
      
    };
  },
  methods: {
    async onSubmit () {
      let res = await changeUserInfo(this.form);
      if (res) {
        this.$router.push({name: 'info'});
      }
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