<template>
  <ValidationObserver v-slot="{ handleSubmit }">
    <b-form @submit.prevent="handleSubmit(onHandleSubmit)">
      <ValidationProvider 
        v-slot="{errors}" 
        rules="required" 
        name="Tên phòng ban"
      >
        <b-form-group
          label="Tên phòng ban:"
          label-for="name"
        >
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            placeholder="Nhập tên phòng ban"
            :state="errors.length !== 0 ? false : null"
          ></b-form-input>
          <b-form-invalid-feedback :state="errors ? false : true">
            {{ errors[0] }}
          </b-form-invalid-feedback>
        </b-form-group>
      </ValidationProvider>
      <SelectManager
        :value="form.manager_id"
        :onChange="handleChangeManager"
      />
      <ValidationProvider 
        name="Mô tả"
      >
        <b-form-group
          label="Mô tả:"
          label-for="description"
        >
          <b-form-textarea
            id="description"
            v-model="form.description"
            type="text"
            placeholder="Nhập mô tả"
          ></b-form-textarea>
        </b-form-group>
      </ValidationProvider>
      <b-button type="submit" variant="primary" v-if="mode === 'create'">Thêm mới</b-button>
      <b-button type="submit" variant="primary" v-if="mode === 'edit'">Cập nhật</b-button>
    </b-form>
  </ValidationObserver>
</template>

<script>
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import SelectManager from '../../../components/select/SelectManager';
import { getDepartment } from '../../../apis/department';
export default {
  name: 'department-form',
  components: {
    ValidationObserver, ValidationProvider,
    SelectManager
  },
  props: {
    mode: {
      type: String,
      default: 'create'
    },
    departmentId: {
      type: [Number, String],
      default: null
    },
    onSubmit: {
      type: Function
    }
  },
  data () {
    return {
      form: {
        id: '',
        name: '',
        description: '',
        manager_id: null
      }
    }
  },
  async created () {
    if (this.departmentId !== null) {
      let department = await getDepartment(this.departmentId);
      console.log(department);
      this.form = department;
    }
  },
  methods: {
    onHandleSubmit () {
      this.onSubmit(this.form);
    },
    handleChangeManager (manager_id) {
      this.form.manager_id = manager_id;
    }
  }
}
</script>

<style>

</style>