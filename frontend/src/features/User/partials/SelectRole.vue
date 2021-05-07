<template>
  <b-form-group label="Kiểu nhân viên:" label-for="role_id">
    <b-form-select
      id="role_id"
      aria-placeholder="Chọn kiểu nhân viên"
      :value="value"
      @change="handleOnChange"
    >
      <b-form-select-option 
        v-for="(item, index) in userRole"
        :value="item.id"
        :key="index"
      >{{ item.name }}</b-form-select-option>
    </b-form-select>
  </b-form-group>
</template>

<script>
import { USER_ROLE } from '../../../constants/user';
export default {
  name: 'select-role',
  props: {
    value: {
      type: Number,
      default: 3
    },
    onChange: Function
  },
  data () {
    return {
      userRole: USER_ROLE
    };
  },
  methods: {
    handleOnChange (value) {
      this.onChange(value);
    }
  }

}
</script>

<style>

</style>