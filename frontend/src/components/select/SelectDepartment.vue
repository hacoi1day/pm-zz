<template>
  <b-form-group label="Chọn phòng ban:" label-for="department_id">
    <b-form-select
      id="department_id"
      aria-placeholder="Chọn phòng ban"
      :value="value"
      @change="handleOnChange"
      :state="errors.length !== 0 ? false : null"
    >
      <b-form-select-option :value="null" disabled>Chọn phòng ban</b-form-select-option>
      <b-form-select-option 
        v-for="(item, index) in departments"
        :value="item.id"
        :key="index"
      >{{ item.name }}</b-form-select-option>
    </b-form-select>
    <b-form-invalid-feedback :state="errors ? false : true">
      {{ errors[0] }}
    </b-form-invalid-feedback>
  </b-form-group>
</template>

<script>
import { dropdownDepartment } from '../../apis/department'
export default {
  name: 'select-department',
  props: {
    value: {
      type: Number,
      default: null
    },
    onChange: Function,
    errors: Array
  },
  data () {
    return {
      departments: []
    }
  },
  created () {
    this.getDepartment();
  },
  methods: {
    async getDepartment() {
      let res = await dropdownDepartment();
      this.departments = res;
    },
    handleOnChange (value) {
      this.onChange(value);
    }
  },
  filters: {

  }
}
</script>

<style lang="scss" scoped>

</style>