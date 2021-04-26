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
              :rules="`required|email|unique:users,email,${userId}`" 
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
                <b-form-radio v-model="form.gender" name="gender" :value="1">Nam</b-form-radio>
                <b-form-radio v-model="form.gender" name="gender" :value="0">Nữ</b-form-radio>
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
            <b-button type="submit" variant="primary" v-if="mode === 'create'">Thêm mới</b-button>
            <b-button type="submit" variant="primary" v-if="mode === 'edit'">Cập nhật</b-button>
          </b-form>
        </ValidationObserver>
      </b-col>
      <b-col sm="6">
        <avatar
          :value="form.avatar"
          :onChange="handleChangeAvatar"
        />
        <select-department
          :value="form.department_id"
          :onChange="handleChangeDepartment"
        />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import SelectDepartment from '../../../components/select/SelectDepartment.vue';
import Avatar from '../../../components/Avatar.vue';
import { getUser } from '../../../apis/user';

export default {
  name: 'user-form',
  components: { 
    ValidationObserver, ValidationProvider,
    SelectDepartment,
    Avatar
  },
  props: {
    mode: {
      type: String,
      default: 'create'
    },
    userId: {
      type: [Number, String],
      default: null
    },
    onSubmit: {
      type: Function
    }
  },
  async created () {
    if (this.userId !== null) {
      let user = await getUser(this.userId);
      this.form = user;
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
        password: '123456',
        department_id: null
      }
    }
  },
  methods: {
    onHandleSubmit () {
      this.onSubmit(this.form);
    },
    handleChangeDepartment (department_id) {
      if (department_id) {
        this.form.department_id = department_id;
      }
    },
    handleChangeAvatar (avatar) {
      this.form.avatar = avatar;
    }
  }
}
</script>

<style>

</style>