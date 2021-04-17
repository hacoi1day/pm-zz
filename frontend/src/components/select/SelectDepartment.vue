<template>
  <b-row class="my-2">
    <b-col sm="4">
      <label for="department_id">Phòng ban</label>
    </b-col>
    <b-col sm="8">
      <b-form-select
        id="department_id"
        name="department_id"
        aria-placeholder="Chọn phòng ban"
        :value="value"
        @change="handleOnChange"
      >
        <b-form-select-option :value="null" seleted disabled>Chọn phòng ban</b-form-select-option>
        <b-form-select-option
          v-for="(item, index) in departments"
          :key="index"
          :value="item.id"
        >{{item.name}}</b-form-select-option>
      </b-form-select>
    </b-col>
  </b-row>
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
    onChange: Function
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