<template>
  <ValidationProvider 
    v-slot="{errors}" 
    :rules="rules"
    :name="label"
  >
    <b-form-group
      :label="label"
      label-for="name"
    >
      <b-form-input
        id="name"
        type="text"
        :placeholder="placeholder"
        :state="errors.length !== 0 ? false : null"
        @input="handleOnChange"
      ></b-form-input>
      <b-form-invalid-feedback :state="errors ? false : true">
        {{ errors[0] }}
      </b-form-invalid-feedback>
    </b-form-group>
  </ValidationProvider>
</template>

<script>
import { ValidationProvider } from 'vee-validate';

export default {
  name: 'input-text',
  components: {
    ValidationProvider
  },
  props: {
    name: {
      type: String,
      default: ''
    },
    rules: {
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
    },
    onChange: {
      type: Function
    }
  },
  methods: {
    handleOnChange (value) {
      console.log(value);
      this.onChange(value);
    }
  }
}
</script>

<style>

</style>