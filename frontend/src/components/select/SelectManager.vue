<template>
  <b-form-group label="Chọn quản lý:" label-for="manager_id">
    <b-form-select
      id="manager_id"
      aria-placeholder="Chọn quản lý"
      :value="value"
      @change="handleOnChange"
    >
      <b-form-select-option :value="null">Chọn quản lý</b-form-select-option>
      <b-form-select-option 
        v-for="(item, index) in managers"
        :value="item.id"
        :key="index"
      >{{ item.name }}</b-form-select-option>
    </b-form-select>
  </b-form-group>
</template>

<script>
import { dropdownUser } from '../../apis/user'
export default {
  name: 'select-manager',
  props: {
    value: {
      type: Number,
      default: null
    },
    onChange: Function
  },
  data () {
    return {
      managers: []
    }
  },
  created () {
    this.getManager();
  },
  methods: {
    async getManager() {
      let res = await dropdownUser();
      this.managers = res;
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