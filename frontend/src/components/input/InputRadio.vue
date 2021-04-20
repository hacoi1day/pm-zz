<template>
  <b-row class="my-2">
    <b-col sm="4">
      <label for="gender">{{label}}</label>
    </b-col>
    <b-col sm="4" class="d-flex">

    <b-form-radio 
      :name="name" 
      v-for="(item, index) in options" 
      :key="index" 
      :value="item.id" 
      class="mr-3"
      @change="handleChange(item.id)"
    >{{ item.text }}</b-form-radio>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'input-radio',
  props: {
    name: {
      type: String
    },
    label: {
      type: String
    },
    options: {
      type: Array,
    },
    onChange: {
      type: Function
    }
  },
  methods: {
    handleChange (value) {
      this.onChange(value);
    }
  }
}
</script>

<style>

</style>