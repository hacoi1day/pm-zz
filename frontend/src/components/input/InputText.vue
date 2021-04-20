<template>
  <b-row class="my-2">
    <b-col sm="4">
      <label :for="name">{{label}}</label>
    </b-col>
    <b-col sm="8">
      <b-form-input
        type="text"
        :id="name"
        :placeholder="placeholder"
        v-model="value"
      ></b-form-input>
    </b-col>
  </b-row>
</template>

<script>
export default {
  name: 'input-text',
  props: {
    name: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      default: ''
    }
  }
}
</script>

<style>

</style>