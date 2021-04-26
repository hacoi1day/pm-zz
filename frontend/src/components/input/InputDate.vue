<template>
  <b-row class="my-2">
    <b-col sm="4">
      <label :for="name">{{label}}</label>
    </b-col>
    <b-col sm="8">
      <b-form-datepicker 
        :id="name" 
        :value="value"
        :placeholder="placeholder"
        class="mb-2"
        locale="vi"
        @input="handleOnChange"
        ></b-form-datepicker>
    </b-col>
  </b-row>
</template>

<script>
import moment from 'moment';
export default {
  name: 'input-date',
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
    },
    onChange: {
      type: Function
    }
  },
  data () {
    return {
      date: ''
    };
  },
  methods: {
    handleOnChange (value) {
      this.onChange(value);
    }
  },
  filters: {
    dateFilter (date) {
      if (date) {
        return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');
      }
    }
  }
}
</script>

<style>

</style>